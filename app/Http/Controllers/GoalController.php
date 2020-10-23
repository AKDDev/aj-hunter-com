<?php

namespace App\Http\Controllers;

use App\Http\Requests\Goals\DeleteRequest;
use App\Http\Requests\Goals\StoreRequest;
use App\Http\Requests\Goals\UpdateRequest;
use App\Models\Goal;
use App\Models\Project;
use App\Models\Status;
use App\Models\Type;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::with(['status'])
            ->get();

        $view = view('goals.index');

        if($goals->count() == 0) {
            $view->with('message','There are no goals at this time.');
        }

        return $view->with('goals',$goals);
    }

    public function create()
    {
        $projects = Project::active()->get();
        $statuses = Status::get();
        $types = Type::get();

        return view('goals.create')
            ->with('projects',$projects)
            ->with('types',$types)
            ->with('statuses',$statuses);
    }

    public function store(StoreRequest $request)
    {
        Goal::create([
            'goal' => $request->get('goal'),
            'project_id' => $request->get('project_id'),
            'status_id' => $request->get('status_id'),
            'total' => $request->get('total'),
            'type_id' => $request->get('type_id'),
            'start' => $request->get('start'),
            'end' => $request->get('end',null),
        ]);
        session()->flash('success', 'Created new goal successfully.');
        return redirect()->route('goals.list');
    }

    public function show(Goal $goal)
    {
        return view('goals.show')
            ->with('goal',$goal->load(['status','project','type']));
    }

    public function edit(Goal $goal)
    {
        $projects = Project::active()->get();
        $statuses = Status::get();
        $types = Type::get();

        return view('goals.edit')
            ->with('goal',$goal)
            ->with('projects',$projects)
            ->with('types',$types)
            ->with('statuses',$statuses);
    }

    public function update(UpdateRequest $request, Goal $goal)
    {
        $goal->goal = $request->get('goal');
        $goal->project_id = $request->get('project_id');
        $goal->status_id = $request->get('status_id');
        $goal->total = $request->get('total');
        $goal->type_id = $request->get('type_id');
        $goal->start = $request->get('start');
        $goal->end = $request->get('end',null);

        $goal->save();

        session()->flash('success', 'Updated goal successfully.');
        return redirect()->route('goals.list');
    }

    public function destroy(DeleteRequest $request, Goal $goal)
    {
        $goal->delete();

        session()->flash('success', 'Deleted goal successfully.');
        return redirect()->route('goals.list');
    }
}
