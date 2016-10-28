<?php

namespace Ayrel\SeoBundle;

use Ayrel\SeoBundle\Configurator\SimpleConfigurator;
use Ayrel\SeoBundle\MetaResolver\TemplateResolver;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 *
 */
class Renderer
{
    const TPL = 'AyrelSeoBundle::seo.html.twig';

    public function __construct(
        \Twig_Environment $twig,
        TemplateResolver $tplResolver,
        $tpl = null
    ) {
        $this->twig = $twig;
        $this->tplResolver = $tplResolver;
        
        if ($tpl == null) {
            $tpl = self::TPL;
        }

        $this->tpl = $tpl;
    }

    public function render()
    {
        return $this->twig->render(
            $this->tpl,
            $metadata = $this->getMetaData()
        );
    }

    public function getMetaData()
    {
        return $this->tplResolver->getMetaData();
    }
}
