<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class SupplierProject extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['project_id', 'project_link_id', 'supplier_id', 'supplier_link', 'cpi', 'terminate_url', 'quotafull_url', 'complete_url', 'security_terminate_url', 'sample_size', 'notes', 'status'];
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }
    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }
    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
    public function projects()
    {
        return $this->hasMany(Project::class, 'id', 'project_id');
    }
    public function project_link()
    {
        return $this->hasOne(ProjectLink::class, 'id', 'project_link_id');
    }
    public function surveys()
    {
        return $this->hasMany(Respondent::class, 'supplier_project_id', 'id');
    }
    public function total()
    {
        return $this->surveys();
    }
    public function completes()
    {
        return $this->surveys()->where('status', 'complete');
    }
    public function terminate()
    {
        return $this->surveys()->where('status', 'terminate');
    }
    public function security_terminate()
    {
        return $this->surveys()->where('status', 'security-terminate');
    }
    public function quotafull()
    {
        return $this->surveys()->where('status', 'quotafull');
    }
    public function incomplete()
    {
        return $this->surveys()->where('status', null);
    }
    public function getRouteKeyName()
    {
        return 'id';
    }
}
