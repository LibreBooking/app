<?php
define('ROOT_DIR', '../../../');

require_once(ROOT_DIR . 'lib/WebService/RestRequestProcessor.php');
require_once(ROOT_DIR . 'lib/WebService/JsonRestServer.php');
require_once(ROOT_DIR . 'WebServices/AuthenticationWebService.php');

$authenticationService = new AuthenticationWebService();
$service = new RestRequestProcessor($authenticationService, new JsonRestServer());
$service->ProcessRequest();

?>