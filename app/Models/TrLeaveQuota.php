<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrLeaveQuota extends Model
{
    protected $table = 'tr_leave_quota';

    protected $guarded = [];

    public function empl()
    {
        return $this->belongsTo(MsEmployee::class);
    }
}
