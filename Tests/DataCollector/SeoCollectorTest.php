<?php

namespace Ayrel\SeoBundle\Tests\DataCollector;

use Ayrel\SeoBundle\DataCollector\SeoCollector;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SeoCollectorTest extends TestCase
{
    public function testCollector()
    {
        $data = [
            'title' => 'mon title',
            'meta' => [
                'description' => 'ma desc',
                'author' => 'laurent rossillol'
            ]
        ];

        $request = new Request();
        $request->attributes->set(
            'ayrel_seo.meta',
            $data
        );

        $request->attributes->set(
            'ayrel_seo.error',
            'new exception message...'
        );

        $coll = new SeoCollector();
        $coll->collect($request, new Response());

        $this->assertEquals(
            $coll->getTitle(),
            'mon title'
        );

        $this->assertEquals(
            $coll->getError(),
            'new exception message...'
        );

        $this->assertEquals(
            $coll->getMetas(),
            $data['meta']
        );

        $this->assertEquals(
            3,
            $coll->getSize()
        );

        $this->assertEquals(
            'seo',
            $coll->getName()
        );

        $coll->collect(new Request(), new Response());

        $this->assertNull($coll->getTitle());

        $this->assertEquals(
            0,
            count($coll->getMetas())
        );
    }
}
