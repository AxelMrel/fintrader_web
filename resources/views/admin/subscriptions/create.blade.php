@extends('admin.layout')

@section('page-title', 'Nouvel abonnement')
@section('page-subtitle', 'Créer un abonnement pour un client')

@section('content')

<div class="max-w-xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

        @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.subscriptions.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Client --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Client</label>
                <select name="user_id" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-slate-900">
                    <option value="">-- Sélectionner un client --</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->first_name }} {{ $user->last_name }} — {{ $user->email }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Plan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Plan</label>
                <select name="plan_id" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-slate-900">
                    <option value="">-- Sélectionner un plan --</option>
                    @foreach($plans as $plan)
                    <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                        {{ ucfirst($plan->type) }} — {{ number_format($plan->price, 0, ',', ' ') }} FCFA/mois
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Statut --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="status" required
                    class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-slate-900">
                    <option value="pending"   {{ old('status') === 'pending'   ? 'selected' : '' }}>En attente</option>
                    <option value="active"    {{ old('status') === 'active'    ? 'selected' : '' }}>Actif</option>
                    <option value="expired"   {{ old('status') === 'expired'   ? 'selected' : '' }}>Expiré</option>
                    <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>

            {{-- Boutons --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="bg-slate-900 hover:bg-slate-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition">
                    Créer l'abonnement
                </button>
                <a href="{{ route('admin.subscriptions.index') }}"
                    class="text-sm text-gray-500 hover:text-gray-700 transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@endsection