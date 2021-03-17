<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsTypeLeave extends Model
{
    protected $table = 'ms_type_leave';

    public function categoryLeave()
    {
        return $this->hasMany(MsCategoryLeave::class, 'type_leave_id');
    }

    public function trTypeLeave()
    {
        return $this->hasMany(TrLeave::class, 'type_leave_id');
    }

    public function trCategoryLeave()
    {
        return $this->hasMany(TrLeave::class, 'category_leave_id');
    }
}
