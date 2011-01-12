<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class ExistingReservationSeries extends ReservationSeries
{
	/**
	 * @var int
	 */
	private $seriesId;
	
	/**
	 * @var ISeriesUpdateScope
	 */
	protected $seriesUpdateStrategy;	
	
	public function __construct()
	{
		parent::__construct();
		$this->ApplyChangesTo(SeriesUpdateScope::FullSeries);
	}

	public function SeriesId()
	{
		return $this->seriesId;
	}
	
	public function SeriesRepeatOptions()
	{
		return $this->_repeatOptions;
	}
	
	/**
	 * @internal
	 */
	public function WithId($seriesId)
	{
		$this->seriesId = $seriesId;
	}
	
	/**
	 * @internal
	 */
	public function WithOwner($userId)
	{
		$this->_userId = $userId;
	}
	
	/**
	 * @internal
	 */
	public function WithPrimaryResource($resourceId)
	{
		$this->_resourceId = $resourceId;
	}
	
	/**
	 * @internal
	 */
	public function WithSchedule($scheduleId)
	{
		$this->_scheduleId = $scheduleId;
	}
	
	/**
	 * @internal
	 */
	public function WithTitle($title)
	{
		$this->_title = $title;
	}
	
	/**
	 * @internal
	 */
	public function WithDescription($description)
	{
		$this->_description = $description;
	}
	
	/**
	 * @internal
	 */
	public function WithResource($resourceId)
	{
		$this->AddResource($resourceId);
	}
	
	/**
	 * @internal
	 */
	public function WithRepeatOptions(IRepeatOptions $repeatOptions)
	{
		$this->_repeatOptions = $repeatOptions;
	}

	/**
	 * @internal
	 */
	public function WithCurrentInstance(Reservation $reservation)
	{
		$this->AddInstance($reservation);
		$this->currentInstanceDate = $reservation->StartDate();
	}
	
	public function RequiresNewSeries()
	{
		return $this->seriesUpdateStrategy->RequiresNewSeries();
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
	 * @param SeriesUpdateScope $seriesUpdateScope
	 */
	public function ApplyChangesTo($seriesUpdateScope)
	{
		$this->seriesUpdateStrategy = SeriesUpdateScope::CreateStrategy($seriesUpdateScope);
	}
	
	/**
	 * @param IRepeatOptions $repeatOptions
	 */
	public function Repeats(IRepeatOptions $repeatOptions)
	{
		parent::Repeats($repeatOptions);
	}
}
?>