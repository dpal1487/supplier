<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'transaction_id', 'account_id', 'type', 'amount', 'description', 'debit', 'credit', 'balance', 'plan_id', 'order_id', 'email_address', 'contact', 'status'];
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), now()->timestamp);
        });
    }


    public function bank()
    {
        return $this->hasOne(Bank::class, 'id', 'account_id');
    }
    public function expenseCategory()
    {
        return $this->hasOne(ExpenseCategory::class, 'id', 'type');
    }
    public function paymentMethod()
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'type');
    }

    public function transactionType()
    {
        return $this->hasOne(TransactionType::class, 'id', 'type');
    }
}
