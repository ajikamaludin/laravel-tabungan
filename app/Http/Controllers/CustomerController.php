<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\GeneralService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%")
                ->orWhere('class', 'like', "%{$request->q}%")
                ->orWhere('code', 'like', "%{$request->q}%");
        }

        $query->orderBy('created_at', 'desc');

        return inertia('Customer/Index', [
            'query' => $query->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'dob' => 'nullable|date'
        ]);

        Customer::create([
            'code' =>  GeneralService::formatNum(Customer::count() + 1),
            'name' => $request->name,
            'class' => $request->class,
            'address' => $request->address,
            'dob' => $request->dob,
        ]);

        return redirect()->route('customer.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'dob' => 'nullable|date'
        ]);

        $customer->update([
            'name' => $request->name,
            'class' => $request->class,
            'address' => $request->address,
            'dob' => $request->dob,
        ]);

        return redirect()->route('customer.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed updated']);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customer.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
