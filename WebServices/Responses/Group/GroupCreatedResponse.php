<?php

class GroupCreatedResponse extends RestResponse
{
	public $groupId;

	public function __construct(IRestServer $server, $groupId)
	{
		$this->message = 'The group was created';
		$this->groupId = $groupId;
		$this->AddService($server, WebServices::GetGroup, array(WebServiceParams::GroupId => $groupId));
		$this->AddService($server, WebServices::UpdateGroup, array(WebServiceParams::GroupId => $groupId));
		$this->AddService($server, WebServices::DeleteGroup, array(WebServiceParams::GroupId => $groupId));
	}

	public static function Example()
	{
		return new ExampleCustomAttributeCreatedResponse();
	}
}

class GroupUpdatedResponse extends RestResponse
{
	public $groupId;

	public function __construct(IRestServer $server, $groupId)
	{
		$this->message = 'The group was updated';
		$this->groupId = $groupId;
        $this->AddService($server, WebServices::GetGroup, array(WebServiceParams::GroupId => $groupId));
        $this->AddService($server, WebServices::UpdateGroup, array(WebServiceParams::GroupId => $groupId));
        $this->AddService($server, WebServices::DeleteGroup, array(WebServiceParams::GroupId => $groupId));
	}

	public static function Example()
	{
		return new ExampleGroupCreatedResponse();
	}
}

class ExampleGroupCreatedResponse extends GroupCreatedResponse
{
	public function __construct()
	{
		$this->groupId = 1;
		$this->AddLink('http://url/to/group', WebServices::GetGroup);
		$this->AddLink('http://url/to/update/group', WebServices::UpdateGroup);
		$this->AddLink('http://url/to/delete/group', WebServices::DeleteGroup);
	}
}
