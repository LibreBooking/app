<?php
/**
* Swedish (se) help translation file.
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Johan Sundstr�m <johan.sundstrom@vasterbottensmuseum.se>
* @version 03-13-05
* @package Languages
*
* Copyright (C) 2003 - 2004 phpScheduleIt
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
  <h3><a name="top" id="top"></a>Introduction to phpScheduleIt</h3>
  <p><a href="http://phpscheduleit.sourceforge.net" target="_blank">http://phpscheduleit.sourceforge.net</a></p>
  <table width="100%" border="0" cellspacing="0" cellpadding="5" style="border: solid #CCCCCC 1px">
    <tr> 
      <td bgcolor="#FAFAFA"> 
        <ul>
          <li><b><a href="#getting_started">Komma ig�ng</a></b></li>
          <ul>
            <li><a href="#registering">Registrering</a></li>
            <li><a href="#logging_in">Inloggning</a></li>
            <li><a href="#language">V�lja spr�k</a></li>
            <li><a href="#manage_profile">�ndra min profil information/l&ouml;senord</a></li>
            <li><a href="#resetting_password">�terst�ll ett bortgl�mt l�senord</a></li>
            <li><a href="#F� hj�lp"></a></li>
          </ul>
          <li><a href="#my_control_panel"><b>Startsidan</b></a></li>
          <ul>
            <li><a href="#my_announcements">E-posta Administrat&ouml;ren </a></li>
            <li><a href="#my_reservations">Mina bokningar</a></li>
            <li><a href="#my_training">Mina r�ttigheter</a></li>
            <li><a href="#quick_links">Mina genv�gar</a></li>
          </ul>
          <li><a href="#using_the_scheduler"><b>Anv�nd bokningssystemet</b></a></li>
          <ul>
			<li><a href="#read_only">Skrivskyddad version</a></li>
            <li><a href="#making_a_reservation">Bokningshj�lp</a></li>
            <li><a href="#modifying_deleting_a_reservation">�ndra/ta bort en reservation</a></li>
            <li><a href="#navigating">Navigera i bokningssystemet</a></li>
          </ul>
        </ul>
		<hr width="95%" size="1" noshade="noshade" />
        <h4><a name="getting_started" id="getting_started"></a>Komma ig�ng</h4>
        <p>
		
		Det f�rsta du m�ste g�ra f�r att  komma ig�ng �r att registrera dig. Om du redan har registrerat dig �r det bara att logga in. 
		�verst p� alla sidor finns ett v�lkomstmeddelande, dagens datum samt n�gra l�nkar. Bland l�nkarna hittar du &quot;Logga ut&quot;  och &quot;Startsidan&quot;. 
		Det finns �ven en l�nk f�r att  n� hj�lp filerna.
		
		Om fel anv�ndare st�r i v�lkomstmeddelandet, tryck &quot;Logga ut&quot;. Logga sedan in med din egen anv�ndare. Trycker du p� &quot;Startsidan&quot; kommer du hamna p� din egen sida i bokningssystemet.
		Klickar du p� &quot;Hj�lp&quot; f�r du upp ett popupp f�nster d�r du kan v�lja att kontakta administrat�ren.
		
		<p>Varning: har du Norton Personal Firewall p�slaget undertiden du anv�nder bokningssystemet kan du r�ka p� problem. 
		  F�r att f�rs�kra dig om att inte f� problem �r det b�st att sl� av Norton Personal Firewall s� l�nge du anv�nder bokningssystemet.
		   
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="registering" id="registering"></a>Registrering</h5>
        <p>
		F�r att registrera m�ste man f�rst ta sig till regisreringssidan. Den kan man n� fr�n f�rstasidan. Kom ih�g att du m�ste fylla i alla f�lt. 
		Emailadressen du registrerar dig med kommer vara ditt inloggningsnamn. Den �vriga informationen du fyller i kan du �ndra vid ett senare tillf�lle.
		<a href="#quick_links"> �ndra din profil</a>. Kryssar man i valet &quot;H�ll mig inloggad&quot; beh�ver du inte logga in n�sta g�ng du bes�ker bokningssidan.
		<i>Anv�nd bara detta val ifall du �r den enda som anv�nder bokningssystemet p� datorn.</i>
		Efter registreringen kommer du att skickas till  <a href="#my_control_panel">Startsidan</a>.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="logging_in" id="logging_in"></a>Inloggning</h5>
        <p>Skriv in mailadress och l�senord i f�lten.
		 Du m�ste <a href="#registering">registrera</a> dig innan du kan logga in. 
		 
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="language" id="language"></a>V�lja spr�k</h5>
        <p>
		
		P� inloggningssidan finns det en rullgardinsmeny med de olika spr&aring;k du kan v&auml;lja. 
		Efter att du valt spr&aring;k kommer all text p&aring; sidan att &ouml;vers&auml;ttas. Text som administrat&ouml;ren har skrivit in kommer dock inte att &ouml;vers&auml;ttas. 
		Du m&aring;ste logga ut f&ouml;r att kunna byta spr&aring;k.</p>
        <p align="right"><a href="#top">Top</a></p>        
        <h5><a name="manage_profile" id="manage_profile"></a>&Auml;ndra min profil information/l&ouml;senord </h5>
        <p>F&ouml;r att &auml;ndra konto information (namn, mailadress, etc.) eller ditt l&ouml;senord g&ouml;r p&aring; f&ouml;ljande s&auml;tt. 
		Logga in, v&auml;lj sedan &quot;&Auml;ndra min kontoinformation / l&ouml;senord&quot; fr&aring;n <a href="#quick_links">Mina genv�gar</a> p&aring; <a href="#my_control_panel">Startsidan.</a>
		 Du kommer att f&aring; upp en formul&auml;r med din tidigare information redan ifylld. Du kan d&aring; g&ouml;ra de &auml;ndringar du vill, n&auml;r du 
		 &auml;r f&auml;rdig klickar du p&aring; &quot;&Auml;ndra profil&quot;, din information kommer d&aring; att uppdateras.</p>
       
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="resetting_password" id="resetting_password"></a>�terst�lla tidigare l�senord</h5>
        <p>
		Om du har gl�mtbort ditt l�senord kan man �terst�lla det. Det inneb�r att du f�r ett nytt l�senord med mail.
		F�r att g�ra detta, g� till inloggingssidan, klicka p� &quot;Gl�mt l�senord&quot; under login rutan. Du kommer d� att f� skriva in din mailadress. N�r du tryckt p� &quot;Skicka&quot; kommer ett nytt l�senord skickas till din mail.
	    N�r du tagit imot ditt nya l�senord s� b�r du <a href="#logging_in">logga in</a> och <a href="#manage_profile">�ndra l�senord.</a>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="getting_support" id="getting_support"></a>F&aring; hj&auml;lp </h5>
        <p>Om du har n&aring;gra fr&aring;gor eller problem tveka in att maila administrat&ouml;ren. L&auml;ttast &auml;r att anv&auml;nda l&auml;nken fr&aring;n <a href="#quick_links">Mina genv�gar.</a></p>
        <p align="right"><a href="#top">Top</a></p>        <p align="right">&nbsp;</p>
        <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="my_control_panel" id="my_control_panel"></a>Startsidan</h4>
        <p>Fr&aring;n Startsidan kan du &ouml;verblicka dina bokningar och enkelt n&aring; <a href="#using_the_scheduler">bokningssystemet</a> f&ouml;r att &auml;ndra eller g&ouml;ra nya bokningar. Det finns &auml;ven l&auml;nkar f&ouml;r att <a href="#quick_links">�ndra konto information</a> och en l&auml;nk f&ouml;r att logga ut.</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="my_announcements" id="my_announcements"></a>E-posta Administrat&ouml;ren </h5>
        <p>Under den h&auml;r rubriken finns all information som administrat&ouml;ren tycker &auml;r viktig att veta. </p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="my_reservations" id="my_reservations"></a>Mina bokningar</h5>
        <p>Under mina bokningar finner du alla dina bokningar fr&aring;n och med dagen du kollar. Det kommer finnas information om datum, resurs, datum / tid d&aring; den skapades, datum / tid f&ouml;r senaste &auml;ndring, start tid och slut tid. Fr&aring;n denna sida kan du &auml;ven &auml;ndra eller ta bort en bokning bara genom att klicka &quot;&Auml;ndra&quot; eller &quot;Ta bort&quot;. Du kan &auml;ven f&aring; upp ytterligare information ombokningar genom att klicka p&aring; datumen i listan. </p>
        <p>F&ouml;r att sortera dina bokningar som du vill ha dem. Klicka p&aring; + eller - tecknet ovanf&ouml;r de olika kolumnerna f&ouml;r att f&aring; en stigande eller fallande ordning efter kolumnens namn.</p>
        <p><a href="#top"> Top</a></p>
        <h5><a name="my_training" id="my_training"></a>Mina r&auml;ttigheter</h5>
        <p>Under mina r&auml;ttigheter visas alla resurser du har givits tillst&aring;nd att anv&auml;nda (boka). Den visar var resursen finns och ett telefonnummer man kan anv&auml;nda f&ouml;r att kontakta administrat&ouml;ren f&ouml;r respektive resurs. </p>
        <p>N&auml;r du registrerar dig blir inte tilldelad n&aring;gra r&auml;ttigheter alls, om inte administrat&ouml;ren har slagit p&aring; automatisk tilldelning. Administrat&ouml;ren &auml;r den enda personen som kan &auml;ndra r&auml;ttigheter till olika resurser. Du kommer inte att kunna boka en resurs som du inte har r&auml;ttigheter f&ouml;r, men du kan kolla bokningsschemat f&ouml;r resurser du sj&auml;lv inte har r&auml;ttigheter f&ouml;r. </p>
        <p>&nbsp;</p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="quick_links" id="quick_links"></a>Mina genv&auml;gar</h5>
        <p>Fr&aring;n mina genv&auml;gar &auml;r det l&auml;tt att n&aring; de flesta funktioner. Den f&ouml;rsta genv&auml;gen g&aring;r till &quot;Schemal&auml;ggaren&quot; d&auml;rifr&aring;n f&aring;r du en &ouml;versikt &ouml;ver schemat och kan boka eller &auml;ndra dina bokningar. </p>
        <p>Under &quot;&Auml;ndra min konto information&quot; finns en sida d&auml;r du kan &auml;ndra din egen konto information s&aring;som l&ouml;senord, loginnamn etc. L&auml;mnas n&aring;tt f&auml;lt blankt kommer det inte &auml;ndras. </p>
        <p>&quot;Email inst&auml;llningar&quot; tar dig till den sida d&auml;r du kan &auml;ndra all kontaktinformation. Som standard blir du kontaktad via mail varje g&aring;ng du bokar, &auml;ndrar eller tar bort en reservation.</p>
        <p>Den sista l&auml;nken &quot;Logga ut&quot; loggar ut dig fr&aring;n bokningssytemet och tar dig tillbaka till loginsidan. </p>
        <p align="right"><a href="#top">Top</a></p>
        <hr width="95%" size="1" noshade="noshade" />
        <h4><a name="using_the_scheduler" id="using_the_scheduler"></a>Anv&auml;nd schemal&auml;ggaren</h4>
        <p>Det &auml;r i schemal&auml;ggaren du g&ouml;r allt som har med bokningar att g&ouml;ra. Vecko vyn visar dagens schema f&ouml;ljt av 7 dagar framm&aring;t. H&auml;r kan du &ouml;verblicka alla bokningar, g&ouml;ra egna bokningar, eller &auml;ndra dina tidigare bokningar. De olika bokningar kommer ha olika f&auml;rg beroende p&aring; vems som bokat dem. Men det &auml;r bara dina egna bokningar som kommer han en &quot;&auml;ndra&quot; l&auml;nk. Alla andra bokningar kommer bara ha en l&auml;nk f&ouml;r att f&aring; mer detaljerad information. </p>
        <p>Du kan byta schema (om de finns mer &auml;n ett) genom att anv&auml;nda rullgardinsmenyn p&aring; toppen av varje schema. </p>
        <p>Administrat&ouml;ren kan g&ouml;ra s&aring; att vissa tider inte g&aring;r att boka. Bokningar kommer d&aring; inte g&ouml;ras ifall den str&auml;cker sig in p&aring; en tid som &auml;r obokbar. </p>
        <p><a href="#top">Top</a></p>
        <h5><a name="read_only" id="read_only"></a>Skrivskyddad version</h5>
        <p>Om du inte har registrerat eller loggat in s&aring; kan du &auml;nda kolla p&aring; en skrivskyddad version av schemat. Om du klickar p&aring; l&auml;nken &quot;Skrivskyddat schema&quot; p&aring; login sidan flyttas du till en sida som liknar den riktiga schemal&auml;ggaren, men d&auml;r du inte kan se detaljerad information om bokningarna, ej heller g&ouml;ra nya bokningar. </p>
        <p><a href="#top">Top</a></p>
        <h5><a name="making_a_reservation" id="making_a_reservation"></a>Bokningshj&auml;lp</h5>
        <p>F&ouml;r att g&ouml;ra en bokning; anv&auml;nd schemal&auml;ggaren f&ouml;r att navigera till den dag du vill g&ouml;ra bokningen. N&auml;r du har tagit dig till r&auml;tt dag, klicka p&aring; resursen namn. Det kommer d&aring; komma upp ett f&ouml;nster d&auml;r du kan fylla i under vilka tider du vill boka.</p>
        <p>Det kommer att st&aring; hur l&auml;nge man f&aring;r boka resursen nedanf&ouml;r f&auml;ltet man v&auml;ljer tid. V&auml;ljer du en l&auml;ngre tid &auml;n det kommer bokning inte att accepteras.</p>
        <p>Du kan &auml;ven v&auml;lja ifall du vill att bokningen ska repeteras flera dagar. Du v&auml;ljer d&aring; hur m&aring;nga dagar framm&aring;t du vill att bokning ska repeteras. Alla bokningsdatum som krockade med n&aring;gonting annat kommer att skrivas ut. </p>
        <p>F&ouml;r varje bokning kan du skriva i en sammanfattning. Den kommer vara l&auml;sbar f&ouml;r alla andra anv&auml;ndare.</p>
        <p>Efter att du st&auml;llt in de r&auml;tta start och slut tiderna f&ouml;r din bokning och fyllt i om de ska vara n&aring;gon repetition av bokning, tryck &quot;Spara&quot;. Ett meddelande kommer att visas om bokning var inkorrekt, information om de datum som inte var korrekta kommer att visas. G&aring; is&aring;fall tillbaka och &auml;ndra de felaktiga tiderna s&aring; att de inte krockar med n&aring;gon annan bokning. Efter att bokning &auml;r gjord kommer schemat automatiskt att uppdateras. Detta &auml;r n&ouml;dv&auml;ndigt f&ouml;r att all information ska uppdateras i databasen.</p>
        <p>Du kan inte boka en tid f&ouml;r ett datum som redan har varit, f&ouml;r en resurs du inte har r&auml;ttigheter att boka eller f&ouml;r en inaktiverad resurs. Dessa tider kommer att vara en annan f&auml;rg och kommer inte ha en bokningsl&auml;nk. </p>
        <p><a href="#top">Top</a></p>
        <h5><a name="modifying_deleting_a_reservation" id="modifying_deleting_a_reservation"></a>Modifying/Deleting 
          a Reservation</h5>
        <p>Det finns flera olika s&auml;tt att &auml;ndra eller ta bort en bokning. En &auml;r genom <a href="#my_control_panel">Startsidan</a> den andra �r genom bokningssystemet.
		Det �r bara du sj�lv som kan �ndra dina bokningar. Alla andra bokningar kommer att visas i bokningssystemet men det kommer inte finnas n�gon l�nk f�r att �ndra dem.</p>
        <p>F&ouml;r att &auml;ndra en bokning genom schemal&auml;ggaren, klicka p&aring; den bokning du vill &auml;ndra. I f&ouml;nstret som kommer upp har du tv&aring; val, antingen kan du &auml;ndra start och slut tiderna eller s&aring; kan du kryssa i &quot;Ta bort&quot; rutan. Efter att du gjort dina &auml;ndringar klickar du &quot;&Auml;ndra&quot;. De nya &auml;ndringarna sparas d&aring; till databasen. Om det blir fel &auml;r det bara att g&aring; tillbaka och &auml;ndra tiderna, kom ih&aring;g att bokningen inte f&aring;r &ouml;verlappa n&aring;gon annans bokning. Efter att bokningen har &auml;ndrats kommer schemat att uppdateras och visa &auml;ndringen.</p>
        <p>F&ouml;r att &auml;ndra en grupp av &aring;terkommande bokningar, kryssa i f&auml;ltet &quot;Uppdatera alla &aring;terkommande bokningar i gruppen?&quot;. Om det blir n&aring;gra dubbelbokningar skrivs datumen f&ouml;r dem ut.</p>
        <p>Det &auml;r om&ouml;jligt att &auml;ndra n&aring;got p&aring; en bokning som redan har varit. </p>
        <p align="right"><a href="#top">Top</a></p>
        <h5><a name="navigating" id="navigating"></a>Navigera i schemal&auml;ggaren</h5>
        <p>Det finns flera s&auml;tt att navigera i schemal&auml;ggaren.</p>
        <p>Ett s&auml;tt &auml;r att anv&auml;nda &quot;N&auml;sta vecka&quot; respektive &quot;F&ouml;reg&aring;ende vecka&quot; f&ouml;r att f&ouml;rflytta sig veckovis.</p>
        <p>Man kan ocks&aring; hoppa till vilket datum som helst genom att skriva in det i f&auml;ltet l&auml;ngst ner p&aring; sidan. </p>
        <p>Det g&aring;r &auml;ven att klicka upp navigeringskalendern genom att klicka p&aring; &quot;Visa kalender&quot; l&auml;ngst ner. N&auml;r du hittat det datum du &auml;r intresserad av klickar du p&aring; det f&ouml;r att flytta schemal&auml;ggaren dit.</p>
        <p align="right"><a href="#top">Top</a></p>
      </td>
    </tr>
  </table>
</div>