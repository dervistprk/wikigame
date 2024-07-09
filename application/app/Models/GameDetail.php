<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDetail extends Model
{
    use HasFactory;

    protected $table   = 'game_details';
    protected $guarded = [];

    public function game()
    {
        return $this->hasOne(Game::class, 'game_details_id', 'id');
    }
}
