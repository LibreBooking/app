<?php
/**
Copyright 2012-2015 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationAttachmentPresenter.php');

interface IReservationAttachmentPage
{
	/**
	 * @abstract
	 * @return string
	 */
	public function GetFileId();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetReferenceNumber();

	/**
	 * @abstract
	 * @return void
	 */
	public function ShowError();

	/**
	 * @abstract
	 * @param ReservationAttachment $attachment
	 * @return void
	 */
	public function BindAttachment(ReservationAttachment $attachment);
}

class ReservationAttachmentPage extends SecurePage implements IReservationAttachmentPage
{
	/**
	 * @var ReservationAttachmentPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('Error', 1);
	}

	public function PageLoad()
	{
		$this->presenter = new ReservationAttachmentPresenter($this, new ReservationRepository(), PluginManager::Instance()->LoadPermission());
		$this->presenter->PageLoad(ServiceLocator::GetServer()->GetUserSession());
	}

	/**
	 * @return string
	 */
	public function GetFileId()
	{
		return $this->GetQuerystring(QueryStringKeys::ATTACHMENT_FILE_ID);
	}

	/**
	 * @return string
	 */
	public function GetReferenceNumber()
	{
		return $this->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}

	/**
	 * @return void
	 */
	public function ShowError()
	{
		$this->Display('Reservation/attachment-error.tpl');
	}

	/**
	 * @param ReservationAttachment $attachment
	 * @return void
	 */
	public function BindAttachment(ReservationAttachment $attachment)
	{
		header('Content-Type: ' . $attachment->FileType());
		header('Content-Disposition: attachment; filename="' . $attachment->FileName() . '"');
		ob_clean();
		flush();
		echo $attachment->FileContents();
	}
}

?>