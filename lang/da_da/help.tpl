{*
Copyright 2011-2019 Nick Korbel

Denne fil er en del af Booked Scheduler.
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

Dansk hjælpe fil 
*}

{include file='globalheader.tpl'}
<h1 xmlns="http://www.w3.org/1999/html">Booked Scheduler Hjælp</h1>

<h1>Hjælpe fil</h1>

<div id="help">
<h2>Registrering</h2>

<p>
	Registrering kræves for at bruge Reservationsystemet hvis administratoren har aktiveret dette. Efter at din konto
er registreret
vil du være i stand til at logge ind og få adgang til alle de ressourcer, du har tilladelse til.
</p>

<h2>Reservation</h2>

<p>
	Under menuen Kalender vil du finde de objekter du har mulighed for at reservere.<br />

    Her vises de tider i kalenderen der er  ledige, de reserverede tider og de objekter og tider der er blokerede, så du kan lave en reservation der passer bedst til dig.
</p>

<h3>Express</h3>

<p>
	På Reservationsiden finder du de faciliteter, dato og tid, du kan reservere.<br /> 
    Hvis du klikker på tidsperioden giver det dig mulighed for at ændre oplysningerne på reservationen.<br /> 
    Ved at klikke på Opret reservationen giver det mulighed for at lave en reservation, samtidig får du tilsendt en e-mail.<br />
    Du får et referencenummer, der kan bruges til opfølgning på booking.<br />
	Ingen ændringer træder i kraft, før du har gemt din reservation.<br />
	Kun administratorer kan oprette bookinger efterfølgende.
</p>

<h3>Flere reservationer</h3>
<p>
	Du kan Reservere alle de faciliteter du har godkendelse til.<br />

	Hvis du ønsker at tilføje ressourcer til dine reservationer, klik på Flere ressourcer ved siden af navnet på den primære ressource, du har reserveret.<br />
	Du vil derefter være i stand til at tilføje flere ressourcer ved at vælge dem og klikke på knappen Udført.<br />

	For at fjerne yderligere ressourcer fra din reservation, skal du klikke på Flere Ressourcer linket, fravælge de ressourcer, du vil fjerne, og klik på knappen Udført.<br />

	Yderligere ressourcer vil være underlagt de samme regler som primære ressourcer.<br />

	For eksempel betyder det, at hvis du forsøge at skabe en 2 timers reservation med Resource 1, som har en maksimal længde på 3 timer og<br />

	med Resource 2, som har en maksimal længde på 1 time, vil din reservation blive nægtet.<br />

	Du kan se konfigurationsdetaljerne for en ressource ved at holde markøren over navnet ressource.
</p>

<h3>Gentagelse af datoer</h3>

<p>
    En reservation kan konfigureres til at gentage sig på en række forskellige måder. For alle gentages den Indtil den dato der er inkludet nås.<br />
    Gentaglses muligheden tillader fleksible gentagelse-muligheder. For eksempel: Gentag Dagligt hver 2. dage vil
    oprette en reservation hver anden dag til dit angivne tidsinterval.<br />
    Gentag Weeugentligtkly, hver 1 uge på mandag, onsdag, fredag vil oprette en reservation på hver af disse dage i hver uge i dit angivne tidsinterval.<br />
     Hvis du opettede en reservation den 15-01-2011, gentagelse månedlig, hver 3. måned på den dag i måned vil oprette en reservation hver tredje måned den 15.. Sa den 15-01-2011 er den tredje lørdag i januar, det samme eksempel med dagen
    afi uge valgt, vil gentage hver tredje måned på den tredje lørdag i denne måned<br />

<h3>Flere deltagere</h3>

