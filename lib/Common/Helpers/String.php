<?php 
class StringHelper
{
	public static function StartsWith($haystack, $needle)
	{	
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}
}
?>