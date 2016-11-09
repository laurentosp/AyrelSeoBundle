<?php

namespace Ayrel\SeoBundle\Tests\MetaResolver;

use Ayrel\SeoBundle\Configurator\SimpleConfigurator;
use Ayrel\SeoBundle\MetaResolver\TemplateResolver;
use PHPUnit\Framework\TestCase;

class TemplateResolverTest extends TestCase
{
    public function testTplResolver()
    {
        
        $loader = new \Twig_Loader_Filesystem(__DIR__.'/../../Resources/views');

        $tplResolver = new TemplateResolver(
            $this->getMockConfigurator(),
            new \Twig_Environment($loader)
        );

        $meta = $tplResolver->getMetaData();

        $this->assertEquals(
            $meta['title'],
            "super product : 32 €"
        );


        $this->assertEquals(
            $meta['meta']['description'],
            "my description"
        );
    }

    public function getMockConfigurator()
    {
        $config = $this->getMockBuilder(SimpleConfigurator::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $config->method('getConfig')
            ->willReturn([
                'title' => '{{product.title}} : {{product.price}} €',
                'description' => '{{product.description}}'
            ])
        ;

        $config->method('getContext')
            ->willReturn([
                'product' => [
                    'title' => 'super product',
                    'price' => 32,
                    'description' => 'my description'
                ]
            ])
        ;

        return $config;
    }
}