<p>

    Du kan enten Tilføj Deltagere eller Inviter andre, når du booker en reservation. Tilføjelse af nogen vil medtage dem på
    reservationen og vil ikke sende en invitation.<br />
    De tilføjede bruger vil modtage en e-mail. Invitation af en bruger vil sende en invitations e-mail og give brugeren en mulighed for at acceptere eller afvise invitationen.<br />
    Accepteres en invitation tilføjes brugeren til listen af deltagere.<br />
    Afvisning af en invitation fjerner brugeren fra listen af inviterede.<br />
<br />

	Det samlede antal deltagere er begrænset af ressourcens deltager kapacitet.
</p>

<h3>Tilbehør</h3>

<p>
    Tilbehør kan opfattes som objekter, der anvendes i en reservation. Eksempler kan være projektorer eller stole. For at tilføje tilbehør til din reservation, skal du klikke på linket Tilføj til højre for Tilbehør feltet. Derfra vil du
    kunne vælge en mængde fra det tilgængelige tilbehør. Den disponible mængde under din
    reservation vil afhænge af, hvor meget tilbehør der allerede er reserveret.

</p>

<h3>Booking på vegne af andre</h3>

<p>
    Application Administratorer og Gruppe Administratorer kan bestille forbehold på vegne af andre brugere ved at klikke på linket Skift til højre for brugerens navn.<br />
    
    Application Administratorer og Gruppe Administratorer kan også ændre og slette reservationer, der ejes af andre brugere.
</p>

<h2>Updater en Reservation</h2>

<p>Du kan opdatere alle reservationer, som du har oprettet, eller som blev oprettet på dine vegne.
</p>

<h3>Opdatering konkrete forekomster fra en serie</h3>

<p>
	Hvis en reservation er sat op til at gentagelse, så bliver en serie oprettet. Når du har foretaget ændringer, og opdater reservationen, vil du blive spurgt, hvilke forekomster af den serie, du ønsker at anvende ændringerne på. Du kan
    anvende dine ændringer til den forkomst, som du ser (Kun dette tilfælde) og ingen andre forkomst vil være
    ændret.<br />
    Du kan opdatere alle forekomster til at anvende ændringen til en hvilken som helst reservation, der endnu ikke har fundet sted. 
    Du kan også anvende ændringen på kun fremtidige forekomster, som vil opdatere alle inkluderede reservationens forekomster og efter den reservation, du ser i øjeblikket.<br />
Kun Application Administratorer kan opdatere reservationer bagud.
</p>

<h2>Fjerne en Reservation</h2>

<p>
    Sletning af en reservation fjerner den fuldstændigt fra tidsplanen. Den vil ikke længere være synlige noget sted i
    Bookede Scheduler
</p>

<h3>Slette konkrete forkomster fra en serie</h3>

<p>
	I lighed med opdatering af en reservation, når du sletter du kan vælge, hvilke forekomster, du vil slette.<br />
	Kun Application Administratorer kan fjerne reservationer bagud.<br />
</p>
<h2>Tilføjelse af en reservation til Kalender(Outlook&reg;, iCal, Mozilla Lightning, Evolution)</h2>

<p>
    Når viser eller opdaterer en reservation vil du se en knap Tilføj til Outlook. Hvis Outlook er installeret på din
    computer, så skal du blive bedt om at tilføje reservationen.<br  />
    Hvis det ikke er installeret, vil du blive bedt om at hente en .ics fil. Dette er en standard kalender format. Du kan bruge denne fil til at tilføje reservationen til enhver applikation der understøtter iCalendar filformatet.
</p>

<h2>Tilmelding til kalendere</h2>

<p>
    Kalendere kan offentliggøres for Tidsplaner, Ressourcer og brugere. For at denne funktion skal fungere, skal administratoren have konfigureret en abonnement nøgle i konfigurationsfilen. <br />
    For at aktivere Tidsplan og Resource niveau kalender abonnementer, aktiver abonnementer på under varetaelsen af Tidsplan eller ressource.<br />
	Sådan aktiverer du personlig kalender abonnementer, åben booked -> Kalender ->Min kalender. I højre side finder du et link til Vis eller Skjul kalender abonnementer.<br />

    For at abonnerere på en kalender, åben booked -> Kalender, og vælg den tidskalender, du ønsker. I højre side, vil du finde et link til at abonnere på den aktuelle kalender.<br />
    Tilmelding af en ressource kalender følger de samme trin. For at abonnere på din personlige kalender, åben booked -> Kalender -> Min kalender. I højre side, vil du finde et link til at abonnere på den aktuelle kalender
