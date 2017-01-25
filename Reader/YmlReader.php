<?php

namespace Ayrel\SeoBundle\Reader;

use Symfony\Component\Yaml\Yaml;

class YmlReader extends AbstractReader
{
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getYaml()
    {
        if (!is_file($this->path)) {
            return null;
        }

        return Yaml::parse(file_get_contents($this->path));
    }

    public function getRoute()
    {
        $route = $this->request->attributes->get('_route');
        
        if (!$route) {
            throw new \Exception('no route given !!');
        }

        return $route;
    }

    public function isAvailable()
    {
        if (!$this->getYaml()) {
            return false;
        }

        return array_key_exists($this->getRoute(), $this->getYaml());
    }

    public function getConfig()
    {
        $readerConfig = $this->getYaml()[$this->getRoute()];

        return ($readerConfig===null) ? [] : $readerConfig;
    }
}
