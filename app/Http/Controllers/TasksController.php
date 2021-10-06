<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Task;
use App\Project;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTaskOrdersRequest;

class TasksController extends Controller
{
    //
    public function edit(Task $task){
        $project = $task->getProject();
        return view('Task.edit')->with(['task'=>$task,'project'=>$project]);
    }
    public function update(UpdateTaskRequest $request,Task $task){
        $input = $request['task'];
        $task->updateTask($input);
        
        return redirect('/projects/' . $task->project_id);
    }
    public function updateOrders(UpdateTaskOrdersRequest $request,Project $project){
        Task::updateOrders($request);
        
        return redirect('/projects/' . $project->id);
    }
    public function editOrders(Project $project){
        $tasksArray = Task::getOrderedTasksArrayByProjectId($project->id);
        return view('Task.edit_orders')->with(['tasksArray'=>$tasksArray,'project'=>$project]);
    }
}
