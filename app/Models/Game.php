<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table   = 'games';
    protected $guarded = [];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function developer()
    {
        return $this->hasOne(Developer::class, 'id', 'developer_id');
    }

    public function publisher()
    {
        return $this->hasOne(Publisher::class, 'id', 'publisher_id');
    }

    public function details()
    {
        return $this->hasOne(GameDetail::class, 'id', 'game_details_id');
    }

    public function systemReqMin()
    {
        return $this->hasOne(SystemRequirementsMin::class, 'id', 'sys_req_min_id');
    }

    public function systemReqRec()
    {
        return $this->hasOne(SystemRequirementsRec::class, 'id', 'sys_req_rec_id');
    }

    public function videos()
    {
        return $this->hasMany(GameVideo::class, 'game_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(GameImage::class, 'game_id', 'id');
    }

    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'platform_game');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_game');
    }
}
