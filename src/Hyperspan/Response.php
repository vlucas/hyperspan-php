<?php
namespace Hyperspan;

/**
 * @backupGlobals disabled
 */
class Response
{
    protected $_links = array();
    protected $_actions = array();

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
     * Output response as array
     */
    public function toArray()
    {
        $res = array();

        if($this->_links) {
            $res['links'] = array();
            foreach($this->getLinks() as $rel => $link) {
                $res['links'][] = array('rel' => $rel, 'href' => $link);
            }
        }

        if($this->_actions) {
            $res['actions'] = array();
            foreach($this->getActions() as $name => $action) {
                $res['actions'][] = array_merge(array('name' => $name), $action);
            }
        }

        return $res;
    }
}

