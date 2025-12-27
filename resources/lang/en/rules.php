<?php
return [
    'title' => 'Trading Rules Management',

    'header' => [
        'title' => 'Trading Rules Management',
        'subtitle' => 'Manage your list of trading rules for better evaluation',
    ],

    'stats' => [
        'total_rules' => 'Total Rules',
        'active_rules' => 'Active Rules',
        'inactive_rules' => 'Inactive Rules',
        'last_updated' => 'Last Updated',
    ],

    'table' => [
        'title' => 'List of Trading Rules',
        'total' => 'Total: :count rules',
        'search_placeholder' => 'Search for rules...',
        'sort_by' => 'Sort',
        'sort_name_asc' => 'Name (A-Z)',
        'sort_name_desc' => 'Name (Z-A)',
        'sort_order_asc' => 'Order (Lowest)',
        'sort_order_desc' => 'Order (Highest)',
        'add_new_rule' => 'Add New Rule',

        'columns' => [
            'name' => 'Rule Name',
            'description' => 'Description',
            'status' => 'Status',
            'order' => 'Order',
            'actions' => 'Action',
        ],

        'empty' => [
            'title' => 'No Rules Yet',
            'message' => 'Start by creating your first trading rule',
            'add_first_rule' => 'Add First Rule',
        ],
    ],

    'status' => [
        'active' => 'ACTIVE',
        'inactive' => 'INACTIVE',
    ],

    'actions' => [
        'edit' => 'Edit Rule',
        'delete' => 'Delete Rule',
    ],

    'tips' => [
        'title' => 'Tips for Using Trading Rules',
        'tip1' => 'Sort rules by priority with the arrow keys',
        'tip2' => 'Disable unused rules without deleting them',
        'tip3' => 'Use description for a detailed explanation of the rule',
        'tip4' => 'Rules will appear in the trade evaluation form',
    ],

    'modal' => [
        'create_title' => 'Add New Rule',
        'create_subtitle' => 'Set trading rule details for evaluation',
        'edit_title' => 'Edit Rule',
        'edit_subtitle' => 'Update trading rule details',

        'fields' => [
            'name' => [
                'label' => 'Rule Name',
                'placeholder' => 'Example: Time 7:00 AM (Forex) - 8:00 AM (Indexes)',
            ],
            'description' => [
                'label' => 'Description (Optional)',
                'placeholder' => 'Detailed explanation of the rule, example, or additional notes...',
            ],
            'order' => [
                'label' => 'Display Order',
                'placeholder' => 'Order number (lower = higher)',
            ],
            'status' => [
                'label' => 'Rule Status',
                'active' => 'Active',
                'active_desc' => 'Appears in the evaluation form',
                'inactive' => 'Inactive',
                'inactive_desc' => 'Does not appear in the form',
            ],
        ],

        'buttons' => [
            'cancel' => 'Cancel',
            'save' => 'Save Rule',
            'update' => 'Update Rule',
        ],
    ],

    'delete' => [
        'title' => 'Delete Rule?',
        'rule_to_delete' => 'Rule to be deleted',
        'warning_used' => 'Rules already used in the trade evaluation will remain saved',
        'confirm_text' => 'To confirm, type:',
        'input_placeholder' => 'Enter the confirmation code...',
        'confirm_button' => 'Delete Rule',
        'cancel_button' => 'Cancel',
        'validation_message' => 'Please enter :code', // Change this
        'deleting' => 'Deleting...',
        'deleting_message' => 'Deleting rule ":name"...',
    ],

    'messages' => [
        'success' => 'Success!',
        'error' => 'Failed',
        'order_updated' => 'Rules order has been updated',
        'order_failed' => 'Updating rule order failed',
        'order_error' => 'Error updating order',
        'order_save_failed' => 'Failed to save new order',
    ],
];
