<?php

namespace Ayrel\SeoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class AyrelSeoExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yml');

        if ($config['strategy']=="response") {
            $loader->load('response.yml');
        }

        if ($config['strategy']=="twig") {
            $loader->load('twig.yml');
        }

        $container
            ->getDefinition('ayrel_seo.renderer')
            ->addArgument($config['strategy']);

        if (count($config['default'])>0) {
            $container
                ->getDefinition('ayrel_seo.config_template_factory')
                ->addArgument($config['default'])
            ;
        }
    }
}
