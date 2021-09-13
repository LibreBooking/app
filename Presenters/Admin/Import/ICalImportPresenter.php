<?php

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/external/icalreader/icalreader.php');
require_once(ROOT_DIR . 'Pages/Admin/Import/ICalImportPage.php');

class ICalImportPresenter extends ActionPresenter
{
    /**
     * @var IICalImportPage
     */
    private $page;
    /**
     * @var IUserRepository
     */
    private $userRepository;
    /**
     * @var IResourceRepository
     */
    private $resourceRepository;
    /**
     * @var IReservationRepository
     */
    private $reservationRepository;
    /**
     * @var IRegistration
     */
    private $registration;

    /**
     * @var User[]
     */
    private $userCache = [];

    /**
     * @var BookableResource[]
     */
    private $resourceCache = [];

    /**
     * @var IScheduleRepository
     */
    private $scheduleRepository;

    /**
     * @var int
     */
    private $defaultScheduleId;

    public function __construct(
        IICalImportPage $page,
        IUserRepository $userRepository,
        IResourceRepository $resourceRepository,
        IReservationRepository $reservationRepository,
        IRegistration $registration,
        IScheduleRepository $scheduleRepository
    )
    {
        parent::__construct($page);
        $this->page = $page;
        $this->userRepository = $userRepository;
        $this->resourceRepository = $resourceRepository;
        $this->reservationRepository = $reservationRepository;
        $this->registration = $registration;
        $this->scheduleRepository = $scheduleRepository;

        $this->AddAction('importIcs', 'Import');
    }

    public function Import()
    {
        set_time_limit(12000);

        $numberImported = 0;
        $numberSkipped = 0;

        $file = $this->page->GetImportFile();

        $error = $file->Error();
        if (!empty($error)) {
            die($error);
        }

        $icalReader = new ICal();

        $contents = $file->Contents();

        if (empty($contents)) {
            die('Invalid import file');
        }

        /** @var ICal $ical */
        $ical = $icalReader->initLines(explode("\n", trim($file->Contents())));

        if ($ical === false) {
            die('Invalid import file');
        }

        $events = $icalReader->events();

        Log::Debug('Found %s events in ics file', count($events));

        foreach ($events as $event) {
            try {
                if (!array_key_exists('LOCATION', $event)) {
                    $numberSkipped++;
                    Log::Debug('Skipping ics import - missing resource');
                    continue;
                }
                $location = $event['LOCATION'];

                if (empty($location)) {
                    $numberSkipped++;
                    Log::Debug('Skipping ics import - missing resource');
                    continue;
                }

                $organizer = '';
                if (array_key_exists('ORGANIZER', $event)) {
                    $organizer = $event['ORGANIZER'];
                }

                $user = $this->GetOrCreateUser($organizer);
                $resource = $this->GetOrCreateResource($location);

                $startts = date('Y-m-d H:i:s', $icalReader->iCalDateToUnixTimestamp($event['DTSTART']));
                $start = Date::Parse($startts, $this->GetTimezone($event, 'DTSTART_array'));

                $endts = date('Y-m-d H:i:s', $icalReader->iCalDateToUnixTimestamp($event['DTEND']));
                $end = Date::Parse($endts, $this->GetTimezone($event, 'DTEND_array'));

                $title = array_key_exists('SUMMARY', $event) ? htmlspecialchars($event['SUMMARY']) : '';
                $description = array_key_exists('DESCRIPTION', $event) ? htmlspecialchars($event['DESCRIPTION']) : '';
                ;

                $reservation = ReservationSeries::Create(
                    $user->Id(),
                    $resource,
                    $title,
                    $description,
                    new DateRange($start, $end),
                    new RepeatNone(),
                    ServiceLocator::GetServer()->GetUserSession()
                );
                $participantIds = [];

                if (array_key_exists('ATTENDEE_array', $event)) {
                    foreach ($event['ATTENDEE_array'] as $attendee) {
                        if (is_string($attendee)) {
                            $participant = $this->GetOrCreateUser($attendee);
                            $participantIds[] = $participant->Id();
                        }
                    }
                }

                if (count($participantIds) > 0) {
                    $reservation->ChangeParticipants($participantIds);
                }

                Log::Debug('Importing reservation on %s - %s for %s', $start, $end, $location);

                $this->reservationRepository->Add($reservation);
                $numberImported++;
            } catch (Exception $ex) {
                Log::Error('Error importing event from ICS. %s', $ex);
            }
        }

        Log::Debug('Done running ics import. Imported %s Skipped %s', $numberImported, $numberSkipped);

        $this->page->SetNumberImported($numberImported, $numberSkipped);
    }

    private function GetOrCreateUser($email)
    {
        if (empty($email)) {
            $email = ServiceLocator::GetServer()->GetUserSession()->Email;
        } else {
            $email = str_replace('mailto:', '', $email);
        }
        if (array_key_exists($email, $this->userCache)) {
            return $this->userCache[$email];
        }

        $user = $this->userRepository->LoadByUsername($email);

        if ($user->Id() == null) {
            $encoded = htmlspecialchars($email);
            $user = $this->registration->Register(
                $encoded,
                $encoded,
                '',
                '',
                Password::GenerateRandom(),
                Configuration::Instance()->GetDefaultTimezone(),
                Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE),
                Configuration::Instance()->GetKey(ConfigKeys::DEFAULT_HOMEPAGE)
            );
        }

        $this->userCache[$email] = $user;
        return $user;
    }

    private function GetOrCreateResource($resourceName)
    {
        $resource = $this->resourceRepository->LoadByName($resourceName);

        if (array_key_exists($resourceName, $this->resourceCache)) {
            return $this->resourceCache[$resourceName];
        }

        if ($resource->GetId() == null) {
            $encoded = htmlspecialchars($resourceName);
            $resource = BookableResource::CreateNew($resourceName, $this->GetDefaultScheduleId());
            $id = $this->resourceRepository->Add($resource);
            $resource = $this->resourceRepository->LoadById($id);
        }

        $this->resourceCache[$resourceName] = $resource;

        return $resource;
    }

    private function GetDefaultScheduleId()
    {
        if ($this->defaultScheduleId != null) {
            return $this->defaultScheduleId;
        }

        $schedules = $this->scheduleRepository->GetAll();
        foreach ($schedules as $schedule) {
            if ($schedule->GetIsDefault()) {
                $this->defaultScheduleId = $schedule->GetId();
                return $this->defaultScheduleId;
            }
        }

        $this->defaultScheduleId = $schedules[0]->GetId();
        return $this->defaultScheduleId;
    }

    private function GetTimezone($event, $dtarray)
    {
        if (array_key_exists('TZID', $event[$dtarray][0])) {
            return $event[$dtarray][0]['TZID'];
        }

        return 'UTC';
    }

    protected function LoadValidators($action)
    {
        $this->page->RegisterValidator(
            'fileExtensionValidator',
            new FileExtensionValidator('ics', $this->page->GetImportFile())
        );
    }
}
