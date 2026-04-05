<?php

return [
    // Page titles
    'page_title' => 'Akun',
    'page_subtitle' => 'Kelola akun trading Anda',

    // List section
    'list_title' => 'Daftar Akun',
    'total_accounts' => 'Total akun',
    'add_button' => 'Tambah Akun',
    'account_label' => 'Akun',

    // Table headers
    'table' => [
        'id' => 'ID',
        'initial_balance' => 'Saldo Awal',
        'currency' => 'Mata Uang',
        'commission_per_lot' => 'Komisi/Lot',
        'created' => 'Dibuat',
        'actions' => 'Aksi',
    ],

    // Empty state
    'empty' => [
        'title' => 'Tidak ada akun ditemukan',
        'message' => 'Mulailah dengan membuat akun pertama Anda',
        'create_button' => 'Buat Akun',
    ],

    // Action tooltips
    'actions' => [
        'view' => 'Lihat Akun',
        'edit' => 'Edit Akun',
        'delete' => 'Hapus Akun',
    ],

    // Show page (Account Details)
    'show' => [
        'page_title' => 'Detail Akun',
        'page_subtitle' => 'Lihat informasi detail tentang akun ini',
        'back_button' => 'Kembali ke Akun',
        'edit_button' => 'Edit Akun',
        'delete_button' => 'Hapus Akun',
        'account_header' => 'Akun',

        // Basic Information Section
        'basic_info_title' => 'Informasi Dasar',
        'account_id_label' => 'ID Akun',
        'initial_balance_label' => 'Saldo Awal',
        'currency_label' => 'Mata Uang',
        'commission_label' => 'Komisi/Lot',

        // Timestamps Section
        'timestamps_title' => 'Waktu',
        'created_at_label' => 'Dibuat Pada',
        'updated_at_label' => 'Terakhir Diupdate',

        // Related Trades Section
        'related_trades_title' => 'Transaksi Terkait',
        'total_trades_label' => 'total',

        // Trades Table
        'trades_table' => [
            'id' => 'ID',
            'symbol' => 'Simbol',
            'type' => 'Tipe',
            'lots' => 'Lot',
            'date' => 'Tanggal',
            'actions' => 'Aksi',
            'buy_type' => 'Beli',
            'sell_type' => 'Jual',
            'view_trade' => 'Lihat Transaksi',
        ],

        'showing_trades' => 'Menampilkan :shown dari :total transaksi',
        'no_trades_title' => 'Tidak ada transaksi ditemukan',
        'no_trades_message' => 'Akun ini belum memiliki transaksi apapun',

        'hedge_fund_investor' => 'Hedge Fund Investor',
        'currency_info' => 'Currency Info',
        'currency_info_desc' => 'Input dalam Rupiah, otomatis dikonversi ke USD',
        'last_update' => 'Last update',
        'refresh_rate' => 'Refresh Rate',
        'total_investor_modal' => 'Total Investor Modal',
        'total_profit_account' => 'Total Profit (Account)',
        'roi' => 'ROI',
        'investor_name_placeholder' => 'Nama Investor',
        'modal_placeholder' => 'Modal (Rp)',
        'add_investor' => 'Tambah Investor',
        'calculate_profit_sharing' => 'Hitung Bagi Hasil',
        'report' => 'Report',
        'name' => 'Nama',
        'investment' => 'Investasi',
        'percentage' => 'Persentase',
        'profit_share' => 'Bagi Hasil',
        'total' => 'Total',
        'confirm_delete_investor' => 'Hapus investor ini?',
        'delete' => 'Hapus',
        'no_investor' => 'Belum ada investor',
    ],

    // Edit page
    'edit' => [
        'page_title' => 'Edit Akun',
        'back_button' => 'Kembali ke Akun',

        // Form Labels
        'account_name_label' => 'Nama Akun',
        'account_name_placeholder' => 'Contoh: Scalp Trading, Day Trade',
        'description_label' => 'Deskripsi',
        'description_placeholder' => 'Contoh: Untuk scalping EUR/USD pada timeframe 5 menit',
        'initial_balance_label' => 'Saldo Awal',
        'currency_label' => 'Mata Uang',
        'currency_select_option' => 'Pilih Mata Uang',
        'commission_label' => 'Komisi per Lot ($)',
        'commission_help_text' => 'Komisi yang dikenakan per lot yang ditradingkan',

        // Buttons
        'cancel_button' => 'Batal',
        'update_button' => 'Update Akun',
    ],

    // Create page
    'create' => [
        'page_title' => 'Buat Akun Baru',
        'back_button' => 'Kembali ke Akun',

        // Form Labels
        'account_name_label' => 'Nama Akun',
        'account_name_placeholder' => 'Contoh: Scalp Trading, Day Trade',
        'description_label' => 'Deskripsi',
        'description_placeholder' => 'Contoh: Untuk scalping EUR/USD pada timeframe 5 menit',
        'initial_balance_label' => 'Saldo Awal',
        'currency_label' => 'Mata Uang',
        'currency_select_option' => 'Pilih Mata Uang',
        'commission_label' => 'Komisi per Lot ($)',
        'commission_help_text' => 'Nilai default adalah $1.00 per lot',

        // Buttons
        'cancel_button' => 'Batal',
        'create_button' => 'Buat Akun',
    ],

    // Delete modal
    'delete_modal' => [
        'title' => 'Hapus Akun',
        'account_to_delete' => 'Akun yang akan dihapus',
        'warning_message' => 'Tindakan ini tidak dapat dibatalkan. Semua transaksi terkait juga akan dihapus.',
        'confirmation_instruction' => 'Ketik kode konfirmasi di bawah ini untuk menghapus',
        'input_placeholder' => 'Ketik DELETE_',
        'confirm_button' => 'Ya, hapus!',
        'cancel_button' => 'Batal',
        'validation_error' => 'Harap ketik',
        'loading_title' => 'Menghapus Akun',
        'loading_message' => 'Menghapus',
    ],
];
