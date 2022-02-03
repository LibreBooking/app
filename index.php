<?php

require_once('config/config.php');

#echo 'Please update the $conf[\'settings\'][\'script.url\'] setting in your config file to be http://' . $_SERVER['SERVER_NAME'] . str_replace('/index.php', '', $_SERVER['PHP_SELF']) . '/Web';
#echo '<br/>You will be redirected automatically in 20 seconds, but portions of LibreBooking will not function correctly.';

header("refresh:0;url=Web?" . urlencode($_SERVER['QUERY_STRING']));
exit;
