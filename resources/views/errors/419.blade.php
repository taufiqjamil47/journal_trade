@php
    $title = 'Session Expired';
    $code = 419;
    $message = 'Permintaan kedaluwarsa (CSRF token). Silakan muat ulang halaman dan coba lagi.';
@endphp

@include('errors.error')
