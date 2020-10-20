<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

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
}
