<?php

namespace Ayrel\SeoBundle\MetaResolver;

use Ayrel\SeoBundle\Configurator\SimpleConfigurator;

/**
 *
 */
class TemplateResolver
{
    public function __construct(
        SimpleConfigurator $configurator,
        \Twig_Environment $templating
    ) {
        $this->configurator = $configurator;
        $this->templating = $templating;
    }

    /**
    * Get config
    * @return array
    */
    public function getConfig()
    {
        return $this->configurator->getConfig();
    }

    /**
    * Get context
    * @return array
    */
    public function getContext()
    {
        return $this->configurator->getContext();
    }

    public function getMetaData()
    {
        $meta = [];

        foreach ($this->getConfig() as $key => $val) {
            $key = str_replace("_", ":", $key);
            $tag = $this->resolveTemplate($val);
            if (empty($tag)) continue;
            $meta['meta'][$key] = $tag;
        }

        if ($meta['meta']['title']) {
            $meta['title'] = $meta['meta']['title'];
            unset($meta['meta']['title']);
        }

        return $meta;
    }

    public function resolveTemplate($template)
    {
        $tmp = $this->templating->createTemplate($template);
        return $tmp->render($this->getContext());
    }
}
