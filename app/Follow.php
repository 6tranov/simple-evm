<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = ['id','following_id','followed_id','is_authenticated'];
    //$idのユーザーがフォローしているユーザー一覧を取得する。
    public static function getFollowingUsersById($id){
        //select follows.followed_id as id, users.name as name from users join follows on users.id = follows.followed_id where follows.following_id = $id;
        
        return \DB::table('users')->join('follows','users.id','=','follows.followed_id')
        ->where('follows.following_id',$id)
        ->where('follows.is_authenticated',true)
        ->selectRaw("follows.followed_id as id,users.name as name")->get();
    }
    public static function getFollowersById($id){
        //select follows.following_id as id, users.name as name from users join follows on users.id = follows.following_id where follows.followed_id = 21;  
        return \DB::table('users')->join('follows','users.id','=','follows.following_id')
        ->where('follows.followed_id',$id)
        ->where('follows.is_authenticated',true)
        ->selectRaw("follows.following_id as id,users.name as name")->get();
    }
    public static function storeFollow($followingId,$followedId){
        $follows = new Follow();
        $follows->fill([
                'following_id'=>$followingId,
                'followed_id'=>$followedId,
                'is_authenticated' => true,
            ]);
        $follows->save();
    }
    public static function deleteFollow($followingId,$followedId){
        \DB::table('follows')->where([
            'following_id'=>$followingId,
            'followed_id'=>$followedId,
            ])->delete();
    }
    public static function isFollowing($followingId,$followedId){
        $user = \DB::table('follows')->where([
            'following_id'=>$followingId,
            'followed_id'=>$followedId,
            'is_authenticated' => true,
            ])->first();
        return !is_null($user);
    }
    private static function checkFailed(&$exception):bool{
        /*
        
        */
    }
    public static function apply($following_id,$followed_id){
        $follows = new Follow();
        $follows->fill([
                'following_id'=>$following_id,
                'followed_id'=>$followed_id,
                'is_authenticated' => false,
            ]);
        $follows->save();
    }
    public static function cancellApplication($following_id,$followed_id){
        \DB::table('follows')->where([
            'following_id'=>$following_id,
            'followed_id'=>$followed_id,
            ])->delete();
    }
    public static function getRelationship($following_id,$followed_id){
        $user = \DB::table('users')->join('follows','users.id','=','follows.followed_id')
        ->where('follows.followed_id',$followed_id)
        ->where('follows.following_id',$following_id)
        ->first();
        
        if(is_null($user))return '';
        
        switch ($user->is_authenticated) {
            case true:
                $result = 'following';
                break;
            case false:
                $result = 'applying';
                break;
            default:
                $result = '';
                // code...
                break;
        }
        
        return $result;
    }
    public static function approve($followed_id,$following_id){
        $follows_id = \DB::table('users')->join('follows','users.id','=','follows.followed_id')
        ->where('follows.followed_id',$followed_id)
        ->where('follows.following_id',$following_id)
        ->first()->id;
        
        $follows = Follow::find($follows_id);
        
        $follows->fill([
                'id'=>$follows_id,
                'is_authenticated' => true,
            ]);
        $follows->save();
    }
    public static function getApplicantsById($id){
        return \DB::table('users')->join('follows','users.id','=','follows.following_id')
        ->where('follows.followed_id',$id)
        ->where('follows.is_authenticated',false)
        ->selectRaw("follows.following_id as id,users.name as name")->get();
    }
    public static function getApplicationsById($id){
        return \DB::table('users')->join('follows','users.id','=','follows.followed_id')
        ->where('follows.following_id',$id)
        ->where('follows.is_authenticated',false)
        ->selectRaw("follows.followed_id as id,users.name as name")->get();
    }
}
