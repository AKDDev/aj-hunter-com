<?php

namespace App\View\Components\Action;

use Illuminate\View\Component;

class Button extends Component
{
    public $title;

    public function __construct($title = 'Actions')
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.action.button');
    }
}
