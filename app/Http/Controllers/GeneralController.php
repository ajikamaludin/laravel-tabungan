<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;

class GeneralController extends Controller
{
    public function index()
    {
        $customer = Customer::count();
        $balance = Transaction::where('type', Transaction::TYPE_DEBIT)->sum('amount') - Transaction::where('type', Transaction::TYPE_CREDIT)->sum('amount');

        return inertia('Dashboard', [
            'customer_count' => $customer,
            'balance' => $balance
        ]);
    }

    public function maintance()
    {
        return inertia('Maintance');
    }
}
