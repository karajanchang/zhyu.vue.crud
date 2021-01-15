<?php

namespace ZhyuVueCurd\Http\Livewire\Admin;

use Livewire\Component;

class TableIndex extends Component
{
    private $tableService;

    public function render()
    {
        $view = 'livewire.admin.table-index';

        return view()->first([$view, 'vendor.'.$view, 'ZhyuVueCurd::'.$view], [
            'tableService' => $this->tableService
        ]);
    }
}
