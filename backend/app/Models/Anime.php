<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anime extends Model
{
    use SoftDeletes;

    protected $table = 'animes';

    protected $fillable = [
        'title',
        'synopsis',
        'genres',
        'release_year',
        'status',
        'rating',
        'poster_url',
        'banner_url',
    ];

    protected $casts = [
        'genres' => 'array',
        'rating' => 'decimal:1',
    ];

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }
}
