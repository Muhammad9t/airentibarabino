<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'status'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
