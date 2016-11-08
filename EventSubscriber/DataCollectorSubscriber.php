<?php

namespace Ayrel\SeoBundle\EventSubscriber;

use Ayrel\SeoBundle\Event\ExceptionEvent;
use Ayrel\SeoBundle\Event\MetaDataEvent;
use Ayrel\SeoBundle\Event\SeoEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class DataCollectorSubscriber implements EventSubscriberInterface
{
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
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
        $this->request->attributes->set(
            'ayrel_seo.meta',
            $event->getMetaData()
        );
    }

    public function onException(ExceptionEvent $event)
    {
        $this->request->attributes->set(
            'ayrel_seo.error',
            $event->getException()->getMessage()
        );
    }

    public function getRequest()
    {
        return $this->request;
    }
}
