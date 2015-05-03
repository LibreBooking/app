<?php
/**
Copyright 2011-2015 Nick Korbel

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

define('ROOT_DIR', '../../../');

require_once(ROOT_DIR . 'lib/Common/namespace.php');

try
{
	ob_clean();
	require_once(ROOT_DIR . 'lib/external/securimage/securimage.php');

	$img = new securimage();

	// configure the captcha display
	$img->image_width = 280;
	$img->image_height = 100;
	$img->code_length = 6;
	$img->image_bg_color = new Securimage_Color("#ffffff");
	$img->text_color = new Securimage_Color("#000000");
	$img->noise_color = $img->text_color;
	$img->line_color = new Securimage_Color("#cccccc");

	$img->show();
}
catch (Exception $ex)
{
	Log::Error('Error showing captcha image: %s', $ex);
}


?>