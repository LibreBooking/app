<?php

/**
 * Copyright 2017-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Pages/Ajax/IReservationSaveResultsView.php');

class ResourceDisplayPresenter extends ActionPresenter
{
    /**
     * @var IResourceDisplayPage
     */
    private $page;

    /**
     * @var IResourceRepository
     */
    private $resourceRepository;
    /**
     * @var IReservationService
     */
    private $reservationService;
    /**
     * @var IAuthorizationService
     */
    private $authorizationService;
    /**
     * @var IWebAuthentication
     */
    private $authentication;
    /**
     * @var IScheduleRepository
     */
    private $scheduleRepository;
    /**
     * @var IDailyLayoutFactory
     */
    private $dailyLayoutFactory;

    /**
     * @var IGuestUserService
     */
    private $guestUserService;

    /**
     * @var IReservationHandler
     */
    public $reservationCreateHandler;

    /**
     * @var IReservationHandler
     */
    public $reservationCheckinHandler;

    /**
     * @var IAttributeService
     */
    private $attributeService;

    /**
     * @var IReservationRepository
     */
    private $reservationRepository;

    /**
     * @var ITermsOfServiceRepository
     */
    private $termsOfServiceRepository;

    public function __construct(IResourceDisplayPage $page,
                                IResourceRepository $resourceRepository,
                                IReservationService $reservationService,
                                IAuthorizationService $authorizationService,
                                IWebAuthentication $authentication,
                                IScheduleRepository $scheduleRepository,
                                IDailyLayoutFactory $dailyLayoutFactory,
                                IGuestUserService $guestUserService,
                                IAttributeService $attributeService,
                                IReservationRepository $reservationRepository,
                                ITermsOfServiceRepository $termsOfServiceRepository)
    {
        parent::__construct($page);
        $this->page = $page;
        $this->resourceRepository = $resourceRepository;
        $this->reservationService = $reservationService;
        $this->authorizationService = $authorizationService;
        $this->authentication = $authentication;
        $this->scheduleRepository = $scheduleRepository;
        $this->dailyLayoutFactory = $dailyLayoutFactory;
        $this->guestUserService = $guestUserService;
        $this->attributeService = $attributeService;
        $this->reservationRepository = $reservationRepository;
        $this->termsOfServiceRepository = $termsOfServiceRepository;

        parent::AddAction('login', 'Login');
        parent::AddAction('activate', 'Activate');
        parent::AddAction('reserve', 'Reserve');
        parent::AddAction('checkin', 'Checkin');
    }

    public function PageLoad()
    {
        $resourceId = $this->page->GetPublicResourceId();
        $loggedIn = ServiceLocator::GetServer()->GetUserSession()->IsLoggedIn();

        if (empty($resourceId) || !$loggedIn) {
            $this->page->DisplayLogin();
        }
        if (!empty($resourceId)) {
            $this->page->DisplayResourceShell();
        }
    }

    public function Login()
    {
        $username = $this->page->GetEmail();
        $password = $this->page->GetPassword();

        $isValid = $this->authentication->Validate($username, $password);

        if ($isValid) {
            $this->authentication->Login($username, new WebLoginContext(new LoginData()));
            $user = ServiceLocator::GetServer()->GetUserSession();
            $resourceList = array();
            $resources = $this->resourceRepository->GetResourceList();
            foreach ($resources as $resource) {
                if ($this->authorizationService->CanEditForResource($user, $resource)) {
                    $resourceList[] = $resource;
                }
            }

            $this->page->BindResourceList($resourceList);
        }
        else {
            $this->page->BindInvalidLogin();
        }
    }

    public function Activate()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());
        if ($this->authorizationService->CanEditForResource(ServiceLocator::GetServer()->GetUserSession(), $resource)) {
            $resource->EnableDisplay();
            $this->resourceRepository->Update($resource);
            $this->page->SetActivatedResourceId($resource->GetPublicId());
        }
    }

    public function DisplayResource($resourcePublicId)
    {
        $resource = $this->resourceRepository->LoadByPublicId($resourcePublicId);

        if (!$resource->GetIsDisplayEnabled()) {

            $this->page->DisplayNotEnabled();
            return;
        }
        $scheduleId = $resource->GetScheduleId();

        $schedule = $this->scheduleRepository->LoadById($scheduleId);
        $timezone = $schedule->GetTimezone();

        $now = Date::Now()->ToTimezone($timezone);

        $layout = $this->scheduleRepository->GetLayout($scheduleId, new ScheduleLayoutFactory($timezone));
        $slots = $layout->GetLayout($now, true);
        if ($slots[count($slots) - 1]->EndDate()->LessThanOrEqual($now)) {
            $now = $now->AddDays(1)->GetDate();
        }

        $reservationSearchRange = new DateRange($now->GetDate()->ToUtc(), $now->AddDays(1)->GetDate()->ToUtc());
        $reservations = $this->reservationService->GetReservations($reservationSearchRange, null, $timezone, $resource->GetResourceId());

        $attributes = $this->attributeService->GetReservationAttributes(ServiceLocator::GetServer()->GetUserSession(),
            new ReservationView(), 0, array($resource->GetResourceId()));

        $requiredAttributes = array();
        /** @var Attribute $attribute */
        foreach ($attributes as $attribute) {
            if ($attribute->Required()) {
                $requiredAttributes[] = $attribute;
            }
        }
        $this->page->BindResource($resource);
        $this->page->BindSchedule($schedule);
        $this->page->BindAttributes($requiredAttributes);

        $dailyLayout = $this->dailyLayoutFactory->Create($reservations, $layout);

        $reservationList = $reservations->OnDateForResource($now, $resource->GetId());

        /** @var ReservationListItem $next */
        $next = null;

        /** @var ReservationListItem[] $upcoming */
        $upcoming = [];

        $current = null;
        $requiresCheckin = false;
        $checkinReferenceNumber = '';

        /** @var ReservationListItem $r */
        foreach ($reservationList as $r) {
            if (($next == null || $r->StartDate()->LessThan($next->StartDate())) && $r->StartDate()->GreaterThan($now)) {
                $next = $r;
            }

            if ($r->RequiresCheckin()) {
                $requiresCheckin = true;
                $checkinReferenceNumber = $r->ReferenceNumber();
            }

            if ($r->CollidesWith($now)) {
                $current = $r;
            }

            if ($r->StartDate()->GreaterThan($now)) {
                $upcoming[] = $r;
            }
        }

        $this->SetTermsOfService();
        $this->page->SetIsAvailableNow($current == null);
        $this->page->DisplayAvailability($dailyLayout, $now, $current, $next, $upcoming, $requiresCheckin, $checkinReferenceNumber);
    }

    public function Reserve()
    {
        $timezone = $this->page->GetTimezone();
        $resourceId = $this->page->GetResourceId();
        $email = $this->page->GetEmail();

        $now = Date::Now()->ToTimezone($timezone)->Format('Y-m-d ');

        $date = DateRange::Create($now . $this->page->GetBeginTime(), $now . $this->page->GetEndTime(), $timezone);

        $userSession = $this->guestUserService->CreateOrLoad($email);
        $resource = $this->resourceRepository->LoadById($resourceId);

        $resultCollector = new ReservationResultCollector();
        $series = ReservationSeries::Create($userSession->UserId, $resource, Resources::GetInstance()->GetString('AdHocMeeting'), Resources::GetInstance()->GetString('AdHocMeeting'), $date, new RepeatNone(), $userSession);

        $series->AcceptTerms($this->page->GetTermsOfServiceAcknowledgement());

        $attributes = $this->page->GetAttributes();
        foreach ($attributes as $attribute) {
            $series->AddAttributeValue(new AttributeValue($attribute->Id, $attribute->Value));
        }

        $success = $this->GetHandler($userSession)->Handle($series, $resultCollector);

        $this->page->SetReservationSaveResults($success, $resultCollector);
    }

    public function Checkin()
    {
        $resultCollector = new ReservationResultCollector();
        $series = $this->reservationRepository->LoadByReferenceNumber($this->page->GetReferenceNumber());

        $userSession = new NullUserSession();
        $handler = $this->GetCheckinHandler($userSession);

        $series->Checkin($userSession);
        $success = $handler->Handle($series, $resultCollector);

        $this->page->SetReservationCheckinResults($success, $resultCollector);
    }

    public function ProcessDataRequest($dataRequest)
    {
        if ($dataRequest == 'display') {
            $resourceId = $this->page->GetPublicResourceId();

            $this->DisplayResource($resourceId);
        }
    }

    protected function LoadValidators($action)
    {
        if ($action == 'reserve') {
            $this->page->RegisterValidator('emailformat', new EmailValidator($this->page->GetEmail()));
            if (!Configuration::Instance()->GetSectionKey(ConfigSection::TABLET_VIEW, ConfigKeys::TABLET_VIEW_ALLOW_GUESTS, new BooleanConverter()))
            {
                $this->page->RegisterValidator('guestdenied', new RestrictedGuestValidator($this->page->GetEmail(), $this->guestUserService));
            }
        }
    }

    private function GetHandler($userSession)
    {
        if ($this->reservationCreateHandler == null) {
            return ReservationHandler::Create(ReservationAction::Create,
                new AddReservationPersistenceService($this->reservationRepository),
                $userSession);
        }

        return $this->reservationCreateHandler;
    }

    private function GetCheckinHandler($userSession)
    {
        if ($this->reservationCheckinHandler == null) {
            return ReservationHandler::Create(ReservationAction::Checkin, new UpdateReservationPersistenceService($this->reservationRepository), $userSession);
        }

        return $this->reservationCheckinHandler;
    }

    private function SetTermsOfService()
    {
        $termsOfService = $this->termsOfServiceRepository->Load();
        if ($termsOfService != null && $termsOfService->AppliesToReservation()) {
            $this->page->SetTerms($termsOfService);
        }
    }
}

