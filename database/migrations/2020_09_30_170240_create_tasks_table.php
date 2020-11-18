<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('class_id');
            $table->string('title', 50);
            $table->string('statement', 800);
            $table->string('hint', 800)->nullable();
            $table->string('input', 2500)->nullable();
            $table->string('output', 2500);
            $table->unsignedBigInteger('model_answer')->nullable();
            $table->date('deadline')->nullable();
            $table->timestamps();

            $table->index('id');
            $table->index('class_id');

            $table->foreign('class_id')
                ->references('id')
                ->on('classrooms')
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
        Schema::dropIfExists('tasks');
    }
}
