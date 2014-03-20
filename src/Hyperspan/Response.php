<?php
namespace Hyperspan;

/**
 * Hyperspan Response Builder
 */
class Response implements \ArrayAccess
{
    protected $_data = array();
    protected $_properties = array();
    protected $_links = array();
    protected $_actions = array();
    protected $_items = array();

    /**
     * Set base property
     */
    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    /**
     * Get base property
     */
    public function __get($name)
    {
        return $this->_data[$name];
    }

    /**
     * ArrayAccess implementation
     *
     * Allows easy access to set properties
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->_properties[] = $value;
        } else {
            $this->_properties[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->_properties[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->_properties[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->_properties[$offset]) ? $this->_properties[$offset] : null;
    }

    /**
     * Get array of set data
     *
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Get array of properties
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->_properties;
    }

    /**
     * Set single of property
     *
     * @return self
     */
    public function setProperty($name, $value)
    {
        $this->_properties[$name] = $value;
        return $this;
    }

    /**
     * Set array of properties
     *
     * @return self
     */
    public function setProperties(array $properties)
    {
        $this->_properties = $properties;
        return $this;
    }

    /**
     * Get array of links
     *
     * @return array
     */
    public function getLinks()
    {
        return $this->_links;
    }

    /**
     * Add link with name and URL
     */
    public function addLink($rel, $href)
    {
        $this->_links[$rel] = $href;
        return $this;
    }

    /**
     * Get link with name
     */
    public function getLink($rel)
    {
        if(isset($this->_links[$rel])) {
            return $this->_links[$rel];
        }
        return false;
    }

    /**
     * Remove link with name
     */
    public function removeLink($rel)
    {
        if(isset($this->_links[$rel])) {
            unset($this->_links[$rel]);
        }
        return $this;
    }

    /**
     * Get array of actions
     *
     * @return array
     */
    public function getActions()
    {
        return $this->_actions;
    }

    /**
     * Add action with name and URL
     */
    public function addAction($name, array $action)
    {
        $this->_actions[$name] = $action;
        return $this;
    }

    /**
     * Get action with name
     */
    public function getAction($name)
    {
        if(isset($this->_actions[$name])) {
            return $this->_actions[$name];
        }
        return false;
    }

    /**
     * Remove action with name
     */
    public function removeAction($name)
    {
        if(isset($this->_actions[$name])) {
            unset($this->_actions[$name]);
        }
        return $this;
    }

    /**
     * Get array of items/entities
     *
     * @return array
     */
    public function getItems()
    {
        return $this->_items;
    }

    /**
     * Add item to collection
     */
    public function addItem($item)
    {
        $this->_items[] = $item;
        return $this;
    }
}

