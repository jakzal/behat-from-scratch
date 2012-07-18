<?php

namespace Acme\Behat\DoctrineExtension;

use Behat\Behat\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;

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

        if (isset($config['connection'])) {
            $container->setParameter('doctrine.connection.settings', $config['connection']);
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
                arrayNode('connection')->
                    isRequired()->
                    children()->
                        scalarNode('dbname')->
                            isRequired()->
                        end()->
                        scalarNode('user')->
                            isRequired()->
                        end()->
                        scalarNode('password')->
                            isRequired()->
                        end()->
                        scalarNode('host')->
                            defaultValue('127.0.0.1')->
                        end()->
                        scalarNode('driver')->
                            defaultValue('pdo_mysql')->
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
