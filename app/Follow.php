<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    //$idのユーザーがフォローしているユーザー一覧を取得する。
    public static function getFollowingUsersById($id){
        //select follows.followed_id as id, users.name as name from users join follows on users.id = follows.followed_id where follows.following_id = $id;
        
        return \DB::table('users')->join('follows','users.id','=','follows.followed_id')
        ->where('follows.following_id',$id)->selectRaw("follows.followed_id as id,users.name as name")->get();
    }
    public static function getFollowersById($id){
        //select follows.following_id as id, users.name as name from users join follows on users.id = follows.following_id where follows.followed_id = 21;  
        return \DB::table('users')->join('follows','users.id','=','follows.following_id')
        ->where('follows.followed_id',$id)->selectRaw("follows.following_id as id,users.name as name")->get();
    }
    public static function storeFollow($folloingId,$followedId){
        \DB::table('follows')->save([
                'following_id'=>$followingId,
                'followed_id'=>$followedId,
            ]);
    }
    public static function deleteFollow($folloingId,$followedId){
        \DB::table('follows')->where([
            'following_id'=>$followingId,
            'followed_id'=>$followedId,
            ])->delete();
    }
}
