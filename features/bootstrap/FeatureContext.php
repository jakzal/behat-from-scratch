<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\Step\Then,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext,
    Behat\Mink\Driver\GoutteDriver,
    Behat\Mink\Exception\ElementNotFoundException,
    Behat\Mink\Session;

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * @Given /^I visit "([^"]*)"$/
     */
    public function iVisit($page)
    {
        $pages = array('homepage' => '/', 'article form' => '/add-article');

        if (array_key_exists($page, $pages)) {
            $page = $pages[$page];
        }

        return new Then(sprintf('I go to "%s"', $page));
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
     * @Then /^the preview area should not be visible$/
     */
    public function thePreviewAreaShouldNotBeVisible()
    {
        return new Then('I should not see a "div[class=\'preview\']" element');
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
