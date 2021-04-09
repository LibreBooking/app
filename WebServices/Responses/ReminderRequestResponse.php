<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ReminderRequestResponse
{
	public $value;
	public $interval;

	public function __construct($value, $interval)
	{
		$this->value = $value;
		$this->interval = $interval;
	}

	public static function Example()
	{
		return new ReminderRequestResponse(15, ReservationReminderInterval::Hours . ' or ' . ReservationReminderInterval::Minutes . ' or ' . ReservationReminderInterval::Days);
	}
}
