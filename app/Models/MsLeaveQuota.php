<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsLeaveQuota extends Model
{
    protected $table = 'ms_leave_quota';

    protected $guarded = [];

    public function empl()
    {
        return $this->belongsTo(MsEmployee::class);
    }
}
