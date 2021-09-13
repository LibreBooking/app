<?php

class ReservationNotificationFactory implements IReservationNotificationFactory
{
    /**
     * @var array|string[]
     */
    private $creationStrategies = [];

    public function __construct()
    {
        $this->creationStrategies[ReservationAction::Approve] = 'CreateApproveService';
        $this->creationStrategies[ReservationAction::Create] = 'CreateAddService';
        $this->creationStrategies[ReservationAction::Delete] = 'CreateDeleteService';
        $this->creationStrategies[ReservationAction::Update] = 'CreateUpdateService';
        $this->creationStrategies[ReservationAction::Checkin] = 'CreateCheckinService';
        $this->creationStrategies[ReservationAction::Checkout] = 'CreateCheckoutService';
    }

    public function Create($reservationAction, $userSession)
    {
        if (array_key_exists($reservationAction, $this->creationStrategies)) {
            $createMethod = $this->creationStrategies[$reservationAction];
            return $this->$createMethod($userSession);
        }

        return new NullReservationNotificationService();
    }

    private function CreateAddService($userSession)
    {
        $factory = PluginManager::Instance()->LoadPostReservation();
        return $factory->CreatePostAddService($userSession);
    }

    private function CreateApproveService($userSession)
    {
        $factory = PluginManager::Instance()->LoadPostReservation();
        return $factory->CreatePostApproveService($userSession);
    }

    private function CreateDeleteService($userSession)
    {
        $factory = PluginManager::Instance()->LoadPostReservation();
        return $factory->CreatePostDeleteService($userSession);
    }

    private function CreateUpdateService($userSession)
    {
        $factory = PluginManager::Instance()->LoadPostReservation();
        return $factory->CreatePostUpdateService($userSession);
    }

    private function CreateCheckinService($userSession)
    {
        $factory = PluginManager::Instance()->LoadPostReservation();
        return $factory->CreatePostCheckinService($userSession);
    }

    private function CreateCheckoutService($userSession)
    {
        $factory = PluginManager::Instance()->LoadPostReservation();
        return $factory->CreatePostCheckoutService($userSession);
    }
}

class NullReservationNotificationService implements IReservationNotificationService
{
    /**
     * @param ReservationSeries $reservationSeries
     */
    public function Notify($reservationSeries)
    {
        // no-op
    }
}
