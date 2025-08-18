<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $guarded = [];
    
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}