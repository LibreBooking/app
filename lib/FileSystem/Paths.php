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

class Paths
{
	/**
	 * Filesystem directory for storing reservation attachments. Always contains trailing slash
	 *
	 * @static
	 * @return string
	 */
	public static function ReservationAttachments()
	{
		$uploadDir = Configuration::Instance()->GetSectionKey(ConfigSection::UPLOADS, ConfigKeys::UPLOAD_RESERVATION_ATTACHMENTS);

		if (empty($uploadDir))
		{
			$uploadDir = dirname(__FILE__) . '/' . ROOT_DIR . 'uploads/reservation';
		}

		if (!is_dir($uploadDir))
		{
			$uploadDir =  dirname(__FILE__) . '/' . ROOT_DIR . $uploadDir;
		}

		if (!BookedStringHelper::EndsWith($uploadDir, '/'))
		{
			$uploadDir = $uploadDir . '/';
		}

		if (!is_dir($uploadDir))
		{
			Log::Debug('Could not find directory %s. Attempting to create it', $uploadDir);
			$created = mkdir($uploadDir);
			if ($created)
			{
				Log::Debug('Created %s', $uploadDir);
			}
			else
			{
				Log::Debug('Could not create %s', $uploadDir);
			}

		}
		return $uploadDir;
	}

    /**
     * Filesystem directory for storing terms of service file. Always contains trailing slash
     *
     * @static
     * @return string
     */
	public static function Terms()
    {
        return ROOT_DIR . 'Web/uploads/tos/';
    }

    /**
     * Filesystem directory for storing terms of email templates for given language. Always contains trailing slash
     *
     * @static
     * @param $language string
     * @return string
     */
    public static function EmailTemplates($language)
    {
        if (AvailableLanguages::Contains($language)) {
            return dirname(__FILE__) . '/' . ROOT_DIR . "lang/$language/";
        }
        return dirname(__FILE__) . '/' . ROOT_DIR . "lang/en_us/";
    }
}