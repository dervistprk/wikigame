<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table   = 'users';
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin'          => 'boolean',
    ];

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isBanned()
    {
        return $this->is_banned;
    }

    public function isVerified()
    {
        return $this->is_email_verified;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function bestComment()
    {
        return $this->morphOne(Comment::class, 'commentable')->ofMany('likes', 'max');
    }
}
