<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GamesTable implements FromView
{
    public function __construct(protected $data)
    {
    }

    public function view(): View
    {
        return view('backstage.exports.games-table', [
            'data' => $this->data
        ]);
    }
}
