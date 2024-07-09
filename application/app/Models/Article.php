<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $table   = 'articles';
    protected $guarded = [];

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
