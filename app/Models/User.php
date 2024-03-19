<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use App\Traits\HasPermissionsTrait;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Billable;
    use HasPermissionsTrait;
    use HasFactory, Notifiable, HasApiTokens;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'date_of_birth',
        'gender',
        'mobile',
        'country_id',
        'deactivate_reason',
        'deactivate_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->hasOne(UsersRole::class, 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles', 'user_id', 'role_id');
    }
    public function completes()
    {
        return $this->HasMany(Respondent::class, 'user_id', 'id')->where('status', 'complete');
    }
    public function terminates()
    {
        return $this->HasMany(Respondent::class, 'user_id', 'id')->where('status', 'terminate');
    }
    public function quotafull()
    {
        return $this->HasMany(Respondent::class, 'user_id', 'id')->where('status', 'terminate');
    }
    public function projects()
    {
        return $this->HasMany(Respondent::class, 'user_id', 'id');
    }

    public function authorizeRoles($roles)
    {
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(401, 'This action is unauthorized.');
    }
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }
    public function hasRole($role)
    {
        if ($this->roles()->where('slug', $role)->first()) {
            return true;
        }
        return false;
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'user_id', 'id')->where('entity_type', 'user');
    }
}
