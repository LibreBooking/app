<?php

class Parameters
{
    private $_parameters = [];
    private $_count = 0;

    public function __construct()
    {
    }

    public function Add(Parameter &$parameter)
    {
        $this->_parameters[] = $parameter;
        $this->_count++;
    }

    public function Remove(Parameter &$parameter)
    {
        for ($i = 0; $i < $this->_count; $i++) {
            if ($this->_parameters[$i] == $parameter) {
                $this->removeAt($i);
            }
        }
    }

    public function RemoveAt($index)
    {
        unset($this->_parameters[$index]);
        $this->_parameters = array_values($this->_parameters);	// Re-index the array
        $this->_count--;
    }

    /**
     * @param $index
     * @return Parameter
     */
    public function &Items($index)
    {
        return $this->_parameters[$index];
    }

    public function Count()
    {
        return $this->_count;
    }
}
