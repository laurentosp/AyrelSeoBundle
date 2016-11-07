<?php

namespace Ayrel\SeoBundle\Configurator;

use Ayrel\SeoBundle\Config\ConfigTemplateFactory;
use Ayrel\SeoBundle\Reader\AbstractReader;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Ayrel\SeoBundle\Event\SeoEvent;
use Ayrel\SeoBundle\Event\PreConfigEvent;

class SimpleConfigurator
{
    private $readers = [];
    private $request;
    private $configTemplateFactory;

    public function __construct(
        RequestStack $requestStack,
        EventDispatcherInterface $dispatcher,
        ConfigTemplateFactory $configTemplateFactory
    ) {
        $this->request = $requestStack->getMasterRequest();
        $this->configTemplateFactory = $configTemplateFactory;
        $this->dispatcher = $dispatcher;
    }

    public function addReader(AbstractReader $reader)
    {
        if ($this->request) {
            $reader->setRequest($this->request);
        }
        $this->readers[] = $reader;
    }

    private function getReader()
    {
        foreach ($this->readers as $reader) {
            if ($reader->isAvailable()) {
                return $reader;
            }
        }

        throw new \Exception(sprintf(
            'no reader was found for route %s',
            $this->getRoute()
        ));
    }

    public function getConfig()
    {
        $event = new PreConfigEvent($this->getRoute(), $this->getContext());
        $this->dispatcher->dispatch(SeoEvent::PRE_CONFIG, $event);

        $config = $event->getConfig();

        if ($config===null) {
            $config = $this->getReader()->getConfig();
        }

        return $this->configTemplateFactory
            ->createConfigTemplate($config)
            ->all()
        ;
    }

    public function getRoute()
    {
        return $this->request->attributes->get('_route');
    }

    public function getContext()
    {
        return $this->getRequest()->attributes->all();
    }

    public function getRequest()
    {
        return $this->request;
    }
}
