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
namespace Aviso\Formater;

use Aviso\Event\Event;

abstract class AbstractFormater implements FormaterInterface
{
    private $eol = PHP_EOL;

    private $format;

    public function __construct($format = null, $eol = null)
    {
        if (null !== $format) {
            $this->setFormat($format);
        }
        if (null !== $eol) {
            $this->setEol($eol);
        }
    }

    public function format(Event $event)
    {
        $format = $this->getFormat();

        // Process timestamp
        preg_match('/%timestamp:(.*?)%/', $format, $matches);
        list($timestampTag, $timestampFormat) = $matches;
        $timestamp = date($timestampFormat, $event->getTimestamp());
        $format    = str_replace($timestampTag, $timestamp, $format);

        // Process the other items
        $extras = array();
        foreach ($event->getExtras() as $name => $value) {
            $extras[] = $name . ': ' . $value;
        }
        $data = array(
            '%extras%'  => implode(', ', $extras),
            '%message%' => $event->getMessage(),
            '%picture%' => $event->getPicture(),
            '%title%'   => $event->getTitle(),
            '%type%'    => $event->getType(),
        );

        return strtr($format . $this->getEol(), $data);
    }

    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setEol($eol)
    {
        $this->eol = $eol;

        return $this;
    }

    public function getEol()
    {
        return $this->eol;
    }
}
