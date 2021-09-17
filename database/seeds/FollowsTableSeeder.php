<?php

use Illuminate\Database\Seeder;

class FollowsTableSeeder extends Seeder
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
        DB::table('follows')->delete();
        
        //二人のユーザーのidを取得
        $users = DB::table('users')->get();
        foreach($users as $user){
            $user_id[] = $user->id;
        }
        
        // テストデータ挿入
        DB::table('follows')->insert(
            [
                'following_id' => $user_id[0],
                'followed_id' => $user_id[1],
            ]
            );
    }
}
