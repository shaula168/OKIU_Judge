<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Class_Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassroomsController extends Controller
{
    // クラスを新規作成画面
    public function create()
    {
        return view('classrooms.create');
    }

    // クラスの新規登録処理
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:50']
        ]);

        Classroom::storeClassroom($data);
        
        return redirect('home');
    }

    // クラスの詳細画面
    public function show($id)
    {
        $classroom = Classroom::findOrFail($id);

        // 問題一覧
        $tasks = DB::table('tasks')
            ->leftJoin('submissions as A', function ($join) use ($classroom) {
                $join->on('tasks.id', '=', 'A.task_id')
                    ->where([
                        ['tasks.class_id', $classroom->id],
                        ['A.is_first_correct', true]
                    ])
                    ->selectRaw('A.id, A.task_id, A.member_id, A.submit_cnt');
            })
            ->where('tasks.class_id', $classroom->id)
            ->groupBy('tasks.id', 'A.task_id')
            ->selectRaw('tasks.id, tasks.title, tasks.deadline,
                         count(A.task_id) as correct_cnt, avg(A.submit_cnt) as submit_avg')
            ->get();

        // 生徒一覧
        $members = DB::table('class__members')
            ->join('users', function ($join) use ($classroom) {
                $join->on('class__members.user_id', '=', 'users.id')
                    ->where('class__members.class_id', $classroom->id);
            })
            ->select('class__members.id', 'users.name', 'users.student_number')
            ->orderByDesc('class__members.created_at')
            ->get();
        
        // 教師ユーザーか
        $is_teacher = Class_Member::is_teacher($classroom->id);

        return view('classrooms.show', [
            'classroom'  => $classroom,
            'tasks'      => $tasks,
            'members'    => $members,
            'is_teacher' => $is_teacher
        ]);
    }

    // クラスの編集画面
    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);

        // 教師ユーザーか
        $is_teacher = Class_Member::is_teacher($classroom->id);
        if (!$is_teacher) {
            abort('403');
        }

        return view('classrooms.edit', [
            'classroom' => $classroom
        ]);
    }

    // クラスの編集を更新する処理
    public function update(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);

        // 教師ユーザーか
        $is_teacher = Class_Member::is_teacher($classroom->id);
        if (!$is_teacher) {
            abort('403');
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:50']
        ]);

        $classroom->updateClassroom($data);

        return redirect('classrooms/' . $id);
    }

    // クラスに参加画面
    public function join_classroom()
    {
        return view('classrooms.join_classroom');
    }
    
    // クラスに参加する処理
    public function register_classroom(Request $request)
    {
        $data = $request->validate([
            'class_code' => ['required', 'string', 'size:8']
        ]);
        $user_id = auth()->user()->id;

        // クラスの存在チェック
        $classroom = Classroom::where('classroom_code', $data['class_code'])->first();
        if (empty($classroom)) {
            return back()->with('status', 'エラー！入力値を確認してください！');
        }

        // 重複チェック
        $is_student = Class_Member::where([['class_id', $classroom->id], ['user_id', $user_id]])->exists();      
        if ($is_student) {
            return back()->with('status', 'エラー！ 登録済みです！');
        }

        Class_Member::create([
            'class_id'   => $classroom->id,
            'user_id'    => $user_id
        ]);

        return redirect('home');
    }
}
