<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrOvertimeAmount extends Model
{
    protected $table = 'tr_overtime_amount';

    protected $guarded = [];

    public function overtime()
    {
        return $this->belongsTo(TrOvertime::class);
    }
}
