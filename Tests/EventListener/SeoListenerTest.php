<?php

namespace AyrelSeoBundle\Tests\EventListener;

use Ayrel\SeoBundle\EventListener\SeoListener;
use Ayrel\SeoBundle\Renderer;
use Ayrel\SeoBundle\Renderer\ResponseRenderer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class SeoListenerTest extends TestCase
{
    public function setUp()
    {
        $this->responseRender = $this->getResponseRender();
        $this->request = new Request();
        $this->renderer = $this->getRenderer();
    }

    public function throwEvent()
    {
        $listener = new SeoListener($this->renderer);
        $event = $this->getFilterResponseEvent($this->request);
        $listener->onKernelResponse($event);
    }

    public function testNoRoute()
    {
        $this->throwEvent();
    }

    public function testIsXmlHttpRequest()
    {
        $this->request->attributes->set('_route', 'homepage');
        $this->request->headers->replace(array(
            'X-Requested-With' => "XMLHttpRequest"
        ));

        $this->assertEquals(
            $this->request->attributes->get('_route'),
            'homepage'
        );
        $this->throwEvent();
    }

    public function testNoStdController()
    {
        $this->request->attributes->set('_route', 'homepage');
        $this->request->attributes->set('_controller', 'DefaultController:index');
        $this->throwEvent();
    }

    public function testNoContent()
    {
        $this->request->attributes->set('_route', 'homepage');
        $this->request->attributes->set('_controller', 'DefaultController::index');
        $this->throwEvent();
    }

    public function testStd()
    {
        $this->request->attributes->set('_route', 'homepage');
        $this->request->attributes->set('_controller', 'DefaultController::index');
        $this->renderer->method('render')
            ->willReturn('<html></html>');

        $this->throwEvent();
    }

    /**
     * @expectedException \Exception
     */
    public function testNoStrategy()
    {
        $renderer = $this->getMockBuilder(Renderer::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $renderer
            ->method('getStrategy')
            ->willReturn(null);

        $this->renderer = $renderer;

        $this->request->attributes->set('_route', 'homepage');
        $this->request->attributes->set('_controller', 'DefaultController::index');

        $this->throwEvent();
    }

    public function getFilterResponseEvent($request)
    {
        $kernel = $this->getMockBuilder(HttpKernelInterface::class)
            ->getMock();

        $event = new FilterResponseEvent(
            $kernel,
            $request,
            HttpKernelInterface::MASTER_REQUEST,
            new Response()
        );

        return $event;
    }

    public function getRenderer()
    {
        $renderer = $this->getMockBuilder(Renderer::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $renderer
            ->method('getStrategy')
            ->willReturn($this->responseRender);

        return $renderer;
    }

    public function getResponseRender()
    {
        $responseRender = $this->getMockBuilder(ResponseRenderer::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        return $responseRender;
    }
}
