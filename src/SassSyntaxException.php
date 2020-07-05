<?php

namespace PhpAssets\Css\Sass;

use ParseError;
use PhpAssets\Css\SyntaxExceptionInterface;

class SassSyntaxException extends ParseError implements SyntaxExceptionInterface
{
    /**
     * Line in which the syntax exception occurres.
     *
     * @var int
     */
    protected $syntaxExceptionLine;

    /**
     * Create new SassSyntaxException exception.
     *
     * @param  string $message
     * @param  int    $line
     * @return void
     */
    public function __construct(string $message = '', int $line = 0)
    {
        parent::__construct($message);

        $this->syntaxExceptionLine = $line;
    }

    /**
     * Gets the line in which the parser error occurres.
     *
     * @return int
     */
    public function getSyntaxExceptionLine()
    {
        return $this->syntaxExceptionLine;
    }
}
