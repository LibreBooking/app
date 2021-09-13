<?php

class RegexValidator extends ValidatorBase implements IValidator
{
    public function __construct($value, $regex)
    {
        $this->_value = $value;
        $this->_regex = $regex;
    }

    public function Validate()
    {
        $this->isValid = false;
        if (preg_match($this->_regex, $this->_value)) {
            $this->isValid = true;
        }
    }
}
