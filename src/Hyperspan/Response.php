<?php
namespace Hyperspan;

/**
 * Hyperspan Response Builder
 */
class Response
{
    protected $_properties = array();
    protected $_links = array();
    protected $_actions = array();
    protected $_items = array();

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
     * Set array of properties
     *
     * @return array
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

