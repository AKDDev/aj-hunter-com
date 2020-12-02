<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Goal as Model;

class Goal extends Component
{
    public $goal;

    public function __construct(Model $goal)
    {
        $this->goal = $goal;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.goal');
    }
}
