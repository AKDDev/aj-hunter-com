<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $goals = Goal::active()
            ->with(['count','type','project'])
            ->get();
        return view('home')
            ->with('goals',$goals);
    }
}
