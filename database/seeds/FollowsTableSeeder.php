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
        
        //すべてのユーザーのidを取得
        $users = DB::table('users')->get();
        foreach($users as $user){
            $user_id[] = $user->id;
        }
        
        //すべてのユーザーが互いにフォローをする
        //自分で自分をフォローしないようにする。
        foreach ($user_id as $following_id) {
            foreach ($user_id as $followed_id) {
                if($following_id != $followed_id){
                    DB::table('follows')->insert(
                    [
                        'following_id' => $following_id,
                        'followed_id' => $followed_id,
                    ]
                    );
                }
            }
        }
        
    }
}
