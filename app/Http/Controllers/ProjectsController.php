<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Task;
use App\Http\Requests\StoreProjectRequest; 
use App\Http\Requests\EditProjectRequest;


class ProjectsController extends Controller
{
    //
    protected $fillable = [
    'name',
    'start_scheduled_on',
    'complete_scheduled_on',
    'user_name',
    ];
    
    public function index(Project $project){
        return view('Project.index')->with(['projects' => $project->getPaginateByLimit(10)]);
    }
    
    public function show(Project $project){
        //タスクをすべて取得する。
        $tasks = Task::getTasksByProjectId($project->id);
        return view('Project.show')->with(['project' => $project,'tasks'=>$tasks]);
    }
    
    public function create(){
        return view('Project.create');
    }
    public function store(StoreProjectRequest $request,Project $project){
        $project->saveFromInput($request['project']);
        return redirect('/projects/' . $project->id);
    }
    
    public function edit(Project $project){
        $tasks = Task::getTasksByProjectId($project->id);
        return view('Project.edit')->with(['tasks'=>$tasks,'project'=>$project]);
    }
    public function update(EditProjectRequest $request,Project $project){
        $project->updateName($request['project']['name']);
        return redirect('/projects/' . $project->id);
    }
}
