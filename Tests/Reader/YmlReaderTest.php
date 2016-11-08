<?php

namespace Ayrel\SeoBundle\Tests\Reader;

use Ayrel\SeoBundle\Reader\YmlReader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class YmlReaderTest extends TestCase
{
    public function testYmlReader()
    {
        $reader = new YmlReader(__DIR__."/test2.yml");

        $this->assertNull(
            $reader->getYaml()
        );

        $this->assertTrue(
            !$reader->isAvailable()
        );

        $reader = new YmlReader(__DIR__."/test.yml");

        $request = new Request();
        $request->attributes->set('_route', 'homepage');

        $reader->setRequest($request);

        $this->assertTrue($reader->isAvailable());

        $this->assertEquals(
            $reader->getConfig(),
            [
                "title" => "my title",
                "description" => "my description"
            ]
        );
    }

    /**
      * @expectedException \Exception
      */
    public function testNoRoute()
    {
        $reader = new YmlReader(__DIR__."/test2.yml");
        $reader->setRequest(new Request());
        $reader->getRoute();
    }
}
