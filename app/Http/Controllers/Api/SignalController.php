<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Signal;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SignalController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return response()->json(Signal::latest()->get());
        }

        $signals = Signal::where('status', 'active')
            ->latest()
            ->get();

        return response()->json($signals);
    }

    public function show(Signal $signal): JsonResponse
    {
        return response()->json($signal);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'pair'          => 'required|string|max:20',
            'direction'     => 'required|in:buy,sell',
            'entry_price'   => 'required|numeric',
            'take_profit'   => 'required|numeric',
            'stop_loss'     => 'required|numeric',
            'description'   => 'nullable|string',
            'plan_required' => 'required|in:basic,premium,vip',
        ]);

        $signal = Signal::create([
            ...$validated,
            'trader_id' => auth()->id() ?? 1,
            'status'    => 'active',
        ]);

        return response()->json([
            'message' => 'Signal créé',
            'signal'  => $signal,
        ], 201);
    }

    public function update(Request $request, Signal $signal): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'nullable|in:active,closed,cancelled',
            'result' => 'nullable|in:tp_hit,sl_hit,cancelled',
        ]);

        $signal->update($validated);

        return response()->json([
            'message' => 'Signal mis à jour',
            'signal'  => $signal,
        ]);
    }

    public function destroy(Signal $signal): JsonResponse
    {
        $signal->delete();

        return response()->json(['message' => 'Signal supprimé']);
    }
}