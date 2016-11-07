<?php

namespace Ayrel\SeoBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class MetaDataEvent extends Event
{
    private $metadata;

    public function __construct($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
    * Get metadata
    * @return array
    */
    public function getMetadata()
    {
        return $this->metadata;
    }
    
    /**
    * Set metadata
    * @return $this
    */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }
}
