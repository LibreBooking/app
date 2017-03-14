{*
Copyright 2013-2016 Nick Korbel

Translation: 2014 Nicola Ruggero <nicola@nxnt.org>

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

La tua prenotazione sta per iniziare.<br />
Dettagli prenotazione:
	<br />
	<br />
	Inizio: {formatdate date=$StartDate key=reservation_email}<br />
	Fine: {formatdate date=$EndDate key=reservation_email}<br />
	Risorsa: {$ResourceName}<br />
	Note: {$Title}<br />
	Descrizione: {$Description|nl2br}<br />
<br />
<br />
<a href="{$ScriptUrl}/{$ReservationUrl}">Vedi questa prenotazione</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Aggiungi al calendario</a> |
<a href="{$ScriptUrl}">Accedi a Booked Scheduler</a>

