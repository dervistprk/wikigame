<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $table   = 'platforms';
    protected $guarded = [];

    public function games()
    {
        return $this->belongsToMany(Game::class, 'platform_game');
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
