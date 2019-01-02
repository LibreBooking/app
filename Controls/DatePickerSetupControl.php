<?php
/**
Copyright 2011-2019 Nick Korbel

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

require_once(ROOT_DIR . 'Controls/Control.php');

class DatePickerSetupControl extends Control
{
	public function __construct(SmartyPage $smarty)
	{
		parent::__construct($smarty);
	}

	public function PageLoad()
	{
		$this->SetDefault('NumberOfMonths', 1);
		$this->SetDefault('ShowButtonPanel', 'false');
		$controlId = $this->Get("ControlId");
		$controlId = str_replace(']', '\\\\]', str_replace('[', '\\\\[', $controlId));
		$altId = $this->Get('AltId');

        $elementsToTrigger = '#' . $controlId;
        if (!empty($altId))
        {
			$altId = str_replace(']', '\\\\]', str_replace('[', '\\\\[', $altId));
            $elementsToTrigger .= ",#$altId";
        }

		$this->Set('ControlId', $controlId);
		$this->Set('AltId', $altId);

		$this->SetDefault('OnSelect', sprintf("function() { $('%s').trigger('change'); }", $elementsToTrigger));
		$this->SetDefault('FirstDay', 0);

		$hasTimepicker = $this->Get('HasTimepicker');
		$this->Set('HasTimepicker', $hasTimepicker);
		$this->Set('DateFormat', Resources::GetInstance()->GetDateFormat('general_date_js'));
		$this->Set('TimeFormat', Resources::GetInstance()->GetDateFormat('general_time_js'));
		$this->Set('AltFormat', Resources::GetInstance()->GetDateFormat($hasTimepicker ? 'js_general_datetime' : 'js_general_date'));
		$this->Set('DayNamesMin', $this->GetJsDayNames('two'));
		$this->Set('DayNamesShort', $this->GetJsDayNames('abbr'));
		$this->Set('DayNames', $this->GetJsDayNames('full'));
		$this->Set('MonthNames', $this->GetJsMonthNames('full'));
		$this->Set('MonthNamesShort', $this->GetJsMonthNames('abbr'));
		$this->SetDefault('MinDate', null);
		$this->SetDefault('MaxDate', null);

		$this->Display('Controls/DatePickerSetup.tpl');
	}

	private function SetDefault($key, $value)
	{
		$item = $this->Get($key);
		if ($item == null)
		{
			$this->Set($key, $value);
		}
	}
	private function GetJsDayNames($dayKey)
	{
		return $this->GetJsArrayValues(Resources::GetInstance()->GetDays($dayKey));
	}

	private function GetJsMonthNames($monthKey)
	{
		return $this->GetJsArrayValues(Resources::GetInstance()->GetMonths($monthKey));
	}

	private function GetJsArrayValues($values)
	{
		return "['" . implode("','", $values) . "']";
	}
}