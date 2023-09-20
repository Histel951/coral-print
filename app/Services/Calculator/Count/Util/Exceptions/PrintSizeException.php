<?php

namespace App\Services\Calculator\Count\Util\Exceptions;

use Throwable;

class PrintSizeException extends \Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
        private readonly array $parameters = [],
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Возвращает параметры переданные с ошибкой
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
