<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Http\Requests\Types\DeleteRequest;
use App\Http\Requests\Types\StoreRequest;
use App\Http\Requests\Types\UpdateRequest;

class TypeController extends Controller
{
     public function index()
    {
        $types = Type::get();

        $view = view('type.list');

        if($types->count() == 0) {
            $view->with('message','There are no types at this time.');
        }

        return $view->with('types', $types);
    }

    public function create()
    {
        return view('type.create');
    }

    public function store(StoreRequest $request)
    {
        Type::create([
            'type' => $request->get('type'),
        ]);
        session()->flash('success', 'Created new type successfully.');
        return redirect()->route('types.list');
    }

    public function show(Type $type)
    {
        return view('type.show')
            ->with('type',$type);
    }

    public function edit(Type $type)
    {
        return view('type.edit')
            ->with('type',$type);
    }

    public function update(UpdateRequest $request, Type $type)
    {
        $type->type = $request->get('type');

        $type->save();

        session()->flash('success', 'Updated type successfully.');
        return redirect()->route('types.list');
    }

    public function destroy(DeleteRequest $request, Type $type)
    {
        $type->delete();

        session()->flash('success', 'Deleted type successfully.');
        return redirect()->route('types.list');
    }
}
