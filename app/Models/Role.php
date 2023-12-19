<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable=['name','slug'];
   //  public function permissions() {

   //      return $this->belongsToMany(Permission::class,'roles_permissions');

   //   }

   
     public function permission() {

        return $this->hasOne(RolePermission::class,'role_id' , 'id');

     }   
      public function permissions() {

        return $this->hasMany(RolePermission::class,'role_id' , 'id');

     }

   //   public function users() {
   //      return $this->belongsToMany(User::class,'users_roles');
   //   }

    public function user() {
        return $this->hasOne(UserRole::class,'role_id' , 'id');
     }
     public function users() {
        return $this->hasMany(UserRole::class,'role_id' , 'id');
     }


     public function hasPermission($permission)
     {
      return $this->permissions->contains('name' , $permission);
     }
}
