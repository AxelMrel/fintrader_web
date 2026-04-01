<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\ContractTemplate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractController extends Controller
{
    // Client : voir les modèles disponibles
    public function templates(): JsonResponse
    {
        $templates = ContractTemplate::where('is_active', true)->get();
        return response()->json($templates);
    }

    // Client : souscrire à un modèle de contrat
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'contract_template_id' => 'required|exists:contract_templates,id',
            'capital'              => 'required|numeric|min:0',
            'client_accepted'      => 'required|boolean|in:1,true',
        ]);

        $template = ContractTemplate::findOrFail($validated['contract_template_id']);

        // Vérifier le capital minimum
        if ($validated['capital'] < $template->min_capital) {
            return response()->json([
                'message' => "Le capital minimum est de {$template->min_capital} {$template->currency}",
            ], 422);
        }

        // Vérifier capital maximum si défini
        if ($template->max_capital && $validated['capital'] > $template->max_capital) {
            return response()->json([
                'message' => "Le capital maximum est de {$template->max_capital} {$template->currency}",
            ], 422);
        }

        $contract = Contract::create([
        'client_id'                 => $request->user()->id,
        'contract_template_id'      => $template->id,
        'capital'                   => $validated['capital'],
        'currency'                  => $template->currency,
        'entry_fees'                => $template->entry_fees,
        'investor_share'            => $template->investor_share,
        'manager_share'             => $template->manager_share,
        'early_withdrawal_penalty'  => $template->early_withdrawal_penalty,
        'capital_protection'        => $template->capital_protection,
        'duration_months'           => $template->duration_months,
        'status'                    => 'pending',
        'client_accepted'           => true,
        'accepted_at'               => now(),
    ]);

    $contract->load('template', 'client');

    // Générer le PDF
    try {
        $pdf     = Pdf::loadView('pdf.contract', compact('contract'));
        $pdfPath = "contracts/contract_{$contract->id}.pdf";
        $pdf->save(storage_path("app/public/{$pdfPath}"));
        $contract->update(['pdf_path' => $pdfPath]);
    } catch (\Exception $e) {
        // Le contrat est créé même si le PDF échoue
        \Log::error('PDF generation failed: ' . $e->getMessage());
    }

    return response()->json([
        'message'  => 'Contrat soumis avec succès, en attente de validation',
        'contract' => $contract->load('template'),
        'pdf_url'  => $contract->pdf_path ? asset("storage/{$contract->pdf_path}") : null,
    ], 201);
    }

    // Client : voir mes contrats
    public function myContracts(Request $request): JsonResponse
    {
        $contracts = Contract::where('client_id', $request->user()->id)
            ->with('template')
            ->latest()
            ->get()
            ->map(function ($contract) {
                return [
                    'id'               => $contract->id,
                    'template_name'    => $contract->template->name,
                    'capital'          => $contract->capital,
                    'currency'         => $contract->currency,
                    'status'           => $contract->status,
                    'start_date'       => $contract->start_date,
                    'end_date'         => $contract->end_date,
                    'current_capital'  => $contract->current_capital,
                    'profit_loss'      => $contract->profit_loss,
                    'profit_percent'   => $contract->profitPercentage(),
                    'investor_profit'  => $contract->investorProfit(),
                    'pdf_url'          => $contract->pdf_path
                        ? asset("storage/{$contract->pdf_path}")
                        : null,
                ];
            });

        return response()->json($contracts);
    }

    // Client : voir un contrat en détail
    public function show(Contract $contract, Request $request): JsonResponse
    {
        if ($contract->client_id !== $request->user()->id && !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Accès refusé.'], 403);
        }

        return response()->json([
            'contract' => $contract->load('template'),
            'pdf_url'  => $contract->pdf_path
                ? asset("storage/{$contract->pdf_path}")
                : null,
        ]);
    }
}