<?php
session_start();
define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'lib/Common/namespace.php');

//Checks if the user was authenticated by facebook and redirects to external authentication page
//Need to ask facebook token directly in the redirect_uri (?) -> Can't redirect to external auth page and then ask (???)
if (isset($_GET['code'])) { 
    try{
        $facebook_Client = new Facebook\Facebook([
            'app_id'                => Configuration::Instance()->GetSectionKey(ConfigSection::AUTHENTICATION, ConfigKeys::FACEBOOK_CLIENT_ID),
            'app_secret'            => Configuration::Instance()->GetSectionKey(ConfigSection::AUTHENTICATION, ConfigKeys::FACEBOOK_CLIENT_SECRET),
            'default_graph_version' => 'v2.5'
        ]);

        $helper = $facebook_Client->getRedirectLoginHelper();
        $accesstoken = $helper->getAccessToken();
        $_SESSION['facebook_access_token'] = serialize($accesstoken);
        
        $code = filter_input(INPUT_GET,'code');
        header("Location: ".ROOT_DIR."Web/external-auth.php?type=fb&code=".$code);
        exit;
    } catch (\Facebook\Exceptions\FacebookResponseException | \Facebook\Exceptions\FacebookSDKException $e) {
        Log::Debug("Exception during facebook login: %s", $e->getMessage());
        $_SESSION['facebook_error'] = true;
        header("Location:".ROOT_DIR."Web");
        exit();
    } 

} else{
    header("Location:".ROOT_DIR."Web");
    exit();
}
?>