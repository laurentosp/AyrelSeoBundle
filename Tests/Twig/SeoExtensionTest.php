<?php

namespace AyrelSeoBundle\Tests\Twig;

use Ayrel\SeoBundle\Renderer;
use Ayrel\SeoBundle\Twig\SeoExtension;
use PHPUnit\Framework\TestCase;

class SeoExtensionTest extends TestCase
{
    public function testExtension()
    {
        $render = $this->getMockBuilder(Renderer::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $render->method('render')
            ->willReturn('<title>title</title>');

        $ext = new SeoExtension($render);

        $ext->getFunctions();

        $ext->seo();
    }
}
