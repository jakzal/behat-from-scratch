<?php

namespace features\bootstrap\Page\Element;

use Behat\Mink\Element\ElementInterface;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Session;
use features\bootstrap\Page\ImageSearchResultsPage;

class SearchResultsNavigationElement extends NodeElement
{
    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        parent::__construct('//*[@id="modeselector"]//ul', $session);
    }

    /**
     * @param string $name
     *
     * @return ElementInterface
     */
    public function switchTab($name)
    {
        $tab = $this->find('xpath', sprintf('//a[contains(., "%s")]', $name));

        if (!$tab) {
            throw new ElementNotFoundException($this->getSession(), 'tab', 'name', $name);
        }

        $tab->click();

        return $this->getResultsPage($name);
    }

    /**
     * @return ElementInterface
     */
    private function getResultsPage($name)
    {
        switch ($name) {
            case 'Images':
                return new ImageSearchResultsPage($this->getSession());
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Unsupported page: "%s"', $name));
        }
    }
}
