<?php

namespace features\bootstrap\Page;

use Behat\Mink\Element\DocumentElement;

class ImageSearchResultsPage extends DocumentElement
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
