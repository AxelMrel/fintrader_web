<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $query = Contract::with(['client', 'template'])->latest();

        if ($request->status && $request->status !== 'tous') {
            $query->where('status', $request->status);
        }

        $contracts = $query->get();

        return view('admin.contracts.index', compact('contracts'));
    }

    public function show(Contract $contract)
    {
        $contract->load(['client', 'template']);
        return view('admin.contracts.show', compact('contract'));
    }

    public function activate(Contract $contract)
    {
        $contract->update([
            'status'          => 'active',
            'start_date'      => now(),
            'end_date'        => Carbon::now()->addMonths($contract->duration_months),
            'current_capital' => $contract->capital,
        ]);

        return redirect()
            ->route('admin.contracts.index')
            ->with('success', 'Contrat activé !');
    }

    public function updatePerformance(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'current_capital' => 'required|numeric|min:0',
        ]);

        $profitLoss = $validated['current_capital'] - $contract->capital;

        $contract->update([
            'current_capital' => $validated['current_capital'],
            'profit_loss'     => $profitLoss,
        ]);

        return redirect()
            ->route('admin.contracts.show', $contract)
            ->with('success', 'Performance mise à jour !');
    }

    public function close(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'current_capital' => 'required|numeric|min:0',
        ]);

        $profitLoss     = $validated['current_capital'] - $contract->capital;
        $managerProfit  = $profitLoss > 0
            ? ($profitLoss * $contract->manager_share / 100)
            : 0;
        $investorProfit = $profitLoss > 0
            ? ($profitLoss * $contract->investor_share / 100)
            : 0;

        $contract->update([
            'status'          => 'closed',
            'current_capital' => $validated['current_capital'],
            'profit_loss'     => $profitLoss,
            'end_date'        => now(),
        ]);

        return redirect()
            ->route('admin.contracts.index')
            ->with('success', "Contrat clôturé ! Votre part : {$managerProfit} USD | Part client : {$investorProfit} USD");
    }

    public function cancel(Contract $contract)
    {
        $contract->update(['status' => 'cancelled']);

        return redirect()
            ->route('admin.contracts.index')
            ->with('success', 'Contrat annulé.');
    }
}