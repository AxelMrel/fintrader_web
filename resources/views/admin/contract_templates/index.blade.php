@extends('admin.layout')

@section('page-title', 'Modèles de contrats')
@section('page-subtitle', 'Gérer les modèles de contrats')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-semibold text-gray-700">Tous les modèles</h3>
    <a href="{{ route('admin.contract-templates.create') }}"
       class="bg-yellow-500 hover:bg-yellow-400 text-slate-900 font-semibold px-4 py-2 rounded-lg transition">
        + Nouveau modèle
    </a>
</div>

@if($templates->isEmpty())
    <div class="bg-white rounded-xl p-12 text-center shadow-sm">
        <p class="text-gray-400 text-lg">Aucun modèle de contrat pour le moment</p>
        <a href="{{ route('admin.contract-templates.create') }}"
           class="mt-4 inline-block bg-yellow-500 text-slate-900 font-semibold px-6 py-2 rounded-lg">
            Créer le premier modèle
        </a>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($templates as $template)
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            {{-- Header carte --}}
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h4 class="font-bold text-gray-800 text-lg">{{ $template->name }}</h4>
                    <p class="text-sm text-gray-500 mt-1">{{ $template->description }}</p>
                </div>
                <span class="{{ $template->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-xs font-semibold px-2.5 py-1 rounded-full">
                    {{ $template->is_active ? 'Actif' : 'Inactif' }}
                </span>
            </div>

            {{-- Infos clés --}}
            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Frais d'entrée</span>
                    <span class="font-semibold text-gray-800">{{ number_format($template->entry_fees, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Durée</span>
                    <span class="font-semibold text-gray-800">{{ $template->duration_months }} mois</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Partage bénéfices</span>
                    <span class="font-semibold text-gray-800">{{ $template->investor_share }}% / {{ $template->manager_share }}%</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Capital min</span>
                    <span class="font-semibold text-gray-800">{{ number_format($template->min_capital, 0, ',', ' ') }} {{ $template->currency }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Protection capital</span>
                    <span class="font-semibold text-gray-800">{{ $template->capital_protection }}%</span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-2 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.contract-templates.edit', $template) }}"
                   class="flex-1 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2 rounded-lg text-sm transition">
                    Modifier
                </a>
                <form action="{{ route('admin.contract-templates.destroy', $template) }}" method="POST"
                      onsubmit="return confirm('Supprimer ce modèle ?')">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-50 hover:bg-red-100 text-red-600 font-medium py-2 px-4 rounded-lg text-sm transition">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection