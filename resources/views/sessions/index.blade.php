<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sessions - Trading Journal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            900: '#0c4a6e',
                        },
                        dark: {
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-dark-900 to-primary-900 font-sans text-gray-200 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-primary-500 to-cyan-400 bg-clip-text text-transparent">
                        Trading Sessions
                    </h1>
                    <p class="text-gray-400 mt-2">Manage your trading session hours</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}"
                        class="bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 transition-all duration-300">
                        <i class="fas fa-arrow-left text-primary-500 mr-2"></i>
                        <span>Back to Dashboard</span>
                    </a>
                    <a href="{{ route('sessions.create') }}"
                        class="bg-gradient-to-r from-primary-600 to-cyan-600 hover:from-primary-700 hover:to-cyan-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Add Session
                    </a>
                </div>
            </div>
        </header>

        <!-- Sessions Table -->
        <div
            class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b border-gray-700/50 bg-dark-800/50">
                <div class="flex items-center">
                    <div class="bg-primary-500/20 p-3 rounded-xl mr-4">
                        <i class="fas fa-clock text-primary-500 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold">Available Sessions</h2>
                        <p class="text-gray-400 text-sm mt-1">All trading sessions in NY Time</p>
                    </div>
                </div>
            </div>

            <!-- Table Content -->
            <div class="p-6">
                @if ($sessions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-400">
                            <thead class="text-xs uppercase bg-dark-800/50 text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        <i class="fas fa-tag mr-2"></i>Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <i class="fas fa-play-circle mr-2"></i>Start Hour (NY)
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <i class="fas fa-stop-circle mr-2"></i>End Hour (NY)
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        <i class="fas fa-cogs mr-2"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sessions as $s)
                                    <tr
                                        class="border-b border-gray-700/50 hover:bg-dark-800/30 transition-colors duration-200">
                                        <td class="px-6 py-4 font-medium whitespace-nowrap text-white">
                                            {{ $s->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="bg-green-500/20 text-green-400 py-1 px-3 rounded-full text-xs font-medium">
                                                {{ $s->start_hour }}:00
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="bg-red-500/20 text-red-400 py-1 px-3 rounded-full text-xs font-medium">
                                                {{ $s->end_hour }}:00
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('sessions.edit', $s) }}"
                                                    class="bg-amber-500/20 text-amber-500 hover:bg-amber-500/30 py-2 px-4 rounded-lg transition-all duration-200 flex items-center">
                                                    <i class="fas fa-edit mr-2"></i>
                                                    Edit
                                                </a>
                                                <form action="{{ route('sessions.destroy', $s) }}" method="POST"
                                                    class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-500/20 text-red-500 hover:bg-red-500/30 py-2 px-4 rounded-lg transition-all duration-200 flex items-center"
                                                        onclick="return confirm('Delete this session?')">
                                                        <i class="fas fa-trash mr-2"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="bg-dark-800/50 rounded-2xl p-8 max-w-md mx-auto border border-gray-700/30">
                            <div
                                class="bg-primary-500/20 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-clock text-primary-500 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">No Sessions Found</h3>
                            <p class="text-gray-400 mb-6">Get started by creating your first trading session</p>
                            <a href="{{ route('sessions.create') }}"
                                class="bg-gradient-to-r from-primary-600 to-cyan-600 hover:from-primary-700 hover:to-cyan-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg inline-flex items-center">
                                <i class="fas fa-plus mr-2"></i>
                                Create Session
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* Custom table styles */
        table {
            border-collapse: separate;
            border-spacing: 0;
        }

        th,
        td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        tr:last-child td {
            border-bottom: none;
        }
    </style>
</body>

</html>
