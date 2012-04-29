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

class StreamNotifier extends AbstractNotifier
{
    private $stream;

    public function __construct($stream = 'php://stdout', FormaterInterface $formater = null)
    {
        parent::__construct($formater);

        $this->setStream($stream);
    }

    public function handleEvent(Event $event)
    {
        $formatedString = $this->getFormater()->format($event);

        $handle = fopen($this->getStream(), 'a');
        flock($handle, LOCK_EX);
        fwrite($handle, $formatedString);
        fflush($handle);
        flock($handle, LOCK_UN);
        fclose($handle);
    }

    public function setStream($stream)
    {
        $this->stream = $stream;

        return $this;
    }

    public function getStream()
    {
        return $this->stream;
    }
}
