@extends('admin.layout')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Vue d\'ensemble de la plateforme')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    {{-- Clients --}}
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-blue-500 bg-blue-50 px-2 py-1 rounded-full">Clients</span>
        </div>
        <p class="text-3xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Clients inscrits</p>
    </div>

    {{-- Signaux --}}
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">
                {{ $stats['active_signals'] }} actifs
            </span>
        </div>
        <p class="text-3xl font-bold text-gray-800">{{ $stats['total_signals'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Signaux publiés</p>
    </div>

    {{-- Contrats --}}
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                {{ $stats['pending_contracts'] }} en attente
            </span>
        </div>
        <p class="text-3xl font-bold text-gray-800">{{ $stats['total_contracts'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Contrats total</p>
    </div>

    {{-- Abonnements --}}
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-1 rounded-full">Actifs</span>
        </div>
        <p class="text-3xl font-bold text-gray-800">{{ $stats['active_subscriptions'] }}</p>
        <p class="text-sm text-gray-500 mt-1">Abonnements actifs</p>
    </div>
</div>

{{-- Contrats en attente --}}
@if($stats['pending_contracts'] > 0)
<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6 flex items-center gap-3">
    <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>
    <p class="text-yellow-800 font-medium">
        {{ $stats['pending_contracts'] }} contrat(s) en attente de validation.
        <a href="{{ route('admin.contracts.index') }}" class="underline hover:text-yellow-900">Voir les contrats</a>
    </p>
</div>
@endif

{{-- Tableaux --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Derniers contrats --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-semibold text-gray-800">Derniers contrats</h3>
            <a href="{{ route('admin.contracts.index') }}" class="text-sm text-yellow-500 hover:underline">Voir tout</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($recent_contracts as $contract)
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <p class="font-medium text-gray-800 text-sm">
                        {{ $contract->client->first_name }} {{ $contract->client->last_name }}
                    </p>
                    <p class="text-xs text-gray-500">{{ number_format($contract->capital, 2) }} {{ $contract->currency }}</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                    {{ $contract->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $contract->status === 'active' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $contract->status === 'closed' ? 'bg-gray-100 text-gray-700' : '' }}
                    {{ $contract->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                    {{ ucfirst($contract->status) }}
                </span>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-400 text-sm">
                Aucun contrat pour le moment
            </div>
            @endforelse
        </div>
    </div>

    {{-- Derniers clients --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-semibold text-gray-800">Derniers clients</h3>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-yellow-500 hover:underline">Voir tout</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($recent_users as $user)
            <div class="px-6 py-4 flex items-center gap-3">
                <div class="w-9 h-9 bg-slate-100 rounded-full flex items-center justify-center shrink-0">
                    <span class="text-slate-600 font-semibold text-sm">
                        {{ strtoupper(substr($user->first_name, 0, 1)) }}
                    </span>
                </div>
                <div>
                    <p class="font-medium text-gray-800 text-sm">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </p>
                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                </div>
                <span class="ml-auto text-xs text-gray-400">
                    {{ $user->created_at->diffForHumans() }}
                </span>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-400 text-sm">
                Aucun client pour le moment
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection