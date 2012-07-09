<?php
/**
Copyright 2012 Alois Schloegl, IST Austria
This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/


require_once('../config/config.php');

## use parameters in config/config
$url      = $conf['settings']['script.url'];
$hostname = $conf['settings']['database']['hostspec'];
$username = $conf['settings']['database']['user'];  
$password = $conf['settings']['database']['password'];  
$database = $conf['settings']['database']['name'];  
$icskey   = $conf['settings']['ics']['subscription.key'];

header("Exported calendars of phpScheduleIt");

echo '<H1>Exported calendars of <a href="',$url,'">phpScheduleIt</a></H1>';
echo 'Which calendar client are you using ?<br>';
echo '<a href="',$url,'/',basename($_SERVER['SCRIPT_NAME']),'?outlook=1">Outlook</a><br>';
echo '<a href="',$url,'/',basename($_SERVER['SCRIPT_NAME']),'?">Mozilla</a><br>';

if ((isset($_GET["outlook"]) && $_GET["outlook"]) 
 || (isset($_GET["win"]) && $_GET["win"]))
{
    $url=preg_replace('(^http)m','webcal',$url);
    echo '<H2>HowTo use with Outlook</H2><pre>Double click on link below to start calendar import into Outlook</pre>';
}
else 
{
    echo '<H2>HowTo use with Mozilla</H2>';
    echo '<pre>  Mozilla -> Menu File -> New Calendar -> <br>';
    echo '  ->"Select: On The Network" -> Next<br>';
    echo '  -> Select: iCalendar (ICS), Location: URL starting with https://... ->Next<br>';
    echo '  -> Name: (its recommended use the name listed below)</pre>';    
} 

// Open data base connection 
$link = mysql_connect( $hostname, $username, $password);
#mysql_select_db($database); 
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

// Get Urls for Schedule calendars
echo "<H3>URLs for all schedules </H3>";
$result = mysql_query('SELECT public_id, name FROM '.$database.'.schedules ORDER BY name ');
while ($row = mysql_fetch_assoc($result)) {
    echo '<a href="',$url,'/export/ical-subscribe.php?uid=&sid=',$row['public_id'],'&rid=&icskey=',$icskey,'">',$row['name'].'</a><br>';
}

// Get Urls for resource calendars
$result = mysql_query('SELECT public_id, name FROM '.$database.'.resources ORDER BY name');
echo "<H3>URLs for resources </H3>";
while ($row = mysql_fetch_assoc($result)) {
    echo '<a href="',$url,'/export/ical-subscribe.php?uid=&sid=&rid=',$row['public_id'],'&icskey=',$icskey,'">',$row['name'].'</a><br>';
}

echo "<H3>URLs for accessories </H3>";
$result = mysql_query('SELECT accessory_name FROM '.$database.'.accessories');
while ($row = mysql_fetch_assoc($result)) {
    echo '<a href="',$url,'/export/ical-subscribe.php?uid=&sid=&rid=&aid=',$row['accessory_name'],'&icskey=',$icskey,'">',$row['accessory_name'].'</a><br>';
}

// get Urls for resource calendars
### TODO: this is specific to IST Austria, its generic use should be documented somewhere else. 
echo "<H3>Accessory calendars (combined)</H3>";
foreach (array("IT%","Announce%","Catering%","Tech%") as $cal) {
    echo '<a href="',$url,'/export/ical-subscribe.php?uid=&sid=&rid=&aid=',$cal,'&icskey=',$icskey,'">',$cal,'</a><br>';
}


// Free the resources associated with the result set
// This is done automatically at the end of the script
mysql_free_result($result);
mysql_close($link);

?>
