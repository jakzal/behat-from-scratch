<?php

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\Step\Then;
use Behat\MinkExtension\Context\MinkContext;

class FeatureContext extends BehatContext
{
    /**
     * @param array $parameters
     *
     * @return null
     */
    public function __construct($parameters)
    {
        $this->useContext('article_preview', new ArticlePreviewContext($parameters));
        $this->useContext('latest_articles', new LatestArticlesContext($parameters));
        $this->useContext('mink', new MinkContext());
    }

    /**
     * @param string $page
     *
     * @Given /^I visit "([^"]*)"$/
     *
     * @return \Behat\Behat\Context\Step\Then
     */
    public function iVisit($page)
    {
        $pages = array('homepage' => '/', 'article form' => '/add-article');

        if (array_key_exists($page, $pages)) {
            $page = $pages[$page];
        }

        return new Then(sprintf('I go to "%s"', $page));
    }
}
