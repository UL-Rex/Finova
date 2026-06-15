<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
                        ->orderBy('date', 'desc')
                        ->get();
        return view('transactions.index', compact('transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'amount'   => 'required|numeric|min:0',
            'type'     => 'required|in:income,expense',
            'category' => 'nullable|string',
            'date'     => 'required|date',
            'note'     => 'nullable|string',
        ]);

        Transaction::create([
            'user_id'  => Auth::id(),
            'title'    => $request->title,
            'amount'   => $request->amount,
            'type'     => $request->type,
            'category' => $request->category,
            'date'     => $request->date,
            'note'     => $request->note,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction added!');
    }

    public function update(Request $request, Transaction $transaction)
    {
        abort_if($transaction->user_id !== Auth::id(), 403);

        $request->validate([
            'title'    => 'required|string|max:255',
            'amount'   => 'required|numeric|min:0',
            'type'     => 'required|in:income,expense',
            'category' => 'nullable|string',
            'date'     => 'required|date',
            'note'     => 'nullable|string',
        ]);

        $transaction->update($request->only('title','amount','type','category','date','note'));

        return redirect()->route('transactions.index')->with('success', 'Transaction updated!');
    }

    public function destroy(Transaction $transaction)
    {
        abort_if($transaction->user_id !== Auth::id(), 403);
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted!');
    }
}