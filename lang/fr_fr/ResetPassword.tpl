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
	
Votre mot de passe temporaire phpScheduleIt : {$TemporaryPassword}

<br/>

Votre ancien mot de passe ne fonctionne maintenant plus.

SVP : <a href="{$ScriptUrl}">Connexion à phpScheduleIt</a> pour changer au plus vite votre mot de passe.
	
{include file='..\..\tpl\Email\emailfooter.tpl'}
