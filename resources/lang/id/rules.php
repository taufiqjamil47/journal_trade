<?php

return [
    'title' => 'Manajemen Aturan Trading',

    'header' => [
        'title' => 'Manajemen Aturan Trading',
        'subtitle' => 'Kelola daftar aturan trading untuk evaluasi yang lebih baik',
    ],

    'stats' => [
        'total_rules' => 'Total Rules',
        'active_rules' => 'Rules Aktif',
        'inactive_rules' => 'Rules Nonaktif',
        'last_updated' => 'Terakhir Diupdate',
    ],

    'table' => [
        'title' => 'Daftar Trading Rules',
        'total' => 'Total: :count rules',
        'search_placeholder' => 'Cari rule...',
        'sort_by' => 'Urutkan',
        'sort_name_asc' => 'Nama (A-Z)',
        'sort_name_desc' => 'Nama (Z-A)',
        'sort_order_asc' => 'Urutan (Terendah)',
        'sort_order_desc' => 'Urutan (Tertinggi)',
        'add_new_rule' => 'Tambah Rule Baru',

        'columns' => [
            'name' => 'Nama Rule',
            'description' => 'Deskripsi',
            'status' => 'Status',
            'order' => 'Urutan',
            'actions' => 'Aksi',
        ],

        'empty' => [
            'title' => 'Belum Ada Rules',
            'message' => 'Mulai dengan membuat rule trading pertama Anda',
            'add_first_rule' => 'Tambah Rule Pertama',
        ],
    ],

    'status' => [
        'active' => 'AKTIF',
        'inactive' => 'NON-AKTIF',
    ],

    'actions' => [
        'edit' => 'Edit Rule',
        'delete' => 'Hapus Rule',
    ],

    'tips' => [
        'title' => 'Tips Penggunaan Trading Rules',
        'tip1' => 'Urutkan rules berdasarkan prioritas dengan tombol panah',
        'tip2' => 'Nonaktifkan rule yang tidak digunakan tanpa menghapus',
        'tip3' => 'Gunakan deskripsi untuk penjelasan detail rule',
        'tip4' => 'Rules akan muncul di form evaluasi trade',
    ],

    'modal' => [
        'create_title' => 'Tambah Rule Baru',
        'create_subtitle' => 'Atur detail trading rule untuk evaluasi',
        'edit_title' => 'Edit Rule',
        'edit_subtitle' => 'Perbarui detail trading rule',

        'fields' => [
            'name' => [
                'label' => 'Nama Rule',
                'placeholder' => 'Contoh: Time 07.00 AM (Forex) - 08.00 AM (Indexs)',
            ],
            'description' => [
                'label' => 'Deskripsi (Opsional)',
                'placeholder' => 'Penjelasan detail rule, contoh, atau catatan tambahan...',
            ],
            'order' => [
                'label' => 'Urutan Tampilan',
                'placeholder' => 'Angka urutan (semakin kecil = semakin atas)',
            ],
            'status' => [
                'label' => 'Status Rule',
                'active' => 'Aktif',
                'active_desc' => 'Tampil di form evaluasi',
                'inactive' => 'Non-Aktif',
                'inactive_desc' => 'Tidak tampil di form',
            ],
        ],

        'buttons' => [
            'cancel' => 'Batal',
            'save' => 'Simpan Rule',
            'update' => 'Update Rule',
        ],
    ],

    'delete' => [
        'title' => 'Hapus Rule?',
        'rule_to_delete' => 'Rule yang akan dihapus',
        'warning_used' => 'Rule yang sudah digunakan di evaluasi trade akan tetap tersimpan',
        'confirm_text' => 'Untuk mengonfirmasi, ketik:',
        'input_placeholder' => 'Ketik kode konfirmasi...',
        'confirm_button' => 'Hapus Rule',
        'cancel_button' => 'Batal',
        'validation_message' => 'Silakan ketik :code', // Ubah ini
        'deleting' => 'Menghapus...',
        'deleting_message' => 'Menghapus rule ":name"...',
    ],

    'messages' => [
        'success' => 'Berhasil!',
        'error' => 'Gagal',
        'order_updated' => 'Urutan rules telah diperbarui',
        'order_failed' => 'Gagal memperbarui urutan rule',
        'order_error' => 'Terjadi kesalahan saat memperbarui urutan',
        'order_save_failed' => 'Gagal menyimpan urutan baru',
    ],
];
