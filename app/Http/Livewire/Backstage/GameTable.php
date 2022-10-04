<?php

namespace App\Http\Livewire\Backstage;

use App\Exports\GamesTable;
use App\Models\Game;
use Maatwebsite\Excel\Facades\Excel;

//use Maatwebsite\Excel\Excel;

class GameTable extends TableComponent
{
    public $sortField = 'revealed_at';

    public function render()
    {
        $columns = [
            [
                'title' => 'account',
                'sort' => true,
            ],

            [
                'title' => 'prize_id',
                'attribute' => 'prize_id',
                'sort' => true,
            ],

            [
                'title' => 'title',
                'attribute' => 'title',
                'sort' => true,
            ],

            [
                'title' => 'revealed at',
                'attribute' => 'revealed_at',
                'sort' => true,
            ],
            [
                'title' => 'Starts at',
                'attribute' => 'starts_at',
                'sort' => true,
            ],
            [
                'title' => 'Ends at',
                'attribute' => 'ends_at',
                'sort' => true,
            ],
        ];

//        dd(Game::filter()
//            ->orderBy($this->sortField, $this->sortAsc ? 'DESC' : 'ASC')
//            ->get());

        return view('livewire.backstage.table', [
            'columns' => $columns,
            'resource' => 'games',
            'rows' => Game::filter(null, null, [
                    'filter1' => $this->search
                ])
                ->orderBy($this->sortField, $this->sortAsc ? 'DESC' : 'ASC')
                ->paginate($this->perPage),
        ]);
    }

    public function exportToCSV()
    {
        return Excel::download(new GamesTable(
            Game::filter(null, null, [
                        'filter1' => $this->search
                    ])
                    ->orderBy($this->sortField, $this->sortAsc ? 'DESC' : 'ASC')
                    ->get()
        ), 'games.csv');
    }
}
