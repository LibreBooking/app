<?php

class EmailLogger implements IEmailService
{
    /**
     * @param IEmailMessage $emailMessage
     */
    public function Send(IEmailMessage $emailMessage)
    {
        if (is_array($emailMessage->To())) {
            $to = implode(', ', $emailMessage->To());
        } else {
            $to = $emailMessage->To();
        }
        Log::Debug(
            "Sending Email. To: %s\nFrom: %s\nSubject: %s\nBody: %s",
            $to,
            $emailMessage->From(),
            $emailMessage->Subject(),
            $emailMessage->Body()
        );
    }
}
