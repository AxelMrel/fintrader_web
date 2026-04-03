<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Signal;
use Illuminate\Http\Request;

class SignalController extends Controller
{
    public function index()
    {
        $signals = Signal::latest()->get();
        return view('admin.signals.index', compact('signals'));
    }

    public function create()
    {
        return view('admin.signals.create');
    }

    public function store(Request $request)
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

        Signal::create([
            ...$validated,
            'trader_id' => 1,
            'status'    => 'active',
        ]);

        return redirect()
            ->route('admin.signals.index')
            ->with('success', 'Signal créé avec succès !');
    }

    public function show(Signal $signal)
    {
        return view('admin.signals.show', compact('signal'));
    }

    public function destroy(Signal $signal)
    {
        $signal->delete();

        return redirect()
            ->route('admin.signals.index')
            ->with('success', 'Signal supprimé !');
    }

    public function edit(Signal $signal)
    {
        return view('admin.signals.edit', compact('signal'));
    }

public function update(Request $request, Signal $signal)
{
    $validated = $request->validate([
        'pair'          => 'required|string|max:20',
        'direction'     => 'required|in:buy,sell',
        'entry_price'   => 'required|numeric',
        'take_profit'   => 'required|numeric',
        'stop_loss'     => 'required|numeric',
        'description'   => 'nullable|string',
        'plan_required' => 'required|in:basic,premium,vip',
        'status'        => 'required|in:active,closed,cancelled',
    ]);

    $signal->update($validated);

    return redirect()
        ->route('admin.signals.index')
        ->with('success', 'Signal mis à jour !');
}
}