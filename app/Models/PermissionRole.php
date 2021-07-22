<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table = 'permission_role';
    // protected $primaryKey = ['permission_id', 'role_id'];
    // public $incrementing = false;

    // public $timestamps = false;

    protected $fillable = [
        'permission_role',
        'role_id',
        'read_right',
        'create_right',
        'update_right',
        'delete_right'
    ];

    public function roles()
    {
        return $this->belongsTo(Roles::class);
    }

    public function scopeById($query, $permission_id)
    {
        return $query->where('permission_id', $permission_id);
    }
}
