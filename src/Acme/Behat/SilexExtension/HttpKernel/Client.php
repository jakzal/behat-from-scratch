<?php

namespace Acme\Behat\SilexExtension\HttpKernel;

use Symfony\Component\HttpKernel\Client as BaseClient;
use Silex\Application;

/**
 * @author Jakub Zalas <jakub@zalas.pl>
 */
class Client extends BaseClient
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
