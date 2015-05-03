<?php
/**
Copyright 2011-2015 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/


/**
 * Producing mySql query string
 */
class MySqlScript {

    /**
     * @var string
     */
    private $path;

    /**
     * @var array|string[]
     */
    private $tokens = array();

    public function __construct($path) {
        $this->path = $path;
    }

    /**
     * Return the mySql script files directory path
     * $param null
     * @return string path to directory where mySql script are located
     */
    public function Name() {
        return $this->path;
    }

    /**
     * Replace the default string values
     * @param string $search databasename, username, etc ...
     * @param string $replace configured databasename, configured username, etc ...
     */
    public function Replace($search, $replace) {
        $this->tokens[$search] = $replace;
    }

    /**
     * Contruct and return mySql statement string
     * @param null
     * @return string $sql query string
     */
    public function GetFullSql() {
        $f = fopen($this->path, "r");
        $sql = fread($f, filesize($this->path));
        fclose($f);

        foreach ($this->tokens as $search => $replace) {
            $sql = str_replace($search, $replace, $sql);
        }

        return $sql;
    }

}
?>