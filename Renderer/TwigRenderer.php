<?php

namespace Ayrel\SeoBundle\Renderer;

class TwigRenderer
{
    const TPL = 'AyrelSeoBundle::seo.html.twig';

    public function __construct(\Twig_Environment $twig, $tpl = null)
    {
        $this->twig = $twig;

        if ($tpl == null) {
            $tpl = self::TPL;
        }

        $this->tpl = $tpl;
    }

    public function render($metadata)
    {
        return $this->twig->render(
            $this->tpl,
            $metadata
        );
    }
}
