<?php

namespace PhpAssets\Css\Sass;

use ScssPhp\ScssPhp;
use PhpAssets\Css\CompilerInterface;
use ScssPhp\ScssPhp\Exception\ParserException;

class SassCompiler implements CompilerInterface
{
    /**
     * Scss compiler.
     *
     * @var \ScssPhp\ScssPhp\Compiler
     */
    protected $scss;

    /**
     * Create new SassCompiler instance.
     */
    public function __construct()
    {
        $this->scss = new ScssPhp\Compiler;
    }

    /**
     * Compile Sass to CSS.
     *
     * @param string $raw
     * @return string
     */
    public function compile($raw)
    {
        try {
            return $this->scss->compile($raw);
        } catch (ParserException $e) {
            $line = (int) explode(',', explode('line ', $e->getMessage())[1])[0];

            throw new SassSyntaxException($e->getMessage(), $line);
        }
    }
}
