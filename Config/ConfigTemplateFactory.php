<?php

namespace Ayrel\SeoBundle\Config;

class ConfigTemplateFactory
{
    private $defaults= [];

    public function __construct($defaults = [])
    {
        $this->defaults = $defaults;
    }

    public function createConfigTemplate($templates)
    {
        return new ConfigTemplate($templates, $this->defaults);
    }
}
