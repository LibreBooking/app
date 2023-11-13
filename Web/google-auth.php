<?php
//Defining the root directory
define('ROOT_DIR', '../');

//Loading config constants fom config file & load the google API
require_once(ROOT_DIR . 'lib/Common/namespace.php');

//Checks if the user was authenticated by google
if (isset($_GET['code'])) {
    $code = filter_input(INPUT_GET,'code');
    header("Location: ".ROOT_DIR."Web/external-auth.php?type=google&code=".$code);
    exit;
} else{
    header("Location:".ROOT_DIR."Web");
    exit();
}