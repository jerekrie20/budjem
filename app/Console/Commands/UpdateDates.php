<?php

namespace App\Console\Commands;

use App\Models\Budget;
use App\Models\Income;
use Illuminate\Console\Command;

class UpdateDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update due and pay dates based on frequencies';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Update due dates for budgets
        $transactions = Budget::all();

        foreach ($transactions as $transaction) {
            //get Current date
            $currentDate = new \DateTime($transaction->due_date);
            //Check if Date is in the past and update
            if ($currentDate < new \DateTime()) {
                //get updated date
                $updatedDate = $this->getUpdatedDate($currentDate, $transaction->frequency);
                //update date
                $transaction->due_date = $updatedDate->format('Y-m-d');

                $transaction->save();
            }

        }

        // Update pay dates for incomes
        $incomes = Income::all();

        foreach ($incomes as $income) {
            $currentDate = new \DateTime($income->pay_date);
            if ($currentDate < new \DateTime()) {
                $updatedDate = $this->getUpdatedDate($currentDate, $income->frequency);
                $income->pay_date = $updatedDate->format('Y-m-d');
                $income->save();
            }
        }

        $this->info('Dates have been updated!');
    }

    private function getUpdatedDate($currentDate, $frequency)
    {
        switch (strtolower($frequency)) {
            case 'monthly':
                return $currentDate->modify('+1 month');
            case 'weekly':
                return $currentDate->modify('+1 week');
            case 'yearly':
                return $currentDate->modify('+1 year');
            default:
                return $currentDate;
        }
    }
}
