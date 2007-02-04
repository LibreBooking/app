<?php
/**
* English (en) help translation file.
* This also serves as the base translation file from which to derive
*  all other translations.
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Marian Murín <murin@netkosice.sk>
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
?>
<div align="center"> 
  <h3><a name="top" id="top"></a>Úvod do phpScheduleIt</h3>
  <p><a href="http://phpscheduleit.sourceforge.net" target="_blank">http://phpscheduleit.sourceforge.net</a></p>  
  <table width="100%" border="0" cellspacing="0" cellpadding="5" style="border: solid #CCCCCC 1px">
    <tr> 
      <td bgcolor="#FAFAFA"> 
        <ul>
          <li><b><a href="#getting_started">Zaèíname</a></b></li>
          <ul>
            <li><a href="#registering">Registrácia</a></li>
            <li><a href="#logging_in">Prihlasovanie</a></li>
            <li><a href="#language">Vıber jazyka</a></li>
            <li><a href="#manage_profile">Zmena Profilu/Hesla</a></li>
            <li><a href="#resetting_password">Reset Vášho zabudnutého hesla</a></li>
            <li><a href="#getting_support">Ako získa pomoc</a></li>
          </ul>
          <li><a href="#my_control_panel"><b>Môj Riadiaci Panel</b></a></li>
          <ul>
            <li><a href="#quick_links">Moje rıchle odkazy</a></li>
			<li><a href="#my_announcements">Moje oznámenia</a></li>
            <li><a href="#my_reservations">Moje rezervácie</a></li>
            <li><a href="#my_training">Moje oprávnenia</a></li>
			<li><a href="#my_invitations">Moje pozvania</a></li>
			<li><a href="#my_participation">Moja úèas na rezervácii</a></li>         
          </ul>
          <li><a href="#using_the_scheduler"><b>Pouívanie plánovaèa</b></a></li>
          <ul>
			<li><a href="#read_only">Verzia len na èítanie</a></li>
            <li><a href="#making_a_reservation">Vytvorenie rezervácie</a></li>
            <li><a href="#modifying_deleting_a_reservation">Zmena/Zrušenie rezervácie</a></li>
            <li><a href="#navigating">Navigácia v plánovaèi</a></li>
          </ul>
        </ul>
		<hr width="95%" size="1" noshade="noshade" />
        <h4><a name="getting_started" id="getting_started"></a>Zaèíname</h4>
        <p>Pre pouívanie plánovaèa je potrebné sa najskôr zaregistrova. 
          Ak ste sa u zaregistrovali, musíte sa prihlási, aby ste mohli zaèa pouíva tento systém.  V hornej èasti kadej stránky (okrem registraènej stránky a stránky pre prihlásenie) uvidíte informácie o privítaní, dnešnı dátum a nieko¾ko odkazov -- &quot;Odhlási sa&quot;,  &quot;Môj riadiaci panel&quot;, pod odkazom pre privítanie, a &quot;Pomoc&quot; pod dátumom.</p>
          <p>Ak je na privítacom odkaze zobrazenı predchádzajúci uívate¾ , kliknite na &quot;Odhlási&quot; pre vyèistenie cookies, ktoré boli pouité a <a href="#logging_in">Prihláste sa </a> pod svojim menom a heslom. Kliknutím na odkaz &quot;Môj riadiaci panel&quot; sa dostanete do èasti <a href="#my_control_panel">Môj riadiaci panel</a>, vaša &quot;domovská stránka&quot; plánovaèa.
          Kliknutím na odkaz  &quot;Pomoc&quot; otvoríte pop-up okno pre nápovedu. Kliknutím na odkaz &quot;Email Administrátorovi&quot; pošle email administrátorovi systému.</p>
          <p><font color="#FF0000">Varovanie:</font> Ak máte spustenı Norton Personal
            Firewall poèas pouívania phpScheduleIt, môu sa vyskytnú problémy.
            Prosím ukonèite  Norton Personal Firewall poèas pouívania  phpScheduleIt. Po skonèení práce s phpScheduleIt ho môete znova spusti.</p>
          <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="registering" id="registering"></a>Registrácia</h5>
        <p>Pre zaregistrovanie sa do systému, choïte prosím na stránku pre registráciu. To môete dosiahnu cez odkaz na úvodnú prihlasovaciu stránku. Je potrebné vyplni kadé pole vo formulári. Emailová adresa, s ktorou sa zaregistrujete, bude slúi ako vaše prihlasovacie meno. Informácie, ktoré zadáte pri registrácii, môete v budúcnosti kedyko¾vek meni pomocou <a href="#quick_links">zmeny vášho profilu</a>. Vıberom vo¾by &quot;Udruj ma pripojeného&quot; dosiahnete to, e budú pouité  cookies pre vašu identifikáciu do systému a pri ïalšom pouívaní plánovaèa sa nebudete musie prihlasova do systému zadaním vášho mena a hesla, pretoe si to systém zapamätá.  <i>Túto vo¾bu by ste mali poui len vtedy, ak ste jedinı uívate¾ vyuívajúci plánovaè na vašom poèítaèi. V iadnom prípade túto vo¾bu nepouíva na poèítaèi, ktorı nie je Váš. Mohlo by tak dôjs k zneuitiu Vašich údajov. </i> 
          Po registrácii, budete presmerovaní do èasti  <a href="#my_control_panel">Môj riadiaci panel</a>.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="logging_in" id="logging_in"></a>Prihlasovanie</h5>
        <p>Prihlasovanie je také jednoduché, aké je zadanie vašej emailovej adresy a hesla. 
          Musíte by <a href="#registering">registrovanı</a> predtım ne sa môete prihlási. To môete dosiahnu kliknutím na registraènnı odkaz, ktorı je na prihlasovacej stránke. Vıberom vo¾by &quot;Udruj ma prihláseného &quot; bude pouité
          cookies na identifikáciu pri kadom návrate do plánovaèa, bez toho, aby ste sa museli prihlasova.<i>Túto vo¾bu by ste mali poui len vtedy, ak ste jedinı uívate¾ vyuívajúci plánovaè na vašom poèítaèi.</i><em> </em>Po prihlásení budete presmerovanı do oblasti  <a href="#my_control_panel">Môj riadiaci panel</a>.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="language" id="language"></a>Vıber jazyka</h5>
        <p>Na prihlasovacej stránke je menu so všetkımi dostupnımi jazykovımi mutáciami, ktoré administrátor pridal do systému. Prosím vyberte jazyk, ktorı preferujete a celı systém phpScheduleIt bude s vami komunikova tımto jazykom. Text, ktorı do systému pridá administrátor alebo uívatelia systému, nebude preloenı. Preloenı bude len text samotnej aplikácie. Ak chcete vybra inı jazyk, tak je potrebné sa odhlási.</p>
        <p align="right"><a href="#top">Nahor</a></p>        
        <h5><a name="manage_profile" id="manage_profile"></a>Zmena Profilu/Hesla</h5>
        <p>Ak chcete zmeni váš profil  (meno, email, atï.) alebo vaše heslo, prihláste sa prosím do systému. V sekcii <a href="#my_control_panel">Môj riadiaci panel</a>, v odkaze <a href="#quick_links">Moje rıchle odkazy</a>, klliknite na &quot;Zmena profilu /hesla&quot;. Dostanete sa do formulára s vašimi vyplnenımi informáciami. Môete zmeni ¾ubovo¾nú informáciu, ktorú potrebujete. Kadé pole, ktoré necháte prázdne, nebude zmenené. Ak si eláte zmeni vaše prihlasovacie heslo, zadajte ho prosím dvakrát. Po editácii vaších informácií, kliknite na  &quot;Zmeni profil &quot; 
          a vaše zmeny budú uloené do databázy. Potom budete automaticky presmerovanı do sekcie Môj riadiaci panel.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="resetting_password" id="resetting_password"></a>Reset vášho zabudnutého hesla</h5>
        <p>Ak ste si zabudli vaše heslo, môete ho zresetova a nové heslo vám bude poslané emailom. Aby ste to mohli zrealizova, prejdite na prihlasovaciu stránku a kliknite na odkaz  &quot;Zabudol som heslo&quot;, ktorı je hneï pod formulárom na prihlásenie. Následne budete presmerovanı na  novú stránku, na ktorej je potrebné zada vašu emailovú adresu. 
          Po kliknutí na &quot;Odosla&quot;, vám bude náhodne vygenerované nové heslo. Toto nové heslo bude uloené v databáze systému a zároveò vám bude poslané emailom. Po obdraní nového hesla sa môete, 
          <a href="#logging_in">prihlási</a> a následne si vaše nové heslo  <a href="#manage_profile">zmeni</a>.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="getting_support" id="getting_support"></a>Ako získa pomoc</h5>
        <p>Ak nemáte oprávnenie na vyuívanie zdrojov alebo máte otázky oh¾adom rezervácií, prosím pouijte odkaz &quot;Email
          Administrátorovi&quot;, ktorı sa nachádza v sekcii <a href="#quick_links">Moje rıchle odkazy</a></p>
        <p align="right"><a href="#top">Nahor</a></p>        <p align="right">&nbsp;</p>
        <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="my_control_panel" id="my_control_panel"></a>Môj riadiaci panel</h4>
        <p>Riadiaci panel  je vaša  &quot;domovská stránka &quot; pre rezervaènı systém. Tu môete prezera, zadáva nové rezervácia alebo ich maza. Môj riadiaci panel taktie obsahuje odkaz na <a href="#using_the_scheduler">Plánovaè</a>, 
          odkaz na <a href="#quick_links">Zmenu vášho profilu</a> a vo¾bu na odhlásenie sa z rezervaèného systému.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="quick_links" id="quick_links"></a>Moje rıchle odkazy</h5>
        <p>Oblas rıchlych odkazov vám poskytne bené odkazy aplikácie.
          Prvı, &quot;Choï na Online plánovaè &quot; vás nasmeruje na predvolenı plánovaè. Tu môete prezera rozvrhy jednotlivıch zdrojov, rezervova zdroje a meni vaše súèasné rezervácie.</p>
        <p>&quot;Prezri môj kalendár &quot; vás navedie na kalendárovı poh¾ad rezervácií, ktoré ste si naplánovali alebo na ktorıch ste zúèastnenı. Tento poh¾ad je monı na dennej, tıdennej alebo mesaènej báze.</p>
        <p>&quot;Pozri rozvrh &amp; Kalendár zdrojov &quot; vás navedie na kalendárovı poh¾ad rezervácií pre vybranı zdroj  alebo pre všetky zdroje vybraného rozvrhu. Ak ste si zvolili dennı poh¾ad urèitého zdroja, budete ma tie monos vytlaèi poh¾ad &quot;Zonam prihlásenıch&quot; kliknutím na ikonu notebook-u, ktorá sa nachádza ved¾a menu pre zdroje.</p>
        <p>&quot;Zmena môjho Profilu/Hesla&quot; vás navedie na stránku, ktorá vám umoní meni vaše osobné informácie, ako sú prihlasovacia email adresa, meno, telefónne èíslo a heslo. Všetky tieto informácie budú za vás vypísané. Prázdne alebo nezmenené hodnoty nebudú zapísané do databázy.</p>
        <p>&quot;Správa mojich emailovıch nastavení &quot; vás navedie na stránku, kde si môete vybra ako a kedy chcete by kontaktovanı vzh¾adom naváš rozvrh. Predvolená vo¾ba je, e obdríte notifikáciu formou HTML emailu stále keï pridáte, zmeníte alebo zrušíte rezerváciu.</p>
        <p>Poslednı odkaz , &quot;Odlhási&quot; vás odhlasí zo súèasnej session a presmeruje vás na prihlasovaciu stránku.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="my_announcements" id="my_announcements"></a>Moje oznámenia</h5>
        <p>Táto oblas obsahuje  všetky oznámenia, ktoré sú pridané do systému administrátorom.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="my_reservations" id="my_reservations"></a>Moje rezervácie</h5>
        <p>Oblas rezervácií zobrazuje všetky vaše rezervácie, ktoré zaèínajú dneškom (predvolene). Táto oblas zobrazuje pre kadú rezerváciu Dátum, 
          Zdroj, Dátum/Èas vytvorenia rezervácie, Dátum/Èas jej poslednej modifikácie, 
          Poèiatoènı èas a Koncovı èas. Z tejto oblasti môete taktie meni rezerváciu alebo ju zruši, jednoducho kliknutím na odkaz &quot;Zmeni&quot; alebo &quot;Zmaza&quot; 
          na konci príslušnej rezervácie. Obidve akcie vyvolajú  pop-up okno, v ktorom je moné potvrïi zmeny vašej rezervácie. 
          Kliknutím na dátum rezervácie sa otvorí nové okno, v ktorom je moné prezera detaily rezervácie.</p>
        <p>Pre usporoadanie vašich rezervácií pod¾a konkrétneho ståpca, kliknite na odkaz ( &#150; ) 
          alebo ( + ) v hornej èasti ståpca. Znak mínus usporiadá vaše rezervácie v poradí zhora nadol pod¾a mena ståpca, znak plus usporiada vaše rezervácie v poradí zdola nahor pod¾a mena ståpca.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="my_training" id="my_training"></a>Moje oprávnenia</h5>
        <p>Oblas oprávnení zobrazuje všetky zdroje, ku ktorım ste získali oprávnenie na pouívanie.
		  Táto èas zobrazuje mená zdrojov, ich umiestnenie a telefónne èíslo, ktoré môete poui pre kontaktovanie.</p>
        <p>Po registrácii nebudete ma oprávnenie na vyuívanie zdrojov, pokia¾ vám administrátor
		  neumoní povoli všetky zdroje automaticky.  Iba administrátor vám môe prideli oprávnenia na vyuívanie zdrojov. Ak nemáte pridelené oprávnenie na vyuívanie konkretného zdroja, nebudete ho môc vyuíva, ale budete môc prezera jeho súèasné rezervácie.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="my_invitations" id="my_invitations"></a>Moje pozvania</h5>
        <p>Oblas moje pozvania zobrazuje všetky rezervácie, ku ktorım ste boli pozvanı a umoòuje vám to buï pozvanie akceptova alebo odmietnu. Ak pozvanie príjmete, stále máte monos ukonèi úèas na tomto pozvaní neskôr. Ak pozvanie zamietnete, nebudete ma v budúcnosti monos akceptova pozvanie k rezervácii.</p>
        <p align="right"><a href="#top">Nahor</a></p>        
        <h5><a name="my_participation" id="my_participation"></a>Moja úèas na rezervácii</h5>
        <p>Oblas Moja úèas na rezervácii zobrazuje všetky rezervácie, na ktorıch máte úèas. Neukazjue rezervácie, ktoré ste vytvorili sami. Na tomto mieste si môete vybra ukonèenie úèasti pre vybranú rezerváciu. Ak úèas ukonèíte,
          nebudete ma monos zúèastni sa rezervácie aj keï vás tvorca pozve ešte raz.</p>
        <p align="right"><a href="#top">Nahor</a></p>        <p align="right">&nbsp;</p>
        <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="using_the_scheduler" id="using_the_scheduler"></a>Pouívanie plánovaèa</h4>
        <p>Plánovaè je miesto, kde môete vykonáva všetky plánovacie funkcie pre pride¾ovanie k jednotlivım zdrojom. Zobrazenı tıdeò zaèína súèasnım a pokraèuje siedmimi 
          (7) 
        dòami. Tu si môete prezera zdroje plánovaèa, rezervova zdroje a meni vaše súèasné rezervácie. Rezervácie budú zafarbené a budú zobrazené, ale iba vaše rezervácie budú odkazova na editáciu vašej rezervácie. Všetky ïalšie rezervácie budú odkazova len na prezeranie rezervácie.</p>
        <p>Môete zmeni rezervácie  (ak existuje viac ako jedna) pouitím menu v hornej èasti kadej rezervácie.</p>
        <p>Systemovı administrátor môe špecifikova èasy, ktoré znamenajú  &quot;vıpadky systému&quot;. Tieto èasy nebude moné rezervova pokia¾ budú v konflikte s èasmi vıpadkov.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="read_only" id="read_only"></a>Verzia len na èítanie</h5>
        <p>Ak ste sa ešte nezaregistrovali do rezervaèného systému alebo ste sa neprihlásili, môete prezera verziu systému, ktorá je urèená len na èítanie kliknutím na odkaz &quot;Plánovaè len na èítanie &quot;, ktorı je na prihlasovacej stránke. Táto verzia plánovaèa vám ukáe všetky zdroje a rezervácie, ale nebudete môc prezera iadne detaily o zdrojoch a rezerváciách a taktie nebudete môc zadáva rezervácie.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="making_a_reservation" id="making_a_reservation"></a>Vytvorenie rezervácie</h5>
        <p>Aby ste mohli rezervova zdroj, najprv prejdite na deò, pre ktorı si prajete vytvori rezerváciu. Keï ste u našli tabu¾ku pre poadovanı deò, kliknite na meno zdroja. Tım sa spustí pop-up
        okno, kde si môete vybra poèiatoèné a koncové dni (ak sú povolené) a èasy, pre ktoré chcete rezervova danı zdroj.</p>
        <p>Pod informáciou o vıbere èasu je odkaz, ktorı hovorí aká dlhá môe by rezervácia pre danı zdroj. Ak vaša rezervácia je väèšia alebo menšia ne tento povolenı èas, tak to nebude akceptované.</p>
        <p>Ak máte záujem, môete si vybra aj opakovanú rezerváciu. Pre opakovanú rezerváciu vyberte dni, pre ktoré chcete, aby sa opakovala rezervácia, potom vyberte trvanie rezervácie, ktorá sa bude opakova. Rezervácia bude vytvorená pre vybranı poèiatoènı deò, plus všetky dni, ktoré ste vybrali ako opakujúce. Všetky dátumy, ktoré nemohli by rezervované kvôli konfliktom v rezervácii, budú vypísané. Ak vytvárate viacdennú rezerváciu, vo¾by pre opakovanie nebudú dostupné.</p>
        <p>Môete prida súhrn tejto rezervácie pomocou vyplnenia sumárneho textového boxu. Tento súhrn bude dostupnı pre všetkıch ïalších uívate¾ov len na èítanie.</p>        
        <p>Po nastavení správneho zaèiatku a nastavením poèiatoènıch a koncovıch dní/èasov pre rezerváciu a vıberom vo¾by pre opakovanú rezerváciu, stlaète tlaèítko &quot;Uloi&quot;.
           Ak rezervácia nebola úspešná, objaví sa správa, ktorá vás informuje o dátume(och), ktoré neboli úspešne zarezervované. Ak sa vám nepodarilo úspešne zarezervova vybrané dátumy, choïte naspä a zmeòte poadované èasy tak, aby nekolidovali s ïalšími u existujúcimi rezerváciami. Ak vaše rezervácie boli úspešne vykonané, rozvrh sa automaticky obnoví. To je potrebné na to, aby sa obnovili všetky informácie o rezerváciách z databázy.</p>
        <p>Nie je moné rezervova zdroj pre dátum, ktorı uplynul, pre zdroj, ktorı vám nebol pridelenı alebo pre zdroj, ktorı je momentálne neaktívny. Tieto zdroje sú oznaèené sivou farbou a neobsahujú odkaz pre vytvorenie rezervácie.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="modifying_deleting_a_reservation" id="modifying_deleting_a_reservation"></a>Zmena/Zrušenie rezervácie</h5>
        <p>Existuje nieko¾ko spôsobov ako zmeni alebo zruši rezerváciu. Jeden je prostredníctvom <a href="#my_control_panel">Môj riadiaci panel</a> ako je popísané vyššie. Druhı je pomocou online plánovaèa. Ako u bolo skôr uvedené, iba vy budete môc meni vaše rezervácie. Všetky ïalšie rezervácie budú zobrazené, ale nebudú obsahova odkaz na ich editáciu.</p>
        <p>Pre zmenu rezervácie pomocou plánovaèa, jednoducho kliknite na rezerváciu, ktorú chcete zmeni. Tımto sa vám otvorí pop-up okno, ktoré je ve¾mi podobné ako je rezervaèné okno. Máte 2 monosti;
          môete zmeni buï poèiatoèné a koncové èasy rezervácie,
          alebo môete kliknú na zaškàtavací box &quot;Zmaza&quot;.
           Po vykonaní vaších zmien, stlaète talèítko &quot;Zmeni&quot;, ktorı je v spodnej èasti formulára. Vaša nová vo¾ba bude porovnaná so súèasnımi rezerváciami a objaví sa správa, ktorá vám oznámi stav vašej modifikácie. Ak potrebujete zmeni èasy, choïte naspä na okno pre modifikáciu a vyberte nové èasy, ktoré sa neprekrıvajú s ïalšími rezerváciami. Po úspešnej zmene vašej rezervácie,
           plánovaè sa automaticky obnoví. To je potrebné na obnovenie všetkıch informácií z databázy.</p>
        <p>Pre zmenu skupiny opakujúcich sa rezervácií, zaškrtnite box oznaèenı
        &quot;Zmeni všetky opakujúce sa záznamy v skupine?&quot;. Všetky kolidujúce dátumy budú vypísané.</p>
        <p>Nie je moné zmeni rezerváciu, ktorá bola zadaná pred súèasnım dátumom, resp. dátumom, ktorı u uplynul.</p>
        <p align="right"><a href="#top">Nahor</a></p>
        <h5><a name="navigating" id="navigating"></a>Navigácia v plánovaèi</h5>
        <p>Je nieko¾ko spôsobov ako sa pohybova  v kalendári plánovaèa..</p>
        <p>Pohybujte sa pomocou tıdòov pouitím odkazov &quot;Predchádzajúci tıdeò &quot; a &quot;Nasledujúci tıdeò &quot;, ktoré sú v spodnej èasti plánovaèa .</p>
        <p>Môete prejs na ¾ubovo¾nı dátum vıberom dátumu z formulára, ktorı je v spodnej èasti plánovaèa.</p>
        <p>Prechodom na navigaènı kalendár kliknutím na odkaz &quot;Prezeraj kalendár &quot;, ktorı je tie v spodnej èasti plánovaèa. Nájdite poadovanı dátum a kliknite naò, aby ste sa dostali na tento dátum v plánovaèi.</p>
        <p align="right"><a href="#top">Nahor</a></p>
      </td>
    </tr>
  </table>
</div>
