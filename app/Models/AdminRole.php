<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'admin_role';
    protected $primaryKey = ['admin_id', 'role_id'];
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'admin_id',
        'role_id',
    ];
}
