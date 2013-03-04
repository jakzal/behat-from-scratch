<?php

namespace features\bootstrap\Page;

use Behat\Mink\Element\DocumentElement;
use features\bootstrap\Page\Element\SearchResultsNavigationElement;

class WebSearchResultsPage extends DocumentElement
{
    /**
     * @param string $keywords
     *
     * @return integer
     */
    public function countResults($keywords)
    {
        $xpath = sprintf(
            '//h3[contains(translate(.,"abcdefghijklmnopqrstuvwxyz","ABCDEFGHIJKLMNOPQRSTUVWXYZ"), "%s") and @class="r"]/a',
            strtoupper($keywords)
        );
        $results = $this->findAll('xpath', $xpath);

        return count($results);
    }

    /**
     * @param string $name
     *
     * @return ElementInterface
     */
    public function switchTab($name)
    {
        $navigation = new SearchResultsNavigationElement($this->getSession());

        return $navigation->switchTab($name);
    }
}
