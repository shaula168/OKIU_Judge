<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('member_id');
            $table->string('code_txt', 8500);
            $table->string('stdout', 2500)->nullable();
            $table->string('cmpinfo', 2500)->nullable();
            $table->string('stderr', 2500)->nullable();
            $table->tinyInteger('result')->default(0);  // 0:waiting 1:correct -1:incorrect
            $table->boolean('is_first_correct')->default(false);
            $table->timestamps();

            $table->index('id');
            $table->index('task_id');
            $table->index('member_id');
            $table->index('is_first_correct');

            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('member_id')
                ->references('id')
                ->on('class__members')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submissions');
    }
}
