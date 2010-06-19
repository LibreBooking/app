<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class Reservation
{
	/**
	 * @var int
	 */
	private $_userId;

	/**
	 * @return int
	 */
	public function UserId()
	{
		return $this->_userId;
	}

	/**
	 * @var int
	 */
	private $_resourceId;

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->_resourceId;
	}

	/**
	 * @var string
	 */
	private $_title;

	/**
	 * @return string
	 */
	public function Title()
	{
		return $this->_title;
	}

	/**
	 * @var string
	 */
	private $_description;

	/**
	 * @return string
	 */
	public function Description()
	{
		return $this->_description;
	}

	/**
	 * @var Date
	 */
	private $_startDate;
	
	/**
	 * @return Date
	 */
	public function StartDate()
	{
		return $this->_startDate;
	}
	
	/**
	 * @var Date
	 */
	private $_endDate;
	
	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->_endDate;
	}
	
	/**
	 * @param int $userId
	 * @param int $resourceId
	 * @param string $title
	 * @param string $description
	 */
	public function Update($userId, $resourceId, $title, $description)
	{
		$this->_userId = $userId;
		$this->_resourceId = $resourceId;
		$this->_title = $title;
		$this->_description = $description;
	}

	/**
	 * @param DateRange $duration
	 */
	public function UpdateDuration(DateRange $duration)
	{
		$this->_startDate = $duration->GetBegin()->ToUtc();
		$this->_endDate = $duration->GetEnd()->ToUtc();
	}
}
?>