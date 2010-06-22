<?php
/**
* This file provides output functions
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author Richard Cantzler <rmcii@users.sourceforge.net>
* @version 03-30-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/..';

include_once($basedir . '/lib/Auth.class.php');

/**
* Provides functions for outputting template HTML
*/
class Template {
	var $title;
	var $link;
	var $dir_path;
	
	/**
	* Set the page's title
	* @param string $title title of page
	* @param int $depth depth of the current page relative to phpScheduleIt root
	*/
	function Template($title = '', $depth = 0) {
		global $conf;
		
		$this->title = (!empty($title)) ? $title : $conf['ui']['welcome'];
		$this->dir_path = str_repeat('../', $depth);
		$this->link = CmnFns::getNewLink();
	}
	
	/**
	* Print all XHTML headers
	* This function prints the HTML header code, CSS link, and JavaScript link
	*
	* DOCTYPE is XHTML 1.0 Transitional
	* @param none
	*/
	function printHTMLHeader() {
		global $conf;
		global $languages;
		global $lang;
		global $charset;
		
		$path = $this->dir_path;
		echo "<?xml version=\"1.0\" encoding=\"$charset\"?" . ">\n";
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $languages[$lang][2]?>" lang="<?php echo $languages[$lang][2]?>">
	<head>
	<title>
	<?php echo $this->title?>
	</title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset?>" />
	<?php
	if ((bool)$conf['app']['allowRss'] && Auth::is_logged_in()) {
		echo '<link rel="alternate" type="application/rss+xml" title="phpScheduleIt" href=" ' . CmnFns::getScriptURL() . '/rss.php?id=' . Auth::getCurrentID() . "\"/>\n";
	}
	?>
	<link rel="shortcut icon" href="favicon.ico"/>
	<link rel="icon" href="favicon.ico"/>
	<script language="JavaScript" type="text/javascript" src="<?php echo $path?>functions.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?php echo $path?>ajax.js"></script>
	<style type="text/css">
	@import url(<?php echo $path?>jscalendar/calendar-blue-custom.css);
	@import url(<?php echo $path?>css.css);
	</style>
	<script type="text/javascript" src="<?php echo $path?>jscalendar/calendar.js"></script>
	<script type="text/javascript" src="<?php echo $path?>jscalendar/lang/<?php echo get_jscalendar_file()?>"></script>
	<script type="text/javascript" src="<?php echo $path?>jscalendar/calendar-setup.js"></script>
	</head>
	<body>
	<?php
	}
	
	
	/**
	* Print welcome header message
	* This function prints out a table welcoming
	*  the user.  It prints links to My Control Panel,
	*  Log Out, Help, and Email Admin.
	* If the user is the admin, an admin banner will
	*  show up
	* @global $conf
	*/
	function printWelcome() {
		global $conf;
		
		// Print out notice for administrator
		echo Auth::isAdmin() ? '<h3 align="center">' . translate('Administrator') . '</h3>' : '';
		
		// Print out logoImage if it exists
		echo (!empty($conf['ui']['logoImage']))
			? '<div align="left"><img src="' . $conf['ui']['logoImage'] . '" alt="logo" vspace="5" /></div>'
			: '';
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="5" class="mainBorder">
	  <tr>
		<td class="mainBkgrdClr">
		  <h4 class="welcomeBack"><?php echo translate('Welcome Back', array($_SESSION['sessionName'], 1))?></h4>
		  <p>
			<?php $this->link->doLink($this->dir_path . 'index.php?logout=true', translate('Log Out')) ?>
			|
			<?php $this->link->doLink($this->dir_path . 'ctrlpnl.php', translate('My Control Panel')) ?>
		  </p>
		</td>
		<td class="mainBkgrdClr" valign="top">
		  <div align="right">
		    <p>
			<?php echo translate_date('header', Time::getAdjustedTime(mktime()));?>
			</p>
			<p>
			  <?php  $this->link->doLink('javascript: help();', translate('Help')) ?>
			</p>
		  </div>
		</td>
	  </tr>
	</table>
	<?php 
	}
	
	
	/**
	* Start main HTML table
	* @param none
	*/
	function startMain() {
	?>
	<p>&nbsp;</p>
	<table width="100%" border="0" cellspacing="0" cellpadding="10" style="border: solid #CCCCCC 1px;">
	  <tr>
		<td bgcolor="#FAFAFA">
		  <?php 
	}
	
	
	/**
	* End main HTML table
	* @param none
	*/
	function endMain() {
	?>
		</td>
	  </tr>
	</table>
	<?php 
	}
	
	
	/**
	* Print HTML footer
	* This function prints out a tech email
	* link and closes off HTML page
	* @global $conf
	*/
	function printHTMLFooter() {
		global $conf;
	?>
	<p align="center"><a href="http://phpscheduleit.sourceforge.net">phpScheduleIt v<?php echo $conf['app']['version']?></a></p>
	</body>
	</html>
	<?php 
	}
	
	/**
	* Sets the link class variable to reference a new Link object
	* @param none
	*/
	function set_link() {
		$this->link = CmnFns::getNewLink();
	}
	
	/**
	* Returns the link object
	* @param none
	* @return link object for this class 
	*/
	function get_link() {
		return $this->link;
	}
	
	/**
	* Sets a new title for the template page
	* @param string $title title of page
	*/
	function set_title($title) {
		$this->title = $title;
	}
}
?>