<?php

namespace Ayrel\SeoBundle\Tests\EventSubscriber;

use Ayrel\SeoBundle\EventSubscriber\DataCollectorSubscriber;
use Ayrel\SeoBundle\Event\ExceptionEvent;
use Ayrel\SeoBundle\Event\MetaDataEvent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class DataCollectorSubscriberTest extends TestCase
{
    public function testSub()
    {
        $data = ['title' => 'my title'];
        $dataSub = new DataCollectorSubscriber($this->getMockRequestStack());
        $event = new MetaDataEvent($data);

        $dataSub->onPostMetaData($event);

        $this->assertEquals(
            $dataSub->getRequest()->attributes->get('ayrel_seo.meta'),
            $data
        );

        $dataSub->onException(
            new ExceptionEvent(new \Exception('mon message...'))
        );

        $this->assertEquals(
            $dataSub->getRequest()->attributes->get('ayrel_seo.error'),
            'mon message...'
        );

        $this->assertContains(
            'onPostMetaData',
            $dataSub->getSubscribedEvents()['ayrel_seo.post_metadata']
        );
    }

    public function getMockRequestStack()
    {
        
        $requestStack = new RequestStack();
        $requestStack->push(new Request());

        return $requestStack;
    }
}
