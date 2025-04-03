<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ComponentBuilder extends Component
{
    public $index, $type, $data, $order;

    public function __construct($index, $type = null, $data = [], $order = 0)
    {
        $this->index = $index;
        $this->type = $type;
        $this->data = $data;
        $this->order = $order;
    }

    public function render()
    {
        return view('components.component-builder');
    }
}
