<?php
/**
* ReservationHelper class provides helper functions for reservation creation/parsing/etc
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 02-02-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/
class ReservationHelper
{
	function ReservationHelper() { }
	
	/**
	* Returns all the users who should be removed
	* @param array $orig the POST-ed array of users who were originally on the reservation
	* @param array $invited the POST-ed array of users in the invited list
	* @return array hashtable with memberid as the key and the email address as the value
	*/
	function getRowsForInvitation($orig, $invited) {
		$to_invite = array();
		
		if ( is_null($orig) || empty($orig) ){	// If there are no original users, all users should be invited
			$invited_array = $invited;
		}
		else {
			$invited_array = array_diff($invited, $orig);
		}
		
		foreach($invited_array as $idx => $val) {
			$invited_parts = explode('|', $val);
			$to_invite[$invited_parts[0]] = $invited_parts[1];
		}
		
		return $to_invite;
	}
	
	/**
	* Returns all the users who should be removed
	* @param array $orig the POST-ed array of users who were originally on the reservation
	* @param array $removed the POST-ed array of users in the removed list
	* @param array $invited the POST-ed array of users in the invited list
	* @return array hashtable with memberid as the key and the email address as the value
	*/
	function getRowsForRemoval($orig, $removed, $invited) {
		$to_remove = array();
		
		for ($i = 0; $i < count($removed); $i++) {
			// All users in the explicit removed list should be added
			$removed_parts = explode('|', $removed[$i]);
			$to_remove[$removed_parts[0]] = $removed_parts[1];
		}
		
		if ( !is_null($orig) && !empty($orig) ) {	// If there are no original users, then there are none to uninvite
			// If the user was in the original list but it now not in the invited list, remove them
			$removed_array = array_diff($orig, $invited);
			foreach($removed_array as $idx => $val) {
				$removed_parts = explode('|', $val);
				$to_remove[$removed_parts[0]] = $removed_parts[1];
			}
		}
		
		return $to_remove;
	}
	
	/**
	* Returns all the users who have no status change at all
	* @param array $orig the POST-ed array of users who were originally on the reservation
	* @param array $invited the POST-ed array of users in the invited list
	* @return array hashtable with memberid as the key and the email address as the value
	*/
	function getUnchangedUsers($orig, $invited) {
		$unchanged = array();
		
		if (!is_null($orig) && !empty($orig) && !is_null($invited) && !empty($invited)) {
			$common = array_intersect($orig, $invited);
			foreach($common as $idx => $val) {
				$parts = explode('|', $val);
				$unchanged[$parts[0]] = $parts[1];
			}
		}
		
		return $unchanged;
	}
}
?>