<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Debt;
use Illuminate\Support\Facades\Auth;

class DebtController extends Controller
{
    public function index()
    {
        $debts = Debt::where('user_id', Auth::id())
                    ->orderBy('due_date', 'asc')
                    ->get();
        return view('debts.index', compact('debts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'type'          => 'required|string',
            'total_amount'  => 'required|numeric|min:0',
            'paid_amount'   => 'nullable|numeric|min:0',
            'interest_rate' => 'nullable|numeric|min:0',
            'due_date'      => 'nullable|date',
        ]);

        Debt::create([
            'user_id'       => Auth::id(),
            'title'         => $request->title,
            'type'          => $request->type,
            'total_amount'  => $request->total_amount,
            'paid_amount'   => $request->paid_amount ?? 0,
            'interest_rate' => $request->interest_rate,
            'due_date'      => $request->due_date,
        ]);

        return redirect()->route('debts.index')->with('success', 'Debt added!');
    }

    public function update(Request $request, Debt $debt)
    {
        abort_if($debt->user_id !== Auth::id(), 403);

        $request->validate([
            'title'         => 'required|string|max:255',
            'type'          => 'required|string',
            'total_amount'  => 'required|numeric|min:0',
            'paid_amount'   => 'nullable|numeric|min:0',
            'interest_rate' => 'nullable|numeric|min:0',
            'due_date'      => 'nullable|date',
        ]);

        $debt->update($request->only(
            'title','type','total_amount','paid_amount','interest_rate','due_date'
        ));

        return redirect()->route('debts.index')->with('success', 'Debt updated!');
    }

    public function destroy(Debt $debt)
    {
        abort_if($debt->user_id !== Auth::id(), 403);
        $debt->delete();
        return redirect()->route('debts.index')->with('success', 'Debt deleted!');
    }
}