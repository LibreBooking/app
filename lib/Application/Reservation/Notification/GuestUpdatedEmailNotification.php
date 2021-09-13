<?php

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/GuestAddedEmailNotification.php');

class GuestUpdatedEmailNotification extends GuestAddedEmailNotification
{
    /**
     * @var IUserRepository
     */
    private $userRepository;

    /**
     * @var IAttributeRepository
     */
    private $attributeRepository;

    public function __construct(IUserRepository $userRepository, IAttributeRepository $attributeRepository)
    {
        $this->userRepository = $userRepository;
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * @param ReservationSeries $reservationSeries
     */
    public function Notify($reservationSeries)
    {
        $instance = $reservationSeries->CurrentInstance();
        $owner = $this->userRepository->LoadById($reservationSeries->UserId());

        foreach ($instance->AddedInvitedGuests() as $guestEmail) {
            $message = new GuestAddedEmail($owner, $guestEmail, $reservationSeries, $this->attributeRepository, $this->userRepository);
            ServiceLocator::GetEmailService()->Send($message);
        }

        foreach ($instance->AddedParticipatingGuests() as $guestEmail) {
            $message = new GuestAddedEmail($owner, $guestEmail, $reservationSeries, $this->attributeRepository, $this->userRepository);
            ServiceLocator::GetEmailService()->Send($message);
        }

        foreach ($instance->UnchangedInvitedGuests() as $guestEmail) {
            $message = new GuestUpdatedEmail($owner, $guestEmail, $reservationSeries, $this->attributeRepository, $this->userRepository);
            ServiceLocator::GetEmailService()->Send($message);
        }

        foreach ($instance->UnchangedParticipatingGuests() as $guestEmail) {
            $message = new GuestUpdatedEmail($owner, $guestEmail, $reservationSeries, $this->attributeRepository, $this->userRepository);
            ServiceLocator::GetEmailService()->Send($message);
        }

        foreach ($instance->RemovedInvitedGuests() as $guestEmail) {
            $message = new GuestDeletedEmail($owner, $guestEmail, $reservationSeries, $this->attributeRepository, $this->userRepository);
            ServiceLocator::GetEmailService()->Send($message);
        }

        foreach ($instance->RemovedParticipatingGuests() as $guestEmail) {
            $message = new GuestDeletedEmail($owner, $guestEmail, $reservationSeries, $this->attributeRepository, $this->userRepository);
            ServiceLocator::GetEmailService()->Send($message);
        }
    }
}
