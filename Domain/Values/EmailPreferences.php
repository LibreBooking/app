<?php
/**
Copyright 2011-2019 Nick Korbel

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


class EmailPreferences implements IEmailPreferences
{
	private $preferences = array();

	private $_added = array();
	private $_removed = array();

	public function Add($eventCategory, $eventType)
	{
		$key = $this->ToKey($eventCategory, $eventType);
		$this->preferences[$key] = true;
	}

	public function Delete($eventCategory, $eventType)
	{
		$key = $this->ToKey($eventCategory, $eventType);
		unset($this->preferences[$key]);
	}

	public function Exists($eventCategory, $eventType)
	{
		$key = $this->ToKey($eventCategory, $eventType);
		return isset($this->preferences[$key]);
	}

	private function ToKey($eventCategory, $eventType)
	{
		return $eventCategory . '|' . $eventType;
	}

	public function AddPreference(IDomainEvent $event)
	{
		if (!$this->Exists($event->EventCategory(), $event->EventType()))
		{
			$this->Add($event->EventCategory(), $event->EventType());
			$this->_added[] = $event;
		}
	}

	public function RemovePreference(IDomainEvent $event)
	{
		if ($this->Exists($event->EventCategory(), $event->EventType()))
		{
			$this->Delete($event->EventCategory(), $event->EventType());
			$this->_removed[] = $event;
		}
	}

	public function GetAdded()
	{
		return $this->_added;
	}

	public function GetRemoved()
	{
		return $this->_removed;
	}
}

interface IEmailPreferences
{
	/**
	 * @abstract
	 * @param EventCategory|string $eventCategory
	 * @param string $eventType
	 * @return bool
	 */
	public function Exists($eventCategory, $eventType);

	/**
	 * @abstract
	 * @param IDomainEvent $event
	 */
	public function AddPreference(IDomainEvent $event);

	/**
	 * @param IDomainEvent $event
	 */
	public function RemovePreference(IDomainEvent $event);

	/**
	 * @abstract
	 * @return array|IDomainEvent[]
	 */
	public function GetAdded();

	/**
	 * @abstract
	 * @return array|IDomainEvent[]
	 */
	public function GetRemoved();
}
