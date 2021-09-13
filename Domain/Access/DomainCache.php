<?php

class DomainCache
{
    private $_cache;

    public function __construct()
    {
        $this->_cache = [];
    }

    /**
     * @param mixed $key
     * @return bool
     */
    public function Exists($key)
    {
        return array_key_exists($key, $this->_cache);
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function Get($key)
    {
        return $this->_cache[$key];
    }

    /**
     * @param mixed $key
     * @param mixed $object
     */
    public function Add($key, $object)
    {
        $this->_cache[$key] = $object;
    }

    /**
     * @param mixed $key
     */
    public function Remove($key)
    {
        unset($this->_cache[$key]);
    }
}
