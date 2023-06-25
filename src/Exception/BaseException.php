<?php

namespace App\Exception;

use Exception;

class BaseException extends Exception
{

    private ?array $data;

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, array $data = [])
    {
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }

    public function getData(): array
    {
        return $this->data;
    }
}