</p>

<h3>Kalender klient (Outlook&reg;, iCal, Mozilla Lightning, Evolution)</h3>

<p>
    I de fleste tilfælde ved blot at klikke på Abonner på Kalender linket vil automatisk oprette abonnementet i
    din kalender klient. I Outlook, hvis det ikke automatisk tilføjes, åben kalenderoversigten, derefter højreklikke Min
    Kalendere og vælg Tilføj Kalender -> fra internettet. Indsæt i webadressen trykt under Abonner på denne kalender link i
    Reserveret Scheduler
</p>

<h3>Google&reg; Kalender</h3>

<p>
    Åben Google Kalender indstillinger. Klik på fanen Kalendere. Klik på Find interessante kalendere. Klik Tilføj via webadresse. Sæt i URL'en trykt under Abonner på denne kalender link i Bookede.
</p>

<h2>Mængder</h2>

<p>
    Administratorer har mulighed for at konfigurere kvoteregler baseret på en række forskellige kriterier. Hvis din reservation vil krænke nogen kvote, vil du blive underrettet og reservation vil blive afvist.
</p>

<h2>Administration</h2>

<p>
	
    Hvis du er Application Administrator, så vil du se Application Management menuen. Alle administrative opgaver findes her.
</p>

<h3>Opsætning af Tidsplaner</h3>

<p>
	Når du installerer Booked Scheduler vil en standard tidsplan oprettes med ud af boksen indstillinger. Fra Tidsplaner menuindstillingen kan du se og redigere attributter i de nuværende skemaer.<br />
    Hver tidsplan skal have et layout defineret. Dette styrer tilgængeligheden af ressourcer på tidsplanen. Hvis du klikker på Skift layout linket vil bringe dig til layout editoren.<br />
    Her kan du oprette og ændre tidsintervaller, der er tilgængelige for reservation og blokeret fra reservation.<br />
    Der er ingen begrænsning på tidspunkter, men du skal give tidspunkter for alle 24 timer af døgnet, én pr linje.<br />
    Desuden skal tidsformatet være 24 timer<br />
    Du kan også give et display mærke for et eller alle tidspunt(er), hvis du vil<br />
    <br />
    Et tidspunkter uden en etiket vil blive vist på denne måde: 10:25 til 16:50<br />
    <br />
    Under konfigurations- vinduet er der en guide oprettelse af et tidsinterval. Dette vil oprette tilgængelige tidsintervaller i intervallet mellem start- og sluttider.<br />
    <br />
</p>

<h3>Opsætning af Ressourcer</h3>

