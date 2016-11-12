<?php

namespace Ayrel\SeoBundle\EventListener;

use Ayrel\SeoBundle\Renderer;
use Ayrel\SeoBundle\Renderer\ResponseRenderer;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class SeoListener
{
    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }


    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->attributes->get('_route')===null) {
            return;
        }

        if ($request->isXmlHttpRequest()) {
            return;
        }

        if (strstr($request->attributes->get('_controller'), "::")===false) {
            return ;
        }

        $strategy = $this->renderer->getStrategy();

        if (!$strategy instanceof ResponseRenderer) {
            throw new \Exception('strategy must be response for event');
        }

        $response = $event->getResponse();
        $strategy->setResponse($response);
        
        $content = $this->renderer->render();
        if ($content===null) {
            return ;
        }

        $response->setContent($content);
        $event->setResponse($response);
    }
}
