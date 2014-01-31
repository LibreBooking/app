<?php
/**
Copyright 2012-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

define('ROOT_DIR', '../../');

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'lib/WebService/Slim/namespace.php');

require_once(ROOT_DIR . 'WebServices/AuthenticationWebService.php');
require_once(ROOT_DIR . 'WebServices/ReservationsWebService.php');
require_once(ROOT_DIR . 'WebServices/ReservationWriteWebService.php');
require_once(ROOT_DIR . 'WebServices/ResourcesWebService.php');
require_once(ROOT_DIR . 'WebServices/ResourcesWriteWebService.php');
require_once(ROOT_DIR . 'WebServices/UsersWebService.php');
require_once(ROOT_DIR . 'WebServices/UsersWriteWebService.php');
require_once(ROOT_DIR . 'WebServices/SchedulesWebService.php');
require_once(ROOT_DIR . 'WebServices/AttributesWebService.php');
require_once(ROOT_DIR . 'WebServices/GroupsWebService.php');
require_once(ROOT_DIR . 'WebServices/AccessoriesWebService.php');

require_once(ROOT_DIR . 'Web/Services/Help/ApiHelpPage.php');

if (!Configuration::Instance()->GetSectionKey(ConfigSection::API, ConfigKeys::API_ENABLED, new BooleanConverter()))
{
	die("Booked Scheduler API has been configured as disabled.<br/><br/>Set \$conf['settings']['api']['enabled'] = 'true' to enable.");
}

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
RegisterAccessories($server, $registry);

$app->hook('slim.before.dispatch', function () use ($app, $server, $registry)
{
	$routeName = $app->router()->getCurrentRoute()->getName();
	if ($registry->IsSecure($routeName))
	{
		$security = new WebServiceSecurity(new UserSessionRepository());
		$wasHandled = $security->HandleSecureRequest($server, $registry->IsLimitedToAdmin($routeName));
		if (!$wasHandled)
		{
			$app->halt(RestResponse::UNAUTHORIZED_CODE,
					   'You must be authenticated in order to access this service.<br/>' . $server->GetFullServiceUrl(WebServices::Login));
		}
	}
});

$app->error(function (\Exception $e) use ($app)
{
	require_once(ROOT_DIR . 'lib/Common/Logging/Log.php');
	Log::Error('Slim Exception. %s', $e);
	$app->response()->header('Content-Type', 'application/json');
	$app->response()->status(RestResponse::SERVER_ERROR);
	$app->response()->write('Exception was logged.');
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
	$category->AddPost('SignOut/', array($webService, 'SignOut'), WebServices::Logout);
	$category->AddPost('Authenticate/', array($webService, 'Authenticate'), WebServices::Login);
	$registry->AddCategory($category);
}

function RegisterReservations(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$readService = new ReservationsWebService($server, new ReservationViewRepository(), new PrivacyFilter(new ReservationAuthorization(PluginManager::Instance()->LoadAuthorization())), new AttributeService(new AttributeRepository()));
	$writeService = new ReservationWriteWebService($server, new ReservationSaveController(new ReservationPresenterFactory()));

	$category = new SlimWebServiceRegistryCategory('Reservations');
	$category->AddSecurePost('/', array($writeService, 'Create'), WebServices::CreateReservation);
	$category->AddSecureGet('/', array($readService, 'GetReservations'), WebServices::AllReservations);
	$category->AddSecureGet('/:referenceNumber', array($readService, 'GetReservation'), WebServices::GetReservation);
	$category->AddSecurePost('/:referenceNumber', array($writeService, 'Update'), WebServices::UpdateReservation);
	$category->AddSecurePost('/:referenceNumber/Approval', array($writeService, 'Approve'), WebServices::ApproveReservation);
	$category->AddSecureDelete('/:referenceNumber', array($writeService, 'Delete'), WebServices::DeleteReservation);

	$registry->AddCategory($category);
}

function RegisterResources(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$resourceRepository = new ResourceRepository();
	$attributeService = new AttributeService(new AttributeRepository());
	$webService = new ResourcesWebService($server, $resourceRepository, $attributeService, new ReservationViewRepository());
	$writeWebService = new ResourcesWriteWebService($server, new ResourceSaveController($resourceRepository, new ResourceRequestValidator($attributeService)));
	$category = new SlimWebServiceRegistryCategory('Resources');
	$category->AddSecureGet('/', array($webService, 'GetAll'), WebServices::AllResources);
	$category->AddGet('/Status', array($webService, 'GetStatuses'), WebServices::GetStatuses);
	$category->AddSecureGet('/Status/Reasons', array($webService, 'GetStatusReasons'), WebServices::GetStatusReasons);
	$category->AddSecureGet('/Availability', array($webService, 'GetAvailability'), WebServices::AllAvailability);
	$category->AddSecureGet('/:resourceId', array($webService, 'GetResource'), WebServices::GetResource);
	$category->AddSecureGet('/:resourceId/Availability', array($webService, 'GetAvailability'), WebServices::GetResourceAvailability);

	$category->AddAdminPost('/', array($writeWebService, 'Create'), WebServices::CreateResource);
	$category->AddAdminPost('/:resourceId', array($writeWebService, 'Update'), WebServices::UpdateResource);
	$category->AddAdminDelete('/:resourceId', array($writeWebService, 'Delete'), WebServices::DeleteResource);
	$registry->AddCategory($category);
}

function RegisterAccessories(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$webService = new AccessoriesWebService($server, new ResourceRepository(), new AccessoryRepository());
	$category = new SlimWebServiceRegistryCategory('Accessories');
	$category->AddSecureGet('/', array($webService, 'GetAll'), WebServices::AllAccessories);
	$category->AddSecureGet('/:accessoryId', array($webService, 'GetAccessory'), WebServices::GetAccessory);
	$registry->AddCategory($category);
}

function RegisterUsers(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$attributeService = new AttributeService(new AttributeRepository());
	$webService = new UsersWebService($server, new UserRepositoryFactory(), $attributeService);
	$writeWebService = new UsersWriteWebService($server,
												new UserSaveController(new ManageUsersServiceFactory(), new UserRequestValidator($attributeService, new UserRepository())));
	$category = new SlimWebServiceRegistryCategory('Users');
	$category->AddSecureGet('/', array($webService, 'GetUsers'), WebServices::AllUsers);
	$category->AddSecureGet('/:userId', array($webService, 'GetUser'), WebServices::GetUser);
	$category->AddAdminPost('/', array($writeWebService, 'Create'), WebServices::CreateUser);
	$category->AddAdminPost('/:userId', array($writeWebService, 'Update'), WebServices::UpdateUser);
	$category->AddAdminDelete('/:userId', array($writeWebService, 'Delete'), WebServices::DeleteUser);
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
	$category->AddSecureGet('Category/:categoryId', array($webService, 'GetAttributes'), WebServices::AllCustomAttributes);
	$category->AddSecureGet('/:attributeId', array($webService, 'GetAttribute'), WebServices::GetCustomAttribute);
	$registry->AddCategory($category);
}

function RegisterGroups(SlimServer $server, SlimWebServiceRegistry $registry)
{
	$groupRepository = new GroupRepository();
	$webService = new GroupsWebService($server, $groupRepository, $groupRepository);
	$category = new SlimWebServiceRegistryCategory('Groups');
	$category->AddSecureGet('/', array($webService, 'GetGroups'), WebServices::AllGroups);
	$category->AddSecureGet('/:groupId', array($webService, 'GetGroup'), WebServices::GetGroup);
	$registry->AddCategory($category);
}