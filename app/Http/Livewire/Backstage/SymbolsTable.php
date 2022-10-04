<?php

namespace App\Http\Livewire\Backstage;

use App\Models\Campaign;
use App\Models\SymbolId;
use Livewire\Component;

class SymbolsTable extends TableComponent
{
    public $sortField = 'name';

    public function render()
    {
        $columns = [
            [
                'title' => 'name',
                'sort' => true,
            ],
            [
                'title' => 'image',
                'sort' => false,
            ],
            [
                'title' => 'Matching Point 3',
                'sort' => true,
            ],
            [
                'title' => 'Matching Point 4',
                'sort' => true,
            ],
            [
                'title' => 'Matching Point 5',
                'sort' => true,
            ],
            [
                'title' => 'status',
                'sort' => false,
            ],
        ];

//        $columns[] = [
//            'title' => 'tools',
//            'sort' => false,
//            'tools' => ['use', 'edit', 'delete'],
//        ];

        return view('livewire.backstage.symbols-table', [
            'columns' => $columns,
            'resource' => 'Symbols',
            'rows' => SymbolId::search($this->search)
                ->orderBy($this->sortField, $this->sortAsc ? 'DESC' : 'ASC')
                ->paginate($this->perPage),
        ]);
    }
}
