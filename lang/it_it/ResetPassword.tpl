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
{include file='..\..\tpl\Email\emailheader.tpl'}
	
Questa è la tua password temporanea di phpScheduleIt : {$TemporaryPassword}

<br/>

La tua vecchia password non funzioner&agrave pi&ugrave.

Prego <a href="{$ScriptUrl}">Loggati in phpScheduleIt</a> e cambia la tua password al pi&ugrave presto.
	
{include file='..\..\tpl\Email\emailfooter.tpl'}