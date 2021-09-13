<?php

interface IValidator
{
    /**
     * @return bool
     */
    public function IsValid();

    /**
     * @return void
     */
    public function Validate();

    /**
     * @return string[]|null
     */
    public function Messages();

    /**
     * @return bool
     */
    public function ReturnsErrorResponse();
}
