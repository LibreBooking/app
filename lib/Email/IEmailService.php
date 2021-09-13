<?php

interface IEmailService
{
    /**
     * @param IEmailMessage $emailMessage
     */
    public function Send(IEmailMessage $emailMessage);
}
