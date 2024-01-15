<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status'];

    public function image()
    {
        return $this->hasOne(Image::class, 'entity_id', 'id')->where('entity_type', 'industry');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($industry) {
            // before delete() method call this
            $industry->image()->delete();
            // do the rest of the cleanup...
        });
    }
}
