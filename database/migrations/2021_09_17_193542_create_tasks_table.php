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
            //$table->date('due_on');
            //$table->date('done_on')->nullable($value=true);
            $table->date('start_scheduled_on');
            $table->date('complete_scheduled_on');
            $table->date('started_on')->nullable($value=true);
            $table->date('completed_on')->nullable($value=true);
            $table->unsignedInteger('planned_value');
            $table->unsignedInteger('earned_value');
            $table->unsignedInteger('actual_cost');
            $table->unsignedBigInteger('project_id');
            //$table->unsignedBigInteger('previous_task_id')->nullable();
            $table->unsignedInteger('order_index');
            $table->string('name');
            Schema::enableForeignKeyConstraints();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            //$table->foreign('previous_task_id')->references('id')->on('tasks')->onDelete('cascade');
            Schema::disableForeignKeyConstraints();
            
            $table->timestamps();
        });
        
        DB::statement('alter table tasks add constraint nameLength check(char_length(name)>=1)');
        DB::statement('alter table tasks add constraint scheduleDateOrder check(start_scheduled_on <= complete_scheduled_on)');
        DB::statement('alter table tasks add constraint DateOrder check(started_on <= completed_on)');
        DB::statement('alter table tasks add constraint pvValue check(planned_value >= 1)');
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
