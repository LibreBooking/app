<?php

require_once(ROOT_DIR . 'lib/external/is_email/is_email.php');

class EmailValidator extends ValidatorBase implements IValidator
{
    private $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function Validate()
    {
        $this->isValid = psi_is_email($this->email);

        if (!$this->isValid) {
            $this->AddMessageKey('ValidEmailRequired');
        }
    }
}
