<?php
/**
* Allows for forced file download as a file attachment
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-19-06
* @package phpScheduleIt.PageBase.Download.Stream
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

require_once('IDownloadStream.class.php');

class FileDownloadStream extends IDownloadStream
{
	var $filepath;
	
	/**
	* Provides the functionality for downloading a filesystem file from the browser
	* @param string $path the full path to the file, without the file name
	* @param string $file the full file name
	*/
	function FileDownloadStream($path, $file) {
		$this->filepath = $path . $file;
		
		if(!is_file($this->filepath) OR !eregi('^[A-Z_0-9][A-Z_0-9.]*$', $file))
		{
			die('Invalid file');
		}
	}
	
	function getSize() {
		return filesize($this->filepath);
	}
	
	function download() {
		$fp = fopen($this->filepath, "r");
		fpassthru($fp);
	}
}
?>