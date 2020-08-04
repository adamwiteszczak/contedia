<?php
namespace classes;

class Request
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $params = array();

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Request
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $param
     * @throws \Api\MissingArgumentException
     */
    public function requireParam($param)
    {
        if (!array_key_exists($param, $this->params)) {
            throw new \Api\MissingArgumentException('expected param: ' . $param);
        }

        return $this->params[$param];
    }

    /**
     * Get a value from the request, or return default value if it doesn't exist
     * @param string $param
     * @param mixed $default_value
     * @return mixed
     */
    public function getParam($param, $default_value = null)
    {
        if (array_key_exists($param, $this->params)) {
            return $this->params[$param];
        }

        return $default_value;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

}