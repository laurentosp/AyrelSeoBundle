<?php

namespace Ayrel\SeoBundle\Configurator;

use Symfony\Component\Yaml\Yaml;

class SimpleConfigurator
{
    private $readers = [];

    public function addReader($reader)
    {
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
