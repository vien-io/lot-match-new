<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableSearch extends Component
{
    public function __construct(
        public string $action,
        public string $placeholder = 'Search...',
        public string $ariaLabel = 'Search',
    ) {}

    public function render()
    {
        return view('components.table-search');
    }
}