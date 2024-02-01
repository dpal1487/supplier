<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['industry_id', 'question_key', 'text', 'language', 'type'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($question) {
            if ($question->answer) {
                $question->answers()->delete();
            }
        });
    }
    function industry()
    {
        return $this->hasOne(Industry::class, 'id', 'industry_id');
    }

    public function answer()
    {
        return $this->hasOne(Answer::class, 'question_id', 'id');
    }
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }
}
