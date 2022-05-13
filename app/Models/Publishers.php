<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publishers extends Model
{
    use HasFactory;

    protected $table = 'publishers';

    public function games()
    {
        return $this->hasMany(Games::class, 'publisher_id', 'id');
    }
}
