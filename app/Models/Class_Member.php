<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Class_Member extends Model
{
    protected $fillable = [
        'class_id', 'user_id', 'is_teacher'
    ];

    // 教師ユーザーか
    public static function is_teacher($class_id)
    {
        $is_teacher = DB::table('class__members')
            ->select('is_teacher')
            ->where([
                ['class_id', $class_id],
                ['user_id', auth()->user()->id]
            ])->first()->is_teacher;

        if (is_null($is_teacher)) abort('403');

        return $is_teacher;
    }

    // 対象クラスにおけるログインユーザーのメンバーを返す
    public static function get_member($class_id)
    {
        $member = DB::table('class__members')
            ->where([
                ['class_id', $class_id],
                ['user_id', auth()->user()->id]
            ])->first();
        
        if (is_null($member)) abort('403');
        
        return $member;
    }

    // 対象 id のメンバーが対象クラスに存在する場合はそのメンバーを返す
    public static function get_member_idsearch($id, $class_id)
    {
        $member = DB::table('class__members')
            ->where([
                ['id', $id],
                ['class_id', $class_id]
            ])->first();
        
        if (is_null($member)) abort('403');
        
        return $member;
    }
}
