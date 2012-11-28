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
require_once(ROOT_DIR . 'WebServices/ReservationsWebService.php');
require_once(ROOT_DIR . 'WebServices/ResourcesWebService.php');
require_once(ROOT_DIR . 'WebServices/UsersWebService.php');
require_once(ROOT_DIR . 'WebServices/SchedulesWebService.php');
require_once(ROOT_DIR . 'WebServices/AttributesWebService.php');
require_once(ROOT_DIR . 'WebServices/GroupsWebService.php');

require_once(ROOT_DIR . 'Web/Services/Help/ApiHelpPage.php');

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$server = new SlimServer($app);

$registry = new SlimWebServiceRegistry($app);

RegisterHelp($registry, $app);
RegisterAuthentication($server, $registry);
RegisterReservations($server, $registry);
RegisterResources($server, $registry);
RegisterUsers($server, $registry);
RegisterSchedules($server, $registry);
RegisterAttributes($server, $registry);
RegisterGroups($server, $registry);

$app->hook('slim.before.dispatch', function () use ($app, $server, $registry)
{
	if ($registry->IsSecure($app->router()->getCurrentRoute()->getName()))
	{
		$security = new WebServiceSecurity(new UserSessionRepository());
		$wasHandled = $security->HandleSecureRequest($server);
		if (!$wasHandled)
		{
			$app->halt(RestResponse::UNAUTHORIZED_CODE,
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

function RegisterReservations(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$webService = new ReservationsWebService($server,
											 new ReservationViewRepository(),
											 new PrivacyFilter(new ReservationAuthorization(PluginManager::Instance()->LoadAuthorization())),
											 new AttributeService(new AttributeRepository()));
	$category = new SlimWebServiceRegistryCategory('Reservations');
	$category->AddSecureGet('/', array($webService, 'GetReservations'), WebServices::AllReservations);
	$category->AddSecureGet('/:referenceNumber', array($webService, 'GetReservation'), WebServices::GetReservation);
	$registry->AddCategory($category);
}

function RegisterResources(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$webService = new ResourcesWebService($server, new ResourceRepository(), new AttributeService(new AttributeRepository()));
	$category = new SlimWebServiceRegistryCategory('Resources');
	$category->AddSecureGet('/', array($webService, 'GetAll'), WebServices::AllResources);
	$category->AddSecureGet('/:resourceId', array($webService, 'GetResource'), WebServices::GetResource);
	$registry->AddCategory($category);
}

function RegisterUsers(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$webService = new UsersWebService($server, new UserRepositoryFactory(), new AttributeService(new AttributeRepository()));
	$category = new SlimWebServiceRegistryCategory('Users');
	$category->AddSecureGet('/', array($webService, 'GetUsers'), WebServices::AllUsers);
	$category->AddSecureGet('/:userId', array($webService, 'GetUser'), WebServices::GetUser);
	$registry->AddCategory($category);
}

function RegisterSchedules(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$webService = new SchedulesWebService($server, new ScheduleRepository());
	$category = new SlimWebServiceRegistryCategory('Schedules');
	$category->AddSecureGet('/', array($webService, 'GetSchedules'), WebServices::AllSchedules);
	$category->AddSecureGet('/:scheduleId', array($webService, 'GetSchedule'), WebServices::GetSchedule);
	$registry->AddCategory($category);
}

function RegisterAttributes(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$webService = new AttributesWebService($server, new AttributeService(new AttributeRepository()));
	$category = new SlimWebServiceRegistryCategory('Attributes');
	$category->AddSecureGet('/:categoryId', array($webService, 'GetAttributes'), WebServices::AllCustomAttributes);
	$category->AddSecureGet('/:attributeId', array($webService, 'GetAttribute'), WebServices::GetCustomAttribute);
	$registry->AddCategory($category);
}

function RegisterGroups(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$webService = new GroupsWebService($server);
	$category = new SlimWebServiceRegistryCategory('Groups');
	$category->AddSecureGet('/:groupId', array($webService, 'GetGroup'), WebServices::GetGroup);
	$registry->AddCategory($category);
}

?>