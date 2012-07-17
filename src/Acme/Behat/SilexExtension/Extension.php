<?php

namespace Acme\Behat\SilexExtension;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

use Behat\Behat\Extension\ExtensionInterface;

/**
 * Silex extension for Behat.
 *
 * @author Jakub Zalas <jakub@zalas.pl>
 */
class Extension implements ExtensionInterface
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $config    Extension configuration hash (from behat.yml)
     * @param ContainerBuilder $container ContainerBuilder instance
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/services'));
        $loader->load('core.xml');

        $extensions = $container->hasParameter('behat.extension.classes')
                    ? $container->getParameter('behat.extension.classes')
                    : array();

        if (isset($config['mink_driver']) && $config['mink_driver']) {
            if (!class_exists('Behat\\Mink\\Driver\\BrowserKitDriver')) {
                throw new \RuntimeException(
                    'Install MinkBrowserKitDriver in order to activate silex session.'
                );
            }

            $loader->load('mink_driver.xml');
        } elseif (in_array('Behat\\MinkExtension\\Extension', $extensions) && class_exists('Behat\\Mink\\Driver\\BrowserKitDriver')) {
            $loader->load('mink_driver.xml');
        }
    }

    /**
     * Setups configuration for current extension.
     *
     * @param ArrayNodeDefinition $builder
     */
    public function getConfig(ArrayNodeDefinition $builder)
    {
    }

    /**
     * Returns compiler passes used by mink extension.
     *
     * @return array
     */
    public function getCompilerPasses()
    {
        return array();
    }
}
