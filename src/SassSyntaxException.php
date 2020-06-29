<?php

namespace PhpAssets\Css\Sass;

use Throwable;
use InvalidArgumentException;
use PhpAssets\Css\SyntaxExceptionInterface;

class SassSyntaxException extends InvalidArgumentException implements SyntaxExceptionInterface
{
    /**
     * Create new SassSyntaxException exception.
     *
     * @param string $message
     * @param integer $line
     * @param integer $code
     * @param Throwable $previous
     */
    public function __construct(string $message = "", int $line = 0)
    {
        parent::__construct($message);

        $this->line = 0;
    }
}
