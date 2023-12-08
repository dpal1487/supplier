<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'base_url', 'base_path'];
    public function image()
    {
        return $this->hasOne(ItemImage::class, 'image_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ItemImage::class, 'image_id', 'id');
    }

    public function banner()
    {
        return $this->hasOne(Banner::class, 'image_id', 'id');
    }
    public function service()
    {
        return $this->hasOne(Service::class, 'image_id', 'id');
    }
}
