{*
Copyright 2013-2020 Nick Korbel

Denne fil er en del af programmet Booked Schduler.

Booked Scheduler er et gratis program.

Du må genudgive og ændre i det så længe du følger retningslinjerne under
"GNU General Public License" som er udgivet af "The Free Software Foundation",
enten version 3 af retningslinjerne, eller en hvilken som helst senere version.

Booked Scheduler er udgivet i håbet om, at det er nyttigt og brugbart,
men uden NOGEN GARANTI; Ikke engang med almindelige gældende handelsbetingelser
eller en garanti om, at det kan bruges til et bestemt formål.  Se alle detaljer
i "GNU General Public License".

Du skulle have modtaget en kopi af "GNU General Public License" sammen med
Booked Scheduler. Hvis ikke, se <http://www.gnu.org/licenses/>.
*}

Din serie af reservationer for {$ResourceName} slutter {formatdate date=$StartDate key=reservation_email}.<br/>
Oplysninger om reservation:
	<br/>
	<br/>
	Begynder: {formatdate date=$StartDate key=reservation_email}<br/>
	Slutter: {formatdate date=$EndDate key=reservation_email}<br/>
	Facilitet: {$ResourceName}<br/>
	Overskrift: {$Title}<br/>
	Beskrivelse: {$Description|nl2br}
<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Se denne reservation</a> |
<a href="{$ScriptUrl}">Log på {$AppTitle}</a>
