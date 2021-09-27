<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class InvalidConfirmationCodeException extends Exception
{
    public function report(Exception $exception)
    {
        Log::info($exception->getMessage());
    }
}
