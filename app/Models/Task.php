<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'class_id', 'title', 'statement', 'hint', 'code_tmp',
        'input', 'output', 'model_answer', 'deadline'
    ];

    public static function get_task($task_id, $class_id)
    {
        return Task::select('id', 'title')
            ->where([['id', $task_id], ['class_id', $class_id]])
            ->firstOrFail();
    }

    // 新規作成
    public static function storeTask($data)
    {
        $code_tmp = null;
        if(!is_null($data['code_tmp'])) {
            $code_tmp = json_encode($data['code_tmp'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
            $code_tmp = substr($code_tmp, 1, -1);
        }

        Task::create([
            'class_id'  => $data['class_id'],
            'title'     => $data['title'],
            'statement' => $data['statement'],
            'hint'      => $data['hint'],
            'code_tmp'  => $code_tmp,
            'input'     => Submission::convertEOL(rtrim($data['input'])),
            'output'    => Submission::convertEOL(rtrim($data['output'])),
            'deadline'  => $data['deadline']
        ]);
    }

    // 更新処理
    public static function updateTask($task_id, $data)
    {
        $code_tmp = null;
        if(!is_null($data['code_tmp'])) {
            $code_tmp = json_encode($data['code_tmp'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
            $code_tmp = substr($code_tmp, 1, -1);
        }

        Task::findOrFail($task_id)
            ->update([
                'title'     => $data['title'],
                'statement' => $data['statement'],
                'hint'      => $data['hint'],
                'code_tmp'  => $code_tmp,
                'input'     => Submission::convertEOL(rtrim($data['input'])),
                'output'    => Submission::convertEOL(rtrim($data['output'])),
                'deadline'  => $data['deadline']
            ]);
    }

    public static function setModelAnswer($task_id, $submission_id)
    {
        $task = Task::findOrFail($task_id);
        $task->model_answer = $submission_id;
        $task->save();
    }
}
