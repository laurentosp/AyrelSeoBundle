<?php

namespace Ayrel\SeoBundle\EventSubscriber;

use Ayrel\SeoBundle\Event\ExceptionEvent;
use Ayrel\SeoBundle\Event\MetaDataEvent;
use Ayrel\SeoBundle\Event\SeoEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LoggerSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return array(
            SeoEvent::POST_METADATA => array("onPostMetaData", 10),
            SeoEvent::EXCEPTION => array("onException", 10)
        );
    }

    public function onPostMetaData(MetaDataEvent $event)
    {
        if (isset($event->getMetaData()['title'])) {
            $this->logger->info(vsprintf(
                "%s : %s",
                array( 'title', $event->getMetaData()['title'])
            ));
        }

        foreach ($event->getMetaData()['meta'] as $key => $val) {
            $this->logger->info(vsprintf(
                "%s : %s",
                array( $key, $val)
            ));
        }
    }

    public function onException(ExceptionEvent $event)
    {
        $this->logger->error($event->getException()->getMessage());
    }
}
