<?php
/**
* Allows for forced file download as a file attachment
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-13-06
* @package phpScheduleIt.PageBase.Download
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

require_once('DownloadPage.php');

class FileDownload extends DownloadPage
{
	/**
	* Allows for forced file download as a file attachment
	* @param string $filename the name of the downloaded file
	* @param string $path the full path to the file, without the file name
	* @param string $file the full file name
	*/
	function FileDownload($filename, $path, $file) {
		$this->stream = new FileDownloadStream($path, $file);
		$this->filename = $filename;
	}
}
?>