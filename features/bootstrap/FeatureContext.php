<?php

namespace features\bootstrap;

use Behat\Behat\Context\BehatContext;

class FeatureContext extends BehatContext
{
    /**
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->useContext('search', new SearchContext());
    }
}
