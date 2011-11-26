<?php
require_once(ROOT_DIR . 'Domain/Blackout.php');

interface IBlackoutRepository
{
	/**
	 * @abstract
	 * @param Blackout $blackout
	 * @return void
	 */
	public function Add(Blackout $blackout);
}

class BlackoutRepository implements IBlackoutRepository
{
	/**
	 * @param Blackout $blackout
	 * @return void
	 */
	public function Add(Blackout $blackout)
	{
		$db = ServiceLocator::GetDatabase();
		$seriesId = $db->ExecuteInsert(new AddBlackoutCommand($blackout->OwnerId(), $blackout->ResourceId(), $blackout->Title()));
		$db->Execute(new AddBlackoutInstanceCommand($seriesId, $blackout->StartDate(), $blackout->EndDate()));
	}
}
