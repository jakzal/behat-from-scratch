<?php

use Symfony\Component\HttpKernel\Client;
use Silex\Application;

class SilexClient extends Client
{
    /**
     * @var \Silex\Application $application
     */
    private $application = null;

    /**
     * @param \Silex\Application $application
     *
     * @return null
     */
    public function __construct(Application $application)
    {
        $this->application = $application;

        parent::__construct($application['kernel']);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function doRequest($request)
    {
        $this->application->beforeDispatched = false;

        $this->application['request'] = $request;

        $this->application->flush();

        return parent::doRequest($request);
    }
}
