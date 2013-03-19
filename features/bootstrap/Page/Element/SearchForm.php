<?php

namespace features\bootstrap\Page\Element;

use SensioLabs\PageObjectExtension\PageObject\Element;
use SensioLabs\PageObjectExtension\PageObject\Page;


class SearchForm extends Element
{
    /**
     * @return string
     */
    protected function xpath()
    {
        return '//form[@name="f"]';
    }

    /**
     * @return Page
     */
    public function search($keywords)
    {
        $this->fillField('q', $keywords);
        $this->pressButton('Google Search');

        return $this->getPage('Web search results');
    }
}

