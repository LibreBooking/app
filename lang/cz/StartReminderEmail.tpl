{*
Copyright 2013-2020 Nick Korbel

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
Nezmeškejte svůj rezervovaný termín.<br/>
Detaily rezervace:
<br/>
<br/>
Začátek: {formatdate date=$StartDate key=reservation_email}<br/>
Konec: {formatdate date=$EndDate key=reservation_email}<br/>
Zdroj: {$ResourceName}<br/>
Název: {$Title}<br/>
Popis: {$Description|nl2br}<br/>
<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Zobrazit tuto rezervaci v systému</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Přidat do Outlook</a> |
<a href="{$ScriptUrl}">Přihlásit se do rezervačního systému</a>