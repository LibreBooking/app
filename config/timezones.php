<?php
AddTimezone('US/Samoa', -11, 'Samoa');
AddTimezone('US/Hawaii', -10, 'Hawaii');
AddTimezone('US/Alaska', -9, 'Alaska');
AddTimezone('US/Pacific', -8, 'Pacific');
AddTimezone('America/Tijuana', -8, 'Tijuana');
AddTimezone('US/Arizona', -7, 'Arizona');
AddTimezone('America/Mazatlan', -7, 'Mazatlan');
AddTimezone('US/Mountain', -7, 'US/Mountain');
AddTimezone('US/Central', -6, 'US/Central');
AddTimezone('America/Monterrey', -6, 'Monterrey');
AddTimezone('Canada/Saskatchewan', -6, 'Saskatchewan');
AddTimezone('America/Bogota', -6, 'Bogota');
AddTimezone('US/Eastern', -5, 'US/Eastern');
AddTimezone('US/East-Indiana', -5, 'US/East-Indiana');
AddTimezone('America/Caracas', -4.5, 'Caracas');
AddTimezone('Canada/Atlantic', -4, 'Canada/Atlantic');
AddTimezone('America/La_Paz', -4, 'La Paz');
AddTimezone('America/Santiago', -4, 'Santiago');
AddTimezone('Canada/Newfoundland', -3.5, 'Newfoundland');
AddTimezone('America/Montevideo', -3, 'Montevideo');
AddTimezone('Atlantic/Azores', -1, 'Azores');
AddTimezone('Atlantic/Cape_Verde', -1, 'Cape Verde');
AddTimezone('Africa/Casablanca', 0, 'Casablanca');
AddTimezone('GMT', 0, 'Greenwich Mean Time');
AddTimezone('Europe/Amsterdam', 1, 'Amsterdam');
AddTimezone('Europe/Belgrade', 1, 'Belgrade');
AddTimezone('Europe/Brussels', 1, 'Brussels');
AddTimezone('Europe/Sarajevo', 1, 'Sarajevo');
AddTimezone('Asia/Amman', 2, 'Amman');
AddTimezone('Europe/Athens', 2, 'Athens');
AddTimezone('Asia/Beirut', 2, 'Beirut');
AddTimezone('Africa/Cairo', 2, 'Cairo');
AddTimezone('Africa/Harare', 2, 'Harare');
AddTimezone('Europe/Helsinki', 2, 'Helsinki');
AddTimezone('Asia/Jerusalem', 2, 'Jerusalem');
AddTimezone('Europe/Minsk', 2, 'Minsk');
AddTimezone('Africa/Windhoek', 2, 'Windhoek');
AddTimezone('Asia/Baghdad', 3, 'Baghdad');
AddTimezone('Asia/Kuwait', 3, 'Kuwait');
AddTimezone('Europe/Moscow', 3, 'Moscow');
AddTimezone('Africa/Nairobi', 3, 'Nairobi');
AddTimezone('Asia/Tbilisi', 3, 'Tbilisi');
AddTimezone('Asia/Tehran', 3.5, 'Tehran');
AddTimezone('Asia/Muscat', 4, 'Muscat');
AddTimezone('Asia/Baku', 4, 'Baku');
AddTimezone('Asia/Yerevan', 4, 'Yerevan');
AddTimezone('Asia/Kabul', 4.5, 'Kabul');
AddTimezone('Asia/Yekaterinburg', 5, 'Yekaterinburg');
AddTimezone('Asia/Karachi', 5, 'Karachi');
AddTimezone('Asia/Almaty', 6, 'Almaty');
AddTimezone('Asia/Dhaka', 6, 'Dhaka');
AddTimezone('Asia/Rangoon', 6.5, 'Rangoon');
AddTimezone('Asia/Bangkok', 7, 'Bangkok');
AddTimezone('Asia/Krasnoyarsk', 7, 'Krasnoyarsk');
AddTimezone('Asia/Hong_Kong', 8, 'Hong Kong');
AddTimezone('Asia/Irkutsk', 8, 'Irkutsk');
AddTimezone('Asia/Kuala_Lumpur', 8, 'Kuala Lumpur');
AddTimezone('Australia/Perth', 8, 'Perth');
AddTimezone('Asia/Taipei', 8, 'Taipei');
AddTimezone('Asia/Tokyo', 9, 'Tokyo');
AddTimezone('Asia/Seoul', 9, 'Seoul');
AddTimezone('Asia/Yakutsk', 9, 'Yakutsk');
AddTimezone('Australia/Adelaide', 9.5, 'Adelaide');
AddTimezone('Australia/Darwin', 9.5, 'Darwin');
AddTimezone('Australia/Brisbane', 10, 'Brisbane');
AddTimezone('Australia/Sydney', 10, 'Sydney');
AddTimezone('Pacific/Guam', 10, 'Guam');
AddTimezone('Australia/Hobart', 10, 'Hobart');
AddTimezone('Asia/Vladivostok', 10, 'Vladivostok');
AddTimezone('Asia/Magadan', 11, 'Magadan');
AddTimezone('Pacific/Auckland', 12, 'Auckland');
AddTimezone('Pacific/Fiji', 12, 'Fiji');
AddTimezone('Pacific/Tongatapu', 13, 'Tongatapu');




CommitTimezones();

function AddTimezone($timezoneName, $gmtOffset, $displayName)
{
	if (is_null($displayName))
	{
		$displayName = $timezoneName;
	}
	
	$GLOBALS['APP_TIMEZONES'][] = array('Name' => $timezoneName, 'Offset' => $gmtOffset, 'DisplayName' => $displayName);
}

function CommitTimezones()
{
	usort($GLOBALS['APP_TIMEZONES'], "SortByOffset");
}

function SortByOffset($tz1, $tz2)
{
	if ($tz1['Offset'] == $tz2['Offset'])
	{
        return 0;
    }
    return ($tz1['Offset'] < $tz2['Offset']) ? -1 : 1;
}
?>