<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        // Get the weekly, monthly and yearly spent and income
        $weeklySpent = $this->weeklySpent();
        $weeklyIncome = $this->weeklyIncome();
        $weeklyLeft = $weeklyIncome - $weeklySpent;
        $monthlySpent = $this->monthlySpent();
        $monthlyIncome = $this->monthlyIncome();
        $monthlyLeft = $monthlyIncome - $monthlySpent;
        $yearlySpent = $this->yearlySpent();
        $yearlyIncome = $this->yearlyIncome();
        $yearlyLeft = $yearlyIncome - $yearlySpent;

        //Get Charts
        $weeklyBarChart = $this->BarChart($weeklySpent,$weeklyIncome);
        $monthlyBarChart = $this->BarChart($monthlySpent,$monthlyIncome);
        $yearlyBarChart = $this->BarChart($yearlySpent,$yearlyIncome);

        return Inertia::render('Dashboard', [
            'weeklySpent' => $weeklySpent,
            'weeklyIncome' => $weeklyIncome,
            'weeklyLeft' => $weeklyLeft,
            'monthlySpent' => $monthlySpent,
            'monthlyIncome' => $monthlyIncome,
            'monthlyLeft' => $monthlyLeft,
            'yearlySpent' => $yearlySpent,
            'yearlyIncome' => $yearlyIncome,
            'yearlyLeft' => $yearlyLeft,
            'chartData' => $weeklyBarChart,
            'MonthlychartData' => $monthlyBarChart,
            'YearlychartData' => $yearlyBarChart,
        ]);
    }

    /**
     * Do the total calculation for the budget
     * Total spent, remaining amount, etc
     * How much is left for the month
     * How much is left for the week
     * How mush is left for the year
     * Salary for the year minus total spent
     */

    //Weekly Spent
    public function weeklySpent()
    {
        $user = auth()->user();
        $budgets = $user->budgets; // Assuming a user has many budgets relationship

        // Calculate totalSpent for the week from the budgets table, frequency is weekly, filter by due_date so that it matches the current week
        return $budgets->where('frequency', 'weekly')->whereBetween('due_date', [now()->startOfWeek(), now()->endOfWeek()])->sum('amount');
    }

    //Weekly income
    public function weeklyIncome()
    {
        $user = auth()->user();
        $incomes = $user->incomes; // Assuming a user has many incomes relationship

        // Fetch or calculate the weekly income from the incomes table, frequency is weekly from the current week
        return $incomes->where('frequency', 'weekly')->whereBetween('pay_date', [now()->startOfWeek(), now()->endOfWeek()])->sum('amount');
    }

    //Monthly Spent
    public function monthlySpent(){
        $user = auth()->user();
        $budgets = $user->budgets; // Assuming a user has many budgets relationship

        // Calculate totalSpent for the month from the budgets table, frequency is monthly, filter by due_date so that it matches the current month
        return $budgets->where('frequency', 'monthly')->whereBetween('due_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');
    }

    //Monthly income
    public function monthlyIncome(){
        $user = auth()->user();
        $incomes = $user->incomes; // Assuming a user has many incomes relationship

        //Calculate the monthly income by combing the weekly and monthly incomes in the current month
        $monthlyIncome = $incomes->where('frequency', 'monthly')->whereBetween('pay_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');
        $weeklyIncome = $incomes->where('frequency', 'weekly')->whereBetween('pay_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount') * 4;

        return $monthlyIncome + $weeklyIncome;
    }

    //Yearly Spent
    public function yearlySpent(){
        $user = auth()->user();
        $budgets = $user->budgets; // Assuming a user has many budgets relationship

        // Calculate totalSpent for the year from the budgets table, frequency is yearly, filter by due_date so that it matches the current year
        $totalSpent = $budgets->where('frequency', 'yearly')->whereBetween('due_date', [now()->startOfYear(), now()->endOfYear()])->sum('amount');

        //Need to add all the weekly and monthly budgets in the current year
        $totalSpent += $budgets->where('frequency', 'monthly')->whereBetween('due_date', [now()->startOfYear(), now()->endOfYear()])->sum('amount') * 12;
        $totalSpent += $budgets->where('frequency', 'weekly')->whereBetween('due_date', [now()->startOfYear(), now()->endOfYear()])->sum('amount') * 52;

        // Calculate remainingAmount
        return $totalSpent;
    }

    //Yearly income
    public function yearlyIncome(){
        $user = auth()->user();
        $incomes = $user->incomes; // Assuming a user has many incomes relationship

        // Fetch or calculate the yearly income from the incomes table, frequency is yearly from the current year
        $yearlyIncome = $incomes->where('frequency', 'yearly')->whereBetween('pay_date', [now()->startOfYear(), now()->endOfYear()])->sum('amount');
        //Need to add all the weekly and monthly incomes in the current year
        // Month times 12 and week times 52
        $monthlyIncome = $incomes->where('frequency', 'monthly')->whereBetween('pay_date', [now()->startOfYear(), now()->endOfYear()])->sum('amount') * 12;
        $weeklyIncome = $incomes->where('frequency', 'weekly')->whereBetween('pay_date', [now()->startOfYear(), now()->endOfYear()])->sum('amount') * 52;

        $yearlyIncome += $monthlyIncome + $weeklyIncome;
        return $yearlyIncome;
    }

    protected function BarChart($spent,$income)
    {

        // Remaining Amount for the week
        $remainingAmount = $income - $spent;

        //check to see if $remainingAmount is negative or positive
        if($remainingAmount < 0){
            $remainColor = 'rgba(255, 99, 132, 1)'; // Red for Remaining
        }else{
            $remainColor = 'rgba(5, 15, 251, 1)'; // blue for Remaining
        }

        // Generate chart data
        return [
            'labels' => ['Spent', 'Income', 'Remaining'],
            'datasets' => [
                [
                    'label' => 'Report',
                    'data' => [$spent, $income, $remainingAmount],
                    'backgroundColor' => [
                        'rgba(255, 206, 86, 1)' ,  // Yellow for Spent
                        'rgba(0, 100, 0, 1)',   // Green for Income
                        $remainColor   // Red for Remaining
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    'borderWidth' => 1
                ]
            ]
        ];
    }




}
