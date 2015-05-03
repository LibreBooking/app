{*
Copyright 2011-2015 Nick Korbel

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
BEGIN:VCALENDAR
VERSION:2.0
METHOD:REQUEST
PRODID:-//BookedScheduler//NONSGML {$bookedVersion}//EN
{foreach from=$Reservations item=reservation}
BEGIN:VEVENT
CLASS:PUBLIC
CREATED:{formatdate date=$reservation->DateCreated key=ical}
DESCRIPTION:{$reservation->Description|regex_replace:"/\r\n|\n|\r/m":"\n "}
DTSTAMP:{formatdate date=$reservation->DateCreated key=ical}
DTSTART:{formatdate date=$reservation->DateStart key=ical}
DTEND:{formatdate date=$reservation->DateEnd key=ical}
LOCATION:{$reservation->Location}
ORGANIZER;CN={$reservation->Organizer}:MAILTO:{$reservation->OrganizerEmail}
{if $reservation->RecurRule neq ''}
RRULE:{$reservation->RecurRule}
{/if}
SUMMARY:{$reservation->Summary}
UID:{$reservation->ReferenceNumber}&{$UID}
SEQUENCE:0
URL:{$reservation->ReservationUrl}
X-MICROSOFT-CDO-BUSYSTATUS:BUSY
END:VEVENT
{/foreach}
{if $reservation->StartReminder != null}
BEGIN:VALARM
TRIGGER;RELATED=START:-PT{$reservation->StartReminder->MinutesPrior()}M
ACTION:DISPLAY
DESCRIPTION:{$reservation->Summary}
END:VALARM
{/if}
{if $reservation->EndReminder != null}
BEGIN:VALARM
TRIGGER;RELATED=END:-PT{$reservation->EndReminder->MinutesPrior()}M
ACTION:DISPLAY
DESCRIPTION:{$reservation->Summary}
END:VALARM
{/if}
END:VCALENDAR