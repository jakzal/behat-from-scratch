<?php

namespace features\bootstrap;

use features\bootstrap\Page\HomePage;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Mink\Element\ElementInterface;

class SearchContext extends RawMinkContext
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
       $this->getSession()->visit($this->locatePath('/'));

       $this->page = new HomePage($this->getSession());
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

        if ($resultCount === 0) {
            $message = sprintf('Expected at least one result for "%s", got: "%d"', $keywords, $resultCount);

            throw new \LogicException($message);
        }
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

