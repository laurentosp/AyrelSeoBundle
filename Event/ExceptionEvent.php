<?php

namespace Ayrel\SeoBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class ExceptionEvent extends Event
{
    private $exception;

    public function __construct(\Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
    * Get exception
    * @return \Exception
    */
    public function getException()
    {
        return $this->exception;
    }
    
    /**
    * Set exception
    * @return $this
    */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
        return $this;
    }
}
