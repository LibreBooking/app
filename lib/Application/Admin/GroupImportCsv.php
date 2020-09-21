<?php
/**
 * Copyright 2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class GroupImportCsvRow
{
    private $values = array();
    private $indexes = array();

    /**
     * @var string
     */
    public $name;
    /**
     * @var bool
     */
    public $autoAdd;
    /**
     * @var string
     */
    public $groupAdministrator;
    /**
     * @var bool
     */
    public $isAdmin;
    /**
     * @var bool
     */
    public $isGroupAdmin;
    /**
     * @var bool
     */
    public $isResourceAdmin;
    /**
     * @var bool
     */
    public $isScheduleAdmin;
    /**
     * @var string[]
     */
    public $members;
    /**
     * @var string[]
     */
    public $permissionsFull;
    /**
     * @var string[]
     */
    public $permissionsRead;

    /**
     * @param $values array
     * @param $indexes array
     */
    public function __construct($values, $indexes)
    {
        $this->values = $values;
        $this->indexes = $indexes;

        $this->name = $this->valueOrDefault('name');
        $this->autoAdd = $this->valueOrFalse('autoAdd');
        $this->groupAdministrator = $this->valueOrDefault('groupAdministrator');
        $this->isAdmin = $this->valueOrFalse('isAdmin');
        $this->isGroupAdmin = $this->valueOrFalse('isGroupAdmin');
        $this->isResourceAdmin = $this->valueOrFalse('isResourceAdmin');
        $this->isScheduleAdmin = $this->valueOrFalse('isScheduleAdmin');
        $this->members = $this->asArray('members');
        $this->permissionsFull = $this->asArray('permissionsFull');
        $this->permissionsRead = $this->asArray('permissionsRead');
    }

    public function IsValid()
    {
        $isValid = !empty($this->name);
        if (!$isValid) {
            Log::Debug('Group import row is not valid. Name %s', $this->name);
        }
        return $isValid;
    }

    /**
     * @param string[] $values
     * @return bool|string[]
     */
    public static function GetHeaders($values)
    {
        $values = array_map('strtolower', $values);

        if (!in_array('name', $values)) {
            return false;
        }

        $indexes['name'] = self::indexOrFalse('name', $values);
        $indexes['autoAdd'] = self::indexOrFalse('is auto add', $values);
        $indexes['groupAdministrator'] = self::indexOrFalse('group administrator', $values);
        $indexes['isAdmin'] = self::indexOrFalse('is application admin', $values);
        $indexes['isGroupAdmin'] = self::indexOrFalse('is group admin', $values);
        $indexes['isResourceAdmin'] = self::indexOrFalse('is resource admin', $values);
        $indexes['isScheduleAdmin'] = self::indexOrFalse('is schedule admin', $values);
        $indexes['members'] = self::indexOrFalse('members', $values);
        $indexes['permissionsFull'] = self::indexOrFalse('full permissions', $values);
        $indexes['permissionsRead'] = self::indexOrFalse('read only permissions', $values);

        return $indexes;
    }

    private static function indexOrFalse($columnName, $values)
    {
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
        return ($this->indexes[$column] === false || !array_key_exists($this->indexes[$column], $this->values)) ? '' : $this->tryToGetEscapedValue($this->values[$this->indexes[$column]]);
    }

    /**
     * @param $column string
     * @return bool
     */
    private function valueOrFalse($column)
    {
        $value = $this->valueOrDefault($column);

        return $value == "true";
    }

    private function tryToGetEscapedValue($v)
    {
        $value = htmlspecialchars(trim($v));
        if (!$value) {
            return trim($v);
        }

        return $value;
    }

    private function asArray($column) {
        return (!array_key_exists($column, $this->indexes) || $this->indexes[$column] === false) ? array() : array_map('trim', explode(',', htmlspecialchars($this->values[$this->indexes[$column]])));
    }
}

class GroupImportCsv
{
    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @var int[]
     */
    private $skippedRowNumbers = array();

    /**
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * @return GroupImportCsvRow[]
     */
    public function GetRows()
    {
        $rows = array();

        $contents = $this->file->Contents();

        $contents = $this->RemoveUTF8BOM($contents);
        $csvRows = preg_split('/\n|\r\n?/', $contents);

        if (count($csvRows) == 0) {
            Log::Debug('No rows in group import file');
            return $rows;
        }

        Log::Debug('%s rows in group import file', count($csvRows));

        $headers = GroupImportCsvRow::GetHeaders(str_getcsv($csvRows[0]));

        if (!$headers) {
            Log::Debug('No headers in group import file');
            return $rows;
        }

        for ($i = 1; $i < count($csvRows); $i++) {
            $values = str_getcsv($csvRows[$i]);

            $row = new GroupImportCsvRow($values, $headers);

            if ($row->IsValid()) {
                $rows[] = $row;
            }
            else {
                Log::Error('Skipped import of group row %s. Values %s', $i, print_r($values, true));
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