<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['title', 'content', 'slug', 'image_id', 'published'];
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($blog) {
            if ($blog->image) {
                $blog->image->delete();
                unlink($blog->image->path . '/' . $blog->image->name);
            }
        });
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'entity_id', 'id')->where('entity_type', 'blog');
    }
}
