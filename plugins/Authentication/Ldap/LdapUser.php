<?php
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
        $this->phone = isset($entry->telephonenumber) ? $entry->telephonenumber : '';
        $this->institution = isset($entry->physicaldeliveryofficename) ? $entry->physicaldeliveryofficename : '';
        $this->title = isset($entry->title) ? $entry->title : '';
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