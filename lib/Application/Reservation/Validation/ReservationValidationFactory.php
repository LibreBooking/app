<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

class ReservationValidationFactory implements IReservationValidationFactory
{
	/**
	 * @var array|string[]
	 */
	private $creationStrategies = array();

	public function __construct()
	{
		//$this->creationStrategies[ReservationAction::Approve] = 'CreateUpdateService';
		$this->creationStrategies[ReservationAction::Create] = 'CreateAddService';
		$this->creationStrategies[ReservationAction::Delete] = 'CreateDeleteService';
		$this->creationStrategies[ReservationAction::Update] = 'CreateUpdateService';
	}

	public function Create($reservationAction, $userSession)
	{
		if (array_key_exists($reservationAction, $this->creationStrategies))
		{
			$ruleProcessor = $this->GetRuleProcessor($userSession);

			$createMethod = $this->creationStrategies[$reservationAction];
			return $this->$createMethod($ruleProcessor, $userSession);
		}

		return new NullReservationValidationService();
	}
	
	private function CreateAddService(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		$reservationRepository = new ReservationViewRepository();

		$ruleProcessor->AddRule(new ResourceAvailabilityRule(new ResourceReservationAvailability($reservationRepository), $userSession->Timezone));
		$ruleProcessor->AddRule(new AccessoryAvailabilityRule($reservationRepository, new AccessoryRepository(), $userSession->Timezone));

		return new AddReservationValidationService($ruleProcessor);
	}
	
	private function CreateUpdateService(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		$reservationRepository = new ReservationViewRepository();

		$ruleProcessor->AddRule(new ExistingResourceAvailabilityRule(new ResourceReservationAvailability($reservationRepository), $userSession->Timezone));
		$ruleProcessor->AddRule(new AccessoryAvailabilityRule($reservationRepository, new AccessoryRepository(), $userSession->Timezone));

		return new UpdateReservationValidationService($ruleProcessor);
	}
	
	private function CreateDeleteService(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		return new DeleteReservationValidationService($ruleProcessor);
	}
	
	private function GetRuleProcessor(UserSession $userSession)
	{
		$resourceRepository = new ResourceRepository();
		$reservationRepository = new ReservationViewRepository();
		// Common rules
		$rules = array();
		$rules[] = new ReservationDateTimeRule();
		$rules[] = new AdminExcludedRule(new ReservationStartTimeRule(), $userSession);
		$rules[] = new AdminExcludedRule(new PermissionValidationRule(new PermissionServiceFactory()), $userSession);
		$rules[] = new AdminExcludedRule(new ResourceMinimumNoticeRule($resourceRepository), $userSession);
		$rules[] = new AdminExcludedRule(new ResourceMaximumNoticeRule($resourceRepository), $userSession);
		$rules[] = new AdminExcludedRule(new ResourceMinimumDurationRule($resourceRepository), $userSession);
		$rules[] = new AdminExcludedRule(new ResourceMaximumDurationRule($resourceRepository), $userSession);
		$rules[] = new AdminExcludedRule(new QuotaRule(new QuotaRepository(), $reservationRepository, new UserRepository(), new ScheduleRepository()), $userSession);
		$rules[] = new ResourceAvailabilityRule(new ResourceBlackoutAvailability($reservationRepository), $userSession->Timezone);
		
		return new ReservationValidationRuleProcessor($rules);
	}
}

class NullReservationValidationService implements IReservationValidationService
{
	/**
	 * @param ReservationSeries $reservation
	 * @return IReservationValidationResult
	 */
	function Validate($reservation)
	{
		return new ReservationValidationResult();
	}
}
?>