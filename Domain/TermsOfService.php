<?php

class TermsOfService
{
    public const RESERVATION = 'RESERVATION';
    public const REGISTRATION = 'REGISTRATION';

    private $id;
    private $termsText;
    private $termsUrl;
    private $filename;
    private $applicability;

    /**
     * @param int $id
     * @param string $termsText
     * @param string $termsUrl
     * @param string $filename
     * @param string $applicability
     */
    public function __construct($id, $termsText, $termsUrl, $filename, $applicability)
    {
        $this->id = $id;
        $this->termsText = $termsText;
        $this->termsUrl = $termsUrl;
        $this->filename = $filename;
        $this->applicability = $applicability;
    }

    /**
     * @param string $termsText
     * @param string $termsUrl
     * @param string $filename
     * @param string $applicability
     * @return TermsOfService
     */
    public static function Create($termsText, $termsUrl, $filename, $applicability)
    {
        return new TermsOfService(0, $termsText, $termsUrl, $filename, $applicability);
    }

    /**
     * @return int
     */
    public function Id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function Text()
    {
        return $this->termsText;
    }

    /**
     * @return string
     */
    public function Url()
    {
        return $this->termsUrl;
    }

    /**
     * @return string
     */
    public function FileName()
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function Applicability()
    {
        return $this->applicability;
    }

    /**
     * @return bool
     */
    public function AppliesToReservation()
    {
        return $this->Applicability() == self::RESERVATION;
    }

    /**
     * @return bool
     */
    public function AppliesToRegistration()
    {
        return $this->Applicability() == self::REGISTRATION;
    }

    /**
     * @return string
     */
    public function DisplayUrl()
    {
        $scriptUrl = Configuration::Instance()->GetScriptUrl();

        if ($this->IsText()) {
            return $scriptUrl . '/tos.php';
        }
        if ($this->IsUrl()) {
            return $this->termsUrl;
        }

        return $scriptUrl . "/uploads/tos/{$this->filename}";
    }

    /**
     * @return bool
     */
    public function IsText()
    {
        return !empty($this->termsText);
    }

    /**
     * @return bool
     */
    public function IsUrl()
    {
        return !empty($this->termsUrl);
    }

    /**
     * @return bool
     */
    public function IsFile()
    {
        return !empty($this->filename);
    }
}
