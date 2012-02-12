Behat from Scratch
==================

Simple project created as an introduction to Behat on the [first London Behat Users meetup](http://www.meetup.com/London-BEHAT-PHPSpec-user-group-for-Developers-Testers/events/46923902/).

It is based on the Silex micro-framework, uses Twig templates and Symfony's form component.

Installation
------------

Download the composer:

```bash
wget -nc http://getcomposer.org/composer.phar
```

Install the dependencies:

```bash
php composer.phar install
```

Configuration
-------------

Configure your web server to use the project's web directory as a document root.
Example configuration for apache (change paths and domain name):

```
<VirtualHost *:80>
    ServerName behat.dev

    DocumentRoot /var/www/behat.dev/web
    DirectoryIndex index.php

    Directory /var/www/behat.dev/web>
        Options FollowSymLinks
        AllowOverride All
        Order allow,deny
        allow from all
    Directory>
</VirtualHost>
```

`base_url` in `config/behat.yml` needs to be changed accordingly.

Running Behat
-------------

While installing dependencies Behat will create a link to its binary in `bin/behat`.

All the project's scenarios can be run with:

```bash
./bin/behat
```

