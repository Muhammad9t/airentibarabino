<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'image', 'status'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
