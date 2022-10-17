<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentDislike extends Model
{
    use HasFactory;

    protected $table   = 'comment_dislikes';
    protected $guarded = [];

    public function comment()
    {
        return $this->hasOne(Comment::class, 'id', 'comment_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
