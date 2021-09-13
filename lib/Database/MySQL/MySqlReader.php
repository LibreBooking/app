<?php

class MySqlReader implements IReader
{
    private $_result = null;

    public function __construct($result)
    {
        $this->_result = $result;
    }

    public function GetRow()
    {
        return mysqli_fetch_assoc($this->_result);
    }

    public function NumRows()
    {
        return mysqli_num_rows($this->_result);
    }

    public function Free()
    {
        mysqli_free_result($this->_result);
    }
}
