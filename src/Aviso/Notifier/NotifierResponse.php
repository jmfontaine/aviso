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

class NotifierResponse
{
    private $status;

    private $errorCode;

    private $errorMessage;

    private $exception;

    public function __construct($status, $errorCode = null, $errorMessage = null, \Exception $exception = null)
    {
        $this->setStatus($status)
             ->setErrorCode($errorCode)
             ->setErrorMessage($errorMessage)
             ->setException($exception);
    }

    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function setException($exception)
    {
        $this->exception = $exception;

        return $this;
    }

    public function getException()
    {
        return $this->exception;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }
}
