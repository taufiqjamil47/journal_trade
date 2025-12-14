<?php

if (! function_exists('format_price')) {
    /**
     * Format a decimal price for display according to integer part length:
     * - If integer part has 2 or more digits (>=10) -> show 3 decimals
     * - Otherwise -> show 5 decimals
     *
     * Examples:
     *  - 1.34325  -> 1.34325 (5 decimals)
     *  - 134.87432 -> 134.874 (3 decimals)
     *
     * @param  float|string|null  $value
     * @return string
     */
    function format_price($value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        // Ensure numeric
        if (! is_numeric($value)) {
            return (string) $value;
        }

        $float = (float) $value;
        $abs = abs($float);
        $intPart = (int) floor($abs);

        // If integer part has 2+ digits (>=10), use 3 decimals, else 5
        $decimals = ($intPart >= 10) ? 3 : 5;

        // Use dot as decimal separator and no thousands separator
        return number_format($float, $decimals, '.', '');
    }
}
