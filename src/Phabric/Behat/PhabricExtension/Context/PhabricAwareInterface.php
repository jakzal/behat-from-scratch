<?php

namespace Phabric\Behat\PhabricExtension\Context;

use Phabric\Phabric;

interface PhabricAwareInterface
{
    public function setPhabric(Phabric $phabric);
}
