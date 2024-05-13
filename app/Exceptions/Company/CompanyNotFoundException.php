<?php

namespace App\Exceptions\Company;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CompanyNotFoundException extends Exception
{
    public function __construct(string $message = null, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message ?? getMessage('company_not_found'), $code, $previous);
    }

    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::info('Company not found');
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return responseFailed(getMessage('company not found'), 404);
    }
}
