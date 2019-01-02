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

require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

abstract class ReservationPresenterBase implements IReservationPresenter
{
    /**
     * @var IReservationPage
     */
    protected $basePage;

    protected function __construct(IReservationPage $page)
    {
        $this->basePage = $page;
    }

    public abstract function PageLoad();
}

class ReservationPresenter extends ReservationPresenterBase
{
    /**
     * @var INewReservationPage
     */
    private $_page;

    /**
     * @var IReservationInitializerFactory
     */
    private $initializationFactory;

    /**
     * @var IReservationPreconditionService
     */
    private $preconditionService;

    public function __construct(
        INewReservationPage $page,
        IReservationInitializerFactory $initializationFactory,
        INewReservationPreconditionService $preconditionService)
    {
        parent::__construct($page);

        $this->_page = $page;
        $this->initializationFactory = $initializationFactory;
        $this->preconditionService = $preconditionService;
    }

    public function PageLoad()
    {
        $user = ServiceLocator::GetServer()->GetUserSession();
        $this->preconditionService->CheckAll($this->_page, $user);
        $initializer = $this->initializationFactory->GetNewInitializer($this->_page);
        $initializer->Initialize();
    }
}

class EditReservationPresenter extends ReservationPresenterBase
{
    /**
     * @var IExistingReservationPage
     */
    private $page;

    /**
     * @var IReservationInitializerFactory
     */
    private $initializationFactory;

    /**
     * @var EditReservationPreconditionService
     */
    private $preconditionService;

    /**
     * @var IReservationViewRepository
     */
    private $reservationViewRepository;

    public function __construct(
        IExistingReservationPage $page,
        IReservationInitializerFactory $initializationFactory,
        EditReservationPreconditionService $preconditionService,
        IReservationViewRepository $reservationViewRepository)
    {
        parent::__construct($page);

        $this->page = $page;
        $this->initializationFactory = $initializationFactory;
        $this->preconditionService = $preconditionService;
        $this->reservationViewRepository = $reservationViewRepository;
    }

    public function PageLoad()
    {
        $user = ServiceLocator::GetServer()->GetUserSession();

        $referenceNumber = $this->page->GetReferenceNumber();
        $reservationView = $this->reservationViewRepository->GetReservationForEditing($referenceNumber);

        $this->preconditionService->CheckAll($this->page, $user, $reservationView);
        $initializer = $this->initializationFactory->GetExistingInitializer($this->page, $reservationView);
        $initializer->Initialize();
    }
}

interface IReservationPresenter
{
    public function PageLoad();
}