<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsFunctionalPosition extends Model
{
    protected $table = 'ms_functional_position';

    public function lecturer()
    {
        return $this->hasMany(MsLecturer::class, 'functional_position_id');
    }
}
