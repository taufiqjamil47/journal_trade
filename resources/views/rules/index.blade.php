@extends('Layouts.index')
@section('title', 'Trading Rules Management')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-primary-500 to-green-400 bg-clip-text text-transparent">
                        Trading Rules Management
                    </h1>
                    <p class="text-gray-400 mt-2">Kelola daftar aturan trading untuk evaluasi yang lebih baik</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="openCreateModal()"
                        class="flex items-center bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg group">
                        <i class="fas fa-plus-circle mr-2 group-hover:scale-110 transition-transform"></i>
                        Tambah Rule Baru
                    </button>
                    <a href="{{ route('trades.index') }}"
                        class="flex items-center bg-dark-800/50 backdrop-blur-sm rounded-lg p-3 border border-gray-700/50 hover:border-primary-500/50 hover:shadow-lg hover:shadow-primary-500/10 transition-all duration-300 group">
                        <i class="fas fa-arrow-left text-primary-500 mr-2 group-hover:scale-110 transition-transform"></i>
                        <span>Kembali ke Trades</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-dark-800 to-blue-900/20 rounded-2xl p-6 border border-blue-700/30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-2">Total Rules</p>
                        <p class="text-3xl font-bold text-blue-400">{{ $rules->count() }}</p>
                    </div>
                    <div class="bg-blue-500/20 p-4 rounded-xl">
                        <i class="fas fa-rules text-blue-500 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-dark-800 to-green-900/20 rounded-2xl p-6 border border-green-700/30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-2">Active Rules</p>
                        <p class="text-3xl font-bold text-green-400">{{ $rules->where('is_active', true)->count() }}</p>
                    </div>
                    <div class="bg-green-500/20 p-4 rounded-xl">
                        <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-dark-800 to-amber-900/20 rounded-2xl p-6 border border-amber-700/30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-2">Inactive Rules</p>
                        <p class="text-3xl font-bold text-amber-400">{{ $rules->where('is_active', false)->count() }}</p>
                    </div>
                    <div class="bg-amber-500/20 p-4 rounded-xl">
                        <i class="fas fa-pause-circle text-amber-500 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-dark-800 to-purple-900/20 rounded-2xl p-6 border border-purple-700/30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm mb-2">Last Updated</p>
                        <p class="text-lg font-bold text-purple-400">
                            {{ $rules->sortByDesc('updated_at')->first()->updated_at->diffForHumans() ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="bg-purple-500/20 p-4 rounded-xl">
                        <i class="fas fa-history text-purple-500 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rules Table -->
        <div
            class="bg-gradient-to-br from-dark-800 to-dark-800/70 backdrop-blur-sm rounded-2xl border border-gray-700/30 shadow-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-700/50 bg-gradient-to-r from-dark-800 to-green-900/20">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-green-300">Daftar Trading Rules</h2>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Cari rule..."
                                class="bg-dark-800/80 border border-gray-600 rounded-lg py-2 pl-10 pr-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent w-64">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-500"></i>
                        </div>
                        <button onclick="resetOrder()" class="text-sm text-gray-400 hover:text-gray-300 transition-colors">
                            <i class="fas fa-sort-amount-down mr-1"></i> Reset Urutan
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-dark-800/50 to-dark-800/20 border-b border-gray-700/50">
                            <th class="py-4 px-6 text-left">
                                <div class="flex items-center space-x-2">
                                    <span>No</span>
                                    <button onclick="sortTable('order')" class="text-gray-500 hover:text-gray-300">
                                        <i class="fas fa-sort"></i>
                                    </button>
                                </div>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <div class="flex items-center space-x-2">
                                    <span>Nama Rule</span>
                                    <button onclick="sortTable('name')" class="text-gray-500 hover:text-gray-300">
                                        <i class="fas fa-sort"></i>
                                    </button>
                                </div>
                            </th>
                            <th class="py-4 px-6 text-left">Deskripsi</th>
                            <th class="py-4 px-6 text-left">
                                <div class="flex items-center space-x-2">
                                    <span>Status</span>
                                    <button onclick="sortTable('is_active')" class="text-gray-500 hover:text-gray-300">
                                        <i class="fas fa-sort"></i>
                                    </button>
                                </div>
                            </th>
                            <th class="py-4 px-6 text-left">Urutan</th>
                            <th class="py-4 px-6 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="rulesTableBody">
                        @forelse($rules as $rule)
                            <tr class="border-b border-gray-700/30 hover:bg-gradient-to-r hover:from-dark-800/50 hover:to-dark-800/30 transition-all duration-200 rule-item"
                                data-name="{{ strtolower($rule->name) }}"
                                data-description="{{ strtolower($rule->description) }}"
                                data-status="{{ $rule->is_active ? 'active' : 'inactive' }}">
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div
                                            class="bg-gray-700 text-gray-300 w-8 h-8 rounded-full flex items-center justify-center font-bold mr-3">
                                            {{ $loop->iteration }}
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-200">{{ $rule->name }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-gray-400 text-sm max-w-xs truncate">{{ $rule->description ?? '-' }}
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold 
                                {{ $rule->is_active ? 'bg-green-900/30 text-green-400 border border-green-700/50' : 'bg-red-900/30 text-red-400 border border-red-700/50' }}">
                                        {{ $rule->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="bg-gray-800 px-3 py-1 rounded-lg text-gray-300">{{ $rule->order }}</span>
                                        <div class="flex flex-col space-y-1">
                                            <button onclick="moveUp({{ $rule->id }})"
                                                class="text-gray-400 hover:text-green-400">
                                                <i class="fas fa-chevron-up text-xs"></i>
                                            </button>
                                            <button onclick="moveDown({{ $rule->id }})"
                                                class="text-gray-400 hover:text-red-400">
                                                <i class="fas fa-chevron-down text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-2">
                                        <button
                                            onclick="openEditModal({{ $rule->id }}, '{{ $rule->name }}', '{{ $rule->description }}', {{ $rule->order }}, {{ $rule->is_active ? 'true' : 'false' }})"
                                            class="p-2 bg-blue-900/20 hover:bg-blue-900/30 border border-blue-700/30 rounded-lg text-blue-400 hover:text-blue-300 transition-all duration-200 group">
                                            <i class="fas fa-edit group-hover:scale-110 transition-transform"></i>
                                        </button>
                                        <button onclick="deleteRule({{ $rule->id }}, '{{ $rule->name }}')"
                                            class="p-2 bg-red-900/20 hover:bg-red-900/30 border border-red-700/30 rounded-lg text-red-400 hover:text-red-300 transition-all duration-200 group">
                                            <i class="fas fa-trash group-hover:scale-110 transition-transform"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 px-6 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-4"></i>
                                        <p class="text-lg">Belum ada rules</p>
                                        <p class="text-sm mt-2">Tambahkan rules pertama Anda untuk mulai evaluasi trading
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($rules->hasPages())
                <div class="px-6 py-4 border-t border-gray-700/50 bg-dark-800/50">
                    {{ $rules->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

        <!-- Quick Tips -->
        <div class="mt-8 bg-gradient-to-br from-dark-800 to-amber-900/20 rounded-2xl p-6 border border-amber-700/30">
            <div class="flex items-center">
                <div class="bg-amber-500/20 p-4 rounded-xl mr-4">
                    <i class="fas fa-lightbulb text-amber-400 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-amber-300 mb-2">Tips Penggunaan Trading Rules</h3>
                    <ul class="text-gray-400 text-sm space-y-2">
                        <li><i class="fas fa-check-circle text-amber-500 mr-2"></i> Urutkan rules berdasarkan prioritas
                            dengan tombol panah</li>
                        <li><i class="fas fa-check-circle text-amber-500 mr-2"></i> Nonaktifkan rule yang tidak digunakan
                            tanpa menghapus</li>
                        <li><i class="fas fa-check-circle text-amber-500 mr-2"></i> Gunakan deskripsi untuk penjelasan
                            detail rule</li>
                        <li><i class="fas fa-check-circle text-amber-500 mr-2"></i> Rules akan muncul di form evaluasi
                            trade</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div id="ruleModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden z-50 overflow-y-auto">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/90 rounded-2xl border border-gray-700/30 shadow-2xl w-full max-w-2xl">
                <!-- Modal Header -->
                <div class="px-8 py-6 border-b border-gray-700/50 bg-gradient-to-r from-dark-800 to-green-900/30">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-green-500/20 p-4 rounded-2xl mr-5 shadow-lg shadow-green-500/10">
                                <i class="fas fa-rules text-green-400 text-2xl"></i>
                            </div>
                            <div>
                                <h2 id="modalTitle"
                                    class="text-2xl font-bold bg-gradient-to-r from-green-400 to-emerald-300 bg-clip-text text-transparent">
                                    Tambah Rule Baru
                                </h2>
                                <p class="text-gray-400 text-sm mt-1">Atur detail trading rule untuk evaluasi</p>
                            </div>
                        </div>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-300 transition-colors">
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Form -->
                <form id="ruleForm" method="POST" class="p-8">
                    @csrf
                    <input type="hidden" id="ruleId" name="id">

                    <div class="space-y-6">
                        <!-- Name -->
                        <div class="space-y-3">
                            <label for="name" class="block text-sm font-semibold text-gray-300 flex items-center">
                                <div class="bg-blue-500/20 p-2 rounded-lg mr-3">
                                    <i class="fas fa-heading text-blue-500"></i>
                                </div>
                                <span>Nama Rule</span>
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input type="text" id="name" name="name" required
                                class="w-full bg-dark-800/80 border border-blue-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                placeholder="Contoh: Time 07.00 AM (Forex) - 08.00 AM (Indexs)">
                            <p class="text-xs text-blue-400 mt-2">Nama rule yang jelas dan deskriptif</p>
                        </div>

                        <!-- Description -->
                        <div class="space-y-3">
                            <label for="description" class="block text-sm font-semibold text-gray-300 flex items-center">
                                <div class="bg-purple-500/20 p-2 rounded-lg mr-3">
                                    <i class="fas fa-align-left text-purple-500"></i>
                                </div>
                                <span>Deskripsi (Opsional)</span>
                            </label>
                            <textarea id="description" name="description" rows="3"
                                class="w-full bg-dark-800/80 border border-purple-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 shadow-inner resize-none"
                                placeholder="Penjelasan detail rule, contoh, atau catatan tambahan..."></textarea>
                            <p class="text-xs text-purple-400 mt-2">Gunakan untuk memberikan konteks atau contoh</p>
                        </div>

                        <!-- Order -->
                        <div class="space-y-3">
                            <label for="order" class="block text-sm font-semibold text-gray-300 flex items-center">
                                <div class="bg-amber-500/20 p-2 rounded-lg mr-3">
                                    <i class="fas fa-sort-numeric-up text-amber-500"></i>
                                </div>
                                <span>Urutan Tampilan</span>
                            </label>
                            <input type="number" id="order" name="order" min="0"
                                class="w-full bg-dark-800/80 border border-amber-700/40 rounded-xl py-3.5 px-4 text-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 shadow-inner"
                                placeholder="Angka urutan (semakin kecil = semakin atas)">
                            <p class="text-xs text-amber-400 mt-2">Urutkan berdasarkan prioritas atau alur trading</p>
                        </div>

                        <!-- Status -->
                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-gray-300 flex items-center">
                                <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                                    <i class="fas fa-toggle-on text-green-500"></i>
                                </div>
                                <span>Status Rule</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="status-option">
                                    <input type="radio" name="is_active" value="1" checked
                                        class="status-radio hidden">
                                    <div
                                        class="status-content bg-green-900/20 border-2 border-green-600/30 rounded-xl p-4 text-center transition-all duration-300 hover:border-green-500 hover:scale-105 cursor-pointer">
                                        <i class="fas fa-check-circle text-2xl text-green-400 mb-2"></i>
                                        <div class="text-green-400 font-semibold">Active</div>
                                        <div class="text-green-400/60 text-xs mt-1">Tampil di form evaluasi</div>
                                    </div>
                                </label>
                                <label class="status-option">
                                    <input type="radio" name="is_active" value="0" class="status-radio hidden">
                                    <div
                                        class="status-content bg-red-900/20 border-2 border-red-600/30 rounded-xl p-4 text-center transition-all duration-300 hover:border-red-500 hover:scale-105 cursor-pointer">
                                        <i class="fas fa-pause-circle text-2xl text-red-400 mb-2"></i>
                                        <div class="text-red-400 font-semibold">Inactive</div>
                                        <div class="text-red-400/60 text-xs mt-1">Tidak tampil di form</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-700/50">
                        <button type="button" onclick="closeModal()"
                            class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-xl transition-all duration-200">
                            Batal
                        </button>
                        <button type="submit" id="submitBtn"
                            class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center group">
                            <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform"></i>
                            <span id="submitText">Simpan Rule</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden z-50">
        <div class="min-h-screen flex items-center justify-center p-4">
            <div
                class="bg-gradient-to-br from-dark-800 to-dark-800/90 rounded-2xl border border-red-700/30 shadow-2xl w-full max-w-md">
                <div class="p-8">
                    <div class="text-center mb-6">
                        <div class="bg-red-500/20 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-exclamation-triangle text-red-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-red-300 mb-2">Konfirmasi Hapus</h3>
                        <p class="text-gray-400">Apakah Anda yakin ingin menghapus rule <span id="deleteRuleName"
                                class="font-bold text-gray-200"></span>?</p>
                        <p class="text-sm text-red-400 mt-2"><i class="fas fa-exclamation-circle mr-1"></i> Rule yang
                            terhubung dengan trade tidak akan terpengaruh</p>
                    </div>

                    <div class="flex justify-center space-x-4">
                        <button onclick="closeDeleteModal()"
                            class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-xl transition-all duration-200">
                            Batal
                        </button>
                        <button onclick="confirmDelete()" id="confirmDeleteBtn"
                            class="px-8 py-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center group">
                            <i class="fas fa-trash mr-2 group-hover:scale-110 transition-transform"></i>
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .rule-item:hover {
            background: linear-gradient(90deg, rgba(31, 41, 55, 0.5), rgba(31, 41, 55, 0.3));
        }

        .status-option input:checked+.status-content {
            border-color: currentColor;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
        }

        .status-option:nth-child(1) input:checked+.status-content {
            border-color: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        }

        .status-option:nth-child(2) input:checked+.status-content {
            border-color: #ef4444;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
        }

        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 0 4px;
        }

        .pagination li a,
        .pagination li span {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 8px;
            background: rgba(31, 41, 55, 0.5);
            border: 1px solid rgba(75, 85, 99, 0.3);
            color: #d1d5db;
            text-decoration: none;
            transition: all 0.2s;
        }

        .pagination li a:hover {
            background: rgba(31, 41, 55, 0.8);
            border-color: #3b82f6;
        }

        .pagination li.active span {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: white;
            border-color: transparent;
        }
    </style>

    <script>
        // Modal Functions
        let currentRuleId = null;

        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Tambah Rule Baru';
            document.getElementById('ruleForm').action = "{{ route('trading-rules.store') }}";
            document.getElementById('ruleForm').method = 'POST';
            document.getElementById('ruleId').value = '';
            document.getElementById('name').value = '';
            document.getElementById('description').value = '';
            document.getElementById('order').value = '';
            document.querySelector('input[name="is_active"][value="1"]').checked = true;
            document.getElementById('submitText').textContent = 'Simpan Rule';
            document.getElementById('ruleModal').classList.remove('hidden');
        }

        function openEditModal(id, name, description, order, isActive) {
            document.getElementById('modalTitle').textContent = 'Edit Rule';
            document.getElementById('ruleForm').action = "{{ route('trading-rules.update', '') }}/" + id;
            document.getElementById('ruleForm').method = 'POST';
            document.getElementById('ruleForm').innerHTML += '@method('PUT')';
            document.getElementById('ruleId').value = id;
            document.getElementById('name').value = name;
            document.getElementById('description').value = description || '';
            document.getElementById('order').value = order || '';
            document.querySelector(`input[name="is_active"][value="${isActive ? '1' : '0'}"]`).checked = true;
            document.getElementById('submitText').textContent = 'Update Rule';
            document.getElementById('ruleModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('ruleModal').classList.add('hidden');
            // Reset method field if exists
            const methodField = document.querySelector('input[name="_method"]');
            if (methodField) methodField.remove();
        }

        function openDeleteModal(id, name) {
            currentRuleId = id;
            document.getElementById('deleteRuleName').textContent = `"${name}"`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            currentRuleId = null;
        }

        function deleteRule(id, name) {
            openDeleteModal(id, name);
        }

        async function confirmDelete() {
            if (!currentRuleId) return;

            const btn = document.getElementById('confirmDeleteBtn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner animate-spin mr-2"></i>Menghapus...';
            btn.disabled = true;

            try {
                const response = await fetch(`/trading-rules/${currentRuleId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });

                if (response.ok) {
                    showNotification('Rule berhasil dihapus', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    throw new Error('Gagal menghapus rule');
                }
            } catch (error) {
                showNotification('Gagal menghapus rule', 'error');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }

        // Table Functions
        function sortTable(column) {
            const tbody = document.getElementById('rulesTableBody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            rows.sort((a, b) => {
                let aValue, bValue;

                if (column === 'name') {
                    aValue = a.dataset.name;
                    bValue = b.dataset.name;
                } else if (column === 'status') {
                    aValue = a.dataset.status;
                    bValue = b.dataset.status;
                } else if (column === 'order') {
                    aValue = parseInt(a.querySelector('td:nth-child(5) .bg-gray-800').textContent) || 0;
                    bValue = parseInt(b.querySelector('td:nth-child(5) .bg-gray-800').textContent) || 0;
                }

                if (aValue < bValue) return -1;
                if (aValue > bValue) return 1;
                return 0;
            });

            // Toggle sort direction
            if (tbody.dataset.sortColumn === column) {
                rows.reverse();
                tbody.dataset.sortDirection = tbody.dataset.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                tbody.dataset.sortColumn = column;
                tbody.dataset.sortDirection = 'asc';
            }

            // Reorder table
            rows.forEach(row => tbody.appendChild(row));

            // Update row numbers
            updateRowNumbers();
        }

        function updateRowNumbers() {
            const rows = document.querySelectorAll('#rulesTableBody tr');
            rows.forEach((row, index) => {
                const numberCell = row.querySelector('td:first-child .bg-gray-700');
                if (numberCell) {
                    numberCell.textContent = index + 1;
                }
            });
        }

        function resetOrder() {
            location.reload();
        }

        // Search Functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#rulesTableBody tr');

            rows.forEach(row => {
                const name = row.dataset.name;
                const description = row.dataset.description || '';
                const visible = name.includes(searchTerm) || description.includes(searchTerm);
                row.style.display = visible ? '' : 'none';
            });

            updateRowNumbers();
        });

        // Order Management
        async function moveUp(id) {
            await updateOrder(id, 'up');
        }

        async function moveDown(id) {
            await updateOrder(id, 'down');
        }

        async function updateOrder(id, direction) {
            try {
                const response = await fetch(`/trading-rules/${id}/order`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        direction
                    })
                });

                if (response.ok) {
                    showNotification('Urutan berhasil diperbarui', 'success');
                    setTimeout(() => location.reload(), 1000);
                }
            } catch (error) {
                showNotification('Gagal memperbarui urutan', 'error');
            }
        }

        // Notification System
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-xl border backdrop-blur-sm transform transition-all duration-300 translate-x-full ${
            type === 'success' ? 'bg-green-900/20 border-green-700/30 text-green-400' :
            type === 'error' ? 'bg-red-900/20 border-red-700/30 text-red-400' :
            'bg-blue-900/20 border-blue-700/30 text-blue-400'
        }`;

            notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} mr-3"></i>
                <span>${message}</span>
            </div>
        `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Form Submission
        document.getElementById('ruleForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner animate-spin mr-2"></i>Menyimpan...';
            btn.disabled = true;

            // Form will submit normally via Laravel
        });

        // Close modals with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeDeleteModal();
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-select status radio based on active rules
            const activeRulesCount = {{ $rules->where('is_active', true)->count() }};
            const totalRules = {{ $rules->count() }};

            if (activeRulesCount === totalRules) {
                document.querySelector('input[name="is_active"][value="1"]').checked = true;
            }
        });
    </script>
@endsection
