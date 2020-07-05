<?php

use Mockery as m;
use PhpAssets\Css\Sass\SassCompiler;
use PhpAssets\Css\Sass\SassSyntaxException;
use PHPUnit\Framework\TestCase;
use ScssPhp\ScssPhp;
use ScssPhp\ScssPhp\Exception\ParserException;

class SassCompilerAdapterTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function test_compile_method_passes_rwa_to_scss_php_compile()
    {
        $scss = m::mock(ScssPhp\Compiler::class);
        $scss->shouldReceive('compile')->withArgs(['dummy sass']);
        $compiler = new SassCompiler($scss);
        $compiler->compile('dummy sass');
    }

    public function test_compile_method_returns_compiled()
    {
        $scss = m::mock(ScssPhp\Compiler::class);
        $scss->shouldReceive('compile')->andReturn('css');
        $compiler = new SassCompiler($scss);
        $this->assertEquals('css', $compiler->compile('dummy sass'));
    }

    public function test_compile_method_catches_parser_error_and_throws_sass_syntax_exception()
    {
        $this->expectException(SassSyntaxException::class);
        $scss = m::mock(ScssPhp\Compiler::class);
        $scss->shouldReceive('compile')->andThrow(ParserException::class);
        $compiler = new SassCompiler($scss);
        $compiler->compile('dummy sass');
    }

    public function test_getSyntaxExceptionLine_method()
    {
        $scss = m::mock(ScssPhp\Compiler::class);
        $compiler = new SassCompiler($scss);

        try {
            (new ScssPhp\Compiler)->compile('
                body{
                    backgroundred;
                }
            ');
        } catch (ParserException $e) {
            $line = $this->callUnaccessibleMethod($compiler, 'getSyntaxExceptionLine', [$e]);
            $this->assertEquals(3, $line);
        }
    }

    protected function callUnaccessibleMethod($abstract, string $method, array $params = [])
    {
        $class = $abstract;
        if (! is_string($abstract)) {
            $class = get_class($abstract);
        }

        $class = new ReflectionClass($class);
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        if ($method->isStatic()) {
            return $method->invokeArgs(null, $params);
        }

        return $method->invokeArgs($abstract, $params);
    }
}
