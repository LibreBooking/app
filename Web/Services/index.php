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
require_once(ROOT_DIR . 'WebServices/BookingsWebService.php');

require_once(ROOT_DIR . 'Web/Services/Help/ApiHelpPage.php');

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$server = new SlimServer($app);

$registry = new SlimWebServiceRegistry($app);

RegisterHelp($registry, $app);
RegisterAuthentication($server, $registry);
RegisterBookings($server, $registry);

$app->hook('slim.before.dispatch', function () use ($app, $server, $registry)
{
	if ($registry->IsSecure($app->router()->getCurrentRoute()->getName()))
	{
		$security = new WebServiceSecurity(new UserSessionRepository());
		$wasHandled = $security->HandleSecureRequest($server);
		if (!$wasHandled)
		{
			$app->halt(401,
					   'You must be authenticated in order to access this service.<br/>' . $server->GetFullServiceUrl(WebServices::Login));
		}
	}
});

$app->run();

function RegisterHelp(SlimWebServiceRegistry $registry, \Slim\Slim $app)
{
	$app->get('/', function () use ($registry, $app)
	{
		// Print API documentation
		ApiHelpPage::Render($registry, $app);
	})->name("Default");

	$app->get('/Help', function () use ($registry, $app)
	{
		// Print API documentation
		ApiHelpPage::Render($registry, $app);
	})->name("Help");

}

function RegisterAuthentication(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$webService = new AuthenticationWebService($server, new WebServiceAuthentication(PluginManager::Instance()->LoadAuthentication(), new UserSessionRepository()));

	$category = new SlimWebServiceRegistryCategory('Authentication');
	$category->AddPost('SignOut', array($webService, 'SignOut'), WebServices::Logout);
	$category->AddPost('Authenticate', array($webService, 'Authenticate'), WebServices::Login);
	$registry->AddCategory($category);
}

function RegisterBookings(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$webService = new BookingsWebService($server);
	$category = new SlimWebServiceRegistryCategory('Bookings');
	$category->AddGet('/', array($webService, 'GetBookings'), WebServices::Bookings);
	$registry->AddCategory($category);
}

?>