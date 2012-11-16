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
	public $customAttributes = array();

	public function __construct()
	{
	}

	/**
	 * @param IRestServer $server
	 * @param BookableResource $resource
	 * @param IEntityAttributeList $attributes
	 * @return ResourceResponse
	 */
	public static function Create($server = null, $resource = null, $attributes = null)
	{
		$resourceId = $resource->GetId();
		$r = new ResourceResponse();
		$r->resourceId = $resourceId;
		$r->name = $resource->GetName();
		$r->location = $resource->GetLocation();
		$r->contact = $resource->GetContact();
		$r->notes = $resource->GetNotes();
		$r->maxLength = $resource->GetMaxLength();
		$r->minLength = $resource->GetMinLength();
		$r->maxNotice = $resource->GetMaxNotice();
		$r->minNotice = $resource->GetMinNotice();
		$r->requiresApproval = $resource->GetRequiresApproval();
		$r->allowMultiday = $resource->GetAllowMultiday();
		$r->maxParticipants = $resource->GetMaxParticipants();
		$r->description = $resource->GetDescription();
		$r->scheduleId = $resource->GetScheduleId();

		$definitions = $attributes->GetDefinitions();
		$values = $attributes->GetValues($resourceId);

		for ($i = 0; $i < count($definitions); $i++)
		{
			$r->customAttributes[] = new CustomAttributeResponse($definitions[$i]->Id(), $definitions[$i]->Label(), $values[$i]);
		}

		$r->AddService($server, WebServices::GetResource, array(WebServiceParams::ResourceId => $resourceId));

		return $r;
	}
}

?>