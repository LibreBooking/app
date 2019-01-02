{*
Modified by Alenka Kavčič (alenka.kavcic@fri.uni-lj.si), UL FRI, August 2015
Translated and adapted for Slovenian language
Note: these instructions are translated only partially; some text is left in English

Copyright 2011-2019 Nick Korbel

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
{include file='globalheader.tpl'}
<h1>Administracija programa Booked Scheduler</h1>

<div id="help">
	<h2>Administracija</h2>

	<p>Če ste v skupini, ki ima vlogo administratorja aplikacije (Application Administrator), boste v meniju videli tudi postavko Urejanje aplikacije. 
	   V njej najdete vsa administrativna opravila.</p>

	<div id="help-schedules">
		<h3>Nastavljanje urnikov</h3>

		<p>
			Ob namestitvi sistema Booked Scheduler se ustvari privzeti urnik z vnaprej določenimi nastavitvami. Lastnosti trenutnega urnika lahko 
			pregledate in urejate preko menija Urniki.
		</p>

		<p>Urniki so lahko prikazani tako, da se začnejo s katerimkoli dnevom v tednu in prikazujejo katerokoli število dni. Za prikaz urnika z začetkom
		    na trenutni dan nastavite Začetek na opcijo Danes.</p>

		<p>Vsak urnik mora imeti določeno postavitev, ki določa razpoložljivost virov na tem urniku. S klikom na povezavo Spremeni postavitev odprete 
		    urejevalnik postavitve urnika, v katerem lahko ustvarite ali spremenite časovne intervale, ki so na voljo za rezervacije v tem urniku.
			Določite lahko tudi blokirane časovne intervale, ki v tem urniku niso na voljo. Pri tem ni nobenih omejitev pri časih intervalov,
			a morate poskrbeti, da z intervali pokrijete vseh 24 ur dneva. Vsak časovni interval je zapisan v svoji vrstici. Format zapisa časa mora biti
			24-urni. Pri tem lahko kateremukoli intervalu ali pa tudi vsem intervalom dodate tudi oznako, ki se prikaže poleg intervala.</p>

		<p>Časovni interval brez oznake mora imeti naslednji format: 10:25 - 16:50</p>

		<p>Časovni interval z oznako mora imeti naslednji format: 10:25 - 16:50 Oznaka intervala</p>

		<p>Pod poljem z izpisanimi časovnimi intervali se nahaja čarovnik za ustvarjanje intervalov. Z njegovo pomočjo lahko ustvarite razpoložljive 
		    časovne intervale podane dolžine v podanem obdobju med začetnim in končnim časom.</p>

		<h3>Administracija urnikov</h3>

		<p>Skupina uporabnikov lahko dobi dovoljenje za urejanje virov. Če želimo neki skupini uporabnikov omogočiti administracijo urnika, ji moramo 
		    najprej dodeliti vlogo administratorja urnika (Schedule Administrator). To lahko nastavimo z orodjem za administracijo skupin 
			(meni Urejanje aplikacije -> Skupine). Ko smo dodali ustrezno vlogo, bo skupina vidna tudi pri orodju za urejanje urnikov.</p>

		<p>Administratorji urnikov (Schedule Administrators) imajo enake privilegije kot administratorji aplikacije (Application Administrators) za vse vire,
            ki so na urniku, za katerega je skupina določena. Tako lahko spreminjajo podrobnosti urnika, urejajo nerazpoložljive termine ali urejajo in 
			odobrijo rezervacije.</p>
	</div>

	<div id="help-resources">
		<h3>Nastavljanje virov</h3>

		<p>Vire si lahko ogledate in z njimi upravljate preko menija Viri. Tu lahko spremenite atribute in konfiguracijo uporabe posameznega vira.
		</p>

		<p>Viri v sistemu Booked Scheduler so lahko karkoli, kar želimo ponuditi za rezervacijo, npr. prostor ali oprema. Vsak vir mora biti dodeljen
		    nekemu urniku, da ga lahko rezerviramo. Vir podeduje tudi postavitev, ki jo uporablja urnika.</p>

		<p>Če nastavimo najkrajše trajanje rezervacije, lahko onemogočimo rezervacije, ki so krajše od nastavljenega trajanja. Privzeto najkrajše 
		    trajanje ni nastavljeno.</p>

		<p>Če nastavimo najdaljše trajanje rezervacije, lahko onemogočimo rezervacije, ki so daljše od nastavljenega trajanja. Privzeto najdaljše 
		    trajanje ni nastavljeno.</p>

		<p>Če nastavimo vir tako, da zahteva potrditev, so vse rezervacije na čakanju, dokler niso potrjene. Privzeto ne potrebujemo nobene potrditve.</p>

		<p>Če nastavimo vir tako, da samodejno dodeli dovoljenje za dostop do njega, potem imajo vsi novi uporabniki dovoljenje za dostop do tega vira
            že ob registraciji. Privzeto je samodejno dodeljevanje dovoljenj.</p>

		<p>Pri rezervaciji lahko zahtevate, da so narejene najmanj določen čas pred začetkom. To dosežete z nastavitvijo vira tako, da zahteva določeno 
		    število dni, ur ali minut za predhodno obvestilo. Tako bi, na primer, če je sedaj ura 10:30 v ponedeljek in vir zahteva 1 dan za predhodno obvestilo,
			vir lahko rezervirali najkasneje do 10:30 v nedeljo. Privzeta vrednost je, da so rezervacije lahko narejene do trenutnega časa.</p>

		<p>Da se izognete rezervaciji virov predaleč v prihodnost, lahko pri rezervaciji zahtevate največje število dni, ur ali minut za 
		    predhodno obvestilo. Tako, na primer, če je sedaj ura 10:30 v ponedeljek in vir zahteva, da se ne more končati prej kot 1 dan v prihodnosti,
			vira ne moremo rezervirati kasneje kot le do 10:30 v torek. Privzeto največja vrednost ni nastavljena.</p>

		<p>Določeni viri nimajo zmogljivosti uporabe. Na primer, neka konferenčna soba je lahko za največ 8 oseb. Z nastavitvijo zmogljivosti vira tako preprečimo,
		    da bi vir naenkrat uporabljalo več kot vnaprej določeno število udeležencev; organizatorja pri tem ne štejemo. Privzeta vrednost je, da ima vir
			neomejeno zmogljivost.</p>

		<p>Administratorji aplikacije (Application Administrators) in ustrezni administratorji urnika in virov (Schedule, Resource Administrators) so 
		    izvzeti iz omejitev uporabe.</p>

		<h3>Administracija virov</h3>

		<p>A group of users may be set up with permission to manage resources. In order for a group to be set as the resource administrator the group must first
			be granted the Resource Administrator role. This is configured from the Groups admin tool. Once that role has been added, the group will be
			available in the Manage Resources tool.</p>

		<p>Resource Administrators have the same capabilities as Application Administrators for any resource which the group is assigned to. They can change
			resource details, black out times, manage and approve reservations.</p>

		<h3>Slike virov</h3>

		<p>You can set a resource image which will be displayed when viewing resource details from the reservation page. This
			requires php_gd2 to be installed and enabled in your php.ini file. <a href="http://www.php.net/manual/en/book.image.php" target="_blank">More
				Details</a></p>

		<div id="help-resource-statuses">
			<h3>Statusi virov</h3>
			<p>Setting a resource to the Available status will allow users with permission to book the reservation. The Unavailable status will show the resource on
			the schedule but will not allow it to be booked by anyone other than administrators. The Hidden status will remove the resource from the schedule
			and prevent bookings from all users.</p>
		</div>
	</div>

	<div id="help-resource-groups">
		<h3>Skupine virov</h3>

		<p>Resource Groups are a simple way to organize and filter resources. When a booking is being created, the user will have an option to book all
			resources in a group. If resources in a group are assigned to different schedules then only the resources which share a schedule will be booked
			together.</p>

		<p>If using resource groups, each resource must be assigned to at least one group. Due to the group hierarchy, unassigned resources will not be able to
			be reserved.</p>

		<p>Drag and drop resource groups to reorganize.</p>

		<p>Right click a resource group name for additional actions.</p>

		<p>Drag and drop resources to add them to groups.</p>
	</div>

	<div id="help-resource-types">
		<h3>Tipi virov</h3>

		<p>Resource types allow resources that share a common set of attributes to be managed together. Custom attributes for a resource type will apply to all
			resources of that type</p>
	</div>

	<div id="help-accessories">
		<h3>Nastavljanje dodatkov</h3>

		<p>Accessories can be thought of as ancillary resources used during a reservation. Examples may be projectors or chairs in a
			conference room.</p>

		<p>Accessories can be viewed and managed from the Accessories menu item, under the Resources menu item. Setting a
			accessory quantity will prevent more than that number of accessories from being booked at a time.</p>
	</div>

	<div id="help-quotas">
		<h3>Nastavljanje kvot</h3>

		<p>Quotas restrict reservations from being booked based on a configurable limit. The quota system in Booked Scheduler is
			very flexible, allowing you to build limits based on reservation length and number reservations.</p>

		<p>Quota limits &quot;stack&quot;. For example, if a quota exists limiting a resource to 5 hours per day and another quota exists limiting to
			4 reservations per day, a user would be able to make 4 one-hour-long reservations but would be restricted from making 3
			two-hour-long reservations. This allows powerful quota combinations to be built.</p>

		<p>Quotas applied to a group are enforced for each user in the group individually. It does not apply to the group's aggregated reservations.</p>

		<p>It is important to remember that quota limits are enforced based on the schedule's timezone. For example, a daily limit would begin and end at
			midnight of the schedule's timezone; not the user's timezone.</p>

		<p>Application Administrators are exempt from quota limits.</p>
	</div>

	<div id="help-announcements">
		<h3>Nastavljanje obvestil</h3>

		<p>Announcements are a very simple way to display notifications to Booked Scheduler users.</p>

		<p>From the Announcements menu item
			you can view and manage the announcements that are displayed on users dashboards. An announcement can be configured
			with an optional start and end date. An optional priority level is also available, which sorts announcements from 1
			to 10.</p>

		<p>HTML is allowed within the announcement text. This allows you to embed links or images from anywhere on the web.</p>

	</div>

	<div id="help-groups">
		<h3>Nastavljanje skupin</h3>

		<p>Groups in Booked Scheduler organize users, control resource access permissions and define roles within the
			application. Setting resource permissions for a group will grant access to all members of that group. Users can individually be granted additional
			resource permission.</p>

		<h3>Vloge</h3>

		<p>Roles give a group of users the authorization to perform certain actions.</p>

		<p>Application Administrator: Users that belong to a group that is given the Application Administrator role are open to
			full administrative privileges. This role has nearly zero restrictions on what resources can be booked. It can
			manage all aspects of the application.</p>

		<p>Group Administrator: Users that belong to a group that is given the Group Administrator role are able to manage
			their groups and reserve on behalf of and manage users within that group. A group administrator must first be assigned the Group Administrator role.
			This group will then be available in the Group Administrators list.</p>

		<p>Resource Administrator: Users that belong to a group that is given the Resource Administrators role have the same capabilities as Application
			Administrators for any resource which the group is assigned to. They can change resource details, black out times, manage and approve
			reservations.</p>

		<p>Schedule Administrator: Users that belong to a group that is given the Schedule Administrators role have the same capabilities as Application
			Administrators for any resource that is on a schedule which the group is assigned to. They can change schedule details, black out times, manage and
			approve reservations.</p>

	</div>

	<div id="help-reservations">
		<h3>Ogled in upravljanje z rezervacijami</h3>

		<p>You can view and manage reservations from the Reservations menu item. By default you will see the last 14 days and the
			next 14 days worth of reservations. This can be filtered more or less granular depending on what you are looking for.
			This tool allows you to quickly find an act on a reservation. You can also export the list of filtered reservations
			to CSV format for further reporting.</p>

		<h3>Potrditve rezervacij</h3>

		<p>Setting $conf['settings']['reservation']['updates.require.approval'] to true will put all reservation requests into a
			pending state. The reservation becomes active only after an administrator approves it. From the Reservations admin
			tool an administrator will be able to view and approve pending reservations. Pending reservations will be
			highlighted.</p>
	</div>

	<div id="help-users">
		<h3>Ogled in upravljanje z uporabniki</h3>

		<p>You can add, view, and manage all registered users from the Users menu item. This tool allows you to change resource
			access permissions of individual users, assign users to groups, deactivate or delete accounts, reset user passwords, and edit user details.
			You can also add new users to Booked Scheduler, which is especially useful if self-registration is turned off.</p>

		<h3>Barve rezervacij</h3>

		<p>Reservation colors can be set for individual users. The slot background color of the user's reservations on the Schedule and Calendar views will be
			displayed in this color.</p>

	</div>

	<div id="help-attributes">
		<h3>Prilagojeni atributi</h3>

		<p>Custom Attributes are a powerful extension point in Booked. You can add additional attributes to Reservations, Resources, Resource Types and
			Users.</p>

		<p>Attributes can be configured as single line text box, a multi-line text box, a select list (drop down), or a checkbox. All attributes can be
			configured to be required. Textbox attributes allow an optional validation expression to be set. This value must be a valid regular expression. For
			example, to require a digit to be entered the validation expression would be <em>/\d+/</em></p>

		<p>User, Resource, and Resource Type attributes can be limited to a single entity. These attributes will have an Applies To property. If an attribute is
			configured to apply to a single entity then it will only be collected for that entity.</p>

		<p>Reservation attributes will be collected during the reservation process.</p>

		<p>User attributes are collected when registering and updating a user's profile.</p>

		<p>Resources attributes are entered when managing resources and will be displayed when viewing resource details.</p>

		<p>Resource Type attributes are entered when managing resource types and will be displayed when viewing resource details.</p>

		<p>Custom attributes are available to plugins and can be used to extend the functionality of Booked.</p>
	</div>

	<div id="help-blackouts">
		<h3>Nerazpoložljivi termini</h3>

		<p>Blackout Times can be used to prevent reservations from being booked at certain times. This feature is helpful when a resource is temporarily
			unavailable or unavailable at a scheduled recurring interval. Blacked out times are not bookable by anyone, including administrators.</p>
	</div>

	<div id="help-reporting">
		<h3>Poročanje</h3>

		<p>Reports are accessible to all application, group, resource and schedule administrators. When the currently logged in
			user has access to reporting features, they will see a Reports navigation item. Booked Scheduler comes with a set of
			Common Reports which can be viewed as a list of results, a chart, exported to CSV and printed. In addition, ad-hoc
			reports can be created from the Create New Report menu item. This also allows listing, charting, exporting and
			printing. In addition, custom reports can be saved and accessed again at a later time from the My Saved Reports menu
			item. Saved reports also have the ability to be emailed.</p>
	</div>

	<div id="help-reminders">
		<h3>Opomniki za rezervacije</h3>

		<p>Users can request that reminder emails are send prior to the beginning or end of a reservation. In order for this
			feature to function, $conf['settings']['enable.email'] and $conf['settings']['reservation']['enable.reminders'] must
			both be set to true. Also, a scheduled task must be configured on your server to execute
			/Booked Scheduler/Jobs/sendreminders.php</p>

		<p>On Linux, a cron job can be used. The command to run is <span class="note">php</span> followed by the full path to
			Booked Scheduler/Jobs/sendreminders.php. The full path to sendreminders.php on this server is <span
					class="note">{$RemindersPath}</span>
		</p>

		<p>An example cron configuration might look like: <span class="note">* * * * * php -f {$RemindersPath}</span></p>

		<p>If you have access to cPanel through a hosting provider, <a
					href="http://docs.cpanel.net/twiki/bin/view/AllDocumentation/CpanelDocs/CronJobs" target="_blank">setting up
				a cron job in cPanel</a> is straightforward. Either select the Every Minute option from the Common Settings menu,
			or enter * for minute, hour, day, month and weekday.</p>

		<p>On Windows, <a href="http://windows.microsoft.com/en-au/windows7/schedule-a-task" target="_blank">a scheduled task
				can be used</a>. The task must be configured to run at a frequent interval - at least every 5 minutes. The task to execute is php followed by
			the
			full path to Booked Scheduler\Jobs\sendreminders.php. For example, c:\PHP\php.exe -f c:\inetpub\wwwroot\Booked\Jobs\sendreminders.php</p>

	</div>

	<div id="help-configuration">
		<h2>Konfiguracija</h2>

		<p>Določene funkcionalnosti lahko nastavite le z urejanjem konfiguracijske datoteke.</p>

		<p class="setting"><span>$conf['settings']['app.title']</span>Naslov aplikacije, ki ga uporabi brskalnik. Privzeto je Booked Scheduler.</p>

		<p class="setting"><span>$conf['settings']['default.timezone']</span>Privzet časovni pas, ki je v uporabi. Če ni nastavljen, se uporabi časovni pas strežnika.
		Možne vrednosti najdete na naslednji povezavi:
			<a href="http://php.net/manual/en/timezones.php" target="_blank">http://php.net/manual/en/timezones.php</a></p>

		<p class="setting"><span>$conf['settings']['allow.self.registration']</span>Če je omogočena registracija novih računov za uporabnike. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['admin.email']</span>Naslov e-pošte glavnega administratorja aplikacije.</p>

		<p class="setting"><span>$conf['settings']['default.page.size']</span>Začetno število vrstic za vse strani, ki prikazujejo sezname podatkov.</p>

		<p class="setting"><span>$conf['settings']['enable.email']</span>Ali ima sistem Booked Scheduler omogočeno pošiljanje elektronske pošte.</p>

		<p class="setting"><span>$conf['settings']['default.language']</span>Privzet jezik za vse uporabnike. To je lahko katerikoli jezik iz direktorija lang datotek Booked Scheduler.</p>

		<p class="setting"><span>$conf['settings']['script.url']</span>Poln javni URL do korenskega direktorija te namestitve sistema Booked Scheduler. 
		    To naj bi bil spletni direktorij, ki vsebuje datoteke bookings.php in calendar.php (med drugim). Če se ta vrednost začne z //, potem se protokol določi samodejno (http ali https).</p>

		<p class="setting"><span>$conf['settings']['image.upload.directory']</span>Fizični direktorij, v katerem shranjujemo slike.
			Ta direktorij mora imeti pravice za branje in pisanje (zaželene so pravice 755). Direktorij je lahko podan z absolutno potjo ali pa z relativno glede na korenski direktorij sistema Booked Scheduler.</p>

		<p class="setting"><span>$conf['settings']['image.upload.url']</span>Naslov URL, kjer lahko najdemo shranjene slike. To je lahko celoten URL (polni naslov) ali pa relativni glede na 
		nastavitev $conf['settings']['script.url'].
		</p>

		<p class="setting"><span>$conf['settings']['cache.templates']</span>Ali se predloge shranijo v predpomnilnik. Priporočljivo je, da je vrednost nastavljena na da (true),
		vendar mora imeti direktorij tpl_c pravice za pisanje.</p>

		<p class="setting"><span>$conf['settings']['use.local.jquery']</span>Ali se uporablja lokalna različica datotek jQuery. Če je nastavljeno na ne (false), 
		    se bodo datoteke naložile z Google CDN. Priporočljivo je vrednost nastaviti na ne (false), saj se s tem izboljšajo performanse in uporaba pasovne širine. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['registration.captcha.enabled']</span>Ali je pri registraciji uporabnika vključena varnostna slika captcha.</p>

		<p class="setting"><span>$conf['settings']['registration.require.email.activation']</span>Ali mora uporabnik aktivirati račun preko elektronske pošte, preden
		    se lahko prvič prijavi v sistem.</p>

		<p class="setting"><span>$conf['settings']['registration.auto.subscribe.email']</span>Ali bo uporabnik samodejno 
			prijavljen na vsa sporočila po elektronski pošti.</p>

		<p class="setting"><span>$conf['settings']['inactivity.timeout']</span>Število minut neaktivnosti, preden je uporabnik samodejno odjavljen.
            Pustite prazno, če ne želite samodejne odjave uporabnika.</p>

		<p class="setting"><span>$conf['settings']['name.format']</span>Prikaz imena in priimka. Privzeta vrednost je najprej ime in nato priimek 
			{literal}'{first} {last}'{/literal}.</p>

		<p class="setting"><span>$conf['settings']['css.extension.file']</span>Absolutni pot ali relativni naslov URL do dodatne vključene datoteke CSS.
			To datoteko lahko uporabite za spremembo privzetega stila s pomočjo manjših prilagoditev ali pa celotne nove teme. Če stila sistema 
			Booked Scheduler ne boste razširjali in spreminjali, pustite prazno.</p>

		<p class="setting"><span>$conf['settings']['disable.password.reset']</span>Če je onemogočena funkcionalnost ponastavitve gesla. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['home.url']</span>Kam se preusmeri uporabnika, ko klikne na logotip.
			Privzeto je to uporabnikova začetna stran.</p>

		<p class="setting"><span>$conf['settings']['logout.url']</span>Kam se preusmeri uporabnika, ko se odjavi iz sistema.
			Privzeto je to stran za prijavo.</p>

		<p class="setting"><span>$conf['settings']['default.homepage']</span>Privzeta začetna stran uporabnika, ki se uporabi ob registraciji. 
		    1 = Nadzorna plošča, 2 = Urnik, 3 = Moj koledar, 4 = Koledar virov. Privzeto je 1 (Nadzorna plošča).</p>


		<p class="setting"><span>$conf['settings']['schedule']['use.per.user.colors']</span>Pri rezervacijah uporabi barve, ki jih določi 
		    administrator za posameznega uporabnika. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['schedule']['show.inaccessible.resources']</span>Ali so viri, ki uporabniku niso dostopni, 
		    prikazani na urniku.</p>

		<p class="setting"><span>$conf['settings']['schedule']['reservation.label']</span>Format oznake, ki se prikaže pri rezerviranem terminu 
		    na strani rezervacij. Možne oznake so navedene v razdelku Razpoložljivi simboli oznak.</p>

		<p class="setting"><span>$conf['settings']['schedule']['hide.blocked.periods']</span>Ali so blokirani termini skriti na strani za 
		    rezervacije. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['ics']['require.login']</span>Ali se morajo uporabniki prijaviti, če želijo dodati
            rezervacijo v Outlook.</p>

		<p class="setting"><span>$conf['settings']['ics']['subscription.key']</span>Če želite dovoliti naročnine na koledar,
			nastavite to vrednost na nekaj, kar je težko uganiti. Če vrednost ni nastavljena, bodo naročnine na koledar onemogočene.</p>

		<p class="setting"><span>$conf['settings']['privacy']['view.schedules']</span>Ali neavtenticiran uporabnik lahko vidi
			urnike rezervacij. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['privacy']['view.reservations']</span>Ali neavtenticiran uporabnik lahko vidi
			podrobnosti rezervacij. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['privacy']['hide.user.details']</span>Ali uporabniki, ki niso administratorji, lahko
		    vidijo osebne podatke ostalih uporabnikov. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['reservation']['start.time.constraint']</span>Kdaj lahko ustvarite ali urejate rezervacije.
			Opcije so future, current, none. Opcija future pomeni, da rezervacije ne moremo ustvariti ali je spreminjati, če je začetni čas
			izbranega časovnega intervala že mimo (v preteklosti). Opcija current pomeni, da rezervacijo lahko ustvarimo ali jo spreminjamo, 
			če končni čas izbranega časovnega intervala še ni pretekel. Opcija none pomeni, da ni omejitev glede časa ustvarjanja ali 
			spreminjanja rezervacij. Privzeto je prihodnji (future).</p>

		<p class="setting"><span>$conf['settings']['reservation']['updates.require.approval']</span>Ali se pri posodobitvah rezervacij, 
		    ki so že bile predhodno potrjene, ponovno zahteva potrditev. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['reservation']['prevent.participation']</span>Ali naj bo uporabniku onemogočeno dodajanje
		    in povabila drugim udeležencem, da se pridružijo rezervaciji. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['reservation']['prevent.recurrence']</span>Ali naj bo uporabniku onemogočeno ustvarjanje
			ponavljajočih se rezervacij. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.add']</span>Ali naj se pošlje sporočilo po e-pošti 
		    vsem administratorjem virov, kadar se ustvari rezervacija. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.update']</span>Ali naj se pošlje sporočilo po e-pošti
		    vsem administratorjem virov, kadar je rezervacija posodobljena. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['reservation.notify']['resource.admin.delete']</span>Ali naj se pošlje sporočilo po e-pošti
		    vsem administratorjem virov, kadar je rezervacija zbrisana. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.add']</span>Ali naj se pošlje sporočilo po e-pošti
		    vsem administratorjem aplikacije, kadar se ustvari rezervacija. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.update']</span>Ali naj se pošlje sporočilo po e-pošti
		    vsem administratorjem aplikacije, kadar je rezervacija posodobljena. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['reservation.notify']['application.admin.delete']</span>Ali naj se pošlje sporočilo po e-pošti
		    vsem administratorjem aplikacije, kadar je rezervacija zbrisana. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.add']</span>Ali naj se pošlje sporočilo po e-pošti 
		    vsem administratorjem skupine, kadar se ustvari rezervacija. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.update']</span>Ali naj se pošlje sporočilo po e-pošti 
		    vsem administratorjem skupine, kadar je rezervacija posodobljena. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['reservation.notify']['group.admin.delete']</span>Ali naj se pošlje sporočilo po e-pošti 
		    vsem administratorjem skupine, kadar je rezervacija zbrisana. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['uploads']['enable.reservation.attachments']</span>Ali je uporabnikom dovoljeno, da pri 
		    rezervacijah pripnejo tudi datoteke. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['uploads']['reservation.attachment.path']</span>Absolutna ali relativna pot v datotečnem sistemu 
		    (relativna na korenski direktorij namestitve sistema Booked Scheduler) do shranjenih priponk k rezervacijam. Ta direktorij mora imeti 
			pravice za pisanje preko PHP (priporočena zaščita 755). Privzeto je uploads/reservation.</p>

		<p class="setting"><span>$conf['settings']['uploads']['reservation.attachment.extensions']</span>Z vejico ločen seznam dovoljenih 
		    končnic datotek. Če pustite prazno, bodo dovoljene vse vrste datotek (kar ni priporočljivo).</p>

		<p class="setting"><span>$conf['settings']['database']['type']</span>Katerikoli podprt tip PEAR::MDB2</p>

		<p class="setting"><span>$conf['settings']['database']['user']</span>Uporabniško ime za dostop do konfigurirane podatkovne baze.</p>

		<p class="setting"><span>$conf['settings']['database']['password']</span>Geslo za uporabnika podatkovne baze.</p>

		<p class="setting"><span>$conf['settings']['database']['hostspec']</span>Gostujoči naslov URL podatkovne baze ali named pipe.</p>

		<p class="setting"><span>$conf['settings']['database']['name']</span>Ime podatkovne baze za Booked Scheduler.</p>

		<p class="setting"><span>$conf['settings']['phpmailer']['mailer']</span>Knjižnica PHP email. Opcije so mail, smtp,
			sendmail, qmail.</p>

		<p class="setting"><span>$conf['settings']['phpmailer']['smtp.host']</span>Gostitelj SMTP, če se uporablja smtp.</p>

		<p class="setting"><span>$conf['settings']['phpmailer']['smtp.port']</span>Vrata SMTP, če se uporablja smtp, navadno so 25.</p>

		<p class="setting"><span>$conf['settings']['phpmailer']['smtp.secure']</span>Varnost SMTP, če se uporablja smtp. Opcije so 
			'', ssl ali tls.</p>

		<p class="setting"><span>$conf['settings']['phpmailer']['smtp.auth']</span>Ali SMTP zahteva avtentikacijo, če se uporablja smtp.
			Opciji sta da (true) ali ne (false).</p>

		<p class="setting"><span>$conf['settings']['phpmailer']['smtp.username']</span>Uporabniško ime za SMTP, če se uporablja smtp.</p>

		<p class="setting"><span>$conf['settings']['phpmailer']['smtp.password']</span>Geslo za SMTP, če se uporablja smtp.</p>

		<p class="setting"><span>$conf['settings']['phpmailer']['sendmail.path']</span>Pot do sendmail, če se uporablja sendmail.</p>

		<p class="setting"><span>$conf['settings']['plugins']['Authentication']</span>Ime uporabljenega vtičnika za avtentikacijo. Več o vtičnikih
		    najdete v spodnjem razdelku Vtičniki.</p>

		<p class="setting"><span>$conf['settings']['plugins']['Authorization']</span>Ime uporabljenega vtičnika za avtorizacijo.
			Več o vtičnikih najdete v spodnjem razdelku Vtičniki.</p>

		<p class="setting"><span>$conf['settings']['plugins']['Permission']</span>Ime uporabljenega vtičnika za dovoljenja
			Več o vtičnikih najdete v spodnjem razdelku Vtičniki.</p>

		<p class="setting"><span>$conf['settings']['plugins']['PreReservation']</span>Ime uporabljenega vtičnika za predrezervacije.
			Več o vtičnikih najdete v spodnjem razdelku Vtičniki.</p>

		<p class="setting"><span>$conf['settings']['plugins']['PostReservation']</span>Ime uporabljenega vtičnika za porezervacije.
			Več o vtičnikih najdete v spodnjem razdelku Vtičniki.</p>

		<p class="setting"><span>$conf['settings']['install.password']</span>Če izvajate namestitev ali posodobitev sistema, boste morali 
			vpisati vrednost, ki je tu določena. To vrednost nastavite na poljubno naključno vrednost.</p>

		<p class="setting"><span>$conf['settings']['pages']['enable.configuration']</span>Ali naj bo stran za urejanje konfiguracij 
			na voljo administratorjem aplikacij. Opciji sta da (true) ali ne (false).</p>

		<p class="setting"><span>$conf['settings']['api']['enabled']</span>Ali naj bo omogočen vmesnik RESTful API programa Booked Scheduler.
			Več o predpogojih za uporabo vmesnika API najdete v datoteki readme_installation.html. Opciji sta da (true) ali ne (false).</p>

		<p class="setting"><span>$conf['settings']['recaptcha']['enabled']</span>Ali naj se uporabi reCAPTCHA namesto vgrajene
			captcha. Opciji sta da (true) ali ne (false).</p>

		<p class="setting"><span>$conf['settings']['recaptcha']['public.key']</span>Javni ključ vaše reCAPTCHA. Obiščite
			www.google.com/recaptcha za prijavo.</p>

		<p class="setting"><span>$conf['settings']['recaptcha']['private.key']</span>Privatni ključ vaše reCAPTCHA. Obiščite
			www.google.com/recaptcha za prijavo.</p>

		<p class="setting"><span>$config['settings']['email']['default.from.address']</span>Naslov e-pošte, ki se uporabi v polju 'od'
			('from') pri pošiljanju elektronske pošte. Če strežniki zavračajo e-pošto ali jo označujejo kot neželjeno pošto (spam), 
			nastavite to vrednost na naslov, ki vsebuje ime vaše domene. Na primer, noreply@yourdomain.com. Ta nastavitev ne spremeni imena 'od' ('from') ali
			naslova za odgovor.</p>

		<p class="setting"><span>$conf['settings']['reports']['allow.all.users']</span>Ali neadministratorji lahko dostopajo do poročil o uporabi. 
		    Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['password']['minimum.letters']</span>Najmanjše število črk, ki jih zahteva uporabniško geslo. Privzeto je 6.</p>

		<p class="setting"><span>$conf['settings']['password']['minimum.numbers']</span>Najmanjše število števk, ki jih zahteva uporabniško geslo. Privzeto je 0.</p>

		<p class="setting"><span>$conf['settings']['password']['upper.and.lower']</span>Ali uporabniško geslo zahteva kombinacijo velikih in malih 
			črk. Privzeto je ne (false).</p>

		<p class="setting"><span>$conf['settings']['reservation.labels']['ics.summary']</span>Format izpisa v polju
			povzetek za ics feeds. Možne oznake so navedene v razdelku Razpoložljivi simboli oznak.</p>

		<p class="setting"><span>$conf['settings']['reservation.labels']['rss.description']</span>Format izpisa v polju
			z opisom za rss/atom feeds. Možne oznake so navedene v razdelku Razpoložljivi simboli oznak.</p>

		<p class="setting"><span>$conf['settings']['reservation.labels']['my.calendar']</span>Format izpisa v oznaki za rezervacije
			na strani Moj koledar. Možne oznake so navedene v razdelku Razpoložljivi simboli oznak.</p>

		<p class="setting"><span>$conf['settings']['reservation.labels']['resource.calendar']</span>Format izpisa v oznaki za rezervacije 
			na strani koledarja virov. Možne oznake so navedene v razdelku Razpoložljivi simboli oznak.</p>
		{literal}
			<p class="setting"><span>$conf['settings']['reservation.labels']['reservation.popup']</span>Format oznake, ki se izpiše v oknu rezervacij.
				Možne vrednosti so {name} {dates} {title} {resources} {participants} {accessories} {description} {attributes}. Dodamo lahko tudi posamezne
				atribute po meri, če uporabimo att skupaj z id atributa. Na primer: {att1}.
				Privzet je izpis vseh informacij.</p>
		{/literal}

	</div>

	<h2>Vtičniki</h2>

	<p>Trenutno lahko uporabite vtičnike za naslednje komponente:</p>

	<ul>
		<li>Avtentikacija - Komu je dovoljeno, da se prijavi.</li>
		<li>Avtorizacija - Kaj lahko dela uporabnik, ko je prijavljen.</li>
		<li>Dovoljenja - Do katerih virov ima uporabnik dostop.</li>
		<li>Predrezervacija - Kaj se zgodi pred tem, ko je rezervacija ustvarjena.</li>
		<li>Porezervacija - Kaj se zgodi po tem, ko je rezervacija ustvarjena.</li>
		<li>Poregistracija - Kaj se zgodi, ko se registrira nov uporabnik.</li>
	</ul>

	<p>
		Vtičnik omogočite tako, da v nastavitvah konfiguracije nastavite vrednost na ime direktorija z vtičnikom. Na primer, da omogočite avtentikacijo preko 
		LDAP, nastavite $conf['settings']['plugins']['Authentication'] = 'Ldap';</p>

	<p>Vtičniki imajo lahko svoje konfiguracijske datoteke. Na primer, za uporabo vtičnika LDAP preimenujte ali prekopirajte 
		/plugins/Authentication/Ldap/Ldap.config.dist v /plugins/Authentication/Ldap/Ldap.config ter uredite vse vrednosti tako, da ustrezajo vašemu okolju.</p>

	<h3>Nameščanje vtičnikov</h3>

	<p>Nov vtičnik namestite tako, da prekopirate direktorij vtičnika v ustrezen poddirektorij v direktoriju plugin. Nato
		spremenite $conf['settings']['plugins']['Authentication'], $conf['settings']['plugins']['Authorization'] ali
		$conf['settings']['plugins']['Permission'] v datoteki config.php tako, da vpišete ime direktorija z vtičnikom.</p>

	<h2>Razpoložljivi simboli oznak</h2>

	<p>Razpoložljivi simboli za oznake rezervacije so
		 {literal}{name}, {title}, {description}, {email}, {phone}, {organization}, {position}, {startdate}, {enddate} {resourcename} {participants} {invitees}{/literal}
		. Lahko dodamo tudi atribute po meri, če uporabimo att skupaj z id atributa. Na primer {literal}{att1}{/literal}
		Pustite prazno, če ni oznak. Uporabite lahko katerokoli kombinacijo simbolov.</p>

	<h2>Povezovanje z Active Directory</h2>

	<p>Sistem Booked lahko avtenticira uporabnike preko Active Directory. Če želite omogočiti to opcijo, najprej nastavite 
	<span class="setting">$conf['settings']['plugins']['Authentication'] = 'ActiveDirectory';</span>
	</p>

	<p>Nato odprite Urejanje aplikacije, izberite Personalizacija in Konfiguracija aplikacije ter izberite datoteko za avtentikacijo ActiveDirectory.</p>

	<p class="setting"><span>$conf['settings']['domain.controllers']</span>Z vejico ločen seznam strežnikov ActiveDirectory; npr. domaincontroller1,controller2
	</p>

	<p class="setting"><span>$conf['settings']['port']</span>Privzeta vrata 389 ali 636 za SSL.</p>

	<p class="setting"><span>$conf['settings']['username']</span>Uporabniško ime administratorja (ni vedno zahtevano).</p>

	<p class="setting"><span>$conf['settings']['password']</span>Geslo administratorja (ni vedno zahtevano).</p>

	<p class="setting"><span>$conf['settings']['basedn']</span>Osnovni dn za vašo domeno. Ta je navadno enak priponi vašega računa, a se mora začeti z DC=.
     	Osnovni dn lahko poiščete med razširjenimi atributi v Active Directory Users and Computers MMC.</p>

	<p class="setting"><span>$conf['settings']['version']</span>Različica protokola LDAP. Privzeto je 3.</p>

	<p class="setting"><span>$conf['settings']['use.ssl']</span>Ali naj uporabi SSL. Tipično je to povezano z vrati, ki so v uporabi.</p>

	<p class="setting"><span>$conf['settings']['account.suffix']</span>Polna pripona računa za vašo domeno. Primer: @uidauthent.domain.com.</p>

	<p class="setting"><span>$conf['settings']['database.auth.when.ldap.user.not.found']</span>Če avtentikacija preko Active Directory ne uspe, 
	    uporabi avtentikacijo preko podatkovne baze sistema Booked Scheduler.</p>

	<p class="setting"><span>$conf['settings']['attribute.mapping']</span>Mapiranje zahtevanih atributov v imena atributov v vašem direktoriju.</p>

	<p class="setting"><span>$conf['settings']['required.groups']</span>Skupina, kateri mora pripadati uporabnik. Uporabnik mora pripadati vsaj eni od navedenih 
	    skupin. Če je prazno, ni omejitev skupin. Npr. Group1,Group2</p>

	<p class="setting"><span>$conf['settings']['sync.groups']</span>Ali naj sinhronizira članstvo v skupini z Booked. Skupine Active Directory morajo biti najprej
		ustvarjene v Booked. Karkoli, kar ne obstaja v Booked, bo izpuščeno.</p>

	<p>Več informacij o konfiguraciji ActiveDirectory najdete na naslovu <a href="http://adldap.sourceforge.net/wiki/doku.php?id=documentation_configuration">http://adldap.sourceforge.net/wiki/doku.php?id=documentation_configuration</a>
	</p>

	<h2>Povezovanje z LDAP</h2>

	<p>Sistem Booked lahko avtenticira uporabnike preko LDAP. Če želite omogočiti to opcijo, najprej nastavite 
	<span class="setting">$conf['settings']['plugins']['Authentication'] = 'Ldap';</span></p>

	<p>Nato odprite Urejanje aplikacije, izberite Personalizacija in Konfiguracija aplikacije ter izberite datoteko za avtentikacijo Ldap.</p>

	<p class="setting"><span>$conf['settings']['host']</span>Z vejico ločen seznam strežnikov LDAP; npr. mydomain1,localhost</p>

	<p class="setting"><span>$conf['settings']['port']</span>Privzeta vrata 389 ali 636 za SSL.</p>

	<p class="setting"><span>$conf['settings']['version']</span>Različica protokola LDAP. Privzeto je 3.</p>

	<p class="setting"><span>$conf['settings']['starttls']</span>WAli naj po vzpostavitvi povezave uporabi TLS.</p>

	<p class="setting"><span>$conf['settings']['binddn']</span>Ime, ki ga poveže z uporabniškim imenom (username). Če to ni določeno, se uporabi anonimna povezava (anonymous).</p>

	<p class="setting"><span>$conf['settings']['bindpw']</span>Geslo za ime binddn. Če je poverilnica napačna, povezava ne bo uspela na strani strežnika in se bo 
	    namesto nje uporabila anonimna povezava. S praznim nizom bindpw zahtevamo neavtenticirano povezavo.</p>

	<p class="setting"><span>$conf['settings']['basedn']</span>Ime osnove LDAP. Npr. dc=example,dc=com</p>

	<p class="setting"><span>$conf['settings']['filter']</span>Privzet filter za iskanje uporabnikov.</p>

	<p class="setting"><span>$conf['settings']['scope']</span>Obseg iskanja uporabnikov. Npr. uid.</p>

	<p class="setting"><span>$conf['settings']['required.group']</span>Skupina, kateri mora pripadati uporabnik. Uporabnik mora pripadati vsaj eni od navedenih 
	    skupin. Če je prazno, ni omejitev skupin. Npr. Group1,Group2</p>

	<p class="setting"><span>$conf['settings']['database.auth.when.ldap.user.not.found']</span>Če avtentikacija preko LDAP ne uspe, 
	    uporabi avtentikacijo preko podatkovne baze sistema Booked Scheduler.</p>

	<p class="setting"><span>$conf['settings']['ldap.debug.enabled']</span>Ali naj omogoči podrobnejše dnevniške zapise za LDAP.</p>

	<p class="setting"><span>$conf['settings']['attribute.mapping']</span>Mapiranje zahtevanih atributov v imena atributov v vašem direktoriju.</p>

	<p class="setting"><span>$conf['settings']['user.id.attribute']</span>Ime atributa za identifikacijo uporabnika. Npr. uid</p>

	<p>Več informacij o konfiguraciji LDAP najdete na naslovu <a href="http://pear.php.net/manual/en/package.networking.net-ldap2.connecting.php">http://pear.php.net/manual/en/package.networking.net-ldap2.connecting.php</a>
	</p>

	<h2>Povezovanje s CAS</h2>

	<p>Sistem Booked lahko za avtentikacijo uporabnikov uporabi CAS. To omogočite tako, da najprej nastavite <span
				class="setting">$conf['settings']['plugins']['Authentication'] = 'CAS';</span></p>

	<p>nato pa odprete Urejanje aplikacij - Prilagoditve - Konfiguracija aplikacije ter izberete datoteko za avtentikacijo CAS.</p>

	<p class="setting"><span>$conf['settings']['cas.version']</span>1.0 = CAS_VERSION_1_0, 2.0 = CAS_VERSION_2_0, S1 = SAML_VERSION_1_1</p>

	<p class="setting"><span>$conf['settings']['cas.server.hostname']</span>Ime strežnika CAS.</p>

	<p class="setting"><span>$conf['settings']['cas.port']</span>Vrata, na katerih teče strežnik CAS.</p>

	<p class="setting"><span>$conf['settings']['cas.server.uri']</span>URI, na katerega odgovarja strežnik CAS.</p>

	<p class="setting"><span>$conf['settings']['cas.change.session.id']</span>Ali dovolimo phpCAS, da spremeni session_id.</p>

	<p class="setting"><span>$conf['settings']['email.suffix']</span>Končnica e-pošte, ki se uporabi ob shranjevanju uporabniškega računa CAS. ex) E-poštni naslovi bodo shranjeni
		v Booked Scheduler kot username@yourdomain.com</p>

	<p class="setting"><span>$conf['settings']['cas_logout_servers']</span>Z vejico ločen seznam strežnikov, ki jih uporabimo za odjavo. Če ne uporabljate strežnikov CAS za odjavo, pustite prazno.</p>

	<p class="setting"><span>$conf['settings']['cas.certificates']</span>Polna pot do certifikata, ki ga uporablja CAS. Če certifikata ne uporabljate, pustite prazno.
	</p>

	<p class="setting"><span>$conf['settings']['cas.debug.enabled']</span>Ali naj omogoči podrobnejše dnevniške zapise za CAS.</p>

	<p class="setting"><span>$conf['settings']['cas.debug.file']</span>Celotna absolutna pot do datoteke za razhroščevanje, če je cas.debug.enabled nastavljen na resnično (true).</p>

	<p>Če uporabljate CAS, morate nastaviti tudi <span class="setting">$conf['settings']['logout.url']</span> na vaš strežnik CAS za odjavo.</p>

	<p>Več informacij o konfiguraciji CAS najdete na naslovu <a href="https://wiki.jasig.org/display/casc/phpcas">https://wiki.jasig.org/display/casc/phpcas</a>.</p>

	<h2>Povezovanje z WordPress</h2>

	<p>Sistem Booked lahko avtenticira uporabnike preko strani WordPress, ki teče na istem strežniku kot Booked. Če želite omogočiti to opcijo, najprej nastavite 
	<span class="setting">$conf['settings']['plugins']['Authentication'] = 'WordPress';</span>
	</p>

	<p>Nato odprite Urejanje aplikacije, izberite Personalizacija in Konfiguracija aplikacije ter izberite datoteko za avtentikacijo WordPress.</p>

	<p class="setting"><span>$conf['settings']['wp_includes.directory']</span>Celotna absolutna pot do direktorija wp-includes ali relativna pot od korenskega direktorija Booked Scheduler.</p>

	<p class="setting"><span>$conf['settings']['database.auth.when.wp.user.not.found']</span>Če avtentikacija preko WordPressa ne uspe, uporabi avtentikacijo preko podatkovne baze sistema Booked Scheduler.</p>


</div>

{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}