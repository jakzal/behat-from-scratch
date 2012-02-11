<?php

include __DIR__.'/../vendor/.composer/autoload.php';
require_once __DIR__.'/../src/Application.php';

$application = new Application(false);
$application->run();
