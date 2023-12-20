<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;

trait HasPermissionsTrait
{

    //give permission 

    public function getAllPermissions($permissions)
    {
        return Permission::whereIn('name', $permissions)->get();
    }
    public function hasPermission($permission)
    {
        return (bool) $this->permissions->where('name', $permission->name)->count();
    }

    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }
    public function hasPermissionThroughRole($permissions)
    {
        foreach ($permissions->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    public function givePermissionTo(...$permissions)
    {
        $permission = $this->getAllPermissions($permissions);
        if ($permission == null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }
}
