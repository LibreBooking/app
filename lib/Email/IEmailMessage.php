<?php

interface IEmailMessage
{
    /**
     * @return string
     */
    public function Charset();

    /**
     * @return array|EmailAddress[]|EmailAddress
     */
    public function To();

    /**
     * @return EmailAddress
     */
    public function From();

    /**
     * @return array|EmailAddress[]|EmailAddress
     */
    public function CC();

    /**
     * @return array|EmailAddress[]|EmailAddress
     */
    public function BCC();

    /**
     * @return string
     */
    public function Subject();

    /**
     * @return string
     */
    public function Body();

    /**
     * @return EmailAddress
     */
    public function ReplyTo();

    /**
     * @abstract
     * @param string $contents
     * @param string $fileName
     */
    public function AddStringAttachment($contents, $fileName);

    /**
     * @abstract
     * @return bool
     */
    public function HasStringAttachment();

    /**
     * @abstract
     * @return string|null
     */
    public function AttachmentContents();

    /**
     * @abstract
     * @return string|null
     */
    public function AttachmentFileName();
}
