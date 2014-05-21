<?php

namespace Context;

use SensioLabs\Behat\PageObjectExtension\Context\PageObjectContext;

class SearchContext extends PageObjectContext
{
    /**
     * @Given /^(?:|I )visited (?:|the )homepage$/
     */
    public function iVisitedTheHomepage()
    {
        $this->getPage('Homepage')->open();
    }

    /**
     * @When /^(?:|I )search for "(?P<keywords>[^"]*)"$/
     */
    public function iSearchFor($keywords)
    {
        $this->getPage('Homepage')->search($keywords);
    }

    /**
     * @Then /^(?:|I )should see (?:|a )list of "(?P<keywrods>[^"]*)" websites$/
     */
    public function iShouldSeeAListOfWebsites($keywords)
    {
        $resultCount = $this->getPage('Web search results')->countResults($keywords);

        expect($resultCount > 0)->toBe(true);
    }

    /**
     * @When /^(?:|I )change (?:|the )tab to "(?P<tab>[^"]*)"$/
     */
    public function iChangeTheTabTo($tab)
    {
        $this->getPage('Web search results')->switchTab($tab);
    }

    /**
     * @Then /^(?:|I )should see (?:|a )list of "(?P<keywords>[^"]*)" images$/
     */
    public function iShouldSeeAListOfImages($keywords)
    {
        $resultCount = $this->getPage('Images search results')->countResults($keywords);

        expect($resultCount > 0)->toBe(true);
    }
}

