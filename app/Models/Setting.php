<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'logo',
        'phone_one',
        'phone_two',
        'email_one',
        'email_two',
        'address_one',
        'address_two',
        'footer_description',
    ];
}
