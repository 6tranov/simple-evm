<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{
    //
    public function edit(Task $task){
        $project = $task->getProject();
        return view('Task.edit')->with(['task'=>$task,'project'=>$project]);
    }
    public function update(){
        
    }
}
