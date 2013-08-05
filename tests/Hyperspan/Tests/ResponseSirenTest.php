<?php
namespace Hyperspan\Tests;
use Hyperspan\Response;
use Hyperspan\Formatter;

/**
 * @backupGlobals disabled
 */
class ResponseSirenTest extends \PHPUnit_Framework_TestCase
{
    public function testSet()
    {
        $res = new Response();
        $res->title = 'Testing Title';

        $expected = array(
            'title' => 'Testing Title'
        );

        $format = new Formatter\Siren($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testSetOverridesAnyKey()
    {
        $res = new Response();
        $res->properties = array('foo' => 'bar');
        $res->setProperties(array(
            'title' => 'Add Item',
            'foo' => 'bar',
            'bar' => 'baz'
        ));

        $expected = array(
            'properties' => array(
                'foo' => 'bar'
            )
        );

        $format = new Formatter\Siren($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testSetProperties()
    {
        $res = new Response();
        $res->setProperties(array(
            'title' => 'Add Item',
            'foo' => 'bar',
            'bar' => 'baz'
        ));

        $expected = array(
            'properties' => array(
                'title' => 'Add Item',
                'foo' => 'bar',
                'bar' => 'baz'
            )
        );

        $format = new Formatter\Siren($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testAddLink()
    {
        $res = new Response();
        $res->addLink('self', 'http://localhost/foo/bar');

        $expected = array(
            'links' => array(
                array(
                    'rel' => 'self',
                    'href' => 'http://localhost/foo/bar'
                )
            )
        );

        $format = new Formatter\Siren($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testAddLinkArray()
    {
        $res = new Response();
        $res->addLink('self', array(
            'class' => array('foo', 'bar'),
            'href' => 'http://localhost/foo/bar'
        ));

        $expected = array(
            'links' => array(
                array(
                    'rel' => 'self',
                    'class' => array('foo', 'bar'),
                    'href' => 'http://localhost/foo/bar'
                )
            )
        );

        $format = new Formatter\Siren($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testAddAction()
    {
        $res = new Response();
        $res->addAction('add-item', array(
            'title' => 'Add Item',
            'method' => 'POST',
            'href' => '/post'
        ));

        $expected = array(
            'actions' => array(
                array(
                    'name' => 'add-item',
                    'title' => 'Add Item',
                    'method' => 'POST',
                    'href' => '/post'
                )
            )
        );

        $format = new Formatter\Siren($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testAddItem()
    {
        $res = new Response();
        $res->addItem(array(
            'some' => 'value',
            'something' => 'else',
            'another' => 'one'
        ));

        $expected = array(
            'entities' => array(
                array(
                    'some' => 'value',
                    'something' => 'else',
                    'another' => 'one'
                )
            )
        );

        $format = new Formatter\Siren($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testAddItemNestedResponse()
    {
        $res = new Response();
        $res->setProperties(array(
                'foo' => 'bar'
            ))
            ->addLink('self', '/test');

        $res2 = clone $res;
        $res2->addItem($res);

        $expected = array(
            'properties' => array(
                'foo' => 'bar'
            ),
            'links' => array(
                array(
                    'rel' => 'self',
                    'href' => '/test'
                )
            )
        );
        $expected['entities'][] = $expected;

        $format = new Formatter\Siren($res2);
        $this->assertEquals($expected, $format->toArray());
    }
}

