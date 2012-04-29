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

class JsonFormater implements FormaterInterface
{
    public function format(Event $event)
    {
        $data = array(
            'type'      => $event->getType(),
            'timestamp' => $event->getTimestamp(),
            'title'     => $event->getTitle(),
            'message'   => $event->getMessage(),
            'picture'   => $event->getPicture(),
            'extras'    => $event->getExtras(),
        );

        return json_encode($data);
    }
}
