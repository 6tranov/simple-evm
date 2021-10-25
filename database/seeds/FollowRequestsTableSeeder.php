<?php

use Illuminate\Database\Seeder;

class FollowRequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        // 初期化
        DB::table('follow_requests')->delete();
        
        //特に何もしない。
    }
}
