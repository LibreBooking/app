<?php

class CsvImportResult
{
    public $importCount = 0;
    public $skippedRows = array();
    public $messages = array();

    /**
     * @param $imported int
     * @param $skippedRows int[]
     * @param $messages string|string[]
     */
    public function __construct($imported, $skippedRows, $messages)
    {
        $this->importCount = $imported;
        $this->skippedRows = $skippedRows;
        $this->messages = is_array($messages) ? $messages : array($messages);
    }
}
