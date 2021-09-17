<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
        DB::table('users')->delete();
        
        // テストデータ挿入
        DB::table('users')->insert(
            [
                'name' => 'user1',
                'email' => 'user1@example.com',
                'password' => Hash::make('password'),
                'biography' => 'hello'
            ]
            );
            
        DB::table('users')->insert(
            [
                'name' => 'user2',
                'email' => 'user2@example.com',
                'password' => Hash::make('password'),
                'biography' => 'hello'
            ]
            );
    }
}
