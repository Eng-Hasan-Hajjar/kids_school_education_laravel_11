<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $guarded = [];
    
    public function units()
    {
        return $this->hasMany(Unit::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_section');
    }



    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Unit::class);
    }
}