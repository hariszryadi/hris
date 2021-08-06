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

    public function leaveQuota()
    {
        return $this->hasOne(TrLeaveQuota::class, 'empl_id');
    }

    public function trLeave()
    {
        return $this->hasMany(TrLeave::class, 'empl_id');
    }

    public function leaveUpdatedBy()
    {
        return $this->hasMany(TrLeave::class, 'updated_by');
    }

    public function trOvertime()
    {
        return $this->hasMany(TrOvertime::class, 'empl_id');
    }

    public function overtimeUpdatedBy()
    {
        return $this->hasMany(TrOvertime::class, 'updated_by');
    }

    public function scopeCheckDir($query)
    {
        return $query->where('division_id', '=', 14);
    }

    public function scopeCheckWadir($query)
    {
        return $query->where('division_id', '=', 15);
    }
}
