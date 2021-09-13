<?php

class EmailAddress
{
    private $address;
    private $name;

    public function Address()
    {
        return $this->address;
    }

    public function Name()
    {
        return $this->name;
    }

    public function __construct($address, $name = '')
    {
        $this->address = $address;
        $this->name = $name;
    }

    public function __toString()
    {
        return "{$this->address}<{$this->name}>";
    }
}
