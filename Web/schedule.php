<?php
/**
* Scheduler Application
* This file contians the scheduler application where
* users have an interface for reserving resources,
* viewing other reservations and modifying their own.
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 07-18-04
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
list($s_sec, $s_msec) = explode(' ', microtime());	// Start execution timer
/**
* Include Template class
*/
include_once('lib/Template.class.php');
/**
* Include scheduler-specific output functions
*/
include_once('lib/Schedule.class.php');


// Check that the user is logged in
if (!Auth::is_logged_in()) {
    Auth::print_login_msg();
}

$t = new Template(translate('Online Scheduler'));
$s = new Schedule(isset($_GET['scheduleid']) ? $_GET['scheduleid'] : null);

// Print HTML headers
$t->printHTMLHeader();

// Print welcome box
$t->printWelcome();

// Begin main table
$t->startMain();

ob_start();		// The schedule may take a long time to print out, so buffer all of that HTML data

if ($s->isValid) {
	$s->print_schedule();
	
	// Print out links to jump to new date
	$s->print_jump_links();
}
else {
	$s->print_error();
}

ob_end_flush();	// Write all of the HTML out

// End main table
$t->endMain();

list($e_sec, $e_msec) = explode(' ', microtime());		// End execution timer
$tot = ((float)$e_sec + (float)$e_msec) - ((float)$s_sec + (float)$s_msec);
echo '<!--Schedule printout time: ' . sprintf('%.16f', $tot) . ' seconds-->';
// Print HTML footer
$t->printHTMLFooter();
?>

<SCRIPT type="text/javascript" src="./test/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="./test/jquery.drag.resize.js"></SCRIPT>
<LINK rel="stylesheet" href="./test/style.css" type="text/css" media="screen" title="">


<SCRIPT type="text/javascript">
var boxSize=118;
var bookId =0;
var timeDisp="";
$(document).ready( function() {
	$('.resourceName').append('<a class="eventAdder">(add booking)</a>'); 
	$('.eventAdder').bind("click", function(e){
		AddEvent(e);
	});
	

});

function dragResizeupdated(width, left){

	timeEnd = width/boxSize;
	timeStart = (left) /  boxSize;
	
	var Time = new Date();
	Time.setHours(24);Time.setMinutes(0);Time.setSeconds(0);
	
	Time.setHours(Time.getHours() + timeStart*3);
	timeStart = Time.getHours();
	

	timeEnd = timeStart +timeEnd*3;

	$('.timeDisp').html("<i>(From: "+timeStart+" To:"+timeEnd+")</i>");
}

function AddEvent(e){
var tooltip ='Booking Id: '+(++bookId);
var handle = $(e.target).parent();
var content = $(handle).html();
var newContent = '<div class="editor">'+
'<div '+
'class="block snap-to-grid" style="width:'+boxSize+'px;left:0;">'+tooltip+
'<div class="timeDisp"></div>'+

'<div class="handle" /><div class="resize" />'+
'</div></div>';
$(handle).html(newContent+content); 
$('.editor').dragResize({grid:boxSize});


}
</SCRIPT>

