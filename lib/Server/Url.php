<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

class Url
{
    /**
     * @var string
     */
    private $url = '';

    /**
     * @var bool
     */
    private $hasQuestionMark = false;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->hasQuestionMark = strpos($url, '?') !== false;
    }

    /**
     * @param string $name
     * @param string $value
     * @return Url
     */
    public function AddQueryString($name, $value)
    {
        $char = '?';
        if ($this->hasQuestionMark)
        {
            $char = '&';
        }

        $this->hasQuestionMark = true;
        $this->url .= sprintf("$char%s=%s", $name, urlencode($value));

        return $this;
    }

    /**
     * @return string
     */
    public function ToString()
    {
        return $this->__toString();
    }

    public function __toString()
    {
        return $this->url;
    }
}

?>