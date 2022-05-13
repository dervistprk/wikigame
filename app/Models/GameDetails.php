<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDetails extends Model
{
    use HasFactory;

    protected $table = 'game_details';

    public function game()
    {
        return $this->hasOne(Games::class, 'game_details_id', 'id');
    }
}
