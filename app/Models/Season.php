<?php

namespace App\Models;

use App\Models\Serie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Season extends Model
{
    use HasFactory;

    public function series()
    {
        return $this->belongsto(Serie::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
}