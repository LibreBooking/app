<?php

require_once(ROOT_DIR . 'lib/Email/Messages/GuestDeletedEmail.php');

class GuestDeletedEmailNotification implements IReservationNotification
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

        foreach ($instance->UnchangedParticipatingGuests() as $email) {
            $message = new GuestDeletedEmail($owner, $email, $reservationSeries, $this->attributeRepository, $this->userRepository);
            ServiceLocator::GetEmailService()->Send($message);
        }
    }
}
