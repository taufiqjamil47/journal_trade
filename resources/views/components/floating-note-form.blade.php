<div id="floatingNoteContainer"
    class="fixed right-0 top-1/2 transform -translate-y-1/2 z-50 transition-all duration-300 ease-in-out"
    style="right: -400px;"> <!-- Default hidden -->


    <!-- Floating Button untuk Toggle -->
    <button id="toggleNoteForm"
        class="absolute origin-right left-0 top-1/2 transform -translate-y-1/2 -translate-x-full bg-primary-600 hover:bg-primary-700 text-white p-3 rounded-l-xl shadow-lg transition-all duration-300">
        <i id="toggleIcon"
            class="fas {{ session('note_form_hidden', true) ? 'fa-chevron-left' : 'fa-chevron-right' }} mr-3"></i>
    </button>
    <!-- Form Container -->
    <div class="bg-dark-800 w-96 h-[85vh] overflow-y-auto shadow-2xl border border-gray-700 rounded-l-lg">
        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-700">
                <h2 class="text-xl font-bold text-white">
                    <i class="fas fa-clipboard-check text-primary-500 mr-2"></i>
                    Formulir kalibrasi diri
                </h2>
                <span class="text-xs bg-primary-900 text-primary-200 px-2 py-1 rounded">TRADER</span>
            </div>

            <!-- Form -->
            <form id="noteForm" action="{{ route('notes.store') }}" method="POST">
                @csrf

                <!-- Bagian 0 - Aturan Meta -->
                <div class="mb-6 p-4 bg-primary-900/20 rounded-lg border border-primary-700/30">
                    <h3 class="font-bold text-primary-300 mb-2 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        — ATURAN META —
                    </h3>
                    <p class="text-sm text-gray-300 italic mb-3">(WAJIB DIBACA SETIAP HARI)</p>
                    <ul class="text-sm text-gray-300 space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-ban text-red-400 mr-2 mt-1"></i>
                            <span>Jika merasa "aku sudah berubah / lebih disiplin" → STOP TRADING 24 JAM</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-ban text-red-400 mr-2 mt-1"></i>
                            <span>Jika merasa bangga pada dirimu sebagai trader → STOP TRADING 48 JAM</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-skull-crossbones text-yellow-400 mr-2 mt-1"></i>
                            <span>Jika ingin membuktikan bahwa form ini berhasil → EGO SEDANG MEMIMPIN</span>
                        </li>
                    </ul>
                </div>

                <!-- Bagian 1 - Status Internal -->
                <div class="mb-6">
                    <h3 class="font-bold text-white mb-3">BAGIAN 1 — STATUS INTERNAL</h3>

                    <!-- Q1 -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">1. Kondisi batin dominan saat
                            ini:</label>
                        <div class="space-y-2">
                            @foreach (['Netral', 'Ingin membuktikan sesuatu', 'Gelisah / bosan', 'Tertekan / lelah', 'Terlalu percaya diri'] as $option)
                                <label class="flex items-center">
                                    <input type="radio" name="part_1_q1" value="{{ $option }}"
                                        class="mr-2 text-primary-600 focus:ring-primary-500">
                                    <span class="text-sm text-gray-300">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Q2 -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">2. Alasan sebenarnya membuka
                            chart:</label>
                        <div class="space-y-2">
                            @foreach (['Menjalankan proses', 'Takut ketinggalan', 'Mencari validasi diri', 'Kebiasaan / pelarian'] as $option)
                                <label class="flex items-center">
                                    <input type="radio" name="part_1_q2" value="{{ $option }}"
                                        class="mr-2 text-primary-600 focus:ring-primary-500">
                                    <span class="text-sm text-gray-300">{{ $option }}</span>
                                </label>
                            @endforeach
                            <div class="flex items-center">
                                <input type="radio" name="part_1_q2" value="Lainnya"
                                    class="mr-2 text-primary-600 focus:ring-primary-500">
                                <span class="text-sm text-gray-300 mr-2">Lainnya:</span>
                                <input type="text" name="part_1_q2_other"
                                    class="flex-1 bg-dark-700 border border-gray-600 rounded px-2 py-1 text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Q3 -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            3. Skala keterikatan ego hari ini (0–10):
                        </label>
                        <input type="range" name="part_1_q3" min="0" max="10" value="0"
                            class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer">
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>0 = hasil tidak berarti</span>
                            <span id="egoScaleValue" class="font-bold text-primary-400">0</span>
                            <span>10 = hasil menentukan harga diri</span>
                        </div>
                    </div>
                </div>

                <!-- Bagian 2 - Reaksi Market -->
                <div class="mb-6">
                    <h3 class="font-bold text-white mb-3">BAGIAN 2 — REAKSI TERHADAP MARKET</h3>

                    <!-- Q4 -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">4. Respons emosional pertama
                            saat
                            melihat chart:</label>
                        <div class="grid grid-cols-1 gap-2">
                            @foreach (['Tenang', 'Tertarik berlebihan', 'Ingin cepat entry', 'Merasa "aku tahu ini"', 'Tidak ada apa-apa'] as $option)
                                <label
                                    class="flex items-center p-2 bg-dark-700 rounded hover:bg-dark-600 cursor-pointer">
                                    <input type="radio" name="part_2_q4" value="{{ $option }}"
                                        class="mr-2 text-primary-600 focus:ring-primary-500">
                                    <span class="text-sm text-gray-300">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Q5 -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">5. Apakah muncul cerita/narasi
                            di
                            kepala?</label>
                        <div class="space-y-2 mb-3">
                            @foreach (['Tidak ada', 'Ada tapi lemah', 'Kuat dan meyakinkan'] as $option)
                                <label class="flex items-center">
                                    <input type="radio" name="part_2_q5" value="{{ $option }}"
                                        class="mr-2 text-primary-600 focus:ring-primary-500">
                                    <span class="text-sm text-gray-300">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                        <textarea name="part_2_q5_text" placeholder="Jika ada, tulis SATU kalimat tanpa pembenaran..."
                            class="w-full h-20 bg-dark-700 border border-gray-600 rounded px-3 py-2 text-sm text-gray-300 placeholder-gray-500 focus:outline-none focus:border-primary-500"></textarea>
                    </div>
                </div>

                <!-- Bagian 3 - Gerbang Anti-Ego -->
                <div class="mb-6 p-4 bg-red-900/20 rounded-lg border border-red-700/30">
                    <h3 class="font-bold text-red-300 mb-3 flex items-center">
                        <i class="fas fa-gate mr-2"></i>
                        BAGIAN 3 — GERBANG ANTI-EGO
                    </h3>
                    <p class="text-sm text-gray-300 mb-4 italic">(BINARY, TIDAK BISA DITAWAR)</p>

                    <div class="space-y-3">
                        @foreach ([['q' => 'part_3_q6', 'text' => '6. Jika aku tidak trading hari ini, apakah aku tetap merasa utuh sebagai diri sendiri?'], ['q' => 'part_3_q7', 'text' => '7. Jika trade ini loss, apakah aku tidak akan mencoba membalasnya hari ini?'], ['q' => 'part_3_q8', 'text' => '8. Apakah aku akan baik-baik saja jika setup ini profit di akun orang lain?'], ['q' => 'part_3_q9', 'text' => '9. Apakah keputusan hari ini tidak akan aku ceritakan ke siapa pun untuk validasi?']] as $item)
                            <div class="flex items-center justify-between p-3 bg-dark-700/50 rounded">
                                <span class="text-sm text-gray-300">{{ $item['text'] }}</span>
                                <div class="flex space-x-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="{{ $item['q'] }}" value="1"
                                            class="mr-1 text-green-500 focus:ring-green-500">
                                        <span class="text-sm text-green-400">YA</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="{{ $item['q'] }}" value="0"
                                            class="mr-1 text-red-500 focus:ring-red-500">
                                        <span class="text-sm text-red-400">TIDAK</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 p-3 bg-red-900/30 rounded border border-red-700">
                        <p class="text-sm text-red-300 font-semibold">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            Jika satu saja TIDAK → DILARANG ENTRY.
                        </p>
                    </div>
                </div>

                <!-- Bagian 4 - Keputusan Sadar -->
                <div class="mb-6">
                    <h3 class="font-bold text-white mb-3">BAGIAN 4 — KEPUTUSAN SADAR</h3>

                    <!-- Q10 -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">10. Keputusan hari ini:</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label
                                class="flex items-center justify-center p-3 bg-green-900/30 border border-green-700 rounded hover:bg-green-800/30 cursor-pointer">
                                <input type="radio" name="part_4_q10" value="Entry sesuai rules"
                                    class="mr-2 text-green-500 focus:ring-green-500">
                                <span class="text-sm text-green-300">Entry sesuai rules</span>
                            </label>
                            <label
                                class="flex items-center justify-center p-3 bg-blue-900/30 border border-blue-700 rounded hover:bg-blue-800/30 cursor-pointer">
                                <input type="radio" name="part_4_q10" value="Tidak entry"
                                    class="mr-2 text-blue-500 focus:ring-blue-500">
                                <span class="text-sm text-blue-300">Tidak entry</span>
                            </label>
                        </div>
                    </div>

                    <!-- Q11 -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">11. Jika tidak entry, emosi
                            dominan:</label>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach (['Lega', 'Kesal', 'FOMO', 'Netral', 'Bangga karena patuh'] as $option)
                                <label
                                    class="flex items-center p-2 bg-dark-700 rounded hover:bg-dark-600 cursor-pointer">
                                    <input type="radio" name="part_4_q11" value="{{ $option }}"
                                        class="mr-2 text-primary-600 focus:ring-primary-500">
                                    <span class="text-sm text-gray-300">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Bagian 5 - Catatan Ego -->
                <div class="mb-6 p-4 bg-yellow-900/20 rounded-lg border border-yellow-700/30">
                    <h3 class="font-bold text-yellow-300 mb-3 flex items-center">
                        <i class="fas fa-brain mr-2"></i>
                        BAGIAN 5 — CATATAN EGO
                    </h3>
                    <p class="text-sm text-gray-300 mb-3">Lengkapi kalimat ini:</p>
                    <div class="bg-dark-700 p-3 rounded">
                        <p class="text-sm text-gray-300 mb-2">
                            <span class="text-yellow-300 font-semibold">"Hari ini egoku ingin</span>
                            <input type="text" name="part_5_text" placeholder="____________"
                                class="mx-2 px-2 py-1 bg-dark-800 border-b border-yellow-500 text-white text-center min-w-[120px] focus:outline-none">
                            <span class="text-yellow-300 font-semibold">, dan aku memilih</span>
                            <input type="text" name="part_5_text2" placeholder="____________"
                                class="mx-2 px-2 py-1 bg-dark-800 border-b border-yellow-500 text-white text-center min-w-[120px] focus:outline-none">
                            <span class="text-yellow-300 font-semibold">."</span>
                        </p>
                    </div>
                </div>

                <!-- Bagian 6 - Pembongkar Ilusi -->
                <div class="mb-6">
                    <h3 class="font-bold text-white mb-3">BAGIAN 6 — PEMBONGKAR ILUSI KEMAJUAN</h3>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            12. Apakah hari ini aku merasa lebih baik dari diriku kemarin?
                        </label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="part_6_q12" value="1"
                                    class="mr-2 text-primary-600 focus:ring-primary-500">
                                <span class="text-sm text-gray-300">YA</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="part_6_q12" value="0"
                                    class="mr-2 text-primary-600 focus:ring-primary-500">
                                <span class="text-sm text-gray-300">TIDAK</span>
                            </label>
                        </div>
                    </div>

                    <div class="p-3 bg-purple-900/20 rounded border border-purple-700/30">
                        <p class="text-sm text-purple-300 italic">
                            "Perasaan ini bukan fakta, dan tidak memberiku hak istimewa apa pun di market."
                        </p>
                    </div>
                </div>

                <!-- Bagian 7 - Penutup Wajib -->
                <div class="mb-6">
                    <h3 class="font-bold text-white mb-3">BAGIAN 7 — PENUTUP WAJIB</h3>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            13. Apakah aku menghormati batasanku hari ini?
                        </label>
                        <div class="flex space-x-4 mb-3">
                            <label class="flex items-center">
                                <input type="radio" name="part_7_q13" value="1"
                                    class="mr-2 text-green-500 focus:ring-green-500">
                                <span class="text-sm text-green-400">YA</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="part_7_q13" value="0"
                                    class="mr-2 text-red-500 focus:ring-red-500">
                                <span class="text-sm text-red-400">TIDAK</span>
                            </label>
                        </div>
                        <textarea name="part_7_q13_text" placeholder="Jika TIDAK, tulis satu kalimat tanpa pembelaan..."
                            class="w-full h-16 bg-dark-700 border border-gray-600 rounded px-3 py-2 text-sm text-gray-300 placeholder-gray-500 focus:outline-none focus:border-red-500"></textarea>
                    </div>
                </div>

                <!-- Catatan Terakhir -->
                <div class="mb-6 p-4 bg-gray-800/50 rounded-lg border border-gray-700">
                    <h3 class="font-bold text-gray-300 mb-2 flex items-center">
                        <i class="fas fa-eye mr-2"></i>
                        CATATAN TERAKHIR
                    </h3>
                    <ul class="text-sm text-gray-400 space-y-1">
                        <li class="flex items-start">
                            <i class="fas fa-minus mr-2 mt-1"></i>
                            <span>Form ini <span class="italic">tidak akan membuatmu hebat</span></span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-shield-alt mr-2 mt-1"></i>
                            <span>Ia hanya mencegahmu menghancurkan diri sendiri</span>
                        </li>
                    </ul>
                    <div class="mt-3 pt-3 border-t border-gray-700">
                        <p class="text-center text-gray-300 font-semibold">
                            <i class="fas fa-user-secret mr-2"></i>
                            Ego tidak dikalahkan. Ia hanya diawasi.
                        </p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="sticky bottom-0 bg-dark-800 pt-4 pb-2 border-t border-gray-700">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i>
                        SIMPAN FORM KALIBRASI
                    </button>
                    <p class="text-xs text-center text-gray-500 mt-2">
                        Isi form ini SETIAP KALI membuka chart
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('floatingNoteContainer');
        const toggleBtn = document.getElementById('toggleNoteForm');
        const toggleIcon = document.getElementById('toggleIcon');

        // Update ego scale value
        const egoScale = document.querySelector('input[name="part_1_q3"]');
        const egoScaleValue = document.getElementById('egoScaleValue');

        if (egoScale) {
            egoScale.addEventListener('input', function() {
                egoScaleValue.textContent = this.value;
            });
        }

        // Toggle form visibility
        toggleBtn.addEventListener('click', function() {
            const isHidden = container.style.right === '0px' || !container.style.right;

            if (isHidden) {
                // Hide form
                container.style.right = '-400px';
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-left', 'mr-3');
                toggleBtn.classList.remove('-scale-x-100');

                // Save state to localStorage
                localStorage.setItem('noteFormHidden', 'true');
            } else {
                // Show form
                container.style.right = '0';
                toggleIcon.classList.remove('fa-chevron-left', 'mr-3');
                toggleIcon.classList.add('fa-chevron-right', 'lg:mr-3');
                toggleBtn.classList.add('-scale-x-100', 'lg:scale-x-100');

                // Save state to localStorage
                localStorage.setItem('noteFormHidden', 'false');
            }
        });

        // Load saved state
        const savedState = localStorage.getItem('noteFormHidden');
        if (savedState === 'true') {
            container.style.right = '-400px';
            toggleIcon.classList.remove('fa-chevron-right');
            toggleIcon.classList.add('fa-chevron-left');
        }

        // Form submission handling
        const form = document.getElementById('noteForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Validate anti-ego gate questions
                const q6 = document.querySelector('input[name="part_3_q6"]:checked');
                const q7 = document.querySelector('input[name="part_3_q7"]:checked');
                const q8 = document.querySelector('input[name="part_3_q8"]:checked');
                const q9 = document.querySelector('input[name="part_3_q9"]:checked');

                // Check if any answer is "TIDAK" (value = 0)
                if ((q6 && q6.value === '0') ||
                    (q7 && q7.value === '0') ||
                    (q8 && q8.value === '0') ||
                    (q9 && q9.value === '0')) {

                    const decision = document.querySelector('input[name="part_4_q10"]:checked');
                    if (decision && decision.value === 'Entry sesuai rules') {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'PERINGATAN!',
                            html: `
                            <p>Anda menjawab <strong>TIDAK</strong> pada salah satu Gerbang Anti-Ego!</p>
                            <p class="mt-2 text-red-300">Jika satu saja TIDAK → DILARANG ENTRY.</p>
                            <p class="mt-2">Silakan ubah keputusan Anda atau perbaiki jawaban Gerbang Anti-Ego.</p>
                        `,
                            confirmButtonColor: '#d33'
                        });
                    }
                }
            });
        }
    });
</script>
