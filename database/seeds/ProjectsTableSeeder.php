<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // 初期化
        DB::table('projects')->delete();
        
        //一番初めのユーザーidを取得
        $users = DB::table('users')->get();
        $user_id = $users[0]->id;
        
        // テストデータ挿入
        DB::table('projects')->insert(
            [
                'name' => 'project1',
                'start_scheduled_on' => '2021-1-1',
                'complete_scheduled_on' => '2021-2-1',
                'user_id' => $user_id
            ]
            );
    }
}
