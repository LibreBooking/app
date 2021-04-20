<?php

interface IDomainEvent
{
    /**
     * @return string
     */
    function EventType();

    /**
     * @return EventCategory|string
     */
    function EventCategory();
}
