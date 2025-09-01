<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarIcon extends Component
{
    public $href;
    public $icon;
    public $tooltip;
    public $active;
    
    public function __construct($href, $icon, $tooltip, $active = '')
    {
        $this->href = $href;
        $this->icon = $icon;
        $this->tooltip = $tooltip;
        $this->active = $active;
    }

    public function render(): View|Closure|string
    {
        return view('components.sidebar-icon');
    }
}
