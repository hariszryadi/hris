<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'ms_division';

    protected $fillable = ['name'];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'division_id');
    }
}
