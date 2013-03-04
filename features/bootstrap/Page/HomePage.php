<?php

namespace features\bootstrap\Page;

use Behat\Mink\Element\DocumentElement;
use features\bootstrap\Page\Element\SearchFormElement;

class HomePage extends DocumentElement
{
    /**
     * @param string $keywords
     *
     * @return WebSearchResultsPage
     */
    public function search($keywords)
    {
        $form = $this->getSearchForm();

        return $form->search($keywords);
    }

    /**
     * @return SearchFormElement
     */
    private function getSearchForm()
    {
        return new SearchFormElement($this->getSession());
    }
}
