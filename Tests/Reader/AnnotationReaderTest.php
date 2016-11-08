<?php

namespace Ayrel\SeoBundle\Tests\Reader;

use Ayrel\SeoBundle\Annotation\SeoAnnotation as Seo;
use Ayrel\SeoBundle\Reader\AnnotationReader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class AnnotationReaderTest extends TestCase
{
    public function testAnnotationReader()
    {
        $reader = new AnnotationReader();
        $reader->setRequest(new Request());

        $this->assertTrue(!$reader->isAvailable());

        $request = new Request();
        $request->attributes->set("_controller", AnnotationReaderTest::class."::indexAction");

        $reader->setRequest($request);

        $this->assertTrue($reader->isAvailable());

        $this->assertEquals(
            [
                "title" => "my Website | {{_route}}",
                "description" => "this is the route {{_route}} of my website"
            ],
            $reader->getConfig()
        );
    }

    /**
      * @expectedException     \Exception
      */
    public function testNoRequest()
    {
        $reader = new AnnotationReader();
        $reader->getRequest();
    }

    public function testRequest()
    {
        $reader = new AnnotationReader();
        $request = new Request();
        $reader->setRequest($request);
        
        $this->assertEquals(
            $request,
            $reader->getRequest()
        );
    }

    /**
     * @Seo({
     *     "title": "my Website | {{_route}}",
     *     "description": "this is the route {{_route}} of my website"
     * })
     */
    public function indexAction()
    {
    }
}
