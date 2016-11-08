<?php

namespace Ayrel\SeoBundle\Tests\Renderer;

use Ayrel\SeoBundle\Renderer\ResponseRenderer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class ResponseRendererTest extends TestCase
{
    public function testRender()
    {
        $renderer = new ResponseRenderer();

        $response = new Response();
        $response->setContent(
            '<html><head><title>my title</title><meta name="description" content="description"/><meta name="titi" content="toto"/></head><body></body></html>'
        );

        $renderer->setResponse($response);

        $html = $renderer->render([
            'title' => 'my new title',
            'meta' => [
                'description' => 'my description',
                'author' => 'Laurent Rossillol'
            ]
        ]);

        $crawler = new Crawler($html);

        $this->assertEquals(
            $crawler->filter('title')->text(),
            'my new title'
        );

        $this->assertEquals(
            $crawler->filter('meta[name=description]')->attr('content'),
            'my description'
        );
    }

    public function testRenderNoResponse()
    {
        $renderer = new ResponseRenderer();
        $this->assertTrue(!$renderer->render([]));
        $this->assertNull($renderer->getTitle());
        $this->assertNull($renderer->getMetaTag('description'));
    }

    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage no metadata set!!
     */
    public function testNoMeta()
    {
        $renderer = new ResponseRenderer();
        $renderer->setResponse(new Response('<html></html>'));
        $renderer->render([]);
    }
}
