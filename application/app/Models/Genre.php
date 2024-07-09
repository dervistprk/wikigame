<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $table   = 'genres';
    protected $guarded = [];

    public function games()
    {
        return $this->belongsToMany(Game::class, 'genre_game');
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
