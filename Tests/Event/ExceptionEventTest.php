<?php

namespace Ayrel\SeoBundle\Tests\Event;

use Ayrel\SeoBundle\Event\ExceptionEvent;
use PHPUnit\Framework\TestCase;

class ExceptionEventTest extends TestCase
{
    public function testMetaDataEvent()
    {
        $exception = new \Exception('mon exception');
        $event = new ExceptionEvent($exception);

        $event->setException($exception);

        $this->assertEquals(
            $exception,
            $event->getException()
        );
    }
}
