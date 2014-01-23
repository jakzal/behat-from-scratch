<?php

namespace features\bootstrap\Page;

use features\bootstrap\Page\Element\SearchFormElement;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\UnexpectedPageException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;

class Homepage extends Page
{
    /**
     * @var string $path
     */
    protected $path = '/';

    /**
     * @var array $elements
     */
    protected $elements = array(
        'Search form' => array('xpath' => '//form[@name="f"]')
    );

    /**
     * @param string $keywords
     *
     * @return Page
     */
    public function search($keywords)
    {
        $element = $this->getElement('Search form');
        $element->fillField('q', $keywords);
        $element->pressButton('Google Search');

        return $this->getPage('Web search results');
    }

    /**
     * @throws UnexpectedPageException
     */
    protected function verifyPage()
    {
        $title = $this->find('css', 'title');

        if (null === $title || 'Google' !== $title->getHtml()) {
            throw new UnexpectedPageException('Expected to be on a google homepage');
        }
    }
}
