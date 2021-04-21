<?php

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationEmailMessage.php');

class ReservationSeriesEndingEmail extends EmailMessage
{
    /**
     * @var string
     */
	private $email;

    /**
     * @var ExistingReservationSeries
     */
    private $reservationSeries;

    /**
     * @var string
     */
    private $timezone;

    /**
     * @var Reservation
     */
    private $currentInstance;

    public function __construct(ExistingReservationSeries $reservationSeries, $language, $timezone, $email)
	{
		parent::__construct($language);

		$this->reservationSeries = $reservationSeries;
		$this->timezone = $timezone;
		$this->email = $email;
		$this->currentInstance = $this->reservationSeries->CurrentInstance();
    }

	public function To()
	{
		return array(new EmailAddress($this->email));
	}

	public function Subject()
	{
		return $this->Translate('ReservationSeriesEndingSubject', array(
		    $this->reservationSeries->Resource()->GetName(),
            $this->currentInstance->StartDate()->ToTimezone($this->timezone)->Format(Resources::GetInstance()->GetDateFormat('general_date'))));
	}

    public function Body()
    {
        $this->Set('ResourceName', $this->reservationSeries->Resource()->GetName());
        $this->Set('Title', $this->reservationSeries->Title());
        $this->Set('Description', $this->reservationSeries->Description());
        $this->Set('StartDate', $this->currentInstance->StartDate()->ToTimezone($this->timezone));
        $this->Set('EndDate', $this->currentInstance->EndDate()->ToTimezone($this->timezone));
        $this->Set('ReservationUrl', sprintf("%s?%s=%s", Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER, $this->currentInstance->ReferenceNumber()));

        return $this->FetchTemplate('ReservationSeriesEnding.tpl');
    }
}
