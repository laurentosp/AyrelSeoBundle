<?php

namespace Ayrel\SeoBundle\Tests\EventSubscriber;

use Ayrel\SeoBundle\EventSubscriber\LoggerSubscriber;
use Ayrel\SeoBundle\Event\ExceptionEvent;
use Ayrel\SeoBundle\Event\MetaDataEvent;
use Psr\Log\LoggerInterface;
use PHPUnit\Framework\TestCase;

class LoggerSubscriberTest extends TestCase
{
    public function testLoggerSub()
    {
        $data = ['title' => 'my title', 'meta' => ['description' => 'my description']];
        $logSub = new LoggerSubscriber($this->getMockLogger());
        
        $event = new MetaDataEvent($data);
        $logSub->onPostMetaData($event);

        $event = new ExceptionEvent(new \Exception('mon message'));
        $logSub->onException($event);

        $this->assertContains(
            'onPostMetaData',
            $logSub->getSubscribedEvents()['ayrel_seo.post_metadata']
        );
    }

    public function getMockLogger()
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        return $logger;
    }
}
