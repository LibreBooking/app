<?php
/**
* Interface a DownloadPage stream object
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-13-06
* @package Interfaces
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

class IDownloadStream
{
	/**
	* The action to take to force the download of the file
	* @param none
	*/
	function download() {
		die ('Not implemented');
	}
	
	/**
	* Gets the size of the download
	* @param none
	* @return this size of the download file in bytes
	*/
	function getSize() {
		die ('Not implemented');
	}
}
?>