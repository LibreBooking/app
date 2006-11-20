<?php
/**
* Allows the forced download of a string as a file attachment
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-19-06
* @package phpScheduleIt.PageBase.Download
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/../../..';
require_once('DownloadPage.php');
require_once('streams/StringDownloadStream.php');

class StreamDownload extends DownloadPage
{
	/**
	* Allows the forced download of a string as a file attachment
	* @param string $filename the name of the downloaded file
	* @param string $string the string contents of the file to download
	*/
	function StreamDownload($filename, $string) {
		$this->stream = new StringDownloadStream($string);
		$this->filename = $filename;
	}
}
?>