<p>
    Du kan vise og administrere ressourcer fra Resources menupunkt. Her kan du ændre attributter og anvendelses konfiguration af en ressource.<br />
    <br />
    Ressourcer i Booked Scheduler kan være noget, du ønsker at gøre reserverbart, såsom værelser eller udstyr. Hver ressource skal tildeles til en tidsplan, for at det at kan gøres reserverbart. Ressourcen vil arve et hvilket somhelst layout tidsskemaet bruger.<br />
    <br />
    Indstilling af en reservations mindste varighed vil forhindre booking i at vare længere end den indstillede tid. Standard er intet minimum.<br />
    <br />
    Indstilling af en reservations maksimal varighed vil forhindre booking i at være kortere end den indstillede tid.<br /> 
    Standard er intet maksimum<br />
    <br />
    Indstilling af en ressource til at kræve godkendelse vil placere alle bookinger for denne ressource i en afventende tilstand indtil godkendelse. Standard er ingen godkendelse kræves.<br />
    <br />
    Indstilling af en ressource til at få tilladelse til at den automatisk vil give alle nye brugere tilladelse til at få adgang til ressourcen på registreringstidspunktet. Standarden er automatisk at tildele tilladelser.<br />
    <br />
    Du kan kræve en bookings leveringstid ved at sætte en ressource til at kræve et bestemt antal dage / timer / minutter meddelelse.<br />
    For eksempel, hvis det på nuværende tidspunkt er 10:30 på en mandag og ressourcen kræver 1 dag meddelelsen, vil ressourcen ikke kunne bookes før 10:30 om søndagen.<br />
    Standarden er, at reservationer kan foretages indtil den aktuelle tid.<br />
    <br />
    Du kan forhindre ressourcer fra blive reserveret for langt frem i tiden ved at kræve en maksimal anmeldelse af dage / timer / minutter.<br />
    For eksempel, hvis det på nuværende tidspunkt er 10:30 på en mandag og ressourcen kan ikke slutte mere end 1 dag frem i tiden, ressourcen vil ikke kunne bookes efter 10:30 tirsdag.<br />
    Standard er intet maksimum<br />    
    <br />
	Visse ressourcer kan ikke have en anvendelses kapacitet.<br />
    Indstilling af kapaciteten ressource vil forhindre mere end det konfigurerede antal deltagere på én gang, med undtagelse af arrangøren.<br />
    <br />
    Application Administratorer er fritaget for anvendelses begrænsninger.
</p>

<h3>Ressource-billeder</h3>

<p>
    Du kan indstille en ressource billeder, som vil blive vistnår du får vist ressource detaljer på reservations siden.<br />
    Det kræver php_gd2 at er installeret og aktiveret i din php.ini fil.<br />
	<a href="http://www.php.net/manual/en/book.image.php">Flere detaljer</a>
</p>

<h3>Opsætning af Tilbehør</h3>

<p>
    Tilbehør kan opfattes som ting, der anvendes i løbet af en reservations.<br />
	Eksempler kan være projektorer eller stole i et mødelokale.<br />
    <br />
    Tilbehørs kan vises og styres fra Tilbehørs menuen, under menuen Ressourcer.<br />
    Indstilling af mængden tilbehør vil forhindre at mere end mængden af tilbehør vil kunne bookes ad gangen.
</p>

<h3>Opsætning af Mænder</h3>

<p>
	Mængder forhindrer reservationer fra blive reserveret baseret på en konfigurerbar grænse.<br />
    Mændeordningen i Booked Scheduler er meget fleksibel, så du kan oprette grænser baseret på reservations længde og antallet af reservationer. Desuden mænder begrænser "stacks".<br />
    <br />
    For eksempel, hvis en mængde begrænser en ressource til 5 timer dagligt og anden mængde begrænses til 4 reservationer pr dag, ville en bruger være i stand til at lave 4 timer lange reservation men ville blive forhindret i at oprette 3 to timer lange reservationer .<br />
    Dette giver mulighed for stærke kombinationer af mængder, der kan oprettes.<br />
    <br />
    Application Administratorer er fritaget for mænder begrænsninger.
</p>

<h3>Opsætning af Meddelelser</h3>

<p>
	Meddelelser er en meget enkel måde at vise meddelelser til Booked Scheduler brugere.<br />
	Fra Meddelelser menuen kan du vise og administrere de meddelelser, der vises på brugernes dashboards.<br />
	En meddelelse kan konfigureres med en valgfri start- og slutdato.<br />
    En valgfri prioritetsniveau er også tilgængelige, som sorterer meddelelser fra 1 til 10.<br />
   <br />
	HTML er tilladt i meddellelsens tekst. Dette giver dig mulighed for at integrere links eller billeder fra hvor som helst på nettet.
