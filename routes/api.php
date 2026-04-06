<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SignalController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\ContractController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
});

Route::get('/plans',              [PlanController::class, 'index']);
Route::get('/contract-templates', [ContractController::class, 'templates']);


Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me',      [AuthController::class, 'me']);
    });

    Route::get('/signals',           [SignalController::class, 'index']);
    Route::get('/signals/{signal}',  [SignalController::class, 'show']);

    Route::post('/subscriptions',     [SubscriptionController::class, 'store']);
    Route::get('/subscriptions/mine', [SubscriptionController::class, 'mySubscription']);

    Route::post('/contracts',           [ContractController::class, 'store']);
    Route::get('/contracts/mine',       [ContractController::class, 'myContracts']);
    Route::get('/contracts/{contract}', [ContractController::class, 'show']);

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

    // // 3. ROUTES ADMINISTRATEUR (Nécessitent le middleware 'admin')
    // Route::middleware('admin')->group(function () {

    //     // Gestion des Signaux (URL: /api/signals)
    //     Route::post('/signals',             [SignalController::class, 'store']);
    //     Route::put('/signals/{signal}',     [SignalController::class, 'update']);
    //     Route::delete('/signals/{signal}',  [SignalController::class, 'destroy']);

    //     // Gestion des Plans (URL: /api/plans)
    //     Route::post('/plans',        [PlanController::class, 'store']);
    //     Route::put('/plans/{plan}',  [PlanController::class, 'update']);

    //     // Gestion des Abonnements (URL: /api/subscriptions)
    //     Route::get('/subscriptions',                         [SubscriptionController::class, 'index']);
    //     Route::put('/subscriptions/{subscription}/activate', [SubscriptionController::class, 'activate']);

    //     // Gestion des Contrats (URL: /api/contracts)
    //     Route::get('/contracts',                             [ContractController::class, 'index']);
    //     Route::put('/contracts/{contract}/activate',         [ContractController::class, 'activate']);
    //     Route::put('/contracts/{contract}/performance',      [ContractController::class, 'updatePerformance']);
    //     Route::put('/contracts/{contract}/close',            [ContractController::class, 'close']);
    //     Route::put('/contracts/{contract}/cancel',           [ContractController::class, 'cancel']);
    // });
});