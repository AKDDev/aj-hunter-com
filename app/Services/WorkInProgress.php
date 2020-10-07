<?php
namespace App\Services;

use \File;

class WorkInProgress
{
    protected $projects;

    public function __construct()
    {
        $file = File::get(storage_path('data/work-in-progress.json'));

        $this->projects = collect(json_decode($file));
    }

    public function getCurrentProjects()
    {
        return $this->projects->filter(function($item) {
            return $item->active;
        });
    }
}
