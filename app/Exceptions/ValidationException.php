<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    protected $errors = [];

    public function __construct($message = "Validation failed", $errors = [], $code = 422)
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Report the exception.
     */
    public function report()
    {
        \Illuminate\Support\Facades\Log::warning('Validation Exception: ' . $this->message, [
            'errors' => $this->errors,
        ]);
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $this->message,
                'errors' => $this->errors,
            ], 422);
        }

        return back()->withInput()->withErrors($this->errors);
    }
}
