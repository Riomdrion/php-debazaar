<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdvertentiesGrid extends Component
{
    public $items;
    public $routeName;
    public $type;

    public function __construct($items, $routeName, $type)
    {
        $this->items = $items;
        $this->routeName = $routeName;
        $this->type = $type;
    }

    public function render()
    {
        return view('components.advertenties-grid');
    }
}
