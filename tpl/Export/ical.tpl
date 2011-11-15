BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//phpScheduleIt//NONSGML {$phpScheduleItVersion}//EN
METHOD:REQUEST
BEGIN:VEVENT
CREATED:{formatdate date=$DateCreated key=ical}
DESCRIPTION:{$Description}
DTEND:{formatdate date=$DateEnd key=ical}
DTSTAMP:{formatdate date=$DateStamp key=ical}
DTSTART:{formatdate date=$DateStart key=ical}
LOCATION:{$ResourceName}
ORGANIZER:MAILTO:{$OwnerEmail}
{if $RecurRule neq ''}
RRULE:{$RecurRule}
{/if}
SUMMARY:{$Summary}
UID:{$ReferenceNumber}&{$ScriptUrl}
URL:{$ReservationUrl}
X-MICROSOFT-CDO-BUSYSTATUS:BUSY
END:VEVENT
END:VCALENDAR