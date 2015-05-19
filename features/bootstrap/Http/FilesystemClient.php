<?php

namespace Http;

use GuzzleHttp\Client;
use GuzzleHttp\Message\RequestInterface;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\Stream\Stream;

class FilesystemClient extends Client
{
    /**
     * @var ResponseFileLocator
     */
    private $fileLocator;

    /**
     * @param ResponseFileLocator $fileLocator
     * @param array               $config
     */
    public function __construct(ResponseFileLocator $fileLocator, array $config = [])
    {
        parent::__construct($config);

        $this->fileLocator = $fileLocator;
    }

    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function send(RequestInterface $request)
    {
        $response = $this->loadResponse($request);

        if (!$response instanceof ResponseInterface) {
            return new Response(404);
        }

        return $response;
    }

    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface|null
     */
    private function loadResponse(RequestInterface $request)
    {
        $responseFilePath = $this->fileLocator->getResponseFilePath($request);
        $bodyFilePath = $this->fileLocator->getBodyFilePath($request);

        if (file_exists($responseFilePath) && file_exists($bodyFilePath)) {
            /* @var ResponseInterface $response */
            $response = unserialize(file_get_contents($responseFilePath));
            $response->setBody(new Stream(fopen($bodyFilePath, 'r')));

            return $response;
        }
    }
}