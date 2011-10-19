<?php
class ReservationNotificationFactory implements IReservationNotificationFactory
{
	/**
	 * @var array|string[]
	 */
	private $creationStrategies = array();
	
	public function __construct()
	{
		$this->creationStrategies[ReservationAction::Approve] = 'CreateApproveService';
		$this->creationStrategies[ReservationAction::Create] = 'CreateAddService';
		$this->creationStrategies[ReservationAction::Delete] = 'CreateDeleteService';
		$this->creationStrategies[ReservationAction::Update] = 'CreateUpdateService';
	}
	
	public function Create($reservationAction)
	{
		$userRepo = new UserRepository();
		$resourceRepo = new ResourceRepository();
				
		if (array_key_exists($reservationAction, $this->creationStrategies))
		{
			$createMethod = $this->creationStrategies[$reservationAction];
			return $this->$createMethod($userRepo, $resourceRepo);
		}

		return new NullReservationNotificationService();
	}
	
	private function CreateAddService($userRepo, $resourceRepo)
	{
		return new AddReservationNotificationService($userRepo, $resourceRepo);
	}

	private function CreateApproveService($userRepo, $resourceRepo)
	{
		return new ApproveReservationNotificationService($userRepo, $resourceRepo);
	}
	
	private function CreateDeleteService($userRepo, $resourceRepo)
	{
		return new DeleteReservationNotificationService();
	}
	
	private function CreateUpdateService($userRepo, $resourceRepo)
	{

		return new UpdateReservationNotificationService($userRepo, $resourceRepo);
	}
}

class NullReservationNotificationService implements IReservationNotificationService
{

	/**
	 * @param ReservationSeries $reservationSeries
	 */
	function Notify($reservationSeries)
	{
		// no-op
	}
}
?>