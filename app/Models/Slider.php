<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }
}
