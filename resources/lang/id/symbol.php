<?php
return [
    'title' => 'Simbol',
    'header_title' => 'Simbol Perdagangan',
    'header_subtitle' => 'Kelompok simbol perdagangan Anda',
    'trader_label' => 'Pedagang',

    // Table
    'table_title' => 'Daftar Symbol',
    'total_symbols' => 'Total: :count Symbols',
    'add_symbol_button' => 'Tambah Symbol',
    'add_first_symbol_button' => 'Tambah Symbol Pertama',

    // Table columns
    'column_id' => 'ID',
    'column_name' => 'Nama',
    'column_pip_value' => 'Nilai Pip',
    'column_pip_worth' => 'Nilai Pip',
    'column_active' => 'Aktif',
    'column_actions' => 'Tindakan',

    // Status
    'status_active' => 'Aktif',
    'status_inactive' => 'Tidak Aktif',

    // Buttons
    'edit_button_title' => 'Edit Symbol',
    'delete_button_title' => 'Hapus Symbol',

    // Empty state
    'no_symbols_title' => 'Belum ada symbol',
    'no_symbols_subtitle' => 'Mulai dengan menambahkan symbol pertama Anda',

    // Delete modal
    'delete_modal_title' => 'Hapus Symbol?',
    'delete_modal_symbol_to_delete' => 'Symbol yang akan dihapus:',
    'delete_modal_warning' => 'Trade yang menggunakan symbol ini akan tetap ada',
    'delete_modal_confirm_prompt' => 'Ketik konfirmasi:',
    'delete_modal_input_placeholder' => 'Ketik kode konfirmasi...',
    'delete_modal_confirm_button' => 'Hapus Symbol',
    'delete_modal_cancel_button' => 'Batal',
    'delete_modal_validation_message_part1' => 'Silakan ketik ',
    'delete_modal_validation_message_part2' => '',
    'delete_loading_title' => 'Menghapus...',
    'delete_loading_message' => 'Menghapus symbol ":name"...',

    // Create page
    'create_title' => 'Buat Simbol Baru',
    'create_header_title' => 'Tambah Symbol Baru',
    'create_header_subtitle' => 'Tambahkan simbol perdagangan baru ke sistem',
    'back_to_list' => 'Daftar Symbols',

    // Form errors
    'form_error_title' => 'Terdapat kesalahan dalam pengisian form:',

    // Form sections
    'form_section_title' => 'Informasi Symbol Baru',
    'form_section_subtitle' => 'Isi semua informasi yang diperlukan untuk menambahkan symbol baru',

    // Form labels and placeholders
    'form_name_label' => 'Nama Simbol',
    'form_name_placeholder' => 'Contoh: EURUSD',
    'form_name_help' => 'Nama symbol trading (contoh: EURUSD, GBPUSD, XAUUSD)',

    'form_pip_value_label' => 'Nilai Pip',
    'form_pip_value_placeholder' => 'Contoh: 0.0001',
    'form_pip_value_help' => 'Nilai per pip dalam mata uang quote (biasanya 0.0001 untuk forex)',

    'form_pip_worth_label' => 'Nilai Pip (USD per pip per 1 lot)',
    'form_pip_worth_placeholder' => 'Contoh: 10.00',
    'form_pip_worth_help' => 'Nilai USD per pip untuk 1 lot standar (default: 10)',

    'form_pip_position_label' => 'Pip Position',
    'form_pip_position_placeholder' => 'Contoh: 4 (untuk kebanyakan pasangan)',
    'form_pip_position_help' => 'Posisi desimal untuk pip (biasanya 4 untuk forex, 2 untuk JPY pairs)',

    'form_status_label' => 'Status Symbol',
    'form_status_help' => 'Tentukan apakah simbol ini aktif untuk trading',

    // Form buttons
    'cancel_button' => 'Batal',
    'back_button' => 'Kembali',
    'submit_button' => 'Tambah Symbol',

    // Tips section
    'tips_title' => 'Tips Menambahkan Symbol',
    'tip_format_title' => 'Format Symbol',
    'tip_format_description' => 'Gunakan format standar seperti <code class="text-primary-400 font-mono">EURUSD</code> untuk pasangan mata uang atau <code class="text-primary-400 font-mono">XAUUSD</code> untuk emas.',

    'tip_pip_value_title' => 'Nilai Pip',
    'tip_pip_value_description' => 'Untuk forex, nilai pip biasanya <code class="text-green-400 font-mono">0.0001</code>. Untuk pasangan dengan JPY, biasanya <code class="text-green-400 font-mono">0.01</code>.',

    'tip_pip_worth_title' => 'Pip Worth',
    'tip_pip_worth_description' => 'Nilai default <code class="text-blue-400 font-mono">10</code> adalah standar untuk kebanyakan pasangan forex. Sesuaikan jika diperlukan.',

    'tip_status_title' => 'Status Aktif',
    'tip_status_description' => 'Nonaktifkan simbol jika tidak digunakan sementara. Data historis tetap tersimpan.',

    // Status (sudah ada di file sebelumnya, tapi untuk referensi)
    'status_active' => 'Aktif',
    'status_inactive' => 'Nonaktif',

    // Edit page
    'edit_title' => 'Edit Symbol',
    'edit_header_title' => 'Edit Symbol',
    'edit_header_subtitle' => 'Perbarui informasi simbol perdagangan',
    'status_active_description' => 'Simbol ini aktif untuk trading',
    'status_inactive_description' => 'Simbol ini tidak aktif untuk trading',

    // Form info
    'form_info_title' => 'Informasi Symbol',
    'form_id_label' => 'ID:',

    // Form help text (edit specific)
    'edit_pip_value_help' => 'Nilai per pip dalam mata uang quote',
    'edit_pip_worth_help' => 'Nilai USD per pip untuk 1 lot standar',
    'edit_pip_position_help' => 'Posisi desimal untuk pip (biasanya 4 untuk forex)',

    // Status section
    'edit_status_title' => 'Status Pesanan',
    'edit_status_subtitle' => 'Aktifkan atau nonaktifkan simbol untuk trading',
    'edit_current_status_label' => 'Status saat ini',

    // Form buttons (edit specific)
    'edit_submit_button' => 'Simpan Perubahan',

    // Current info section
    'current_info_title' => 'Informasi Saat Ini',
    'current_symbol_label' => 'Symbol',
    'current_pip_value_label' => 'Pip Value',
    'current_status_label' => 'Status',
    'last_updated_label' => 'Terakhir Diperbarui',

    // Status (already exists, but for reference)
    'status_active' => 'Aktif',
    'status_inactive' => 'Nonaktif',

    // Form buttons (shared with create)
    'cancel_button' => 'Batal',
    'back_button' => 'Kembali',
    'back_to_list' => 'Daftar Symbols',
    'form_error_title' => 'Terdapat kesalahan dalam pengisian form:',

    // Form labels (shared with create)
    'form_name_label' => 'Symbol Name',
    'form_name_placeholder' => 'Contoh: EURUSD',
    'form_pip_value_label' => 'Pip Value',
    'form_pip_value_placeholder' => 'Contoh: 0.0001',
    'form_pip_worth_label' => 'Pip Worth (USD per pip per 1 lot)',
    'form_pip_worth_placeholder' => 'Contoh: 10.00',
    'form_pip_position_label' => 'Pip Position',
    'form_pip_position_placeholder' => 'Contoh: 4 (untuk kebanyakan pasangan)',
];
