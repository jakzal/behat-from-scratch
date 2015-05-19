<?php

namespace Context\Argument;

use Behat\Behat\Context\Argument\ArgumentResolver;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Behat argument resolver.
 *
 * Resolves arguments based on a list like:
 *  *  HttpClient => service.id
 *  *  MyService => other_service.id
 *
 * Based on https://github.com/jakzal/RestExtension/blob/master/src/Behat/RestExtension/Context/Argument/ConfigurableArgumentResolver.php
 */
class ConfigurableArgumentResolver implements ArgumentResolver
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $supportedArguments;

    /**
     * @param ContainerInterface $container
     * @param array              $supportedArguments
     */
    public function __construct(ContainerInterface $container, array $supportedArguments)
    {
        $this->container = $container;
        $this->supportedArguments = $supportedArguments;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveArguments(\ReflectionClass $classReflection, array $arguments)
    {
        if ($constructor = $classReflection->getConstructor()) {
            $arguments = $this->resolveConstructorArguments($constructor, $arguments);
        }

        return $arguments;
    }

    /**
     * @param \ReflectionMethod $constructor
     * @param array             $arguments
     *
     * @return array
     */
    private function resolveConstructorArguments(\ReflectionMethod $constructor, array $arguments)
    {
        $constructorParameters = $constructor->getParameters();
        foreach ($constructorParameters as $position => $parameter) {
            foreach ($this->supportedArguments as $classOrInterface => $serviceId) {
                if ($parameter->getClass() && $this->supports($parameter->getClass(), $classOrInterface, $serviceId)) {
                    $arguments[$position] = $this->container->get($serviceId);
                }
            }
        }

        return $arguments;
    }

    /**
     * @param tring  $parameterClass
     * @param string $classOrInterface
     * @param mixed  $service
     *
     * @return bool
     */
    private function supports(\ReflectionClass $parameterClass, $classOrInterface, $service)
    {
        return (interface_exists($classOrInterface) && $parameterClass->implementsInterface($classOrInterface))
        || $parameterClass->getName() === $classOrInterface
        || is_subclass_of($service, $parameterClass->getName());
    }
}