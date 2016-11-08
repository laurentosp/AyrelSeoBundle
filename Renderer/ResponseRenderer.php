<?php

namespace Ayrel\SeoBundle\Renderer;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class ResponseRenderer
{
    const TITLE_PATTERN = '<title>%s</title>';
    const META_PATTERN = "<meta name=\"%s\" content=\"%s\" />";

    private $metadata = [];

    private $response;

    /**
    * Get response
    * @return Response
    */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
    * Set response
    * @return $this
    */
    public function setResponse(Response $response)
    {
        $this->response = $response;
        return $this;
    }

    public function render($metadata)
    {
        $this->metadata = $metadata;
        
        if (($response=$this->getResponse())===null) {
            return false;
        }

        $content = $response->getContent();

        $newHead = "<!-- SEO Ayrel Bundle -->\n";
        $newHead.= $this->getNewHeadChildrenTags();
        $newHead.= "<!-- SEO Ayrel Bundle -->\n";
        $newHead.= $this->getOtherHeadChildrenTags($content);
        $newHead = $this->addTabulation($newHead);

        $content = preg_replace("/\s*<head\>(.*)\<\/head\>/s", "\n<head>\n{$newHead}\n</head>", $content);

        return $content;
    }

    public function addTabulation($content)
    {
        return "\t".str_replace("\n", "\n\t", $content);
    }

    public function getTitle()
    {
        if (isset($this->metadata['title'])) {
            return vsprintf(self::TITLE_PATTERN, $this->metadata['title']);
        }
    }

    public function getMetaTag($name)
    {
        if (isset($this->metadata['meta'][$name])) {
            return vsprintf(
                self::META_PATTERN,
                array( $name, $this->metadata['meta'][$name])
            );
        }
    }

    public function getNewHeadChildrenTags()
    {
        if (count($this->metadata)==0) {
            throw new \Exception('no metadata set!!');
        }

        $head = $this->getTitle()."\n";
        
        foreach ($this->metadata['meta'] as $name => $content) {
            $head.= $this->getMetaTag($name)."\n";
        }

        return $head;
    }

    public function getOtherHeadChildrenTags($content)
    {
        $crawler = new Crawler($content);
        
        $metadata = $this->metadata;

        $heads = $crawler->filter('head')->children()->reduce(
            function (Crawler $crawler) use ($metadata) {
                if (isset($metadata['title'])&&$crawler->nodeName()==="title") {
                    return false;
                }

                foreach ($metadata['meta'] as $name => $meta) {
                    if ($crawler->nodeName()==="meta"&&$crawler->attr('name')===$name) {
                        return false;
                    }
                }
                return true;
            }
        );

        $head = "";
        foreach ($heads as $node) {
            $head .= $node->ownerDocument->saveHTML($node);
        }

        return $head;
    }
}
