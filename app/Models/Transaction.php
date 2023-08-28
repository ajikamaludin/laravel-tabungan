<?php

namespace App\Models;

class Transaction extends Model
{
    const TYPE_DEBIT = 0;
    const TYPE_CREDIT = 1;

    protected $fillable = [
        'customer_id',
        'type',
        'amount',
        'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class)->withTrashed();
    }

    public function record_customer_balance()
    {
        $customer = Customer::withTrashed()->find($this->customer_id);

        if ($this->type == self::TYPE_DEBIT) {
            $customer->update(['balance' => $customer->balance + $this->amount]);
        }

        if ($this->type == self::TYPE_CREDIT) {
            $customer->update(['balance' => $customer->balance - $this->amount]);
        }
    }

    public function restore_customer_balance()
    {
        $customer = Customer::withTrashed()->find($this->customer_id);

        if ($this->type == self::TYPE_DEBIT) {
            $customer->update(['balance' => $customer->balance - $this->amount]);
        }

        if ($this->type == self::TYPE_CREDIT) {
            $customer->update(['balance' => $customer->balance + $this->amount]);
        }
    }
}
