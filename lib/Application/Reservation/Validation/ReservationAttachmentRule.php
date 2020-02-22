<?php
/**
Copyright 2012-2020 Nick Korbel

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

class ReservationAttachmentRule implements IReservationValidationRule
{
	/**
	 * @param ReservationSeries $reservationSeries
	 * @param $retryParameters
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries, $retryParameters)
	{
		$attachments = $reservationSeries->AddedAttachments();

		$allowedExtensionsConfig = Configuration::Instance()->GetSectionKey(ConfigSection::UPLOADS, ConfigKeys::UPLOAD_RESERVATION_EXTENSIONS);

		if (empty($allowedExtensionsConfig) || empty($attachments))
		{
			return new ReservationRuleResult();
		}

		$allowedExtensions = str_replace('.', '', $allowedExtensionsConfig);
		$allowedExtensions = str_replace(' ', '', $allowedExtensions);
		$allowedExtensionList = explode(',', $allowedExtensions);

		foreach ($attachments as $attachment)
		{
			$isValid = in_array($attachment->FileExtension(), $allowedExtensionList);
			if (!$isValid)
			{
				return new ReservationRuleResult($isValid, Resources::GetInstance()->GetString('InvalidAttachmentExtension', $allowedExtensionsConfig));
			}
		}

		return new ReservationRuleResult();
	}
}