<?php

namespace features\bootstrap\Page;

use SensioLabs\PageObjectExtension\PageObject\Page;
use features\bootstrap\Page\Element\SearchResultsNavigation;

class WebSearchResults extends Page
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
     * @return Element
     */
    public function switchTab($name)
    {
        return $this->getPage('Element / Search results navigation')->switchTab($name);
    }
}

