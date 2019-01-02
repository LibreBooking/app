{*
Modified by Alenka Kavčič (alenka.kavcic@fri.uni-lj.si), UL FRI, August 2015
Translated and adapted for Slovenian language

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
<h1>Pomoč programa Booked Scheduler</h1>

<div id="help">
<h2>Registracija</h2>

<p>
	Registracija je potrebna pred uporabo sistema Booked Scheduler, če je administrator to omogočil. Po registraciji vašega računa 
	se lahko prijavite v sistem in dostopate do virov, za katere imate dovoljenja za dostop.
</p>

<h2>Rezervacije</h2>

<p>
	V meniju Urnik je podmeni Rezervacije. Ta vam omogoča prikaz razpoložljivih, rezerviranih in onemogočenih terminov na urniku,
	omogoča pa tudi rezervacijo virov, za katere imate dovoljenja.
</p>

<h3>Hitre</h3>

<p>
	Na strani za rezervacije poiščite vir, datum in čas, v katerem bi želeli ta vir rezervirati. Podrobnosti rezervacije lahko spremenite s klikom na označen termin.
	S klikom na gumb Ustvari se preveri razpoložljivost vira v izbranem terminu, zabeleži rezervacija in pošlje sporočilo o rezervaciji po e-pošti. Dobili boste tudi referenčno številko
	rezervacije, ki jo uporabite za sledenje tej rezervaciji.
</p>

<p>Vse spremembe, ki jih naredite pri rezervaciji, se vidne šele po shranjevanju te rezervacije.</p>

<p>Rezervacije v preteklosti lahko ustvarijo le administratorji aplikacije (Application Administrators).</p>

<h3>Več virov</h3>

<p>Vse vire, za katere imate dovoljenja, lahko rezervirate kot del ene same rezervacije. Več virov k vaši rezervaciji dodate tako, da kliknete povezavo
   Več virov, ki je prikazana poleg glavnega vira, ki ga rezervirate. Nove vire lahko dodate tako, da jih izberete in kliknete gumb Opravljeno.</p>

<p>Za brisanje dodatnih virov iz vaše rezervacije izberite povezavo Več virov, odznačite vire, ki jih želite odstraniti, ter kliknite gumb Opravljeno.</p>

<p>Za dodatne vire veljajo enaka pravila kot za osnovni vir. Tako, na primer, če želite narediti dvourno rezervacijo vira 1, ki ima najdaljši možni čas 
   rezervacije 3 ure, in dodatnega vira 2, ki ima najdaljši možni čas rezervacije 1 uro, bo rezervacija zavrnjena.</p>

<p>Podrobnosti konfiguracije vira lahko vidite ob prehodu z miško preko imena vira.</p>

<h3>Ponavljajoči se datumi</h3>

<p>Rezervacijo lahko uredite tako, da se ponavlja na več različnih načinov. Vsi načini ponavljanja vključujejo tudi datum, do katerega se ponavlja.</p>

<p>Opcija ponavljanja omogoča prilagodljive nastavitve možnosti ponavljanja rezervacij. Na primer, nastavitev "Ponovi Dnevno vsak 2 dan" bo ustvarila rezervacije
    vsak drugi dan za celotno obdobje, ki je določeno z datumom začetka in konca. Nastavitev "Ponovi Tedensko vsak 1 teden Na pon, sre, pet" pa bo ustvarila rezervacijo
	na navedene dneve v vseh tednih znotraj določenega obdobja. Če na primer ustvarite rezervacijo na dan 15.01.2016, ki se ponavlja "Mesečno vsak 3 mesec na dan v mesecu",
	se naredijo rezervacije vsak tretji mesec na 15. dan v mesecu. Ker je 15.01.2016 tretji petek v januarju, bi enak primer z izbranim "dan v tednu" ponovil rezervacije
	vsak tretji mesec na tretji petek v mesecu.</p>

<h3>Dodatni udeleženci</h3>

<p>Ko opravite rezervacijo, lahko dodate tudi udeležence ali pa jih povabite k rezervaciji. Če na rezervacijo dodate nekega udeleženca, je ta udeleženec dodan na rezervacijo, 
    vendar se mu ne pošlje povabila po e-pošti. Dodan uporabnik bo prejel sporočilo po e-pošti. Ko povabite uporabnika, se pošlje povabilno sporočilo po e-pošti, uporabnik pa
	ima možnost, da sprejme ali zavrne povabilo. Sprejetje povabila doda uporabnika na seznam udeležencev. Zavrnitev povabila zbriše uporabnika s seznama povabljenih.
</p>

<p>
	Skupno število udeležencev je omejeno na število, ki ga določa kapaciteta udeležencev pri posameznem viru.
</p>

<h3>Dodatki</h3>

<p>Dodatki so objekti, ki jih lahko uporabimo med rezervacijo. Primer takih objektov so projektorji ali atoli. Če želite k rezervaciji 
	dodati dodatke, kliknite na povezavo Dodaj na desni strani naslova dodatka. Nato boste lahko izbrali količino vsakega od dodatkov, 
	ki so na voljo. Količina dodatkov, ki so na voljo v terminu vaše rezervacije, je odvisna od tega, koliko dodatkov je že predhodno rezerviranih.</p>

<h3>Rezervacije v imenu drugih</h3>

<p>Administratorji aplikacije (Application Administrators) in administratorji skupin (Group Administrators) lahko opravijo rezervacije v imenu 
    drugih uporabnikov, če kliknejo na povezavo Spremeni na desni strani uporabniškega imena.</p>

<p>Administratorji aplikacije in administratorji skupin lahko tudi spreminjajo in brišejo rezervacije, ki so jih naredili drugi uporabniki.</p>

<h2>Posodobitev rezervacije</h2>

<p>Katerokoli rezervacijo, ki ste jo ustvarili sami ali nekdo drug v vašem imenu, lahko tudi posodobite.</p>

<h3>Posodobitev določenih primerkov iz zaporedja</h3>

<p>
	Če je rezervacija nastavljena na ponavljanje, se ustvari zaporedje rezervacij. Ko spremenite ali posodobite rezervacijo, 
	vas sistem vpraša, kateri primerek rezervacije v zaporedju želite spremeniti. Spremembe lahko uveljavite le na tistem 
	primerku rezervacije, ki si ga ogledujete (Samo ta primerek) in nobena druga rezervacija iz zaporedja se ne bo spremenila.
	Druga možnost je, da izberete opcijo Vsi primerki in s tem posodobite vse primerke rezervacij, ki se še niso izvršile 
	(torej vse prihodnje rezervacije). Pri tretji možnosti pa lahko spremembe uveljavite le na prihodnjih rezervacijah 
	(Prihodnji primerki), torej na vseh primerkih rezervacij, ki sledijo rezervaciji, ki si jo trenutno ogledujete, in vključno z njo.
</p>

<p>Pretekle rezervacije lahko posodobijo le administratorji aplikacije (Application Administrators).</p>

<h2>Brisanje rezervacije</h2>

<p>Brisanje rezervacije jo v celoti odstrani z urnika. Zbrisana rezervacija ne bo več vidna nikjer v sistemu Booked Scheduler.</p>

<h3>Brisanje določenih primerkov iz zaporedja</h3>

<p>Podobno kot pri posodabljanju rezervacij, lahko tudi pri brisanju rezervacij izberete, katere primerke rezervacij želite zbrisati.</p>

<p>Pretekle rezervacije lahko zbrišejo le administratorji aplikacije (Application Administrators).</p>

<h2>Dodajanje rezervacije v Koledar (Outlook&reg;, iCal, Mozilla Lightning, Evolution)</h2>

<p>Pri ogledu ali posodobitvi rezervacije se vam prikaže gumb Dodaj v Outlook. Če imate na vašem računalniku nameščen Outlook,
    s klikom na ta gumb dodate srečanje v koledar. Če Outlooka nimate nameščenega, lahko prenesete na vaš računalnik le datoteko .ics,
	ki je zapis srečanja v standardnem formatu za koledarje. To datoteko lahko nato uporabite za dodajanje rezervacije na vaš koledar v
	katerikoli aplikaciji, ki podpira format datotek iCalendar.</p>

<h2>Naročnina na Koledarje</h2>

<p>Koledarji so lahko na voljo za urnike, vire in uporabnike. Zato mora administrator v konfiguracijski datoteki nastaviti 
    ključ za naročnino. Če želite omogočiti naročnino na koledarje na nivoju urnika in virov, le vključite naročnino, ko urejate
    urnik ali vire. Če želite omogočiti naročnino na osebni koledar uporabnika, odprite Urnik -> Moj koledar. Na desni strani 
	poiščite povezavo, ki Vključi ali Izključi naročnino na koledar.
</p>

<p> Če se želite naročiti na koledar urnika, odprite Urnik -> Koledar virov ter izberite urnik, ki vas zanima. Na desni strani
    poiščite povezavo za naročnino na trenutni koledar. Pri naročanju na koledar virov uporabite enake korake. Pri naročanju na vaš osebni koledar
	odprite Urnik -> Moj koledar. Na desni strani poiščite povezavo za naročilo na trenutni koledar.</p>

<h3>Odjemalec Koledar (Outlook&reg;, iCal, Mozilla Lightning, Evolution)</h3>

<p>V večini primerov bo klik na povezavo Naroči se na ta koledar samodejno vzpostavil naročnino v vašem odjemalcu za koledar. Pri odjemalcu Outlook,
    če se naročnina ne vzpostavi samodejno, odprite pogled koledarja, nato z desnim gumbom kliknite Moj koledar in izberite	Dodaj koledar -> Z interneta.
	Prilepite naslov URL, ki je v sistemu Booked Scheduler izpisan pod povezano Naroči se na ta koledar.</p>

<h3>Koledar Google&reg;</h3>

<p>Odprite nastavitve koledarja Google Calendar. Kliknite na zavihek koledarji (Calendars). Kliknite Prebrskaj zanimive koledarje (Browse interesting calendars). 
    Kliknite Dodaj URL. Prilepite naslov URL, ki je v sistemu Booked Scheduler izpisan pod povezano Naroči se na ta koledar.</p>

<h2>Kvote</h2>

<p>Administratorji lahko določijo pravila za kvoto na podlagi različnih kriterijev. Če bi vaša rezervacija presegla katerokoli kvoto 
    (kršila katerokoli pravilo), vas sistem o tem obvesti, rezervacija pa je zavrnjena.</p>

</div>
{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}