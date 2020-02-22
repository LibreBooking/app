<?php
/**
Copyright 2011-2020 Nick Korbel

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

require_once(ROOT_DIR . 'lib/external/SimpleImage/SimpleImage.php');

interface IImageFactory
{
	/**
	 * @return IImage
	 */
	function Load($pathToImage);
}

class ImageFactory implements IImageFactory
{
	public function Load($pathToImage)
	{
		if (!extension_loaded('gd'))
		{
			die('gd extension is required for image upload');
		}

		$image = new SimpleImage();
      	$image->load($pathToImage);

      	return new Image($image);
	}
}
