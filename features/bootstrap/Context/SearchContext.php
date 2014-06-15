<?php

namespace Context;

use Behat\Behat\Context\Context;
use Page\Homepage;
use Page\ImagesSearchResults;
use Page\WebSearchResults;

class SearchContext implements Context
{
    /**
     * @var Homepage
     */
    private $homepage;

    /**
     * @var WebSearchResults
     */
    private $webSearchResults;

    /**
     * @var ImagesSearchResults
     */
    private $imagesSearchResults;

    /**
     * @param Homepage         $homepage
     * @param WebSearchResults $webSearchResults
     */
    public function __construct(Homepage $homepage, WebSearchResults $webSearchResults, ImagesSearchResults $imagesSearchResults)
    {
        $this->homepage = $homepage;
        $this->webSearchResults = $webSearchResults;
        $this->imagesSearchResults = $imagesSearchResults;
    }
    /**
     * @Given /^(?:|I )visited (?:|the )homepage$/
     */
    public function iVisitedTheHomepage()
    {
        $this->homepage->open();
    }

    /**
     * @When /^(?:|I )search for "(?P<keywords>[^"]*)"$/
     */
    public function iSearchFor($keywords)
    {
        $this->homepage->search($keywords);
    }

    /**
     * @Then /^(?:|I )should see (?:|a )list of "(?P<keywrods>[^"]*)" websites$/
     */
    public function iShouldSeeAListOfWebsites($keywords)
    {
        $resultCount = $this->webSearchResults->countResults($keywords);

        expect($resultCount > 0)->toBe(true);
    }

    /**
     * @When /^(?:|I )change (?:|the )tab to "(?P<tab>[^"]*)"$/
     */
    public function iChangeTheTabTo($tab)
    {
        $this->webSearchResults->switchTab($tab);
    }

    /**
     * @Then /^(?:|I )should see (?:|a )list of "(?P<keywords>[^"]*)" images$/
     */
    public function iShouldSeeAListOfImages($keywords)
    {
        $resultCount = $this->imagesSearchResults->countResults($keywords);

        expect($resultCount > 0)->toBe(true);
    }
}

