<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SymbolId extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getImageAttribute()
    {
        return asset("{$this->attributes['image_url']}");
    }

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%'.$query.'%');
    }
}
