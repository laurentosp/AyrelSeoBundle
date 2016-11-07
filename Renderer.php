<?php

namespace Ayrel\SeoBundle;

use Ayrel\SeoBundle\Event\ExceptionEvent;
use Ayrel\SeoBundle\Event\MetaDataEvent;
use Ayrel\SeoBundle\Event\SeoEvent;
use Ayrel\SeoBundle\MetaResolver\TemplateResolver;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 *
 */
class Renderer
{
    private $tplResolver;
    private $selectedStrategy;

    public function __construct(
        TemplateResolver $tplResolver,
        EventDispatcherInterface $dispacher,
        $selectedStrategy = 'response'
    ) {
        $this->dispacher = $dispacher;
        $this->tplResolver = $tplResolver;
        $this->selectedStrategy = $selectedStrategy;
    }

    public function addStrategy($renderer, $name)
    {
        $this->strategies[$name] = $renderer;
    }

    public function getStrategy()
    {
        return $this->strategies[$this->getSelectedStrategy()];
    }

    public function setSelectedStrategy($name)
    {
        $this->selectedStrategy = $name;
    }

    public function getSelectedStrategy()
    {
        return $this->selectedStrategy;
    }

    public function render()
    {
        try {
            return $this->getStrategy()->render(
                $this->getMetaData()
            );
        } catch (\Exception $e) {
            $event = new ExceptionEvent($e);
            $this->dispacher->dispatch(SeoEvent::EXCEPTION, $event);

            return null;
        }
    }

    public function getMetaData()
    {
        $metadata = $this->tplResolver->getMetaData();

        $event = new MetaDataEvent($metadata);
        $this->dispacher->dispatch(SeoEvent::POST_METADATA, $event);

        return $event->getMetaData();
    }
}
