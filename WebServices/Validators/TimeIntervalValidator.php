<?php

require_once(ROOT_DIR . 'lib/Common/Validators/namespace.php');

class TimeIntervalValidator extends ValidatorBase
{
	private $value;
	private $attributeName;

	public function __construct($value, $attributeName)
	{
		$this->value = $value;
		$this->attributeName = $attributeName;
		$this->isValid = true;
	}

	/**
	 * @return void
	 */
	public function Validate()
	{
		try
		{
			TimeInterval::Parse($this->value);
		}
		catch(Exception $ex)
		{
			$this->isValid = false;
			$this->AddMessage("Invalid time specified for {$this->attributeName}");
		}
	}

}

