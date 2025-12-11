@extends('Layouts.index')
@section('title', 'Trades')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-4">{{ $code ?? 'Error' }}</h1>
                <p class="lead">{{ $message ?? 'Something went wrong.' }}</p>

                @if (config('app.debug') && isset($exceptionMessage))
                    <pre class="text-left small bg-light p-3 mt-3">{{ $exceptionMessage }}</pre>
                @endif

                <div class="mt-4">
                    <a href="{{ url('/') }}" class="btn btn-primary">Home</a>
                    <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
                </div>

                <p class="text-muted mt-4 small">If this keeps happening, please contact the administrator.</p>
            </div>
        </div>
    </div>
@endsection
