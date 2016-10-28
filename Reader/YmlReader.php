<?php

namespace Ayrel\SeoBundle\Reader;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Yaml\Yaml;

class YmlReader extends AbstractReader
{
    public function __construct(RequestStack $requestStack, $path)
    {
        parent::__construct($requestStack);
        $this->yaml = Yaml::parse(file_get_contents($path));
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
        return isset($this->yaml[$this->getRoute()]);
    }

    public function getConfig()
    {
        return $this->yaml[$this->getRoute()];
    }
}
