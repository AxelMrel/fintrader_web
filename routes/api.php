<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SignalController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\ContractController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
});

// Plans et modèles de contrats visibles sans connexion
Route::get('/plans',              [PlanController::class, 'index']);
Route::get('/contract-templates', [ContractController::class, 'templates']);

Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me',      [AuthController::class, 'me']);

    // Signaux - lecture pour tous
    Route::get('/signals',           [SignalController::class, 'index']);
    Route::get('/signals/{signal}',  [SignalController::class, 'show']);

    // Abonnements - client
    Route::post('/subscriptions',     [SubscriptionController::class, 'store']);
    Route::get('/subscriptions/mine', [SubscriptionController::class, 'mySubscription']);

    // Contrats - client
    Route::post('/contracts',           [ContractController::class, 'store']);
    Route::get('/contracts/mine',       [ContractController::class, 'myContracts']);
    Route::get('/contracts/{contract}', [ContractController::class, 'show']);


    // Statistiques de parrainage
    Route::get('/referral/stats', function (Request $request) {
        $user = $request->user()->load('referrals');
        return response()->json([
            'referral_code'    => $user->referral_code,
            'referral_balance' => $user->referral_balance,
            'total_referrals'  => $user->referrals->count(),
            'commissions'      => $user->referralCommissions()
                ->with('sourceUser', 'contract')
                ->latest()
                ->get(),
        ]);
    });

    Route::middleware('admin')->group(function () {

        // Signaux
        Route::post('/signals',             [SignalController::class, 'store']);
        Route::put('/signals/{signal}',     [SignalController::class, 'update']);
        Route::delete('/signals/{signal}',  [SignalController::class, 'destroy']);

        // Plans
        Route::post('/plans',        [PlanController::class, 'store']);
        Route::put('/plans/{plan}',  [PlanController::class, 'update']);

        // Abonnements
        Route::get('/subscriptions',                          [SubscriptionController::class, 'index']);
        Route::put('/subscriptions/{subscription}/activate', [SubscriptionController::class, 'activate']);

        // Contrats
        Route::get('/contracts',                               [ContractController::class, 'index']);
        Route::put('/contracts/{contract}/activate',          [ContractController::class, 'activate']);
        Route::put('/contracts/{contract}/performance',       [ContractController::class, 'updatePerformance']);
        Route::put('/contracts/{contract}/close',             [ContractController::class, 'close']);
        Route::put('/contracts/{contract}/cancel',            [ContractController::class, 'cancel']);
    });
});