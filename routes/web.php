<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SignalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ContractController;
use App\Http\Controllers\Admin\ContractTemplateController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\PlanController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->name('admin.')->middleware(['admin.web'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Signaux
    Route::get('/signals',             [SignalController::class, 'index'])->name('signals.index');
    Route::get('/signals/create',      [SignalController::class, 'create'])->name('signals.create');
    Route::post('/signals',            [SignalController::class, 'store'])->name('signals.store');
    Route::get('/signals/{signal}/edit',  [SignalController::class, 'edit'])->name('signals.edit');
    Route::put('/signals/{signal}',       [SignalController::class, 'update'])->name('signals.update');
    Route::get('/signals/{signal}',    [SignalController::class, 'show'])->name('signals.show');
    Route::delete('/signals/{signal}', [SignalController::class, 'destroy'])->name('signals.destroy');

    // Utilisateurs
    Route::get('/users',               [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/plan', [UserController::class, 'updatePlan'])->name('users.updatePlan');

    // Modèles de contrats
    Route::get('/contract-templates',                         [ContractTemplateController::class, 'index'])->name('contract-templates.index');
    Route::get('/contract-templates/create',                  [ContractTemplateController::class, 'create'])->name('contract-templates.create');
    Route::post('/contract-templates',                        [ContractTemplateController::class, 'store'])->name('contract-templates.store');
    Route::get('/contract-templates/{contractTemplate}/edit', [ContractTemplateController::class, 'edit'])->name('contract-templates.edit');
    Route::put('/contract-templates/{contractTemplate}',      [ContractTemplateController::class, 'update'])->name('contract-templates.update');
    Route::delete('/contract-templates/{contractTemplate}',   [ContractTemplateController::class, 'destroy'])->name('contract-templates.destroy');

    // Contrats
    Route::get('/contracts',                        [ContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/{contract}',             [ContractController::class, 'show'])->name('contracts.show');
    Route::put('/contracts/{contract}/activate',    [ContractController::class, 'activate'])->name('contracts.activate');
    Route::put('/contracts/{contract}/performance', [ContractController::class, 'updatePerformance'])->name('contracts.performance');
    Route::put('/contracts/{contract}/close',       [ContractController::class, 'close'])->name('contracts.close');
    Route::put('/contracts/{contract}/cancel',      [ContractController::class, 'cancel'])->name('contracts.cancel');

    // Plans d'abonnement
    Route::get('/plans',               [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create',        [PlanController::class, 'create'])->name('plans.create');
    Route::post('/plans',              [PlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/{plan}/edit',   [PlanController::class, 'edit'])->name('plans.edit');
    Route::put('/plans/{plan}',        [PlanController::class, 'update'])->name('plans.update');
    Route::delete('/plans/{plan}',     [PlanController::class, 'destroy'])->name('plans.destroy');

    // Souscriptions clients
    Route::get('/subscriptions',                         [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/create',                  [SubscriptionController::class, 'create'])->name('subscriptions.create');
    Route::post('/subscriptions',                        [SubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::get('/subscriptions/{subscription}',          [SubscriptionController::class, 'show'])->name('subscriptions.show');
    Route::get('/subscriptions/{subscription}/edit',     [SubscriptionController::class, 'edit'])->name('subscriptions.edit');
    Route::put('/subscriptions/{subscription}',          [SubscriptionController::class, 'update'])->name('subscriptions.update');
    Route::delete('/subscriptions/{subscription}',       [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');
    Route::put('/subscriptions/{subscription}/activate', [SubscriptionController::class, 'activate'])->name('subscriptions.activate');
});