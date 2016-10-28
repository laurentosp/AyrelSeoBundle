<?php

namespace Ayrel\SeoBundle\Reader;

use Symfony\Component\HttpFoundation\RequestStack;

abstract class AbstractReader
{
    protected $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getContext()
    {
        $this->request->attributes->set('var', "ma variable");
        $this->request->attributes->set('desc', "ma desc...");

        return $this->request->attributes->all();
    }

    abstract public function getConfig();

    abstract public function isAvailable();
}
