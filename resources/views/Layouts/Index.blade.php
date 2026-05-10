<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Default Title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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
    <style>
        .risk-level-card {
            cursor: pointer;
        }

        .risk-level-card:hover .risk-level-content {
            transform: translateY(-2px);
            border-color: currentColor;
        }

        .risk-level-content {
            border-radius: 12px;
            padding: 12px 8px;
            text-align: center;
        }

        .risk-percent-radio:checked+.risk-level-content {
            border-width: 3px;
            border-color: currentColor;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
            transform: scale(1.05);
        }

        /* Animasi untuk card metrics */
        .group:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        @keyframes scrollText {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }
    </style>

    <style>
        /* Simple scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        .dark .overflow-x-auto::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        .dark .overflow-x-auto::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
        }

        .overflow-y-auto::-webkit-scrollbar {
            width: 8px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        .dark .overflow-y-auto::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        .dark .overflow-y-auto::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
        }

        /* Hover effects for tables */
        tr:hover {
            background-color: rgba(55, 65, 81, 0.3);
        }

        .dark tr:hover {
            background-color: rgba(200, 200, 200, 0.3);
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Inline script to prevent theme flash -->
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>

<body
    class="bg-gradient-to-br from-pink-100 via-purple-100 to-blue-200 text-gray-900 dark:from-dark-900 dark:to-primary-900 dark:text-gray-200 font-sans min-h-screen">
    <!-- running text -->
    @include('components.running-text')

    <!-- Content placeholder -->
    <div class="container mx-auto py-1">
        @yield('content')

        @include('components.floating-note-form')
        @include('components.language-switcher')
    </div>

    <!-- Theme Switch Script -->
    <script>
        // Theme Switch Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const themeSwitch = document.getElementById('themeSwitch');
            const themeIcon = document.getElementById('themeIcon');
            const html = document.documentElement;

            // Set initial icon based on current theme
            const currentTheme = localStorage.getItem('theme') || 'dark';
            themeIcon.className = currentTheme === 'dark' ? 'fas fa-moon text-lg' : 'fas fa-sun text-lg';

            // Toggle theme on button click
            themeSwitch.addEventListener('click', function() {
                if (html.classList.contains('dark')) {
                    // Currently dark, switch to light
                    html.classList.remove('dark');
                    themeIcon.className = 'fas fa-sun text-lg';
                    localStorage.setItem('theme', 'light');
                } else {
                    // Currently light, switch to dark
                    html.classList.add('dark');
                    themeIcon.className = 'fas fa-moon text-lg';
                    localStorage.setItem('theme', 'dark');
                }
            });
        });
    </script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Untuk menampilkan success/error message dari session
        @if (session('success'))
            Swal.fire({
                icon: '{{ session('icon') ?? 'success' }}',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                position: 'top-end',
                toast: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33'
            });
        @endif
    </script>

    <script>
        // Script ini berjalan sebelum halaman berpindah
        (function() {
            // Simpan state nav ke sessionStorage saat link diklik
            document.addEventListener('DOMContentLoaded', function() {
                const links = document.querySelectorAll('a[href]');

                links.forEach(link => {
                    link.addEventListener('click', function(e) {
                        // Hanya untuk link internal (tidak eksternal atau anchor)
                        if (this.href && !this.target && this.href.startsWith(window.location
                                .origin)) {
                            const navState = localStorage.getItem('navVisible');
                            sessionStorage.setItem('navVisibleTemp', navState);
                        }
                    });
                });
            });

            // Restore state dari sessionStorage saat halaman dimuat
            window.addEventListener('load', function() {
                const tempState = sessionStorage.getItem('navVisibleTemp');

                if (tempState !== null) {
                    localStorage.setItem('navVisible', tempState);
                    // Hapus temp storage
                    sessionStorage.removeItem('navVisibleTemp');
                }
            });
        })();
    </script>

    <div class="fixed bottom-6 right-[4.5rem] z-50" id="userInfo">
        <div
            class="flex items-center gap-2 bg-white/90 backdrop-blur-md rounded-2xl shadow-xl p-1 border border-white/20">
            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-user-astronaut text-white text-sm"></i>
                </div>
                <div class="hidden md:flex flex-col">
                    @auth
                        <span class="text-gray-800 font-semibold text-xs leading-tight">Selamat Datang,</span>
                        <span class="text-gray-600 font-medium text-sm leading-tight">
                            {{ explode(' ', Auth::user()->name)[0] }}
                        </span>
                    @else
                        <span class="text-gray-800 font-semibold text-xs leading-tight">Selamat Datang,</span>
                        <span class="text-gray-600 font-medium text-sm leading-tight">Tamu</span>
                    @endauth
                </div>
            </div>

            <div class="w-px h-8 bg-gray-200 mx-1"></div>

            <button id="logoutBtn"
                class="group relative bg-red-500 hover:bg-red-600 text-white w-9 h-9 rounded-xl transition-all duration-300 hover:shadow-lg flex items-center justify-center"
                title="Logout">
                <i class="fas fa-sign-out-alt text-sm group-hover:rotate-12 transition-transform"></i>
                <span
                    class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                    Keluar
                </span>
            </button>
        </div>
    </div>

    <!-- Theme Switch Button -->
    <button id="themeSwitch"
        class="fixed bottom-[1.7rem] right-6 z-50 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 w-10 h-10 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110">
        <i id="themeIcon" class="fas fa-moon text-lg"></i>
    </button>


    <script>
        document.getElementById('logoutBtn').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar dari sistem?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading
                    Swal.fire({
                        title: 'Sedang keluar...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch('{{ route('logout') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Content-Type': 'application/json'
                            },
                            credentials: 'same-origin'
                        })
                        .then(response => {
                            if (response.ok) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Anda telah keluar dari sistem',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = '/login';
                                });
                            } else {
                                throw new Error('Logout failed');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan. Silakan coba lagi.',
                                icon: 'error',
                                confirmButtonColor: '#dc2626'
                            });
                        });
                }
            });
        });
    </script>

    <!-- Page Specific Scripts -->
    @stack('scripts')

    <!-- Include Analysis Scripts -->
    @yield('scripts')
</body>

</html>
