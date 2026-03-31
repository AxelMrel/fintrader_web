@extends('admin.layout')


@section('page-title', 'Contrats')
@section('page-subtitle', 'Gérer les demandes de contrats')

@section('content')

{{-- Filtres --}}
<div class="flex gap-3 mb-6">
    @foreach(['tous' => 'Tous', 'pending' => 'En attente', 'active' => 'Actifs', 'closed' => 'Clôturés', 'cancelled' => 'Annulés'] as $value => $label)
    <a href="{{ request()->fullUrlWithQuery(['status' => $value]) }}"
       class="px-4 py-2 rounded-lg text-sm font-medium transition
       {{ request('status', 'tous') === $value
           ? 'bg-slate-900 text-white'
           : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Client</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Modèle</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Capital</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($contracts as $contract)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm text-gray-500">#{{ $contract->id }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center">
                            <span class="text-slate-600 font-semibold text-xs">
                                {{ strtoupper(substr($contract->client->first_name, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 text-sm">
                                {{ $contract->client->first_name }} {{ $contract->client->last_name }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $contract->client->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">
                    {{ $contract->template->name }}
                </td>
                <td class="px-6 py-4">
                    <p class="text-sm font-semibold text-gray-800">
                        {{ number_format($contract->capital, 2) }} {{ $contract->currency }}
                    </p>
                    <p class="text-xs text-gray-500">
                        Frais : {{ number_format($contract->entry_fees, 0, ',', ' ') }} FCFA
                    </p>
                </td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                        {{ $contract->status === 'pending'   ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $contract->status === 'active'    ? 'bg-green-100 text-green-700'   : '' }}
                        {{ $contract->status === 'closed'    ? 'bg-gray-100 text-gray-700'     : '' }}
                        {{ $contract->status === 'cancelled' ? 'bg-red-100 text-red-700'       : '' }}">
                        {{ ucfirst($contract->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $contract->created_at->format('d/m/Y') }}
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.contracts.show', $contract) }}"
                       class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium px-3 py-1.5 rounded-lg transition">
                        Voir
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                    Aucun contrat pour le moment
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection