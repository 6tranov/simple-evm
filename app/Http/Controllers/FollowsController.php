<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Follow;
use App\User;
use App\Http\Requests\StoreFollowRequest;
use App\Http\Requests\DeleteFollowRequest;

class FollowsController extends Controller
{
    //
    public function followsIndex(){
        $id = Auth::user()->id;
        $followingUsers = Follow::getFollowingUsersById($id);
        
        return view("Follow.follows_index")->with(['followingUsers'=>$followingUsers]);
    }
    public function followersIndex(){
        $id = Auth::user()->id;
        $followers = Follow::getFollowersById($id);
        
        return view("Follow.followers_index")->with(['followers'=>$followers]);
    }
    public function store(StoreFollowRequest $request){
        //フォローするユーザーのID
        $followingId = Auth::user()->id;
        
        //フォローされるユーザーのID
        $followedId = $request['followed_id'];
        
        //フォロー関係を登録
        Follow::storeFollow($followingId,$followedId);
        
        //フォローしたユーザーのプロフィールページにリダイレクト
        return redirect("/users/${followedId}/profile");
    }
    public function delete(DeleteFollowRequest $request){
        //フォローするユーザーのID
        $followingId = Auth::user()->id;
        
        //フォローされるユーザーのID
        $followedId = $request['followed_id'];
        
        //フォロー関係を解除
        Follow::deleteFollow($followingId,$followedId);
        
        //フォロー解除したユーザーのプロフィールページリダイレクト
        return redirect("/users/${followedId}/profile");
    }
    public function othersFollowsIndex(User $user){
        $followingUsers = Follow::getFollowingUsersById($user->id);
        
        return view("Follow.others_follows_index")->with(["user"=>$user,"followingUsers"=>$followingUsers,]);
    }
    public function othersFollowersIndex(User $user){
        $followers = Follow::getFollowersById($user->id);
        
        return view("Follow.others_followers_index")->with(["user"=>$user,"followers"=>$followers]);
    }
}
