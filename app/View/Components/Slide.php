<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Slide extends Component
{
    public $slide;

    public function __construct($slide)
    {
        $this->slide = $slide;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.carousel.slide');
    }
}
