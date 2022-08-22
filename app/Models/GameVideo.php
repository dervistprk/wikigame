<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameVideo extends Model
{
    use HasFactory;

    protected $table = 'game_videos';
    protected $guarded = [];

    public function game()
    {
        return $this->hasOne(Game::class, 'id', 'game_id');
    }
}
