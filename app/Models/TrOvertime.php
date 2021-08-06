<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrOvertime extends Model
{
    protected $table = 'tr_overtime';

    protected $guarded = [];

    public function empl()
    {
        return $this->belongsTo(MsEmployee::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(MsEmployee::class, 'updated_by');
    }

    public function trOvertimeAmount()
    {
        return $this->hasOne(TrOvertimeAmount::class, 'overtime_id');
    }
}
