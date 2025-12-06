@extends('Layouts.index')
@section('title', 'Edit Session')
@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <header class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary-500">
                        Edit Session
                    </h1>
                    <p class="text-gray-500 mt-1">Perbarui detail sesi perdagangan</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('sessions.index') }}"
                        class="flex items-center bg-gray-800 rounded-lg px-4 py-2 border border-gray-700 hover:border-primary-500 transition-colors">
                        <i class="fas fa-arrow-left text-primary-500 mr-2"></i>
                        <span>Kembali ke Sessions</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Form Container -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-gray-800 rounded-xl border border-gray-700">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-gray-700">
                    <div class="flex items-center">
                        <div class="bg-amber-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-edit text-amber-500"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold">Edit Session</h2>
                            <p class="text-gray-500 text-sm mt-1">Update jam session dalam NY Time</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content -->
                <form action="{{ route('sessions.update', $session) }}" method="POST" class="p-6">
                    @csrf @method('PUT')
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-300">
                                <i class="fas fa-tag mr-2 text-primary-500"></i>Nama Session
                            </label>
                            <input type="text" name="name" value="{{ $session->name }}"
                                class="w-full bg-gray-700/50 border border-gray-600 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500/50 transition-all duration-200"
                                placeholder="Contoh: London Session, NY Session" required>
                            @error('name')
                                <p class="text-red-400 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="start_hour" class="block text-sm font-medium text-gray-300">
                                    <i class="fas fa-play-circle mr-2 text-green-500"></i>Jam Mulai (0-23, NY Time)
                                </label>
                                <input type="number" name="start_hour" value="{{ $session->start_hour }}" min="0"
                                    max="23"
                                    class="w-full bg-gray-700/50 border border-gray-600 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500/50 transition-all duration-200"
                                    required>
                                @error('start_hour')
                                    <p class="text-red-400 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="end_hour" class="block text-sm font-medium text-gray-300">
                                    <i class="fas fa-stop-circle mr-2 text-red-500"></i>Jam Selesai (0-23, NY Time)
                                </label>
                                <input type="number" name="end_hour" value="{{ $session->end_hour }}" min="0"
                                    max="23"
                                    class="w-full bg-gray-700/50 border border-gray-600 rounded-lg py-3 px-4 text-gray-200 focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500/50 transition-all duration-200"
                                    required>
                                @error('end_hour')
                                    <p class="text-red-400 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Duration Preview -->
                        @php
                            $duration = $session->end_hour - $session->start_hour;
                            if ($duration < 0) {
                                $duration += 24;
                            }
                        @endphp
                        <div class="bg-gray-750 rounded-lg p-4 border border-gray-700/50">
                            <div class="flex items-center">
                                <div class="bg-primary-500/20 p-2 rounded-lg mr-3">
                                    <i class="fas fa-clock text-primary-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Durasi Session</p>
                                    <p class="text-base font-semibold">{{ $duration }} jam</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div
                        class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-6 border-t border-gray-700">
                        <a href="{{ route('sessions.index') }}"
                            class="flex items-center text-gray-400 hover:text-gray-300 transition-colors duration-200 w-full sm:w-auto justify-center sm:justify-start">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Sessions
                        </a>
                        <div class="flex gap-3 w-full sm:w-auto">
                            <button type="button" onclick="cancelEdit()"
                                class="bg-gray-700 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-lg flex items-center justify-center w-full sm:w-auto">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </button>
                            <button type="submit"
                                class="bg-amber-600 hover:bg-amber-700 text-white font-medium py-3 px-6 rounded-lg flex items-center justify-center w-full sm:w-auto">
                                <i class="fas fa-save mr-2"></i>
                                Update Session
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function cancelEdit() {
            Swal.fire({
                title: 'Batalkan Perubahan?',
                html: `
                    <div class="text-left text-sm">
                        <div class="bg-amber-900/20 p-4 rounded-lg mb-4 border border-amber-700/30">
                            <p class="font-bold mb-2 text-amber-300">Perubahan yang belum disimpan akan hilang</p>
                            <ul class="space-y-1 text-gray-300">
                                <li class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-amber-500 mr-2 text-xs"></i>
                                    <span>Semua perubahan pada session akan dibatalkan</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                `,
                icon: 'warning',
                iconColor: '#f59e0b',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fas fa-times mr-2"></i>Ya, Batalkan',
                cancelButtonText: '<i class="fas fa-arrow-left mr-2"></i>Kembali Edit',
                reverseButtons: true,
                customClass: {
                    popup: 'bg-gray-800 border border-amber-700/30',
                    title: 'text-amber-300',
                    htmlContainer: 'text-left'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('sessions.index') }}';
                }
            });
        }

        // Real-time validation for hour inputs
        document.addEventListener('DOMContentLoaded', function() {
            const startHourInput = document.querySelector('input[name="start_hour"]');
            const endHourInput = document.querySelector('input[name="end_hour"]');
            const durationDiv = document.querySelector('.bg-gray-750');

            function updateDurationPreview() {
                const startHour = parseInt(startHourInput.value) || 0;
                const endHour = parseInt(endHourInput.value) || 0;

                let duration = endHour - startHour;
                if (duration < 0) duration += 24;

                // Update duration display
                const durationText = durationDiv.querySelector('.text-base');
                if (durationText) {
                    durationText.textContent = `${duration} jam`;
                }

                // Add visual feedback
                if (duration <= 0) {
                    durationDiv.classList.add('border-red-500/30');
                    durationDiv.classList.remove('border-gray-700/50');
                } else {
                    durationDiv.classList.remove('border-red-500/30');
                    durationDiv.classList.add('border-gray-700/50');
                }
            }

            [startHourInput, endHourInput].forEach(input => {
                input.addEventListener('input', updateDurationPreview);
                input.addEventListener('change', updateDurationPreview);
            });

            // Initial update
            updateDurationPreview();
        });
    </script>

    <style>
        /* SweetAlert Custom Styles - Consistent with other pages */
        .swal2-popup {
            background: #1f2937 !important;
            border: 1px solid rgba(245, 158, 11, 0.3) !important;
            border-radius: 0.75rem !important;
        }

        .swal2-title {
            color: #fbbf24 !important;
            font-weight: 600 !important;
        }

        .swal2-confirm {
            background: #d33 !important;
            border: none !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1.5rem !important;
            font-weight: 500 !important;
        }

        .swal2-cancel {
            background-color: #374151 !important;
            border: 1px solid #4b5563 !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1.5rem !important;
            font-weight: 500 !important;
        }
    </style>
@endsection
