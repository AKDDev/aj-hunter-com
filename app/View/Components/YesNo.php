<?php

namespace App\View\Components;

use Illuminate\View\Component;

class YesNo extends Component
{
    public $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.yes-no');
    }
}
