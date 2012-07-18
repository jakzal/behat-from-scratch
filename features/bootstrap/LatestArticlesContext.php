<?php

use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\ExpectationException;
use Phabric\Phabric;
use Phabric\Behat\PhabricExtension\Context\PhabricAwareInterface;

class LatestArticlesContext extends RawMinkContext implements PhabricAwareInterface
{
    /**
     * @var \Phabric\Phabric $phabric
     */
    private $phabric = null;

    /**
     * @var \Doctrine\DBAL\Connection $connection
     */
    private $connection = null;

    public function setPhabric(Phabric $phabric)
    {
        $this->phabric = $phabric;
    }

    /**
     * @param array $parameters
     *
     * @return null
     */
    public function __construct($parameters)
    {
        $this->connection = \Doctrine\DBAL\DriverManager::getConnection(array(
            'dbname' => $parameters['database']['dbname'],
            'user' => $parameters['database']['username'],
            'password' => $parameters['database']['password'],
            'host' => $parameters['database']['host'],
            'driver' => $parameters['database']['driver'],
        ));

        //$dataSource = new \Phabric\Datasource\Doctrine(
            //$this->connection,
            //$parameters['Phabric']['entities']
        //);

        //$this->phabric = new \Phabric\Phabric($dataSource);
        //$this->phabric->addDataTransformation(
            //'TEXTTOMYSQLDATE', function($date) {
                //$date = new \DateTime($date);

                //return $date->format('Y-m-d H:i:s');
            //}
        //);
        //$this->phabric->createEntitiesFromConfig($parameters['Phabric']['entities']);
    }

    /**
     * @param \Behat\Gherkin\Node\TableNode $table
     *
     * @Given /^following articles were written$/
     *
     * @return null
     */
    public function followingArticlesWereWritten(TableNode $table)
    {
        $this->phabric->insertFromTable('Article', $table);
    }

    /**
     * @param string $title
     *
     * @Then /^(?:|I )should see (?:|the )"(?P<title>[^"]*)" article$/
     *
     * @return null
     */
    public function iShouldSeeTheArticle($title)
    {
        $entity = $this->phabric->getEntity('Article');
        $article = $entity->getNamedItem($title);

        $xpath = sprintf('//div[contains(@class, "article")]//h2[text()="%s"]', $title);
        $this->assertXpathElementExists($xpath);

        $xpath = sprintf('//div[contains(@class, "article")]//p[text()="%s"]', $article['content']);
        $this->assertXpathElementExists($xpath);
    }

    /**
     * @param string $title
     *
     * @Given /^(?:|I )should not see (?:|the )"(?P<title>[^"]*)" article$/
     *
     * @return null
     */
    public function iShouldNotSeeTheArticle($title)
    {
        $entity = $this->phabric->getEntity('Article');
        $article = $entity->getNamedItem($title);

        $xpath = sprintf('//div[contains(@class, "article")]//h2[text()="%s"]', $title);
        $this->assertXpathElementDoesNotExist($xpath);

        $xpath = sprintf('//div[contains(@class, "article")]//p[text()="%s"]', $article['content']);
        $this->assertXpathElementDoesNotExist($xpath);
    }

    /**
     * @AfterScenario
     *
     * @return null
     */
    public function clearDatabase()
    {
        $this->phabric->reset();
        $this->connection->query('DELETE FROM articles');
    }

    /**
     * @param string $xpath
     *
     * @return null
     */
    private function assertXpathElementExists($xpath)
    {
        $node = $this->getSession()->getPage()->find('xpath', $xpath);

        if (!$node) {
            throw new ElementNotFoundException($this->getSession(), 'element', 'xpath', $xpath);
        }
    }

    /**
     * @param string $xpath
     *
     * @return null
     */
    private function assertXpathElementDoesNotExist($xpath)
    {
        $node = $this->getSession()->getPage()->find('xpath', $xpath);

        if ($node) {
            throw new ExpectationException(sprintf('Did not expect to find: "%s"', $xpath), $this->getSession());
        }
    }
}
