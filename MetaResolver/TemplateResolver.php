<?php

namespace Ayrel\SeoBundle\MetaResolver;

use Ayrel\SeoBundle\Configurator\SimpleConfigurator;

/**
 *
 */
class TemplateResolver
{
    public function __construct(SimpleConfigurator $configurator)
    {
        $this->configurator = $configurator;
    }

    /**
    * Get templating
    * @return \Twig_Environment $templating
    */
    public function getTemplating()
    {
        if ($this->templating===null) {
            throw new \Exception('templating is not set');
        }

        return $this->templating;
    }
    
    /**
    * Set templating
    * @return $this
    */
    public function setTemplating(\Twig_Environment $templating)
    {
        $this->templating = $templating;
        return $this;
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
            $meta['meta'][$key] = $this->resolveTemplate($val);
        }

        if ($meta['meta']['title']) {
            $meta['title'] = $meta['meta']['title'];
            unset($meta['meta']['title']);
        }

        return $meta;
    }

    public function resolveTemplate($template)
    {
        $tmp = $this->getTemplating()->createTemplate($template);
        return strip_tags($tmp->render($this->getContext()));
    }
}
