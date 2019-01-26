{*
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
*}
{function name=datePickerDateFormat}
new Date({$date->Year()}, {$date->Month()-1}, {$date->Day()})
{/function}
<script type="text/javascript">
    $(function () {
        $("#{$ControlId}").{if $HasTimepicker}datetimepicker{else}datepicker{/if}({ldelim}
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
            currentText: "{{translate key='Today'}|escape:'javascript'}",
            timeFormat: "{$TimeFormat}",
            altFieldTimeOnly: false,
            controlType: 'select'
            {if $AltId neq ''}
            ,
            altField: "#{$AltId}",
            altFormat: '{$AltFormat}'
            {/if}
            {if $DefaultDate}
            ,
            defaultDate: {datePickerDateFormat date=$DefaultDate}
            {/if}
            {if $MinDate}
            ,
            minDate: {datePickerDateFormat date=$MinDate->AddDays(1)}
            {/if}
            {if $MaxDate}
            ,
            maxDate: {datePickerDateFormat date=$MaxDate->AddDays(1)}
            {/if}
            {rdelim});

        {if $AltId neq ''}
        $("#{$ControlId}").change(function () {
            if ($(this).val() == '') {
                $("#{$AltId}").val('');
            }
            else {
                var dateVal = $("#{$ControlId}").{if $HasTimepicker}datetimepicker{else}datepicker{/if}('getDate');
                var dateString = dateVal.getFullYear() + '-' + ('0' + (dateVal.getMonth() + 1)).slice(-2) + '-' + ('0' + dateVal.getDate()).slice(-2);
                {if $HasTimepicker}
                dateString = dateString + ' ' + dateVal.getHours() + ':' + dateVal.getMinutes();
                {/if}
                $("#{$AltId}").val(dateString);
            }
        });
        {/if}

    });
</script>