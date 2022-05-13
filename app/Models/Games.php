<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = [
        'category_id',
        'publisher_id',
        'developer_id',
        'game_details_id',
        'sys_req_min_id',
        'sys_req_rec_id'
    ];

    public function category()
    {
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }

    public function developer()
    {
        return $this->hasOne(Developers::class, 'id', 'developer_id');
    }

    public function publisher()
    {
        return $this->hasOne(Publishers::class, 'id', 'publisher_id');
    }

    public function details()
    {
        return $this->hasOne(GameDetails::class, 'id', 'game_details_id');
    }

    public function systemReqMin()
    {
        return $this->hasOne(SystemRequirementsMin::class, 'id', 'sys_req_min_id');
    }

    public function systemReqRec()
    {
        return $this->hasOne(SystemRequirementsRec::class, 'id', 'sys_req_rec_id');
    }
}
