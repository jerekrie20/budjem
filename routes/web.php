<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {return Inertia::render('Dashboard');})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //Profile Actions
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Budget Actions

    //Expenses
    Route::get('/budget', [BudgetController::class,'index'])->name('budget');
    Route::post('/budget/store', [BudgetController::class,'store'])->name('budget.store');
    Route::get('/budget/show/{budget}', [BudgetController::class, 'show'])->name('budget.show');
    Route::put('/budget/update/{budget}', [BudgetController::class, 'update'])->name('budget.update');
    Route::get('/budget/destroy/{budget}', [BudgetController::class, 'destroy'])->name('budget.destroy');

    Route::get('/graph',[BudgetController::class,'graph'])->name('graph');

    //Income
    Route::post('/income/store', [IncomeController::class,'store'])->name('income.store');
    Route::get('/income/show/{income}', [IncomeController::class,'show'])->name('income.show');
    Route::put('/income/update/{income}', [IncomeController::class,'update'])->name('income.update');
    Route::get('/income/destroy/{income}', [IncomeController::class,'destroy'])->name('income.destroy');
});

require __DIR__.'/auth.php';
