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
?><div align="center">
  <h3><a name="top" id="top"></a>Bevezet� a phpScheduleIt haszn�lat�ba</h3>
  <p><a href="http://phpscheduleit.sourceforge.net" target="_blank">http://phpscheduleit.sourceforge.net</a></p>
  <table width="100%" border="0" cellspacing="0" cellpadding="5" style="border: solid #CCCCCC 1px">
    <tr> 
      <td bgcolor="#FAFAFA"> 
        <ul>
          <li><b><a href="#getting_started">Bevezet�s</a></b></li>
          <ul>
            <li><a href="#registering">Regisztr�ci�</a></li>
            <li><a href="#logging_in">Bejelentkez�s</a></li>
            <li><a href="#language">Nyelv V�laszt�s</a></li>
            <li><a href="#manage_profile">Jelsz� V�lt�s/Profil Szerkeszt�s</a></li>
            <li><a href="#resetting_password">Elfelejtett Jelsz� Vissza�ll�t�sa</a></li>
            <li><a href="#getting_support">T�mogat�s</a></li>
          </ul>
          <li><a href="#my_control_panel"><b>Ir�ny�t� Pult</b></a></li>
          <ul>
            <li><a href="#quick_links">Gyors Linkek</a></li>
			<li><a href="#my_announcements">Bejelent�sek</a></li>
            <li><a href="#my_reservations">El�jegyz�sek</a></li>
            <li><a href="#my_training">Jogosults�gok</a></li>
			<li><a href="#my_invitations">Megh�v�k</a></li>
			<li><a href="#my_participation">Megh�vott R�szv�telek</a></li>         
          </ul>
          <li><a href="#using_the_scheduler"><b>Az El�jegyz�s Haszn�lata</b></a></li>
          <ul>
			<li><a href="#read_only">Csak Olvashat� M�d</a></li>
            <li><a href="#making_a_reservation">El�jegyz�s Menete</a></li>
            <li><a href="#modifying_deleting_a_reservation">El�jegyz�s 
              M�dos�t�sa/T�rl�se</a></li>
            <li><a href="#navigating">Barangol�s az El�jegyz�si Rendszerben</a></li>
          </ul>
        </ul>
		<hr width="95%" size="1" noshade="noshade" /> 
        <h4><a name="getting_started" id="getting_started"></a>Bevezet�s</h4> 
        <p>A phpScheduleIt haszn�lat�hoz els�k�nt regisztr�lni kell. 
          Ammennyiben m�r regisztr�lt, akkor be kell jelentkeznie a Rendszerbe. 
          Minden oldal tetej�n (kiv�ve a regisztr�ci�s �s a bejelentkez� oldalt)
          egy k�sz�nt� �zenetet tal�l, az aktu�lis d�tummal �s n�h�ny linkkel. 
          A &quot;Kil�p�s&quot; link �s az &quot;Ir�ny�t� Pult&quot; link 
          a k�sz�nt� �zenet alatt, a &quot;Seg�ts�g&quot; link pedig a napi 
          d�tum alatt helyezkedik el.</p> 
          <p>Ha m�s Felhaszn�l� nev�t olvassa a K�sz�nt�ben, klikkeljen a &quot;Kil�p�s&quot; 
          linkre, amivel �rv�nytelen�ti a s�tiket, majd kattintson a <a href="#logging_in">Bel�p�s</a>
          linkre a bejelentkez�shez. Az &quot;Ir�ny�t� Pult&quot; linkkel az 
          <a href="#my_control_panel">Ir�ny�t� Pultra</a> jut, amely az �n &quot;k�zponti 
          lapja&quot; az el�jegyz� Rendszerben. 
          Amennyiben r�klikkel a &quot;Seg�ts�g&quot; linkre, egy felugr� ablak jelenik meg. 
          A &quot;Lev�l K�ld�se az Adminisztr�tornak&quot; linket v�lasztva egy beviteli mez� 
          jelenik meg, mellyel az Rendszer karbantart�j�nak �zenhet.</p> 
          <p><font color="#FF0000">Figyelem:</font> Ha az �n g�p�n fut a Norton Personal 
            Firewall mik�zben a phpScheduleIt-et haszn�lja, akkor probl�m�k l�phetnek fel. 
            K�rem kapcsolja ki a Norton Personal Firewallt, ameddig a phpScheduleIt-tel 
            dolgozik �s kapcsolja vissza amint v�gzett a teend�ivel.</p> 
          <p align="right"><a href="#top">Ugr�s a tetej�re</a></p> 
        <h5><a name="registering" id="registering"></a>Regisztr�ci�</h5> 
        <p>Regisztr�ci�hoz menjen a Regisztr�ci�s oldalra. Ez el�rhet� egy link 
          seg�ts�g�vel a bejelentkez� oldalon. T�lts�n ki minden sz�ks�ges mez�t.
          A megadott email c�m lehet egyben a Felhaszn�l�i Neve is. A megadott 
          adatokat b�rmikor megv�ltoztathatja: <a href="#quick_links">Profil 
          Megv�ltoztat�sa</a>. Ha bejel�li az &quot;�rizzen meg bejelentkezett �llapotban&quot; 
          opci�t, akkor a rendszer s�tiket fog haszn�lni az �n azonos�t�s�ra minden alkalommal, 
          feleslegess� t�ve ezzel az ism�telt bejelentkez�st. <i>Csak akkor haszn�lja ezt az 
          opci�t, ha �n az egyed�li, aki a phpScheduleIt-et haszn�lja az adott g�pr�l.</i> 
          Regisztr�ci� ut�n �n automatikusan az <a href="#my_control_panel"> 
          Ir�ny�t� Pultra</a> ker�l.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>
        <h5><a name="logging_in" id="logging_in"></a>Bejelentkez�s</h5>
        <p>Bejelentkez�skor egyszer�en csak meg kell adni a Felhaszn�l� Nevet �s a 
          Jelszav�t. El�bb <a href="#registering">Regisztr�lnia</a> kell miel�tt 
          be tudna jelentkezni. Ezt a Regisztr�ci� linkre kattintva teheti meg az 
          indul� oldalon. Ha bejel�li az &quot;�rizzen meg bejelentkezett �llapotban&quot; 
          opci�t, akkor a rendszer s�tiket fog haszn�lni az �n azonos�t�s�ra minden alkalommal, 
          feleslegess� t�ve ezzel az ism�telt bejelentkez�st. <i>Csak akkor haszn�lja ezt az 
          opci�t, ha �n az egyed�li, aki a phpScheduleIt-et haszn�lja az adott g�pr�l.</i> 
          Regisztr�ci� ut�n �n automatikusan az <a href="#my_control_panel"> 
          Ir�ny�t� Pultra</a> ker�l.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>
        <h5><a name="language" id="language"></a>Nyelv V�laszt�s</h5>
        <p>A Bejelentkez� oldalon el�rhet� egy leg�rd�l� men�, amelyben megtal�lhat� az
          �sszes nyelv, amelyet az Adminisztr�tor be�ll�tott<a href="#my_control_panel"></a>.
          K�rem v�lassza ki a k�v�nt nyelvet �s minden phpScheduleIt fel�rat �s �zenet
          ezen a nyelven fog sz�lni. A bevitt inform�ci�k nem ker�lnek ford�t�sra
          sem az adminisztr�tor sem m�s felhaszn�l�k �ltal; a Nyelv V�laszt�s csak az 
          alkalmaz�s sz�vegez�s�re terjed ki. �nnek ki kell jelentkeznie, ha egy 
          m�sik nyelvet akar kiv�lasztani.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>        
        <h5><a name="manage_profile" id="manage_profile"></a>Profil Szerkeszt�s/Jelsz� V�lt�s</h5>
        <p>Ha az adatait m�dos�tani szeretn� (n�v, email c�m, stb.) vagy jelsz�t v�ltana, 
          els�k�nt jelentkezzen be. Az <a href="#my_control_panel">Ir�ny�t� Pulton
          </a>, a <a href="#quick_links">Gyors Linkek</a> k�z�tt, klikkeljen a &quot;Profil 
          Szerkeszt�se/Jelsz� V�lt�s&quot; linkre. Ez egy olyan oldalra viszi, 
          ahol az adatai vannak felsorolva. Szerkessze azokat tetsz�se szerint. Az �resen 
          hagyott mez�k tartalma nem fog v�ltozni. Amennyiben a Jelszav�t szeretn� Megv�ltoztatni, 
          �rja azt be k�tszer. Amikor v�grehajtotta a k�v�nt v�ltoztat�sokat, klikkeljen a &quot;Profil Szerkeszt�se&quot; 
          linkre �s a v�ltoz�sok �rv�nybe fognak l�pni. V�gezet�l vissza fog ker�lni az 
          Ir�ny�t� Pultra.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>
        <h5><a name="resetting_password" id="resetting_password"></a>Elfelejtett Jelsz� Vissza�ll�t�sa</h5>
        <p>Amennyiben elfelejtette a Jelszav�t, k�rheti, hogy a rendszer adjon egy �jat 
          �nnek �s k�ldje el email-ben. Ehhez keresse fel �s k�vesse a Bejelentkez� oldalon az  
          &quot;Elfelejtett Jelsz�&quot; linket a Bejelentekez� mez� alatt. 
          Egy �j oldalra fog ker�lni, ahol meg kell adnia email c�m�t. 
          Miut�n r�klikkelt a &quot;K�ld�s&quot; linkre, a rendszer egy �j, v�letlen jelsz�t 
          gener�l. Az �jdons�lt Jelsz� beker�l az adatb�zisba �s a Rendszer elk�ldi �nnek 
          email-ben. Nyissa meg a levelet �s m�solja �t a jelszav�t a bejelentkez�hez, 
          <a href="#logging_in">Jelentkezzen be</a> vele, �s nyomban <a href="#manage_profile">v�ltoztassa 
          meg azt</a>.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>
        <h5><a name="getting_support" id="getting_support"></a>T�mogat�s</h5>
        <p>Ha nincs joga egy Kontingens haszn�lat�hoz, k�rd�se van egy Kontingenssel, 
          El�jegyz�ssel, vagy a Felhaszn�l�j�val kapcsolatban, k�rem haszn�lja az &quot;Email
          k�ld�se az Adminisztr�tornak&quot; linket,
          melyet <a href="#quick_links">Gyors Linkek</a> k�z�tt tal�lhat meg.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>        <p align="right">&nbsp;</p>
        <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="my_control_panel" id="my_control_panel"></a>Ir�ny�t� Pult</h4>
        <p>Az Ir�ny�t� Pult az �n &quot;Kiindul� pontja&quot; az El�jegyz�si Rendszer 
          kezel�s�hez. Itt megtekintheti, m�dos�thatja, vagy t�r�lheti El�jegyz�seit. 
          Az Ir�ny�t� Pult is tartalmaz <a href="#using_the_scheduler">El�jegyz�s</a>, 
          �s <a href="#quick_links">Profil M�dos�t�sa</a> linket �s egy opci�t is, amivel 
          kijelentkezhet az El�jegyz�si Rendszerb�l.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>
        <h5><a name="quick_links" id="quick_links"></a>Gyors Linkek</h5>
        <p>A Gyors Linkek r�v�n egy helyen megtal�lhat�k a legfontosabb linkek.
          Az els� az &quot;El�jegyz�s&quot;, mely az alap�rtelmezett
          El�jegyz�shez vezet. Itt megtekintheti �s �tn�zheti a Kontingenseit, 
          �s m�dos�thatja El�jegyz�seit.</p>
        <p>A &quot;Saj�t Napt�r Megtekint�se&quot; az El�jegyz�s Napt�r N�zet�hez vezet,
          melyben azok az El�jegyz�sek szerepelnek, melyekben �n is R�sztvev�. Megtekinthet�
          Napi, Heti, vagy Havi Bont�sban is.</p>
        <p>A &quot;Kontingens Napt�r Megtekint�se&quot; elviszi �nt a Rendszer
          Napt�r�hoz, amelyben az �sszes, vagy egy kiv�lasztott El�jegyz�s 
          Vizsg�latait tekintheti meg. Ha kiv�laszt egy El�jegyz�st a Napi N�zetben,
          lehet�s�ge van kinyomtatni a &quot;Lista N�zetet&quot;, amennyiben
          a jegyzett�mb ikonra kattint, a Kontingens melletti leg�rd�l� men�ben.</p>
        <p>A &quot;Profil Szerkeszt�se/Jelsz� V�lt�s&quot; link egy olyan oldalra
          vezet, ahol megv�ltoztathatja olyan adatait, mint: a Felhaszn�l�i N�v, 
          Email c�m, N�v, Telefonsz�m �s a Jelsz�. Minden mez�be beker�l a megadott
          �rt�k. Az �resen, vagy v�ltozatlanul hagyott mez�k nem v�ltoznak.</p>
        <p>Az &quot;Email Be�ll�t�sok Szerkeszt�se&quot; olyan oldalra visz, ahol
          megv�laszthatja, hogy hogyan �s milyen form�ban szeretne visszajelz�st
          kapni az El�jegyz�seir�l. Alap �rtelmez�s szerint a Rendszer HTML emailben
          �rtes�ti minden alkalommal, amikor hozz�ad, m�dos�t, vagy t�r�l egy el�jegyz�st.</p>
        <p>V�g�l a legutols� link, a &quot;Kil�p�s&quot; kil�pteti a Rendszerb�l, majd
          visszaker�l a Bejelentkez� oldalara.</p>
        <p align="right"><a href="#top">Vissza a tetej�re</a></p>
        <h5><a name="my_announcements" id="my_announcements"></a>Bejelent�sek</h5>
        <p>A Bejelent�sek k�z�tt olyan inform�ci�kat tal�l, amiket az Adminisztr�tor
          k�zl�sre fontosnak �t�lt.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>
        <h5><a name="my_reservations" id="my_reservations"></a>El�jegyz�sek</h5>
        <p>Az El�jegyz�sek lista tartalmaz minde elj�vend� El�jegyz�st az aktu�lis 
          napt�l sz�m�tva (alap�rtelmez�s). A t�bl�zatban megtal�lhat� az El�jegyz�s 
          D�tuma, Kontingense, a L�trehoz�s ideje, az utols� M�dos�t�s ideje, valamint a
          Kezd� �s a Befejez� Id�pont. A list�b�l kiindulva az El�jegyz�sek 
          M�dos�tani �s T�r�lni lehet a &quot;M�dos�t�s&quot; vagy a &quot;T�rl�s&quot; 
          linkre kattintva a megfelel� El�jegyz�s sor�nak v�g�n l�v� linkre kattintva. 
          Mindk�t esetben egy el�ugr� ablakban hat�rozhatja meg a k�v�nt v�ltoztat�sokat. 
          Az El�jegyz�s Id�pontj�ra kattintva egy �j el�reugr� ablak jelenik meg, 
          melyen megtekintheti a r�szleteket.</p>
        <p>Az El�jegyz�sek rendez�si m�dj�nak megv�ltoztat�s�hoz kattintson a &#150; 
          vagy a + linkre az oszlop tetej�n. A m�nusz jellel az adott oszlopra n�zve 
          cs�kken� sorrendben k�rhet�k az El�jegyz�si lista elemei, a plussz jellel az 
          aktu�lis oszlopnak megfelel�en n�vekv� sorrendben list�zhat�k az El�jegyz�sek.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>
        <h5><a name="my_training" id="my_training"></a>Jogosults�gok</h5>
        <p>A Jogosults�gok k�z�tt fel van sorolva minden Kontingens, amelyre �r�si joga van.
	  A list�n megtal�lhat� a Kontingens neve, a Helysz�n �s a Telefon sz�m, amelyen 
          �rdekl�dhet az Adminisztr�torn�l.</p>
        <p>Regisztr�ci�t k�vet�en a Felhaszn�l� nem tud egyik Kontingensbe sem �rni, hacsak a 
	  az Adminisztr�tor nem hat�rozott �gy, hogy a Felhaszn�l�k alap�rtelmezett Jogosults�got kapnak. 
	  Az Adminisztr�tor az egyetlen szem�ly, aki Jogosults�got adhat egy Kontingenshez. Am�g ez nem 
          t�rt�nik meg, �n nem �rhat azokba a Kontingensekbe, amelyekhez nincs joga, de az El�jegyz�st 
          megtekintheti.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>
        <h5><a name="my_invitations" id="my_invitations"></a>Megh�v�sok</h5>
        <p>A Megh�v�sok k�z�tt megtal�lhat� minden El�jegyz�s, amelyre Megh�v�st kapott,
          �s lehet�s�ge ny�lik az El�jegyz�sben val� R�szv�tel Elfogad�s�ra �s
          Visszautas�t�s�ra. Ha elfogadta a R�szv�telt, a k�s�bbiekben m�g lehet�s�ge
          van r�, hogy felf�ggessze azt. Visszautas�t�s eset�n csak akkor tud R�sztvev�k�nt
          szerepelni egy El�jegyz�sben, ha az adott El�jegyz�s l�trehoz�ja ism�telten
          megh�vja �nt.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>        
        <h5><a name="my_participation" id="my_participation"></a>R�szv�telek</h5>
        <p>A R�szv�telek k�perny�n megtal�lhat minden El�jegyz�st, amelyben
          R�sztvev�k�nt szerepel. Nem mutatkoznak azok az El�jegyz�sek, melyeknek
          �n a gazd�ja. Az t�bl�zaton lehet�s�g ny�lik a R�szv�tel Felf�ggeszt�s�re
          egy kiv�lasztott El�jegyz�sben. Ha befejezi a R�szv�telt egy El�jegyz�sben,
          Nem fog tudni r�sztvenni benne, hacsak az El�jegyz�s l�trehoz�ja nem Hivja meg
          �nt ism�telten.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>        <p align="right">&nbsp;</p>
        <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="using_the_scheduler" id="using_the_scheduler"></a>A Rendszer haszn�lata</h4>
        <p>Az El�jegyz�si Rendszerben v�grehajthat minden El�jegyz�si funkci�t.
          A Heti Bont�s az aktu�lis hetet mutatja, �s alap�rtelmez�sben 7 napos
          id�szakot mutat. V�ltogathat az El�jegyz�sek k�z�tt, megtekintheti a Kontingenseket
          �s m�dos�thatja El�jegyz�seit. Az El�jegyz�sek sz�nk�doltak, �s mindegyik l�that�
          de csak az <i>�n</i> �ltal l�trehozottak eset�ben
          tal�lhat� link a szerkeszt�shez. A t�bbi El�jegyz�s eset�n csak a megtekint�shez
          haszn�lhat� link �rhet� el.</p>
        <p>Az el�jegyz�sek k�z�tt (amennyiben t�bb is l�tezik) a f�nt tal�lhat� leg�rd�l�
          men� seg�ts�g�vel v�lthat.</p>
        <p>A Rendszer Adminisztr�tor meghat�rozhat &quot;Tiltott Id�pontokat&quot;,
          amelyek nem lesznek el�rhet�ek. Az El�jegyz�s nem ker�l bejegyz�sre,
          ha egy Tiltott Id�ponttal �tk�z�s tapasztalhat�.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>
        <h5><a name="read_only" id="read_only"></a>Csak Olvashat� M�d</h5>
        <p>Ha nem Regisztr�lt, vagy nem jelentkezett be, akkor megtekintheti az El�jegyz�s
          Csak Olvashat� v�ltozat�t, ha r�klikkel a &quot;Csak Olvashat� M�d&quot; linkre
          a bejelentkez� oldalon. Ekkor l�that� minden Kontingens �s El�jegyz�s,
          de �n sem r�szleteket nem tekinthet meg egyikr�l sem, sem az El�jegyz�sek
          szerkeszt�s�re vagy l�trehoz�s�ra nem lesz lehet�s�ge.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>
        <h5><a name="making_a_reservation" id="making_a_reservation"></a>El�jegyz�s L�trehoz�sa</h5>
        <p>Egy el�jegyz�s l�trehoz�s�hoz els�k�nt arra a napra kell navig�lnia,
          amelyikre az El�jegyz�st l�tre szeretn� hozni. Amikor megtal�lta a kiv�lasztott
          naphoz tartoz� oldalt, kattintson a Kontingens nev�re, vagy a kiv�nt id�pontra. Ekkor egy el�re
          ugr� ablakban kiv�laszthatja a Kezd� �s Befejez� id�pontot (ha enged�lyezett)
          amelyek k�z�tt El�jegyz�s�t l�tre szeretn� hozni.</p>
        <p>Az El�jegyz�s hossz�ra vonatkoz� inform�ci�kat tartalmaz� �zenetet tal�lhat
          az id�szak kiv�laszt�s�ra szolg�l� mez� alatt. Ha az el�jegyz�se r�videbb,
          vagy hosszabb a megadott intervallumn�l, a Rendszer nem fogja elfogadni.</p>
        <p>Az ablakban lehet�s�ge van Ism�tl�d� El�jegyz�s l�trehoz�s�ra is.
          Els�k�nt v�lassza ki, hogy mely napokon szeretn�, hogy az El�jegyz�s ism�tl�dj�n,
          majd meg kell adnia, hogy milyen hossz� id�szakra vonatkozzon. Az El�jegyz�s
          bejegyz�sre ker�l a kiindul� napra �s minden tov�bbi megadott napra
          a meghat�rozott id�szakon bel�l. Minden olyan alkalmat, amikor valamilyen okb�l
          nem hozhat� l�tre Ism�telt El�fordul�s a Rendszer kijelez. Ha T�bbnapos El�jegyz�sek
          l�trehoz�sakor Ism�telt El�fordul�s nem v�laszthat�.</p>
        <p>Az El�jegyz�s�hez tartoz� adatokat a Megjegyz�s mez�ben k�z�lje.
          A Megjegyz�s mez�t azut�n minden Felhaszn�l� megtekintheti, hogy 
          inform�l�djon az El�jegyz�se r�szletei fel�l.</p>
        <p>Miut�n meghat�rozta az El�jegyz�s Kezd� �s Befejez� Id�pontj�t,
           �s ig�nyei szerint kiv�lasztotta a k�v�nt ism�tl�d�seket, nyomja
           meg a &quot;Ment�s&quot; gombot.
           A Rendszer ezt k�vet�en egy �zenetet k�ld, hogy mely alkalmakra nem tudta
           tudta teljes�teni a k�r�st. Sikertelen pr�b�lkoz�s eset�n menjen vissza �s 
           v�ltoztassa meg az Id�pontokat oly m�don, hogy ne forduljon el� �tfed�s m�s
           El�jegyz�ssel. Az El�jegyz�s elfogad�sa eset�n a Rendszer automatikusan
           friss�l. Ez el�felt�tele, hogy minden �j inform�ci� kijelz�sre ker�lj�n.</p>
        <p>Nem hozhat l�tre El�jegyz�st olyan id�pontra, amelyik m�r elm�lt, tov�bb� olyan
           Kontingensbe, amelyhez nincsen �r�si Jogosults�ga vagy olyan El�jegyz�sbe
           amely Inakt�v. Ilyen esetben a Kontingens sz�rk�n jelenik meg �s nem �rhet�
           el olyan link, amely el�hozn� az el�re ugr� ablakot.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>
        <h5><a name="modifying_deleting_a_reservation" id="modifying_deleting_a_reservation"></a>El�jegyz�s M�dos�t�sa/T�rl�se</h5>
        <p>Egy El�jegyz�s T�rl�se, vagy M�dos�t�sa t�bb m�don is lehets�ges. Az egyiket
           az <a href="#my_control_panel">Ir�ny�t� Pultn�l</a> m�r olvashatta.
           Az Online El�jegyz�sben - mint m�r az kor�bban is eml�t�sre ker�lt - 
           szint�n megteheti. A nem M�dos�that�/T�r�lhet� El�jegyz�sek eset�n
           a Rendszer nem k�n�lja fel a linket.</p>
        <p>Az El�jegyz�si Rendszerben rendk�v�l egyszer� m�don el�g a k�v�nt
          El�jegyz�sre kattintania. Ezut�n az El�jegyz�s L�trehoz�sakor
          l�that� ablakhoz hasonl� el�re ugr� ablak jelenik meg. K�t v�laszt�sa
          van: a Kezd� �s a Befejez� id�pontok M�dos�t�sa ut�n v�laszthatja a &quot;M�dos�t�s&quot;
          gombot az oldal alj�n, az El�jegyz�s t�rl�s�hez pedig ez el�tt a &quot;T�rl�s&quot;
          opci�t is be kell jel�lnie. A megadott �j adatok ellen�rz�sre ker�lnek a
          Rendszerben a t�bbi El�jegyz�shez k�pest �s a Rendszer visszajelz�st
          ad, hogy sikeres volt-e a v�ltoztat�s. Ha az id�pontok nem stimmelnek
          t�rjen vissza a M�dos�t�s ablakba, hogy kijav�thassa az �tfed�seket 
          Sikeres m�dos�t�s eset�n az El�jegyz�si Rendszer automatikusan friss�l,
          �s a k�perny� �jra bet�lt�dik. Erre az�rt van sz�ks�g, hogy l�that�v� v�ljanak
          az �n �ltal v�grehajtott v�ltoz�sok.</p>
        <p>Ism�telten El�fordul� El�jegyz�sek v�ltoztat�sakor, jel�lje be az
          &quot;Ism�telt El�fordul�sok Friss�t�se&quot; opci�t. Az �rv�nytelen
          el�fordul�sokat a Rendszer visszajelzi �nnek.</p>
        <p>Nem m�dos�that olyan EL�jegyz�st, amely m�r elm�lt.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>
        <h5><a name="navigating" id="navigating"></a>Barangol�s az El�jegyz�si Rendszerben</h5>
        <p>Sz�mtalan lehet�s�ge van az El�jegyz�si Rendszerben t�rt�n� barangol�sra.</p>
        <p>A hetek k�z�tt az &quot;El�z� H�t&quot; �s a &quot;K�vetkez� H�t&quot; link
          seg�ts�g�vel v�lthat. Ezek az El�jegyz�s alj�n tal�lhat�k</p>
        <p>Lehet�s�g van a kiv�lasztott napra t�rt�n� ugr�sra, ha megadja azt a lap alj�n.</p>
        <p>A Napt�r el�hoz�sa a &quot;Napt�r Megtekint�se&quot; linkkel lehets�ges, amely
          a lap alj�n tal�lhat�. V�laszza ki a megfelel� lapot �s r�kattintva a kiv�lasztott
          napra ugrik az El�jegyz�si Rendszer.</p>
        <p align="right"><a href="#top">Ugr�s a tetej�re</a></p>
      </td>
    </tr>
  </table>
</div>