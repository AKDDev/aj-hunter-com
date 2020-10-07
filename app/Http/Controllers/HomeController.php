<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $date1 = now()->toDateTimeString();
        $date2 = now()->subDay()->ToDateTimeString();
        $date3 = now()->subDays(2)->ToDateTimeString();

        $feed = [
            ['title' => 'Blog 1', 'body' => 'This is test data', 'date' => $date1],
            ['title' => 'Blog 2', 'body' => 'This is test data 2', 'date' => $date2],
            ['title' => 'Blog 3', 'body' => 'This is test data 3', 'date' => $date3],
        ];

        return view('home')
            ->with('feed', $feed);
    }
}
