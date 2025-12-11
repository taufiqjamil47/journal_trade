<?php

namespace App\Exceptions;

use Exception;

class TradeException extends Exception
{
    /**
     * Report the exception.
     */
    public function report()
    {
        \Illuminate\Support\Facades\Log::error('Trade Exception: ' . $this->message, [
            'code' => $this->code,
            'file' => $this->file,
            'line' => $this->line,
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
                'error_code' => $this->code,
            ], 400);
        }

        return back()->withInput()->withErrors([
            'error' => $this->message,
        ]);
    }
}
