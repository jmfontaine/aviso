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

class CallbackNotifier extends AbstractNotifier
{
    private $callback;

    public function __construct($callback = null, FormaterInterface $formater = null)
    {
        parent::__construct($formater);

        if (null !== $callback) {
            $this->setCallback($callback);
        }
    }

    public function handleEvent(Event $event)
    {
        if ($this->callback instanceof Closure) {
            $this->callback($event);
        } else {
            call_user_func($this->callback, $event);
        }
    }

    public function setCallback($callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('Callback is not callable');
        }

        $this->callback = $callback;

        return $this;
    }

    public function getCallback()
    {
        return $this->callback;
    }
}
