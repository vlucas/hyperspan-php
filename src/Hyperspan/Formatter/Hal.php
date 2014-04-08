<?php
namespace Hyperspan\Formatter;
use Hyperspan\Response;

/**
 * Formatter for HAL - Hypermedia Application Language
 */
class Hal extends Base
{
    /**
     * Output response as array
     */
    public function toArray()
    {
        $res = array();

        // Links
        if($links = $this->_response->getLinks()) {
            $res['_links'] = array();
            foreach($links as $rel => $link) {
                if(is_array($link)) {
                    $res['_links'][$rel] = $link;
                } else {
                    $res['_links'][$rel] = array('href' => $link);
                }
            }
        }

        // Forms
        if($forms = $this->_response->getForms()) {
            $res['_forms'] = array();
            foreach($forms as $name => $form) {
                $res['_forms'][$name] = $form;
            }
        }

        // Embedded items
        if($keys = $this->_response->getItems()) {
            $res['_embedded'] = array();
            foreach($keys as $key => $items) {
                $options = $this->_response->getItemOptions($key);
                foreach($items as $item) {
                    if($item instanceof Response) {
                        $itemRes = new self($item);
                        $item = $itemRes->toArray();
                    } elseif(!is_array($item)) {
                        throw new \InvalidArgumentException("Argument 1 passed to " . __METHOD__ . " must be of the type array or " . __CLASS__ . ", " . gettype($item) . " given");
                    }

                    // If set as a collection
                    if((isset($options['collection']) && $options['collection'] === true)) {
                        $res['_embedded'][$key][] = $item;
                    // or adding more than 1 item with the same key
                    } elseif(isset($res['_embedded'][$key])) {
                        if(is_array($res['_embedded'][$key]) && isset($res['_embedded'][$key][0])) {
                            $res['_embedded'][$key][] = $item;
                        } else {
                            // Make into multi-dimensional array
                            $res['_embedded'][$key] = array($res['_embedded'][$key]);
                            $res['_embedded'][$key][] = $item;
                        }
                    } else {
                        $res['_embedded'][$key] = $item;
                    }
                }
            }
        }

        // Properties
        if($props = $this->_response->getProperties()) {
            $res = array_merge($res, $props);
        }

        // Custom set data overrides everything else
        if($data = $this->_response->getData()) {
            $res = array_merge($res, $data);
        }

        return $res;
    }
}
