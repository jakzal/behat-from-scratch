<?php

namespace features\bootstrap\Page\Element;

use Behat\Mink\Element\NodeElement;
use Behat\Mink\Session;
use features\bootstrap\Page\WebSearchResultsPage;

class SearchFormElement extends NodeElement
{
    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        parent::__construct('//form[@name="f"]', $session);
    }

    /**
     * @param string $keywords
     *
     * @return WebSearchResultsPage
     */
    public function search($keywords)
    {
        $this->fillField('q', $keywords);
        $this->pressButton('Google Search');

        return new WebSearchResultsPage($this->getSession());
    }
}
