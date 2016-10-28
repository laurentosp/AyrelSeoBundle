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
        $this->request = $requestStack->getCurrentRequest();
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

        throw new \Exception('no reader was found');
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
