<?php

namespace Ayrel\SeoBundle\Tests;

use Ayrel\SeoBundle\MetaResolver\TemplateResolver;
use Ayrel\SeoBundle\Renderer;
use Ayrel\SeoBundle\Renderer\TwigRenderer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RendererTest extends TestCase
{
    protected $data = ['title' => 'my Title'];

    public function getMockTplResolver()
    {
        $tplResolver = $this->getMockBuilder(TemplateResolver::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $tplResolver
            ->method('getMetaData')
            ->willReturn($this->data)
        ;

        return $tplResolver;
    }

    public function getMockDispatcher()
    {
        $dispatcher = $this->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $dispatcher
            ->method('dispatch')
            ->will($this->returnArgument(1));
        ;

        return $dispatcher;
    }

    public function getMockTwigRenderer()
    {
         $twigRenderer = $this->getMockBuilder(TwigRenderer::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        return $twigRenderer;
    }

    public function testGetMetaData()
    {
        $renderer = new Renderer($this->getMockTplResolver(), $this->getMockDispatcher());
        $this->assertEquals($this->data, $renderer->getMetaData());
    }

    public function testSelectStrategy()
    {
        $renderer = new Renderer($this->getMockTplResolver(), $this->getMockDispatcher());
        $twigRenderer = $this->getMockTwigRenderer();
        $renderer->addStrategy($twigRenderer, 'twig');
        $renderer->setSelectedStrategy('twig');

        $this->assertEquals(
            $twigRenderer,
            $renderer->getStrategy()
        );
    }

    public function testRender()
    {
        $renderer = new Renderer($this->getMockTplResolver(), $this->getMockDispatcher());
        $twigRenderer = $this->getMockTwigRenderer();
        
        $twigRenderer->method('render')
            ->willReturn($this->data);
        ;

        $renderer->addStrategy($twigRenderer, 'twig');
        $renderer->setSelectedStrategy('twig');
        
        $this->assertEquals(
            $this->data,
            $renderer->render()
        );
    }

    public function testRenderException()
    {
        $renderer = new Renderer($this->getMockTplResolver(), $this->getMockDispatcher());
        $twigRenderer = $this->getMockTwigRenderer();
        
        $twigRenderer->method('render')
            ->will($this->throwException(new \Exception('error')));
        ;

        $renderer->addStrategy($twigRenderer, 'twig');
        $renderer->setSelectedStrategy('twig');
        
        $this->assertEquals(
            null,
            $renderer->render()
        );
    }
}
