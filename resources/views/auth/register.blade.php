@extends('Layouts.auth')
@section('title', 'Register - ' . config('app.name', 'Journal Trade'))
@section('content')
    <div class="flex min-h-screen">
        <!-- Left Side: Trading Chart & Pairs -->
        <div
            class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0"
                    style="background-image: radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 50%);">
                </div>
            </div>

            <!-- VIGNETTE EFFECT - Shadow di tepi dalam -->
            <div class="absolute inset-0 pointer-events-none z-20"
                style="background: radial-gradient(ellipse at center, transparent 50%, rgba(0,0,0,0.6) 100%);">
            </div>

            <!-- Trading Chart Area -->
            <div class="relative z-10 w-full flex flex-col justify-between p-8">
                <!-- Header -->
                <div class="flex items-center space-x-3">
                    <div
                        class="h-10 w-10 bg-blue-500/20 rounded-xl flex items-center justify-center backdrop-blur-sm border border-blue-400/30">
                        <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <span class="text-white/70 text-sm font-mono tracking-wider">LIVE MARKET</span>
                    <span class="ml-auto flex items-center space-x-2">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-green-400 text-xs font-mono">● LIVE</span>
                    </span>
                </div>

                <!-- Chart Placeholder dengan Candlestick -->
                <div class="flex-1 flex items-center justify-center px-4">
                    <div class="w-full max-w-2xl">
                        <!-- Simulasi Candlestick Chart dengan Canvas -->
                        <div class="relative h-64 w-full">
                            <canvas id="candlestickChart" class="w-full h-full rounded-lg"></canvas>

                            <!-- Label Pair -->
                            <div
                                class="absolute top-0 left-0 bg-black/40 backdrop-blur-sm px-3 py-1 rounded-lg border border-white/10">
                                <span class="text-green-400 font-mono text-sm font-bold" id="pairPrice">XAUUSD</span>
                                <span class="text-white/60 text-xs ml-2" id="pairChange">+0.85%</span>
                            </div>
                        </div>

                        <!-- Pairs Ticker -->
                        <div class="mt-4 grid grid-cols-4 gap-2">
                            <div class="bg-white/5 backdrop-blur-sm rounded-lg p-2 border border-white/10 hover:bg-white/10 transition-colors cursor-pointer"
                                data-pair="GBPUSD">
                                <div class="flex items-center justify-between">
                                    <span class="text-white/80 text-xs font-mono font-bold">GBPUSD</span>
                                    <span class="text-green-400 text-xs font-mono" id="price-gbpusd">1.2645</span>
                                </div>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-white/40 text-[10px]" id="change-gbpusd">+0.23%</span>
                                    <span class="text-green-400 text-[10px]" id="arrow-gbpusd">▲</span>
                                </div>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-lg p-2 border border-white/10 hover:bg-white/10 transition-colors cursor-pointer"
                                data-pair="XAUUSD">
                                <div class="flex items-center justify-between">
                                    <span class="text-white/80 text-xs font-mono font-bold">XAUUSD</span>
                                    <span class="text-green-400 text-xs font-mono" id="price-xauusd">2,035.80</span>
                                </div>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-white/40 text-[10px]" id="change-xauusd">+0.85%</span>
                                    <span class="text-green-400 text-[10px]" id="arrow-xauusd">▲</span>
                                </div>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-lg p-2 border border-white/10 hover:bg-white/10 transition-colors cursor-pointer"
                                data-pair="EURUSD">
                                <div class="flex items-center justify-between">
                                    <span class="text-white/80 text-xs font-mono font-bold">EURUSD</span>
                                    <span class="text-red-400 text-xs font-mono" id="price-eurusd">1.0852</span>
                                </div>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-white/40 text-[10px]" id="change-eurusd">-0.12%</span>
                                    <span class="text-red-400 text-[10px]" id="arrow-eurusd">▼</span>
                                </div>
                            </div>
                            <div class="bg-white/5 backdrop-blur-sm rounded-lg p-2 border border-white/10 hover:bg-white/10 transition-colors cursor-pointer"
                                data-pair="BTCUSD">
                                <div class="flex items-center justify-between">
                                    <span class="text-white/80 text-xs font-mono font-bold">BTCUSD</span>
                                    <span class="text-green-400 text-xs font-mono" id="price-btcusd">43,245</span>
                                </div>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-white/40 text-[10px]" id="change-btcusd">+2.34%</span>
                                    <span class="text-green-400 text-[10px]" id="arrow-btcusd">▲</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Info -->
                <div class="flex items-center justify-between text-white/40 text-xs font-mono mt-4">
                    <span id="lastUpdate">Last update: {{ now()->format('H:i:s') }}</span>
                    <span class="flex items-center space-x-4">
                        <span id="tradeCount">● {{ number_format(rand(100, 500)) }}</span>
                        <span id="tradeVolume">Volume: {{ number_format(rand(1000, 9999)) }}</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Right Side: Register Form -->
        <div class="flex-1 flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8 bg-white overflow-y-auto">
            <div class="max-w-md w-full space-y-6">
                <!-- Header dengan efek gradien -->
                <div class="text-center">
                    <div
                        class="mx-auto h-16 w-16 bg-gradient-to-r from-green-600 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg transform rotate-3 hover:rotate-0 transition-transform duration-300">
                        <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <h2
                        class="text-4xl font-extrabold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                        Join Now
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">Create a new account and start your trading journey
                        professionally</p>
                </div>

                <!-- Form dengan efek glassmorphism -->
                <form action="{{ route('register') }}" method="POST" class="mt-6 space-y-4">
                    @csrf

                    <!-- Name Field dengan ikon -->
                    <div class="space-y-1">
                        <label for="name" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-500 transition-colors duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                autofocus
                                class="block w-full pl-10 pr-3 py-2.5 border-2 rounded-xl shadow-sm transition-all duration-200
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                            @error('name') border-red-500 bg-red-50 @else border-gray-300 hover:border-gray-400 @enderror"
                                placeholder="Masukkan nama lengkap Anda">
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email Field dengan ikon -->
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-semibold text-gray-700">Alamat Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-500 transition-colors duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="block w-full pl-10 pr-3 py-2.5 border-2 rounded-xl shadow-sm transition-all duration-200
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                            @error('email') border-red-500 bg-red-50 @else border-gray-300 hover:border-gray-400 @enderror"
                                placeholder="nama@perusahaan.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Field dengan ikon dan toggle visibility -->
                    <div class="space-y-1">
                        <label for="password" class="block text-sm font-semibold text-gray-700">Kata Sandi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-500 transition-colors duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="block w-full pl-10 pr-10 py-2.5 border-2 rounded-xl shadow-sm transition-all duration-200
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                            @error('password') border-red-500 bg-red-50 @else border-gray-300 hover:border-gray-400 @enderror"
                                placeholder="Buat kata sandi yang kuat">
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <!-- Password strength indicator -->
                        <div class="mt-1.5">
                            <div class="flex items-center space-x-2">
                                <div class="flex-1 h-1 bg-gray-200 rounded-full overflow-hidden">
                                    <div id="passwordStrength"
                                        class="h-full w-0 transition-all duration-300 rounded-full"></div>
                                </div>
                                <span id="strengthText" class="text-xs text-gray-500 min-w-[50px] text-right"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Password Confirmation Field dengan ikon -->
                    <div class="space-y-1">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Konfirmasi
                            Kata Sandi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-500 transition-colors duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="block w-full pl-10 pr-3 py-2.5 border-2 rounded-xl shadow-sm transition-all duration-200
                            focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent border-gray-300 hover:border-gray-400"
                                placeholder="Konfirmasi kata sandi Anda">
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="terms" name="terms" required
                                class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500 focus:ring-2 transition duration-200 mt-0.5">
                        </div>
                        <label for="terms"
                            class="ml-2 block text-sm text-gray-700 cursor-pointer hover:text-gray-900 transition-colors">
                            Saya menyetujui <a href="#"
                                class="text-green-600 hover:text-green-500 font-medium">Syarat & Ketentuan</a> dan <a
                                href="#" class="text-green-600 hover:text-green-500 font-medium">Kebijakan
                                Privasi</a>
                        </label>
                    </div>

                    <!-- Submit Button dengan efek hover modern -->
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 transform hover:scale-105">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-green-300 group-hover:text-green-200 transition-colors duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </span>
                        Daftar Sekarang
                    </button>

                    <!-- Divider -->
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">atau daftar dengan</span>
                        </div>
                    </div>

                    <!-- Social Registration Buttons -->
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button"
                            class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 hover:shadow-md">
                            <svg class="h-5 w-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z" />
                            </svg>
                            Google
                        </button>
                        <button type="button"
                            class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200 hover:shadow-md">
                            <svg class="h-5 w-5 mr-2 text-blue-800" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22,12c0-5.523-4.477-10-10-10S2,6.477,2,12c0,4.991,3.657,9.128,8.438,9.879v-6.99h-2.54V12h2.54V9.797c0-2.506,1.492-3.89,3.777-3.89c1.094,0,2.238,0.195,2.238,0.195v2.46h-1.26c-1.243,0-1.63,0.771-1.63,1.562V12h2.773l-0.443,2.89h-2.33v6.99C18.343,21.128,22,16.991,22,12z" />
                            </svg>
                            Facebook
                        </button>
                    </div>
                </form>

                <!-- Login Link dengan animasi -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="font-semibold text-green-600 hover:text-green-500 transition-all duration-200 hover:underline decoration-2 underline-offset-2">
                            Masuk Sekarang
                            <svg class="inline-block h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Toggle password visibility for password field
            document.getElementById('togglePassword')?.addEventListener('click', function() {
                const passwordInput = document.getElementById('password');
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Change icon
                const eyeIcon = this.querySelector('svg');
                if (type === 'text') {
                    eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
                } else {
                    eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
                }
            });

            // Password strength checker
            const passwordInput = document.getElementById('password');
            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('strengthText');

            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    let strength = 0;
                    let color = '';
                    let text = '';

                    if (password.length >= 8) strength++;
                    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
                    if (password.match(/[0-9]/)) strength++;
                    if (password.match(/[^a-zA-Z0-9]/)) strength++;

                    switch (strength) {
                        case 0:
                        case 1:
                            color = 'bg-red-500';
                            text = 'Lemah';
                            strengthBar.style.width = '25%';
                            break;
                        case 2:
                            color = 'bg-yellow-500';
                            text = 'Sedang';
                            strengthBar.style.width = '50%';
                            break;
                        case 3:
                            color = 'bg-blue-500';
                            text = 'Kuat';
                            strengthBar.style.width = '75%';
                            break;
                        case 4:
                            color = 'bg-green-500';
                            text = 'Sangat Kuat';
                            strengthBar.style.width = '100%';
                            break;
                    }

                    if (password.length === 0) {
                        strengthBar.style.width = '0%';
                        strengthText.textContent = '';
                    } else {
                        strengthBar.className = `h-full transition-all duration-300 rounded-full ${color}`;
                        strengthText.textContent = text;
                    }
                });
            }

            // ============================================
            // CANDLESTICK CHART WITH OHLC ANIMATION
            // ============================================
            (function() {
                const canvas = document.getElementById('candlestickChart');
                if (!canvas) return;

                const ctx = canvas.getContext('2d');

                // Canvas sizing
                function resizeCanvas() {
                    const rect = canvas.parentElement.getBoundingClientRect();
                    canvas.width = rect.width * window.devicePixelRatio;
                    canvas.height = rect.height * window.devicePixelRatio;
                    canvas.style.width = rect.width + 'px';
                    canvas.style.height = rect.height + 'px';
                    ctx.scale(window.devicePixelRatio, window.devicePixelRatio);
                }
                resizeCanvas();

                // Chart configuration
                const config = {
                    width: canvas.parentElement.clientWidth || 600,
                    height: canvas.parentElement.clientHeight || 256,
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 10,
                        right: 10
                    },
                    candles: 60,
                    candleWidth: 0,
                    gap: 2,
                    animationSpeed: 30, // Frames per second
                };

                // Data generation
                let priceData = [];
                let currentPrice = 2035.80;

                // Animation state
                let isAnimating = false;
                let animationQueue = [];
                let currentAnimation = null;

                function generateInitialData() {
                    priceData = [];
                    let price = currentPrice;
                    for (let i = 0; i < config.candles; i++) {
                        const change = (Math.random() - 0.5) * 4;
                        const open = price;
                        const close = price + change;
                        const high = Math.max(open, close) + Math.random() * 2;
                        const low = Math.min(open, close) - Math.random() * 2;
                        priceData.push({
                            open,
                            high,
                            low,
                            close,
                            // For animation
                            currentHigh: high,
                            currentLow: low,
                            currentClose: close,
                            animating: false
                        });
                        price = close;
                    }
                    currentPrice = priceData[priceData.length - 1].close;
                }
                generateInitialData();

                // Find min and max price for scaling
                function getPriceRange() {
                    let min = Infinity;
                    let max = -Infinity;
                    priceData.forEach(candle => {
                        min = Math.min(min, candle.low);
                        max = Math.max(max, candle.high);
                    });
                    const padding = (max - min) * 0.1;
                    return {
                        min: min - padding,
                        max: max + padding
                    };
                }

                // Draw grid
                function drawGrid(priceRange) {
                    const {
                        min,
                        max
                    } = priceRange;
                    const chartHeight = config.height - config.padding.top - config.padding.bottom;
                    const chartWidth = config.width - config.padding.left - config.padding.right;

                    ctx.strokeStyle = '#334155';
                    ctx.lineWidth = 0.5;
                    ctx.setLineDash([4, 4]);

                    // Horizontal grid lines (5 lines)
                    for (let i = 0; i < 5; i++) {
                        const y = config.padding.top + (i / 4) * chartHeight;
                        ctx.beginPath();
                        ctx.moveTo(config.padding.left, y);
                        ctx.lineTo(config.width - config.padding.right, y);
                        ctx.stroke();

                        // Price labels
                        const price = max - (i / 4) * (max - min);
                        ctx.fillStyle = '#475569';
                        ctx.font = '10px monospace';
                        ctx.textAlign = 'right';
                        ctx.fillText(price.toFixed(2), config.padding.left - 5, y + 3);
                    }

                    ctx.setLineDash([]);
                }

                // Draw candlesticks with animation support
                function drawCandles(priceRange) {
                    const {
                        min,
                        max
                    } = priceRange;
                    const chartHeight = config.height - config.padding.top - config.padding.bottom;
                    const chartWidth = config.width - config.padding.left - config.padding.right;

                    const candleCount = priceData.length;
                    const totalGap = (candleCount - 1) * config.gap;
                    config.candleWidth = (chartWidth - totalGap) / candleCount;

                    if (config.candleWidth < 2) config.candleWidth = 2;

                    // Draw MA lines first
                    drawMovingAverages(priceRange);

                    // Draw candles
                    priceData.forEach((candle, index) => {
                        const x = config.padding.left + index * (config.candleWidth + config.gap);
                        const xCenter = x + config.candleWidth / 2;

                        // Scale price to y coordinate
                        const scaleY = (price) => {
                            return config.padding.top + chartHeight - ((price - min) / (max - min)) *
                                chartHeight;
                        };

                        // Use animated values if animating
                        const open = candle.open;
                        const close = candle.animating ? candle.currentClose : candle.close;
                        const high = candle.animating ? candle.currentHigh : candle.high;
                        const low = candle.animating ? candle.currentLow : candle.low;

                        const yOpen = scaleY(open);
                        const yClose = scaleY(close);
                        const yHigh = scaleY(high);
                        const yLow = scaleY(low);

                        const isBullish = close >= open;
                        const color = isBullish ? '#22c55e' : '#ef4444';

                        // Draw wick (high-low line)
                        ctx.strokeStyle = color;
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(xCenter, yHigh);
                        ctx.lineTo(xCenter, yLow);
                        ctx.stroke();

                        // Draw candle body
                        const bodyTop = Math.min(yOpen, yClose);
                        const bodyBottom = Math.max(yOpen, yClose);
                        const bodyHeight = Math.max(bodyBottom - bodyTop, 1);

                        ctx.fillStyle = color;
                        ctx.fillRect(x, bodyTop, config.candleWidth, bodyHeight);

                        // Border for better visibility
                        ctx.strokeStyle = isBullish ? '#16a34a' : '#dc2626';
                        ctx.lineWidth = 0.5;
                        ctx.strokeRect(x, bodyTop, config.candleWidth, bodyHeight);
                    });
                }

                // Draw moving averages
                function drawMovingAverages(priceRange) {
                    const {
                        min,
                        max
                    } = priceRange;
                    const chartHeight = config.height - config.padding.top - config.padding.bottom;

                    // SMA 10
                    const sma10 = [];
                    for (let i = 0; i < priceData.length; i++) {
                        if (i < 9) {
                            sma10.push(null);
                            continue;
                        }
                        let sum = 0;
                        for (let j = i - 9; j <= i; j++) {
                            sum += priceData[j].close;
                        }
                        sma10.push(sum / 10);
                    }

                    // SMA 20
                    const sma20 = [];
                    for (let i = 0; i < priceData.length; i++) {
                        if (i < 19) {
                            sma20.push(null);
                            continue;
                        }
                        let sum = 0;
                        for (let j = i - 19; j <= i; j++) {
                            sum += priceData[j].close;
                        }
                        sma20.push(sum / 20);
                    }

                    const scaleY = (price) => {
                        return config.padding.top + chartHeight - ((price - min) / (max - min)) * chartHeight;
                    };

                    // Draw SMA 10 (blue)
                    ctx.strokeStyle = '#3b82f6';
                    ctx.lineWidth = 2;
                    ctx.globalAlpha = 0.7;
                    ctx.beginPath();
                    let started = false;
                    sma10.forEach((value, index) => {
                        if (value === null) return;
                        const x = config.padding.left + index * (config.candleWidth + config.gap) + config
                            .candleWidth / 2;
                        const y = scaleY(value);
                        if (!started) {
                            ctx.moveTo(x, y);
                            started = true;
                        } else {
                            ctx.lineTo(x, y);
                        }
                    });
                    ctx.stroke();
                    ctx.globalAlpha = 1;

                    // Draw SMA 20 (purple)
                    ctx.strokeStyle = '#8b5cf6';
                    ctx.lineWidth = 2;
                    ctx.globalAlpha = 0.7;
                    ctx.beginPath();
                    started = false;
                    sma20.forEach((value, index) => {
                        if (value === null) return;
                        const x = config.padding.left + index * (config.candleWidth + config.gap) + config
                            .candleWidth / 2;
                        const y = scaleY(value);
                        if (!started) {
                            ctx.moveTo(x, y);
                            started = true;
                        } else {
                            ctx.lineTo(x, y);
                        }
                    });
                    ctx.stroke();
                    ctx.globalAlpha = 1;

                    // Legend
                    ctx.font = '10px monospace';
                    ctx.fillStyle = '#3b82f6';
                    ctx.textAlign = 'left';
                    ctx.fillText('MA 10', config.width - config.padding.right - 100, config.padding.top + 15);
                    ctx.fillStyle = '#8b5cf6';
                    ctx.fillText('MA 20', config.width - config.padding.right - 50, config.padding.top + 15);
                }

                // Update price and change display
                function updatePriceDisplay() {
                    const lastCandle = priceData[priceData.length - 1];
                    const firstCandle = priceData[0];
                    const change = ((lastCandle.close - firstCandle.open) / firstCandle.open) * 100;
                    const isPositive = change >= 0;

                    const priceElement = document.getElementById('pairPrice');
                    const changeElement = document.getElementById('pairChange');

                    if (priceElement) {
                        priceElement.textContent = 'XAUUSD ' + lastCandle.close.toFixed(2);
                    }
                    if (changeElement) {
                        changeElement.textContent = (isPositive ? '+' : '') + change.toFixed(2) + '%';
                        changeElement.className = 'text-white/60 text-xs ml-2 ' + (isPositive ? 'text-green-400' :
                            'text-red-400');
                    }
                }

                // Animate a new candle (like TradingView)
                function animateNewCandle() {
                    const lastCandle = priceData[priceData.length - 1];

                    // Generate the final values for the new candle
                    const change = (Math.random() - 0.45) * 4;
                    const finalOpen = lastCandle.close;
                    const finalClose = finalOpen + change;
                    const finalHigh = Math.max(finalOpen, finalClose) + Math.random() * 2;
                    const finalLow = Math.min(finalOpen, finalClose) - Math.random() * 2;

                    // Create the new candle with animation data
                    const newCandle = {
                        open: finalOpen,
                        high: finalHigh,
                        low: finalLow,
                        close: finalClose,
                        // Animation state
                        currentHigh: finalOpen,
                        currentLow: finalOpen,
                        currentClose: finalOpen,
                        animating: true,
                        // Animation progress
                        progress: 0,
                        // Store final values
                        targetHigh: finalHigh,
                        targetLow: finalLow,
                        targetClose: finalClose,
                    };

                    // Add to price data
                    priceData.push(newCandle);

                    // Remove oldest if exceeds limit
                    if (priceData.length > config.candles) {
                        priceData.shift();
                    }

                    // Animate the candle
                    const duration = 60; // frames (about 2 seconds at 30fps)
                    let frame = 0;

                    function animateFrame() {
                        frame++;
                        const progress = Math.min(frame / duration, 1);

                        // Ease in-out function for smooth animation
                        const ease = progress < 0.5 ?
                            2 * progress * progress :
                            1 - Math.pow(-2 * progress + 2, 2) / 2;

                        // Update the candle values
                        newCandle.currentClose = finalOpen + (finalClose - finalOpen) * ease;
                        newCandle.currentHigh = finalOpen + (finalHigh - finalOpen) * ease;
                        newCandle.currentLow = finalOpen + (finalLow - finalOpen) * ease;

                        // Add some wick animation (high moves up, low moves down)
                        if (progress > 0.3) {
                            const wickProgress = (progress - 0.3) / 0.7;
                            newCandle.currentHigh = finalOpen + (finalHigh - finalOpen) * Math.min(wickProgress * 1.5, 1);
                            newCandle.currentLow = finalOpen + (finalLow - finalOpen) * Math.min(wickProgress * 1.5, 1);
                        }

                        // Render the chart
                        render();

                        if (progress < 1) {
                            requestAnimationFrame(animateFrame);
                        } else {
                            // Finalize the candle
                            newCandle.currentHigh = finalHigh;
                            newCandle.currentLow = finalLow;
                            newCandle.currentClose = finalClose;
                            newCandle.animating = false;

                            // Update price display
                            updatePriceDisplay();
                            updatePairTickers();

                            // Render final frame
                            render();

                            // Check if there are more animations in queue
                            if (animationQueue.length > 0) {
                                const nextCandle = animationQueue.shift();
                                addNewCandle(nextCandle);
                            } else {
                                isAnimating = false;
                            }
                        }
                    }

                    // Start animation
                    isAnimating = true;
                    animateFrame();
                }

                // Add new candle to queue
                function addNewCandle(candleData = null) {
                    if (isAnimating) {
                        // Queue the candle for later
                        if (candleData) {
                            animationQueue.push(candleData);
                        } else {
                            animationQueue.push(null);
                        }
                        return;
                    }

                    // If there's a queue, process it
                    if (animationQueue.length > 0) {
                        const nextCandle = animationQueue.shift();
                        // Process the queued candle
                        setTimeout(() => {
                            animateNewCandle();
                        }, 100);
                        return;
                    }

                    animateNewCandle();
                }

                // Update pair tickers with random changes
                function updatePairTickers() {
                    const pairs = [{
                            id: 'gbpusd',
                            base: 1.2645,
                            volatility: 0.005
                        },
                        {
                            id: 'xauusd',
                            base: 4035.80,
                            volatility: 5
                        },
                        {
                            id: 'eurusd',
                            base: 1.0852,
                            volatility: 0.004
                        },
                        {
                            id: 'btcusd',
                            base: 62245,
                            volatility: 200
                        }
                    ];

                    pairs.forEach(pair => {
                        const change = (Math.random() - 0.45) * 0.5;
                        const newPrice = pair.base * (1 + change / 100);
                        const isPositive = change >= 0;

                        const priceEl = document.getElementById('price-' + pair.id);
                        const changeEl = document.getElementById('change-' + pair.id);
                        const arrowEl = document.getElementById('arrow-' + pair.id);

                        if (priceEl) {
                            priceEl.textContent = pair.id === 'btcusd' ?
                                Math.round(newPrice).toLocaleString() :
                                newPrice.toFixed(4);
                        }
                        if (changeEl) {
                            changeEl.textContent = (isPositive ? '+' : '') + change.toFixed(2) + '%';
                            changeEl.className = 'text-white/40 text-[10px] ' + (isPositive ? 'text-green-400' :
                                'text-red-400');
                        }
                        if (arrowEl) {
                            arrowEl.textContent = isPositive ? '▲' : '▼';
                            arrowEl.className = 'text-[10px] ' + (isPositive ? 'text-green-400' : 'text-red-400');
                        }
                    });
                }

                // Main render function
                function render() {
                    const priceRange = getPriceRange();
                    ctx.clearRect(0, 0, config.width, config.height);

                    // Background
                    ctx.fillStyle = 'transparent';
                    ctx.fillRect(0, 0, config.width, config.height);

                    drawGrid(priceRange);
                    drawCandles(priceRange);
                }

                // Initial render
                render();

                // Auto-update time
                function updateTime() {
                    const now = new Date();
                    const timeStr = now.toTimeString().split(' ')[0];
                    const timeElement = document.getElementById('lastUpdate');
                    if (timeElement) {
                        timeElement.textContent = 'Last update: ' + timeStr;
                    }
                }
                setInterval(updateTime, 1000);

                // Update trade stats randomly
                setInterval(() => {
                    const countEl = document.getElementById('tradeCount');
                    const volumeEl = document.getElementById('tradeVolume');
                    if (countEl) {
                        const count = Math.floor(Math.random() * 400) + 100;
                        countEl.textContent = '● ' + count.toLocaleString();
                    }
                    if (volumeEl) {
                        const volume = Math.floor(Math.random() * 9000) + 1000;
                        volumeEl.textContent = 'Volume: ' + volume.toLocaleString();
                    }
                }, 5000);

                // Handle resize
                function handleResize() {
                    resizeCanvas();
                    config.width = canvas.parentElement.clientWidth || 600;
                    config.height = canvas.parentElement.clientHeight || 256;
                    render();
                }

                window.addEventListener('resize', handleResize);

                // Generate first candle after initial load
                setTimeout(() => {
                    addNewCandle();
                }, 1000);

                // Then add new candles every 3-5 seconds
                setInterval(() => {
                    addNewCandle();
                }, 1000 + Math.random() * 2000);

            })();
        </script>
    @endpush
@endsection
