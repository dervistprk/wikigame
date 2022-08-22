<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;

    protected $table   = 'developers';
    protected $guarded = [];

    public function games()
    {
        return $this->hasMany(Game::class, 'developer_id', 'id');
    }
}
