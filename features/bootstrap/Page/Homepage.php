<?php

namespace features\bootstrap\Page;

use Behat\Mink\Element\DocumentElement;
use features\bootstrap\Page\Element\SearchFormElement;
use SensioLabs\PageObjectExtension\PageObject\Page;

class Homepage extends Page
{
    /**
     * @var string $path
     */
    protected $path = '/';

    /**
     * @param string $keywords
     *
     * @return Page
     */
    public function search($keywords)
    {
        return $this->getElement('Search form')->search($keywords);
    }
}
