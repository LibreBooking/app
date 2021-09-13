<?php

class ReservationImportCsvRow
{
    public $email;
    public $resourceNames = [];
    public $title;
    public $description;
    public $begin;
    public $end;
    public $attributes = [];

    private $values = [];
    private $indexes = [];

    /**
     * @param $values array
     * @param $indexes array
     * @param $attributes CustomAttribute[]
     */
    public function __construct($values, $indexes, $attributes)
    {
        $this->values = $values;
        $this->indexes = $indexes;

        $this->email = strtolower($this->valueOrDefault('email'));
        $this->resourceNames = (!array_key_exists('resourceNames', $this->indexes) || $indexes['resourceNames'] === false) ? []
                        : array_map('trim', explode(',', htmlspecialchars($values[$indexes['resourceNames']])));
        $this->title = $this->valueOrDefault('title');
        $this->description = $this->valueOrDefault('description');
        $this->begin = $this->valueOrDefault('begin');
        $this->end = $this->valueOrDefault('end');

        foreach ($attributes as $label => $attribute) {
            $this->attributes[$label] = $this->valueOrDefault($label);
        }
    }

    public function IsValid()
    {
        $isValid = !empty($this->email) && !empty($this->resourceNames) && !empty($this->begin) && !empty($this->end);
        if (!$isValid) {
            Log::Debug('Reservation import row is not valid. Missing email, resource or dates');
        }
        return $isValid;
    }

    /**
     * @param string[] $values
     * @param CustomAttribute[] $attributes
     * @return bool|string[]
     */
    public static function GetHeaders($values, $attributes)
    {
        if (!in_array('email', $values) || !in_array('resource names', $values) || !in_array('begin', $values) || !in_array('end', $values)) {
            return false;
        }

        $indexes['email'] = self::indexOrFalse('email', $values);
        $indexes['resourceNames'] = self::indexOrFalse('resource names', $values);
        $indexes['title'] = self::indexOrFalse('title', $values);
        $indexes['description'] = self::indexOrFalse('description', $values);
        $indexes['begin'] = self::indexOrFalse('begin', $values);
        $indexes['end'] = self::indexOrFalse('end', $values);

        foreach ($attributes as $label => $attribute) {
            $escapedLabel = str_replace('\'', '\\\\', $label);
            $indexes[$label] = self::indexOrFalse($escapedLabel, $values);
        }

        return $indexes;
    }

    private static function indexOrFalse($columnName, $values)
    {
        $values = array_map('strtolower', $values);
        $index = array_search($columnName, $values);
        if ($index === false) {
            return false;
        }

        return intval($index);
    }

    /**
     * @param $column string
     * @return string
     */
    private function valueOrDefault($column)
    {
        return ($this->indexes[$column] === false ||
                !array_key_exists($this->indexes[$column], $this->values)) ? ''
                : htmlspecialchars(trim($this->values[$this->indexes[$column]]));
    }
}

class ReservationImportCsv
{
    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @var int[]
     */
    private $skippedRowNumbers = [];

    /**
     * @var CustomAttribute[]
     */
    private $attributes;

    /**
     * @param UploadedFile $file
     * @param CustomAttribute[] $attributes
     */
    public function __construct(UploadedFile $file, $attributes)
    {
        $this->file = $file;
        $this->attributes = $attributes;
    }

    /**
     * @return ReservationImportCsvRow[]
     */
    public function GetRows()
    {
        $rows = [];

        $contents = $this->file->Contents();

        $contents = $this->RemoveUTF8BOM($contents);
        $csvRows = preg_split('/\n|\r\n?/', $contents);

        if (count($csvRows) == 0) {
            Log::Debug('No rows in reservation import file');
            return $rows;
        }

        Log::Debug('%s rows in reservation import file', count($csvRows));

        $headers = ReservationImportCsvRow::GetHeaders(str_getcsv($csvRows[0]), $this->attributes);

        if (!$headers) {
            Log::Debug('No headers in reservation import file');
            return $rows;
        }

        for ($i = 1; $i < count($csvRows); $i++) {
            $values = str_getcsv($csvRows[$i]);

            $row = new ReservationImportCsvRow($values, $headers, $this->attributes);

            if ($row->IsValid()) {
                $rows[] = $row;
            } else {
                Log::Error('Skipped import of reservation row %s. Values %s', $i, print_r($values, true));
                $this->skippedRowNumbers[] = $i;
            }
        }

        return $rows;
    }

    /**
     * @return int[]
     */
    public function GetSkippedRowNumbers()
    {
        return $this->skippedRowNumbers;
    }

    private function RemoveUTF8BOM($text)
    {
        return str_replace("\xEF\xBB\xBF", '', $text);
    }
}
