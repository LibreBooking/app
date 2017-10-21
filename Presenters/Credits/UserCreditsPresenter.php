<?php
/**
 * Copyright 2017 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'Pages/Credits/UserCreditsPage.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class UserCreditsPresenter extends ActionPresenter
{
    /**
     * @var IUserCreditsPage
     */
    private $page;

    /**
     * @var IUserRepository
     */
    private $userRepository;

    public function __construct(IUserCreditsPage $page, IUserRepository $userRepository)
    {
        parent::__construct($page);

        $this->page = $page;
        $this->userRepository = $userRepository;

//        $this->AddAction(ProfileActions::Update, 'UpdateProfile');

    }

    public function PageLoad(UserSession $userSession)
    {
        $user = $this->userRepository->LoadById($userSession->UserId);
        $this->page->SetCurrentCredits($user->GetCurrentCredits());
    }

    public function ProcessAction()
    {
    }
}