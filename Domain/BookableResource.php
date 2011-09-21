<?php

interface IResource
{
	/**
	 * alias of GetId()
	 * @return int
	 */
	public function GetResourceId();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetId();

	/**
	 * @return string
	 */
	public function GetName();
}

class BookableResource implements IResource
{
	protected $_resourceId;
	protected $_name;
	protected $_location;
	protected $_contact;
	protected $_notes;
	protected $_description;
	protected $_minLength;
	protected $_maxLength;
	protected $_autoAssign;
	protected $_requiresApproval;
	protected $_allowMultiday;
	protected $_maxParticipants;
	protected $_minNotice;
	protected $_maxNotice;
	protected $_scheduleId;
	protected $_imageName;
	protected $_isActive;
	
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
								$scheduleId = null)
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
	}

    /**
     * @param string $resourceName
     * @param int $scheduleId
     * @return BookableResource
     */
	public static function CreateNew($resourceName, $scheduleId)
	{
		return new BookableResource(null,
							$resourceName,
							null,
							null,
							null,
							null,
							null,
							null,
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
		
		$resource->_isActive = true;
		if (isset($row[ColumnNames::RESOURCE_ISACTIVE]))
		{
			$resource->_isActive = (bool)$row[ColumnNames::RESOURCE_ISACTIVE];
		}
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
		return new TimeInterval($this->_minLength);
	}
	
	/**
	 * @param string $value
	 */
	public function SetMinLength($value)
	{
		$this->_minLength = $value;
	}
	
	public function HasMinLength()
	{
		return !empty($this->_minLength);
	}
	
	/**
	 * @return TimeInterval
	 */
	public function GetMaxLength()
	{
		return new TimeInterval($this->_maxLength);
	}
	
	/**
	 * @param string $value
	 */
	public function SetMaxLength($value)
	{
		$this->_maxLength = $value;
	}
	
	public function HasMaxLength()
	{
		return !empty($this->_maxLength);
	}
	
	public function GetAutoAssign()
	{
		return $this->_autoAssign;
	}
	
	public function SetAutoAssign($value)
	{
		$this->_autoAssign = $value;
	}
	
	public function GetRequiresApproval()
	{
		return $this->_requiresApproval;
	}
	
	public function SetRequiresApproval($value)
	{
		$this->_requiresApproval = $value;
	}
	
	public function GetAllowMultiday()
	{
		return $this->_allowMultiday;
	}
	
	public function SetAllowMultiday($value)
	{
		$this->_allowMultiday = $value;
	}
	
	public function GetMaxParticipants()
	{
		return $this->_maxParticipants;
	}
	
	/**
	 * @param string $value
	 */
	public function SetMaxParticipants($value)
	{
		$this->_maxParticipants = $value;
		if (empty($value))
		{
			$this->_maxParticipants = null;
		}
	}
	
	public function HasMaxParticipants()
	{
		return !empty($this->_maxParticipants);
	}
	
	/**
	 * @return TimeInterval
	 */
	public function GetMinNotice()
	{
		return new TimeInterval($this->_minNotice);
	}
	
	/**
	 * @param string $value
	 */
	public function SetMinNotice($value)
	{
		$this->_minNotice = $value;
	}
	
	public function HasMinNotice()
	{
		return !empty($this->_minNotice);
	}
	
	/**
	 * @return TimeInterval
	 */
	public function GetMaxNotice()
	{
		return new TimeInterval($this->_maxNotice);
	}
	
	/**
	 * @param string $value
	 */
	public function SetMaxNotice($value)
	{
		$this->_maxNotice = $value;
	}
	
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
	
	public function SetScheduleId($value)
	{
		$this->_scheduleId = $value;
	}
	
	public function GetImage()
	{
		return $this->_imageName;
	}

	public function SetImage($value)
	{
		$this->_imageName = $value;
	}
	
	public function HasImage()
	{
		return !empty($this->_imageName);
	}
	
	public function IsOnline()
	{
		return $this->_isActive;
	}
	
	public function TakeOffline()
	{
		$this->_isActive = false;
	}
	
	public function BringOnline()
	{
		$this->_isActive = true;
	}

	public function __toString()
	{
		return 'BookableResource' . $this->_resourceId;
	}
}
?>