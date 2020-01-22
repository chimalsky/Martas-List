<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = ['id'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'collaborators', 'user_id');
    }

    public function archives()
    {
        return $this->hasMany(ResourceType::class, 'resource_types', 'project_id');
    }
}
