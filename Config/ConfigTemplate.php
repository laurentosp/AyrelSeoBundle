<?php

namespace Ayrel\SeoBundle\Config;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigTemplate
{
    private $defaults = [];

    private $templates = [];

    public function __construct($templates, $defaults = [])
    {
        $this->defaults = $defaults;
        $this->templates = $templates;
    }

    public function all()
    {
        $ret = [];
        foreach ($this->templates as $key => $val) {
            $ret[$key] = $this->getTemplate($key, $val);
        }

        return $ret;
    }

    private function getTemplate($key, $val)
    {
        if ($val != strip_tags($val)) {
            throw new Exception(sprintf(
                'Error Tag %s : Meta Template couldn\'t have htmls tags',
                $key
            ));
        }

        if ($val===null) {
            if (isset($this->defaults[$key])) {
                $val = $this->defaults[$key];
            }
        }

        return $val;
    }
}
