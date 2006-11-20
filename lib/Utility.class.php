<?php
/**
* Utility class
* Provides basic utility functions needed in multiple different locations
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 02-18-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/
class Utility
{
	function Utility() { }
	
	/**
	* Returns a query string that will allow the user to sort on the given order in the opposite direction
	* @param string $query_string the full current query string to parse
	* @param string $desired_order the desired sort order of the new result set
	* @param string $vert_key the query string key name of the vertical sort order
	* @param string $order_key the query string key name of the column sort order
	* @return the full query string with the correct order key/value and vertical key/value including the question mark
	*/
	function getSortingUrl($query_string, $desired_order, $vert_key = 'vert', $order_key = 'order') {
		$query_string = str_replace('?' ,'', $query_string);	// Get rid of the ? to simplify the regexes
		$return_query = $query_string;
		
		$query_pairs = $this->_buildPairs($query_string);
		
		$is_desired_order = false;
		$desired_vert = 'ASC';		// New sort order, always use ASC
		
		if (array_key_exists($order_key, $query_pairs)) {
			// Figure out the current order
			$cur_order = $query_pairs[$order_key];
			$is_desired_order = ($cur_order == $desired_order);
			
			// If it is already in the desired order, just flip the vert
			if (!$is_desired_order) {
				$query_pairs[$order_key] = $desired_order;
			}
		}
		else {
			// No order is in the current query string, so we can just append
			$query_pairs[$order_key] = $desired_order;
		}
			
		if (array_key_exists($vert_key, $query_pairs)) {
			// Figure out current vert order
			$cur_vert = $query_pairs[$vert_key];
			
			if ($is_desired_order) {
				// It's in the correct order, just flip the vert
				$desired_vert = $this->_flipVert($cur_vert);
			}
			
			$query_pairs[$vert_key] = $desired_vert;
		}
		else {
			// No order is in the current query string, so we can just append
			$query_pairs[$vert_key] = $desired_vert;
		}		
		
		$return = '';
		foreach ($query_pairs as $param => $value) {
			$return .= "$param=$value&amp;";
		}
		
		return '?' . substr($return, 0, strlen($return) - 5);		// Remove the ending &amp;
	}
	
	/**
	* Takes a query string and builds the pairs of paramaters in a hash with param name as the key and the param value as the hash value
	* @param string $query_string the query string to parse
	* @return array of query string parameter pair values
	*/
	function _buildPairs($query_string) {
		$pairs = array();
		
		if (empty($query_string)) {
			return $pairs;
		}
		
		$query_string = str_replace('?' ,'', $query_string);	// Get rid of the ? because it will screw up the pairs
		
		$query_params = explode('&', $query_string);
		
		for ($i = 0; $i < count($query_params); $i++) {
			list($key, $value) = explode('=', $query_params[$i]);
			$pairs[$key] = $value;
		}
		
		return $pairs;
	}
	
	/**
	* Takes a SQL vertical sorting keyword and flips it to the opposite direction
	* @param string $cur_vert the current sorting direction keyword
	* @return the opposite direction SQL sorting keyword
	*/
	function _flipVert($cur_vert) {
		$flipped_vert = 'ASC';
		
		if (strtoupper($cur_vert) == 'ASC') {
			$flipped_vert = 'DESC';
		}
		
		return $flipped_vert;
	}
	
		
	/**
	* Gets an array of resource ids to add to this reservation
	* @param array $orig the array of items who were originally in the list
	* @param array $selected the array of currently selected items
	* @return array of items is to add to the original list
	*/
	function getAddedItems($orig, $selected) {
		$added = array();
		
		if ( !is_null($orig) && count($orig) > 0 ) {
			$diff = array_diff($selected, $orig);
			foreach($diff as $idx => $val) {
				$added[] = $val;
			}
		}
		else {
			$added = $selected;
		}
		
		return $added;
	}
	
	/**
	* Gets an array of resource ids to remove from this reservation
	* @param array $orig the array of items who were originally in the list
	* @param array $selected the array of currently selected items
	* @return array of items to remove from the original list
	*/
	function getRemovedItems($orig, $selected) {
		$removed = array();
		
		if ( !is_null($orig) && count($orig) > 0 ) {
			$diff = array_diff($orig, $selected);
			foreach($diff as $idx => $val) {
				$removed[] = $val;
			}
		}
		
		return $removed;
	}
}
?>