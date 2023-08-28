<?php

namespace App\Models;

class Customer extends Model
{
    protected $fillables = [
        'code',
        'class',
        'dob',
        'address',
    ];
}
