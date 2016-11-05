<?php

namespace Ayrel\SeoBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SeoCollector extends DataCollector
{
    public function __construct($temp)
    {
    }

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = $request->attributes->get('ayrel_seo.meta');
    }

    public function getTitle()
    {
        if (!isset($this->data['title'])) {
            return null;
        }

        return $this->data['title'];
    }

    public function getMetas()
    {
        if (!isset($this->data['meta'])) {
            return [];
        }

        return $this->data['meta'];
    }

    public function getSize()
    {
        $size = 0;
        if ($this->getTitle()!==null) {
            $size++;
        }

        $size += count($this->getMetas());

        return $size;
    }

    public function getName()
    {
        return 'seo';
    }
}
