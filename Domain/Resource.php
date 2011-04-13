<?php

interface IResource
{
	/**
	 * @return int
	 */
	public function GetResourceId();
	
	/**
	 * @return string
	 */
	public function GetName();
}

class Resource implements IResource
{
	private $_resourceId;
	private $_name;
	private $_location;
	private $_contact;
	private $_notes;
	private $_description;
	private $_minLength;
	private $_maxLength;
	private $_autoAssign;
	private $_requiresApproval;
	private $_allowMultiday;
	private $_maxParticipants;
	private $_minNotice;
	private $_maxNotice;
	private $_scheduleId;
	
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
	 * @param array[string] $row
	 * @return Resource
	 */
	public static function Create($row)
	{
		return new Resource($row[ColumnNames::RESOURCE_ID],
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
	}
	
	public function GetResourceId()
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
	
	public function GetMinLength()
	{
		return $this->_minLength;
	}
	
	public function SetMinLength($value)
	{
		$this->_minLength = $value;
	}
	
	public function HasMinLength()
	{
		return !empty($tihs->_minLength);
	}
	
	public function GetMaxLength()
	{
		return $this->_maxLength;
	}
	
	public function SetMaxLength($value)
	{
		$this->_maxLength = $value;
	}
	
	public function HasMaxLength()
	{
		return !empty($tihs->_maxLength);
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
	
	public function SetMaxParticipants($value)
	{
		$this->_maxParticipants = $value;
	}
	
	public function HasMaxParticipants()
	{
		return !empty($this->_maxParticipants);
	}
	
	public function GetMinNotice()
	{
		return $this->_minNotice;
	}
	
	public function SetMinNotice($value)
	{
		$this->_minNotice = $value;
	}
	
	public function HasMinNotice()
	{
		return !empty($this->_minNotice);
	}
	
	public function GetMaxNotice()
	{
		return $this->_maxNotice;
	}
	
	public function SetMaxNotice($value)
	{
		$this->_maxNotice = $value;
	}
	
	public function HasMaxNotice()
	{
		return !empty($this->_maxNotice);
	}
	
	public function GetScheduleId()
	{
		return $this->_scheduleId;
	}
	
	public function SetScheduleId($value)
	{
		$this->_scheduleId = $value;
	}
}
?>