<?php

namespace Acme;

use Silex\Application as SilexApplication;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class Application extends SilexApplication
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
     * @return null
     */
    private function registerServiceProviders()
    {
        $this->register(new UrlGeneratorServiceProvider());
        $this->register(new FormServiceProvider());
        $this->register(new ValidatorServiceProvider());
        $this->register(new TranslationServiceProvider(),array('translator.messages' => array()));
        $this->register(new TwigServiceProvider(), array('twig.path' => __DIR__.'/../../templates'));
    }

    /**
     * @return null
     */
    private function registerRoutes()
    {
        $this->match('/add-article', array($this, 'handleAddArticle'))
            ->bind('add_article');

        $this->get('/', array($this, 'handleHomepage'));
    }

    /**
     * @return string
     */
    public function handleHomepage()
    {
        return $this['twig']->render('homepage.twig');
    }

    /**
     * @retrn string
     */
    public function handleAddArticle()
    {
        $options = array('validation_constraint' => new Collection(array(
            'title' => new NotBlank(array('message' => 'Article title is required')),
            'body'  => new NotBlank(array('message' => 'Article body is required'))
        )));

        $form = $this['form.factory']->createBuilder('form', array(), $options)
            ->add('title', 'text')
            ->add('body', 'textarea')
            ->getForm();

        $showPreview = false;

        if ($this['request']->getMethod() == 'POST') {
            $form->bindRequest($this['request']);
            $showPreview = $form->isValid();
        }

        return $this['twig']->render('addArticle.twig', array(
            'form' => $form->createView(),
            'showPreview' => $showPreview
        ));
    }
}
