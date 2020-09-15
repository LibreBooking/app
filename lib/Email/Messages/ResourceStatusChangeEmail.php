<?php
/**
Copyright 2012-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Email/namespace.php');

class ResourceStatusChangeEmail extends EmailMessage
{

	private $email;
	/**
	 * @var BookableResource
	 */
	private $resource;
	private $message;

	/**
	 * @param string $email
	 * @param BookableResource $resource
	 * @param string $message
	 * @param string $language
	 */
	public function __construct($email, BookableResource $resource, $message, $language)
	{
		parent::__construct($language);
		$this->email = $email;
		$this->resource = $resource;
		$this->message = $message;
	}

	public function To()
	{
		return new EmailAddress($this->email);
	}

	public function Subject()
	{
		return $this->Translate('ResourceStatusChangedSubject', array($this->resource->GetName()));
	}

	public function Body()
	{
		$this->Set('ResourceName', $this->resource->GetName());
		$this->Set('Message', $this->message);
		return $this->FetchTemplate('ResourceStatusChanged.tpl');
	}
}