<?php

abstract class ValidatorBase implements IValidator
{
    /**
     * @var bool
     */
    protected $isValid = true;

    /**
     * @var array|string[]
     */
    private $messages = [];

    /**
     * @return bool
     */
    public function IsValid()
    {
        return $this->isValid;
    }

    /**
     * @return array|null|string[]
     */
    public function Messages()
    {
        return $this->messages;
    }

    /**
     * @return bool
     */
    public function ReturnsErrorResponse()
    {
        return false;
    }

    /**
     * @param string $message
     */
    protected function AddMessage($message)
    {
        $this->messages[] = $message;
    }

    /**
     * @param string $resourceKey
     * @param array $params
     */
    protected function AddMessageKey($resourceKey, $params = [])
    {
        $this->AddMessage(Resources::GetInstance()->GetString($resourceKey, $params));
    }
}
