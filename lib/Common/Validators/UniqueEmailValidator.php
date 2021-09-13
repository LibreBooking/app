<?php

class UniqueEmailValidator extends ValidatorBase implements IValidator
{
    private $_email;
    private $_userid;
    private $userRepository;

    public function __construct(IUserViewRepository $userRepository, $email, $userid = null)
    {
        $this->_email = $email;
        $this->_userid = $userid;
        $this->userRepository = $userRepository;
    }

    public function Validate()
    {
        $this->isValid = true;

        $userId = $this->userRepository->UserExists($this->_email, null);

        if (!empty($userId)) {
            $this->isValid = $userId == $this->_userid;
        }

        if (!$this->isValid) {
            $this->AddMessageKey('UniqueEmailRequired');
        }
    }
}
