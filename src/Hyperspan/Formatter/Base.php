<?php
namespace Hyperspan\Formatter;
use Hyperspan\Response;

/**
 * Base formatter class that other formatters will extend
 */
abstract class Base
{
    protected $_response;

    /**
     * Output response as array
     */
    public function __construct(Response $res)
    {
        $this->_response = $res;
    }

    /**
     * Output response as array
     */
    public function toArray() {}

    /**
     * Output response as JSON
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Output response as XML
     */
    public function toXML()
    {
        throw new RuntimeException("Method " . __METHOD__ . " not implemented");
    }
}

