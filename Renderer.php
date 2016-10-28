<?php

namespace Ayrel\SeoBundle;

use Ayrel\SeoBundle\MetaResolver\TemplateResolver;

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
        $this->tplResolver->setTemplating($twig);
        
        if ($tpl===null) {
            $tpl = self::TPL;
        }

        $this->tpl = $tpl;
    }

    public function render()
    {
        return $this->twig->render(
            $this->tpl,
            $this->getMetaData()
        );
    }

    public function getMetaData()
    {
        return $this->tplResolver->getMetaData();
    }
}
