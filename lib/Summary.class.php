<?php
/**
* Formats and truncates reservation summaries for display on the schedule
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-06-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

class Summary
{
	var $visible = false;
	var $user_name = '';
	var $text = '';
	
	var $EMPTY_SUMMARY = '&nbsp;';
	
	function Summary($text) {
		$this->text = $text;
	}
	
	function toScheduleCell($available_chars = -1) {
		$summary = $this->EMPTY_SUMMARY;
		
		if ($available_chars == -1 || $available_chars > $this->getSize()) {
			$available_chars = $this->getSize();
		}
		
		if ($this->isVisible()) {
			if (!empty($this->user_name) && strlen($this->user_name) >= $available_chars) {
				$summary = substr($this->user_name, 0, $available_chars);
			}
			else if (!empty($this->user_name) && $this->getSize() >= $available_chars) {
				$summary = "{$this->user_name}\n<i>" . htmlspecialchars(substr($this->text, 0, $available_chars - strlen($this->user_name))) . '</i>';
			}
			else {
				$summary = htmlspecialchars(substr($this->text, 0, $available_chars));
			}
			
			if ($this->getSize() > $available_chars && $available_chars > 0) {
				$summary .= '...';
			}
		}
		
		return $summary;
	}
	
	function toScheduleHover() {
		if (!$this->isVisible()) {
			return $this->EMPTY_SUMMARY;
		}
		if (!empty($this->user_name)) {
			return "{$this->user_name}\n<i>" . htmlspecialchars($this->text) . '</i>';
		}
		else {
			return htmlspecialchars($this->text);
		}		
	}
	
	function getSize() {
		return strlen($this->user_name) + strlen($this->text);
	}
	
	function isVisible() {
		return $this->visible && ( strlen($this->text) + strlen($this->user_name) ) > 0;
	}
}
?>