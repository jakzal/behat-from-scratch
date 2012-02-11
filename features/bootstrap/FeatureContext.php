<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\Step\Then,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\Mink\Behat\Context\MinkContext,
    Behat\Mink\Exception\ElementNotFoundException;

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

    /**
     * @Then /^I should see "([^"]*)" input on the article form$/
     */
    public function iShouldSeeInputOnTheArticleForm($label)
    {
        $xpath = sprintf('//form//label[text()="%s"]/following-sibling::input[@type=\'text\']', $label);

        $this->assertXpathElementExists($xpath);
    }

    /**
     * @Given /^I should see "([^"]*)" textarea on the article form$/
     */
    public function iShouldSeeTextareaOnTheArticleForm($label)
    {
        $xpath = sprintf('//form//label[text()="%s"]/following-sibling::textarea', $label);

        $this->assertXpathElementExists($xpath);
    }

    /**
     * @Then /^I should see "([^"]*)" in the preview area$/
     */
    public function iShouldSeeInPreviewArea($text)
    {
        return new Then(sprintf('I should see "%s" in the "div[class=\'preview\']" element', $text));
    }

    /**
     * @param string $label
     *
     * @return null
     */
    private function assertXpathElementExists($xpath)
    {
        $node = $this->getSession()->getPage()->find('xpath', $xpath);

        if (!$node) {
            throw new ElementNotFoundException($this->getSession(), 'element', 'xpath', $xpath);
        }
    }
}
