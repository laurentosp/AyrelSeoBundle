<?php

namespace Ayrel\SeoBundle\Twig;

use Ayrel\SeoBundle\Renderer;

class SeoExtension extends \Twig_Extension
{
    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('ayrel_seo', array($this, 'seo'), array('is_safe' => array('html')))
        );
    }

    public function seo()
    {
        try {
            return $this->renderer->render();
        } catch (\Exception $e) {
        }
    }
}
