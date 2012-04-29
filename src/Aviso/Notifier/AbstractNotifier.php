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

use Aviso\Formater\FormaterInterface;
use Aviso\Formater\LineFormater;

abstract class AbstractNotifier implements NotifierInterface
{
    /**
     * @var Aviso\Formater\FormaterInterface
     */
    private $formater;

    public function __construct(FormaterInterface $formater = null)
    {
        if (null === $formater) {
            $formater = new LineFormater();
        }
        $this->setFormater($formater);
    }

    public function setFormater(FormaterInterface $formater)
    {
        $this->formater = $formater;

        return $this;
    }

    public function getFormater()
    {
        return $this->formater;
    }
}
