<?php
require_once('lib/Common/SmartyPage.php');
require_once('Controls/ReservationControl.php');
$r = new ReservationControl(new SmartyPage());
$r->PageLoad();
?>