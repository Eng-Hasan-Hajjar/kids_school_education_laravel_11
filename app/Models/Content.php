<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $guarded = [];
    
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}