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
    protected $fillable = [
        'supplier_name',
        'contact_number',
        'email_address',
        'rfq_email',
        'password',
        'final_id_emails',
        'website',
        'final_id',
        'country_id',
        'description',
        'display_name',
        'skype_profile',
        'aol',
        'mailing_adress',
        'city',
        'state',
        'zipcode',
        'country_id',
        'status',
        'linkedin_profile',
        'traffic_details',
        'name_of_contact'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }
    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function project()
    {
        return $this->hasOne(SupplierProject::class, 'supplier_id', 'id');
    }

    public function projects()
    {
        return $this->hasMany(SupplierProject::class, 'supplier_id', 'id');
    }

    public function respondents()
    {
        return $this->hasMany(Respondent::class, 'supplier_id', 'id');
    }
}
