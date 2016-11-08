<?php

namespace Ayrel\SeoBundle\Tests\Event;

use Ayrel\SeoBundle\Event\PreConfigEvent;
use PHPUnit\Framework\TestCase;

class PreConfigEventTest extends TestCase
{
    public function testEvent()
    {
        $context = ["price" => 23];
        $config = ["title" => "{{price}} €"];
        
        $event = new PreConfigEvent("product", $context);

        $event->setRoute("product");
        $this->assertEquals(
            "product",
            $event->getRoute()
        );

        $event->setContext($context);
        $this->assertEquals(
            $context,
            $event->getContext()
        );

        $event->setConfig($config);
        $this->assertEquals(
            $config,
            $event->getConfig()
        );
    }
}
