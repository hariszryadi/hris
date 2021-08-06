<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrLeave extends Model
{
    protected $table = 'tr_leave';

    protected $guarded = [];

    public function empl()
    {
        return $this->belongsTo(MsEmployee::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(MsEmployee::class, 'updated_by');
    }

    public function typeLeave()
    {
        return $this->belongsTo(MsTypeLeave::class);
    }

    public function categoryLeave()
    {
        return $this->belongsTo(MsCategoryLeave::class);
    }
}
