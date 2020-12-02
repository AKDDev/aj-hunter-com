<?php

namespace App\Http\Controllers;

use App\Http\Requests\Count\DeleteRequest;
use App\Http\Requests\Count\StoreRequest;
use App\Models\Count;
use App\Models\Goal;
use App\Models\Type;
use Illuminate\Http\Request;

class CountController extends Controller
{
    public function create()
    {
        $goals = Goal::active()->get();

        return view('count.create')
            ->with('goals',$goals);
    }

    public function store(StoreRequest $request)
    {
        Count::create([
            'goal_id' => $request->get('goal_id'),
            'value' => $request->get('value'),
            'when' => $request->get('when'),
            'comment' => $request->get('comment'),
        ]);

        session()->flash('success', 'Created new count successfully.');
        return back();
    }

    public function destroy(DeleteRequest $request, Count $count)
    {
        $count->delete();

        session()->flash('success', 'Deleted count successfully.');
        return back();
    }
}
