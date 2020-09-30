<?php
/**
 * Copyright 2012-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/UserSessionRepository.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class WebServiceApiUserAuthentication extends Authentication
{
    private $userRepository;

    public function __construct(IRoleService $roleService, IUserRepository $userRepository, IGroupRepository $groupRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct($roleService, $userRepository, $groupRepository);
    }

    public function Login($username, $loginContext)
    {
        $user = $this->userRepository->LoadByUsername($username);
        if ($user->GetIsApiOnly()) {
            return parent::Login($username, $loginContext);
        }
        return null;
    }

    public function Validate($username, $passwordPlainText)
    {
        $user = $this->userRepository->LoadByUsername($username);
        if ($user->GetIsApiOnly()) {
            return parent::Validate($username, $passwordPlainText);
        }
        return false;
    }
}