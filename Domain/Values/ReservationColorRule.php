<?php

class ReservationColorRule
{
    public $Id;
    public $AttributeId;
    public $AttributeType;
    public $AttributeName = 'Reservation Type';
    public $RequiredValue = 'a specific value';
    public $ComparisonType;
    public $Color = 'a32ca3';

    /**
     * @param int $attributeId
     * @param string $requiredValue
     * @param string $color
     * @return ReservationColorRule
     */
    public static function Create($attributeId, $requiredValue, $color)
    {
        $rule = new ReservationColorRule();

        $rule->AttributeId = $attributeId;
        $rule->RequiredValue = $requiredValue;
        $rule->Color = $color;

        return $rule;
    }

    /**
     * @param array $row
     * @return ReservationColorRule
     */
    public static function FromRow($row)
    {
        $rule = self::Create($row[ColumnNames::ATTRIBUTE_ID], $row[ColumnNames::REQUIRED_VALUE], $row[ColumnNames::RESERVATION_COLOR]);
        $rule->AttributeName = $row[ColumnNames::ATTRIBUTE_LABEL];
        $rule->Id = $row[ColumnNames::RESERVATION_COLOR_RULE_ID];

        return $rule;
    }

    public function IsSatisfiedBy(ReservationItemView $reservation)
    {
        $value = $reservation->Attributes->Get($this->AttributeId);
        if (!empty($value)) {
            return $value == $this->RequiredValue;
        }

        return false;
    }
}
