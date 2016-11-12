<?php

namespace AyrelSeoBundle\Tests\DependencyInjection;

use Ayrel\SeoBundle\DependencyInjection\AyrelSeoExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class AyrelSeoExtensionTest extends TestCase
{
    public function testDefault()
    {
        $ext = new AyrelSeoExtension();
        $container = $this->getMockBuilder(ContainerBuilder::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $container->method('getDefinition')
            ->willReturn(new Definition())
            ;

        $ext->load([
            'ayrel_seo' => [
                'strategy' => 'response'
            ]
        ], $container);
    }

    public function testTwig()
    {
        $ext = new AyrelSeoExtension();
        $container = $this->getMockBuilder(ContainerBuilder::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $container->method('getDefinition')
            ->willReturn(new Definition())
            ;

        $ext->load([
            'ayrel_seo' => [
                'strategy' => 'twig'
            ]
        ], $container);
    }

    public function testDefaults()
    {
        $ext = new AyrelSeoExtension();
        $container = $this->getMockBuilder(ContainerBuilder::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $container->method('getDefinition')
            ->willReturn(new Definition())
            ;

        $ext->load([
            'ayrel_seo' => [
                'strategy' => 'response',
                'default' => [
                    'title' => 'my title'
                ]
            ]
        ], $container);
    }
}
