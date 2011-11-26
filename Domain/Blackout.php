<?php

class Blackout
{
	/**
	 * @var int
	 */
	protected $ownerId;

	/**
	 * @var int
	 */
	protected $resourceId;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var DateRange
	 */
	protected $date;

	/**
	 * @param int $userId
	 * @param int $resourceId
	 * @param string $title
	 * @param DateRange $blackoutDate
	 */
	protected function __construct($userId, $resourceId, $title, $blackoutDate)
	{
		$this->ownerId = $userId;
		$this->resourceId = $resourceId;
		$this->title = $title;
		$this->date = $blackoutDate;
	}

	/**
	 * @static
	 * @param int $userId
	 * @param int $resourceId
	 * @param string $title
	 * @param DateRange $blackoutDate
	 * @return Blackout
	 */
	public static function Create($userId, $resourceId, $title, $blackoutDate)
	{
		return new Blackout($userId, $resourceId, $title, $blackoutDate);
	}

	/**
	 * @return DateRange
	 */
	public function Date()
	{
		return $this->date;
	}

	/**
	 * @return Date
	 */
	public function StartDate()
	{
		return $this->date->GetBegin();
	}

	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->date->GetEnd();
	}

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->resourceId;
	}

	/**
	 * @return int
	 */
	public function OwnerId()
	{
		return $this->ownerId;
	}

	/**
	 * @return string
	 */
	public function Title()
	{
		return $this->title;
	}
}
?>