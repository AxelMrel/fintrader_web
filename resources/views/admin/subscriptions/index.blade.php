@extends('admin.layout')

@section('page-title', 'Abonnements')
@section('page-subtitle', 'Gérer les abonnements des clients')

@section('content')

{{-- Filtres --}}
<div class="flex gap-3 mb-6">
    @foreach(['tous' => 'Tous', 'pending' => 'En attente', 'active' => 'Actifs', 'expired' => 'Expirés', 'cancelled' => 'Annulés'] as $value => $label)
    <a href="{{ request()->fullUrlWithQuery(['status' => $value]) }}"
       class="px-4 py-2 rounded-lg text-sm font-medium transition
       {{ request('status', 'tous') === $value
           ? 'bg-slate-900 text-white'
           : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
        {{ $label }}
    </a>
    @endforeach
    <a href="{{ route('admin.subscriptions.create') }}"
        class="bg-slate-900 hover:bg-slate-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        + Nouvel abonnement
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Client</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Plan</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Début</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fin</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($subscriptions as $subscription)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm text-gray-500">#{{ $subscription->id }}</td>

                {{-- Client --}}
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center">
                            <span class="text-slate-600 font-semibold text-xs">
                                {{ strtoupper(substr($subscription->user->first_name, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 text-sm">
                                {{ $subscription->user->first_name }} {{ $subscription->user->last_name }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $subscription->user->email }}</p>
                        </div>
                    </div>
                </td>

                {{-- Plan --}}
                <td class="px-6 py-4">
                    <span class="text-sm font-semibold px-2.5 py-1 rounded-full
                        {{ $subscription->plan->type === 'basic'   ? 'bg-gray-100 text-gray-700'     : '' }}
                        {{ $subscription->plan->type === 'premium' ? 'bg-blue-100 text-blue-700'     : '' }}
                        {{ $subscription->plan->type === 'vip'     ? 'bg-yellow-100 text-yellow-700' : '' }}">
                        {{ ucfirst($subscription->plan->type) }}
                    </span>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ number_format($subscription->plan->price, 0, ',', ' ') }} FCFA/mois
                    </p>
                </td>

                {{-- Statut --}}
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                        {{ $subscription->status === 'pending'   ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $subscription->status === 'active'    ? 'bg-green-100 text-green-700'   : '' }}
                        {{ $subscription->status === 'expired'   ? 'bg-gray-100 text-gray-700'     : '' }}
                        {{ $subscription->status === 'cancelled' ? 'bg-red-100 text-red-700'       : '' }}">
                        {{ ucfirst($subscription->status) }}
                    </span>
                </td>

                {{-- Dates --}}
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $subscription->start_date ? $subscription->start_date->format('d/m/Y') : '—' }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $subscription->end_date ? $subscription->end_date->format('d/m/Y') : '—' }}
                </td>

                {{-- Actions --}}
                <td class="px-6 py-4">
                    @if($subscription->status === 'pending')
                    <form action="{{ route('admin.subscriptions.activate', $subscription) }}" method="POST">
                        @csrf @method('PUT')
                        <button class="bg-green-500 hover:bg-green-400 text-white text-sm font-medium px-3 py-1.5 rounded-lg transition">
                            Activer
                        </button>
                    </form>
                    @else
                    <span class="text-gray-400 text-sm">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                    Aucun abonnement pour le moment
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection