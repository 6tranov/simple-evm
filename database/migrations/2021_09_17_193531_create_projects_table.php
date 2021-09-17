<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('name');
            $table->date('start_scheduled_on');
            $table->date('complete_scheduled_on');
            $table->date('started_on')->nullable($value=true);
            $table->date('completed_on')->nullable($value=true);
            $table->unsignedBigInteger('user_id');
            Schema::enableForeignKeyConstraints();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('projects');
    }
}
