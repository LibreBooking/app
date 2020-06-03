<?php
/**
Copyright 2012-2020 Nick Korbel

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
	public $minNoticeAdd;
	public $minNoticeUpdate;
	public $minNoticeDelete;
	public $maxNotice;
	public $description;
	public $scheduleId;
	public $icsUrl;
	public $statusId;
	public $statusReasonId;
	public $customAttributes = array();
	public $typeId;
	public $groupIds;
    public $bufferTime;
    public $autoReleaseMinutes;
    public $requiresCheckIn;
    public $color;
    public $creditsPerSlot;
    public $peakCreditsPerSlot;
    public $maxConcurrentReservations;

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
		$this->minNoticeAdd = $resource->GetMinNoticeAdd()->__toString();
		$this->minNoticeUpdate = $resource->GetMinNoticeUpdate()->__toString();
		$this->minNoticeDelete = $resource->GetMinNoticeDelete()->__toString();
		$this->requiresApproval = $resource->GetRequiresApproval();
		$this->allowMultiday = $resource->GetAllowMultiday();
		$this->maxParticipants = $resource->GetMaxParticipants();
		$this->description = $resource->GetDescription();
		$this->scheduleId = $resource->GetScheduleId();
		$this->statusId = $resource->GetStatusId();
		$this->statusReasonId = $resource->GetStatusReasonId();
		$this->bufferTime = $resource->GetBufferTime()->__toString();
		$this->typeId = $resource->GetResourceTypeId();
        $this->groupIds = $resource->GetResourceGroupIds();
        $this->autoReleaseMinutes = $resource->GetAutoReleaseMinutes();
        $this->requiresCheckIn = $resource->IsCheckInEnabled();
        $this->color = $resource->GetColor();
        $this->creditsPerSlot = $resource->GetCreditsPerSlot();
        $this->peakCreditsPerSlot = $resource->GetPeakCreditsPerSlot();
        $this->maxConcurrentReservations = $resource->GetMaxConcurrentReservations();

		$attributeValues = $attributes->GetAttributes($resourceId);

		$i=0;
		foreach($attributeValues as $av)
		{
			$this->customAttributes[] = new CustomAttributeResponse($server, $av->Id(), $av->Label(), $av->Value());
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
		$this->minNoticeAdd= $length;
		$this->minNoticeUpdate = $length;
		$this->minNoticeDelete = $length;
		$this->requiresApproval = true;
		$this->allowMultiday = true;
		$this->maxParticipants = 10;
		$this->description = 'resource description';
		$this->scheduleId = 123;
		$this->statusId = ResourceStatus::AVAILABLE;
		$this->statusReasonId = 3;
		$this->typeId = 2;
        $this->bufferTime = '1 hours 30 minutes';
        $this->autoReleaseMinutes = 15;
        $this->requiresCheckIn = true;
        $this->color = '#ffffff';
        $this->creditsPerSlot = 3;
        $this->peakCreditsPerSlot = 6;
        $this->maxConcurrentReservations = 1;

		$this->customAttributes = array(CustomAttributeResponse::Example());
	}
}