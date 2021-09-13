<?php

interface IDomainEvent
{
    /**
     * @return string
     */
    public function EventType();

    /**
     * @return EventCategory|string
     */
    public function EventCategory();
}
