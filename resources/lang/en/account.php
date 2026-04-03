<?php

return [
    // Page titles
    'page_title' => 'Accounts',
    'page_subtitle' => 'Manage your trading accounts',

    // List section
    'list_title' => 'Accounts List',
    'total_accounts' => 'Total accounts',
    'add_button' => 'Add Account',
    'account_label' => 'Account',

    // Table headers
    'table' => [
        'id' => 'ID',
        'initial_balance' => 'Initial Balance',
        'currency' => 'Currency',
        'commission_per_lot' => 'Commission/Lot',
        'created' => 'Created',
        'actions' => 'Actions',
    ],

    // Empty state
    'empty' => [
        'title' => 'No accounts found',
        'message' => 'Get started by creating your first account',
        'create_button' => 'Create Account',
    ],

    // Action tooltips
    'actions' => [
        'view' => 'View Account',
        'edit' => 'Edit Account',
        'delete' => 'Delete Account',
    ],

    // Show page (Account Details)
    'show' => [
        'page_title' => 'Account Details',
        'page_subtitle' => 'View detailed information about this account',
        'back_button' => 'Back to Accounts',
        'edit_button' => 'Edit Account',
        'delete_button' => 'Delete Account',
        'account_header' => 'Account',

        // Basic Information Section
        'basic_info_title' => 'Basic Information',
        'account_id_label' => 'Account ID',
        'initial_balance_label' => 'Initial Balance',
        'currency_label' => 'Currency',
        'commission_label' => 'Commission/Lot',

        // Timestamps Section
        'timestamps_title' => 'Timestamps',
        'created_at_label' => 'Created At',
        'updated_at_label' => 'Last Updated',

        // Related Trades Section
        'related_trades_title' => 'Related Trades',
        'total_trades_label' => 'total',

        // Trades Table
        'trades_table' => [
            'id' => 'ID',
            'symbol' => 'Symbol',
            'type' => 'Type',
            'lots' => 'Lots',
            'date' => 'Date',
            'actions' => 'Actions',
            'buy_type' => 'Buy',
            'sell_type' => 'Sell',
            'view_trade' => 'View Trade',
        ],

        'showing_trades' => 'Showing :shown of :total trades',
        'no_trades_title' => 'No trades found',
        'no_trades_message' => 'This account doesn\'t have any trades yet',
    ],

    // Edit page
    'edit' => [
        'page_title' => 'Edit Account',
        'back_button' => 'Back to Account',

        // Form Labels
        'account_name_label' => 'Account Name',
        'account_name_placeholder' => 'e.g., Scalp Trading, Day Trade',
        'description_label' => 'Description',
        'description_placeholder' => 'e.g., For scalping EUR/USD on 5min timeframe',
        'initial_balance_label' => 'Initial Balance',
        'currency_label' => 'Currency',
        'currency_select_option' => 'Select Currency',
        'commission_label' => 'Commission per Lot ($)',
        'commission_help_text' => 'Commission charged per lot traded',

        // Buttons
        'cancel_button' => 'Cancel',
        'update_button' => 'Update Account',
    ],

    // Create page
    'create' => [
        'page_title' => 'Create New Account',
        'back_button' => 'Back to Accounts',

        // Form Labels
        'account_name_label' => 'Account Name',
        'account_name_placeholder' => 'e.g., Scalp Trading, Day Trade',
        'description_label' => 'Description',
        'description_placeholder' => 'e.g., For scalping EUR/USD on 5min timeframe',
        'initial_balance_label' => 'Initial Balance',
        'currency_label' => 'Currency',
        'currency_select_option' => 'Select Currency',
        'commission_label' => 'Commission per Lot ($)',
        'commission_help_text' => 'Default is $1.00 per lot',

        // Buttons
        'cancel_button' => 'Cancel',
        'create_button' => 'Create Account',
    ],

    // Delete modal
    'delete_modal' => [
        'title' => 'Delete Account',
        'account_to_delete' => 'Account to delete',
        'warning_message' => 'This action cannot be undone. All related trades will also be deleted.',
        'confirmation_instruction' => 'Please type the confirmation code below to delete',
        'input_placeholder' => 'Type DELETE_',
        'confirm_button' => 'Yes, delete it!',
        'cancel_button' => 'Cancel',
        'validation_error' => 'Please type',
        'loading_title' => 'Deleting Account',
        'loading_message' => 'Deleting',
    ],
];
