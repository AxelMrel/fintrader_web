<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::withCount('subscriptions')->latest()->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:basic,premium,vip',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Plan::create([...$request->only('name', 'type', 'price', 'description'), 'is_active' => true]);

        return redirect()->route('admin.plans.index')->with('success', 'Plan créé avec succès !');
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|in:basic,premium,vip',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $plan->update([
            ...$request->only('name', 'type', 'price', 'description'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.plans.index')->with('success', 'Plan mis à jour !');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', 'Plan supprimé !');
    }
}