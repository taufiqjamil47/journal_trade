@php
    $title = 'Server Error';
    $code = 500;
    $message = 'Terjadi kesalahan pada server. Silakan coba lagi atau hubungi administrator.';
    $exceptionMessage = isset($exception) ? $exception->getMessage() : null;
@endphp

@include('errors.error')
