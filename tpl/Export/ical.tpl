{*
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//phpScheduleIt//NONSGML {$phpScheduleItVersion}//EN
METHOD:REQUEST
{foreach from=$Reservations item=reservation}
BEGIN:VEVENT
CREATED:{formatdate date=$reservation->DateCreated key=ical}
DESCRIPTION:{$reservation->Description}
DTEND:{formatdate date=$reservation->DateEnd key=ical}
DTSTAMP:{formatdate date=$reservation->DateCreated key=ical}
DTSTART:{formatdate date=$reservation->DateStart key=ical}
LOCATION:{$reservation->ResourceName}
ORGANIZER:MAILTO:{$reservation->Organizer}
{if $reservation->RecurRule neq ''}
RRULE:{$reservation->RecurRule}
{/if}
SUMMARY:{$reservation->Summary}
UID:{$reservation->ReferenceNumber}&{$ScriptUrl}
URL:{$reservation->ReservationUrl}
X-MICROSOFT-CDO-BUSYSTATUS:BUSY
END:VEVENT
{/foreach}
END:VCALENDAR