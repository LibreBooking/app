<?php

class EqualValidator extends ValidatorBase implements IValidator
{
    private $_value1;
    private $_value2;

    public function __construct($value1, $value2)
    {
        $this->_value1 = $value1;
        $this->_value2 = $value2;
    }

    public function Validate()
    {
        $this->isValid = ($this->_value1 == $this->_value2);
    }

    public function __toString()
    {
        return sprintf('value1: %s, value2: %s', $this->_value1, $this->_value2);
    }
}
