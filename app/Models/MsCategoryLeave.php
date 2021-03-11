<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsCategoryLeave extends Model
{
    protected $table = 'ms_category_leave';

    protected $guarded = [];

    public function typeLeave()
    {
        return $this->belongsTo(MsTypeLeave::class);
    }
}
