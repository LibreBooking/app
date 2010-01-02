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
		$this->smarty->assign('DateFormat', Resources::GetInstance()->GetDateFormat('js_general_date'));
		$this->smarty->assign('DayNamesMin', $this->GetJsDayNames('two'));
		$this->smarty->assign('DayNamesShort', $this->GetJsDayNames('abbr'));
		$this->smarty->assign('DayNames', $this->GetJsDayNames('full'));
		$this->smarty->assign('MonthNames', $this->GetJsMonthNames('full'));
		$this->smarty->assign('MonthNamesShort', $this->GetJsMonthNames('abbr'));
		
		$this->smarty->display('Controls/DatePickerSetup.tpl');		
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