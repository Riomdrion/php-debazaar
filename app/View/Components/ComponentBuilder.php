<?php
// app/View/Components/ComponentBuilder.php

namespace App\View\Components;

use Illuminate\View\Component;

class ComponentBuilder extends Component
{
    public $index;
    public $type;
    public $data;
    public $order;

    public function __construct($index = 0, $type = null, $data = '[]', $order = 0)
    {
        $this->index = $index;
        $this->type = $type;
        $this->order = $order;

        // Correcte parsing
        if (is_array($data)) {
            $this->data = $data;
        } elseif (is_string($data)) {
            $decoded = json_decode($data, true);
            $this->data = is_array($decoded) ? $decoded : [];
        } else {
            $this->data = [];
        }
    }

    public function render()
    {
        return view('components.component-builder');
    }
}

