<?php

namespace Phabric\Behat\PhabricExtension\Context\Initializer;

use Behat\Behat\Context\ContextInterface;
use Behat\Behat\Context\Initializer\InitializerInterface;
use Phabric\Phabric;
use Phabric\Behat\PhabricExtension\Context\PhabricAwareInterface;

class PhabricAwareInitializer implements InitializerInterface
{
    private $phabric = null;

    public function __construct(Phabric $phabric)
    {
        $this->phabric = $phabric;
    }

    /**
     * @param \Behat\Behat\Context\ContextInterface $context
     *
     * @return boolean
     */
    public function supports(ContextInterface $context)
    {
        if ($context instanceof PhabricAwareInterface) {
            return true;
        }

        return false;
    }

    /**
     * @param Behat\Behat\Context\ContextInterface $context
     *
     * @return null
     */
    public function initialize(ContextInterface $context)
    {
        $context->setPhabric($this->phabric);
    }
}
