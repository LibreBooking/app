<?php

class RenderedMessage
{
    /**
     * 
     * @param EmailAddress[] $to 
     * @param EmailAddress[] $cc 
     * @param EmailAddress[] $bcc 
     * @param StringAttachment[] $attachments 
     * @return void 
     */
    public function __construct(
        public readonly string $charset,
        public readonly string $subject,
        public readonly EmailAddress $from,
        public readonly EmailAddress $replyTo,
        public readonly array $to,
        public readonly array $cc,
        public readonly array $bcc,
        public readonly string $body,
        public readonly array $attachments
    )
    {
    }
}