<?php
class LoginTime
{
	var $Now = null;
	
	var $_format = 'Y-m-d H:is';
	
	function LoginTime()
	{
		static $tmp;
		$this->Now =& $tmp;		
	}
	
	function SetNow($value){
		$this->$Now = &$tmp;
	}
	
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