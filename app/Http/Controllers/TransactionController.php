<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query()->with(['customer']);

        if ($request->type != '') {
            $query->where('type', $request->type);
        }

        $query->orderBy('created_at', 'desc');

        return inertia('Transaction/Index', [
            'query' => $query->paginate(10),
            'type' => $request->type,
        ]);
    }

    public function create(Request $request)
    {
        if (!in_array($request->type, [Transaction::TYPE_DEBIT, Transaction::TYPE_CREDIT])) {
            return redirect()->route('trx.index', ['type' => Transaction::TYPE_CREDIT]);
        }

        return inertia('Transaction/Form', [
            'type' => $request->type,
            '_now' => now()->format('m/d/Y'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:0,1',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
        ]);

        DB::beginTransaction();

        $trx = Transaction::create([
            'type' => $request->type,
            'amount' => $request->amount,
            'date' => $request->date,
            'customer_id' => $request->customer_id,
        ]);

        $trx->record_customer_balance();

        DB::commit();

        return redirect()->route('trx.index', ['type' => $request->type])
            ->with('message', ['type' => 'success', 'message' => 'Item has beed saved']);
    }

    public function destroy(Transaction $trx)
    {
        DB::transaction(function () use ($trx) {
            $trx->restore_customer_balance();
            $trx->delete();
        });

        return redirect()->back()
            ->with('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
