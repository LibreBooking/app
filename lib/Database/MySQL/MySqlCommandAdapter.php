<?php

class MySqlCommandAdapter
{
    private $_values = null;
    private $_query = null;
    private $_db = null;

    public function __construct(ISqlCommand &$command, $db)
    {
        $this->_values = [];
        $this->_query = null;
        $this->_db = $db;

        $this->Convert($command);
    }

    public function GetValues()
    {
        return $this->_values;
    }

    public function GetQuery()
    {
        return $this->_query;
    }

    private function Convert(SqlCommand &$command)
    {
        $query = $command->GetQuery();

        for ($p = 0; $p < $command->Parameters->Count(); $p++) {
            $curParam = $command->Parameters->Items($p);

            if (is_null($curParam->Value)) {
                $query = str_replace($curParam->Name, 'null', $query);
            }
            if (is_array($curParam->Value)) {
                $escapedValues = [];
                foreach ($curParam->Value as $value) {
                    $escapedValues[] = mysqli_real_escape_string($this->_db, $value ?? '');
                }
                $values = implode("','", $escapedValues);
                $inClause = "'$values'";
                $query = str_replace($curParam->Name, $inClause, $query);
            } else {
                $escapedValue = mysqli_real_escape_string($this->_db, $curParam->Value ?? '');
                $query = str_replace($curParam->Name, $curParam->QuotedValue($escapedValue), $query);
            }
        }

        $this->_query = $query . ';';
    }
}
