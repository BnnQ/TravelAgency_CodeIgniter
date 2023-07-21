<?php

namespace Exceptions;

use Exception;
use Throwable;

class UnsetuppedBuilderException extends Exception
{
    public function __construct(string $message = "You must initialize all required fields using builder before calling build()", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}