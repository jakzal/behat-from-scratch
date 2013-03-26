<?php

namespace features\bootstrap\Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class ImagesSearchResults extends Page
{
    /**
     * @param string $keywords
     *
     * @return integer
     */
    public function countResults($keywords)
    {
        $xpath = sprintf(
            '//table[@class="images_table"]'.
            '//a/img/..'.
            '/following-sibling::b[contains(translate(.,"abcdefghijklmnopqrstuvwxyz","ABCDEFGHIJKLMNOPQRSTUVWXYZ"), "%s")]',
            strtoupper($keywords)
        );
        $results = $this->findAll('xpath', $xpath);

        return count($results);
    }
}

