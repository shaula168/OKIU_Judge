<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'title', 'classroom_code'
    ];

    // 新規作成
    public static function storeClassroom($data)
    {
        $user_id = auth()->user()->id;

        // ランダムな文字列を生成して返す
        function random_str($length = 8)
        {
            return substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
        }
        
        $code = random_str();
        while(true) {
            $count = Classroom::where('classroom_code', $code)->count();
            if ($count <= 0) break;
            $code = random_str();
        }

        $classroom = Classroom::create([
            'title'          => $data['title'],
            'classroom_code' => $code
        ]);

        Class_Member::create([
            'class_id'   => $classroom->id,
            'user_id'    => $user_id,
            'is_teacher' => true
        ]);
    }

    // 更新
    public function updateClassroom($data)
    {
        $this->update([
            'title' => $data['title']
        ]);
    }
}
