<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Task;
use App\Project;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\UpdateTaskOrdersRequest;
use APp\Http\Requests\StoreTaskRequest;

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
        $idArray = $request['id'];
        Task::updateOrders($idArray,$project->id);
        
        return redirect('/projects/' . $project->id);
    }
    public function editOrders(Project $project){
        $tasksArray = Task::getOrderedTasksArrayByProjectId($project->id);
        return view('Task.edit_orders')->with(['tasksArray'=>$tasksArray,'project'=>$project]);
    }
    public function store(StoreTaskRequest $request){
        $input = $request['task'];
        $task = new Task();
        $task->fill(input);
        $task->save();
        
        return $task->toArray();
    }
}
