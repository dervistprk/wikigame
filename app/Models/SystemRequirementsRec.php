<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemRequirementsRec extends Model
{
    use HasFactory;

    protected $table = 'system_requirements_rec';

    public function game()
    {
        return $this->hasOne(Games::class, 'syst_req_rec_id', 'id');
    }
}
