<?php
/**
Copyright 2011-2012 Nick Korbel

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

/**
 * Ldap user class
 */

class LdapUser {

    private $fname;
    private $lname;
    private $mail;
    private $phone;
    private $institution;
    private $title;

	/**
	 * @param adLDAPUserCollection $entry
	 */
    public function __construct($entry) {
        $this->fname = $entry->givenname;
        $this->lname = $entry->sn;
        $this->mail = strtolower($entry->mail);
        $this->phone = $entry->telephonenumber;
        $this->institution = $entry->physicaldeliveryofficename;
        $this->title = $entry->title;
    }

    public function GetFirstName() {
        return $this->fname;
    }

    public function GetLastName() {
        return $this->lname;
    }

    public function GetEmail() {
        return $this->mail;
    }

    public function GetPhone() {
        return $this->phone;
    }

    public function GetInstitution() {
        return $this->institution;
    }

    public function GetTitle() {
        return $this->title;
    }

}

?>