<?php

namespace App\Exceptions;

use Exception;

class ImportException extends Exception
{
    protected $rowNumber;
    protected $details = [];

    public function __construct($message = "Import failed", $rowNumber = null, $details = [], $code = 400)
    {
        parent::__construct($message, $code);
        $this->rowNumber = $rowNumber;
        $this->details = $details;
    }

    public function getRowNumber()
    {
        return $this->rowNumber;
    }

    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Report the exception.
     */
    public function report()
    {
        \Illuminate\Support\Facades\Log::error('Import Exception: ' . $this->message, [
            'row_number' => $this->rowNumber,
            'details' => $this->details,
        ]);
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render($request)
    {
        $message = $this->message;
        if ($this->rowNumber) {
            $message .= " (Row {$this->rowNumber})";
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'row_number' => $this->rowNumber,
                'details' => $this->details,
            ], 400);
        }

        return back()->with('error', $message);
    }
}
