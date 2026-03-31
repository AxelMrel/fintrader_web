@extends('admin.layout')

@section('page-title', 'Nouveau modèle de contrat')
@section('page-subtitle', 'Créer un nouveau modèle')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-8">

        <form action="{{ route('admin.contract-templates.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Nom --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom du modèle</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                       placeholder="Ex: Contrat Standard 6 mois">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                          placeholder="Description du contrat...">{{ old('description') }}</textarea>
            </div>

            {{-- Ligne 1 : Frais + Durée --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Frais d'entrée (FCFA)</label>
                    <input type="number" name="entry_fees" value="{{ old('entry_fees', 20000) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @error('entry_fees') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durée (mois)</label>
                    <input type="number" name="duration_months" value="{{ old('duration_months', 6) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @error('duration_months') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Ligne 2 : Partage bénéfices --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Part investisseur (%)</label>
                    <input type="number" name="investor_share" value="{{ old('investor_share', 50) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @error('investor_share') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Part gestionnaire (%)</label>
                    <input type="number" name="manager_share" value="{{ old('manager_share', 50) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @error('manager_share') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Ligne 3 : Pénalité + Protection --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pénalité retrait anticipé (%)</label>
                    <input type="number" name="early_withdrawal_penalty" value="{{ old('early_withdrawal_penalty', 30) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @error('early_withdrawal_penalty') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Protection capital (%)</label>
                    <input type="number" name="capital_protection" value="{{ old('capital_protection', 50) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @error('capital_protection') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Ligne 4 : Capital min/max --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Capital minimum (USD)</label>
                    <input type="number" name="min_capital" value="{{ old('min_capital', 0) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    @error('min_capital') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Capital maximum (USD) <span class="text-gray-400">optionnel</span></label>
                    <input type="number" name="max_capital" value="{{ old('max_capital') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
            </div>

            {{-- Devise --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Devise</label>
                <select name="currency"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD - Dollar américain</option>
                    <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                    <option value="XOF" {{ old('currency') == 'XOF' ? 'selected' : '' }}>XOF - Franc CFA</option>
                </select>
            </div>

            {{-- Conditions générales --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Conditions générales du contrat</label>
                <textarea name="terms" rows="8"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-yellow-400 font-mono text-sm"
                          placeholder="Saisir les conditions générales du contrat...">{{ old('terms') }}</textarea>
                @error('terms') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Boutons --}}
            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-400 text-slate-900 font-semibold px-6 py-2.5 rounded-lg transition">
                    Créer le modèle
                </button>
                <a href="{{ route('admin.contract-templates.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-2.5 rounded-lg transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
