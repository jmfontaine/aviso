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
use Aviso\Formater\BlockFormater;

class MailNotifier extends AbstractNotifier
{
    private $from;

    private $recipients = array();

    private $subject;

    protected function sendMail($from, $to, $subject, $body)
    {
        $additionalHeaders = sprintf("From: %s\r\nContent-type: text/plain; charset=utf-8\r\n", $from);

        var_dump($body, $subject);

        return mail(
            $to,
            $subject,
            $body,
            $additionalHeaders
        );
    }

    public function __construct($from, $recipients, $subject, FormaterInterface $formater = null)
    {
        if (null === $formater) {
            $formater = new BlockFormater();
        }

        parent::__construct($formater);

        $this->setFrom($from)
             ->setRecipients($recipients)
             ->setSubject($subject);
    }

    public function handleEvent(Event $event)
    {
        foreach ($this->getRecipients() as $recipient) {
            $result = $this->sendMail(
                $recipient,
                $this->getFrom(),
                $this->getSubject(),
                $this->getFormater()->format($event)
            );
        }
    }

    public function addRecipient($recipient)
    {
        $this->recipients[] = $recipient;

        return $this;
    }

    public function setRecipients($recipients)
    {
        $this->recipients = (array) $recipients;

        return $this;
    }

    public function getRecipients()
    {
        return $this->recipients;
    }

    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSubject()
    {
        return $this->subject;
    }
}
