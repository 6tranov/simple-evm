<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;


class ProjectsController extends Controller
{
    //
    public function index(Project $project){
        return view('index')->with(['projects' => $project->getPaginateByLimit(2)]);
    }
}
