<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public static function searchUsers($for,$query){
        switch ($for) {
            case 'id':
                return \DB::table('users')->where('id',$query)->get();
                break;
            case 'name':
                return \DB::table('users')->where('name','like',"%${query}%")->get();
                break;
            case 'bio':
                return \DB::table('users')->where('biography','like',"%${query}%")->get();
                break;
            default:
                return [];
                break;
        }
    }
}
