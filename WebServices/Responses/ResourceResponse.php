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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ResourceResponse extends RestResponse
{
	public $resourceId;
	public $name;
	public $location;
	public $contact;
	public $notes;
	public $minLength;
	public $maxLength;
	public $requiresApproval;
	public $allowMultiday;
	public $maxParticipants;
	public $minNotice;
	public $maxNotice;
	public $description;
	public $scheduleId;
	public $icsUrl;
	public $customAttributes = array();

	/**
	 * @param IRestServer $server
	 * @param BookableResource $resource
	 * @param IEntityAttributeList $attributes
	 */
	public function __construct(IRestServer $server, $resource, $attributes)
	{
		$resourceId = $resource->GetId();
		$this->resourceId = $resourceId;
		$this->name = $resource->GetName();
		$this->location = $resource->GetLocation();
		$this->contact = $resource->GetContact();
		$this->notes = $resource->GetNotes();
		$this->maxLength = $resource->GetMaxLength()->__toString();
		$this->minLength = $resource->GetMinLength()->__toString();
		$this->maxNotice = $resource->GetMaxNotice()->__toString();
		$this->minNotice = $resource->GetMinNotice()->__toString();
		$this->requiresApproval = $resource->GetRequiresApproval();
		$this->allowMultiday = $resource->GetAllowMultiday();
		$this->maxParticipants = $resource->GetMaxParticipants();
		$this->description = $resource->GetDescription();
		$this->scheduleId = $resource->GetScheduleId();

		$definitions = $attributes->GetDefinitions();
		$values = $attributes->GetValues($resourceId);

		$i=0;
		foreach($definitions as $definition)
		{
			$this->customAttributes[] = new CustomAttributeResponse($server, $definition->Id(), $definition->Label(), $values[$i]);
			$i++;
		}

		if ($resource->GetIsCalendarSubscriptionAllowed())
		{
			$url = new CalendarSubscriptionUrl(null, null, $resource->GetPublicId());
			$this->icsUrl = $url->__toString();
		}
		$this->AddService($server, WebServices::GetResource, array(WebServiceParams::ResourceId => $resourceId));
	}


	public static function Example()
	{
		return new ExampleResourceResponse();
	}
}

class ExampleResourceResponse extends ResourceResponse
{
	public function __construct()
	{
		$interval = new TimeInterval(120);
		$length = $interval->__toString();
		$this->resourceId = 123;
		$this->name = 'resource name';
		$this->location = 'location';
		$this->contact = 'contact';
		$this->notes = 'notes';
		$this->maxLength = $length;
		$this->minLength = $length;
		$this->maxNotice = $length;
		$this->minNotice = $length;
		$this->requiresApproval = true;
		$this->allowMultiday = true;
		$this->maxParticipants = 10;
		$this->description = 'resource description';
		$this->scheduleId = 123;

		$this->customAttributes = array(CustomAttributeResponse::Example());

	}
}

?>