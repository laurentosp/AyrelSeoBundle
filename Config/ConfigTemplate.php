<?php

namespace Ayrel\SeoBundle\Config;

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
        foreach ($this->defaults as $key => $val) {
            $ret[$key] = $this->getTemplate($key);
        }

        foreach ($this->templates as $key => $val) {
            $ret[$key] = $this->getTemplate($key);
        }

        return $ret;
    }

    public function getTemplate($key)
    {
        $val = null;
        if (isset($this->templates[$key])) {
            $val = $this->templates[$key];
        }

        if ($val===null) {
            if (isset($this->defaults[$key])) {
                $val = $this->defaults[$key];
            }
        }

        if ($val != strip_tags($val)) {
            throw new \Exception(sprintf(
                'Error Tag %s : %s Meta Template couldn\'t have htmls tags',
                $key,
                $val
            ));
        }

        return $val;
    }
}
