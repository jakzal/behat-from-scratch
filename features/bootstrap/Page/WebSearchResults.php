<?php

namespace Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

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
     * @return Page
     */
    public function switchTab($name)
    {
        return $this->getElement('Search results navigation')->switchTab($name);
    }
}

