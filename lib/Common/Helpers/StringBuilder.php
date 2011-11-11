<?php
class StringBuilder 
{
	private $_string = array();
	
	public function Append($string) 
	{
		$this->_string[] = $string;
	}

	public function AppendLine()
	{
		$this->_string[] = "\n";
	}

	public function ToString() 
	{
		return join('', $this->_string);
	}
}
?>