<?php

use Silex\Provider\FormServiceProvider;
use Silex\Provider\SymfonyBridgesServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

class Application extends Silex\Application
{
    /**
     * @param boolean $debug
     *
     * @return null
     */
    public function __construct($debug = false)
    {
        parent::__construct();

        $this['debug'] = (boolean) $debug;

        $this->registerServiceProviders();
        $this->registerRoutes();
    }

    /**
     * @return string
     */
    public function handleHomepage()
    {
        return $this['twig']->render('homepage.twig');
    }

    /**
     * @return null
     */
    private function registerServiceProviders()
    {
        $this->register(new UrlGeneratorServiceProvider());
        $this->register(new FormServiceProvider());
        $this->register(new ValidatorServiceProvider());
        $this->register(new TranslationServiceProvider(),array('translator.messages' => array()));
        $this->register(new TwigServiceProvider(), array('twig.path' => __DIR__.'/../templates'));
        $this->register(new SymfonyBridgesServiceProvider());
    }

    /**
     * @return null
     */
    private function registerRoutes()
    {
        $this->get('/', array($this, 'handleHomepage'));
    }
}
