<?php

if (! function_exists('format_price')) {
    /**
     * Format harga desimal untuk ditampilkan sesuai dengan panjang bagian bilangan bulat:
     * - Jika bagian bilangan bulat memiliki 2 digit atau lebih (>=10) -> tampilkan 3 angka desimal
     * - Jika tidak -> tampilkan 5 angka desimal
     * * Contoh:
     * - 1.34325 -> 1.34325 (5 angka desimal)
     * - 134.87432 -> 134.874 (3 angka desimal)
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

        // Jika bagian bilangan bulat memiliki 2 digit atau lebih (>=10), gunakan 3 angka desimal, jika tidak, gunakan 5 angka desimal
        $decimals = ($intPart >= 10) ? 3 : 5;

        // Gunakan titik sebagai pemisah desimal dan tanpa pemisah ribuan
        return number_format($float, $decimals, '.', '');
    }
}
