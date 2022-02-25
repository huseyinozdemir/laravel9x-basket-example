<?php

namespace App\Exceptions;

use Exception;

class StockResponseException extends Exception
{
    public function render($request)
    {
        return response()->json(['error' => $this->message], $this->code);
    }
}
