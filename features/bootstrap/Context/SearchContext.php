<?php

namespace Context;

use Behat\Behat\Context\Context;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Zalas\Behat\RestExtension\Http\HttpClient;

class SearchContext implements Context
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var Response
     */
    private $lastResponse;

    /**
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @When I search for :postcode
     */
    public function iSearchFor($postcode)
    {
        $this->lastResponse = $this->httpClient->send(
            new Request('GET', sprintf('http://api.postcodes.io/postcodes/%s', $postcode))
        );
    }

    /**
     * @Then I should see its location
     */
    public function iShouldSeeItsLocation()
    {
        \PHPUnit_Framework_Assert::assertSame(200, $this->lastResponse->getStatusCode(), 'Got a successful response');

        $json = json_decode($this->lastResponse->getBody(), true);
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
