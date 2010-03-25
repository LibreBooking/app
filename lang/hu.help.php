<?php
/**
* Hungarian (hu) help translation file.
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Your Name <your@email.com>
* @version 01-08-05
* @package Languages
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
///////////////////////////////////////////////////////////
// INSTRUCTIONS
///////////////////////////////////////////////////////////
// This file contains all the help file for phpScheduleit.  Please save the translated
//  file as '2 letter language code'.help.php.  For example, en.help.php.
// 
// To make phpScheduleIt help available in another language, simply translate this
//  file into your language.  If there is no direct translation, please provide the
//  closest translation.
//
// This will be included in the body of the help file.
//
// Please keep the HTML formatting unless you need to change it.  Also, please try
//  to keep the HTML XHTML 1.0 Transitional complaint.
///////////////////////////////////////////////////////////
?>
<div align="center"> 
  <h3><a name="top" id="top"></a>Bevezetõ a phpScheduleIt használatába</h3>
  <p><a href="http://phpscheduleit.sourceforge.net" target="_blank">http://phpscheduleit.sourceforge.net</a></p>
  <table width="100%" border="0" cellspacing="0" cellpadding="5" style="border: solid #CCCCCC 1px">
    <tr> 
      <td bgcolor="#FAFAFA"> 
        <ul>
          <li><b><a href="#getting_started">Bevezetés</a></b></li>
          <ul>
            <li><a href="#registering">Regisztráció</a></li>
            <li><a href="#logging_in">Bejelentkezés</a></li>
            <li><a href="#language">Nyelv Választás</a></li>
            <li><a href="#manage_profile">Jelszó Váltás/Profil Szerkesztés</a></li>
            <li><a href="#resetting_password">Elfelejtett Jelszó Visszaállítása</a></li>
            <li><a href="#getting_support">Támogatás</a></li>
          </ul>
          <li><a href="#my_control_panel"><b>Irányító Pult</b></a></li>
          <ul>
            <li><a href="#quick_links">Gyors Linkek</a></li>
			<li><a href="#my_announcements">Bejelentések</a></li>
            <li><a href="#my_reservations">Elõjegyzések</a></li>
            <li><a href="#my_training">Jogosultságok</a></li>
			<li><a href="#my_invitations">Meghívók</a></li>
			<li><a href="#my_participation">Meghívott Részvételek</a></li>         
          </ul>
          <li><a href="#using_the_scheduler"><b>Az Elõjegyzés Használata</b></a></li>
          <ul>
			<li><a href="#read_only">Csak Olvasható Mód</a></li>
            <li><a href="#making_a_reservation">Elõjegyzés Menete</a></li>
            <li><a href="#modifying_deleting_a_reservation">Elõjegyzés 
              Módosítása/Törlése</a></li>
            <li><a href="#navigating">Barangolás az Elõjegyzési Rendszerben</a></li>
          </ul>
        </ul>
		<hr width="95%" size="1" noshade="noshade" /> 
        <h4><a name="getting_started" id="getting_started"></a>Bevezetés</h4> 
        <p>A phpScheduleIt használatához elsõként regisztrálni kell. 
          Ammennyiben már regisztrált, akkor be kell jelentkeznie a Rendszerbe. 
          Minden oldal tetején (kivéve a regisztrációs és a bejelentkezõ oldalt)
          egy köszöntõ üzenetet talál, az aktuális dátummal és néhány linkkel. 
          A &quot;Kilépés&quot; link és az &quot;Irányító Pult&quot; link 
          a köszöntõ üzenet alatt, a &quot;Segítség&quot; link pedig a napi 
          dátum alatt helyezkedik el.</p> 
          <p>Ha más Felhasználó nevét olvassa a Köszöntõben, klikkeljen a &quot;Kilépés&quot; 
          linkre, amivel érvényteleníti a sütiket, majd kattintson a <a href="#logging_in">Belépés</a>
          linkre a bejelentkezéshez. Az &quot;Irányító Pult&quot; linkkel az 
          <a href="#my_control_panel">Irányító Pultra</a> jut, amely az Ön &quot;központi 
          lapja&quot; az elõjegyzõ Rendszerben. 
          Amennyiben ráklikkel a &quot;Segítség&quot; linkre, egy felugró ablak jelenik meg. 
          A &quot;Levél Küldése az Adminisztrátornak&quot; linket választva egy beviteli mezõ 
          jelenik meg, mellyel az Rendszer karbantartójának üzenhet.</p> 
          <p><font color="#FF0000">Figyelem:</font> Ha az ön gépén fut a Norton Personal 
            Firewall miközben a phpScheduleIt-et használja, akkor problémák léphetnek fel. 
            Kérem kapcsolja ki a Norton Personal Firewallt, ameddig a phpScheduleIt-tel 
            dolgozik és kapcsolja vissza amint végzett a teendõivel.</p> 
          <p align="right"><a href="#top">Ugrás a tetejére</a></p> 
        <h5><a name="registering" id="registering"></a>Regisztráció</h5> 
        <p>Regisztrációhoz menjen a Regisztrációs oldalra. Ez elérhetõ egy link 
          segítségével a bejelentkezõ oldalon. Töltsön ki minden szükséges mezõt.
          A megadott email cím lehet egyben a Felhasználói Neve is. A megadott 
          adatokat bármikor megváltoztathatja: <a href="#quick_links">Profil 
          Megváltoztatása</a>. Ha bejelöli az &quot;Õrizzen meg bejelentkezett állapotban&quot; 
          opciót, akkor a rendszer sütiket fog használni az ön azonosítására minden alkalommal, 
          feleslegessé téve ezzel az ismételt bejelentkezést. <i>Csak akkor használja ezt az 
          opciót, ha Ön az egyedüli, aki a phpScheduleIt-et használja az adott géprõl.</i> 
          Regisztráció után Ön automatikusan az <a href="#my_control_panel"> 
          Irányító Pultra</a> kerül.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>
        <h5><a name="logging_in" id="logging_in"></a>Bejelentkezés</h5>
        <p>Bejelentkezéskor egyszerûen csak meg kell adni a Felhasználó Nevet és a 
          Jelszavát. Elõbb <a href="#registering">Regisztrálnia</a> kell mielõtt 
          be tudna jelentkezni. Ezt a Regisztráció linkre kattintva teheti meg az 
          induló oldalon. Ha bejelöli az &quot;Õrizzen meg bejelentkezett állapotban&quot; 
          opciót, akkor a rendszer sütiket fog használni az ön azonosítására minden alkalommal, 
          feleslegessé téve ezzel az ismételt bejelentkezést. <i>Csak akkor használja ezt az 
          opciót, ha Ön az egyedüli, aki a phpScheduleIt-et használja az adott géprõl.</i> 
          Regisztráció után Ön automatikusan az <a href="#my_control_panel"> 
          Irányító Pultra</a> kerül.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>
        <h5><a name="language" id="language"></a>Nyelv Választás</h5>
        <p>A Bejelentkezõ oldalon elérhetõ egy legördülõ menü, amelyben megtalálható az
          összes nyelv, amelyet az Adminisztrátor beállított<a href="#my_control_panel"></a>.
          Kérem válassza ki a kívánt nyelvet és minden phpScheduleIt felírat és üzenet
          ezen a nyelven fog szólni. A bevitt információk nem kerülnek fordításra
          sem az adminisztrátor sem más felhasználók által; a Nyelv Választás csak az 
          alkalmazás szövegezésére terjed ki. Önnek ki kell jelentkeznie, ha egy 
          másik nyelvet akar kiválasztani.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>        
        <h5><a name="manage_profile" id="manage_profile"></a>Profil Szerkesztés/Jelszó Váltás</h5>
        <p>Ha az adatait módosítani szeretné (név, email cím, stb.) vagy jelszót váltana, 
          elsõként jelentkezzen be. Az <a href="#my_control_panel">Irányító Pulton
          </a>, a <a href="#quick_links">Gyors Linkek</a> között, klikkeljen a &quot;Profil 
          Szerkesztése/Jelszó Váltás&quot; linkre. Ez egy olyan oldalra viszi, 
          ahol az adatai vannak felsorolva. Szerkessze azokat tetszése szerint. Az üresen 
          hagyott mezõk tartalma nem fog változni. Amennyiben a Jelszavát szeretné Megváltoztatni, 
          írja azt be kétszer. Amikor végrehajtotta a kívánt változtatásokat, klikkeljen a &quot;Profil Szerkesztése&quot; 
          linkre és a változások érvénybe fognak lépni. Végezetül vissza fog kerülni az 
          Irányító Pultra.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>
        <h5><a name="resetting_password" id="resetting_password"></a>Elfelejtett Jelszó Visszaállítása</h5>
        <p>Amennyiben elfelejtette a Jelszavát, kérheti, hogy a rendszer adjon egy újat 
          önnek és küldje el email-ben. Ehhez keresse fel és kövesse a Bejelentkezõ oldalon az  
          &quot;Elfelejtett Jelszó&quot; linket a Bejelentekezõ mezõ alatt. 
          Egy új oldalra fog kerülni, ahol meg kell adnia email címét. 
          Miután ráklikkelt a &quot;Küldés&quot; linkre, a rendszer egy Új, véletlen jelszót 
          generál. Az Újdonsült Jelszó bekerül az adatbázisba és a Rendszer elküldi Önnek 
          email-ben. Nyissa meg a levelet és másolja át a jelszavát a bejelentkezéhez, 
          <a href="#logging_in">Jelentkezzen be</a> vele, és nyomban <a href="#manage_profile">változtassa 
          meg azt</a>.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>
        <h5><a name="getting_support" id="getting_support"></a>Támogatás</h5>
        <p>Ha nincs joga egy Kontingens használatához, kérdése van egy Kontingenssel, 
          Elõjegyzéssel, vagy a Felhasználójával kapcsolatban, kérem használja az &quot;Email
          küldése az Adminisztrátornak&quot; linket,
          melyet <a href="#quick_links">Gyors Linkek</a> között találhat meg.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>        <p align="right">&nbsp;</p>
        <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="my_control_panel" id="my_control_panel"></a>Irányító Pult</h4>
        <p>Az Irányító Pult az Ön &quot;Kiinduló pontja&quot; az Elõjegyzési Rendszer 
          kezeléséhez. Itt megtekintheti, módosíthatja, vagy törölheti Elõjegyzéseit. 
          Az Irányító Pult is tartalmaz <a href="#using_the_scheduler">Elõjegyzés</a>, 
          és <a href="#quick_links">Profil Módosítása</a> linket és egy opciót is, amivel 
          kijelentkezhet az Elõjegyzési Rendszerbõl.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>
        <h5><a name="quick_links" id="quick_links"></a>Gyors Linkek</h5>
        <p>A Gyors Linkek révén egy helyen megtalálhatók a legfontosabb linkek.
          Az elsõ az &quot;Elõjegyzés&quot;, mely az alapértelmezett
          Elõjegyzéshez vezet. Itt megtekintheti és átnézheti a Kontingenseit, 
          és módosíthatja Elõjegyzéseit.</p>
        <p>A &quot;Saját Naptár Megtekintése&quot; az Elõjegyzés Naptár Nézetéhez vezet,
          melyben azok az Elõjegyzések szerepelnek, melyekben Ön is Résztvevõ. Megtekinthetõ
          Napi, Heti, vagy Havi Bontásban is.</p>
        <p>A &quot;Kontingens Naptár Megtekintése&quot; elviszi Önt a Rendszer
          Naptárához, amelyben az összes, vagy egy kiválasztott Elõjegyzés 
          Vizsgálatait tekintheti meg. Ha kiválaszt egy Elõjegyzést a Napi Nézetben,
          lehetõsége van kinyomtatni a &quot;Lista Nézetet&quot;, amennyiben
          a jegyzettömb ikonra kattint, a Kontingens melletti legördülõ menüben.</p>
        <p>A &quot;Profil Szerkesztése/Jelszó Váltás&quot; link egy olyan oldalra
          vezet, ahol megváltoztathatja olyan adatait, mint: a Felhasználói Név, 
          Email cím, Név, Telefonszám és a Jelszó. Minden mezõbe bekerül a megadott
          érték. Az üresen, vagy változatlanul hagyott mezõk nem változnak.</p>
        <p>Az &quot;Email Beállítások Szerkesztése&quot; olyan oldalra visz, ahol
          megválaszthatja, hogy hogyan és milyen formában szeretne visszajelzést
          kapni az Elõjegyzéseirõl. Alap értelmezés szerint a Rendszer HTML emailben
          értesíti minden alkalommal, amikor hozzáad, módosít, vagy töröl egy elõjegyzést.</p>
        <p>Végül a legutolsó link, a &quot;Kilépés&quot; kilépteti a Rendszerbõl, majd
          visszakerül a Bejelentkezõ oldalara.</p>
        <p align="right"><a href="#top">Vissza a tetejére</a></p>
        <h5><a name="my_announcements" id="my_announcements"></a>Bejelentések</h5>
        <p>A Bejelentések között olyan információkat talál, amiket az Adminisztrátor
          közlésre fontosnak ítélt.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>
        <h5><a name="my_reservations" id="my_reservations"></a>Elõjegyzések</h5>
        <p>Az Elõjegyzések lista tartalmaz minde eljövendõ Elõjegyzést az aktuális 
          naptól számítva (alapértelmezés). A táblázatban megtalálható az Elõjegyzés 
          Dátuma, Kontingense, a Létrehozás ideje, az utolsó Módosítás ideje, valamint a
          Kezdõ és a Befejezõ Idõpont. A listából kiindulva az Elõjegyzések 
          Módosítani és Törölni lehet a &quot;Módosítás&quot; vagy a &quot;Törlés&quot; 
          linkre kattintva a megfelelõ Elõjegyzés sorának végén lévõ linkre kattintva. 
          Mindkét esetben egy elõugró ablakban határozhatja meg a kívánt változtatásokat. 
          Az Elõjegyzés Idõpontjára kattintva egy új elõreugró ablak jelenik meg, 
          melyen megtekintheti a részleteket.</p>
        <p>Az Elõjegyzések rendezési módjának megváltoztatásához kattintson a &#150; 
          vagy a + linkre az oszlop tetején. A mínusz jellel az adott oszlopra nézve 
          csökkenõ sorrendben kérhetõk az Elõjegyzési lista elemei, a plussz jellel az 
          aktuális oszlopnak megfelelõen növekvõ sorrendben listázhatók az Elõjegyzések.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>
        <h5><a name="my_training" id="my_training"></a>Jogosultságok</h5>
        <p>A Jogosultságok között fel van sorolva minden Kontingens, amelyre írási joga van.
	  A listán megtalálható a Kontingens neve, a Helyszín és a Telefon szám, amelyen 
          érdeklõdhet az Adminisztrátornál.</p>
        <p>Regisztrációt követõen a Felhasználó nem tud egyik Kontingensbe sem írni, hacsak a 
	  az Adminisztrátor nem határozott úgy, hogy a Felhasználók alapértelmezett Jogosultságot kapnak. 
	  Az Adminisztrátor az egyetlen személy, aki Jogosultságot adhat egy Kontingenshez. Amíg ez nem 
          történik meg, Ön nem írhat azokba a Kontingensekbe, amelyekhez nincs joga, de az Elõjegyzést 
          megtekintheti.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>
        <h5><a name="my_invitations" id="my_invitations"></a>Meghívások</h5>
        <p>A Meghívások között megtalálható minden Elõjegyzés, amelyre Meghívást kapott,
          és lehetõsége nyílik az Elõjegyzésben való Részvétel Elfogadására és
          Visszautasítására. Ha elfogadta a Részvételt, a késõbbiekben még lehetõsége
          van rá, hogy felfüggessze azt. Visszautasítás esetén csak akkor tud Résztvevõként
          szerepelni egy Elõjegyzésben, ha az adott Elõjegyzés létrehozója ismételten
          meghívja Önt.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>        
        <h5><a name="my_participation" id="my_participation"></a>Részvételek</h5>
        <p>A Részvételek képernyõn megtalálhat minden Elõjegyzést, amelyben
          Résztvevõként szerepel. Nem mutatkoznak azok az Elõjegyzések, melyeknek
          Ön a gazdája. Az táblázaton lehetõség nyílik a Részvétel Felfüggesztésére
          egy kiválasztott Elõjegyzésben. Ha befejezi a Részvételt egy Elõjegyzésben,
          Nem fog tudni résztvenni benne, hacsak az Elõjegyzés létrehozója nem Hivja meg
          Önt ismételten.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>        <p align="right">&nbsp;</p>
        <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="using_the_scheduler" id="using_the_scheduler"></a>A Rendszer használata</h4>
        <p>Az Elõjegyzési Rendszerben végrehajthat minden Elõjegyzési funkciót.
          A Heti Bontás az aktuális hetet mutatja, és alapértelmezésben 7 napos
          idõszakot mutat. Váltogathat az Elõjegyzések között, megtekintheti a Kontingenseket
          és módosíthatja Elõjegyzéseit. Az Elõjegyzések színkódoltak, és mindegyik látható
          de csak az <i>Ön</i> által létrehozottak esetében
          található link a szerkesztéshez. A többi Elõjegyzés esetén csak a megtekintéshez
          használható link érhetõ el.</p>
        <p>Az elõjegyzések között (amennyiben több is létezik) a fönt található legördülõ
          menü segítségével válthat.</p>
        <p>A Rendszer Adminisztrátor meghatározhat &quot;Tiltott Idõpontokat&quot;,
          amelyek nem lesznek elérhetõek. Az Elõjegyzés nem kerül bejegyzésre,
          ha egy Tiltott Idõponttal ütközés tapasztalható.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>
        <h5><a name="read_only" id="read_only"></a>Csak Olvasható Mód</h5>
        <p>Ha nem Regisztrált, vagy nem jelentkezett be, akkor megtekintheti az Elõjegyzés
          Csak Olvasható változatát, ha ráklikkel a &quot;Csak Olvasható Mód&quot; linkre
          a bejelentkezõ oldalon. Ekkor látható minden Kontingens és Elõjegyzés,
          de Ön sem részleteket nem tekinthet meg egyikrõl sem, sem az Elõjegyzések
          szerkesztésére vagy létrehozására nem lesz lehetõsége.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>
        <h5><a name="making_a_reservation" id="making_a_reservation"></a>Elõjegyzés Létrehozása</h5>
        <p>Egy elõjegyzés létrehozásához elsõként arra a napra kell navigálnia,
          amelyikre az Elõjegyzést létre szeretné hozni. Amikor megtalálta a kiválasztott
          naphoz tartozó oldalt, kattintson a Kontingens nevére, vagy a kivánt idõpontra. Ekkor egy elõre
          ugró ablakban kiválaszthatja a Kezdõ és Befejezõ idõpontot (ha engedélyezett)
          amelyek között Elõjegyzését létre szeretné hozni.</p>
        <p>Az Elõjegyzés hosszára vonatkozó információkat tartalmazó üzenetet találhat
          az idõszak kiválasztására szolgáló mezõ alatt. Ha az elõjegyzése rövidebb,
          vagy hosszabb a megadott intervallumnál, a Rendszer nem fogja elfogadni.</p>
        <p>Az ablakban lehetõsége van Ismétlõdõ Elõjegyzés létrehozására is.
          Elsõként válassza ki, hogy mely napokon szeretné, hogy az Elõjegyzés ismétlõdjön,
          majd meg kell adnia, hogy milyen hosszú idõszakra vonatkozzon. Az Elõjegyzés
          bejegyzésre kerül a kiinduló napra és minden további megadott napra
          a meghatározott idõszakon belül. Minden olyan alkalmat, amikor valamilyen okból
          nem hozható létre Ismételt Elõfordulás a Rendszer kijelez. Ha Többnapos Elõjegyzések
          létrehozásakor Ismételt Elõfordulás nem választható.</p>
        <p>Az Elõjegyzéséhez tartozó adatokat a Megjegyzés mezõben közölje.
          A Megjegyzés mezõt azután minden Felhasználó megtekintheti, hogy 
          informálódjon az Elõjegyzése részletei felõl.</p>
        <p>Miután meghatározta az Elõjegyzés Kezdõ és Befejezõ Idõpontját,
           és igényei szerint kiválasztotta a kívánt ismétlõdéseket, nyomja
           meg a &quot;Mentés&quot; gombot.
           A Rendszer ezt követõen egy üzenetet küld, hogy mely alkalmakra nem tudta
           tudta teljesíteni a kérést. Sikertelen próbálkozás esetén menjen vissza és 
           változtassa meg az Idõpontokat oly módon, hogy ne forduljon elõ átfedés más
           Elõjegyzéssel. Az Elõjegyzés elfogadása esetén a Rendszer automatikusan
           frissül. Ez elõfeltétele, hogy minden új információ kijelzésre kerüljön.</p>
        <p>Nem hozhat létre Elõjegyzést olyan idõpontra, amelyik már elmúlt, továbbá olyan
           Kontingensbe, amelyhez nincsen írási Jogosultsága vagy olyan Elõjegyzésbe
           amely Inaktív. Ilyen esetben a Kontingens szürkén jelenik meg és nem érhetõ
           el olyan link, amely elõhozná az elõre ugró ablakot.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>
        <h5><a name="modifying_deleting_a_reservation" id="modifying_deleting_a_reservation"></a>Elõjegyzés Módosítása/Törlése</h5>
        <p>Egy Elõjegyzés Törlése, vagy Módosítása több módon is lehetséges. Az egyiket
           az <a href="#my_control_panel">Irányító Pultnál</a> már olvashatta.
           Az Online Elõjegyzésben - mint már az korábban is említésre került - 
           szintén megteheti. A nem Módosítható/Törölhetõ Elõjegyzések esetén
           a Rendszer nem kínálja fel a linket.</p>
        <p>Az Elõjegyzési Rendszerben rendkívül egyszerû módon elég a kívánt
          Elõjegyzésre kattintania. Ezután az Elõjegyzés Létrehozásakor
          látható ablakhoz hasonló elõre ugró ablak jelenik meg. Két választása
          van: a Kezdõ és a Befejezõ idõpontok Módosítása után választhatja a &quot;Módosítás&quot;
          gombot az oldal alján, az Elõjegyzés törléséhez pedig ez elõtt a &quot;Törlés&quot;
          opciót is be kell jelölnie. A megadott új adatok ellenõrzésre kerülnek a
          Rendszerben a többi Elõjegyzéshez képest és a Rendszer visszajelzést
          ad, hogy sikeres volt-e a változtatás. Ha az idõpontok nem stimmelnek
          térjen vissza a Módosítás ablakba, hogy kijavíthassa az átfedéseket 
          Sikeres módosítás esetén az Elõjegyzési Rendszer automatikusan frissül,
          és a képernyõ újra betöltõdik. Erre azért van szükség, hogy láthatóvá váljanak
          az Ön által végrehajtott változások.</p>
        <p>Ismételten Elõforduló Elõjegyzések változtatásakor, jelölje be az
          &quot;Ismételt Elõfordulások Frissítése&quot; opciót. Az érvénytelen
          elõfordulásokat a Rendszer visszajelzi Önnek.</p>
        <p>Nem módosíthat olyan ELõjegyzést, amely már elmúlt.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>
        <h5><a name="navigating" id="navigating"></a>Barangolás az Elõjegyzési Rendszerben</h5>
        <p>Számtalan lehetõsége van az Elõjegyzési Rendszerben történõ barangolásra.</p>
        <p>A hetek között az &quot;Elõzõ Hét&quot; és a &quot;Következõ Hét&quot; link
          segítségével válthat. Ezek az Elõjegyzés alján találhatók</p>
        <p>Lehetõség van a kiválasztott napra történõ ugrásra, ha megadja azt a lap alján.</p>
        <p>A Naptár elõhozása a &quot;Naptár Megtekintése&quot; linkkel lehetséges, amely
          a lap alján található. Válaszza ki a megfelelõ lapot és rákattintva a kiválasztott
          napra ugrik az Elõjegyzési Rendszer.</p>
        <p align="right"><a href="#top">Ugrás a tetejére</a></p>
      </td>
    </tr>
  </table>
</div>