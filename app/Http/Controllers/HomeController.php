<?php

namespace App\Http\Controllers;

use App\Services\RssFeed;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(RssFeed $feed)
    {
        return view('home')
            ->with('feed', $feed->getItems());
    }
}
