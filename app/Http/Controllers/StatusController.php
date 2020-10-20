<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use App\Http\Requests\Status\DeleteRequest;
use App\Http\Requests\Status\StoreRequest;
use App\Http\Requests\Status\UpdateRequest;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::get();

        $view = view('status.list');

        if($statuses->count() == 0) {
            $view->with('message','There are no statuses at this time.');
        }

        return $view->with('statuses', $statuses);
    }

    public function create()
    {
        return view('status.create');
    }

    public function store(StoreRequest $request)
    {
        Status::create([
            'status' => $request->get('status'),
        ]);
        session()->flash('success', 'Created new status successfully.');
        return redirect()->route('statuses.list');
    }

    public function show(Status $status)
    {
        return view('statuses.show')
            ->with('status',$status);
    }

    public function edit(Status $status)
    {
        return view('statuses.edit')
            ->with('status',$status);
    }

    public function update(UpdateRequest $request, Status $status)
    {
        $status->status = $request->get('status');

        $status->save();

        session()->flash('success', 'Updated status successfully.');
        return redirect()->route('statuses.list');
    }

    public function destroy(DeleteRequest $request, Status $status)
    {
        $status->delete();

        session()->flash('success', 'Deleted status successfully.');
        return redirect()->route('statuses.list');
    }
}
