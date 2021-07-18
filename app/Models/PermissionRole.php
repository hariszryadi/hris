<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table = 'permission_role';
    protected $primaryKey = ['permission_id', 'role_id'];
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'permission_role',
        'role_id',
        'read_right',
        'create_right',
        'update_right',
        'delete_right'
    ];
}
