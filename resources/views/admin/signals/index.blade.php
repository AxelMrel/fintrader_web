@extends('admin.layout')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Tous les Signaux</h2>
        <a href="{{ route('admin.signals.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Nouveau Signal
        </a>
    </div>

    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b">
                <th class="p-3 text-gray-600 font-semibold text-sm">Paire</th>
                <th class="p-3 text-gray-600 font-semibold text-sm">Direction</th>
                <th class="p-3 text-gray-600 font-semibold text-sm">Entrée</th>
                <th class="p-3 text-gray-600 font-semibold text-sm">TP / SL</th>
                <th class="p-3 text-gray-600 font-semibold text-sm">Plan</th>
                <th class="p-3 text-gray-600 font-semibold text-sm">Statut</th>
                <th class="p-3 text-gray-600 font-semibold text-sm text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($signals as $signal)
            <tr class="border-b hover:bg-gray-50 transition">
                <td class="p-3 font-bold text-slate-800">{{ $signal->pair }}</td>
                <td class="p-3">
                    <span class="px-2 py-1 rounded text-xs font-bold uppercase {{ $signal->direction == 'buy' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $signal->direction }}
                    </span>
                </td>
                <td class="p-3 text-sm">{{ $signal->entry_price }}</td>
                <td class="p-3 text-sm">
                    <span class="text-green-600">{{ $signal->take_profit }}</span> / 
                    <span class="text-red-600">{{ $signal->stop_loss }}</span>
                </td>
                <td class="p-3 text-sm italic">{{ ucfirst($signal->plan_required) }}</td>
                <td class="p-3">
                    <span class="px-2 py-1 rounded-full text-[10px] {{ $signal->status == 'active' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-700' }}">
                        {{ $signal->status }}
                    </span>
                </td>
                <td class="p-3 text-center">
                    <button class="text-blue-500 hover:text-blue-700 mr-2 text-sm">Modifier</button>
                    <form action="{{ route('admin.signals.destroy', $signal->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm" onclick="return confirm('Supprimer ce signal ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection