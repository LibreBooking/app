<?php
/**
Copyright 2012-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Email/Messages/AccountActivationEmail.php');

class AccountActivation implements IAccountActivation
{
	/**
	 * @var IAccountActivationRepository
	 */
	private $activationRepository;

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	public function __construct(IAccountActivationRepository $activationRepository, IUserRepository $userRepository)
	{
		$this->activationRepository = $activationRepository;
		$this->userRepository = $userRepository;
	}

	public function Notify(User $user)
	{
		$activationCode = BookedStringHelper::Random(30);

		$this->activationRepository->AddActivation($user, $activationCode);

		ServiceLocator::GetEmailService()->Send(new AccountActivationEmail($user, $activationCode));
	}

	public function Activate($activationCode)
	{
		$userId = $this->activationRepository->FindUserIdByCode($activationCode);
		$this->activationRepository->DeleteActivation($activationCode);

		if ($userId != null)
		{
			$user = $this->userRepository->LoadById($userId);
			$user->Activate();
			$this->userRepository->Update($user);
			return new ActivationResult(true, $user);
		}

		return new ActivationResult(false);
	}
}

class ActivationResult
{
	/**
	 * @var bool
	 */
	private $activated;

	/**
	 * @var null|User
	 */
	private $user;

	/**
	 * @param bool $activated
	 * @param User|null $user
	 */
	public function __construct($activated, $user = null)
	{
		$this->activated = $activated;
		$this->user = $user;
	}

	/**
	 * @return boolean
	 */
	public function Activated()
	{
		return $this->activated;
	}

	/**
	 * @return null|User
	 */
	public function User()
	{
		return $this->user;
	}
}