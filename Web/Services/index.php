<?php
/**
Copyright 2012 Nick Korbel

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

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'lib/WebService/Slim/namespace.php');

require_once(ROOT_DIR . 'WebServices/AuthenticationWebService.php');

require_once(ROOT_DIR . 'Web/Services/Help/ApiHelpPage.php');

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$server = new SlimServer($app);

//die($app->environment()->offsetGet('slim.url_scheme'));
//die($app->environment()->offsetGet('HOST'));
//var_dump($app);
//die();

$registry = new SlimWebServiceRegistry($app);

RegisterHelp($registry, $app);
RegisterAuthentication($server, $registry);

$app->run();

function RegisterHelp(SlimWebServiceRegistry $registry, \Slim\Slim $app)
{
	$app->get('/', function () use ($registry, $app)
	{
		// Print API documentation
		ApiHelpPage::Render($registry, $app);
	});

	$app->get('/Help', function () use ($registry, $app)
	{
		// Print API documentation
		ApiHelpPage::Render($registry, $app);
	});

}

function RegisterAuthentication(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$auth = new AuthenticationWebService($server, new WebServiceAuthentication(PluginManager::Instance()->LoadAuthentication(), new UserSessionRepository()));

	$authCategory = new SlimWebServiceRegistryCategory('Authentication');
	$authCategory->AddPost('SignOut', array($auth, 'SignOut'), WebServices::Logout);
	$authCategory->AddPost('Authenticate', array($auth, 'Authenticate'), WebServices::Login);
	$registry->AddCategory($authCategory);
}

function RegisterUser(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$auth = new AuthenticationWebService($server, new WebServiceAuthentication(PluginManager::Instance()->LoadAuthentication(), new UserSessionRepository()));
	$authCategory = new SlimWebServiceRegistryCategory('Users');
	$authCategory->AddGet(':userid/Bookings', array($auth, 'MyBookings'), WebServices::MyBookings);
}
?>