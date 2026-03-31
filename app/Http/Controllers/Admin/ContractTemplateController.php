<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContractTemplate;
use Illuminate\Http\Request;

class ContractTemplateController extends Controller
{
    public function index()
    {
        $templates = ContractTemplate::latest()->get();
        return view('admin.contract_templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.contract_templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                      => 'required|string|max:255',
            'description'               => 'nullable|string',
            'entry_fees'                => 'required|numeric|min:0',
            'duration_months'           => 'required|integer|min:1',
            'investor_share'            => 'required|numeric|min:0|max:100',
            'manager_share'             => 'required|numeric|min:0|max:100',
            'early_withdrawal_penalty'  => 'required|numeric|min:0|max:100',
            'capital_protection'        => 'required|numeric|min:0|max:100',
            'min_capital'               => 'required|numeric|min:0',
            'max_capital'               => 'nullable|numeric|min:0',
            'currency'                  => 'required|string|max:10',
            'terms'                     => 'required|string',
        ]);

        ContractTemplate::create($validated);

        return redirect()
            ->route('admin.contract-templates.index')
            ->with('success', 'Modèle de contrat créé avec succès !');
    }

    public function edit(ContractTemplate $contractTemplate)
    {
        return view('admin.contract_templates.edit', compact('contractTemplate'));
    }

    public function update(Request $request, ContractTemplate $contractTemplate)
    {
        $validated = $request->validate([
            'name'                      => 'required|string|max:255',
            'description'               => 'nullable|string',
            'entry_fees'                => 'required|numeric|min:0',
            'duration_months'           => 'required|integer|min:1',
            'investor_share'            => 'required|numeric|min:0|max:100',
            'manager_share'             => 'required|numeric|min:0|max:100',
            'early_withdrawal_penalty'  => 'required|numeric|min:0|max:100',
            'capital_protection'        => 'required|numeric|min:0|max:100',
            'min_capital'               => 'required|numeric|min:0',
            'max_capital'               => 'nullable|numeric|min:0',
            'currency'                  => 'required|string|max:10',
            'is_active'                 => 'boolean',
            'terms'                     => 'required|string',
        ]);

        $contractTemplate->update($validated);

        return redirect()
            ->route('admin.contract-templates.index')
            ->with('success', 'Modèle mis à jour !');
    }

    public function destroy(ContractTemplate $contractTemplate)
    {
        $contractTemplate->delete();

        return redirect()
            ->route('admin.contract-templates.index')
            ->with('success', 'Modèle supprimé !');
    }
}