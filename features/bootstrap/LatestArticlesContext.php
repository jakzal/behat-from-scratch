<?php

use Acme\Behat\DoctrineExtension\Context\DoctrineConnectionAwareInterface;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\ExpectationException;
use Doctrine\DBAL\Connection;

class LatestArticlesContext extends RawMinkContext implements DoctrineConnectionAwareInterface
{
    /**
     * @var \Doctrine\DBAL\Connection $connection
     */
    private $connection = null;

    /**
     * @param \Doctrine\DBAL\Connection $connection
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
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
        $statement = $this->connection->prepare('INSERT INTO articles (title, content, updated_at) VALUES (?, ?, ?)');

        foreach ($table->getHash() as $row) {
            $date = new \DateTime($row['Modification time']);
            $statement->bindValue(1, $row['Title']);
            $statement->bindValue(2, $row['Content']);
            $statement->bindValue(3, $date->format('Y-m-d H:i:s'));
            $statement->execute();
        }
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
        $articles = $this->connection->executeQuery('SELECT * FROM articles WHERE title = ?', array($title))
            ->fetchAll();

        $xpath = sprintf('//div[contains(@class, "article")]//h2[text()="%s"]', $title);
        $this->assertXpathElementExists($xpath);

        $xpath = sprintf('//div[contains(@class, "article")]//p[text()="%s"]', $articles[0]['content']);
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
        $articles = $this->connection->executeQuery('SELECT * FROM articles WHERE title = ?', array($title))
            ->fetchAll();

        $xpath = sprintf('//div[contains(@class, "article")]//h2[text()="%s"]', $title);
        $this->assertXpathElementDoesNotExist($xpath);

        $xpath = sprintf('//div[contains(@class, "article")]//p[text()="%s"]', $articles[0]['content']);
        $this->assertXpathElementDoesNotExist($xpath);
    }

    /**
     * @AfterScenario
     *
     * @return null
     */
    public function clearDatabase()
    {
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
