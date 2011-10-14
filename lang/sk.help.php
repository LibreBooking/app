<?php
/**
* English (en) help translation file.
* This also serves as the base translation file from which to derive
*  all other translations.
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Marian Mur�n <murin@netkosice.sk>
* @version 05-15-06
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
  <h3><a name="top" id="top"></a>�vod do phpScheduleIt</h3>
  <p><a href="http://phpscheduleit.sourceforge.net" target="_blank">http://phpscheduleit.sourceforge.net</a></p>  
  <table width="100%" border="0" cellspacing="0" cellpadding="5" style="border: solid #CCCCCC 1px">
    <tr> 
      <td bgcolor="#FAFAFA"> 
        <ul>
          <li><b><a href="#getting_started">Za��name</a></b></li>
          <ul>
            <li><a href="#registering">Registr�cia</a></li>
            <li><a href="#logging_in">Prihlasovanie</a></li>
            <li><a href="#language">V�ber jazyka</a></li>
            <li><a href="#manage_profile">Zmena Profilu/Hesla</a></li>
            <li><a href="#resetting_password">Reset V�ho zabudnut�ho hesla</a></li>
            <li><a href="#getting_support">Ako z�ska� pomoc</a></li>
          </ul>
          <li><a href="#my_control_panel"><b>M�j Riadiaci Panel</b></a></li>
          <ul>
            <li><a href="#quick_links">Moje r�chle odkazy</a></li>
			<li><a href="#my_announcements">Moje ozn�menia</a></li>
            <li><a href="#my_reservations">Moje rezerv�cie</a></li>
            <li><a href="#my_training">Moje opr�vnenia</a></li>
			<li><a href="#my_invitations">Moje pozvania</a></li>
			<li><a href="#my_participation">Moja ��as� na rezerv�cii</a></li>         
          </ul>
          <li><a href="#using_the_scheduler"><b>Pou��vanie pl�nova�a</b></a></li>
          <ul>
			<li><a href="#read_only">Verzia len na ��tanie</a></li>
            <li><a href="#making_a_reservation">Vytvorenie rezerv�cie</a></li>
            <li><a href="#modifying_deleting_a_reservation">Zmena/Zru�enie rezerv�cie</a></li>
            <li><a href="#navigating">Navig�cia v pl�nova�i</a></li>
          </ul>
        </ul>
		<hr width="95%" size="1" noshade="noshade" />
        <h4><a name="getting_started" id="getting_started"></a>Za��name</h4>
        <p>Pre pou��vanie pl�nova�a je potrebn� sa najsk�r zaregistrova�. 
          Ak ste sa u� zaregistrovali, mus�te sa prihl�si�, aby ste mohli za�a� pou��va� tento syst�m.  V hornej �asti ka�dej str�nky (okrem registra�nej str�nky a str�nky pre prihl�senie) uvid�te inform�cie o priv�tan�, dne�n� d�tum a nieko�ko odkazov -- &quot;Odhl�si� sa&quot;,  &quot;M�j riadiaci panel&quot;, pod odkazom pre priv�tanie, a &quot;Pomoc&quot; pod d�tumom.</p>
          <p>Ak je na priv�tacom odkaze zobrazen� predch�dzaj�ci u��vate� , kliknite na &quot;Odhl�si�&quot; pre vy�istenie cookies, ktor� boli pou�it� a <a href="#logging_in">Prihl�ste sa </a> pod svojim menom a heslom. Kliknut�m na odkaz &quot;M�j riadiaci panel&quot; sa dostanete do �asti <a href="#my_control_panel">M�j riadiaci panel</a>, va�a &quot;domovsk� str�nka&quot; pl�nova�a.
          Kliknut�m na odkaz  &quot;Pomoc&quot; otvor�te pop-up okno pre n�povedu. Kliknut�m na odkaz &quot;Email Administr�torovi&quot; po�le email administr�torovi syst�mu.</p>
          <p><font color="#FF0000">Varovanie:</font> Ak m�te spusten� Norton Personal
            Firewall po�as pou��vania phpScheduleIt, m��u sa vyskytn� probl�my.
            Pros�m ukon�ite  Norton Personal Firewall po�as pou��vania  phpScheduleIt. Po skon�en� pr�ce s phpScheduleIt ho m��ete znova spusti�.</p>
          <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="registering" id="registering"></a>Registr�cia</h5>
        <p>Pre zaregistrovanie sa do syst�mu, cho�te pros�m na str�nku pre registr�ciu. To m��ete dosiahnu� cez odkaz na �vodn� prihlasovaciu str�nku. Je potrebn� vyplni� ka�d� pole vo formul�ri. Emailov� adresa, s ktorou sa zaregistrujete, bude sl�i� ako va�e prihlasovacie meno. Inform�cie, ktor� zad�te pri registr�cii, m��ete v bud�cnosti kedyko�vek meni� pomocou <a href="#quick_links">zmeny v�ho profilu</a>. V�berom vo�by &quot;Udr�uj ma pripojen�ho&quot; dosiahnete to, �e bud� pou�it�  cookies pre va�u identifik�ciu do syst�mu a pri �al�om pou��van� pl�nova�a sa nebudete musie� prihlasova� do syst�mu zadan�m v�ho mena a hesla, preto�e si to syst�m zapam�t�.  <i>T�to vo�bu by ste mali pou�i� len vtedy, ak ste jedin� u��vate� vyu��vaj�ci pl�nova� na va�om po��ta�i. V �iadnom pr�pade t�to vo�bu nepou��va� na po��ta�i, ktor� nie je V�. Mohlo by tak d�js� k zneu�itiu Va�ich �dajov. </i> 
          Po registr�cii, budete presmerovan� do �asti  <a href="#my_control_panel">M�j riadiaci panel</a>.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="logging_in" id="logging_in"></a>Prihlasovanie</h5>
        <p>Prihlasovanie je tak� jednoduch�, ak� je zadanie va�ej emailovej adresy a hesla. 
          Mus�te by� <a href="#registering">registrovan�</a> predt�m ne� sa m��ete prihl�si�. To m��ete dosiahnu� kliknut�m na registra�nn� odkaz, ktor� je na prihlasovacej str�nke. V�berom vo�by &quot;Udr�uj ma prihl�sen�ho &quot; bude pou�it�
          cookies na identifik�ciu pri ka�dom n�vrate do pl�nova�a, bez toho, aby ste sa museli prihlasova�.<i>T�to vo�bu by ste mali pou�i� len vtedy, ak ste jedin� u��vate� vyu��vaj�ci pl�nova� na va�om po��ta�i.</i><em> </em>Po prihl�sen� budete presmerovan� do oblasti  <a href="#my_control_panel">M�j riadiaci panel</a>.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="language" id="language"></a>V�ber jazyka</h5>
        <p>Na prihlasovacej str�nke je menu so v�etk�mi dostupn�mi jazykov�mi mut�ciami, ktor� administr�tor pridal do syst�mu. Pros�m vyberte jazyk, ktor� preferujete a cel� syst�m phpScheduleIt bude s vami komunikova� t�mto jazykom. Text, ktor� do syst�mu prid� administr�tor alebo u��vatelia syst�mu, nebude prelo�en�. Prelo�en� bude len text samotnej aplik�cie. Ak chcete vybra� in� jazyk, tak je potrebn� sa odhl�si�.</p>
        <p align="right"><a href="#top">Nahor</a></p>        
        <h5><a name="manage_profile" id="manage_profile"></a>Zmena Profilu/Hesla</h5>
        <p>Ak chcete zmeni� v� profil  (meno, email, at�.) alebo va�e heslo, prihl�ste sa pros�m do syst�mu. V sekcii <a href="#my_control_panel">M�j riadiaci panel</a>, v odkaze <a href="#quick_links">Moje r�chle odkazy</a>, klliknite na &quot;Zmena profilu /hesla&quot;. Dostanete sa do formul�ra s va�imi vyplnen�mi inform�ciami. M��ete zmeni� �ubovo�n� inform�ciu, ktor� potrebujete. Ka�d� pole, ktor� nech�te pr�zdne, nebude zmenen�. Ak si �el�te zmeni� va�e prihlasovacie heslo, zadajte ho pros�m dvakr�t. Po edit�cii va��ch inform�ci�, kliknite na  &quot;Zmeni� profil &quot; 
          a va�e zmeny bud� ulo�en� do datab�zy. Potom budete automaticky presmerovan� do sekcie M�j riadiaci panel.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="resetting_password" id="resetting_password"></a>Reset v�ho zabudnut�ho hesla</h5>
        <p>Ak ste si zabudli va�e heslo, m��ete ho zresetova� a nov� heslo v�m bude poslan� emailom. Aby ste to mohli zrealizova�, prejdite na prihlasovaciu str�nku a kliknite na odkaz  &quot;Zabudol som heslo&quot;, ktor� je hne� pod formul�rom na prihl�senie. N�sledne budete presmerovan� na  nov� str�nku, na ktorej je potrebn� zada� va�u emailov� adresu. 
          Po kliknut� na &quot;Odosla�&quot;, v�m bude n�hodne vygenerovan� nov� heslo. Toto nov� heslo bude ulo�en� v datab�ze syst�mu a z�rove� v�m bude poslan� emailom. Po obdr�an� nov�ho hesla sa m��ete, 
          <a href="#logging_in">prihl�si�</a> a n�sledne si va�e nov� heslo  <a href="#manage_profile">zmeni�</a>.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="getting_support" id="getting_support"></a>Ako z�ska� pomoc</h5>
        <p>Ak nem�te opr�vnenie na vyu��vanie zdrojov alebo m�te ot�zky oh�adom rezerv�ci�, pros�m pou�ijte odkaz &quot;Email
          Administr�torovi&quot;, ktor� sa nach�dza v sekcii <a href="#quick_links">Moje r�chle odkazy</a></p>
        <p align="right"><a href="#top">Nahor</a></p>        <p align="right">&nbsp;</p>
        <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="my_control_panel" id="my_control_panel"></a>M�j riadiaci panel</h4>
        <p>Riadiaci panel  je va�a  &quot;domovsk� str�nka &quot; pre rezerva�n� syst�m. Tu m��ete prezera�, zad�va� nov� rezerv�cia alebo ich maza�. M�j riadiaci panel taktie� obsahuje odkaz na <a href="#using_the_scheduler">Pl�nova�</a>, 
          odkaz na <a href="#quick_links">Zmenu v�ho profilu</a> a vo�bu na odhl�senie sa z rezerva�n�ho syst�mu.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="quick_links" id="quick_links"></a>Moje r�chle odkazy</h5>
        <p>Oblas� r�chlych odkazov v�m poskytne be�n� odkazy aplik�cie.
          Prv�, &quot;Cho� na Online pl�nova� &quot; v�s nasmeruje na predvolen� pl�nova�. Tu m��ete prezera� rozvrhy jednotliv�ch zdrojov, rezervova� zdroje a meni� va�e s��asn� rezerv�cie.</p>
        <p>&quot;Prezri m�j kalend�r &quot; v�s navedie na kalend�rov� poh�ad rezerv�ci�, ktor� ste si napl�novali alebo na ktor�ch ste z��astnen�. Tento poh�ad je mo�n� na dennej, t�dennej alebo mesa�nej b�ze.</p>
        <p>&quot;Pozri rozvrh &amp; Kalend�r zdrojov &quot; v�s navedie na kalend�rov� poh�ad rezerv�ci� pre vybran� zdroj  alebo pre v�etky zdroje vybran�ho rozvrhu. Ak ste si zvolili denn� poh�ad ur�it�ho zdroja, budete ma� tie� mo�nos� vytla�i� poh�ad &quot;Zonam prihl�sen�ch&quot; kliknut�m na ikonu notebook-u, ktor� sa nach�dza ved�a menu pre zdroje.</p>
        <p>&quot;Zmena m�jho Profilu/Hesla&quot; v�s navedie na str�nku, ktor� v�m umo�n� meni� va�e osobn� inform�cie, ako s� prihlasovacia email adresa, meno, telef�nne ��slo a heslo. V�etky tieto inform�cie bud� za v�s vyp�san�. Pr�zdne alebo nezmenen� hodnoty nebud� zap�san� do datab�zy.</p>
        <p>&quot;Spr�va mojich emailov�ch nastaven� &quot; v�s navedie na str�nku, kde si m��ete vybra� ako a kedy chcete by� kontaktovan� vzh�adom nav� rozvrh. Predvolen� vo�ba je, �e obdr��te notifik�ciu formou HTML emailu st�le ke� prid�te, zmen�te alebo zru��te rezerv�ciu.</p>
        <p>Posledn� odkaz , &quot;Odlh�si�&quot; v�s odhlas� zo s��asnej session a presmeruje v�s na prihlasovaciu str�nku.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="my_announcements" id="my_announcements"></a>Moje ozn�menia</h5>
        <p>T�to oblas� obsahuje  v�etky ozn�menia, ktor� s� pridan� do syst�mu administr�torom.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="my_reservations" id="my_reservations"></a>Moje rezerv�cie</h5>
        <p>Oblas� rezerv�ci� zobrazuje v�etky va�e rezerv�cie, ktor� za��naj� dne�kom (predvolene). T�to oblas� zobrazuje pre ka�d� rezerv�ciu D�tum, 
          Zdroj, D�tum/�as vytvorenia rezerv�cie, D�tum/�as jej poslednej modifik�cie, 
          Po�iato�n� �as a Koncov� �as. Z tejto oblasti m��ete taktie� meni� rezerv�ciu alebo ju zru�i�, jednoducho kliknut�m na odkaz &quot;Zmeni�&quot; alebo &quot;Zmaza�&quot; 
          na konci pr�slu�nej rezerv�cie. Obidve akcie vyvolaj�  pop-up okno, v ktorom je mo�n� potvr�i� zmeny va�ej rezerv�cie. 
          Kliknut�m na d�tum rezerv�cie sa otvor� nov� okno, v ktorom je mo�n� prezera� detaily rezerv�cie.</p>
        <p>Pre usporoadanie va�ich rezerv�ci� pod�a konkr�tneho st�pca, kliknite na odkaz ( &#150; ) 
          alebo ( + ) v hornej �asti st�pca. Znak m�nus usporiad� va�e rezerv�cie v porad� zhora nadol pod�a mena st�pca, znak plus usporiada va�e rezerv�cie v porad� zdola nahor pod�a mena st�pca.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="my_training" id="my_training"></a>Moje opr�vnenia</h5>
        <p>Oblas� opr�vnen� zobrazuje v�etky zdroje, ku ktor�m ste z�skali opr�vnenie na pou��vanie.
		  T�to �as� zobrazuje men� zdrojov, ich umiestnenie a telef�nne ��slo, ktor� m��ete pou�i� pre kontaktovanie.</p>
        <p>Po registr�cii nebudete ma� opr�vnenie na vyu��vanie zdrojov, pokia� v�m administr�tor
		  neumo�n� povoli� v�etky zdroje automaticky.  Iba administr�tor v�m m��e prideli� opr�vnenia na vyu��vanie zdrojov. Ak nem�te pridelen� opr�vnenie na vyu��vanie konkretn�ho zdroja, nebudete ho m�c� vyu��va�, ale budete m�c� prezera� jeho s��asn� rezerv�cie.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="my_invitations" id="my_invitations"></a>Moje pozvania</h5>
        <p>Oblas� moje pozvania zobrazuje v�etky rezerv�cie, ku ktor�m ste boli pozvan� a umo��uje v�m to bu� pozvanie akceptova� alebo odmietnu�. Ak pozvanie pr�jmete, st�le m�te mo�nos� ukon�i� ��as� na tomto pozvan� nesk�r. Ak pozvanie zamietnete, nebudete ma� v bud�cnosti mo�nos� akceptova� pozvanie k rezerv�cii.</p>
        <p align="right"><a href="#top">Nahor</a></p>        
        <h5><a name="my_participation" id="my_participation"></a>Moja ��as� na rezerv�cii</h5>
        <p>Oblas� Moja ��as� na rezerv�cii zobrazuje v�etky rezerv�cie, na ktor�ch m�te ��as�. Neukazjue rezerv�cie, ktor� ste vytvorili sami. Na tomto mieste si m��ete vybra� ukon�enie ��asti pre vybran� rezerv�ciu. Ak ��as� ukon��te,
          nebudete ma� mo�nos� z��astni� sa rezerv�cie aj ke� v�s tvorca pozve e�te raz.</p>
        <p align="right"><a href="#top">Nahor</a></p>        <p align="right">&nbsp;</p>
        <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="using_the_scheduler" id="using_the_scheduler"></a>Pou��vanie pl�nova�a</h4>
        <p>Pl�nova� je miesto, kde m��ete vykon�va� v�etky pl�novacie funkcie pre pride�ovanie k jednotliv�m zdrojom. Zobrazen� t�de� za��na s��asn�m a pokra�uje siedmimi 
          (7) 
        d�ami. Tu si m��ete prezera� zdroje pl�nova�a, rezervova� zdroje a meni� va�e s��asn� rezerv�cie. Rezerv�cie bud� zafarben� a bud� zobrazen�, ale iba va�e rezerv�cie bud� odkazova� na edit�ciu va�ej rezerv�cie. V�etky �al�ie rezerv�cie bud� odkazova� len na prezeranie rezerv�cie.</p>
        <p>M��ete zmeni� rezerv�cie  (ak existuje viac ako jedna) pou�it�m menu v hornej �asti ka�dej rezerv�cie.</p>
        <p>Systemov� administr�tor m��e �pecifikova� �asy, ktor� znamenaj�  &quot;v�padky syst�mu&quot;. Tieto �asy nebude mo�n� rezervova� pokia� bud� v konflikte s �asmi v�padkov.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="read_only" id="read_only"></a>Verzia len na ��tanie</h5>
        <p>Ak ste sa e�te nezaregistrovali do rezerva�n�ho syst�mu alebo ste sa neprihl�sili, m��ete prezera� verziu syst�mu, ktor� je ur�en� len na ��tanie kliknut�m na odkaz &quot;Pl�nova� len na ��tanie &quot;, ktor� je na prihlasovacej str�nke. T�to verzia pl�nova�a v�m uk�e v�etky zdroje a rezerv�cie, ale nebudete m�c� prezera� �iadne detaily o zdrojoch a rezerv�ci�ch a taktie� nebudete m�c� zad�va� rezerv�cie.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="making_a_reservation" id="making_a_reservation"></a>Vytvorenie rezerv�cie</h5>
        <p>Aby ste mohli rezervova� zdroj, najprv prejdite na de�, pre ktor� si prajete vytvori� rezerv�ciu. Ke� ste u� na�li tabu�ku pre po�adovan� de�, kliknite na meno zdroja. T�m sa spust� pop-up
        okno, kde si m��ete vybra� po�iato�n� a koncov� dni (ak s� povolen�) a �asy, pre ktor� chcete rezervova� dan� zdroj.</p>
        <p>Pod inform�ciou o v�bere �asu je odkaz, ktor� hovor� ak� dlh� m��e by� rezerv�cia pre dan� zdroj. Ak va�a rezerv�cia je v��ia alebo men�ia ne� tento povolen� �as, tak to nebude akceptovan�.</p>
        <p>Ak m�te z�ujem, m��ete si vybra� aj opakovan� rezerv�ciu. Pre opakovan� rezerv�ciu vyberte dni, pre ktor� chcete, aby sa opakovala rezerv�cia, potom vyberte trvanie rezerv�cie, ktor� sa bude opakova�. Rezerv�cia bude vytvoren� pre vybran� po�iato�n� de�, plus v�etky dni, ktor� ste vybrali ako opakuj�ce. V�etky d�tumy, ktor� nemohli by� rezervovan� kv�li konfliktom v rezerv�cii, bud� vyp�san�. Ak vytv�rate viacdenn� rezerv�ciu, vo�by pre opakovanie nebud� dostupn�.</p>
        <p>M��ete prida� s�hrn tejto rezerv�cie pomocou vyplnenia sum�rneho textov�ho boxu. Tento s�hrn bude dostupn� pre v�etk�ch �al��ch u��vate�ov len na ��tanie.</p>        
        <p>Po nastaven� spr�vneho za�iatku a nastaven�m po�iato�n�ch a koncov�ch dn�/�asov pre rezerv�ciu a v�berom vo�by pre opakovan� rezerv�ciu, stla�te tla��tko &quot;Ulo�i�&quot;.
           Ak rezerv�cia nebola �spe�n�, objav� sa spr�va, ktor� v�s informuje o d�tume(och), ktor� neboli �spe�ne zarezervovan�. Ak sa v�m nepodarilo �spe�ne zarezervova� vybran� d�tumy, cho�te nasp� a zme�te po�adovan� �asy tak, aby nekolidovali s �al��mi u� existuj�cimi rezerv�ciami. Ak va�e rezerv�cie boli �spe�ne vykonan�, rozvrh sa automaticky obnov�. To je potrebn� na to, aby sa obnovili v�etky inform�cie o rezerv�ci�ch z datab�zy.</p>
        <p>Nie je mo�n� rezervova� zdroj pre d�tum, ktor� uplynul, pre zdroj, ktor� v�m nebol pridelen� alebo pre zdroj, ktor� je moment�lne neakt�vny. Tieto zdroje s� ozna�en� sivou farbou a neobsahuj� odkaz pre vytvorenie rezerv�cie.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="modifying_deleting_a_reservation" id="modifying_deleting_a_reservation"></a>Zmena/Zru�enie rezerv�cie</h5>
        <p>Existuje nieko�ko sp�sobov ako zmeni� alebo zru�i� rezerv�ciu. Jeden je prostredn�ctvom <a href="#my_control_panel">M�j riadiaci panel</a> ako je pop�san� vy��ie. Druh� je pomocou online pl�nova�a. Ako u� bolo sk�r uveden�, iba vy budete m�c� meni� va�e rezerv�cie. V�etky �al�ie rezerv�cie bud� zobrazen�, ale nebud� obsahova� odkaz na ich edit�ciu.</p>
        <p>Pre zmenu rezerv�cie pomocou pl�nova�a, jednoducho kliknite na rezerv�ciu, ktor� chcete zmeni�. T�mto sa v�m otvor� pop-up okno, ktor� je ve�mi podobn� ako je rezerva�n� okno. M�te 2 mo�nosti;
          m��ete zmeni� bu� po�iato�n� a koncov� �asy rezerv�cie,
          alebo m��ete klikn� na za�k�tavac� box &quot;Zmaza�&quot;.
           Po vykonan� va��ch zmien, stla�te tal��tko &quot;Zmeni�&quot;, ktor� je v spodnej �asti formul�ra. Va�a nov� vo�ba bude porovnan� so s��asn�mi rezerv�ciami a objav� sa spr�va, ktor� v�m ozn�mi stav va�ej modifik�cie. Ak potrebujete zmeni� �asy, cho�te nasp� na okno pre modifik�ciu a vyberte nov� �asy, ktor� sa neprekr�vaj� s �al��mi rezerv�ciami. Po �spe�nej zmene va�ej rezerv�cie,
           pl�nova� sa automaticky obnov�. To je potrebn� na obnovenie v�etk�ch inform�ci� z datab�zy.</p>
        <p>Pre zmenu skupiny opakuj�cich sa rezerv�ci�, za�krtnite box ozna�en�
        &quot;Zmeni� v�etky opakuj�ce sa z�znamy v skupine?&quot;. V�etky koliduj�ce d�tumy bud� vyp�san�.</p>
        <p>Nie je mo�n� zmeni� rezerv�ciu, ktor� bola zadan� pred s��asn�m d�tumom, resp. d�tumom, ktor� u� uplynul.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="navigating" id="navigating"></a>Navig�cia v pl�nova�i</h5>
        <p>Je nieko�ko sp�sobov ako sa pohybova�  v kalend�ri pl�nova�a..</p>
        <p>Pohybujte sa pomocou t�d�ov pou�it�m odkazov &quot;Predch�dzaj�ci t�de� &quot; a &quot;Nasleduj�ci t�de� &quot;, ktor� s� v spodnej �asti pl�nova�a .</p>
        <p>M��ete prejs� na �ubovo�n� d�tum v�berom d�tumu z formul�ra, ktor� je v spodnej �asti pl�nova�a.</p>
        <p>Prechodom na naviga�n� kalend�r kliknut�m na odkaz &quot;Prezeraj kalend�r &quot;, ktor� je tie� v spodnej �asti pl�nova�a. N�jdite po�adovan� d�tum a kliknite na�, aby ste sa dostali na tento d�tum v pl�nova�i.</p>
        <p align="right"><a href="#top">Nahor</a></p>
      </td>
    </tr>
  </table>
</div>
