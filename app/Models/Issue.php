<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Issue extends Model
{
    protected $fillable = [
        'task_id', 'member_id', 'statement'
    ];

    public static function get_issues($task_id)
    {
        return DB::table('issues')
            ->join('class__members', function ($join) use ($task_id) {
                $join->on('issues.member_id', '=', 'class__members.id')
                    ->where('task_id', $task_id);
            })
            ->join('users', function ($join) {
                $join->on('class__members.user_id', '=', 'users.id');
            })
            ->select('users.name', 'users.student_number', 'class__members.is_teacher', 'issues.statement', 'issues.created_at')
            ->orderByDesc('issues.created_at')
            ->paginate(10);
    }

    public static function post_issue($task_id, $member_id, $statement)
    {
        Issue::create([
            'task_id'   => $task_id,
            'member_id' => $member_id,
            'statement' => $statement
        ]);
    }
}
