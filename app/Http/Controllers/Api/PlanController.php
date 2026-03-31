<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PlanController extends Controller
{
    // Tous : voir les plans disponibles
    public function index(): JsonResponse
    {
        $plans = Plan::where('is_active', true)->get();
        return response()->json($plans);
    }

    // Admin : créer un plan
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:basic,premium,vip',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $plan = Plan::create($validated);

        return response()->json([
            'message' => 'Plan créé avec succès',
            'plan'    => $plan,
        ], 201);
    }

    // Admin : modifier un plan
    public function update(Request $request, Plan $plan): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'nullable|string|max:255',
            'price'       => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ]);

        $plan->update($validated);

        return response()->json([
            'message' => 'Plan mis à jour',
            'plan'    => $plan,
        ]);
    }
}