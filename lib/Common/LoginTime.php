<?php
class LoginTime
{
	var $Now = null;
	
	var $_format = '%Y-%m-$d %H:%i%s';
	
	function Now()
	{
		if (empty($this->Now))
		{
			return date($this->_format);
		}
		else 
		{
			return date($this->_format, $this->Now);
		}
	}
}
?>