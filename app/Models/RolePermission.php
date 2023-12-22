<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    protected $fillable = ['role_id', 'permission_id'];
    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }
    public function permission()
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }
}
