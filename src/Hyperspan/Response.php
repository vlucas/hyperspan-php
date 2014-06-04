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
    protected $_forms = array();
    protected $_items = array();
    protected $_itemsOptions = array();

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
    public function getForms()
    {
        return $this->_forms;
    }

    /**
     * Add form with name and array
     */
    public function addForm($name, array $form)
    {
        $this->_forms[$name] = $form;
        return $this;
    }

    /**
     * Get action with name
     */
    public function getForm($name)
    {
        if(isset($this->_forms[$name])) {
            return $this->_forms[$name];
        }
        return false;
    }

    /**
     * Remove action with name
     */
    public function removeForm($name)
    {
        if(isset($this->_forms[$name])) {
            unset($this->_forms[$name]);
        }
        return $this;
    }

    /**
     * Get array of embeded items/entities
     *
     * @return array
     */
    public function getItems($name = null)
    {
        if($name !== null) {
            if(isset($this->_items[$name])) {
                return $this->_items[$name];
            }
            return array();
        }
        return $this->_items;
    }

    /**
     * Add item to collection
     *
     * @param string $name Lowercase name of the item collection
     * @param array  $item Single item to add to collection
     * @param array  $options Array of options to pass to collection
     *
     * @return self
     */
    public function addItem($name, $item, array $options = array())
    {
        $this->_items[$name][] = $item;
        if(!empty($options)) {
            $this->setItemOptions($name, $options);
        }
        return $this;
    }

    /**
     * Set group of items as collection
     *
     * @param string $name Lowercase name of the item collection
     * @param array  $items Array of items to set as collection
     * @param array  $options Array of options to pass to collection
     *
     * @return self
     */
    public function setItems($name, array $items, array $options = array('collection' => true))
    {
        $this->_items[$name] = $items;
        $this->setItemOptions($name, $options);
        return $this;
    }

    /**
     * Remove items with name
     */
    public function removeItems($name)
    {
        if(isset($this->_items[$name])) {
            unset($this->_items[$name]);
        }
        return $this;
    }

    /**
     * Set Items Options
     *
     * @param string $name Name/key of items
     * @return self
     */
    public function setItemOptions($name, array $options)
    {
        $this->_itemsOptions[$name] = $options;
        return $this;
    }

    /**
     * Get Items Options
     *
     * @param string $name Name/key of items
     * @return array
     */
    public function getItemOptions($name)
    {
        if(isset($this->_itemsOptions[$name])) {
            return $this->_itemsOptions[$name];
        }
        return array();
    }
}

