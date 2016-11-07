<?php

namespace Ayrel\SeoBundle\Reader;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractReader
{
    protected $request;

    /**
    * Get request
    * @return Request
    */
    public function getRequest()
    {
        if ($this->request===null) {
            throw new \Exception('request is not set');
        }

        return $this->request;
    }
    
    /**
    * Set request
    * @return $this
    */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }

    abstract public function getConfig();

    abstract public function isAvailable();
}
