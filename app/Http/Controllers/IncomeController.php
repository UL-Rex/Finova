<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::where('user_id', Auth::id())
                    ->orderBy('date', 'desc')
                    ->get();
        return view('income.index', compact('incomes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'source' => 'required|string',
            'date'   => 'required|date',
            'note'   => 'nullable|string',
        ]);

        Income::create([
            'user_id' => Auth::id(),
            'title'   => $request->title,
            'amount'  => $request->amount,
            'source'  => $request->source,
            'date'    => $request->date,
            'note'    => $request->note,
        ]);

        return redirect()->route('income.index')->with('success', 'Income added!');
    }

    public function update(Request $request, Income $income)
    {
        abort_if($income->user_id !== Auth::id(), 403);

        $request->validate([
            'title'  => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'source' => 'required|string',
            'date'   => 'required|date',
            'note'   => 'nullable|string',
        ]);

        $income->update($request->only('title','amount','source','date','note'));

        return redirect()->route('income.index')->with('success', 'Income updated!');
    }

    public function destroy(Income $income)
    {
        abort_if($income->user_id !== Auth::id(), 403);
        $income->delete();
        return redirect()->route('income.index')->with('success', 'Income deleted!');
    }
}