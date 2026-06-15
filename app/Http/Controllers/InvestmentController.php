<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investment;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::where('user_id', Auth::id())->get();
        return view('investments.index', compact('investments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'type'            => 'required|string',
            'invested_amount' => 'required|numeric|min:0',
            'current_value'   => 'required|numeric|min:0',
            'date'            => 'required|date',
            'note'            => 'nullable|string',
        ]);

        Investment::create([
            'user_id'         => Auth::id(),
            'name'            => $request->name,
            'type'            => $request->type,
            'invested_amount' => $request->invested_amount,
            'current_value'   => $request->current_value,
            'date'            => $request->date,
            'note'            => $request->note,
        ]);

        return redirect()->route('investments.index')->with('success', 'Investment added!');
    }

    public function update(Request $request, Investment $investment)
    {
        abort_if($investment->user_id !== Auth::id(), 403);

        $request->validate([
            'name'            => 'required|string|max:255',
            'type'            => 'required|string',
            'invested_amount' => 'required|numeric|min:0',
            'current_value'   => 'required|numeric|min:0',
            'date'            => 'required|date',
            'note'            => 'nullable|string',
        ]);

        $investment->update($request->only('name','type','invested_amount','current_value','date','note'));

        return redirect()->route('investments.index')->with('success', 'Investment updated!');
    }

    public function destroy(Investment $investment)
    {
        abort_if($investment->user_id !== Auth::id(), 403);
        $investment->delete();
        return redirect()->route('investments.index')->with('success', 'Investment deleted!');
    }
}