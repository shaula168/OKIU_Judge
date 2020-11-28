<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSubmissions extends Migration
{
    public function up()
    {
        Schema::table('submissions', function (Blueprint $table) {
            // 現在の問題におけるユーザの現在までの提出数
            $table->integer('submit_cnt');
        });
    }

    public function down()
    {
        //
    }
}
