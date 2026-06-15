<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::where('user_id', Auth::id())
                    ->orderBy('date', 'desc')
                    ->get();
        return view('expenses.index', compact('expenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'amount'   => 'required|numeric|min:0',
            'category' => 'required|string',
            'date'     => 'required|date',
            'note'     => 'nullable|string',
        ]);

        Expense::create([
            'user_id'  => Auth::id(),
            'title'    => $request->title,
            'amount'   => $request->amount,
            'category' => $request->category,
            'date'     => $request->date,
            'note'     => $request->note,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense added!');
    }

    public function update(Request $request, Expense $expense)
    {
        abort_if($expense->user_id !== Auth::id(), 403);

        $request->validate([
            'title'    => 'required|string|max:255',
            'amount'   => 'required|numeric|min:0',
            'category' => 'required|string',
            'date'     => 'required|date',
            'note'     => 'nullable|string',
        ]);

        $expense->update($request->only('title','amount','category','date','note'));

        return redirect()->route('expenses.index')->with('success', 'Expense updated!');
    }

    public function destroy(Expense $expense)
    {
        abort_if($expense->user_id !== Auth::id(), 403);
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted!');
    }
}