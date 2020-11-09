<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $options;
    public $selected;

    public function __construct($name, $options, $selected)
    {
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form.select');
    }
}
