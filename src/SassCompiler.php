<?php

namespace PhpAssets\Css\Sass;

use PhpAssets\Css\CompilerInterface;
use ScssPhp\ScssPhp;
use ScssPhp\ScssPhp\Exception\ParserException;

/**
 * A compiler adapter for the scssphp\scssphp sass compiler.
 *
 * @see https://github.com/scssphp/scssphp
 */
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
     *
     * @return void
     */
    public function __construct(ScssPhp\Compiler $scss)
    {
        $this->scss = $scss;
    }

    /**
     * Compile Sass to CSS.
     *
     * @param  string $raw
     * @return string
     */
    public function compile($raw)
    {
        try {
            return $this->scss->compile($raw);
        } catch (ParserException $e) {
            throw new SassSyntaxException(
                $e->getMessage(),
                $this->getSyntaxExceptionLine($e)
            );
        }
    }

    /**
     * Get syntax exception line from parser exception.
     *
     * @param  ParserException $e
     * @return int
     */
    protected function getSyntaxExceptionLine(ParserException $e)
    {
        if (count($partials = explode('line ', $e->getMessage())) == 1) {
            return 0;
        }

        if (count($partials = explode(',', $partials[1])) == 1) {
            return 0;
        }

        return (int) $partials[0];
    }
}
