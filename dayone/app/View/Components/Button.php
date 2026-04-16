<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $type;
    public $size;
    public $buttonType;

    public function __construct($type = 'primary', $size = 'md', $buttonType = 'button')
    {
        $this->type = $type;
        $this->size = $size;
        $this->buttonType = $buttonType;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
