<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpinLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'points' => 'array'
    ];


    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'game_id');
    }
}
