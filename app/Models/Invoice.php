<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id', 'invoice_number', 'issue_date', 'add_days', 'due_date', 'interval_date' , 'from_address', 'to_address', 'currency_id', 'type', 'tax_rate', 'client', 'conversion_rate', 'notes', 'status', 'total_amount'
    ];
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($invoice) {
            $invoice->items()->delete();
        });
    }
    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }
    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }
}
