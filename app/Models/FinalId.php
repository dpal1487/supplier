<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalId extends Model
{
    use HasFactory;
    protected $fillable = ['respondent_id', 'project_id'];
    public function respondent()
    {
        return $this->hasOne(Respondent::class, 'id', 'respondent_id');
    }
    public function respondents()
    {
        return $this->hasMany(Respondent::class, 'id', 'respondent_id');
    }
    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'id', 'project_id');
    }
}
