<?php

namespace Ayrel\SeoBundle\MetaResolver;

use Ayrel\SeoBundle\Configurator\SimpleConfigurator;
use Monolog\Logger;

/**
 *
 */
class TemplateResolver
{
    private $logger = null;

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

    /**
    * Get logger
    * @return Logger
    */
    public function getLogger()
    {
        return $this->logger;
    }
    
    /**
    * Set logger
    * @return $this
    */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    public function getMetaData()
    {
        $meta = [];

        foreach ($this->getConfig() as $key => $val) {
            $key = str_replace("_", ":", $key);
            $tag = $this->resolveTemplate($val);
            $meta['meta'][$key] = $tag;

            if ($this->getLogger()) {
                $this->getLogger()->info(vsprintf(
                    "%s : %s",
                    array( $key, $tag)
                ));
            }
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
