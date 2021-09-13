<?php

require_once(ROOT_DIR . 'lib/Common/Validators/namespace.php');

class RequestRequiredValueValidator extends RequiredValidator
{
    private $attributeName;

    /**
     * @param $value mixed
     * @param $attributeName string
     */
    public function __construct($value, $attributeName)
    {
        $this->attributeName = $attributeName;
        parent::__construct($value);
    }

    public function Validate()
    {
        parent::Validate();

        if (!$this->IsValid()) {
            $this->AddMessage($this->attributeName . ' is missing or empty');
        }
    }
}
