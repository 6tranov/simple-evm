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
            $table->date('due_on');
            $table->date('done_on')->nullable($value=true);
            $table->unsignedInteger('planned_value');
            $table->unsignedInteger('earned_value')->nullable($value=true);
            $table->unsignedInteger('actual_cost')->nullable($value=true);
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('previous_task_id')->nullable();
            $table->string('name');
            Schema::enableForeignKeyConstraints();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('previous_task_id')->references('id')->on('tasks')->onDelete('cascade');
            Schema::disableForeignKeyConstraints();
            
            $table->timestamps();
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
