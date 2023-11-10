<?php
//Defining the root directory
define('ROOT_DIR', '../');

//Loading config constants fom config file & load the google API
require_once(ROOT_DIR . 'lib/Common/namespace.php');

// Creating  new Google Client, creates the URL and inserts the Client_ID,
// and all the other informations needed to get the user information*/ 
$client = new Google\Client();
$client->setClientId(Configuration::Instance()->GetSectionKey(ConfigSection::AUTHENTICATION, ConfigKeys::CLIENT_ID));
$client->setClientSecret(Configuration::Instance()->GetSectionKey(ConfigSection::AUTHENTICATION, ConfigKeys::CLIENT_SECRET));
$client->setRedirectUri(Configuration::Instance()->GetSectionKey(ConfigSection::AUTHENTICATION, ConfigKeys::REDIRECT_URI));
$client->addScope("email");
$client->addScope("profile");
// //That's the infor and creates the google request url
$URL = $client->createAuthUrl();

if (isset($_GET['code'])) {
    var_dump(isset($_GET['code']));
    //Token validations for the client
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    //set the acess token that it received
    $client->setAccessToken($token['access_token']);

    //Using the Google API to get the user information 
    $google_oauth = new Google\Service\Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    
    //Save the informations needed to authenticate the login
    $email =  $google_account_info->email;
    $name =  $google_account_info->name;
    $givenName = $google_account_info->given_name;
    $family_name = $google_account_info->family_name;

    $code = filter_input(INPUT_GET,'code');
    
    //Save the vars needed in the session to be used on the booked authentication
    session_start();
    $_SESSION['email'] = $email;
    $_SESSION['givenName'] = $givenName;
    $_SESSION['familyName'] = $family_name;
    
    //Start the check to see if the user exists or needs to be created.
    header("Location: ".ROOT_DIR."Web/external-auth.php?type=google&code=".$code);
    exit;
} else{
    header("Location: ".$URL);
    exit();
}