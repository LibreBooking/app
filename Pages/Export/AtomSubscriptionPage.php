<?php
/**
Copyright 2013-2015 Nick Korbel

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

require_once(ROOT_DIR . 'Presenters/CalendarSubscriptionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Pages/Export/CalendarSubscriptionPage.php');
require_once(ROOT_DIR . 'lib/external/FeedWriter/FeedWriter.php');
require_once(ROOT_DIR . 'lib/external/FeedWriter/FeedItem.php');

class AtomSubscriptionPage extends Page implements ICalendarSubscriptionPage
{
	/**
	 * @var CalendarSubscriptionPresenter
	 */
	private $presenter;

	/**
	 * @var iCalendarReservationView[]
	 */
	private $reservations = array();

	public function __construct()
	{
		$authorization = new ReservationAuthorization(PluginManager::Instance()->LoadAuthorization());
		$service = new CalendarSubscriptionService(new UserRepository(), new ResourceRepository(), new ScheduleRepository());
		$subscriptionValidator = new CalendarSubscriptionValidator($this, $service);
		$this->presenter = new CalendarSubscriptionPresenter($this,
															 new ReservationViewRepository(),
															 $subscriptionValidator,
															 $service,
															 new PrivacyFilter($authorization));
		parent::__construct('', 1);
	}

	public function GetSubscriptionKey()
	{
		return $this->GetQuerystring(QueryStringKeys::SUBSCRIPTION_KEY);
	}

	/**
	 * @return string
	 */
	public function GetUserId()
	{
		return $this->GetQuerystring(QueryStringKeys::USER_ID);
	}

	public function PageLoad()
	{
		ob_clean();
		$this->presenter->PageLoad();

		$config = Configuration::Instance();

		$feed = new FeedWriter(ATOM);
		$title = $config->GetKey(ConfigKeys::APP_TITLE);
		$feed->setTitle("$title Reservations");
		$url = $config->GetScriptUrl();
		$feed->setLink($url);

		$feed->setChannelElement('updated', date(DATE_ATOM , time()));
		$feed->setChannelElement('author', array('name'=>$title));

		foreach ($this->reservations as $reservation)
		{
			/** @var FeedItem $item */
			$item = $feed->createNewItem();
			$item->setTitle($reservation->Summary);
			$item->setLink($reservation->ReservationUrl);
			$item->setDate($reservation->DateCreated->Timestamp());
			$item->setDescription($this->FormatReservationDescription($reservation, ServiceLocator::GetServer()->GetUserSession()));

//			sprintf('<div><span>Start</span> %s</div>
//										  <div><span>End</span> %s</div>
//										  <div><span>Organizer</span> %s</div>
//										  <div><span>Description</span> %s</div>',
//										  $reservation->DateStart->ToString(),
//										  $reservation->DateEnd->ToString(),
//										  $reservation->Organizer,
//										  $reservation->Description));
			$feed->addItem($item);
		}

		$feed->genarateFeed();
	}

	/**
	 * @param array|iCalendarReservationView[] $reservations
	 */
	public function SetReservations($reservations)
	{
		$this->reservations = $reservations;
	}

	/**
	 * @return int
	 */
	public function GetScheduleId()
	{
		return $this->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}

	/**
	 * @return int
	 */
	public function GetResourceId()
	{
		return $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
	}

	/**
	 * @return int
	 */
	public function GetAccessoryIds()
	{
		// no op
	}

	/**
	 * @return string
	 */
	function GetResourceGroupId()
	{
		return $this->GetQuerystring(QueryStringKeys::RESOURCE_GROUP_ID);
	}

	public function FormatReservationDescription(iCalendarReservationView $reservation, UserSession $user)
	{
		$factory = new SlotLabelFactory($user);
		return $factory->Format($reservation->ReservationItemView, Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION_LABELS, ConfigKeys::RESERVATION_LABELS_RSS_DESCRIPTION));
	}
}