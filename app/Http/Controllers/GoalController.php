<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Goal::where('user_id', Auth::id())->get();
        return view('goals.index', compact('goals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'saved_amount'  => 'nullable|numeric|min:0',
            'deadline'      => 'nullable|date',
            'note'          => 'nullable|string',
        ]);

        Goal::create([
            'user_id'       => Auth::id(),
            'title'         => $request->title,
            'target_amount' => $request->target_amount,
            'saved_amount'  => $request->saved_amount ?? 0,
            'deadline'      => $request->deadline,
            'note'          => $request->note,
        ]);

        return redirect()->route('goals.index')->with('success', 'Goal added!');
    }

    public function update(Request $request, Goal $goal)
    {
        abort_if($goal->user_id !== Auth::id(), 403);

        $request->validate([
            'title'         => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'saved_amount'  => 'nullable|numeric|min:0',
            'deadline'      => 'nullable|date',
            'note'          => 'nullable|string',
        ]);

        $goal->update($request->only('title','target_amount','saved_amount','deadline','note'));

        return redirect()->route('goals.index')->with('success', 'Goal updated!');
    }

    public function destroy(Goal $goal)
    {
        abort_if($goal->user_id !== Auth::id(), 403);
        $goal->delete();
        return redirect()->route('goals.index')->with('success', 'Goal deleted!');
    }
}