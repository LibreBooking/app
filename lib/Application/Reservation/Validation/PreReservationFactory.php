<?php
/**
Copyright 2011-2017 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

interface IPreReservationFactory
{
	/**
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	public function CreatePreAddService(UserSession $userSession);

	/**
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	public function CreatePreUpdateService(UserSession $userSession);

	/**
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	public function CreatePreDeleteService(UserSession $userSession);

	/**
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	public function CreatePreApprovalService(UserSession $userSession);

	/**
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	public function CreatePreCheckinService(UserSession $userSession);

	/**
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	public function CreatePreCheckoutService(UserSession $userSession);
}

class PreReservationFactory implements IPreReservationFactory
{
	/**
	 * @var ResourceRepository
	 */
	protected $resourceRepository;

	/**
	 * @var ReservationViewRepository
	 */
	protected $reservationRepository;

	/**
	 * @var ScheduleRepository
	 */
	protected $scheduleRepository;

	/**
	 * @var UserRepository
	 */
	protected $userRepository;

	/**
	 * @var AccessoryRepository
	 */
	protected $accessoryRepository;

	public function __construct()
	{
		$this->resourceRepository = new ResourceRepository();
		$this->reservationRepository = new ReservationViewRepository();
		$this->scheduleRepository = new ScheduleRepository();
		$this->userRepository = new UserRepository();
		$this->accessoryRepository = new AccessoryRepository();
	}

	/**
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	public function CreatePreAddService(UserSession $userSession)
	{
		return $this->CreateAddService($this->GetAddUpdateRuleProcessor($userSession), $userSession);
	}

	/**
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	public function CreatePreUpdateService(UserSession $userSession)
	{
		return $this->CreateUpdateService($this->GetAddUpdateRuleProcessor($userSession), $userSession);
	}

	/**
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	public function CreatePreDeleteService(UserSession $userSession)
	{
		return $this->CreateDeleteService($this->GetRuleProcessor($userSession), $userSession);
	}

	/**
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	public function CreatePreApprovalService(UserSession $userSession)
	{
		return new NullReservationValidationService();
	}

	/**
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	public function CreatePreCheckinService(UserSession $userSession)
	{
		$rules = array();
		$rules[] = new AdminExcludedRule(new AnonymousResourceExcludedRule(new CurrentUserIsReservationUserRule($userSession), $userSession), $userSession, $this->userRepository);
		$rules[] = new ReservationCanBeCheckedInRule($userSession);

		return new ReservationValidationRuleProcessor($rules);
	}

	/**
	 * @param UserSession $userSession
	 * @return IReservationValidationService
	 */
	public function CreatePreCheckoutService(UserSession $userSession)
	{
		$rules = array();
		$rules[] = new AdminExcludedRule(new CurrentUserIsReservationUserRule($userSession), $userSession, $this->userRepository);
		$rules[] = new ReservationCanBeCheckedOutRule($userSession);

		return new ReservationValidationRuleProcessor($rules);
	}

	private function CreateAddService(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		$ruleProcessor->PushRule(new AdminExcludedRule(new RequiresApprovalRule(PluginManager::Instance()->LoadAuthorization()), $userSession, $this->userRepository));
		$ruleProcessor->PushRule(new ResourceAvailabilityRule(new ResourceAvailability($this->reservationRepository), $userSession->Timezone));
		return new AddReservationValidationService($ruleProcessor);
	}

	private function CreateUpdateService(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		if (Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_UPDATES_REQUIRE_APPROVAL, new BooleanConverter()))
		{
			$ruleProcessor->PushRule(new AdminExcludedRule(new RequiresApprovalRule(PluginManager::Instance()->LoadAuthorization()), $userSession, $this->userRepository));
		}
        $ruleProcessor->PushRule(new AdminExcludedRule(new CurrentUserIsReservationUserRule($userSession), $userSession, $this->userRepository));
        $ruleProcessor->PushRule(new ExistingResourceAvailabilityRule(new ResourceAvailability($this->reservationRepository), $userSession->Timezone));
        return new UpdateReservationValidationService($ruleProcessor);
	}

	private function CreateDeleteService(ReservationValidationRuleProcessor $ruleProcessor, UserSession $userSession)
	{
		$ruleProcessor->AddRule(new AdminExcludedRule(new CurrentUserIsReservationUserRule($userSession), $userSession, $this->userRepository));
		return new DeleteReservationValidationService($ruleProcessor);
	}

	private function GetRuleProcessor(UserSession $userSession)
	{
		// Common rules
		$rules = array();
		$rules[] = new ReservationDateTimeRule();
		$rules[] = new ReservationBasicInfoRule();
		$rules[] = new AdminExcludedRule(new ReservationStartTimeRule($this->scheduleRepository), $userSession, $this->userRepository);
		$rules[] = new AdminExcludedRule(new PermissionValidationRule(new PermissionServiceFactory()), $userSession, $this->userRepository);
		$rules[] = new AdminExcludedRule(new ResourceMinimumNoticeRule(), $userSession, $this->userRepository);
		$rules[] = new AdminExcludedRule(new ResourceMaximumNoticeRule(), $userSession, $this->userRepository);
		$rules[] = new AdminExcludedRule(new ResourceParticipationRule(), $userSession, $this->userRepository);
		$rules[] = new ReservationAttachmentRule();

		return new ReservationValidationRuleProcessor($rules);
	}

	private function GetAddUpdateRuleProcessor(UserSession $userSession)
	{
		$ruleProcessor = $this->GetRuleProcessor($userSession);

		$ruleProcessor->AddRule(new AdminExcludedRule(new ResourceMinimumDurationRule($this->resourceRepository), $userSession, $this->userRepository));
		$ruleProcessor->AddRule(new AdminExcludedRule(new ResourceMaximumDurationRule($this->resourceRepository), $userSession, $this->userRepository));
		$ruleProcessor->AddRule(new AdminExcludedRule(new ResourceCrossDayRule($this->scheduleRepository), $userSession, $this->userRepository));
		$ruleProcessor->AddRule(new AdminExcludedRule(new QuotaRule(new QuotaRepository(), $this->reservationRepository, $this->userRepository, $this->scheduleRepository, new QuotaRepository()), $userSession, $this->userRepository));
		$ruleProcessor->AddRule(new SchedulePeriodRule($this->scheduleRepository, $userSession));
		$ruleProcessor->AddRule(new AdminExcludedRule(new CustomAttributeValidationRule(new AttributeService(new AttributeRepository()), $this->userRepository), $userSession, $this->userRepository));
		$ruleProcessor->AddRule(new AdminExcludedRule(new CreditsRule($this->userRepository, $userSession), $userSession, $this->userRepository));
		$ruleProcessor->AddRule(new AccessoryAvailabilityRule($this->reservationRepository, $this->accessoryRepository, $userSession->Timezone));
		$ruleProcessor->AddRule(new AccessoryResourceRule($this->accessoryRepository));

		return $ruleProcessor;
	}


}