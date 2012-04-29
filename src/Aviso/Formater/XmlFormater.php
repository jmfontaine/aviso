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

class XmlFormater implements FormaterInterface
{
    private $encoding;

    protected function appendNode(\DOMElement $parentNode, $name, $value)
    {
        $value = htmlspecialchars($value, ENT_COMPAT, $this->getEncoding());
        $parentNode->appendChild(new \DOMElement($name, (string) $value));
    }

    public function __construct($encoding = 'UTF-8')
    {
        $this->setEncoding($encoding);
    }

    public function format(Event $event)
    {
        $encoding = $this->getEncoding();
        $dom = new \DOMDocument('1.0', $encoding);
        $rootNode = $dom->appendChild(new \DOMElement('event'));

        $data = array(
            'type'      => $event->getType(),
            'timestamp' => $event->getTimestamp(),
            'title'     => $event->getTitle(),
            'message'   => $event->getMessage(),
            'picture'   => $event->getPicture(),
        );
        foreach ($data as $name => $value) {
            $this->appendNode($rootNode, $name, $value);
        }

        $extrasNode = $rootNode->appendChild(new \DOMElement('extras'));
        foreach ($event->getExtras() as $name => $value) {
            $this->appendNode($extrasNode, $name, $value);
        }

        $xml = $dom->saveXML();

        // Remove XML protocol
        $xml = preg_replace('/<\?xml version="1.0"( encoding="[^\"]*")?\?>\n/u', '', $xml);

        return $xml;
    }

    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;

        return $this;
    }

    public function getEncoding()
    {
        return $this->encoding;
    }
}
