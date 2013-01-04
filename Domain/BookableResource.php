<?php
/**
Copyright 2011-2013 Nick Korbel

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

interface IResource extends IPermissibleResource
{
	/**
	 * @return int
	 */
	public function GetId();

	/**
	 * @return string
	 */
	public function GetName();

	/**
	 * @return int
	 */
	public function GetAdminGroupId();

	/**
	 * @return int
	 */
	public function GetScheduleId();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetScheduleAdminGroupId();
}

interface IPermissibleResource
{
	/**
	 * @abstract
	 * @return int
	 */
	public function GetResourceId();
}

class BookableResource implements IResource
{
	protected $_resourceId;
	protected $_name;
	protected $_location;
	protected $_contact;
	protected $_notes;
	protected $_description;
	/**
	 * @var string|int
	 */
	protected $_minLength;
	/**
	 * @var string|int
	 */
	protected $_maxLength;
	protected $_autoAssign;
	protected $_requiresApproval;
	protected $_allowMultiday;
	protected $_maxParticipants;
	/**
	 * @var string|int
	 */
	protected $_minNotice;
	/**
	 * @var string|int
	 */
	protected $_maxNotice;
	protected $_scheduleId;
	protected $_imageName;
	protected $_isActive;
	protected $_adminGroupId;
	protected $_isCalendarSubscriptionAllowed = false;
	protected $_publicId;
	protected $_scheduleAdminGroupId;
	protected $_sortOrder;
	/**
	 * @var array|AttributeValue[]
	 */
	protected $_attributeValues = array();

	public function __construct($resourceId,
								$name,
								$location,
								$contact,
								$notes,
								$minLength,
								$maxLength,
								$autoAssign,
								$requiresApproval,
								$allowMultiday,
								$maxParticipants,
								$minNotice,
								$maxNotice,
								$description = null,
								$scheduleId = null,
								$adminGroupId = null
	)
	{
		$this->SetResourceId($resourceId);
		$this->SetName($name);
		$this->SetLocation($location);
		$this->SetContact($contact);
		$this->SetNotes($notes);
		$this->SetDescription($description);
		$this->SetMinLength($minLength);
		$this->SetMaxLength($maxLength);
		$this->SetAutoAssign($autoAssign);
		$this->SetRequiresApproval($requiresApproval);
		$this->SetAllowMultiday($allowMultiday);
		$this->SetMaxParticipants($maxParticipants);
		$this->SetMinNotice($minNotice);
		$this->SetMaxNotice($maxNotice);
		$this->SetScheduleId($scheduleId);
		$this->SetAdminGroupId($adminGroupId);
	}

	/**
	 * @param string $resourceName
	 * @param int $scheduleId
	 * @param bool $autoAssign
	 * @param int $order
	 * @return BookableResource
	 */
	public static function CreateNew($resourceName, $scheduleId, $autoAssign = false, $order = 0)
	{
		return new BookableResource(null,
			$resourceName,
			null,
			null,
			null,
			null,
			null,
			$autoAssign,
			null,
			null,
			null,
			null,
			null,
			null,
			$scheduleId);
	}

	/**
	 * @param array $row
	 * @return BookableResource
	 */
	public static function Create($row)
	{
		$resource = new BookableResource($row[ColumnNames::RESOURCE_ID],
			$row[ColumnNames::RESOURCE_NAME],
			$row[ColumnNames::RESOURCE_LOCATION],
			$row[ColumnNames::RESOURCE_CONTACT],
			$row[ColumnNames::RESOURCE_NOTES],
			$row[ColumnNames::RESOURCE_MINDURATION],
			$row[ColumnNames::RESOURCE_MAXDURATION],
			$row[ColumnNames::RESOURCE_AUTOASSIGN],
			$row[ColumnNames::RESOURCE_REQUIRES_APPROVAL],
			$row[ColumnNames::RESOURCE_ALLOW_MULTIDAY],
			$row[ColumnNames::RESOURCE_MAX_PARTICIPANTS],
			$row[ColumnNames::RESOURCE_MINNOTICE],
			$row[ColumnNames::RESOURCE_MAXNOTICE],
			$row[ColumnNames::RESOURCE_DESCRIPTION],
			$row[ColumnNames::SCHEDULE_ID]);

		$resource->SetImage($row[ColumnNames::RESOURCE_IMAGE_NAME]);
		$resource->SetAdminGroupId($row[ColumnNames::RESOURCE_ADMIN_GROUP_ID]);
		$resource->SetSortOrder($row[ColumnNames::RESOURCE_SORT_ORDER]);

		$resource->_isActive = true;
		if (isset($row[ColumnNames::RESOURCE_ISACTIVE]))
		{
			$resource->_isActive = (bool)$row[ColumnNames::RESOURCE_ISACTIVE];
		}

		$resource->WithPublicId($row[ColumnNames::PUBLIC_ID]);
		$resource->WithSubscription($row[ColumnNames::ALLOW_CALENDAR_SUBSCRIPTION]);
		$resource->WithScheduleAdminGroupId($row[ColumnNames::SCHEDULE_ADMIN_GROUP_ID_ALIAS]);

		return $resource;
	}

