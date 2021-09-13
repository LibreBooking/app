<?php

class EmailPreferences implements IEmailPreferences
{
    private $preferences = [];

    private $_added = [];
    private $_removed = [];

    public function Add($eventCategory, $eventType)
    {
        $key = $this->ToKey($eventCategory, $eventType);
        $this->preferences[$key] = true;
    }

    public function Delete($eventCategory, $eventType)
    {
        $key = $this->ToKey($eventCategory, $eventType);
        unset($this->preferences[$key]);
    }

    public function Exists($eventCategory, $eventType)
    {
        $key = $this->ToKey($eventCategory, $eventType);
        return isset($this->preferences[$key]);
    }

    private function ToKey($eventCategory, $eventType)
    {
        return $eventCategory . '|' . $eventType;
    }

    public function AddPreference(IDomainEvent $event)
    {
        if (!$this->Exists($event->EventCategory(), $event->EventType())) {
            $this->Add($event->EventCategory(), $event->EventType());
            $this->_added[] = $event;
        }
    }

    public function RemovePreference(IDomainEvent $event)
    {
        if ($this->Exists($event->EventCategory(), $event->EventType())) {
            $this->Delete($event->EventCategory(), $event->EventType());
            $this->_removed[] = $event;
        }
    }

    public function GetAdded()
    {
        return $this->_added;
    }

    public function GetRemoved()
    {
        return $this->_removed;
    }
}

interface IEmailPreferences
{
    /**
     * @abstract
     * @param EventCategory|string $eventCategory
     * @param string $eventType
     * @return bool
     */
    public function Exists($eventCategory, $eventType);

    /**
     * @abstract
     * @param IDomainEvent $event
     */
    public function AddPreference(IDomainEvent $event);

    /**
     * @param IDomainEvent $event
     */
    public function RemovePreference(IDomainEvent $event);

    /**
     * @abstract
     * @return array|IDomainEvent[]
     */
    public function GetAdded();

    /**
     * @abstract
     * @return array|IDomainEvent[]
     */
    public function GetRemoved();
}
