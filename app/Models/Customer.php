<?php

namespace App\Models;

class Customer extends Model
{
    protected $fillable = [
        'code',
        'class',
        'name',
        'dob',
        'address',
        'balance',
    ];

    public function trxs()
    {
        return $this->hasMany(Transaction::class);
    }
}
