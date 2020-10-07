<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Blog extends Component
{
    public $feed;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($feed)
    {
        $this->feed = $feed;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.blog');
    }
}
