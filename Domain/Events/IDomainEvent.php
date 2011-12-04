<?php
interface IDomainEvent
{
    /**
     * @abstract
     * @return string
     */
    function EventType();

    /**
     * @abstract
     * @return EventCategory|string
     */
    function EventCategory();
}
?>