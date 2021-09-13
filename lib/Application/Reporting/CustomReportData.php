<?php

require_once(ROOT_DIR . 'lib/Application/Reporting/namespace.php');

class CustomReportData implements IReportData
{
    private $rows;

    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    public function Rows()
    {
        return $this->rows;
    }
}
