<?php

namespace Ayrel\SeoBundle\Tests\Config;

use Ayrel\SeoBundle\Config\ConfigTemplate;
use PHPUnit\Framework\TestCase;

class ConfigTemplateTest extends TestCase
{
    /**
     * @expectedException     \Exception
     */
    public function testException()
    {
        $conf = new ConfigTemplate(['title' => '<h1>hello</h1>']);
        $conf->getTemplate('title');
    }
}
