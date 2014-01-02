{*
Copyright 2011-2014 Nick Korbel

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
*}
<script type="text/javascript">
$(function(){
  $("#{$ControlId}").datepicker({ldelim}
		 numberOfMonths: {$NumberOfMonths},
		 showButtonPanel: {$ShowButtonPanel},
		 onSelect: {$OnSelect},
		 dayNames: {$DayNames},
		 dayNamesShort: {$DayNamesShort},
		 dayNamesMin: {$DayNamesMin},
		 dateFormat: '{$DateFormat}',
		 {if $FirstDay >=0 && $FirstDay <= 6}
	  		firstDay: {$FirstDay},
		 {/if}
		 monthNames: {$MonthNames},
		 monthNamesShort: {$MonthNamesShort},
		 currentText: "{translate key='Today'}"
	  	 {if $AltId neq ''}
		   ,
	  		altField: "#{$AltId}",
	  	 	altFormat: '{$AltFormat}'
		  {/if}
  {rdelim});

  {if $AltId neq ''}
	$("#{$ControlId}").change(function() {
 		if ($(this).val() == '') {
			$("#{$AltId}").val('');
		}
		else{
			var dateVal = $("#{$ControlId}").datepicker('getDate');
			var dateString = dateVal.getFullYear() + '-' + ('0' + (dateVal.getMonth()+1)).slice(-2) + '-' + ('0' + dateVal.getDate()).slice(-2);
			$("#{$AltId}").val(dateString);
		}
  	});
  {/if}

});
</script>