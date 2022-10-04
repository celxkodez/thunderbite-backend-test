<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'prize_id',
        'account',
        'revealed_at',
        'starts_at',
        'ends_at',
        'spin',
        'points'
    ];

    protected $dates = [
        'revealed_at',
        'starts_at',
        'ends_at',
    ];

    public static function filter($start_date = null, $end_date = null, array $filters = [])
    {
        $filters = array_merge(
            [
                'filter1' => null,
                'filter2' => null,
                'filter3' => null,
                'filter4' => null,
            ],
            $filters
        );

        $query = self::query();
        $campaign = Campaign::find(session('activeCampaign'));

        self::filterDates($query, $campaign, $start_date, $end_date);

        if ($data = $filters['filter1']) {
            $query->where('account', 'like', $data.'%');
        }

        if ($data = $filters['filter2']) {
            $query->where('prize_id', $data);
        }

        if ($data = $filters['filter3']) {
            $query->whereRaw('HOUR(revealed_at) >= '.$data);
        }

        if ($data = $filters['filter4']) {
            $query->whereRaw('HOUR(revealed_at) <= '.$data);
        }

        $query->leftJoin('prizes', 'prizes.id', '=', 'games.prize_id')
            ->select([
                'games.id',
                'account',
                'prize_id',
                'revealed_at',
                'games.starts_at',
                'games.ends_at',
                'prizes.name as title'
            ])
            ->where('games.campaign_id', $campaign->id);

        return $query;
    }

    private static function filterDates($query, $campaign, $start_date = null, $end_date = null): void
    {
        if (($data = $start_date) || ($data = Carbon::now()->subDays(6))) {
            $data = Carbon::parse($data)->setTimezone($campaign->timezone)->toDateTimeString();
            $query->where('games.revealed_at', '>=', $data);
        }
        if (($data = $end_date) || ($data = Carbon::now())) {
            $data = Carbon::parse($data)->setTimezone($campaign->timezone)->toDateTimeString();
            $query->where('games.revealed_at', '<=', $data);
        }
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function prize()
    {
        return $this->belongsTo(Prize::class);
    }
}
