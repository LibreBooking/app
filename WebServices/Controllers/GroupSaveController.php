<?php

/**
 * Copyright 2018 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Presenters/Admin/ManageGroupsPresenter.php');

interface IGroupSaveController
{
	/**
	 * @param GroupRequest $request
	 * @param WebServiceUserSession $session
	 * @return GroupControllerResult
	 */
	public function Create($request, $session);

	/**
	 * @param int $groupId
	 * @param GroupRequest $request
	 * @param WebServiceUserSession $session
	 * @return GroupControllerResult
	 */
	public function Update($groupId, $request, $session);

	/**
	 * @param int $groupId
	 * @param WebServiceUserSession $session
	 * @return GroupControllerResult
	 */
	public function Delete($groupId, $session);
}

class GroupControllerResult
{
	private $groupId;
	private $errors = array();

	public function __construct($groupId, $errors = array())
	{
		$this->groupId = $groupId;
		$this->errors = $errors;
	}

	/**
	 * @return bool
	 */
	public function WasSuccessful()
	{
		return !empty($this->groupId) && empty($this->errors);
	}

	/**
	 * @return int
	 */
	public function GroupId()
	{
		return $this->groupId;
	}

	/**
	 * @return string[]
	 */
	public function Errors()
	{
		return $this->errors;
	}
}

class GroupSaveController implements IGroupSaveController
{
	/**
	 * @var GroupRepository
	 */
	private $groupRepository;

    /**
     * @var ResourceRepository
     */
    private $resourceRepository;

    public function __construct(GroupRepository $groupRepository, ResourceRepository $resourceRepository)
	{
		$this->groupRepository = $groupRepository;
		$this->resourceRepository = $resourceRepository;
	}

	/**
	 * @param GroupRequest $request
	 * @param WebServiceUserSession $session
	 * @return GroupControllerResult
	 */
	public function Create($request, $session)
	{
        $errors = $this->ValidateRequest($request);

		if (!empty($errors))
		{
			return new GroupControllerResult(null, $errors);
		}

        $presenter = $this->GetPresenter(new CreateGroupFacade($request));

        $id = $presenter->AddGroup();

		return new GroupControllerResult($id, null);
	}

	/**
	 * @param int $groupId
	 * @param GroupRequest $request
	 * @param WebServiceUserSession $session
	 * @return GroupControllerResult
	 */
	public function Update($groupId, $request, $session)
	{
        $errors = $this->ValidateRequest($request);

        if (!empty($errors))
        {
            return new GroupControllerResult(null, $errors);
        }

        $presenter = $this->GetPresenter(new CreateGroupFacade($request, $groupId));

        $id = $presenter->AddGroup();

        return new GroupControllerResult($id, null);
	}

	/**
	 * @param int $groupId
	 * @param WebServiceUserSession $session
	 * @return GroupControllerResult
	 */
	public function Delete($groupId, $session)
	{
		$errors = empty($groupId) ? array('groupId is required') : array();
		if (!empty($errors))
		{
			return new GroupControllerResult(null, $errors);
		}

        $presenter = $this->GetPresenter(new CreateGroupFacade(null, $groupId));
        $presenter->DeleteGroup();

		return new GroupControllerResult($groupId);
	}

	/**
	 * @param GroupRequest $request
	 * @return array|string[]
	 */
	private function ValidateRequest($request)
	{
		$errors = array();

		if (empty($request->name))
		{
			$errors[] = 'name is required';
		}

		return $errors;
	}

    private function GetPresenter($page)
    {
        return new ManageGroupsPresenter($page, $this->groupRepository, $this->resourceRepository);
    }
}

abstract class GroupControllerPageFacade implements IManageGroupsPage
{
    public function TakingAction()
    {}

    public function GetAction()
    {}

    public function RequestingData()
    {}

    public function GetDataRequest()
    {}

    public function PageLoad()
    {}

    public function Redirect($url)
    {}

    public function RedirectToError($errorMessageId = ErrorMessages::UNKNOWN_ERROR, $lastPage = '')
    {}

    public function IsPostBack()
    {}

    public function IsValid()
    {}

    public function GetLastPage($defaultPage = '')
    {}

    public function RegisterValidator($validatorId, $validator)
    {}

    public function EnforceCSRFCheck()
    {}

    public function GetSortField()
    {}

    public function GetSortDirection()
    {}

    public function GetGroupId()
    {}

    public function BindGroups($groups)
    {}

    public function BindPageInfo(PageInfo $pageInfo)
    {}

    public function GetPageNumber()
    {}

    public function GetPageSize()
    {}

    public function SetJsonResponse($response)
    {}

    public function GetUserId()
    {}

    public function BindResources($resources)
    {}

    public function BindRoles($roles)
    {}

    public function GetAllowedResourceIds()
    {}

    public function GetGroupName()
    {}

    public function GetRoleIds()
    {}

    public function BindAdminGroups($adminGroups)
    {}

    public function GetAdminGroupId()
    {}

    public function AutomaticallyAddToGroup()
    {}
}

class CreateGroupFacade extends GroupControllerPageFacade
{
    /**
     * @var GroupRequest
     */
    private $request;
    private $id;

    /**
     * @param GroupRequest $request
     * @param int|null $id
     */
    public function __construct($request, $id = null)
    {
        $this->request = $request;
        $this->id = $id;
    }

    public function GetGroupId()
    {
        return $this->id;
    }

    public function GetGroupName()
    {
        return $this->request->name;
    }

    public function AutomaticallyAddToGroup()
    {
        return $this->request->isDefault;
    }
}
