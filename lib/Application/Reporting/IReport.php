<?php

interface IReport
{
    /**
     * @abstract
     * @return IReportColumns
     */
    public function GetColumns();

    /**
     * @abstract
     * @return IReportData
     */
    public function GetData();

    /**
     * @abstract
     * @return int
     */
    public function ResultCount();
}
