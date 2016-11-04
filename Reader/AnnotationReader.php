<?php

namespace Ayrel\SeoBundle\Reader;

use Doctrine\Common\Annotations;
use Ayrel\SeoBundle\Annotation\SeoAnnotation;

class AnnotationReader extends AbstractReader
{
    private function getAnnotation()
    {
        $controller = $this->request->attributes->get('_controller');

        if (!strstr($controller, '::')) {
            return ;
        }

        list($controller, $method) = explode(
            "::",
            $controller
        );
        
        $reflectionMethod = new \ReflectionMethod($controller, $method);
        $reader = new Annotations\AnnotationReader();

        return  $reader->getMethodAnnotation(
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
