<?php

require_once(ROOT_DIR . 'lib/Email/Messages/InviteeAddedEmail.php');

class InviteeAddedEmailNotification implements IReservationNotification
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
        $owner = null;

        $instance = $reservationSeries->CurrentInstance();
        foreach ($instance->AddedInvitees() as $userId) {
            if ($owner == null) {
                $owner = $this->userRepository->LoadById($reservationSeries->UserId());
            }

            $invitee = $this->userRepository->LoadById($userId);

            $message = new InviteeAddedEmail($owner, $invitee, $reservationSeries, $this->attributeRepository, $this->userRepository);
            ServiceLocator::GetEmailService()->Send($message);
        }
    }
}
