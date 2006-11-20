<?php

class StringBuilder {
	var $_string = '';
	
	/**
	* Appends this string onto the end of the full string
	* @param string $string
	*/
	function append($string) {
		$this->_string .= $string;
	}
	
	/**
	* Returns the full string
	* @param none
	* @return the fully appended string
	*/
	function toString() {
		return $this->_string;
	}
}
?>