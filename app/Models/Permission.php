<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name' , 'guard_name'];
   //  public function roles() {

   //      return $this->belongsToMany(Role::class,'roles_permissions');

   //   }

   //   public function users() {

   //      return $this->belongsToMany(User::class,'users_permissions');

   //   }

   public function role() {

        return $this->hasOne(RolePermission::class,'permission_id' , 'id');

     }

    
      public function roles() {

        return $this->hasMany(RolePermission::class,'permission_id' , 'id');

     }

     
}
