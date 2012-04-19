Behat from Scratch
==================

Simple project created as an introduction to [Behat](http://behat.org/) on the [first London Behat Users meetup](http://www.meetup.com/London-BEHAT-PHPSpec-user-group-for-Developers-Testers/events/46923902/).

It is based on the [Silex micro-framework](http://silex.sensiolabs.org/), uses [Twig](http://twig.sensiolabs.org/) templates and [Symfony](http://symfony.com/)'s form component.

Installation
------------

Download [the composer](http://getcomposer.org/):

```bash
curl -s http://getcomposer.org/installer | php
```

Install the dependencies:

```bash
php composer.phar install
```

Running Behat
-------------

By default custom Silex session is used so there's no need for additional configuration.
Behat will create a Silex application and simulate requests.

All the project's scenarios can be run with:

```bash
./bin/behat
```

Composer created this symbolic link during the installation.

Running in a browser
--------------------

To use session run in a browser (like goutte or selenium) you will have to change 
`default_sesion` in `config/behat.yml` and configure a web server. 
Example configuration for apache:

```
<VirtualHost *:80>
    ServerName behat.dev

    DocumentRoot /var/www/behat.dev/web
    DirectoryIndex index.php

    <Directory /var/www/behat.dev/web>
        Options FollowSymLinks
        AllowOverride All
        Order allow,deny
        allow from all
    </Directory>
</VirtualHost>
```

Paths to source code and a domain name have to be updated. 
Also `base_url` in `config/behat.yml` needs to be changed accordingly.
