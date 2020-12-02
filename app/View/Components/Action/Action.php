<?php

namespace App\View\Components\Action;

use Illuminate\View\Component;

class Action extends Component
{
    public $action;
    public $id;

    public function __construct($action = 'get', $id = null)
    {
        $this->action = $action;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.action.action');
    }
}
