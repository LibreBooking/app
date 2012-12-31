<?php
/**
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
*/

echo <<<EOD
    	<select name="defLang">
    	    <option value="{$conf['settings']['default.language']}" selected="selected">Now set to {$conf['settings']['default.language']}</option>
			<option value="ca">Catalan</option>
			<option value="cz">Czech</option>
			<option value="de_de">Deutsch</option>
			<option value="du_nl">Dutch</option>
			<option value="en_us">English US</option>	
			<option value="en_gb">English GB</option>
			<option value="es">Espa&ntilde;ol</option>	
			<option value="fi_fi">Suomi</option>	
			<option value="fr_fr">Fran&ccedil;ais</option>
			<option value="it_it">Italiano</option>	
			<option value="ja_jp">Japanese</option>	
			<option value="pl">Polski</option>
			<option value="pt_br">Portugu&ecirc;s Brasileiro</option>
			<option value="sv_sv">Swedish</option>							
		</select><br />
EOD;
?>