<?php

require_once(ROOT_DIR . 'Domain/Values/FullName.php');

class CreditLogView
{
    /**
     * @var Date
     */
    public $Date;

    /**
     * @var string
     */
    public $Note;

    /**
     * @var int
     */
    public $OriginalCreditCount;

    /**
     * @var int
     */
    public $CreditCount;

    /**
     * @var string
     */
    public $UserFullName;

    public function __construct($date, $note, $originalCount, $count, $userFullName = '')
    {
        $this->Date = $date;
        $this->Note = $note;
        $this->OriginalCreditCount = $originalCount;
        $this->CreditCount = $count;
        $this->UserFullName = $userFullName;
    }

    /**
     * @param array $row
     * @return CreditLogView
     */
    public static function Populate($row)
    {
        $userName = '';
        if (isset($row[ColumnNames::FIRST_NAME])) {
            $userName = new FullName($row[ColumnNames::FIRST_NAME], $row[ColumnNames::LAST_NAME]);
        }

        return new CreditLogView(
            Date::FromDatabase($row[ColumnNames::DATE_CREATED]),
            $row[ColumnNames::CREDIT_NOTE],
            $row[ColumnNames::ORIGINAL_CREDIT_COUNT],
            $row[ColumnNames::CREDIT_COUNT],
            $userName->__toString()
        );
    }
}
