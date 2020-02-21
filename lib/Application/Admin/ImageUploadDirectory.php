<?php

/**
 * Copyright 2014-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class ImageUploadDirectory
{
    public function GetDirectory()
    {
        $uploadDir = Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_DIRECTORY);
        if (is_dir($uploadDir)) {
            return $uploadDir;
        }

        $dir = ROOT_DIR . $uploadDir;
        if (!is_dir($dir)) {
            @mkdir($dir);
        }

        return $dir;
    }

    public function MakeWriteable()
    {
        $chmodResult = chmod($this->GetDirectory(), 0770);
    }

    public function GetPath()
    {
        return Configuration::Instance()->GetScriptUrl() . '/' . Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_URL);
    }

}
