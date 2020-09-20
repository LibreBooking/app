{*
Copyright 2011-2020 Nick Korbel, Paul Menchini

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
<p>Kære {$FullName},</p>

<p>Der er oprettet en konto for dig i {$AppTitle} med disse informationer:<br/>
E-mail: {$EmailAddress}<br/>
Navn: {$FullName}<br/>
Telefon: {$Phone}<br/>
Organisation: {$Organization}<br/>
Adresse: {$Position}<br/>
Adgangskode: {$Password}</p>
{if !empty($CreatedBy)}
	Oprettet af: {$CreatedBy}
{/if}

<a href="{$ScriptUrl}">Log på {$AppTitle}</a>
