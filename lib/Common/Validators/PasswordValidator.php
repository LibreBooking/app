<?php

class PasswordValidator extends ValidatorBase implements IValidator
{
    /**
     * @var User
     */
    private $user;
    private $currentPasswordPlainText;

    /**
     * @param string $currentPasswordPlainText
     * @param User $user
     */
    public function __construct($currentPasswordPlainText, User $user)
    {
        $this->currentPasswordPlainText = $currentPasswordPlainText;
        $this->user = $user;
    }

    public function Validate()
    {
        $pw = new Password($this->currentPasswordPlainText, $this->user->encryptedPassword);
        $this->isValid = $pw->Validate($this->user->passwordSalt);

        if (!$this->isValid) {
            $this->AddMessage(Resources::GetInstance()->GetString('PwMustMatch'));
        }
    }
}
