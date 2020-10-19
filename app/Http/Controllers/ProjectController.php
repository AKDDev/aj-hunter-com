<?php

namespace App\Http\Controllers;

use App\Http\Requests\Projects\StoreRequest;
use App\Models\Project;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Requests\Projects\UpdateRequest;
use App\Http\Requests\Projects\DeleteRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['status'])
            ->get();

        $view = view('projects.index');

        if($projects->count() == 0) {
            $view->with('message','There are no projects at this time.');
        }

        return $view->with('projects',$projects);
    }

    public function create()
    {
        $statuses = Status::get();

        return view('projects.create')
            ->with('statuses',$statuses);
    }

    public function store(StoreRequest $request)
    {
        Project::create([
            'project' => $request->get('name'),
            'active' => $request->get('active'),
            'status_id' => $request->get('status'),
        ]);
        session()->flash('success', 'Created new project successfully.');
        return redirect()->route('projects.list');
    }

    public function show(Project $project)
    {
        return view('projects.show')
            ->with('project',$project->load(['status']));
    }

    public function edit(Project $project)
    {
        $statuses = Status::get();

        return view('projects.edit')
            ->with('project',$project)
            ->with('statuses',$statuses);
    }

    public function update(UpdateRequest $request, Project $project)
    {
        $project->project = $request->get('name');
        $project->status_id = $request->get('status');
        $project->active = $request->get('active');

        $project->save();

        session()->flash('success', 'Updated project successfully.');
        return redirect()->route('projects.list');
    }

    public function destroy(DeleteRequest $request, Project $project)
    {
        $project->delete();

        session()->flash('success', 'Deleted project successfully.');
        return redirect()->route('projects.list');
    }
}
