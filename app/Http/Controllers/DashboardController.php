<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $goals = Goal::active()
            ->with(['count','type','project'])
            ->get();
        $types = Type::get();
        $projects = Project::active()
            ->with('status')
            ->get();

        return view('dashboard')
            ->with('projects',$projects)
            ->with('goals',$goals)
            ->with('types',$types);
    }
}
