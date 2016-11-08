<?php

namespace Ayrel\SeoBundle\Tests\Event;

use Ayrel\SeoBundle\Event\MetaDataEvent;
use PHPUnit\Framework\TestCase;

class MetaDataEventTest extends TestCase
{
    public function testMetaDataEvent()
    {
        $data = ['title' => "mon titre"];
        $event = new MetaDataEvent($data);

        $event->setMetaData($data);

        $this->assertEquals(
            $data,
            $event->getMetaData()
        );
    }
}
