<?php
return [
    'title' => 'Symbols',
    'header_title' => 'Trading Symbols',
    'header_subtitle' => 'Your trading symbol groups',
    'trader_label' => 'Trader',

    // Table
    'table_title' => 'Symbols List',
    'total_symbols' => 'Total: :count Symbols',
    'add_symbol_button' => 'Add Symbol',
    'add_first_symbol_button' => 'Add First Symbol',

    // Table columns
    'column_id' => 'ID',
    'column_name' => 'Name',
    'column_pip_value' => 'Pip Value',
    'column_pip_worth' => 'Pip Value',
    'column_active' => 'Active',
    'column_actions' => 'Action',

    // Status
    'status_active' => 'Active',
    'status_inactive' => 'Inactive',

    // Buttons
    'edit_button_title' => 'Edit Symbol',
    'delete_button_title' => 'Delete Symbol',

    // Empty state
    'no_symbols_title' => 'No symbols yet',
    'no_symbols_subtitle' => 'Start adding your first symbol',

    // Delete modal
    'delete_modal_title' => 'Delete Symbol?',
    'delete_modal_symbol_to_delete' => 'Symbol to be deleted:',
    'delete_modal_warning' => 'Trades using this symbol will remain',
    'delete_modal_confirm_prompt' => 'Type confirmation:',
    'delete_modal_input_placeholder' => 'Enter the confirmation code...',
    'delete_modal_confirm_button' => 'Delete Symbol',
    'delete_modal_cancel_button' => 'Cancel',
    'delete_modal_validation_message_part1' => 'Please type ',
    'delete_modal_validation_message_part2' => '',
    'delete_loading_title' => 'Delete...',
    'delete_loading_message' => 'Delete the symbol ":name"...',

    // Create page
    'create_title' => 'Create New Symbol',
    'create_header_title' => 'Add New Symbol',
    'create_header_subtitle' => 'Add new trading symbol to the system',
    'back_to_list' => 'Symbols List',

    // Form errors
    'form_error_title' => 'There was an error filling out the form:',

    // Form sections
    'form_section_title' => 'New Symbol Information',
    'form_section_subtitle' => 'Fill in all the required information to add a new symbol',

    // Form labels and placeholders
    'form_name_label' => 'Symbol Name',
    'form_name_placeholder' => 'Example: EURUSD',
    'form_name_help' => 'Trading symbol name (example: EURUSD, GBPUSD, XAUUSD)',

    'form_pip_value_label' => 'Pip Value',
    'form_pip_value_placeholder' => 'Example: 0.0001',
    'form_pip_value_help' => 'Value per pip in the quote currency (usually 0.0001 for forex)',

    'form_pip_worth_label' => 'Pip Value (USD per pip per lot)',
    'form_pip_worth_placeholder' => 'Example: 10.00',
    'form_pip_worth_help' => 'USD value per pip for 1 standard lot (default: 10)',

    'form_pip_position_label' => 'Pip Position',
    'form_pip_position_placeholder' => 'Example: 4 (for most pairs)',
    'form_pip_position_help' => 'Decimal position for pips (usually 4 for forex, 2 for JPY pairs)',

    'form_status_label' => 'Symbol Status',
    'form_status_help' => 'Determine whether this symbol is active for trading',

    // Form buttons
    'cancel_button' => 'Cancel',
    'back_button' => 'Back',
    'submit_button' => 'Add Symbol',

    // Tips section
    'tips_title' => 'Tips for Adding Symbols',
    'tip_format_title' => 'Symbol Format',
    'tip_format_description' => 'Use standard formats such as <code class="text-primary-400 font-mono">EURUSD</code> for currency pairs or <code class="text-primary-400 font-mono">XAUUSD</code> for gold.',

    'tip_pip_value_title' => 'Pip Value',
    'tip_pip_value_description' => 'For forex, the pip value is usually <code class="text-green-400 font-mono">0.0001</code>. For pairs with JPY, its usually <code class="text-green-400 font-mono">0.01</code>.',

    'tip_pip_worth_title' => 'Pip Worth',
    'tip_pip_worth_description' => 'The default value of <code class="text-blue-400 font-mono">10</code> is standard for most forex pairs. Adjust if necessary.',

    'tip_status_title' => 'Active Status',
    'tip_status_description' => 'Disables the symbol if its temporarily unused. Historical data is retained.',

    // Status (already in the previous file, but for reference)
    'status_active' => 'Active',
    'status_inactive' => 'Inactive',

    // Edit page
    'edit_title' => 'Edit Symbol',
    'edit_header_title' => 'Edit Symbol',
    'edit_header_subtitle' => 'Update trading symbol information',
    'status_active_description' => 'This symbol is active for trading',
    'status_inactive_description' => 'This symbol is not active for trading',

    // Form info
    'form_info_title' => 'Symbol Information',
    'form_id_label' => 'ID:',

    // Form help text (edit specific)
    'edit_pip_value_help' => 'Value per pip in quote currency',
    'edit_pip_worth_help' => 'USD value per pip for 1 standard lot',
    'edit_pip_position_help' => 'Decimal position for pip (usually 4 for forex)',

    // Status section
    'edit_status_title' => 'Trading Status',
    'edit_status_subtitle' => 'Enable or disable symbol for trading',
    'edit_current_status_label' => 'Current Status',

    // Form buttons (edit specific)
    'edit_submit_button' => 'Save Changes',

    // Current info section
    'current_info_title' => 'Current Information',
    'current_symbol_label' => 'Symbol',
    'current_pip_value_label' => 'Pip Value',
    'current_status_label' => 'Status',
    'last_updated_label' => 'Last Updated',

    // Status (already exists, but for reference)
    'status_active' => 'Active',
    'status_inactive' => 'Inactive',

    // Form buttons (shared with create)
    'cancel_button' => 'Cancel',
    'back_button' => 'Back',
    'back_to_list' => 'Symbols List',
    'form_error_title' => 'There was an error in filling out the form:',

    // Form labels (shared with create) 
    'form_name_label' => 'Symbol Name',
    'form_name_placeholder' => 'Example: EURUSD',
    'form_pip_value_label' => 'Pip Value',
    'form_pip_value_placeholder' => 'Example: 0.0001',
    'form_pip_worth_label' => 'Pip Worth (USD per pip per 1 lot)',
    'form_pip_worth_placeholder' => 'Example: 10.00',
    'form_pip_position_label' => 'Pip Position',
    'form_pip_position_placeholder' => 'Example: 4 (for most pairs)',
];
