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
        
        // プロジェクトのレコードを3つ挿入
        DB::table('projects')->insert(
            [
                'name' => 'project1',
                'user_id' => $user_id
            ]
        );
        
        DB::table('projects')->insert(
            [
                'name' => 'project2',
                'user_id' => $user_id
            ]
        );
        
        DB::table('projects')->insert(
            [
                'name' => 'project3',
                'user_id' => $user_id
            ]
        );
    }
}
