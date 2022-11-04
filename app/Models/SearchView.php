<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchView extends Model
{
    use HasFactory;

    protected $table   = 'search_view';
    protected $guarded = [];

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }
}
