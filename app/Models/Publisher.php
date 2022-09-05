<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $table   = 'publishers';
    protected $guarded = [];

    public function games()
    {
        return $this->hasMany(Game::class, 'publisher_id', 'id');
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
