<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Errors extends Component
{
    public $errors;
    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.form.errors');
    }
}
