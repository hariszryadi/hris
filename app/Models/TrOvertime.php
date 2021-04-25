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
}
