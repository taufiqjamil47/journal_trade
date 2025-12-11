<?php

namespace App\Exceptions;

use Exception;

class DataNotFoundException extends Exception
{
    protected $resourceType;

    public function __construct($resourceType = "Resource", $id = null, $code = 404)
    {
        $this->resourceType = $resourceType;
        $message = $id ? "{$resourceType} dengan ID {$id} tidak ditemukan" : "{$resourceType} tidak ditemukan";
        parent::__construct($message, $code);
    }

    /**
     * Report the exception.
     */
    public function report()
    {
        \Illuminate\Support\Facades\Log::warning('Data Not Found: ' . $this->message);
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
                'resource_type' => $this->resourceType,
            ], 404);
        }

        return back()->with('error', $this->message);
    }
}
