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
use Aviso\Notifier\Growl\Gntp\Request as GntpRequest;

/**
 * Growl notifier.
 *
 * Implements required subset of Growl Notification Transport Protocol (GNTP) - v1.0
 * @see http://growl.info/documentation/developer/gntp.php
 */
class GrowlNotifier extends AbstractNotifier
{
    const PROTOCOLE_GNTP = 'gntp';
    const PROTOCOLE_UDP  = 'udp';

    private $adapter;

    private $applicationName = 'Aviso Growl notifier';

    private $host = 'localhost';

    private $protocol;

    protected function getRequest()
    {
        if (self::PROTOCOLE_UDP === $this->getProtocole()) {
            // TODO: Support UDP protocol
            throw new \BadMethodCallException('UDP protocol is not supported yet');
        } else {
            $request = new GntpRequest();
        }

        return $request;
    }

    public function __construct($protocol = self::PROTOCOLE_GNTP, FormaterInterface $formater = null)
    {
        parent::__construct($formater);

        $this->setProtocol($protocol);
    }

    public function handleEvent(Event $event)
    {
        return $this->getAdapter()->handleEvent($event);
    }

    public function setApplicationName($applicationName)
    {
        $this->applicationName = $applicationName;

        return $this;
    }

    public function getApplicationName()
    {
        return $this->applicationName;
    }

    public function setProtocol($protocol)
    {
        if ($protocol !== $this->getProtocol()) {
            $this->protocol = $protocol;
            $this->adapter   = null;
        }

        return $this;
    }

    public function getProtocol()
    {
        return $this->protocol;
    }

    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }

    public function getAdapter()
    {
        if (null === $this->adapter) {
            if (self::PROTOCOLE_UDP === $this->getProtocol()) {
                // TODO: Support UDP protocol
                throw new \BadMethodCallException('UDP protocol is not supported yet');
            } else {
                $className = '\Aviso\Notifier\Growl\Gntp\Adapter';
            }

            $this->adapter = new $className(
                $this->getApplicationName(),
                $this->getHost()
            );
        }

        return $this->adapter;
    }

    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    public function getHost()
    {
        return $this->host;
    }
}
