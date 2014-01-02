<?php
/**
Copyright 2011-2014 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'lib/Application/User/namespace.php');

class ManageUsersActions
{
	const Activate = 'activate';
	const AddUser = 'addUser';
	const ChangeAttributes = 'changeAttributes';
	const Deactivate = 'deactivate';
	const DeleteUser = 'deleteUser';
	const Password = 'password';
	const Permissions = 'permissions';
	const UpdateUser = 'updateUser';
	const ChangeColor = 'changeColor';
}

interface IManageUsersPresenter
{
	public function AddUser();

	public function UpdateUser();
}

class ManageUsersPresenter extends ActionPresenter implements IManageUsersPresenter
{
	/**
	 * @var \IManageUsersPage
	 */
	private $page;

	/**
	 * @var \UserRepository
	 */
	private $userRepository;

	/**
	 * @var ResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var PasswordEncryption
	 */
	private $passwordEncryption;

	/**
	 * @var IManageUsersService
	 */
	private $manageUsersService;

	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	/**
	 * @var IGroupRepository
	 */
	private $groupRepository;

	/**
	 * @var IGroupViewRepository
	 */
	private $groupViewRepository;

	/**
	 * @param \IGroupRepository $groupRepository
	 */
	public function SetGroupRepository($groupRepository)
	{
		$this->groupRepository = $groupRepository;
	}

	/**
	 * @param \IGroupViewRepository $groupViewRepository
	 */
	public function SetGroupViewRepository($groupViewRepository)
	{
		$this->groupViewRepository = $groupViewRepository;
	}

	/**
	 * @param \IAttributeService $attributeService
	 */
	public function SetAttributeService($attributeService)
	{
		$this->attributeService = $attributeService;
	}

	/**
	 * @param \IManageUsersService $manageUsersService
	 */
	public function SetManageUsersService($manageUsersService)
	{
		$this->manageUsersService = $manageUsersService;
	}

	/**
	 * @param \ResourceRepository $resourceRepository
	 */
	public function SetResourceRepository($resourceRepository)
	{
		$this->resourceRepository = $resourceRepository;
	}

	/**
	 * @param \UserRepository $userRepository
	 */
	public function SetUserRepository($userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * @param IManageUsersPage $page
	 * @param UserRepository $userRepository
	 * @param IResourceRepository $resourceRepository
	 * @param PasswordEncryption $passwordEncryption
	 * @param IManageUsersService $manageUsersService
	 * @param IAttributeService $attributeService
	 * @param IGroupRepository $groupRepository
	 * @param IGroupViewRepository $groupViewRepository
	 */
	public function __construct(IManageUsersPage $page,
								UserRepository $userRepository,
								IResourceRepository $resourceRepository,
								PasswordEncryption $passwordEncryption,
								IManageUsersService $manageUsersService,
								IAttributeService $attributeService,
								IGroupRepository $groupRepository,
								IGroupViewRepository $groupViewRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->userRepository = $userRepository;
		$this->resourceRepository = $resourceRepository;
		$this->passwordEncryption = $passwordEncryption;
		$this->manageUsersService = $manageUsersService;
		$this->attributeService = $attributeService;
		$this->groupRepository = $groupRepository;
		$this->groupViewRepository = $groupViewRepository;

		$this->AddAction(ManageUsersActions::Activate, 'Activate');
		$this->AddAction(ManageUsersActions::AddUser, 'AddUser');
		$this->AddAction(ManageUsersActions::Deactivate, 'Deactivate');
		$this->AddAction(ManageUsersActions::DeleteUser, 'DeleteUser');
		$this->AddAction(ManageUsersActions::Password, 'ResetPassword');
		$this->AddAction(ManageUsersActions::Permissions, 'ChangePermissions');
		$this->AddAction(ManageUsersActions::UpdateUser, 'UpdateUser');
		$this->AddAction(ManageUsersActions::ChangeAttributes, 'ChangeAttributes');
		$this->AddAction(ManageUsersActions::ChangeColor, 'ChangeColor');
	}

	public function PageLoad()
	{
		if ($this->page->GetUserId() != null)
		{
			$userList = $this->userRepository->GetList(1, 1, null, null,
													   new SqlFilterEquals(ColumnNames::USER_ID, $this->page->GetUserId()));
		}
		else
		{
			$userList = $this->userRepository->GetList($this->page->GetPageNumber(), $this->page->GetPageSize(), null,
													   null, null, $this->page->GetFilterStatusId());
		}

		$this->page->BindUsers($userList->Results());
		$this->page->BindPageInfo($userList->PageInfo());

		$groups = $this->groupViewRepository->GetList();
		$this->page->BindGroups($groups->Results());

		$resources = array();

		$user = $this->userRepository->LoadById(ServiceLocator::GetServer()->GetUserSession()->UserId);

		$allResources = $this->resourceRepository->GetResourceList();
		foreach ($allResources as $resource)
		{
			if ($user->IsResourceAdminFor($resource))
			{
				$resources[] = $resource;
			}
		}
		$this->page->BindResources($resources);

		$userIds = array();
		/** @var $user UserItemView */
		foreach ($userList->Results() as $user)
		{
			$userIds[] = $user->Id;
		}
		$attributeList = $this->attributeService->GetAttributes(CustomAttributeCategory::USER, $userIds);
		$this->page->BindAttributeList($attributeList);
	}

	public function Deactivate()
	{
		$user = $this->userRepository->LoadById($this->page->GetUserId());
		$user->Deactivate();
		$this->userRepository->Update($user);
	}

	public function Activate()
	{
		$user = $this->userRepository->LoadById($this->page->GetUserId());
		$user->Activate();
		$this->userRepository->Update($user);
	}

	public function AddUser()
	{
		$userId = $this->manageUsersService->AddUser(
			$this->page->GetUserName(),
			$this->page->GetEmail(),
			$this->page->GetFirstName(),
			$this->page->GetLastName(),
			$this->page->GetPassword(),
			$this->page->GetTimezone(),
			Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE),
			Pages::DEFAULT_HOMEPAGE_ID,
			array(),
			$this->GetAttributeValues());

		$groupId = $this->page->GetUserGroup();

		if (!empty($groupId))
		{
			$group = $this->groupRepository->LoadById($groupId);
			$group->AddUser($userId);
			$this->groupRepository->Update($group);
		}
	}

	public function UpdateUser()
	{
		Log::Debug('Updating user %s', $this->page->GetUserId());

		$extraAttributes = array(
			UserAttribute::Organization => $this->page->GetOrganization(),
			UserAttribute::Phone => $this->page->GetPhone(),
			UserAttribute::Position => $this->page->GetPosition());

		$this->manageUsersService->UpdateUser($this->page->GetUserId(),
											  $this->page->GetUserName(),
											  $this->page->GetEmail(),
											  $this->page->GetFirstName(),
											  $this->page->GetLastName(),
											  $this->page->GetTimezone(),
											  $extraAttributes);
	}

	public function DeleteUser()
	{
		$userId = $this->page->GetUserId();
		Log::Debug('Deleting user %s', $userId);

		$this->manageUsersService->DeleteUser($userId);
	}

	public function ChangePermissions()
	{
		$user = $this->userRepository->LoadById($this->page->GetUserId());
		$allowedResources = array();

		if (is_array($this->page->GetAllowedResourceIds()))
		{
			$allowedResources = $this->page->GetAllowedResourceIds();
		}
		$user->ChangePermissions($allowedResources);
		$this->userRepository->Update($user);
	}

	public function ResetPassword()
	{
		$salt = $this->passwordEncryption->Salt();
		$encryptedPassword = $this->passwordEncryption->Encrypt($this->page->GetPassword(), $salt);

		$user = $this->userRepository->LoadById($this->page->GetUserId());
		$user->ChangePassword($encryptedPassword, $salt);
		$this->userRepository->Update($user);
	}

	public function ChangeAttributes()
	{
		$this->manageUsersService->ChangeAttributes($this->page->GetUserId(), $this->GetAttributeValues());
	}

	public function ProcessDataRequest($dataRequest)
	{
		if ($dataRequest == 'permissions')
		{
			$this->page->SetJsonResponse($this->GetUserResourcePermissions());
		}
		elseif ($dataRequest == 'groups')
		{
			$this->page->SetJsonResponse($this->GetUserGroups());
		}
		elseif ($dataRequest == 'all')
		{
			$users = $this->userRepository->GetAll();
			$this->page->SetJsonResponse($users);
		}
	}

	/**
	 * @return int[] all resource ids the user has permission to
	 */
	public function GetUserResourcePermissions()
	{
		$user = $this->userRepository->LoadById($this->page->GetUserId());
		return $user->AllowedResourceIds();
	}

	/**
	 * @return array|AttributeValue[]
	 */
	private function GetAttributeValues()
	{
		$attributes = array();
		foreach ($this->page->GetAttributes() as $attribute)
		{
			$attributes[] = new AttributeValue($attribute->Id, $attribute->Value);
		}
		return $attributes;
	}

	protected function LoadValidators($action)
	{
		if ($action == ManageUsersActions::UpdateUser)
		{
			Log::Debug('Loading validators for %s', $action);

			$this->page->RegisterValidator('emailformat', new EmailValidator($this->page->GetEmail()));
			$this->page->RegisterValidator('uniqueemail',
										   new UniqueEmailValidator($this->userRepository, $this->page->GetEmail(), $this->page->GetUserId()));
			$this->page->RegisterValidator('uniqueusername',
										   new UniqueUserNameValidator($this->userRepository, $this->page->GetUserName(), $this->page->GetUserId()));
		}

		if ($action == ManageUsersActions::AddUser)
		{
			Log::Debug('Loading validators for %s', $action);

			$this->page->RegisterValidator('addUserEmailformat', new EmailValidator($this->page->GetEmail()));
			$this->page->RegisterValidator('addUserUniqueemail',
										   new UniqueEmailValidator($this->userRepository, $this->page->GetEmail()));
			$this->page->RegisterValidator('addUserUsername',
										   new UniqueUserNameValidator($this->userRepository, $this->page->GetUserName()));
			$this->page->RegisterValidator('addAttributeValidator',
										   new AttributeValidator($this->attributeService, CustomAttributeCategory::USER, $this->GetAttributeValues()));
		}

		if ($action == ManageUsersActions::ChangeAttributes)
		{
			Log::Debug('Loading validators for %s', $action);

			$this->page->RegisterValidator('attributeValidator',
										   new AttributeValidator($this->attributeService, CustomAttributeCategory::USER, $this->GetAttributeValues(), $this->page->GetUserId()));
		}
	}

	/***
	 * @return array|int[]
	 */
	public function GetUserGroups()
	{
		$userId = $this->page->GetUserId();

		$user = $this->userRepository->LoadById($userId);

		$groups = array();
		foreach ($user->Groups() as $group)
		{
			$groups[] = $group->GroupId;
		}

		return $groups;
	}

	public function ChangeColor()
	{
		$userId = $this->page->GetUserId();
		Log::Debug('Changing reservation color for userId: %s', $userId);

		$color = $this->page->GetReservationColor();

		$user = $this->userRepository->LoadById($userId);
		$user->ChangePreference(UserPreferences::RESERVATION_COLOR, $color);

		$this->userRepository->Update($user);

	}
}

?>