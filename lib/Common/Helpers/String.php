<?php 
class String
{
	public static function StartsWith($string, $search)
	{	
		$length = strlen($search);
   		return (substr($string, 0, $length) === $search);
	}
}
?>