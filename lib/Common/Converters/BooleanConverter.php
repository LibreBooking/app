<?php
class BooleanConverter implements IConvert
{
	public function Convert($value)
	{
		return strtolower($value) == 'true';
	}
}
?>