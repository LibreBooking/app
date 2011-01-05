<?php
class TestDateRange extends DateRange
{
	public function __construct()
	{
		parent::__construct(Date::Now(), Date::Now());
	}
}
?>