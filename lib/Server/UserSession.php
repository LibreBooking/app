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

class UserSession
{
	public $UserId = '';
	public $FirstName = '';
	public $LastName = '';
	public $Email = '';
	public $Timezone = '';
	public $HomepageId = 1;
	public $IsAdmin = false;
	public $IsGroupAdmin = false;
	public $IsResourceAdmin = false;
	public $IsScheduleAdmin = false;
	public $LanguageCode = '';
	public $PublicId = '';
	public $LoginTime = '';
	public $ScheduleId = '';
	public $Groups = array();

	private $FilterStartDateDelta;
	private $FilterEndDateDelta;
	private $FilterUserId;
	private $FilterScheduleId;
	private $FilterResourceId;
	private $FilterReservationStatusId;
	private $FilterReferenceNumber;

	public function __construct($id)
	{
		$this->UserId = $id;
		$this->RetrieveFilterValues();
	}
	
	public function IsLoggedIn()
	{
		return true;
	}

	public function GetFilterStartDateDelta()
	{
		return $this->FilterStartDateDelta;
	}

	public function GetFilterEndDateDelta()
	{
		return $this->FilterEndDateDelta;
	}

	public function GetFilterUserId()
	{
		return $this->FilterUserId;
	}

	public function GetFilterScheduleId()
	{
		return $this->FilterScheduleId;
	}

	public function GetFilterResourceId()
	{
		return $this->FilterResourceId;
	}

	public function GetFilterReservationStatusId()
	{
		return $this->FilterReservationStatusId;
	}

	public function GetFilterReferenceNumber()
	{
		return $this->FilterReferenceNumber;
	}

	public function SetFilterStartDateDelta($FilterStartDateDelta)
	{
		if($this->FilterStartDateDelta!=$FilterStartDateDelta)
			$this->StoreFilterValue('FilterStartDateDelta', $FilterStartDateDelta);

		$this->FilterStartDateDelta = $FilterStartDateDelta;
	}

	public function SetFilterEndDateDelta($FilterEndDateDelta)
	{
		if($this->FilterEndDateDelta!=$FilterEndDateDelta)
			$this->StoreFilterValue('FilterEndDateDelta', $FilterEndDateDelta);

		$this->FilterEndDateDelta = $FilterEndDateDelta;
	}

	public function SetFilterUserId($FilterUserId)
	{
		if($FilterUserId)
			$FilterUserId = '0';

		if($this->FilterUserId!=$FilterUserId)
			$this->StoreFilterValue('FilterUserId', $FilterUserId);

		$this->FilterUserId = $FilterUserId;
	}

	public function SetFilterScheduleId($FilterScheduleId)
	{
		if(!$FilterScheduleId)
			$FilterScheduleId = '0';

		if($this->FilterScheduleId!=$FilterScheduleId)
			$this->StoreFilterValue('FilterScheduleId', $FilterScheduleId);

		$this->FilterScheduleId = $FilterScheduleId;
	}

	public function SetFilterResourceId($FilterResourceId)
	{
		if(!$FilterResourceId)
			$FilterResourceId = '0';

		if($this->FilterResourceId!=$FilterResourceId)
			$this->StoreFilterValue('FilterResourceId', $FilterResourceId);

		$this->FilterResourceId = $FilterResourceId;
	}

	public function SetFilterReservationStatusId($FilterReservationStatusId)
	{
		if(!$FilterReservationStatusId)
			$FilterReservationStatusId = '0';

		if($this->FilterReservationStatusId!=$FilterReservationStatusId)
			$this->StoreFilterValue('FilterReservationStatusId', $FilterReservationStatusId);

		$this->FilterReservationStatusId = $FilterReservationStatusId;
	}

	public function SetFilterReferenceNumber($FilterReferenceNumber)
	{
		if(!$FilterReferenceNumber)
			$FilterReferenceNumber = '0';

		if($this->FilterReferenceNumber!=$FilterReferenceNumber)
			$this->StoreFilterValue('FilterReferenceNumber', $FilterReferenceNumber);

		$this->FilterReferenceNumber = $FilterReferenceNumber;
	}

	private function RetrieveFilterValues()
	{
		static $FilterKeys = array(array('name'=>'FilterStartDateDelta'		,'default'=>-7),
								   array('name'=>'FilterEndDateDelta'		,'default'=>+7),
								   array('name'=>'FilterUserId'				,'default'=>''),
								   array('name'=>'FilterScheduelId'			,'default'=>''),
								   array('name'=>'FilterResourceId'			,'default'=>''),
								   array('name'=>'FilterReservationStatusId','default'=> 0),
								   array('name'=>'FilterReferenceNumber'	,'default'=>''),
								  );

		foreach($FilterKeys as $filter)
			$this->$filter['name'] = $filter['default'];

        // TBD: Abstract out db access to Domain/Access/UserRepository.php
		$reader = ServiceLocator::GetDatabase()->Query(new GetUserPreferencesCommand($this->UserId));
		while($row = $reader->GetRow())
			$this->$row[ColumnNames::PrefName] = $row[ColumnNames::PrefValue];
	}

	private function StoreFilterValue($name, $value)
	{
		Log::Debug('Storing new reservations filter value: "%s" = "%s"', $name, $value);

        // TBD: Abstract out db access to Domain/Access/UserRepository.php
		$db = ServiceLocator::GetDatabase();
		$reader = $db->Query(new GetUserPreferenceCommand($this->UserId, $name));
		if($reader->GetRow())
			$db->Execute(new UpdateUserPreferenceCommand($this->UserId, $name, $value));
		else
			$db->ExecuteInsert(new SaveUserPreferenceCommand($this->UserId, $name, $value));
	}
}

class NullUserSession extends UserSession
{
	public function __construct()
	{
		parent::__construct(0);
		$this->SessionToken = '';
		$this->Timezone = Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE);
	}
	
	public function IsLoggedIn()
	{
		return false;
	}
}
?>