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

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

$file = ServiceLocator::GetServer()->GetFile(FormKeys::RESERVATION_FILE);

if ($file != null)
{
	echo 'got a file';
	$fileName = $file->OriginalName();
	$tmpName = $file->TemporaryName();
	$fileSize = $file->Size();
	$fileType = $file->MimeType();
	$extension = $file->Extension();

	$fp = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	fclose($fp);

	$attachment = ReservationAttachment::Create($fileName, $fileType, $fileSize, $content, $extension, 1);
	$repo = new ReservationRepository();
	$repo->AddReservationAttachment($attachment);
}
?>
<form action="test-upload.php" enctype="multipart/form-data" method="POST">
	<input type="file" name="reservationFile">
	<input type="submit" value="Go"/>
</form>
<?php
?>