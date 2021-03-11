<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsEmployee extends Model
{
    protected $table = 'ms_empl';

    protected $guarded = [];

    public function division()
    {
        return $this->belongsTo(MsDivision::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'empl_id');
    }
}
