<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table   = 'comments';
    protected $guarded = [];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->where('is_verified', 1);
    }

    public function waitingConfirmation()
    {
        return $this->hasMany(Comment::class, 'parent_id')->where('is_verified', 0);
    }
}
