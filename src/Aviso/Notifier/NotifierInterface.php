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
namespace Aviso\Notifier;

use Aviso\Event\Event;
use Aviso\Formater\FormaterInterface;

interface NotifierInterface
{
    /**
     * @abstract
     * @param \Aviso\Event\Event $event
     * @return \Aviso\Notifier\NotifierReponse
     */
    public function handleEvent(Event $event);

    public function setFormater(FormaterInterface $formater);

    public function getFormater();
}
