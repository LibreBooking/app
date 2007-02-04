<?php
/**
* Abstract base class for creating a forced file download page
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 01-25-07
* @package phpScheduleIt.PageBase.Download
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/../../../';
require_once($basedir . '/lib/pagebase/Page.php');

class DownloadPage extends Page
{
	var $stream = null;
	var $filename = null;

	function printHeaders() {
		header("Content-type: application/octet-stream\n");
		header("Content-disposition: attachment; filename=\"{$this->filename}\"\n");
		header("Content-transfer-encoding: binary\n");
		header('Content-length: ' . $this->stream->getSize(). "\n");
		header("Pragma: public\n");
		header("Cache-Control: max-age=0\n");
	}

	function download() {
		$this->printHeaders();
		$this->stream->download();
		exit();
	}
}
?>