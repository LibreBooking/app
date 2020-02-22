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
A sua reserva irá terminar em breve.<br/>
Detalhes da reserva:
	<br/>
	<br/>
	Início: {formatdate date=$StartDate key=reservation_email}<br/>
	Fim: {formatdate date=$EndDate key=reservation_email}<br/>
	Recurso: {$ResourceName}<br/>
	Título: {$Title}<br/>
	Descrição: {$Description|nl2br}
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Adicionar ao calendário</a> |
<a href="{$ScriptUrl}">Entrar em {$AppTitle}</a>
