<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = [];
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
