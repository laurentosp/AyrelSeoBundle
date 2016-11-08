<?php

namespace Ayrel\SeoBundle\Tests\Renderer;

use Ayrel\SeoBundle\Renderer\TwigRenderer;
use PHPUnit\Framework\TestCase;

class TwigRendererTest extends TestCase
{
    public function testRender()
    {
        $twig = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $html = '<title>my title</title>';
        $twig->method('render')
            ->willReturn($html)
        ;

        $twigRenderer = new TwigRenderer($twig);

        $this->assertEquals(
            $twigRenderer->render(['title' => 'my title']),
            $html
        );
    }
}
