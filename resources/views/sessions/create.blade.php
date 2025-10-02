@extends('Layouts.index')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-primary-500 to-cyan-400 bg-clip-text text-transparent">
                        Add Session
                    </h1>
                    <p class="text-gray-400 mt-2">Create a new trading session</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('sessions.index') }}"
                        class="bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 transition-all duration-300">
                        <i class="fas fa-arrow-left text-primary-500 mr-2"></i>
                        <span>Back to Sessions</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Form Container -->
        <div class="max-w-2xl mx-auto">
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl overflow-hidden">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-700/50 bg-dark-800/50">
                    <div class="flex items-center">
                        <div class="bg-primary-500/20 p-3 rounded-xl mr-4">
                            <i class="fas fa-plus text-primary-500 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold">Create New Session</h2>
                            <p class="text-gray-400 text-sm mt-1">Define session hours in NY Time</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('sessions.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-300">
                                <i class="fas fa-tag mr-2 text-primary-500"></i>Session Name
                            </label>
                            <input type="text" name="name"
                                class="w-full bg-dark-800 border border-primary-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                                placeholder="e.g., London Session, NY Session" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="start_hour" class="block text-sm font-medium text-gray-300">
                                    <i class="fas fa-clock mr-2 text-green-500"></i>Start Hour (0-23, NY Time)
                                </label>
                                <input type="number" name="start_hour" min="0" max="23"
                                    class="w-full bg-dark-800 border border-green-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                    required>
                            </div>

                            <div class="space-y-2">
                                <label for="end_hour" class="block text-sm font-medium text-gray-300">
                                    <i class="fas fa-clock mr-2 text-red-500"></i>End Hour (0-23, NY Time)
                                </label>
                                <input type="number" name="end_hour" min="0" max="23"
                                    class="w-full bg-dark-800 border border-red-700/30 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-700/50">
                        <a href="{{ route('sessions.index') }}"
                            class="flex items-center text-gray-400 hover:text-gray-300 transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Sessions
                        </a>
                        <button type="submit"
                            class="bg-gradient-to-r from-primary-600 to-cyan-600 hover:from-primary-700 hover:to-cyan-700 text-white font-semibold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Save Session
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Custom input styles */
        input[type="text"],
        input[type="number"] {
            background-color: #1e293b;
            border-color: #475569;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            background-color: #1e293b;
            border-color: #0ea5e9;
        }
    </style>
@endsection
