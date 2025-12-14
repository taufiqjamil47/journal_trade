@extends('Layouts.index')
@section('title', 'Symbols')
@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-primary-500">Symbols</h1>
            <a href="{{ route('symbols.create') }}" class="bg-primary-600 text-white px-4 py-2 rounded">New Symbol</a>
        </div>

        @if (session('success'))
            <div class="mb-3 text-green-400">{{ session('success') }}</div>
        @endif

        <div class="bg-gray-800 rounded-xl p-4 border border-gray-700">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-gray-400 text-sm">
                        <th class="p-2">Name</th>
                        <th class="p-2">Pip Value</th>
                        <th class="p-2">Pip Worth</th>
                        <th class="p-2">Active</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($symbols as $s)
                        <tr class="border-t border-gray-700">
                            <td class="p-2">{{ $s->name }}</td>
                            <td class="p-2">{{ $s->pip_value }}</td>
                            <td class="p-2">{{ $s->pip_worth ?? 10 }}</td>
                            <td class="p-2">{{ $s->active ? 'Yes' : 'No' }}</td>
                            <td class="p-2">
                                <a href="{{ route('symbols.edit', $s->id) }}" class="text-amber-300 mr-3">Edit</a>
                                <form action="{{ route('symbols.destroy', $s->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete symbol?')" class="text-red-400">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
