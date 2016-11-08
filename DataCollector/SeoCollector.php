<?php

namespace Ayrel\SeoBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SeoCollector extends DataCollector
{
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array(
            'meta' => $request->attributes->get('ayrel_seo.meta'),
            'error' => $request->attributes->get('ayrel_seo.error')
        );
    }

    public function getError()
    {
        
        return $this->data['error'];
    }

    public function getTitle()
    {
        if (!isset($this->data['meta']['title'])) {
            return null;
        }

        return $this->data['meta']['title'];
    }

    public function getMetas()
    {
        if (!isset($this->data['meta']['meta'])) {
            return [];
        }

        return $this->data['meta']['meta'];
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
