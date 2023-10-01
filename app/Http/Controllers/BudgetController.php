<?php

namespace App\Http\Controllers;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BudgetController extends Controller
{

    protected function validateBudget(?Budget $budget = null): array
    {
        $budget ??= new Budget();

        return request()->validate([
            'name' => ['required'],
            'color' => ['required'],
            'type' => ['required'],
            'due_date' =>['required','date'] ,
            'frequency' => 'required|in:weekly,monthly,yearly',
            'amount' =>['required','decimal:2'] ,
        ]);

    }

    protected function getUpdatedChartData()
    {

        $user = auth()->user();

        // Retrieve all budget rows for the user
        $budgets = $user->budgets; // Assuming a user has many budgets relationship

        // Calculate totalSpent
        $totalSpent = $budgets->sum('amount'); // Assuming 'amount' is a field in your budgets table

        $income = $user->incomes; // Assuming a user has many incomes relationship

        // Fetch or calculate the monthly income from the incomes table, frequency is monthly
        $monthlyIncome = $income->where('frequency', 'monthly')->sum('amount');

        // Fetch or calculate the weekly income from the incomes table, frequency is weekly
        $weeklyIncome = $income->where('frequency', 'weekly')->sum('amount');

        // Fetch or calculate the yearly income from the incomes table, frequency is yearly
        $yearlyIncome = $income->where('frequency', 'yearly')->sum('amount');

        // Calculate remainingAmount
        $remainingAmount = $monthlyIncome - $totalSpent;

        // Generate chart data
        return [
            'labels' => $budgets->pluck('name')->push('Remaining')->toArray(), // Added 'Remaining' label
            'datasets' => [
                [
                    'data' => $budgets->pluck('amount')->merge([$remainingAmount])->toArray(), // Add remainingAmount to the datasets
                    'backgroundColor' => $budgets->map(function ($budget) {
                        // Return the color from the database or generate a random color if it's null
                        return $budget->color ?? 'rgba(' . mt_rand(0, 255) . ',' . mt_rand(0, 255) . ',' . mt_rand(0, 255) . ',0.5)';
                    })->push('rgba(75, 192, 192,0.5)')->toArray(),

                ]
            ]
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $budgets = $user->budgets; // Assuming a user has many budgets relationship
        $incomes = $user->incomes; // Assuming a user has many incomes relationship

        return Inertia::render('Budget/Index', [
            'budgets' => $budgets,
            'incomes' => $incomes,
            'expense' => null,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', $request);

        $attributes = $this->validateBudget();

        $attributes['user_id'] = $request->user()->id;

        Budget::create($attributes);

        session()->flash('message', 'Budget updated successfully');

        return Redirect::route('budget');

    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        $this->authorize('view', $budget);

        $user = auth()->user();
        $budgets = $user->budgets;
        $incomes = $user->incomes; // Assuming a user has many incomes relationship
        return Inertia::render('Budget/Index', [
            'budgets' => $budgets,
            'incomes' => $incomes,
            'expense' => $budget,
            'update' => true
        ]);

    }


    /**
     * Display the Graph.
     */
    public function graph()
    {
        $chartData = $this->getUpdatedChartData();
        return Inertia::render('Budget/Graph', [
            'chartData' => $chartData,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        $this->authorize('update', $budget);
        $attributes = $this->validateBudget();

        $budget->update($attributes);

        //add flash message
        session()->flash('message', 'Budget was updated');

        return to_route('budget');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        //Delete the budget if it belongs to the user
        $this->authorize('delete', $budget);
        $budget->delete();
        session()->flash('message', 'Budget was deleted successfully');
        return Redirect::route('budget');

    }
}
