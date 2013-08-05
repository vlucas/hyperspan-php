<?php
namespace Hyperspan\Formatter;
use Hyperspan\Response;

/**
 * Formatter for Siren Hypermedia Format
 */
class Siren extends Base
{
    /**
     * Output response as array
     */
    public function toArray()
    {
        $res = array();

        if($props = $this->_response->getProperties()) {
            $res['properties'] = $props;
        }

        if($links = $this->_response->getLinks()) {
            $res['links'] = array();
            foreach($links as $rel => $link) {
                if(is_array($link)) {
                    $res['links'][] = array_merge(array('rel' => $rel), $link);
                } else {
                    $res['links'][] = array('rel' => $rel, 'href' => $link);
                }
            }
        }

        if($actions = $this->_response->getActions()) {
            $res['actions'] = array();
            foreach($actions as $name => $action) {
                $res['actions'][] = array_merge(array('name' => $name), $action);
            }
        }

        if($items = $this->_response->getItems()) {
            $res['entities'] = array();
            foreach($items as $item) {
                if($item instanceof Response) {
                    $itemRes = new self($item);
                    $item = $itemRes->toArray();
                } elseif(!is_array($item)) {
                    throw new \InvalidArgumentException("Argument 1 passed to " . __METHOD__ . " must be of the type array or " . __CLASS__ . ", " . gettype($item) . " given");
                }
                $res['entities'][] = $item;
            }
        }

        if($data = $this->_response->getData()) {
            $res = array_merge($res, $data);
        }

        return $res;
    }
}

