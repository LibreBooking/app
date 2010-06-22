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

require_once('IDownloadStream.php');

class StringDownloadStream extends IDownloadStream
{
	var $contents;
	
	/**
	* Provides the functionality for downloading a string as a file from the browser
	* @param string $string the string contents of the file to download
	*/
	function StringDownloadStream($string) {
		$this->contents = $string;
	}
	
	function getSize() {
		return strlen($this->contents);
	}
	
	function download() {
	   print($this->contents);
	}
}
?>