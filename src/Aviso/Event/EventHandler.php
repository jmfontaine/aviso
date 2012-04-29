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
namespace Aviso\Event;

use Aviso\Notifier\NotifierInterface;

class EventHandler
{
    /**
     * @var \SplObjectStorage
     */
    private $notifiers;

    public function __construct()
    {
        $this->notifiers = new \SplObjectStorage();
    }

    public function attach(NotifierInterface $notifier)
    {
        $this->notifiers->attach($notifier);
    }

    public function detach(NotifierInterface $notifier)
    {
        $this->notifiers->detach($notifier);
    }

    public function handle(Event $event)
    {
        $timestamp = $event->getTimestamp();
        if (empty($timestamp)) {
            $event->setTimestamp(time());
        }

        foreach ($this->notifiers as $notifier) {
            $notifier->handleEvent($event);
        }
    }
}
