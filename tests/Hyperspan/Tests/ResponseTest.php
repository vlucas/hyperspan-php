<?php
namespace Hyperspan\Tests;
use Hyperspan\Response;

/**
 * @backupGlobals disabled
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
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
        $this->assertEquals($expected, $res->toArray());
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
        $this->assertEquals($expected, $res->toArray());
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
        $this->assertEquals($expected, $res->toArray());
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
        $this->assertEquals($expected, $res->toArray());
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
        $this->assertEquals($expected, $res2->toArray());
    }
}

