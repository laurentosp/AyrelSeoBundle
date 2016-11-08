<?php

namespace Ayrel\SeoBundle\Tests\Configurator;

use Ayrel\SeoBundle\Config\ConfigTemplateFactory;
use Ayrel\SeoBundle\Configurator\SimpleConfigurator;
use Ayrel\SeoBundle\Reader\YmlReader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class SimpleConfiguratorTest extends TestCase
{
    public function testGetConfig()
    {
        $simpleConfigurator = new SimpleConfigurator(
            $this->getMockRequestStack(),
            $this->getMockDispatcher(),
            new ConfigTemplateFactory(['title' => 'my title'])
        );

        $simpleConfigurator->addReader($this->getMockReader());

        $this->assertEquals(
            ['title' => 'my title', 'description' => 'my description'],
            $simpleConfigurator->getConfig()
        );
    }

    /**
     * @expectedException     \Exception
     */
    public function testException()
    {
        $simpleConfigurator = new SimpleConfigurator(
            $this->getMockRequestStack(),
            $this->getMockDispatcher(),
            new ConfigTemplateFactory(['title' => 'my title'])
        );

        $simpleConfigurator->getConfig();
    }

    public function getMockReader()
    {
        $reader = $this->getMockBuilder(YmlReader::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $reader->method('getConfig')
            ->willReturn(['title' => null, 'description' => 'my description'])
        ;

        $reader->method('isAvailable')
            ->willReturn(true);

        return $reader;
    }

    public function getMockRequestStack()
    {
        $requestStack = $this->getMockBuilder(RequestStack::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $request = new Request();

        $requestStack->method('getMasterRequest')
            ->willReturn($request)
            ;

        return $requestStack;
    }

    public function getMockDispatcher()
    {
        $dispatcher = $this->getMockBuilder(EventDispatcherInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $dispatcher
            ->method('dispatch')
            ->will($this->returnArgument(1));
        ;

        return $dispatcher;
    }
}
