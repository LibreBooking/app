<?php
class ReservationValidResult implements IReservationValidationResult
{
	private $_canBeSaved;
	private $_errors;
	private $_warnings;
	
	public function __construct($canBeSaved = true, $errors = null, $warnings = null)
	{
		$this->_canBeSaved = $canBeSaved;
		$this->_errors = $errors == null ? array() : $errors;
		$this->_warnings = $warnings == null ? array() : $warnings;
	}
	
	public function CanBeSaved()
	{
		return $this->_canBeSaved;
	}
	
	public function GetErrors()
	{
		return $this->_errors;
	}
	
	public function GetWarnings()
	{
		return $this->_warnings;
	}
}
?>