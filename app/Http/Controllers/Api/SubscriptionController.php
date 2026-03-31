<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    // Client : souscrire à un plan
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $user = $request->user();
        $plan = Plan::findOrFail($validated['plan_id']);

        // Vérifier si l'utilisateur a déjà un abonnement actif
        $existing = Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now())
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Vous avez déjà un abonnement actif.',
                'subscription' => $existing->load('plan'),
            ], 422);
        }

        $subscription = Subscription::create([
            'user_id'    => $user->id,
            'plan_id'    => $plan->id,
            'status'     => 'pending', // devient active après paiement
            'start_date' => null,
            'end_date'   => null,
        ]);

        return response()->json([
            'message'      => 'Souscription créée, en attente de paiement',
            'subscription' => $subscription->load('plan'),
        ], 201);
    }

    // Client : voir mon abonnement actif
    public function mySubscription(Request $request): JsonResponse
    {
        $subscription = Subscription::where('user_id', $request->user()->id)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now())
            ->with('plan')
            ->first();

        if (!$subscription) {
            return response()->json([
                'message' => 'Aucun abonnement actif',
            ], 404);
        }

        return response()->json($subscription);
    }

    // Admin : activer un abonnement après paiement
    public function activate(Request $request, Subscription $subscription): JsonResponse
    {
        $subscription->update([
            'status'     => 'active',
            'start_date' => now(),
            'end_date'   => Carbon::now()->addMonth(),
        ]);

        return response()->json([
            'message'      => 'Abonnement activé',
            'subscription' => $subscription->load('plan'),
        ]);
    }

    // Admin : voir tous les abonnements
    public function index(): JsonResponse
    {
        $subscriptions = Subscription::with(['user', 'plan'])
            ->latest()
            ->get();

        return response()->json($subscriptions);
    }
}