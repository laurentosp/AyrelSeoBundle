<?php

namespace Ayrel\SeoBundle\Reader;

use Doctrine\Common\Annotations;
use Ayrel\SeoBundle\Annotation\SeoAnnotation;

class AnnotationReader extends AbstractReader
{
    private function getAnnotation()
    {
        list($controller, $method) = explode(
            "::",
            $this->request->attributes->get('_controller')
        );
        
        $reflectionMethod = new \ReflectionMethod($controller, $method);
        $reader = new Annotations\AnnotationReader();

        return $reader->getMethodAnnotation(
            $reflectionMethod,
            SeoAnnotation::class
        );
    }

    public function isAvailable()
    {
        return $this->getAnnotation()!==null;
    }

    public function getConfig()
    {
        return $this->getAnnotation()->config;
    }
}
