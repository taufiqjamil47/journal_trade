<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException as LaravelValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // Handle custom exceptions
        $this->reportable(function (TradeException $e) {
            \Illuminate\Support\Facades\Log::error('Trade error: ' . $e->getMessage());
        });

        $this->reportable(function (ValidationException $e) {
            \Illuminate\Support\Facades\Log::warning('Validation error: ' . $e->getMessage());
        });

        $this->reportable(function (DataNotFoundException $e) {
            \Illuminate\Support\Facades\Log::warning('Not found: ' . $e->getMessage());
        });

        $this->reportable(function (ImportException $e) {
            \Illuminate\Support\Facades\Log::error('Import error: ' . $e->getMessage());
        });

        // Handle generic database exceptions
        $this->reportable(function (ModelNotFoundException $e) {
            \Illuminate\Support\Facades\Log::warning('Model not found: ' . $e->getMessage());
        });

        // Handle generic validation exceptions
        $this->renderable(function (LaravelValidationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }
        });

        // Log all other exceptions
        $this->reportable(function (Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Unexpected error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null,
            ]);
        });
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Handle 404s gracefully
        if ($exception instanceof ModelNotFoundException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resource not found',
                ], 404);
            }
            return response()->view('errors.404', [], 404);
        }

        // Handle validation errors
        if ($exception instanceof LaravelValidationException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $exception->errors(),
                ], 422);
            }
        }

        return parent::render($request, $exception);
    }
}
