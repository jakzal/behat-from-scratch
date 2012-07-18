<?php

namespace Phabric\Behat\PhabricExtension;

use Behat\Behat\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

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

        if (isset($config['entities'])) {
            $container->setParameter('phabric.entities', $config['entities']);
        }
    }

    /**
     * Setups configuration for current extension.
     *
     * @param ArrayNodeDefinition $builder
     */
    public function getConfig(ArrayNodeDefinition $builder)
    {
        $builder->
            children()->
                arrayNode('entities')->
                    useAttributeAsKey('name')->
                    prototype('array')->
                        children()->
                             scalarNode('tableName')->end()->
                             scalarNode('nameCol')->end()->
                             scalarNode('primaryKey')->end()->
                             arrayNode('nameTransformations')->
                                prototype('scalar')->end()->
                             end()->
                             arrayNode('dataTransformations')->
                                prototype('scalar')->end()->
                             end()->
                        end()->
                    end()->
                end()->
            end();
    }

    /**
     * Returns compiler passes used by this extension.
     *
     * @return array
     */
    public function getCompilerPasses()
    {
        return array();
    }
}
