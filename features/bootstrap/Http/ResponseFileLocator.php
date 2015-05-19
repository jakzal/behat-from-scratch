<?php

namespace Http;

use GuzzleHttp\Message\RequestInterface;

class ResponseFileLocator
{
    /**
     * @param RequestInterface $request
     *
     * @return string
     */
    public function getResponseFilePath(RequestInterface $request)
    {
        return __DIR__ . '/../stubs/' . preg_replace('/[^\w]/', '_', $request->getUrl());
    }

    /**
     * @param RequestInterface $request
     *
     * @return string
     */
    public function getBodyFilePath(RequestInterface $request)
    {
        return $this->getResponseFilePath($request).'_body';
    }
}