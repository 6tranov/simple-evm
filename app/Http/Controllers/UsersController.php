<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UsersController extends Controller
{
    //
    public function showProfile(){
        $user = Auth::user();
        return view('User.show_profile')->with(['user'=>$user]);
    }
    public static function searchUsers(Request $request){
        $for = $request->input('for');
        $query = $request->input('query');
        
        $users = User::searchUsers($for,$query);
        
        return view('User.search_users')->with(['users'=>$users,'for'=>$for,'query'=>$query]);
    }
}