</p>

<h3>Opsætning af grupper</h3>

<p>
	Grupper i Booked Scheduler organisere brugere, kontrollerer ressource adgangstilladelser og definere roller i anvendelsen.
</p>

<h3>Roller</h3>

<p>
	Roller giver en gruppe af brugere tilladelse til at udføre bestemte handlinger.<br />
	Brugere, der hører til en gruppe, der har Application Administrator rolle har fuld administratorrettigheder.
	Denne rolle har næsten ingen begrænsninger for hvilke ressourcer der kan reserveres.
	De kan administrere alle aspekter af applicationen.<br />
    <br />
    Brugere, der hører til en gruppe, der har Gruppe Administrators rolle er i stand til at reservere på vegne af og administrere brugere i gruppen.
</p>

<h3>Visning og Administration af Reservationer</h3>

<p>
	Du kan vise og administrere reservationer fra Reservationer menuen<br /> 
    Som standard vil du se de sidste 7 dage og den næste 7 dage af reservationen.<br />
    Dette kan filtreres mere eller mindre finmasket afhængigt af hvad du søger.<br />
	Dette værktøj giver dig mulighed for hurtigt at finde en hændelse på en reservation.<br /> 
    Du kan også eksportere listen over filtrerede reservationer til CSV-format til videre rapportering.
</p>

<h3>Godkendelse af Reservation</h3>

<p>
    Fra Reservationer administrator værktøjet vil du være i stand til at se og godkende eksisterende reservationer. Afventende reservationer vil blive fremhævet.
</p>

<h3>Visning og administration af brugere</h3>

<p>
    Du kan tilføje, se og administrere alle registrerede brugere fra Brugere menuen. <br />
    Dette værktøj giver dig tilladelse til at ændre adgang tilladelser for de enkelte brugere, deaktivere eller slette konti, nulstille brugernes adgangskoder og redigere brugeroplysninger.<br />
    Du kan også tilføje nye brugere til Booked Scheduler. Dette er især nyttigt, hvis selvregistrering er slået fra.
</p>

<h2>Konfiguration</h2>

<p>
	Nogle af Booked Scheduler funktionaliteter kan kun styres ved at redigere i konfigurationsfilen.<br />
    
<p class="setting">
	<span>$conf['settings']['server.timezone']</span>Dette skal afspejle tidszonen på den server, Booked Scheduler er hostet på.<br /> 
    Du kan se den aktuelle tidszonen fra Serverindstillinger menuen 
    Mulige tider kan findes her: <a href=" http://php.net/manual/en/timezones.php"></a>
</p>

<p class="setting">
	<span>$conf['settings']['allow.self.registration']</span>Hvis brugerne har tilladelse til at registrere nye konti.
</p>

<p class="setting">
	<span>$conf['settings']['admin.email']</span>mail-adressen på main application administratoren
</p>

<p class="setting">
	<span>$conf['settings']['default.page.size']</span>Det oprindelige antal rækker for alle sider, der viser en liste over data
</p>

<p class="setting">
	<span>$conf['settings']['enable.email']</span>Hvorvidt alle e-mails sendes ud af Booked Scheduler
</p>

<p class="setting">
	<span>$conf['settings']['default.language']</span>Standard sprog for alle brugere. Dette kan være alle sprog i Booked Scheduler sprog biblioteket (booked / lang /)
</p>

<p class="setting">
	<span>$conf['settings']['script.url']</span>Den fulde offentlige webadresse til roden af denne version af Booked Scheduler.<br />
    Dette skal være rod biblioteketder indeholder filerne bookings.php og calendar.php
</p>

<p class="setting">
	<span>$conf['settings']['password.pattern']</span>Et regulært udtryk til at håndtere password under brugerkonto registrering.
</p>

<p class="setting">
    <span>$conf['settings']['schedule']['show.inaccessible.resources']</span>Hvorvidt ressourcer, der ikke er tilgængelige for brugeren, vises i tidsskemaet
