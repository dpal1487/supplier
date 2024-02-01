<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($industry) {
            if ($industry->image) {
                $industry->image->delete();
                unlink($industry->image->path . '/' . $industry->image->name);
            }
        });
    }
    public function image()
    {
        return $this->hasOne(Image::class, 'entity_id', 'id')->where('entity_type', 'industry');
    }
}
