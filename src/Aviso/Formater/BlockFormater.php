<?php
/**
 * This file is part of Aviso.
 *
 * Copyright (c) 2012, Jean-Marc Fontaine
 *
 * @package Aviso
 * @author Jean-Marc Fontaine <jm@jmfontaine.net>
 * @copyright 2012 Jean-Marc Fontaine <jm@jmfontaine.net>
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */
namespace Aviso\Formater;

use Aviso\Event\Event;

class BlockFormater extends AbstractFormater
{
    public function __construct($format = null)
    {
        if (null === $format) {
            $format = <<<EOT
Type: %type%
Date: %timestamp:Y-m-d H:i:s%
Title: %title%
Message: %message%

EOT;
        }

        parent::__construct($format);
    }
}
