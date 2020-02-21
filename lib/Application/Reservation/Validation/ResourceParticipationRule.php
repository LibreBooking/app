<?php
/**
Copyright 2013-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class ResourceParticipationRule implements IReservationValidationRule
{
	/**
	 * @param ReservationSeries $reservationSeries
	 * @param $retryParameters
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries, $retryParameters)
	{
		$errorMessage = new StringBuilder();
		foreach ($reservationSeries->AllResources() as $resource)
		{
			if (!$resource->HasMaxParticipants())
			{
				continue;
			}

			foreach ($reservationSeries->Instances() as $instance)
			{
				$numberOfParticipants = count($instance->Participants());

				Log::Debug('ResourceParticipationRule Resource=%s,InstanceId=%s,MaxParticipants=%s,CurrentParticipants=%s',
						   $resource->GetName(), $instance->ReservationId(), $resource->GetMaxParticipants(),
						   $numberOfParticipants);
				if ($numberOfParticipants > $resource->GetMaxParticipants())
				{
					$errorMessage->AppendLine(Resources::GetInstance()->GetString('MaxParticipantsError',
																				  array($resource->GetName(), $resource->GetMaxParticipants())));
					continue;
				}
			}
		}

		$message = $errorMessage->ToString();
		if (strlen($message) > 0)
		{
			return new ReservationRuleResult(false, $message);
		}
		return new ReservationRuleResult();
	}
}
