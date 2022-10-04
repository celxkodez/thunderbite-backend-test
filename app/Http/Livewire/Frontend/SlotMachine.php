<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Game;
use App\Models\SpinLog;
use App\Models\SymbolId;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class SlotMachine extends Component
{
    public array $reel;
    public array $wins;
    public mixed $total_points;
    public string $prefix = '';
    public string $account;

    public function mount()
    {
        $this->account = request('a');

        $this->reel = $this->reel();
    }

    public function render()
    {
        return view('livewire.frontend.slot-machine');
    }

    public function spin()
    {
        $reel = $this->reel();

        $game = Game::where('account', $this->account)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->latest('created_at')
            ->first();

        $spinLogs = SpinLog::where('game_id', $game->id)
            ->whereDate('created_at', now())
            ->count();

        if ($spinLogs >= (int) $game->spin) {
            throw ValidationException::withMessages([
                "Number Of Spin Exceeded for the day!"
            ]);
        }

        $wins = $this->findWins($reel);
        $total_points = collect($wins['points'])->sum('points');

        $spinLog = SpinLog::create([
            'game_id' => $game->id,
            'is_win' => $total_points > 0,
            'points' => $wins['points'],
        ]);

        $this->prefix = $total_points > 0 ? 'Congrats, You Won!' : 'Sorry, You Loose!';
        $this->wins = $wins;
        $this->total_points = $total_points;

        $this->reel = $reel;
    }

    /**
     * @return array
     * @Note Generates 5 x 3 Array reels from symbols ids present in the database
     */
    private function reel(): array
    {
        $reel = [];
        $symbolIds = SymbolId::inRandomOrder()
            ->where('status', 'active')
            ->get()
            ->pluck('id');

        $symbolIds = [
            ...$symbolIds->toArray(),
            ...$symbolIds->toArray(),
            ...$symbolIds->toArray(),
        ];

        for ($i = 0; $i < 3; $i++) {
            shuffle($symbolIds);
            $reel[] = array_slice($symbolIds, 0, 5);
        }

        return $reel;
    }

    private function findWins(array $reel): array
    {
        $paylines = [
            [
                3 => [
                    [
                        0 => [0,1,2],
                        1 => [0,1,2],
                        2 => [0,1,2],
                    ],

                    [
                        0 => [0],
                        1 => [1],
                        2 => [2],
                    ],
                    [
                        0 => [2],
                        1 => [1],
                        2 => [0],
                    ],
                    [
                        0 => [-1],
                        1 => [0],
                        2 => [-1],
                        3 => [1,2]
                    ],
                    [
                        0 => [-1],
                        1 => [0],
                        2 => [1,2],
                    ],
                    [
                        0 => [0, 1],
                        1 => [2],
                        2 => [-1],
                    ],
                    [
                        0 => [-1],
                        1 => [-1],
                        2 => [0,1],
                        3 => [-1],
                        4 => [2],
                    ],
                ],
                4 => [
                    [
                        0 => [0,1,2,3],
                        1 => [0,1,2,3],
                        2 => [0,1,2,3],
                    ],

                    [
                        0 => [0],
                        1 => [1],
                        2 => [2],
                        3 => [-1],
                        4 => [3],
                    ],
                    [
                        0 => [2],
                        1 => [1],
                        2 => [0],
                        3 => [-1],
                        4 => [3],
                    ],
                    [
                        0 => [-1],
                        1 => [0],
                        2 => [-1],
                        3 => [1,2,3]
                    ],
                    [
                        0 => [-1],
                        1 => [0],
                        2 => [1,2,3],
                    ],
                    [
                        0 => [0, 1],
                        1 => [2],
                        //2 => [-1],
                        2 => [3],
                    ],
                    [
                        0 => [-1],
                        1 => [-1],
                        2 => [0,1],
                        3 => [-1],
                        4 => [2],
                        5 => [-1],
                        6 => [3],
                    ],
                ],
                5 => [
                    [
                        0 => [0,1,2,3,4],
                        1 => [0,1,2,3,4],
                        2 => [0,1,2,3,4],
                    ],
                    [
                        0 => [0],
                        1 => [1],
                        2 => [2],
                        3 => [-1],
                        4 => [3],
                        5 => [-1],
                        6 => [4],
                    ],
                    [
                        0 => [2],
                        1 => [1],
                        2 => [0],
                        3 => [-1],
                        4 => [3],
                        5 => [4],
                    ],
                    [
                        0 => [-1],
                        1 => [0],
                        2 => [-1],
                        3 => [1,2,3],
                        4 => [4],
                    ],
                    [
                        0 => [-1],
                        1 => [0],
                        2 => [1,2,3],
                        3 => [-1],
                        4 => [4]
                    ],//
                    [
                        0 => [0, 1],
                        1 => [2],
                        //2 => [-1],
                        2 => [3,4],
                    ],
                    [
                        0 => [-1],
                        1 => [-1],
                        2 => [0,1],
                        3 => [-1],
                        4 => [2],
                        5 => [-1],
                        6 => [3,4],
                    ],
                ],
            ]
        ];

        $rowStreaks = [];
        $rowStreaksOrders = [];
        $rowStreaksWins = [];
        $points = [];

        foreach ($reel as $row_key => $row) {
            $rowStreaks[] = $row[0];
        }

        $rowStreaksOrders_str = '';

        foreach ($paylines[0][5] as $payline_key => $payline) {

            if ($payline_key == 0) {
                foreach ($payline as $paylineKey => $paylineRows) {
                    $paylineRows_str = '';

                    foreach ($paylineRows as $paylineRows) {
                        $paylineRows_str = $paylineRows_str . $reel[$paylineKey][$paylineRows];
                    }

                    $rowStreaksOrders_str = $rowStreaksOrders_str . $paylineRows_str;


                    $rowStreaksOrders[] = $rowStreaksOrders_str;
                    $rowStreaksOrders_str = '';
                }
            } else {
                $streak_combinations = '';
                foreach ($payline as $key_streak => $streak) {

                    $computedKey = intval($key_streak) % 3;

                    if (count($streak) > 1 ) {
                        foreach ($streak as $streak_key => $streak_value) {
                            $streak_combinations = $streak_combinations . $reel[$computedKey][$streak_value];
                        }
                    } else {
                        $reel_value = $reel[$computedKey][$streak[0]] ?? '';
                        $streak_combinations = $streak_combinations . $reel_value;
                    }
                    $rowStreaksOrders_str = $streak_combinations;
                }

                $rowStreaksOrders[] = $rowStreaksOrders_str;
                $rowStreaksOrders_str = '';
            }

        }

        //find matching row steak

        foreach ($rowStreaksOrders as $orderStreak) {
            foreach ($rowStreaks as $rowStreak) {
                $fiveCombination = $rowStreak . $rowStreak . $rowStreak . $rowStreak . $rowStreak;

                if ($fiveCombination === $orderStreak) {
                    $rowStreaksWins[] = $orderStreak;

                    $symbolId = SymbolId::find($rowStreak);

                    $points[] = [
                        'symbol_id' => $symbolId->id,
                        'points' => $symbolId->match_point_5,
                        'combination' => 5
                    ];
                    break;
                }

                $fourCombination = $rowStreak . $rowStreak . $rowStreak . $rowStreak;

                $orderStreak = mb_substr($orderStreak, 0, strlen($fourCombination));

                if ($fourCombination === $orderStreak) {
                    $rowStreaksWins[] = $orderStreak;

                    $symbolId = SymbolId::find($rowStreak);

                    $points[] = [
                        'symbol_id' => $symbolId->id,
                        'points' => $symbolId->match_point_4,
                        'combination' => 4
                    ];
                    break;
                }

                $threeCombination = $rowStreak . $rowStreak . $rowStreak;

                $orderStreak = mb_substr($orderStreak, 0, strlen($threeCombination));

                if ($threeCombination === $orderStreak) {
                    $rowStreaksWins[] = $orderStreak;

                    $symbolId = SymbolId::find($rowStreak);

                    $points[] = [
                        'symbol_id' => $symbolId->id,
                        'points' => $symbolId->match_point_3,
                        'combination' => 3
                    ];
                    break;
                }

            }
        }

        return [
            'rowStreaksOrders' => $rowStreaksOrders,
            'wins' => $rowStreaksWins,
            'points' => $points
        ];
    }
}
