<?php
/**
 * Copyright 2011-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationPresenter.php');

interface IReservationPage extends IPage
{
	/**
	 * @param $startPeriods array|SchedulePeriod[]
	 * @param $endPeriods array|SchedulePeriod[]
     * @parma $lockDates bool
	 */
	public function BindPeriods($startPeriods, $endPeriods, $lockPeriods);

	/**
	 * @param $resources array|ResourceDto[]
	 */
	public function BindAvailableResources($resources);

	/**
	 * @param $accessories Accessory[]
	 */
	public function BindAvailableAccessories($accessories);

	/**
	 * @param $groups ResourceGroupTree
	 */
	public function BindResourceGroups($groups);

	/**
	 * @param SchedulePeriod $selectedStart
	 * @param Date $startDate
	 */
	public function SetSelectedStart(SchedulePeriod $selectedStart, Date $startDate);

	/**
	 * @param SchedulePeriod $selectedEnd
	 * @param Date $endDate
	 */
	public function SetSelectedEnd(SchedulePeriod $selectedEnd, Date $endDate);

	/**
	 * @param $repeatTerminationDate Date
	 */
	public function SetRepeatTerminationDate($repeatTerminationDate);

	/**
	 * @param UserDto $user
	 */
	public function SetReservationUser(UserDto $user);

	/**
	 * @param IResource $resource
	 */
	public function SetReservationResource($resource);

	/**
	 * @param int $scheduleId
	 */
	public function SetScheduleId($scheduleId);

	/**
	 * @param ReservationUserView[] $participants
	 */
	public function SetParticipants($participants);

	/**
	 * @param ReservationUserView[] $invitees
	 */
	public function SetInvitees($invitees);

	/**
	 * @param $accessories ReservationAccessory[]|array
	 */
	public function SetAccessories($accessories);

	/**
	 * @param $attachments ReservationAttachmentView[]|array
	 */
	public function SetAttachments($attachments);

	/**
	 * @param $canChangeUser
	 */
	public function SetCanChangeUser($canChangeUser);

	/**
	 * @param bool $canShowAdditionalResources
	 */
	public function ShowAdditionalResources($canShowAdditionalResources);

	/**
	 * @param bool $canShowUserDetails
	 */
	public function ShowUserDetails($canShowUserDetails);

	/**
	 * @param bool $shouldShow
	 */
	public function SetShowParticipation($shouldShow);

	/**
	 * @param bool $showReservationDetails
	 */
	public function ShowReservationDetails($showReservationDetails);

	/**
	 * @param bool $isHidden
	 */
	public function HideRecurrence($isHidden);

	/**
	 * @param bool $allowParticipation
	 */
	function SetAllowParticipantsToJoin($allowParticipation);

	/**
	 * @param int $reminderValue
	 * @param ReservationReminderInterval $reminderInterval
	 */
	public function SetStartReminder($reminderValue, $reminderInterval);

	/**
	 * @param int $reminderValue
	 * @param ReservationReminderInterval $reminderInterval
	 */
	public function SetEndReminder($reminderValue, $reminderInterval);

    /**
     * @param DateRange $availability
     */
    public function SetAvailability(DateRange $availability);

    /**
     * @param int $weekday
     */
    public function SetFirstWeekday($weekday);

    public function MakeUnavailable();

    /**
     * @return bool
     */
    public function IsUnavailable();

    /**
     * @param TermsOfService $termsOfService
     */
    public function SetTerms($termsOfService);

    /**
     * @param bool $accepted
     */
    public function SetTermsAccepted($accepted);
}

abstract class ReservationPage extends Page implements IReservationPage
{
	protected $presenter;
	protected $available = true;

	/**
	 * @var PermissionServiceFactory
	 */
	protected $permissionServiceFactory;

	public function __construct($title = null)
	{
		parent::__construct($title);

		if (is_null($this->permissionServiceFactory))
		{
			$this->permissionServiceFactory = new PermissionServiceFactory();
		}
	}