	public function GetResourceId()
	{
		return $this->_resourceId;
	}

	public function GetId()
	{
		return $this->_resourceId;
	}

	public function SetResourceId($value)
	{
		$this->_resourceId = $value;
	}

	public function GetName()
	{
		return $this->_name;
	}

	public function SetName($value)
	{
		$this->_name = $value;
	}

	public function GetLocation()
	{
		return $this->_location;
	}

	public function SetLocation($value)
	{
		$this->_location = $value;
	}

	public function HasLocation()
	{
		return !empty($this->_location);
	}

	public function GetContact()
	{
		return $this->_contact;
	}

	public function SetContact($value)
	{
		$this->_contact = $value;
	}

	public function HasContact()
	{
		return !empty($this->_contact);
	}

	public function GetNotes()
	{
		return $this->_notes;
	}

	public function SetNotes($value)
	{
		$this->_notes = $value;
	}

	public function HasNotes()
	{
		return !empty($this->_notes);
	}

	public function GetDescription()
	{
		return $this->_description;
	}

	public function SetDescription($value)
	{
		$this->_description = $value;
	}

	public function HasDescription()
	{
		return !empty($this->_description);
	}

	/**
	 * @return TimeInterval
	 */
	public function GetMinLength()
	{
		return TimeInterval::Parse($this->_minLength);
	}

	/**
	 * @param string|int $value
	 */
	public function SetMinLength($value)
	{
		$this->_minLength = $value;
	}

	/**
	 * @return bool
	 */
	public function HasMinLength()
	{
		return !empty($this->_minLength);
	}

	/**
	 * @return TimeInterval
	 */
	public function GetMaxLength()
	{
		return TimeInterval::Parse($this->_maxLength);
	}

	/**
	 * @param string|int $value
	 */
	public function SetMaxLength($value)
	{
		$this->_maxLength = $value;
	}

	/**
	 * @return bool
	 */
	public function HasMaxLength()
	{
		return !empty($this->_maxLength);
	}

	/**
	 * @return bool
	 */
	public function GetAutoAssign()
	{
		return $this->_autoAssign;
	}

	/**
	 * @param bool $value
	 * @return void
	 */
	public function SetAutoAssign($value)
	{
		$this->_autoAssign = $value;
	}

	/**
	 * @return bool
	 */
	public function GetRequiresApproval()
	{
		return $this->_requiresApproval;
	}

	/**
	 * @param bool $value
	 * @return void
	 */
	public function SetRequiresApproval($value)
	{
		$this->_requiresApproval = $value;
	}

	/**
	 * @return bool
	 */
	public function GetAllowMultiday()
	{
		return $this->_allowMultiday;
	}

	/**
	 * @param bool $value
	 * @return void
	 */
	public function SetAllowMultiday($value)
	{
		$this->_allowMultiday = $value;
	}

	/**
	 * @return int
	 */
	public function GetMaxParticipants()
	{
		return $this->_maxParticipants;
	}

	/**
	 * @param int $value
	 */
	public function SetMaxParticipants($value)
	{
		$this->_maxParticipants = $value;
		if (empty($value))
		{
			$this->_maxParticipants = null;
		}
	}

	/**
	 * @return bool
	 */
	public function HasMaxParticipants()
	{
		return !empty($this->_maxParticipants);
	}

	/**
	 * @return TimeInterval
	 */
	public function GetMinNotice()
	{
		return TimeInterval::Parse($this->_minNotice);
	}

	/**
	 * @param string|int $value
	 */
	public function SetMinNotice($value)
	{
		$this->_minNotice = $value;
	}

	/**
	 * @return bool
	 */
	public function HasMinNotice()
	{
		return !empty($this->_minNotice);
	}

	/**
	 * @return TimeInterval
	 */
	public function GetMaxNotice()
	{
		return TimeInterval::Parse($this->_maxNotice);
	}

	/**
	 * @param string|int $value
	 */
	public function SetMaxNotice($value)
	{
		$this->_maxNotice = $value;
	}

	/**
	 * @return bool
	 */
	public function HasMaxNotice()
	{
		return !empty($this->_maxNotice);
	}

	/**
	 * @return int
	 */
	public function GetScheduleId()
	{
		return $this->_scheduleId;
	}

	/**
	 * @param int $value
	 * @return void
	 */
	public function SetScheduleId($value)
	{
		$this->_scheduleId = $value;
	}

	/**
	 * @return int
	 */
	public function GetAdminGroupId()
	{
		return $this->_adminGroupId;
	}

