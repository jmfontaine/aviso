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
namespace Aviso\Notifier\Growl\Gntp;

use Aviso\Event\Event;

class Adapter
{
    const EOL = "\r\n";

    const PORT = 23053;

    private $applicationName;

    private $host;

    private $isRegistered = false;

    private $lastRequest;

    private $lastResponse;

    protected function sendRequest($request)
    {
        $this->setLastRequest($request);

        $handle = fsockopen($this->getHost(), self::PORT, $errorCode, $errorString, 5);
        stream_set_timeout($handle, 5);

        fwrite($handle, $request);

        $stringResponse = '';
        while (($currentLine = fgets($handle, 128)) !== false ) {
            $stringResponse .= $currentLine;
        }
        fclose($handle);

        $response = new Response($stringResponse);

        $this->setLastResponse($response);

        return $response;
    }

    protected function register()
    {
        $request  = 'GNTP/1.0 REGISTER NONE' . self::EOL;
        $request .= 'Origin-Software-Name: Aviso Growl Notifier' . self::EOL;
        $request .= 'Application-Name: ' . $this->getApplicationName() . self::EOL;
        $request .= 'Notifications-Count: 1' . self::EOL;
        $request .= self::EOL;
        $request .= 'Notification-Name: Notify' . self::EOL;
        $request .= 'Notification-Enabled: True' . self::EOL;
        $request .= self::EOL . self::EOL;

        return $this->sendRequest($request);
    }

    protected function notify(Event $event)
    {
        $request  = 'GNTP/1.0 NOTIFY NONE' . self::EOL;
        $request .= 'Application-Name: ' . $this->getApplicationName() . self::EOL;
        $request .= 'Notification-Name: Notify' . self::EOL;
        $request .= 'Notification-Title: ' . $event->getTitle() . self::EOL;
        $request .= 'Notification-Text: ' . $event->getMessage() . self::EOL;
        $request .= self::EOL . self::EOL;

        return $this->sendRequest($request);
    }

    public function __construct($applicationName, $host)
    {
        $this->setApplicationName($applicationName)
             ->setHost($host);
    }

    public function handleEvent(Event $event)
    {
        if (!$this->isRegistered()) {
            $response = $this->register();

            if (!$response->isSuccess()) {
                return $response;
            }
        }

        return $this->notify($event);
    }

    public function isRegistered()
    {
        return $this->isRegistered;
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

    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setLastRequest($lastRequest)
    {
        $this->lastRequest = $lastRequest;

        return $this;
    }

    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    public function setLastResponse($lastResponse)
    {
        $this->lastResponse = $lastResponse;

        return $this;
    }

    public function getLastResponse()
    {
        return $this->lastResponse;
    }
}
