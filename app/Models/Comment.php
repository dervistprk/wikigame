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

    public function parent()
    {
        return $this->hasOne(Comment::class, 'id', 'parent_id');
    }

    public function subParent()
    {
        return $this->hasOne(Comment::class, 'id', 'sub_parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->where('is_verified', 1);
    }

    public function waitingConfirmation()
    {
        return $this->hasMany(Comment::class, 'parent_id')->where('is_verified', 0);
    }

    public function likedUsers()
    {
        return $this->hasMany(CommentLike::class, 'comment_id', 'id');
    }

    public function dislikedUsers()
    {
        return $this->hasMany(CommentDislike::class, 'comment_id', 'id');
    }
}