</p>

<p class="setting">
    <span>$conf['settings']['schedule']['reservation.label']</span>Den værdi, der vises for reservationen på siden Reservationer.<br />
    Mulighederne er 'navn', 'titel', eller 'ingen'. Standard er 'navn'.
</p>

<p class="setting">
	<span>$conf['settings']['image.upload.directory']</span>Den fysiske mappe til at billeder gemmes.<br />
	Denne mappe skal være skrivbar. Dette kan være den fulde sti til biblioteket eller relativ til den Booked Schedulers rodmappe.
</p>

<p class="setting">
    <span>$conf['settings']['image.upload.url']</span>Den webadresse hvor uploadede billeder kan ses fra.<br />
	Dette kan være den fulde sti til $conf['settings']['script.url'].
</p>

<p class="setting">
	<span>$conf['settings']['cache.templates']</span>Hvorvidt skabeloner cachelagres.<br /> 
    Det anbefales at dtte sætte til sand, så længe ppl_c er skrivbar.
</p>

<p class="setting">
    <span>$conf['settings']['registration.captcha.enabled']</span>Hvorvidt captcha sikkerhedsbillede er aktiveret under brugerkonto registreringen. 
</p>

<p class="setting">
    <span>$conf['settings']['inactivity.timeout']</span>Antal minutter før brugeren logges ud automatisk.<BR />
    Efterlad dette blankt hvis du ikke ønsker, at brugerne logges ud automatisk.
</p>

<p class="setting">
    <span>$conf['settings']['name.format']</span>Vis format for fornavn og efternavn.<BR />
    Standard er {literal} "{første} {sidste} '{/literal}.
</p>

<p class="setting">
	<span>$conf['settings']['ics']['require.login']</span>Hvis det kræves at brugere skal logge ind for føje en reservation til Outlook
</p>

<p class="setting">
	<span>$conf['settings']['ics']['subscription.key']</span>Hvis du vil tillade webcal abonnementer, skal du indstille dette til en svært at gætte værdien.<br />
    Hvis intet er angivet vil webcal abonnementer blive deaktiveret.
</p>

<p class="setting">
	<span>$conf['settings']['privacy']['view.schedules']</span>Hvis ikke-godkendte brugere kan se reservationskalendere. <br />
   <br />
    Standard er falsk
.
</p>

<p class="setting">
	<span>$conf['settings']['privacy']['view.reservations']</span>Hvis ikke-godkendte brugere kan se reservationsdetailjer.
	Standard er falsk.
</p>

<p class="setting">
	<span>$conf['settings']['privacy']['hide.user.details']</span>Hvis ikke-godkendte brugere kan se personlige oplysninger om andre brugere.<br />
   <br />
    Standard er falsk.
</p>

<p class="setting">
	<span>$conf['settings']['reservation']['start.time.constraint']</span>Hvornår kan reservationer oprettes eller redigeres. <br />
    Mulighederne er fremover, nuværende, ingen.<br />
    
    Fremtidig betyder reservationer kan ikke oprettes eller ændres, hvis starttidspunktet for det valgte tidsinterval i det forløbne.<br />
    Nuværende betyder reservationer kan oprettes eller ændres, hvis sluttidspunktet for det valgte tidspunkt ikke er i det forløbne.<br />
    Ingen betyder, at der er ingen begrænsning er på, hvornår reservationer kan oprettes eller ændres.<br />
    Standard er fremover.
</p>

<p class="setting">	
	<span>$conf['settings']['reservation.notify']['resource.admin.add']</span>Hvorvidt at der sendes en e-mail til alle ressource administratorer når en reservation er oprettet.<br />
    Standard er falsk.
</p>

<p class="setting">
	<span>$conf['settings']['reservation.notify']['resource.admin.update']</span>Hvorvidt at der sendes en e-mail til alle ressource administratorer når en reservation bliver opdateret.<br />
    Standard er falsk.
