<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsDivision extends Model
{
    protected $table = 'ms_division';

    protected $fillable = ['name'];

    public function employee()
    {
        return $this->hasMany(MsEmployee::class, 'division_id');
    }
}
