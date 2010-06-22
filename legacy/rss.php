<?php
/**
* This page will display all upcoming reservation activity for a user as an RSS feed
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 10-08-05
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

include_once('lib/DBEngine.class.php');

if (!(bool)$conf['app']['allowRss'] || ((bool)$conf['app']['allowRss'] && !isset($_GET['id']))) {
	die();	
}

$db = new DBEngine();

$res = $db->get_user_reservations($_GET['id'], 'res.start_date', 'DESC', true);

global $charset;

header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"$charset\"?" . ">\n<rss version=\"2.0\">\n";
echo "<channel>\n<title>{$conf['app']['title']} Reservations</title>\n";

if (!$res) {
	echo "<item>\n";
	echo '<title>' . $db->err_msg . "</title>\n";
	echo '<link>' . CmnFns::getScriptURL(). "</link>\n";
	echo '<description>' . $db->err_msg . "</description>\n";
	echo "</item>\n";	
}

for ($i = 0; $i < count($res) && $res != false; $i++) {
	$cur = $res[$i];
	echo "<item>\n";
	echo '<title>' . $cur['name'] . ' [' . Time::formatDate($cur['start_date']) . ' @ ' . Time::formatTime($cur['starttime']) . "]</title>\n";
	echo '<link>' . CmnFns::getScriptURL() . "/reserve.php?type=m&amp;resid={$cur['resid']}&amp;scheduleid={$cur['scheduleid']}" . "</link>\n";
	echo '<description>' . "</description>\n";
	echo "</item>\n";
}
echo "</channel>\n</rss>";
?>