<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\SettingsController;

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('expenses', ExpenseController::class);
    Route::resource('income', IncomeController::class);
    Route::resource('budgets', BudgetController::class);
    Route::resource('goals', GoalController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('investments', InvestmentController::class);
    Route::resource('debts', DebtController::class);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/education', [EducationController::class, 'index'])->name('education.index');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/profile', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
});

require __DIR__ . '/auth.php';
