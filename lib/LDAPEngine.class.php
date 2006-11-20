<?php
/**
* LDAPEngine class
* @author David Poole <David.Poole@fccc.edu>
* @author William P.O'Sullivan
* @version 05-18-06
* @package LDAPEngine
*
* Copyright (C) 2004 phpScheduleIt
* License: GPL, see LICENSE
*/
$basedir = dirname(__FILE__) . '/..';

include_once($basedir . '/lib/CmnFns.class.php');

class LDAPEngine {

	var $host;
	var $port;
	var $basedn;

	var $binddn;
    var $ldap;
    var $connected;

    var $uid;
    var $fname;
    var $lname;
    var $mail;
    var $phone;
    var $institution;
    var $title;
	var $password;

	/**
	 * Added by POS
	 */
	var $AD_lookupid;		// LDAP lookup dn
	var $AD_lookuppwd;		// LDAP lookup password

	/**
	* LDAPEngine constructor to initialize object
	* @param string $uid user id
	* @param string $password password associated with uid
	*/
	function LDAPEngine( $uid, $password ) {
	   global $conf;

	   $this->connected = false;

	   if( strlen( $uid ) == 0 || strlen( $password ) == 0 ) {
	   	  return;
	   }

	   $this->host = $conf['ldap']['host'];
	   $this->port = $conf['ldap']['port'];
	   $this->basedn = $conf['ldap']['basedn'];
	   $this->AD_lookupid = $conf['ldap']['lookupid'];
	   $this->AD_lookuppwd = $conf['ldap']['lookuppwd'];

	   $this->ldap = ldap_connect( $this->host, $this->port ) or die( "Could not connect to LDAP server." );

	   $this->uid = $uid;

	   if( $this->ldap ) {

			$bind = @ldap_bind( $this->ldap, $this->AD_lookupid, $this->AD_lookuppwd );

	       	if( $bind ) {

	            // System authentication was a success, lookup user's dn via uid= filter
				$result = ldap_search( $this->ldap, $this->basedn, "uid"."=".$this->uid);
				if (ldap_count_entries($this->ldap, $result)<=0) {
					print "<p>LDAPEngine: Search in LDAP failed. uid=$this->uid<p>";
					ldap_close( $this->ldap );
					return;
				} else {
					$this->binddn = ldap_get_dn($this->ldap, ldap_first_entry($this->ldap, $result));
					//print "<p>LDAPEngine: User binding as dn=".$this->binddn."<p>";
					$bind2 = @ldap_bind( $this->ldap, $this->binddn, $password );
					if ($bind2) {
						//print "<p>LDAPEngine: bind using user credentials successful.</p>";
					} else {
						//print "<p>LDAPEngine: bind using user credentials failed.</p>";
						ldap_close( $this->ldap );
						return;
					}
				}
				// ------------------------------------

				if( $this->loadUserData() ) {
				   $this->connected = true;
				   $this->password = $password;
				} else {
				   ldap_close( $this->ldap );
				}

            } else {
				die("LDAPEngine: Attempt to bind to:".$this->host." using systemid:".$this->lookupid." failed.");
                ldap_close( $this->ldap );
            }
        }

    }

    /**
	* Disconnects from the LDAP server
	* @param none
	*/
    function disconnect() {
        if( $this->connected ) {
            ldap_close( $this->ldap );
            $this->connected = false;
        }
    }

	/**
	* Queries LDAP for user information
	* @return boolean indicating success or failure
	*/
	function loadUserData() {

		$attributes = array( "sn", "givenname", "mail", "telephonenumber", "physicaldeliveryofficename", "title" );

        $result = ldap_search( $this->ldap, $this->binddn, "uid=". $this->uid, $attributes );
        $entries = ldap_get_entries( $this->ldap, $result );

        if( $result and ( $entries["count"] == 1 ) ) {
            $this->fname = $entries[0]['givenname'][0];
            $this->lname = $entries[0]['sn'][0];
            $this->mail = strtolower( $entries[0]['mail'][0] );

            $this->phone = isset($entries[0]['telephonenumber']) ? $entries[0]['telephonenumber'][0] : '';
            if ( isset($entries[0]['physicaldeliveryofficename']) ) {
            	$this->institution = $entries[0]['physicaldeliveryofficename'][0];
            } else {
            	$this->institution = "";
            }
            if ( isset($entries[0]['title']) ) {
            	$this->title = $entries[0]['title'][0];
            } else {
            	$this->title = "";
            }
        } else {
            return false;
        }

	   return true;

	}

    /**
	* Returns user information
	* @return array containing user information
	*/
    function getUserData() {
		global $conf;

        $return = array(
            'fname' => $this->fname,
            'lname' => $this->lname,
            'emailaddress' => $this->mail,
            'phone' => $this->phone,
            'institution' => $this->institution,
			'title' => $this->title,
            'logon_name' => $this->uid,
            'password' => $this->password,
            'password2' => $this->password,
            'position' => null,
            'institution' => null,
            'lang' => $conf['app']['defaultLanguage'],
			'timezone' => $conf['app']['timezone']
        );

        return $return;

    }

    /**
	* Gets user's mail attribute.
	* @return string user's email address
	*/
	function getUserEmail( ) {
	  	return $this->mail;
    }

    /**
	* See if the user was authenticated.
	* @return boolean authenication success of failure
	*/
	function connected( ) {
	  	return $this->connected;
    }
}
?>