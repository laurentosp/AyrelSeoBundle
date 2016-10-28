<?php

namespace Ayrel\SeoBundle\MetaResolver;

use Ayrel\SeoBundle\Configurator\SimpleConfigurator;
use Symfony\Bridge\Twig\TwigEngine;

/**
 *
 */
class TemplateResolver
{
    protected $config;
    protected $context;

    public function __construct(SimpleConfigurator $config, \Twig_Environment $templating)
    {
        $this->templating = $templating;
        $this->config = $config;
    }

    /**
    * Get config
    * @return array
    */
    public function getConfig()
    {
        return $this->config->getConfig();
    }

    /**
    * Get context
    * @return array
    */
    public function getContext()
    {
        return $this->config->getContext();
    }

    public function getMetaData()
    {
        $meta = [];

        foreach ($this->getConfig() as $key => $val) {
            $key = str_replace("_", ":", $key);
            $meta['meta'][$key] = $this->resolveTemplate($key, $val);
        }

        if ($meta['meta']['title']) {
            $meta['title'] = $meta['meta']['title'];
            unset($meta['meta']['title']);
        }

        return $meta;
    }

    public function resolveTemplate($meta, $template)
    {
        $tmp = $this->templating->createTemplate($template);
        return strip_tags($tmp->render($this->getContext()));
    }
}
