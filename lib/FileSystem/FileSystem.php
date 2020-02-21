<?php
/**
 * Copyright 2012-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Booked {

    require_once(ROOT_DIR . 'lib/Common/namespace.php');
    require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');

    use Log;
    use Paths;
    use TemplateCacheDirectory;

    interface IFileSystem
    {
        /**
         * @param $path string
         * @param $fileName string
         * @param $fileContents string
         * @return bool
         */
        public function Save($path, $fileName, $fileContents);

        /**
         * @param $fullPath string
         * @return string
         */
        public function GetFileContents($fullPath);

        /**
         * @param $fullPath string
         * @return bool
         */
        public function RemoveFile($fullPath);

        /**
         * @return string
         */
        public function GetReservationAttachmentsPath();

        /**
         * @param $fullPath string
         * @return string[]
         */
        public function GetFiles($fullPath);

        /**
         * @param string $fullPath
         * @return bool
         */
        public function Exists($fullPath);

        /**
         * @return void
         */
        public function FlushSmartyCache();

    }

    class FileSystem implements IFileSystem
    {
        public function Save($path, $fileName, $fileContents)
        {
            $fullName = $path . $fileName;
            Log::Debug('Saving file to %s', $fullName);

            if (file_put_contents($fullName, $fileContents) === false) {
                Log::Error('Could not write contents of file: %s', $fullName);
                return false;
            }

            return true;
        }

        public function GetFileContents($fullPath)
        {
            $contents = file_get_contents($fullPath);
            if ($contents === false) {
                Log::Error('Could not read contents of file: %s', $fullPath);
                return null;
            }

            return $contents;
        }

        public function RemoveFile($fullPath)
        {
            Log::Debug('Deleting file: %s', $fullPath);
            if (unlink($fullPath) === false) {
                Log::Error('Could not delete file: %s', $fullPath);
                return false;
            }

            return true;
        }

        public function GetReservationAttachmentsPath()
        {
            return Paths::ReservationAttachments();
        }

        public function GetFiles($path, $filter = '*')
        {
            return glob($path . $filter);
        }

        public function Exists($fullPath)
        {
            return file_exists($fullPath);
        }

        public function FlushSmartyCache()
        {
            $cacheDir = new TemplateCacheDirectory();
            $cacheDir->Flush();
        }
    }
}