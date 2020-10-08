<?php

namespace App\Http\Controllers;

use App\Http\Requests\Projects\StoreRequest;
use App\Models\Project;
use App\Models\Status;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['status'])
            ->get();

        return view('projects.index')
            ->with('projects',$projects);
    }

    public function create()
    {
        $statuses = Status::get();

        return view('projects.create')
            ->with('statuses',$statuses);
    }

    public function store(StoreRequest $request)
    {

    }
}
