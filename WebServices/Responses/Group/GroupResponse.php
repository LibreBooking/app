<?php

class GroupResponse extends RestResponse
{
	public $id;
	public $name;
	public $adminGroup;
	public $permissions = array();
    public $viewPermissions = array();
	public $users = array();
	public $roles = array();
	public $isDefault = false;

	public function __construct(IRestServer $server, Group $group)
	{
		$this->id = $group->Id();
		$this->name = $group->Name();
		$adminId =  $group->AdminGroupId();
		if (!empty($adminId)) {
            $this->adminGroup = $server->GetServiceUrl(WebServices::GetGroup, array(WebServiceParams::GroupId => $group->AdminGroupId()));
        }

		foreach ($group->AllowedResourceIds() as $resourceId)
		{
			$this->permissions[] = $server->GetServiceUrl(WebServices::GetResource, array(WebServiceParams::ResourceId => $resourceId));
		}

        foreach ($group->AllowedViewResourceIds() as $resourceId)
        {
            $this->viewPermissions[] = $server->GetServiceUrl(WebServices::GetResource, array(WebServiceParams::ResourceId => $resourceId));
        }

		foreach ($group->UserIds() as $userId)
		{
			$this->users[] = $server->GetServiceUrl(WebServices::GetUser, array(WebServiceParams::UserId => $userId));
		}

		foreach ($group->RoleIds() as $roleId)
		{
			$this->roles[] = $roleId;
		}

		$this->isDefault = (bool)$group->IsDefault();
	}

	public static function Example()
	{
		return new ExampleGroupResponse();
	}
}

class ExampleGroupResponse extends GroupResponse
{
	public function __construct()
	{
		$this->id = 123;
		$this->name = 'group name';
		$this->adminGroup = 'http://url/to/group';
		$this->permissions = array('http://url/to/resource');
        $this->viewPermissions = array('http://url/to/resource');
		$this->users = array('http://url/to/user');
		$this->roles = array(1,2);
		$this->isDefault = true;
	}
}

