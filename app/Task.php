<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    //
    public static function getTasksByProjectId($project_id){
        $tasks = DB::table('tasks')->where('project_id',$project_id)->get();
        return $tasks;
    }
}
