@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Gestion des Utilisateurs</h2>
        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
            {{ $users->count() }} membres au total
        </span>
    </div>

    @if(session('success'))
        <div class="m-6 p-4 bg-green-100 text-green-700 border-l-4 border-green-500 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-4 text-gray-600 font-semibold uppercase text-xs">Utilisateur</th>
                    <th class="p-4 text-gray-600 font-semibold uppercase text-xs">Email</th>
                    <th class="p-4 text-gray-600 font-semibold uppercase text-xs text-center">Plan Actuel</th>
                    <th class="p-4 text-gray-600 font-semibold uppercase text-xs text-center">Changer le Plan</th>
                    <th class="p-4 text-gray-600 font-semibold uppercase text-xs text-right">Inscrit le</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold mr-3 uppercase">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <span class="font-medium text-gray-900">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="p-4 text-gray-600 text-sm italic">{{ $user->email }}</td>
                    <td class="p-4 text-center">
                        @php
                            $colors = [
                                'basic' => 'bg-gray-100 text-gray-700',
                                'premium' => 'bg-blue-100 text-blue-700',
                                'vip' => 'bg-amber-100 text-amber-700 border border-amber-200'
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $colors[$user->plan ?? 'basic'] }}">
                            {{ $user->plan ?? 'basic' }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <form action="{{ route('admin.users.updatePlan', $user->id) }}" method="POST" class="inline-flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="plan" onchange="this.form.submit()" class="text-xs border rounded p-1 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="basic" {{ $user->plan == 'basic' ? 'selected' : '' }}>Passer en Basic</option>
                                <option value="premium" {{ $user->plan == 'premium' ? 'selected' : '' }}>Passer en Premium</option>
                                <option value="vip" {{ $user->plan == 'vip' ? 'selected' : '' }}>Passer en VIP 👑</option>
                            </select>
                        </form>
                    </td>
                    <td class="p-4 text-right text-gray-500 text-xs">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection