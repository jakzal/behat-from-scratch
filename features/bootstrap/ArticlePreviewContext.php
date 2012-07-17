<?php

use Behat\Behat\Context\Step\Then;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Mink\Exception\ElementNotFoundException;

class ArticlePreviewContext extends RawMinkContext
{
    /**
     * @param string $label
     *
     * @Then /^I should see "([^"]*)" input on the article form$/
     *
     * @return null
     */
    public function iShouldSeeInputOnTheArticleForm($label)
    {
        $xpath = sprintf('//form//label[text()="%s"]/following-sibling::input[@type=\'text\']', $label);

        $this->assertXpathElementExists($xpath);
    }

    /**
     * @param string $label
     *
     * @Given /^I should see "([^"]*)" textarea on the article form$/
     *
     * @return null
     */
    public function iShouldSeeTextareaOnTheArticleForm($label)
    {
        $xpath = sprintf('//form//label[text()="%s"]/following-sibling::textarea', $label);

        $this->assertXpathElementExists($xpath);
    }

    /**
     * @param string $text
     *
     * @Then /^I should see "([^"]*)" in the preview area$/
     *
     * @return \Behat\Behat\Context\Step\Then
     */
    public function iShouldSeeInPreviewArea($text)
    {
        return new Then(sprintf('I should see "%s" in the "div[class=\'preview\']" element', $text));
    }

    /**
     * @Then /^the preview area should not be visible$/
     *
     * @return \Behat\Behat\Context\Step\Then
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
