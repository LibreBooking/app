<?php

class UniqueUserNameValidator extends ValidatorBase implements IValidator
{
    private $_username;
    private $_userid;
    private $userRepository;

    public function __construct(IUserViewRepository $userRepository, $username, $userid = null)
    {
        $this->_username = $username;
        $this->_userid = $userid;
        $this->userRepository = $userRepository;
    }

    public function Validate()
    {
        $this->isValid = true;
        $userId = $this->userRepository->UserExists(null, $this->_username);

        if (!empty($userId)) {
            $this->isValid = $userId == $this->_userid;
        }

        if (!$this->isValid) {
            $this->AddMessageKey('UniqueUsernameRequired');
        }
    }
}
