<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $name;
    public $value;
    public $checked;

    public function __construct($name, $value, $checked)
    {
        $this->name = $name;
        $this->value = $value;
        $this->checked = $checked;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form.checkbox');
    }
}
