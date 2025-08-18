<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = [];
    
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}