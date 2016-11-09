<?php

namespace Ayrel\SeoBundle\Tests\DependencyInjection;

use Ayrel\SeoBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    public function testConfig()
    {
        $conf = new Configuration();
        $config = $conf->getConfigTreeBuilder();
    }
}
