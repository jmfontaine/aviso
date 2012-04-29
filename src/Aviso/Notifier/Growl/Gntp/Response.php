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

use \Aviso\Notifier\NotifierResponse;

class Response extends NotifierResponse
{
    const EOL = "\r\n";

    private $messageType;

    private $stringResponse;


    protected function parseResponse($response)
    {
        $lines      = explode(self::EOL, $response);
        $linesCount = count($lines);

        preg_match('!^GNTP/1.0 ([A-Z-]*)!', $lines[0], $matches);
        $this->setMessageType($matches[1]);

        for ($i = 1; $i < $linesCount; $i++) {
            // Skip empty lines
            if (empty($lines[$i])) {
                continue;
            }

            // Parse header name and value
            preg_match('!^([a-zA-Z-]*):(.*)$!', $lines[$i], $matches);
            $headerName  = $matches[1];
            $headerValue = trim($matches[2]);

            // Process header
            switch ($headerName) {
                case 'Error-Code':
                    $this->setErrorCode($headerValue);
                    break;

                case 'Error-Description':
                    $this->setErrorMessage($headerValue);
                    break;
            }
        }

        return $this;
    }

    public function __construct($stringResponse)
    {
        $this->setStringResponse($stringResponse)
             ->parseResponse($stringResponse);
    }

    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setStringResponse($stringResponse)
    {
        $this->stringResponse = $stringResponse;

        return $this;
    }

    public function getStringResponse()
    {
        return $this->stringResponse;
    }

    public function isError()
    {
        return '-ERROR' === $this->getMessageType();
    }

    public function isSuccess()
    {
        return '-OK' === $this->getMessageType();
    }

    public function setMessageType($messageType)
    {
        $this->messageType = $messageType;

        return $this;
    }

    public function getMessageType()
    {
        return $this->messageType;
    }

    public function __toString()
    {
        return $this->getStringResponse();
    }
}
