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
     * @param string $keywords
     *
     * @return Page
     */
    public function search($keywords)
    {
        return $this->getElement('Search form')->search($keywords);
    }

    /**
     * @throws UnexpectedPageException
     */
    protected function verifyPage()
    {
        $title = $this->find('css', 'title');

        if (null === $title || 'Google' !== $title->getText()) {
            throw new UnexpectedPageException('Expected to be on a google homepage');
        }
    }
}
