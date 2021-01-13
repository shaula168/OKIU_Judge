<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Classroom;
use App\Models\Class_Member;
use App\Models\Submission;
use App\Models\Issue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    // 問題を新規作成画面
    public function create($class_id)
    {
        $classroom = Classroom::findOrFail($class_id);

        // 教師ユーザーか
        $is_teacher = Class_Member::is_teacher($class_id);
        if (!$is_teacher) {
            abort('403');
        }

        return view('tasks.create', [
            'classroom' => $classroom
        ]);
    }

    // 問題の新規登録処理
    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id'  => ['required', 'integer'],
            'title'     => ['required', 'string', 'max:50'],
            'statement' => ['required', 'string', 'max:800'],
            'hint'      => ['nullable', 'string', 'max:800'],
            'code_tmp'  => ['nullable', 'string', 'max:5000'],
            'input'     => ['nullable', 'string', 'max:2500'],
            'output'    => ['required', 'string', 'max:2500'],
            'deadline'  => ['nullable', 'date']
        ]);

        $classroom = Classroom::findOrFail($data['class_id']);

        // 教師ユーザーか
        $is_teacher = Class_Member::is_teacher($classroom->id);
        if (!$is_teacher) {
            abort('403');
        }

        Task::storeTask($data);
        return redirect('classrooms/' . $classroom->id);
    }

    // 問題の詳細画面
    public function show($class_id, $task_id)
    {
        $classroom = Classroom::findOrFail($class_id);
        $task = Task::select('id', 'title', 'statement', 'hint', 'model_answer', 'code_tmp', 'deadline')
            ->where([['id', $task_id], ['class_id', $class_id]])
            ->firstOrFail();

        // 教師ユーザーか
        $is_teacher = Class_Member::is_teacher($classroom->id);

        return view('tasks.show', [
            'classroom'  => $classroom,
            'task'       => $task,
            'is_teacher' => $is_teacher
        ]);
    }

    // 問題編集画面
    public function edit($class_id, $task_id)
    {
        $classroom = Classroom::findOrFail($class_id);
        $task = Task::where([['id', $task_id], ['class_id', $class_id]])
            ->firstOrFail();
        
        // 教師ユーザーか
        $is_teacher = Class_Member::is_teacher($classroom->id);
        if (!$is_teacher) {
            abort('403');
        }
        
        return view('tasks.edit', [
            'classroom' => $classroom,
            'task'      => $task
        ]);
    }

    // 問題更新処理
    public function update(Request $request, $task_id)
    {
        $data = $request->validate([
            'class_id'  => ['required', 'integer'],
            'title'     => ['required', 'string', 'max:50'],
            'statement' => ['required', 'string', 'max:800'],
            'hint'      => ['nullable', 'string', 'max:800'],
            'code_tmp'  => ['nullable', 'string', 'max:5000'],
            'input'     => ['nullable', 'string', 'max:2500'],
            'output'    => ['required', 'string', 'max:2500'],
            'deadline'  => ['nullable', 'date']
        ]);

        $classroom = Classroom::findOrFail($data['class_id']);
        $task = Task::findOrFail($task_id);

        // 教師ユーザーか
        $is_teacher = Class_Member::is_teacher($classroom->id);
        if (!$is_teacher || $classroom->id != $task->class_id) {
            abort('403');
        }

        Task::updateTask($task->id, $data);

        return redirect('classrooms/' . $classroom->id . '/tasks/' . $task->id);
    }

    // コードの投稿処理
    public function submit($class_id, $task_id, Request $request)
    {
        $classroom = Classroom::findOrFail($class_id);
        $task = Task::select('id', 'input', 'output')
            ->where([['id', $task_id], ['class_id', $class_id]])
            ->firstOrFail();
        
        $data = $request->validate([
            'code'  => ['required', 'string', 'max:5000']
        ]);
        $data['input'] = $task->input;
        $data['output'] = $task->output;

        $member = Class_Member::get_member($classroom->id);

        Submission::storeSubmission($task->id, $member, $data);

        return redirect('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/submissions');
    }

    // 質問ページ表示
    public function issues($class_id, $task_id)
    {
        $classroom = Classroom::findOrFail($class_id);
        $task = Task::get_task($task_id, $class_id);
        $member = Class_Member::get_member($classroom->id);

        $issues = Issue::get_issues($task->id);

        return view('tasks.issues', [
            'classroom' => $classroom,
            'task' => $task,
            'member' => $member,
            'issues' => $issues
        ]);
    }

    // 質問投稿処理
    public function post_issue($class_id, $task_id, Request $request)
    {
        $data = $request->validate([
            'new_statement' => ['required', 'string', 'max:800']
        ]);

        $classroom = Classroom::findOrFail($class_id);
        $task = Task::get_task($task_id, $class_id);
        $member = Class_Member::get_member($classroom->id);

        Issue::post_issue($task->id, $member->id, $data['new_statement']);

        return redirect('classrooms/' . $classroom->id . '/tasks/' . $task->id . '/issues');
    }

    // 投稿リスト表示
    public function submissions($class_id, $task_id, Request $request)
    {
        $classroom = Classroom::findOrFail($class_id);
        $task = Task::get_task($task_id, $class_id);
        $member = Class_Member::get_member($classroom->id);
        $is_teacher = $member->is_teacher;

        if ($member->is_teacher && !is_null($request['member_id'])) {
            $member_id = $request->validate([
                'member_id' => ['nullable', 'integer']
            ]);

            $member = Class_Member::get_member_idsearch($member_id, $class_id);
        }

        $submissions = Submission::get_submit_list($task, $member);

        return view('tasks.submissions', [
            'classroom'   => $classroom,
            'is_teacher'  => $is_teacher,
            'task'        => $task,
            'submissions' => $submissions
        ]);
    }

    /**
     * 投稿詳細表示
     * [投稿ユーザ] または [教師ユーザ] なら表示
     * それ以外は403
     */
    public function show_submit($class_id, $task_id, $submit_id)
    {
        $classroom = Classroom::findOrFail($class_id);
        $task = Task::get_task($task_id, $class_id);
        $submit = Submission::where([['id', $submit_id], ['task_id', $task->id]])
            ->firstOrFail();
        $member = Class_Member::get_member($classroom->id);
        $is_teacher = $member->is_teacher;

        if($submit->member_id != $member->id && !($member->is_teacher)) {
            abort('403');
        }

        return view('tasks.show_submit', [
            'classroom'  => $classroom,
            'is_teacher' => $is_teacher,
            'task'       => $task,
            'submit'     => $submit
        ]);
    }

    /**
     * 模範解答表示
     * [締め切り後] または [正解している] または [教師ユーザ] なら表示
     * それ以外または模範解答が設定されていなければ問題トップに戻りエラー表示
     */
    public function answer($class_id, $task_id)
    {
        $classroom = Classroom::findOrFail($class_id);
        $task = Task::select('id', 'title', 'model_answer', 'deadline')
            ->where([['id', $task_id], ['class_id', $class_id]])
            ->firstOrFail();
        $member = Class_Member::get_member($classroom->id);
        $is_teacher = $member->is_teacher;

        $deadline = new Carbon($task->deadline);
        $deadline = new Carbon($deadline->addDay());   // 締め切り日も期限内に含める処置
        $is_correct_task = Submission::where([
            ['task_id', $task->id],
            ['member_id', $member->id],
            ['result', 1]
        ])->count() > 0 ? true : false;

        if ($deadline->isPast() || $is_correct_task || $member->is_teacher) {
            $submission = Submission::find($task->model_answer);
            if (is_null($submission)) {
                return redirect('classrooms/' . $classroom->id . '/tasks/' . $task->id)
                    ->with('status', '模範解答は設定されていません。');
            }

            return view('tasks.answer', [
                'classroom'  => $classroom,
                'is_teacher' => $is_teacher,
                'task'       => $task,
                'submission' => $submission
            ]);
        }
        
        return redirect('classrooms/' . $classroom->id . '/tasks/' . $task->id)
                ->with('status', '問題に正解すると模範解答が閲覧できます。');
    }

    /**
     * 順位表表示
     */
    public function standings($class_id, $task_id)
    {
        $classroom = Classroom::findOrFail($class_id);
        $task = Task::select('id', 'title', 'deadline')
            ->where([['id', $task_id], ['class_id', $class_id]])
            ->firstOrFail();
        $member = Class_Member::get_member($classroom->id);
        $is_teacher = $member->is_teacher;

        $standings = Submission::get_standings($task->id, $member->id);
        $my_standing = Submission::get_my_standing($task->id, $member->id);

        //////////////////////////////////
        return view('tasks.standings', [
            'classroom'   => $classroom,
            'is_teacher'  => $is_teacher,
            'task'        => $task,
            'standings'   => $standings,
            'my_standing' => $my_standing
        ]);
    }

    /**
     * 提出状況一覧
     * 教師ユーザのみ閲覧可
     * 名前、学籍番号、提出期限内に正解したか or 提出期限後に正解したか or 正解してないか
     */
    public function status_lists($class_id, $task_id)
    {
        $classroom = Classroom::findOrFail($class_id);
        $task = Task::where([['id', $task_id], ['class_id', $class_id]])
            ->firstOrFail();
        
        // 教師ユーザーか
        $is_teacher = Class_Member::is_teacher($classroom->id);
        if (!$is_teacher) {
            abort('403');
        }

        $status_lists = Submission::get_status_lists($classroom->id, $task->id);

        $deadline = null;
        if (!is_null($task->deadline)) {
            $deadline = new Carbon($task->deadline);
            $deadline = new Carbon($deadline->addDay());   // 締め切り日も期限内に含める処置
        }

        for ($i = 0; $i < count($status_lists); $i++) {
            $submit_day = new Carbon($status_lists[$i]->created_at);

            if (is_null($deadline) || $submit_day->lt($deadline)) {
                $status_lists[$i]->is_pass = true;
            } else {
                $status_lists[$i]->is_pass = false;
            }
        }

        return view('tasks.status_lists', [
            'classroom'    => $classroom,
            'task'         => $task,
            'is_teacher'   => $is_teacher,
            'status_lists' => $status_lists
        ]);
    }
}
