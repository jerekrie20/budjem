<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class IncomeController extends Controller

{

    public function index()
    {

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required'],
            'amount' =>['required','decimal:2'],
            'frequency' => 'required|in:weekly,monthly,yearly,bi-weekly',
        ]);

        $attributes['user_id'] = $request->user()->id;

        Income::create($attributes);

        session()->flash('message', 'Income added successfully');

        return Redirect::route('budget');
    }

    public function show(Income $income)
    {
        $this->authorize('view', $income);
        $user = auth()->user();
        $budgets = $user->budgets;
        $incomes = $user->incomes; // Assuming a user has many incomes relationship
        return Inertia::render('Budget/Index', [
            'budgets' => $budgets,
            'incomes' => $incomes,
            'incomeIn' => $income,
            'update' => true
        ]);
    }

    //Update income
    public function update(Request $request, Income $income)
    {
        $this->authorize('update', $income);
        $attributes = $request->validate([
            'name' => ['required'],
            'amount' =>['required','decimal:2'],
            'frequency' => 'required|in:weekly,monthly,yearly,bi-weekly',
        ]);

        $income->update($attributes);

        session()->flash('message', 'Income updated successfully');

        return Redirect::route('budget');
    }

    //destroy income after checking if it belongs to the user
    public function destroy(Income $income)
    {
        $this->authorize('delete', $income);
        $income->delete();
        session()->flash('message', 'Income deleted successfully');
        return Redirect::route('budget');
    }

}
