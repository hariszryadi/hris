<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsMajor extends Model
{
    protected $table = 'ms_major';

    public function lecturer()
    {
        return $this->hasMany(MsLecturer::class, 'major_id');
    }
}
