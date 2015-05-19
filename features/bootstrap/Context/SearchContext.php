<?php

namespace Context;

use Behat\Behat\Context\Context;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\ResponseInterface;

class SearchContext implements Context
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var ResponseInterface
     */
    private $lastResponse;

    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @When I search for :postcode
     */
    public function iSearchFor($postcode)
    {
        $this->lastResponse = $this->httpClient->get('http://api.postcodes.io/postcodes/'.$postcode, ['exceptions' => false]);
    }

    /**
     * @Then I should see its location
     */
    public function iShouldSeeItsLocation()
    {
        $json = $this->lastResponse->json();

        \PHPUnit_Framework_Assert::assertSame(200, $this->lastResponse->getStatusCode(), 'Got a successful response');
        \PHPUnit_Framework_Assert::assertInternalType('array', $json, 'Response contains a query result');
        \PHPUnit_Framework_Assert::arrayHasKey('result', $json, 'Result found in the response');
        \PHPUnit_Framework_Assert::assertArrayHasKey('latitude', $json['result'], 'Latitude found in the response');
        \PHPUnit_Framework_Assert::assertArrayHasKey('longitude', $json['result'], 'Longitude found in the response');
        \PHPUnit_Framework_Assert::assertInternalType('double', $json['result']['latitude'], 'Latitude is a double');
        \PHPUnit_Framework_Assert::assertInternalType('double', $json['result']['longitude'], 'Longitude is a double');
    }


    /**
     * @Then I should be informed the postcode was not found
     */
    public function iShouldBeInformedThePostcodeWasNotFound()
    {
        \PHPUnit_Framework_Assert::assertSame(404, $this->lastResponse->getStatusCode(), '404 Not Found');
    }
}
