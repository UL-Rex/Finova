<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::where('user_id', Auth::id())->get();
        return view('budgets.index', compact('budgets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category'   => 'required|string',
            'amount'     => 'required|numeric|min:0',
            'period'     => 'required|in:weekly,monthly,yearly',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date',
        ]);

        Budget::create([
            'user_id'    => Auth::id(),
            'category'   => $request->category,
            'amount'     => $request->amount,
            'period'     => $request->period,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget added!');
    }

    public function update(Request $request, Budget $budget)
    {
        abort_if($budget->user_id !== Auth::id(), 403);

        $request->validate([
            'category'   => 'required|string',
            'amount'     => 'required|numeric|min:0',
            'period'     => 'required|in:weekly,monthly,yearly',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date',
        ]);

        $budget->update($request->only('category','amount','period','start_date','end_date'));

        return redirect()->route('budgets.index')->with('success', 'Budget updated!');
    }

    public function destroy(Budget $budget)
    {
        abort_if($budget->user_id !== Auth::id(), 403);
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Budget deleted!');
    }
}