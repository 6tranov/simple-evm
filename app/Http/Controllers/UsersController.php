<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Follow;

class UsersController extends Controller
{
    //
    public function showProfile(){
        $user = Auth::user();
        return view('User.show_profile')->with(['user'=>$user]);
    }
    public function searchUsers(Request $request){
        $for = $request->input('for');
        $query = $request->input('query');
        
        $users = User::searchUsers($for,$query);
        
        return view('User.search_users')->with(['users'=>$users,'for'=>$for,'query'=>$query]);
    }
    public function showOthersProfile(User $user){
        if($user->id == Auth::user()->id) return redirect("/profile");
        
        //$isFollowing = Follow::isFollowing(Auth::user()->id,$user->id);
        $relationship = Follow::getRelationship(Auth::user()->id,$user->id);
        return view('User.show_others_profile')->with(['user'=>$user,'relationship'=>$relationship]);//'isFollowing'=>$isFollowing,]);
    }
}
