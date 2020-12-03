<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Carousel extends Component
{
    public $slides;

    public function __construct($slides)
    {
        $this->slides = $slides;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.carousel.carousel');
    }
}
