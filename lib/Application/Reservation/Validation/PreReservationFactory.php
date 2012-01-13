<?php
/**
Copyright 2012 Nick Korbel

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
}

class PreReservationFactory implements IPreReservationFactory
{
    /**
     * @param UserSession $userSession
     * @return IReservationValidationService
     */
    public function CreatePreAddService(UserSession $userSession)
    {
        return $this->CreateAddService($this->GetRuleProcessor($userSession), $userSession);
    }

    /**
     * @param UserSession $userSession
     * @return IReservationValidationService
     */
    public function CreatePreUpdateService(UserSession $userSession)
    {
        return $this->CreateUpdateService($this->GetRuleProcessor($userSession), $userSession);
    }

    /**
     * @param UserSession $userSession
     * @return IReservationValidationService
     */
    public function CreatePreDeleteService(UserSession $userSession)
    {
        return $this->CreateDeleteService($this->GetRuleProcessor($userSession), $userSession);
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
?>