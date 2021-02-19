<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'ms_empl';

    protected $guarded = [];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