</p>

<p class="setting">
    <span>$conf['settings']['reservation.notify']['resource.admin.delete']</span>Hvorvidt at der sendes en e-mail til alle ressource administratorer når en reservation bliver slettet.<br />
    Standard er falsk.
</p>

<p class="setting">
    <span>$conf['settings']['reservation.notify']['application.admin.add']</span>Hvorvidt at der sendes en e-mail til alle application administratorer når en reservation bliver oprettet.<br />
    Standard er falsk.
</p>

<p class="setting">
    <span>$conf['settings']['reservation.notify']['application.admin.update']</span>Hvorvidt at der sendes en e-mail til alle application administratorer når en reservation bliver opdateret.<br />
    Standard er falsk.
</p>

<p class="setting">
    <span>$conf['settings']['reservation.notify']['application.admin.delete']</span>Hvorvidt at der sendes en e-mail til alle application administratorer når en reservation bliver slettet.<br />
    Standard er falsk>.
</p>

<p class="setting">
    <span>$conf['settings']['reservation.notify']['group.admin.add']</span>Hvorvidt at der sendes en e-mail til alle gruppe administratorer når en reservation bliver oprettet.<br />
    Standard er falsk.
</p>
<p class="setting">
    <span>$conf['settings']['reservation.notify']['group.admin.update']</span>Hvorvidt at der sendes en e-mail til alle gruppe administratorer når en reservation bliver opdateret.<br />
    Standard er falsk.
</p>

<p class="setting">
    <span>$conf['settings']['reservation.notify']['group.admin.delete']</span>Hvorvidt at der sendes en e-mail til alle gruppe administratorer når en reservation bliver  slettet.<br />
    Standard er falsk.
</p>

<p class="setting">
    <span>$conf['settings']['css.extension.file']</span>
    Fuld eller relativ URL til yderligere CSS-filer til at inkludere.<br />
    Dette kan bruges til at tilsidesætte standard stilen med justeringer eller en fuld tema.<br />
    Efterlad dette blankt hvis du ikke vil udvide stilen i Booked Scheduler.
</p>

<p class="setting">
    <span>$conf['settings']['uploads']['enable.reservation.attachments']</span>Hvis brugerne har tilladelse til at vedhæfte filer til reservationer.<br />
    Standard er falsk.
</p>

<p class="setting">
    <span>$conf['settings']['uploads']['reservation.attachment.path']</span>Det fulde eller relative filsystem sti (i forhold til roden af dit Booked Schedulers biblioteket) til at gemme reservations vedhæftede filer.<br />
    Denne mappe skal være skrivbar fra PHP.<br />
    Standard er uploads/reservation
</p>

<p class="setting">
    <span>$conf['settings']['uploads']['reservation.attachment.extensions']</span>Komma separet liste over sikre fil extensions.<br />
    Efterlad dette tomt vil tillade alle filtyper (anbefales ikke).
</p>

<p class="setting">
    <span>$conf['settings']['database']['type']</span>Alle PEAR :: MDB2 understøttede typer
</p>

<p class="setting">
    <span>$conf['settings']['database']['user']</span>Database bruger med adgang til den konfigurerede database.
</p>

<p class="setting">
    <span>$conf['settings']['database']['password']</span>Adgangskode for databasen brugeren.
</p>

<p class="setting">
    <span>$conf['settings']['database']['hostspec']</span>Database host URL eller navngiven sti
</p>

<p class="setting">
    <span>$conf['settings']['database']['name']</span>Navnet på Booked Schedulers databasen
</p>

<p class="setting">
    <span>$conf['settings']['phpmailer']['mailer']</span>PHP email bibliotek. Mulighederne er mail, smtp,
	sendmail, qmail
</p>

<p class="setting">
    <span>$conf['settings']['phpmailer']['smtp.host']</span>SMTP host, hvis du bruger smtp
