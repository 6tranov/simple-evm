<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('source_user_id');
            $table->unsignedBigInteger('destination_user_id');
            $table->unique(['source_user_id','destination_user_id']);
            Schema::enableForeignKeyConstraints();
            $table->foreign('source_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('destination_user_id')->references('id')->on('users')->onDelete('cascade');
            Schema::disableForeignKeyConstraints();
            
            $table->timestamps();
        });
        
        DB::statement('alter table follow_requests add constraint dontSendRequestOneself check(source_user_id != destination_user_id)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follow_requests');
    }
}
