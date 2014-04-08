<?php
namespace Hyperspan\Tests;
use Hyperspan\Response;

/**
 * @backupGlobals disabled
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testGetLinkByRel()
    {
        $url = 'http://placekitten.com/200/300';
        $res = new Response();
        $res->addLink('image_src', $url);

        $link = $res->getLink('image_src');
        $this->assertEquals($url, $link);
    }

    public function testGetFormByRel()
    {
        $form = array(
            'method' => 'get',
            'href' => 'http://placekitten.com/200/300'
        );
        $res = new Response();
        $res->addForm('kitten', $form);

        $formResult = $res->getForm('kitten');
        $this->assertEquals($form, $formResult);
    }
}

