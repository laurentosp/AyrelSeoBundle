<?php

namespace Ayrel\SeoBundle\Configurator;

use Ayrel\SeoBundle\Reader\AbstractReader;
use Symfony\Component\HttpFoundation\RequestStack;

class SimpleConfigurator
{
    private $readers = [];
    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getMasterRequest();
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
            $this->request->attributes->get('_route')
        ));
    }

    public function getConfig()
    {
        $config = $this->getReader()->getConfig();

        foreach ($config as $key => $val) {
            $config[$key] = strip_tags($val);
        }

        return $config;
    }

    public function getContext()
    {
        return $this->getReader()->getContext();
    }
}
