<?php
namespace Hyperspan\Tests;
use Hyperspan\Response;

/**
 * @backupGlobals disabled
 */
class ArrayAccessTest extends \PHPUnit_Framework_TestCase
{
    public function testOffsetGetGetsProperties()
    {
        $res = new Response();
        $res->setProperties(array(
            'foo' => 'bar',
            'bar' => 'baz'
        ));

        $this->assertEquals('bar', $res['foo']);
        $this->assertEquals('baz', $res['bar']);
    }

    public function testOffsetSetSetsProperties()
    {
        $res = new Response();

        $res['foo'] = 'bar';
        $res['bar'] = 'baz';

        $props = $res->getProperties();

        $this->assertEquals('bar', $props['foo']);
        $this->assertEquals('baz', $props['bar']);
    }

    public function testOffsetIssetChecksProperties()
    {
        $res = new Response();

        $res['foo'] = 'bar';

        $props = $res->getProperties();

        $this->assertEquals(true, isset($props['foo']));
        $this->assertEquals(false, isset($props['bar']));
    }

    public function testOffsetUnsetRemovesProperties()
    {
        $res = new Response();

        $res['foo'] = 'bar';
        $res['bar'] = 'baz';

        $props = $res->getProperties();

        $this->assertEquals(true, isset($props['foo']));
        unset($props['foo']);
        $this->assertEquals(false, isset($props['foo']));
    }
}

