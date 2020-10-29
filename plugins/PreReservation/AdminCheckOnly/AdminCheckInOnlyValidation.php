<?php
/**
Copyright 2012-2019 Nick Korbel

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

class AdminCheckInOnlyValidation implements IReservationValidationService
{
	/**
	 * @var IReservationValidationService
	 */
	private $serviceToDecorate;

	/**
	 * @var UserSession
	 */
	private $userSession;


	public function __construct(IReservationValidationService $serviceToDecorate,
	 														UserSession $userSession)
	{
		$this->serviceToDecorate = $serviceToDecorate;
		$this->userSession = $userSession;
	}

	public function Validate($series, $retryParameters = null)
	{
		$result = $this->serviceToDecorate->Validate($series, $retryParameters);

		if (!$result->CanBeSaved())
		{
			return $result;
		}



		return $this->EvaluateCustomRule($series);
	}

	private function EvaluateCustomRule($series)
	{
		$configFile = Configuration::Instance()->File('AdminCheckOnly'); // Gets config file
		$customAttributeId = $configFile->GetKey('admincheckonly.attribute.checkin.id'); //Gets ID from AdminCheckInOnly
		$resources = $series->AllResources();
		$adminChecks=0; //Number of resources with AdminCheckInOnly
		$userChecks=0;	//Number of resources without AdminCheckInOnly

		foreach ($resources as $key => $resource) {//Gets AdminCheckInOnly from all attributes

			$attributeRepository = new AttributeRepository();
			$attributes = $attributeRepository->GetEntityValues(4,$resource->GetId());

			foreach($attributes as $attribute){

	                 if($customAttributeId == $attribute->AttributeId){
	                   $adminCheckOnly = $attribute->Value; //Gets AdminCheckInOnly's value

										 if($adminCheckOnly){
											 $adminChecks++;

										 }else{
											 $userChecks++;
										 }
	                 }
								 }
	 					 }
	  $isAdmin = ($this->userSession->IsAdmin || $this->userSession->IsResourceAdmin);
	  Log::Debug('Validating AdminCheckInOnly resources, AdminChecks?:%s. UserChecks?:%s. Is Admin?:%s', $adminChecks, $userChecks, $isAdmin);

		//Changes message in case there is a conflict with other resources that don't have AdminCheckOnly
		if($userChecks){
			$customMessage = $configFile->GetKey('admincheckonly.message.checkin.resource.conflict');
		} else {
			$customMessage = $configFile->GetKey('admincheckonly.message.checkin');
		}

		//If AdminCheckInOnly is on and user doesn't have priviliges,
		//validation fails, showing the custom message for the user
		if($adminChecks && (!$isAdmin)) {
			return new ReservationValidationResult(false, $customMessage);
		}

		// Returns valid result if there's nothing wrong
		return new ReservationValidationResult();

 }

}
