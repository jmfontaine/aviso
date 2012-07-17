<?php
namespace Aviso\Tests\Event;

use Aviso\Event\Event;

class EventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \Aviso\Event\Event
     */
    private $event;

    public function setUp()
    {
        $this->event = new Event();
    }

    /***************************************************
     * Data providers
     ***************************************************/

    public function validTitleProvider()
    {
        return array(
            array('My dummy event'),
        );
    }

    public function validMessageProvider()
    {
        return array(
            array('My dummy message'),
            array("My\ndummy\nmessage\nspreads\nover\nseveral\nlines"),
        );
    }

    public function invalidStringValuesProvider()
    {
        return array(
            array(true),
            array(false),
            array(42),
            array(42.2),
            array(new \StdClass()),
            array(fopen('php://stdin', 'r')),
        );
    }

    /***************************************************
     * Tests
     ***************************************************/

    /**
     * @test
     * @dataProvider validTitleProvider
     */
    public function validTitleCanBeSetAndRetrieved($title)
    {
        $returnValue = $this->event->setTitle($title);
        $this->assertSame($this->event->getTitle(), $title);

        // Setters are supposed to return "$this" to allow method call chaining
        $this->assertSame($this->event, $returnValue);
    }

    /**
     * @test
     * @dataProvider invalidStringValuesProvider
     * @expectedException InvalidArgumentException
     */
    public function invalidTitleCanNotBeSet($title)
    {
        $this->event->setTitle($title);
    }

    /**
     * @test
     * @dataProvider validMessageProvider
     */
    public function validMessageCanBeSetAndRetrieved($message)
    {
        $returnValue = $this->event->setMessage($message);
        $this->assertSame($this->event->getMessage(), $message);

        // Setters are supposed to return "$this" to allow method call chaining
        $this->assertSame($this->event, $returnValue);
    }

    /**
     * @test
     * @dataProvider invalidStringValuesProvider
     * @expectedException InvalidArgumentException
     */
    public function invalidMessageCanNotBeSet($message)
    {
        $this->event->setMessage($message);
    }

    /***************************************************
     * Bugs
     ***************************************************/
}
