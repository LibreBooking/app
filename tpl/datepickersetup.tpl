  $("#{$ControlId}").datepicker({ldelim} 
		 defaultDate: new Date({$DefaultDate->Year()}, {$DefaultDate->Month()-1}, {$DefaultDate->Day()}),
		 numberOfMonths: {$NumberOfMonths},
		 showButtonPanel: {$ShowButtonPanel},
		 onSelect: {$OnSelect},
  {rdelim});