	/**
	 * @param int $adminGroupId
	 */
	public function SetAdminGroupId($adminGroupId)
	{
		$this->_adminGroupId = $adminGroupId;
		if (empty($adminGroupId))
		{
			$this->_adminGroupId = null;
		}
	}

	/**
	 * @return bool
	 */
	public function HasAdminGroup()
	{
		return !empty($this->_adminGroupId);
	}

	/**
	 * @return string
	 */
	public function GetImage()
	{
		return $this->_imageName;
	}

	/**
	 * @param string $value
	 * @return void
	 */
	public function SetImage($value)
	{
		$this->_imageName = $value;
	}

	/**
	 * @return bool
	 */
	public function HasImage()
	{
		return !empty($this->_imageName);
	}

	/**
	 * @return bool
	 */
	public function IsOnline()
	{
		return $this->_isActive;
	}

	/**
	 * @return void
	 */
	public function TakeOffline()
	{
		$this->_isActive = false;
	}

	public function BringOnline()
	{
		$this->_isActive = true;
	}

	/**
	 * @param bool $isAllowed
	 */
	protected function SetIsCalendarSubscriptionAllowed($isAllowed)
	{
		$this->_isCalendarSubscriptionAllowed = $isAllowed;
	}

	/**
	 * @return bool
	 */
	public function GetIsCalendarSubscriptionAllowed()
	{
		return $this->_isCalendarSubscriptionAllowed;
	}

	/**
	 * @param string $publicId
	 */
	protected function SetPublicId($publicId)
	{
		$this->_publicId = $publicId;
	}

	/**
	 * @return string
	 */
	public function GetPublicId()
	{
		return $this->_publicId;
	}

	public function EnableSubscription()
	{
		$this->SetIsCalendarSubscriptionAllowed(true);
		if (empty($this->_publicId))
		{
			$this->SetPublicId(uniqid());
		}
	}

	public function DisableSubscription()
	{
		$this->SetIsCalendarSubscriptionAllowed(false);
	}

	public function WithAttribute(AttributeValue $attribute)
	{
		$this->_attributeValues[$attribute->AttributeId] = $attribute;
	}

	/**
	 * @var array|AttributeValue[]
	 */
	private $_addedAttributeValues = array();

	/**
	 * @var array|AttributeValue[]
	 */
	private $_removedAttributeValues = array();

	/**
	 * @param $attributes AttributeValue[]|array
	 */
	public function ChangeAttributes($attributes)
	{
		$diff = new ArrayDiff($this->_attributeValues, $attributes);

		$added = $diff->GetAddedToArray1();
		$removed = $diff->GetRemovedFromArray1();

		/** @var $attribute AttributeValue */
		foreach ($added as $attribute)
		{
			$this->_addedAttributeValues[] = $attribute;
		}

		/** @var $accessory AttributeValue */
		foreach ($removed as $attribute)
		{
			$this->_removedAttributeValues[] = $attribute;
		}

		foreach ($attributes as $attribute)
		{
			$this->AddAttributeValue($attribute);
		}
	}

	/**
	 * @param $attributeValue AttributeValue
	 */
	public function AddAttributeValue($attributeValue)
	{
		$this->_attributeValues[$attributeValue->AttributeId] = $attributeValue;
	}

	/**
	 * @return array|AttributeValue[]
	 */
	public function GetAddedAttributes()
	{
		return $this->_addedAttributeValues;
	}

	/**
	 * @return array|AttributeValue[]
	 */
	public function GetRemovedAttributes()
	{
		return $this->_removedAttributeValues;
	}

	/**
	 * @param $customAttributeId
	 * @return mixed
	 */
	public function GetAttributeValue($customAttributeId)
	{
		if (array_key_exists($customAttributeId, $this->_attributeValues))
		{
			return $this->_attributeValues[$customAttributeId]->Value;
		}

		return null;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return 'BookableResource' . $this->_resourceId;
	}

	/**
	 * @static
	 * @return BookableResource
	 */
	public static function Null()
	{
		return new BookableResource(null, null, null, null, null, null, null, false, false, false, null, null, null);
	}

	protected function WithPublicId($publicId)
	{
		$this->SetPublicId($publicId);
	}

	protected function WithSubscription($isAllowed)
	{
		$this->SetIsCalendarSubscriptionAllowed($isAllowed);
	}

	/**
	 * @param $scheduleAdminGroupId int
	 */
	protected function WithScheduleAdminGroupId($scheduleAdminGroupId)
	{
		$this->_scheduleAdminGroupId = $scheduleAdminGroupId;
	}

	/**
	 * @return int
	 */
	public function GetScheduleAdminGroupId()
	{
		return $this->_scheduleAdminGroupId;
	}

	/**
	 * @param int $sortOrder
	 */
	public function SetSortOrder($sortOrder)
	{
		$this->_sortOrder = intval($sortOrder);
	}

	/**
	 * @return int
	 */
	public function GetSortOrder()
	{
		return $this->_sortOrder;
	}
}

?>