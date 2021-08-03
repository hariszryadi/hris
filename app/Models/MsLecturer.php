<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsLecturer extends Model
{
    protected $table = 'ms_lecturer';

    protected $guarded = [];

    public function major()
    {
        return $this->belongsTo(MsMajor::class);
    }

    public function functional_position()
    {
        return $this->belongsTo(MsFunctionalPosition::class);
    }
}
