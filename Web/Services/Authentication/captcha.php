<?php
define('ROOT_DIR', '../../../');
require_once(ROOT_DIR . 'lib/WebService/RestRequestProcessor.php');
require_once(ROOT_DIR . 'lib/WebService/JsonRestServer.php');
require_once(ROOT_DIR . 'WebServices/CaptchaWebService.php');

$captchaWebService = new CaptchaWebService();
$service = new RestRequestProcessor($captchaWebService, new JsonRestServer());
$service->ProcessRequest();


?>