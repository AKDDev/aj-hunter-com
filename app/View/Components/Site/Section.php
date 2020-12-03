<?php

namespace App\View\Components\Site;

use Illuminate\View\Component;

class Section extends Component
{
    public $image;
    public $name;
    public function __construct($image, $name)
    {
        $this->image = $image;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.site.section');
    }
}
