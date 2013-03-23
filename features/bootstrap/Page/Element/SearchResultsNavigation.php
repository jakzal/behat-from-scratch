<?php

namespace features\bootstrap\Page\Element;

use Behat\Mink\Element\ElementInterface;
use Behat\Mink\Exception\ElementNotFoundException;
use SensioLabs\PageObjectExtension\PageObject\Element;
use SensioLabs\PageObjectExtension\PageObject\Page;

class SearchResultsNavigation extends Element
{
    /**
     * @var array $selector
     */
    protected $selector =  array('xpath' => '//*[@id="modeselector"]//ul');

    /**
     * @param string $name
     *
     * @return Page
     */
    public function switchTab($name)
    {
        $tab = $this->find('xpath', sprintf('//a[contains(., "%s")]', $name));

        if (!$tab) {
            throw new ElementNotFoundException($this->getSession(), 'tab', 'name', $name);
        }

        $tab->click();

        return $this->getPage($name.' search results');
    }
}
