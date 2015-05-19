<?php

namespace Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\Stream\Stream;

class RecorderClient extends Client
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var ResponseFileLocator
     */
    private $fileLocator;

    /**
     * @param ClientInterface     $client
     * @param ResponseFileLocator $fileLocator
     * @param array               $config
     */
    public function __construct(ClientInterface $client, ResponseFileLocator $fileLocator, array $config = [])
    {
        parent::__construct($config);

        $this->client = $client;
        $this->fileLocator = $fileLocator;
    }

    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function send(RequestInterface $request)
    {
        $response = $this->client->send($request);

        $this->saveResponse($request, $response);

        return $response;
    }

    /**
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    private function saveResponse(RequestInterface $request, ResponseInterface $response)
    {
        $responseFilePath = $this->fileLocator->getResponseFilePath($request);
        $bodyFilePath = $this->fileLocator->getBodyFilePath($request);

        file_put_contents($bodyFilePath, $response->getBody()->getContents());
        $response->setBody(new Stream(fopen($bodyFilePath, 'r')));

        file_put_contents($responseFilePath, serialize($response));
    }
}