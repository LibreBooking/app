<?php
require_once(ROOT_DIR . 'Controls/Control.php');

class DatePickerSetupControl extends Control
{
	public function __construct(SmartyPage $smarty)
	{
		parent::__construct($smarty);
	}
	
	public function PageLoad()
	{
		$this->SetDefault('DefaultDate', Date::Now());
		$this->SetDefault('NumberOfMonths', 1);
		$this->SetDefault('ShowButtonPanel', 'false');
		$this->SetDefault('OnSelect', sprintf("function() { $('#%s').trigger('change'); }", $this->Get("ControlId")));		
		$this->SetDefault('FirstDay', 0);		
		
		$this->Set('DateFormat', Resources::GetInstance()->GetDateFormat('js_general_date'));
		$this->Set('DayNamesMin', $this->GetJsDayNames('two'));
		$this->Set('DayNamesShort', $this->GetJsDayNames('abbr'));
		$this->Set('DayNames', $this->GetJsDayNames('full'));
		$this->Set('MonthNames', $this->GetJsMonthNames('full'));
		$this->Set('MonthNamesShort', $this->GetJsMonthNames('abbr'));
		
		$this->smarty->display('Controls/DatePickerSetup.tpl');		
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
?>