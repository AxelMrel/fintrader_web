@extends('layouts.admin')

@section('page-title', 'Détail du contrat #' . $contract->id)
@section('page-subtitle', 'Gérer ce contrat')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header actions --}}
    <div class="flex justify-between items-center">
        <a href="{{ route('admin.contracts.index') }}"
           class="flex items-center gap-2 text-gray-500 hover:text-gray-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux contrats
        </a>

        {{-- Actions selon statut --}}
        <div class="flex gap-3">
            @if($contract->status === 'pending')
                <form action="{{ route('admin.contracts.activate', $contract) }}" method="POST">
                    @csrf @method('PUT')
                    <button class="bg-green-500 hover:bg-green-400 text-white font-semibold px-4 py-2 rounded-lg transition">
                        ✓ Activer le contrat
                    </button>
                </form>
                <form action="{{ route('admin.contracts.cancel', $contract) }}" method="POST"
                      onsubmit="return confirm('Annuler ce contrat ?')">
                    @csrf @method('PUT')
                    <button class="bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-4 py-2 rounded-lg transition">
                        Annuler
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Infos client + statut --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Client --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Client</h3>
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center">
                    <span class="text-slate-600 font-bold">
                        {{ strtoupper(substr($contract->client->first_name, 0, 1)) }}
                    </span>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">
                        {{ $contract->client->first_name }} {{ $contract->client->last_name }}
                    </p>
                    <p class="text-sm text-gray-500">{{ $contract->client->email }}</p>
                </div>
            </div>
            <p class="text-sm text-gray-500">{{ $contract->client->phone ?? 'Pas de téléphone' }}</p>
        </div>

        {{-- Statut --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Statut</h3>
            <span class="text-sm font-semibold px-3 py-1.5 rounded-full
                {{ $contract->status === 'pending'   ? 'bg-yellow-100 text-yellow-700' : '' }}
                {{ $contract->status === 'active'    ? 'bg-green-100 text-green-700'   : '' }}
                {{ $contract->status === 'closed'    ? 'bg-gray-100 text-gray-700'     : '' }}
                {{ $contract->status === 'cancelled' ? 'bg-red-100 text-red-700'       : '' }}">
                {{ ucfirst($contract->status) }}
            </span>
            @if($contract->start_date)
            <div class="mt-3 space-y-1">
                <p class="text-sm text-gray-500">Début : <span class="font-medium text-gray-700">{{ $contract->start_date->format('d/m/Y') }}</span></p>
                <p class="text-sm text-gray-500">Fin : <span class="font-medium text-gray-700">{{ $contract->end_date->format('d/m/Y') }}</span></p>
            </div>
            @endif
        </div>

        {{-- Performance --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Performance</h3>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Capital initial</span>
                    <span class="font-semibold">{{ number_format($contract->capital, 2) }} {{ $contract->currency }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Capital actuel</span>
                    <span class="font-semibold">{{ number_format($contract->current_capital ?? $contract->capital, 2) }} {{ $contract->currency }}</span>
                </div>
                <div class="flex justify-between text-sm border-t border-gray-100 pt-2">
                    <span class="text-gray-500">Profit/Perte</span>
                    <span class="font-bold {{ $contract->profit_loss >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $contract->profit_loss >= 0 ? '+' : '' }}{{ number_format($contract->profit_loss, 2) }} {{ $contract->currency }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Détails du contrat --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-700 mb-4">Conditions du contrat</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-gray-800">{{ $contract->duration_months }}</p>
                <p class="text-xs text-gray-500 mt-1">Mois de durée</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-gray-800">{{ $contract->investor_share }}%</p>
                <p class="text-xs text-gray-500 mt-1">Part investisseur</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-gray-800">{{ $contract->early_withdrawal_penalty }}%</p>
                <p class="text-xs text-gray-500 mt-1">Pénalité retrait</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-gray-800">{{ $contract->capital_protection }}%</p>
                <p class="text-xs text-gray-500 mt-1">Protection capital</p>
            </div>
        </div>
    </div>

    {{-- Mise à jour performance (si actif) --}}
    @if($contract->status === 'active')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Update performance --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Mettre à jour la performance</h3>
            <form action="{{ route('admin.contracts.performance', $contract) }}" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Capital actuel ({{ $contract->currency }})
                    </label>
                    <input type="number" name="current_capital" step="0.01"
                           value="{{ $contract->current_capital }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <button class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 rounded-lg transition">
                    Mettre à jour
                </button>
            </form>
        </div>

        {{-- Clôture --}}
        <div class="bg-white rounded-xl shadow-sm border border-red-100 p-6">
            <h3 class="font-semibold text-red-700 mb-4">Clôturer le contrat</h3>
            <form action="{{ route('admin.contracts.close', $contract) }}" method="POST" class="space-y-4"
                  onsubmit="return confirm('Clôturer définitivement ce contrat ?')">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Capital final ({{ $contract->currency }})
                    </label>
                    <input type="number" name="current_capital" step="0.01"
                           value="{{ $contract->current_capital }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-red-400">
                </div>
                <button class="w-full bg-red-500 hover:bg-red-400 text-white font-semibold py-2.5 rounded-lg transition">
                    Clôturer le contrat
                </button>
            </form>
        </div>
    </div>
    @endif

    {{-- PDF --}}
    @if($contract->pdf_path)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="font-medium text-gray-800">Contrat PDF</p>
                <p class="text-sm text-gray-500">Signé le {{ $contract->accepted_at?->format('d/m/Y') }}</p>
            </div>
        </div>
        <a href="{{ asset('storage/' . $contract->pdf_path) }}" target="_blank"
           class="bg-slate-900 hover:bg-slate-800 text-white font-semibold px-4 py-2 rounded-lg transition text-sm">
            Télécharger PDF
        </a>
    </div>
    @endif

</div>
@endsection