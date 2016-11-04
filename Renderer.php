<?php

namespace Ayrel\SeoBundle;

use Ayrel\SeoBundle\MetaResolver\TemplateResolver;

/**
 *
 */
class Renderer
{
    private $tplResolver;
    private $selectedStrategy;

    public function __construct(
        TemplateResolver $tplResolver,
        $selectedStrategy = 'response'
    ) {
        $this->tplResolver = $tplResolver;
        $this->selectedStrategy = $selectedStrategy;
    }

    public function addStrategy($renderer, $name)
    {
        $this->strategies[$name] = $renderer;
    }

    public function getStrategy()
    {
        return $this->strategies[$this->getSelectedStrategy()];
    }

    public function setSelectedStrategy($name)
    {
        $this->selectedStrategy = $name;
    }

    public function getSelectedStrategy()
    {
        return $this->selectedStrategy;
    }

    public function render()
    {
        try {
            return $this->getStrategy()->render(
                $this->getMetaData()
            );
        } catch (\Exception $e) {
        }
    }

    public function getMetaData()
    {
        return $this->tplResolver->getMetaData();
    }
}
