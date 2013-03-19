<?php

namespace features\bootstrap;

use SensioLabs\PageObjectExtension\Context\PageObjectContext;
use Behat\Mink\Element\ElementInterface;

class SearchContext extends PageObjectContext
{
    /**
     * @var ElementInterface $page
     */
    private $page = null;

    /**
     * @Given /^(?:|I )visited (?:|the )homepage$/
     */
    public function iVisitedTheHomepage()
    {
        $this->page = $this->getPage('Homepage')->open('/');
    }

    /**
     * @When /^(?:|I )search for "(?P<keywords>[^"]*)"$/
     */
    public function iSearchFor($keywords)
    {
        $this->page = $this->page->search($keywords);
    }

    /**
     * @Then /^(?:|I )should see (?:|a )list of "(?P<keywrods>[^"]*)" websites$/
     */
    public function iShouldSeeAListOfWebsites($keywords)
    {
        $resultCount = $this->page->countResults($keywords);

        expect($resultCount > 0)->toBe(true);
    }

    /**
     * @When /^(?:|I )change (?:|the )tab to "(?P<tab>[^"]*)"$/
     */
    public function iChangeTheTabTo($tab)
    {
        $this->page = $this->page->switchTab($tab);
    }

    /**
     * @Then /^(?:|I )should see (?:|a )list of "(?P<keywords>[^"]*)" images$/
     */
    public function iShouldSeeAListOfImages($keywords)
    {
        $resultCount = $this->page->countResults($keywords);

        expect($resultCount > 0)->toBe(true);
    }
}