	/**
	 * @return IReservationPresenter
	 */
	protected abstract function GetPresenter();

	/**
	 * @return string
	 */
	protected abstract function GetTemplateName();

	/**
	 * @return string
	 */
	protected abstract function GetReservationAction();

	public function PageLoad()
	{
		$this->presenter = $this->GetPresenter();
		$this->presenter->PageLoad();

		$this->Set('ReturnUrl', $this->GetReturnUrl());
		$this->Set('ReservationAction', $this->GetReservationAction());
		$this->Set('MaxUploadSize', UploadedFile::GetMaxSize());
		$this->Set('MaxUploadCount', UploadedFile::GetMaxUploadCount());
		$this->Set('UploadsEnabled', Configuration::Instance()->GetSectionKey(ConfigSection::UPLOADS, ConfigKeys::UPLOAD_ENABLE_RESERVATION_ATTACHMENTS, new BooleanConverter()));
		$this->Set('AllowParticipation', !Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_PREVENT_PARTICIPATION,  new BooleanConverter()));
		$this->Set('AllowGuestParticipation', Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_ALLOW_GUESTS, new BooleanConverter()));
		$remindersEnabled = Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_REMINDERS_ENABLED, new BooleanConverter());
		$emailEnabled = Configuration::Instance()->GetKey(ConfigKeys::ENABLE_EMAIL, new BooleanConverter());
		$this->Set('RemindersEnabled', $remindersEnabled && $emailEnabled);

		$this->Set('RepeatEveryOptions', range(1, 20));
		$this->Set('RepeatOptions', array(
										  'none' => array('key' => 'DoesNotRepeat', 'everyKey' => ''),
										  'daily' => array('key' => 'Daily', 'everyKey' => 'days'),
										  'weekly' => array('key' => 'Weekly', 'everyKey' => 'weeks'),
										  'monthly' => array('key' => 'Monthly', 'everyKey' => 'months'),
										  'yearly' => array('key' => 'Yearly', 'everyKey' => 'years'),
								  )
		);
		$this->Set('DayNames', array(
									 0 => 'DaySundayAbbr',
									 1 => 'DayMondayAbbr',
									 2 => 'DayTuesdayAbbr',
									 3 => 'DayWednesdayAbbr',
									 4 => 'DayThursdayAbbr',
									 5 => 'DayFridayAbbr',
									 6 => 'DaySaturdayAbbr',
							 )
		);

		$this->Set('TitleRequired', Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_TITLE_REQUIRED, new BooleanConverter()));
		$this->Set('DescriptionRequired', Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_DESCRIPTION_REQUIRED, new BooleanConverter()));

		$this->Set('CreditsEnabled', Configuration::Instance()->GetSectionKey(ConfigSection::CREDITS, ConfigKeys::CREDITS_ENABLED, new BooleanConverter()));

        if ($this->IsUnavailable())
        {
            $this->RedirectToError(ErrorMessages::RESERVATION_NOT_AVAILABLE);
            return;
        }

		$this->Display($this->GetTemplateName());
	}

	public function BindPeriods($startPeriods, $endPeriods, $lockPeriods)
	{
		$this->Set('StartPeriods', $startPeriods);
		$this->Set('EndPeriods', $endPeriods);
		$this->Set('LockPeriods', $lockPeriods);
	}

	public function BindAvailableResources($resources)
	{
		$this->Set('AvailableResources', $resources);
	}

	public function ShowAdditionalResources($shouldShow)
	{
		$this->Set('ShowAdditionalResources', $shouldShow);
	}

	public function BindAvailableAccessories($accessories)
	{
		$this->Set('AvailableAccessories', $accessories);
	}

	public function BindResourceGroups($groups)
	{
		$this->Set('ResourceGroupsAsJson', json_encode($groups->GetGroups()));
	}

	public function SetSelectedStart(SchedulePeriod $selectedStart, Date $startDate)
	{
		$this->Set('SelectedStart', $selectedStart);
		$this->Set('StartDate', $startDate);
	}

	public function SetSelectedEnd(SchedulePeriod $selectedEnd, Date $endDate)
	{
		$this->Set('SelectedEnd', $selectedEnd);
		$this->Set('EndDate', $endDate);
	}

	public function SetReservationUser(UserDto $user)
	{
		$this->Set('ReservationUserName', $user->FullName());
		$this->Set('UserId', $user->Id());
		$this->Set('CurrentUserCredits', $user->CurrentCreditCount());
	}

	public function SetReservationResource($resource)
	{
		$this->Set('ResourceName', $resource->GetName());
		$this->Set('ResourceId', $resource->GetId());
		$this->Set('Resource', $resource);
	}

	public function SetScheduleId($scheduleId)
	{
		$this->Set('ScheduleId', $scheduleId);
	}

	public function SetRepeatTerminationDate($repeatTerminationDate)
	{
		$this->Set('RepeatTerminationDate', $repeatTerminationDate);
	}

	public function SetParticipants($participants)
	{
		$this->Set('Participants', $participants);
	}

	public function SetInvitees($invitees)
	{
		$this->Set('Invitees', $invitees);
	}

	public function SetAllowParticipantsToJoin($allowParticipantsToJoin)
	{
		$this->Set('AllowParticipantsToJoin', $allowParticipantsToJoin);
	}

	public function SetAccessories($accessories)
	{
		$this->Set('Accessories', $accessories);
	}

	public function SetAttachments($attachments)
	{
		$this->Set('Attachments', $attachments);
	}

	public function SetCanChangeUser($canChangeUser)
	{
		$this->Set('CanChangeUser', $canChangeUser);
	}

	public function ShowUserDetails($canShowUserDetails)
	{
		$this->Set('ShowUserDetails', $canShowUserDetails);
	}

	public function SetShowParticipation($shouldShow)
	{
		$this->Set('ShowParticipation', $shouldShow);
	}

	public function ShowReservationDetails($showReservationDetails)
	{
		$this->Set('ShowReservationDetails', $showReservationDetails);
	}

	public function HideRecurrence($isHidden)
	{
		$this->Set('HideRecurrence', $isHidden);
	}

	protected function GetReturnUrl()
	{
		$redirect = $this->GetQuerystring(QueryStringKeys::REDIRECT);
		if (!empty($redirect))
		{
			return $redirect;
		}
		return $this->GetLastPage(Pages::SCHEDULE);
	}

	protected function LoadInitializerFactory()
	{
		$userRepository = new UserRepository();
		return new ReservationInitializerFactory(
				new ScheduleRepository(), $userRepository, new ResourceService(new ResourceRepository(),
																			   $this->permissionServiceFactory->GetPermissionService(),
																			   new AttributeService(new AttributeRepository()),
																			   $userRepository,
																			   new AccessoryRepository()),
				new ReservationAuthorization(AuthorizationServiceFactory::GetAuthorizationService())
		);
	}

	public function SetStartReminder($reminderValue, $reminderInterval)
	{
		$this->Set('ReminderTimeStart', $reminderValue);
		$this->Set('ReminderIntervalStart', $reminderInterval);
	}

	public function SetEndReminder($reminderValue, $reminderInterval)
	{
		$this->Set('ReminderTimeEnd', $reminderValue);
		$this->Set('ReminderIntervalEnd', $reminderInterval);
	}

    public function SetAvailability(DateRange $availability)
    {
        $this->Set('AvailabilityStart', $availability->GetBegin());
        $this->Set('AvailabilityEnd', $availability->GetEnd());
    }

    public function SetFirstWeekday($weekday)
    {
        $this->Set('FirstWeekday', $weekday);
    }

    public function MakeUnavailable()
    {
        $this->available = false;
    }

    public function IsUnavailable()
    {
        return !$this->available;
    }

    public function SetTerms($termsOfService)
    {
        $this->Set('Terms', $termsOfService);
    }
}