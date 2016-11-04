<?php

namespace Ayrel\SeoBundle;

use Ayrel\SeoBundle\MetaResolver\TemplateResolver;
use Monolog\Logger;

/**
 *
 */
class Renderer
{
    private $tplResolver;
    private $selectedStrategy;

    public function __construct(
        Logger $logger,
        TemplateResolver $tplResolver,
        $selectedStrategy = 'response'
    ) {
        $this->logger = $logger;
        $this->tplResolver = $tplResolver;
        $this->tplResolver->setLogger($logger);
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
            $this->logger->error($e->getMessage());
            return null;
        }
    }

    public function getMetaData()
    {
        return $this->tplResolver->getMetaData();
    }
}