</p>

<p class="setting">
    <span>$conf['settings']['phpmailer']['smtp.port']</span>SMTP port, hvis du bruger smtp, normalt 25
</p>

<p class="setting">
    <span>$conf['settings']['phpmailer']['smtp.secure']</span>SMTP sikkerhed, hvis du bruger smtp. mulighederne er
	'', ssl eller tls
</p>

<p class="setting">
    <span>$conf['settings']['phpmailer']['smtp.auth']</span>SMTP kræver godkendelse, hvis du bruger smtp.<br />
	Mulighederne er sand eller falsk
</p>

<p class="setting">
    <span>$conf['settings']['phpmailer']['smtp.username']</span>SMTP brugernavn, hvis du bruger smtp
</p>

<p class="setting">
    <span>$conf['settings']['phpmailer']['smtp.password']</span>SMTP adgangskode, hvis du bruger smtp
</p>

<p class="setting">
    <span>$conf['settings']['phpmailer']['sendmail.path']</span>Sti til sendmail, hvis du bruger sendmail
</p>

<p class="setting">
    <span>$conf['settings']['plugins']['Authentication']</span>Navnet på godkendelses plugins der kan anvendes.<br />
    For mere om plugins, se Plugins herunder
</p>

<p class="setting">
    <span>$conf['settings']['plugins']['Authorization']</span>Navnet på tilladelses plugins der kan anvendes.<br />
    For mere om plugins, se Plugins herunder
</p>

<p class="setting">
    <span>$conf['settings']['plugins']['Permission']</span>Navne på tilladelses plugins der kan anvendes. <br />
    For mere om plugins, se Plugins herunder
</p>

<p class="setting">
    <span>$conf['settings']['plugins']['PreReservation']</span>Navne på forhåndsreservations plugins der kan anvendes. <br />
    For mere om plugins, se Plugins herunder


<p class="setting">
    <span>$conf['settings']['plugins']['PostReservation']</span>Navne på indlæg reservations plugins der kan anvendes.<br />
    For mere om plugins, se Plugins herunder
</p>

<p class="setting">
    <span>$conf['settings']['install.password']</span>Hvis du kører en installation eller opgradering, vil du blive bedt om at angive en værdi her
</p>

<h2>Plugins</h2>

<p>Følgende komponenter er i øjeblikket pluggable:
</p>

<ul>
	<li>Authentication(Godkendelse) - hvem har lov til at logge på</li>
    
	<li>Authorization(Tilladelse) - Hvad en bruger kan gøre, når han er logget ind</li>
  
	<li>Permission(Tilladelse) - Hvilke ressourcer en bruger har adgang til</li>
     
	<li>Pre Reservation(Forhånds Reservation) - Hvad sker før en reservation er booket</li>
     
	<li>Post Reservation(Indlæg Reservation)   Hvad sker der efter en reservation er booket</li>
</ul>

<p>
	For at aktivere et plugin, angive værdien af config indstillingen til navnet på plugin-mappen.<br />
    For eksempel for at tillade LDAP-godkendelse, skal du angive
	$conf['settings']['plugins']['Authentication'] = 'Ldap';
</p>

<p>
    Plugins skal have deres egne konfigurationsfiler.<br />
    For LDAP, omdøb eller kopiere /plugins/Authentication/Ldap/Ldap.conf.dist til /plugins/Authentication/Ldap/Ldap.config og redigere alle værdierder er relevante for dit miljø.
</p>

<h3>Installation af Plugins</h3>

<p>
	For at installere en ny plugin kopiere mappen til enten Authentication, Authorization og Permission biblioteket.<br />
     Derefter ændres enten $conf['settings']['plugins']['Authentication'], $conf['settings']['plugins']['Authorization'] eller
	$conf['settings']['plugins']['Permission'] i config.php til navnet på denne mappe.
</p>

</div>
{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}