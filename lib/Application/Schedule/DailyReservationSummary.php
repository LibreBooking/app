<?php

class DailyReservationSummary
{
    /**
     * @var ReservationListItem
     */
    private $_first = null;

    private $_reservationCount = 0;

    /**
     * @var ReservationListItem[]
     */
    private $_reservations = [];

    /**
     * @return int
     */
    public function NumberOfReservations()
    {
        return $this->_reservationCount;
    }

    /**
     * @return int
     */
    public function NumberOfItems()
    {
        return count($this->_reservations);
    }

    /**
     * @return ReservationListItem
     */
    public function FirstReservation()
    {
        return $this->_first;
    }

    public function Reservations()
    {
        return $this->_reservations;
    }

    public function AddReservation(ReservationListItem $item)
    {
        if ($this->_first == null) {
            $this->_first = $item;
        }

        if ($item->IsReservation()) {
            $this->_reservationCount++;
        }
        $this->_reservations[] = $item;
    }
}
