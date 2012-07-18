<?php

namespace Acme\Behat\DoctrineExtension\Context\Initializer;

use Acme\Behat\DoctrineExtension\Context\DoctrineConnectionAwareInterface;
use Behat\Behat\Context\ContextInterface;
use Behat\Behat\Context\Initializer\InitializerInterface;
use Doctrine\DBAL\Connection;

class DoctrineConnectionInitializer implements InitializerInterface
{
    private $connection = null;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Checks if initializer supports provided context.
     *
     * @param ContextInterface $context
     *
     * @return Boolean
     */
    public function supports(ContextInterface $context)
    {
        return $context instanceof DoctrineConnectionAwareInterface;
    }

    /**
     * Initializes provided context.
     *
     * @param ContextInterface $context
     */
    public function initialize(ContextInterface $context)
    {
        $context->setConnection($this->connection);
    }
}
