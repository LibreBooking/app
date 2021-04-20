<?php

class LowerCaseConverter implements IConvert
{
	public function Convert($value)
	{
		return strtolower($value);
	}
}
