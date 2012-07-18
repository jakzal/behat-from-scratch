<?php

namespace Acme\Behat\DoctrineExtension\Context;

use Doctrine\DBAL\Connection;

interface DoctrineConnectionAwareInterface
{
    public function setConnection(Connection $connection);
}