class ReservationResultCollector implements IReservationSaveResultsView
{
    /**
     * @var string[]
     */
    public $Warnings;

    /**
     * @var bool
     */
    public $Succeeded;

    /**
     * @var string[]
     */
    public $Errors;

    /**
     * @param bool $succeeded
     */
    public function SetSaveSuccessfulMessage($succeeded)
    {
        $this->Succeeded = $succeeded;
    }

    /**
     * @param array|string[] $errors
     */
    public function SetErrors($errors)
    {
        $this->Errors = $errors;
    }

    /**
     * @param array|string[] $warnings
     */
    public function SetWarnings($warnings)
    {
        $this->Warnings = $warnings;
    }

    /**
     * @param array|string[] $messages
     */
    public function SetRetryMessages($messages)
    {
    }

    /**
     * @param bool $canBeRetried
     */
    public function SetCanBeRetried($canBeRetried)
    {
    }

    /**
     * @param ReservationRetryParameter[] $retryParameters
     */
    public function SetRetryParameters($retryParameters)
    {
    }

    /**
     * @return ReservationRetryParameter[]
     */
    public function GetRetryParameters()
    {
        return array();
    }

    /**
     * @param bool $canJoinWaitlist
     */
    public function SetCanJoinWaitList($canJoinWaitlist)
    {
        // no-op
    }
}