<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Task;
use App\Http\Requests\UpdateTaskRequest;

class TasksController extends Controller
{
    //
    public function edit(Task $task){
        $project = $task->getProject();
        return view('Task.edit')->with(['task'=>$task,'project'=>$project]);
    }
    public function update(UpdateTaskRequest $request,Task $task){
        $input = $request['task'];
        $task->fill($input)->save();
        
        return redirect('/projects/' . $task->project_id);
    }
}
