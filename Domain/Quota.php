<?php

class Quota
{
	/**
	 * @var int
	 */
	private $quotaId;

	public function __construct($quotaId)
	{
	    $this->quotaId = $quotaId;
	}

	public function ExceedsQuota($reservationSeries)
	{
		throw new Exception('not implemented');
	}

	public function __toString()
	{
		return $this->quotaId . '';
	}
}
?>