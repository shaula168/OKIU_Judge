<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Submission extends Model
{
    protected $fillable = [
        'task_id', 'member_id', 'code_txt', 'code_txt', 'cmpinfo',
        'stderr', 'result', 'is_first_correct', 'submit_cnt'
    ];

    // 改行コードを変更する
    public static function convertEOL($string, $to = "\n")
    {   
        return preg_replace("/\r\n|\r|\n/", $to, $string);
    }

    // サンドボックスサーバーにpost、結果を返す
    public static function postSandboxServer($code, $input)
    {
        $header = array(
            "Content-type: application/json; charset-utf-8"
        );

        $post_data = array('run_spec' => array(
            'parameters' => array('cputime' => 2),
            'language_id' => 'java',
            'sourcefilename' => 'Main.java',
            'sourcecode' => $code,
            'input' => $input
        ));
        $post_data = json_encode($post_data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "jobe/jobe/index.php/restapi/runs");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $result =  curl_exec($ch);
        $result = mb_convert_encoding($result,"UTF-8","EUC-JP");
        curl_close($ch);
        $result = json_decode($result);

        return $result;
    }

    // 投稿処理
    public static function storeSubmission($task_id, $member, Array $data)
    {
        $code = json_encode($data['code'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $code = substr($code, 1, -1);

        $submit_cnt = DB::table('submissions')
            ->where([
                ['task_id', $task_id],
                ['member_id', $member->id]
            ])
            ->selectRaw('max(submit_cnt) as submit_cnt')
            ->value('submit_cnt');

        if (is_null($submit_cnt))
            $submit_cnt = 0;

        // Submission を登録
        $submit = Submission::create([
            'task_id'    => $task_id,
            'member_id'  => $member->id,
            'code_txt'   => $code,
            'submit_cnt' => $submit_cnt + 1
        ]);

        // Task に模範解答として登録
        if ($member->is_teacher) {
            Task::setModelAnswer($task_id, $submit->id);
        }

        // サンドボックスサーバーにpost, 結果を受け取る
        $response = Submission::postSandboxServer($data['code'], $data['input']);

        // ジャッジして submit を update
        $judge = -1;
        if (strcmp($data['output'], rtrim($response->stdout)) == 0)
            $judge = 1;
        
        // 初正解なら is_first_correct を更新
        if (Submission::is_first_correct($task_id, $member->id) && $judge == 1)
            $submit->is_first_correct = true;

        $submit->stdout = rtrim($response->stdout);
        $submit->cmpinfo = $response->cmpinfo;
        $submit->stderr = $response->stderr;
        $submit->result = $judge;
        $submit->update();
    }

    public static function is_first_correct($task_id, $member_id)
    {
        $is_first_correct = Submission::where([
            ['task_id', $task_id],
            ['member_id', $member_id],
            ['is_first_correct', 1]
        ])->doesntExist();

        return $is_first_correct;
    }

    public static function get_submit_list($task, $member)
    {
        $submissions = null;

        if ($member->is_teacher) {
            $submissions = DB::table('submissions')
                ->join('class__members', function ($join) use ($task) {
                    $join->on('submissions.member_id', '=', 'class__members.id')
                        ->where('submissions.task_id', $task->id);
                })
                ->join('users', function ($join) {
                    $join->on('class__members.user_id', '=', 'users.id');
                })
                ->select('users.name', 'users.student_number', 'class__members.id as member_id', 'submissions.id', 'submissions.result', 'submissions.created_at')
                ->orderByDesc('submissions.created_at')
                ->paginate(10);
        } else {
            $submissions = DB::table('submissions')
                ->join('class__members', function ($join) use ($task) {
                    $join->on('submissions.member_id', '=', 'class__members.id')
                        ->where('submissions.task_id', $task->id);
                })
                ->join('users', function ($join) use ($member) {
                    $join->on('class__members.user_id', '=', 'users.id')
                        ->where('class__members.id', $member->id);
                })
                ->select('users.name', 'users.student_number', 'class__members.id as member_id', 'submissions.id', 'submissions.result', 'submissions.created_at')
                ->orderByDesc('submissions.created_at')
                ->paginate(10);
        }

        return $submissions;
    }

    /**
     * 最速正解者トップ3を返す
     */
    public static function get_standings($task_id, $member_id)
    {
        $standings = DB::table('submissions')
            ->join('class__members', function ($join) use ($task_id) {
                $join->on('submissions.member_id', '=', 'class__members.id')
                    ->where([
                        ['submissions.task_id', $task_id],
                        ['submissions.is_first_correct', true],
                        ['class__members.is_teacher', false]
                    ]);
            })
            ->join('users', function ($join) {
                $join->on('class__members.user_id', '=', 'users.id');
            })
            ->select('users.name', 'users.student_number', 'submissions.created_at')
            ->orderByDesc('submissions.created_at')
            ->limit(3)
            ->get();

        return $standings;
    }

    /**
     * 自分の順位を返す
     */
    public static function get_my_standing($task_id, $member_id)
    {
        $my_fc_date = DB::table('submissions')
            ->join('class__members', function ($join) use ($task_id, $member_id) {
                $join->on('submissions.member_id', '=', 'class__members.id')
                    ->where([
                        ['submissions.member_id', $member_id],
                        ['submissions.task_id', $task_id],
                        ['submissions.is_first_correct', true],
                        ['class__members.is_teacher', false]
                    ]);
            })->value('submissions.created_at');

        $my_standing = 0;

        if (!is_null($my_fc_date)) {
            $my_standing = DB::table('submissions')
                ->join('class__members', function ($join) use ($task_id, $my_fc_date) {
                    $join->on('submissions.member_id', '=', 'class__members.id')
                        ->where([
                            ['submissions.task_id', $task_id],
                            ['submissions.is_first_correct', true],
                            ['class__members.is_teacher', false],
                            ['submissions.created_at', '<', $my_fc_date]
                        ]);
                })->count() + 1;
        } else {
            $my_standing = DB::table('submissions')
                ->join('class__members', function ($join) use ($task_id) {
                    $join->on('submissions.member_id', '=', 'class__members.id')
                        ->where([
                            ['submissions.task_id', $task_id],
                            ['submissions.is_first_correct', true],
                            ['class__members.is_teacher', false]
                        ]);
                })->count() + 1;
        }

        return $my_standing;
    }

    /**
     * 提出状況一覧を返す
     */
    public static function get_status_lists($class_id, $task_id)
    {
        $status_lists = DB::table('class__members')
            ->join('submissions', function ($join) use ($class_id, $task_id) {
                $join->on('class__members.id', '=', 'submissions.member_id')
                    ->where([
                        ['class__members.class_id', $class_id],
                        ['class__members.is_teacher', false],
                        ['submissions.task_id', $task_id],
                        ['submissions.is_first_correct', true]
                    ]);
            })
            ->join('users', function ($join) {
                $join->on('class__members.user_id', '=', 'users.id');
            })
            ->select('class__members.id', 'users.name', 'users.student_number', 'submissions.created_at')
            ->orderByDesc('users.student_number')
            ->get();
        
        return $status_lists;
    }
}
