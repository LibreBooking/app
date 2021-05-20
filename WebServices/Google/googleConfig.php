<?php

//Booked Settings

//Uses the Google PHP SDK Client Library to et the user information
//Needs to be installed using Composer-> composer require google/apiclient:"^2.0"
//Or manually installed

require_once(ROOT_DIR . 'lib/Config/namespace.php');

//Error Message
define("DEFAULT_ERROR_MESSAGE", "Something went wrong, with google login.");

/*This config file must be filled out before using the google sign in
a google aplication must be created 
https://console.cloud.google.com/apis/credentials 
The credentials must then be inserted below
The redirect URI path has to be absolute and pointing to /googleAuth.php in
your instalation.*/

//Google Services Constants Insert you ID and Secret
define("CLIENT_ID",Configuration::Instance()->GetSectionKey(ConfigSection::AUTHENTICATION, ConfigKeys::AUTHENTICATION_GOOGLE_CLIENT_ID));
//Google Client secret 
define("CLIENT_SECRET",Configuration::Instance()->GetSectionKey(ConfigSection::AUTHENTICATION, ConfigKeys::AUTHENTICATION_GOOGLE_CLIENT_SECRET)); 
//Google Redirect URI, the path needs to be absolute pointing to /googleAuth.php
define("REDIRECT_URI", Configuration::Instance()->GetKey(ConfigKeys::SCRIPT_URL) . "/googleAuth.php" );

error_reporting(E_ALL & ~E_NOTICE);
