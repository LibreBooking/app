<?php
class LdapUser
{
	private $fname;
	private $lname;
	private $mail;
	private $phone;
	private $institution;
	private $title;
	
	public function __construct($entry)
	{
		$this->fname = $entry['givenname'][0];
        $this->lname = $entry['sn'][0];
        $this->mail = strtolower( $entry['mail'][0] );        
        $this->phone = isset($entry['telephonenumber']) ? $entry['telephonenumber'][0] : '';
        $this->institution = isset($entry['physicaldeliveryofficename']) ? $entry['physicaldeliveryofficename'] : ''; 
        $this->title = isset($entry['title']) ? $entry['title'][0] :  '';	
	}
	
	public function GetFirstName()
	{
		return $this->fname;
	}
	
	public function GetLastName()
	{
		return $this->lname;
	}
	
	public function GetEmail()
	{
		return $this->mail;
	}
	
	public function GetPhone()
	{
		return $this->phone;
	}
	
	public function GetInstitution()
	{
		return $this->institution;
	}
	
	public function GetTitle()
	{
		return $this->title;
	}
}
?>