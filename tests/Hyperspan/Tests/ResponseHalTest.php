<?php
namespace Hyperspan\Tests;
use Hyperspan\Response;
use Hyperspan\Formatter;

class ResponseHalTest extends \PHPUnit_Framework_TestCase
{
    public function testSetCustomKeys()
    {
        $res = new Response();
        $res->title = 'Testing Title';

        $expected = array(
            'title' => 'Testing Title'
        );

        $format = new Formatter\Hal($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testSetOverridesAnyKey()
    {
        $res = new Response();
        $res->foo = 'newkey';
        $res->setProperties(array(
            'title' => 'Add Item',
            'foo' => 'bar',
            'bar' => 'baz'
        ));

        $expected = array(
            'title' => 'Add Item',
            'foo' => 'newkey',
            'bar' => 'baz'
        );

        $format = new Formatter\Hal($res);
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
            'title' => 'Add Item',
            'foo' => 'bar',
            'bar' => 'baz'
        );

        $format = new Formatter\Hal($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testAddLink()
    {
        $res = new Response();
        $res->addLink('self', 'http://localhost/foo/bar');

        $expected = array(
            '_links' => array(
                'self' => array(
                    'href' => 'http://localhost/foo/bar'
                )
            )
        );

        $format = new Formatter\Hal($res);
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
            '_links' => array(
                'self' => array(
                    'class' => array('foo', 'bar'),
                    'href' => 'http://localhost/foo/bar'
                )
            )
        );

        $format = new Formatter\Hal($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testRemoveLink()
    {
        $res = new Response();
        $res->addLink('self', 'http://localhost/foo/bar');
        $res->addLink('next', 'http://localhost/foo/bar?page=2');
        $res->removeLink('self');

        $expected = array(
            '_links' => array(
                'next' => array(
                    'href' => 'http://localhost/foo/bar?page=2'
                )
            )
        );

        $format = new Formatter\Hal($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testAddForm()
    {
        $res = new Response();
        $res->addForm('add-item', array(
            'title' => 'Add Item',
            'method' => 'POST',
            'href' => '/post'
        ));

        $expected = array(
            '_forms' => array(
                'add-item' => array(
                    'title' => 'Add Item',
                    'method' => 'POST',
                    'href' => '/post'
                )
            )
        );

        $format = new Formatter\Hal($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testRemoveAction()
    {
        $res = new Response();
        $res->addForm('add-item', array(
            'title' => 'Add Item',
            'method' => 'POST',
            'href' => '/post'
        ));
        $res->addForm('delete-item', array(
            'title' => 'Delete Item',
            'method' => 'DELETE',
            'href' => '/post/123'
        ));
        $res->removeForm('delete-item');

        $expected = array(
            '_forms' => array(
                'add-item' => array(
                    'title' => 'Add Item',
                    'method' => 'POST',
                    'href' => '/post'
                )
            )
        );

        $format = new Formatter\Hal($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testAddItem()
    {
        $res = new Response();
        $res->addItem('item', array(
            'some' => 'value',
            'something' => 'else',
            'another' => 'one'
        ));

        $expected = array(
            '_embedded' => array(
                'item' => array(
                    'some' => 'value',
                    'something' => 'else',
                    'another' => 'one'
                )
            )
        );

        $format = new Formatter\Hal($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testAddItemMultiple()
    {
        $res = new Response();
        $res->addItem('items', array(
            'some' => 'value',
            'something' => 'else',
            'another' => 'one'
        ));
        $res->addItem('items', array(
            'some' => 'value2',
            'something' => 'else2',
            'another' => 'two'
        ));

        $expected = array(
            '_embedded' => array(
                'items' => array(
                    array(
                        'some' => 'value',
                        'something' => 'else',
                        'another' => 'one'
                    ),
                    array(
                        'some' => 'value2',
                        'something' => 'else2',
                        'another' => 'two'
                    )
                )
            )
        );

        $format = new Formatter\Hal($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testAddItemAsCollection()
    {
        $res = new Response();
        $res->addItem('item', array(
            'some' => 'value',
            'something' => 'else',
            'another' => 'one'
        ), array('collection' => true));

        $expected = array(
            '_embedded' => array(
                'item' => array(
                    array(
                        'some' => 'value',
                        'something' => 'else',
                        'another' => 'one'
                    )
                )
            )
        );

        $format = new Formatter\Hal($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testAddItemMultipleTypes()
    {
        $res = new Response();
        $res->addItem('items', array(
            'some' => 'value',
            'something' => 'else',
            'another' => 'one'
        ));
        $res->addItem('items', array(
            'some' => 'value2',
            'something' => 'else2',
            'another' => 'two'
        ));

        $res->addItem('user', array(
            'name' => 'Chester Tester',
            'username' => 'test'
        ));

        $expected = array(
            '_embedded' => array(
                'items' => array(
                    array(
                        'some' => 'value',
                        'something' => 'else',
                        'another' => 'one'
                    ),
                    array(
                        'some' => 'value2',
                        'something' => 'else2',
                        'another' => 'two'
                    )
                ),
                'user' => array(
                    'name' => 'Chester Tester',
                    'username' => 'test'
                )
            )
        );

        $format = new Formatter\Hal($res);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testAddItemAsCollectionViaSetItemOptions()
    {
        $res = new Response();
        $res->addItem('item', array(
            'some' => 'value',
            'something' => 'else',
            'another' => 'one'
        ));
        $res->setItemOptions('item', array('collection' => true));

        $expected = array(
            '_embedded' => array(
                'item' => array(
                    array(
                        'some' => 'value',
                        'something' => 'else',
                        'another' => 'one'
                    )
                )
            )
        );

        $format = new Formatter\Hal($res);
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
        $res2->addItem('item', $res);

        $expected = array(
            '_links' => array(
                'self' => array(
                    'href' => '/test'
                )
            ),
            'foo' => 'bar'
        );
        $expected['_embedded']['item'] = $expected;

        $format = new Formatter\Hal($res2);
        $this->assertEquals($expected, $format->toArray());
    }

    public function testSetItemsIsCollection()
    {
        $res = new Response();
        $res->setItems('items', array(
            array(
                'some' => 'value',
                'something' => 'else',
                'another' => 'one'
            ), array(
                'some' => 'value2',
                'something' => 'else2',
                'another' => 'two'
            )
        ));

        $res->setItems('users', array(array(
            'name' => 'Chester Tester',
            'username' => 'test'
        )));

        $expected = array(
            '_embedded' => array(
                'items' => array(
                    array(
                        'some' => 'value',
                        'something' => 'else',
                        'another' => 'one'
                    ),
                    array(
                        'some' => 'value2',
                        'something' => 'else2',
                        'another' => 'two'
                    )
                ),
                'users' => array(
                    array(
                        'name' => 'Chester Tester',
                        'username' => 'test'
                    )
                )
            )
        );

        $format = new Formatter\Hal($res);
        $this->assertEquals($expected, $format->toArray());
    }
}

