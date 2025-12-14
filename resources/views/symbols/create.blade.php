@extends('Layouts.index')
@section('title', 'Create Symbol')
@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-primary-500 mb-4">Create Symbol</h1>

        <form action="{{ route('symbols.store') }}" method="POST" class="bg-gray-800 p-4 rounded-xl border border-gray-700">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-300">Name</label>
                    <input type="text" name="name" class="w-full bg-gray-900 p-2 rounded" required>
                </div>

                <div>
                    <label class="block text-sm text-gray-300">Pip Value</label>
                    <input type="number" step="0.00001" name="pip_value" class="w-full bg-gray-900 p-2 rounded" required>
                </div>

                <div>
                    <label class="block text-sm text-gray-300">Pip Worth (USD per pip per 1 lot)</label>
                    <input type="number" step="0.01" name="pip_worth" class="w-full bg-gray-900 p-2 rounded"
                        value="10">
                </div>

                <div>
                    <label class="block text-sm text-gray-300">Pip Position</label>
                    <input type="text" name="pip_position" class="w-full bg-gray-900 p-2 rounded"
                        placeholder="e.g. 4 or 2">
                </div>

                <div class="md:col-span-2">
                    <!-- Hidden input untuk nilai default false -->
                    <input type="hidden" name="active" value="0">

                    <label class="inline-flex items-center">
                        <input type="checkbox" name="active" value="1" {{ old('active', 1) ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-300">Active</span>
                    </label>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('symbols.index') }}" class="text-gray-400 mr-3">Cancel</a>
                <button class="bg-primary-600 px-4 py-2 rounded text-white">Create</button>
            </div>
        </form>
    </div>
@endsection
