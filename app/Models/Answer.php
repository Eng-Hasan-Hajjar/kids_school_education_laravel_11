<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = [];
    
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}