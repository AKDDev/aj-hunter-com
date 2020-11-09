<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $type;
    public $value;

    public function __construct($name, $type = 'text', $value = '')
    {
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form.input');
    }
}
