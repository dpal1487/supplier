<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;


    protected $fillable = ['user_id', 'date', 'points', 'status', 'comments', 'current_points', 'type'];
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), now()->timestamp);
        });
    }


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function payType()
    {
        return $this->hasOne(TransactionType::class, 'id', 'type');
    }
}
