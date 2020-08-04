<?php
namespace classes;

class Api
{
    /**
     * @var array
     */
    protected $available_methods = array();

    /**
     * @var Db
     */
    protected $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    /**
     * @param string $method
     * @return bool
     */
    public function methodExists($method)
    {
        return array_key_exists($method, $this->available_methods);
    }

    /**
     * @param string $method
     * @return string
     */
    public function allowedType($method)
    {
        return $this->available_methods[$method];
    }

}