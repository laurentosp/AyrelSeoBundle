<?php

namespace Ayrel\SeoBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class PreConfigEvent extends Event
{
    private $route;

    private $context;

    private $config = null;

    public function __construct($route, $context)
    {
        $this->route = $route;
        $this->context = $context;
    }

    /**
    * Get route
    * @return string
    */
    public function getRoute()
    {
        return $this->route;
    }
    
    /**
    * Set route
    * @return $this
    */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
    * Get context
    * @return array
    */
    public function getContext()
    {
        return $this->context;
    }
    
    /**
    * Set context
    * @return $this
    */
    public function setContext($context = [])
    {
        $this->context = $context;
        return $this;
    }

    /**
    * Get config
    * @return array
    */
    public function getConfig()
    {
        return $this->config;
    }
    
    /**
    * Set config
    * @return $this
    */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }
}
