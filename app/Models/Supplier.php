<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Supplier extends Model implements Authenticatable
{
    use AuthenticatableTrait;
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['supplier_name', 'country_id', 'notes', 'display_name', 'country_id',  'status', 'email_address', 'website', 'skype_profile', 'linkedin_profile'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
        static::deleting(function ($supplier) {
            $supplier->supplier_redirect->delete();
        });
    }
    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function project()
    {
        return $this->hasOne(SupplierProject::class, 'id', 'supplier_id');
    }
    public function supplier_redirect()
    {
        return $this->hasOne(SupplierRedirect::class, 'supplier_id', 'id');
    }
    public function respondents()
    {
        return $this->hasMany(Respondent::class, 'supplier_id', 'id');
    }
    public function getRouteKeyName()
    {
        return 'id';
    }
}
