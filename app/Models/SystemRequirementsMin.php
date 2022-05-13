<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemRequirementsMin extends Model
{
    use HasFactory;

    protected $table = 'system_requirements_min';

    public function game()
    {
        return $this->hasOne(Games::class, 'syst_req_min_id', 'id');
    }
}
