<?php

namespace Ayrel\SeoBundle\Renderer;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class ResponseRenderer
{
    const TITLE_PATTERN = '<title>%s</title>';
    const META_PATTERN = "<meta name=\"%s\" content=\"%s\" />";
    const META_PROPERTY_PATTERN = "<meta property=\"%s\" content=\"%s\" />";

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
            return vsprintf(self::TITLE_PATTERN, trim($this->metadata['title']));
        }
    }

    public function getMetaTag($name)
    {
        $pattern = self::META_PATTERN;
        if (substr($name, 0, 3)==="og:") {
            $pattern = self::META_PROPERTY_PATTERN;
        }

        if (isset($this->metadata['meta'][$name])) {
            return vsprintf(
                $pattern,
                array( $name, trim($this->metadata['meta'][$name]))
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
                    if ($crawler->nodeName()==="meta") {
                        if (($crawler->attr('name')===$name||$crawler->attr('property')===$name)) {
                            return false;
                        }
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
