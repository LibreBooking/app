<?php
/**
* Finnish (fi) translation file.
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Veli-Matti Koukeri <vmkoukeri@saunalahti.fi>
* @version 05-14-06
* @package Languages
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
///////////////////////////////////////////////////////////
// INSTRUCTIONS
///////////////////////////////////////////////////////////
// This file contains all of the strings that are used throughout phpScheduleit.
// Please save the translated file as '2 letter language code'.lang.php.  For example, en.lang.php.
// 
// To make phpScheduleIt available in another language, simply translate each
//  of the following strings into the appropriate one for the language.  If there
//  is no direct translation, please provide the closest translation.  Please be sure
//  to make the proper additions the /config/langs.php file (instructions are in the file).
//  Also, please add a help translation for your language using en.help.php as a base.
//
// You will probably keep all sprintf (%s) tags in their current place.  These tags
//  are there as a substitution placeholder.  Please check the output after translating
//  to be sure that the sentences make sense.
//
// + Please use single quotes ' around all $strings.  If you need to use the ' character, please enter it as \'
// + Please use double quotes " around all $email.  If you need to use the " character, please enter it as \"
//
// + For all $dates please use the PHP strftime() syntax
//    http://us2.php.net/manual/en/function.strftime.php
//
// + Non-intuitive parts of this file will be explained with comments.  If you
//    have any questions, please email lqqkout13@users.sourceforge.net
//    or post questions in the Developers forum on SourceForge
//    http://sourceforge.net/forum/forum.php?forum_id=331297
///////////////////////////////////////////////////////////

////////////////////////////////
/* Do not modify this section */
////////////////////////////////
global $strings;			  //
global $email;				  //
global $dates;				  //
global $charset;			  //
global $letters;			  //
global $days_full;			  //
global $days_abbr;			  //
global $days_two;			  //
global $days_letter;		  //
global $months_full;		  //
global $months_abbr;		  //
global $days_letter;		  //
/******************************/

// Charset for this language
// 'iso-8859-1' will work for most languages
$charset = 'iso-8859-1';

/***
  DAY NAMES
  All of these arrays MUST start with Sunday as the first element 
   and go through the seven day week, ending on Saturday
***/
// The full day name
$days_full = array('sunnuntai', 'maanantai', 'tiistai', 'keskiviikko', 'torstai', 'perjantai', 'lauantai');
// The three letter abbreviation
$days_abbr = array('sun', 'maa', 'tii', 'kes', 'tor', 'per', 'lau');
// The two letter abbreviation
$days_two  = array('su', 'ma', 'ti', 'ke', 'to', 'pe', 'la');
// The one letter abbreviation
$days_letter = array('S', 'M', 'T', 'K', 'T', 'P', 'L');

/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('tammikuu', 'helmikuu', 'maaliskuu', 'huhtikuu', 'toukokuu', 'kesäkuuta', 'heinäkuu', 'elokuu', 'syyskuu', 'lokakuu', 'marraskuu', 'joulukuu');
// The three letter month name
$months_abbr = array('tammi', 'helmi', 'maalis', 'huhti', 'touko', 'kesä', 'heinä', 'elo', 'syys', 'loka', 'marras', 'joulu');

// All letters of the alphabet starting with A and ending with Z
$letters = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

/***
  DATE FORMATTING
  All of the date formatting must use the PHP strftime() syntax
  You can include any text/HTML formatting in the translation
***/
// General date formatting used for all date display unless otherwise noted
$dates['general_date'] = '%d.%m.%Y';
// General datetime formatting used for all datetime display unless otherwise noted
// The hour:minute:second will always follow this format
$dates['general_datetime'] = '%d.%m.%Y @';
// Date in the reservation notification popup and email
$dates['res_check'] = '%A %d.%m.%Y';
// Date on the scheduler that appears above the resource links
$dates['schedule_daily'] = '%A,<br/>%d.%m.%Y';
// Date on top-right of each page
$dates['header'] = '%A, %B %d, %Y';
// Jump box format on bottom of the schedule page
// This must only include %m %d %Y in the proper order,
//  other specifiers will be ignored and will corrupt the jump box 
$dates['jumpbox'] = '%m %d %Y';

/***
  STRING TRANSLATIONS
  All of these strings should be translated from the English value (right side of the equals sign) to the new language.
  - Please keep the keys (between the [] brackets) as they are.  The keys will not always be the same as the value.
  - Please keep the sprintf formatting (%s) placeholders where they are unless you are sure it needs to be moved.
  - Please keep the HTML and punctuation as-is unless you know that you want to change it.
***/
$strings['hours'] = 'tuntia';
$strings['minutes'] = 'minuuttia';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = 'mm';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = 'pp';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = 'vvvv';
$strings['am'] = 'am';
$strings['pm'] = 'pm';

$strings['Administrator'] = 'Ylläpitäjä';
$strings['Welcome Back'] = 'Tervetuloa, %s';
$strings['Log Out'] = 'Kirjaudu Ulos';
$strings['My Control Panel'] = 'Ohjauspaneeli';
$strings['Help'] = 'Ohjeet';
$strings['Manage Schedules'] = 'Aikataulut';
$strings['Manage Users'] = 'Käyttäjät';
$strings['Manage Resources'] = 'Resurssit';
$strings['Manage User Training'] = 'Käyttäjäkoulutukset';
$strings['Manage Reservations'] = 'Varaukset';
$strings['Email Users'] = 'Lähetä sähköpostia';
$strings['Export Database Data'] = 'Vie tietokannan tiedot';
$strings['Reset Password'] = 'Palauta salasana';
$strings['System Administration'] = 'Järjestelmänhallinta';
$strings['Successful update'] = 'Päivitys onnistui!';
$strings['Update failed!'] = 'Päivitys epäonnistui!';
$strings['Manage Blackout Times'] = 'Käyttökatkot';
$strings['Forgot Password'] = 'Unohtunut salasana';
$strings['Manage My Email Contacts'] = 'Osoitekirja';
$strings['Choose Date'] = 'Valitse päivämäärä';
$strings['Modify My Profile'] = 'Muuta profiilia';
$strings['Register'] = 'Rekisteröidy';
$strings['Processing Blackout'] = 'Käsitellään käytöstäpoistoa';
$strings['Processing Reservation'] = 'Käsitellään varausta';
$strings['Online Scheduler [Read-only Mode]'] = 'Online-aikataulu [Vain lukuoikeus]';
$strings['Online Scheduler'] = 'Online-aikataulu';
$strings['phpScheduleIt Statistics'] = 'phpScheduleIt -tilastot';
$strings['User Info'] = 'Käyttäjän tiedot:';

$strings['Could not determine tool'] = 'Toimintoa ei voitu määrittää. Palaa ohjauspaneeliin, ja yritä uudelleen.';
$strings['This is only accessable to the administrator'] = 'Vain ylläpitäjän käytössä.';
$strings['Back to My Control Panel'] = 'Takaisin ohjauspaneeliin.';
$strings['That schedule is not available.'] = 'Aikataulu ei ole saatavissa.';
$strings['You did not select any schedules to delete.'] = 'Et valinnut poistettavia aikatauluja.';
$strings['You did not select any members to delete.'] = 'Et valinnut poistettavia osallistujia.';
$strings['You did not select any resources to delete.'] = 'Et valinnut poistettavia resursseja.';
$strings['Schedule title is required.'] = 'Aikataulun otsikko on pakollinen tieto.';
$strings['Invalid start/end times'] = 'Epäkelpo aloitus-/lopetus -ajankohta';
$strings['View days is required'] = 'Näytettävä ajanjakso on pakollinen tieto.';
$strings['Day offset is required'] = 'Päiväsiirtymä on pakollinen tieto.';
$strings['Admin email is required'] = 'Ylläpitäjän sähköpostiosoite on pakollinen tieto.';
$strings['Resource name is required.'] = 'Resurssin nimi on pakollinen tieto.';
$strings['Valid schedule must be selected'] = 'Valitse kelvollinen aikataulu.';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'Vähimmäisvarausajan on oltava vähintään yhtäsuuri, kuin enimmäisvarausaika.';
$strings['Your request was processed successfully.'] = 'Syöttämäsi tieto käsiteltiin onnistuneesti.';
$strings['Go back to system administration'] = 'Palaa järjestelmänhallintaan';
$strings['Or wait to be automatically redirected there.'] = 'tai odota uudelleenohjausta.';
$strings['There were problems processing your request.'] = 'Syöttämäsi tiedon käsittely ei onnistunut.';
$strings['Please go back and correct any errors.'] = 'Ole hyvä, ja korjaa virheet.';
$strings['Login to view details and place reservations'] = 'Kirjaudu sisään nähdäksesi lisätietoja, ja lisätäksesi varauksia.';
$strings['Memberid is not available.'] = 'Käyttäjä-id:tä %s ei löytynyt.';

$strings['Schedule Title'] = 'Aikataulun otsikko';
$strings['Start Time'] = 'Aloitusaika';
$strings['End Time'] = 'Lopetusaika';
$strings['Time Span'] = 'Ajanjakso';
$strings['Weekday Start'] = 'Aloituspäivä';
$strings['Admin Email'] = 'Ylläpitäjän sähköpostiosoite';

$strings['Default'] = 'Vakio';
$strings['Reset'] = 'Palauta';
$strings['Edit'] = 'Muokkaa';
$strings['Delete'] = 'Poista';
$strings['Cancel'] = 'Peruuta';
$strings['View'] = 'Näytä';
$strings['Modify'] = 'Muuta';
$strings['Save'] = 'Tallenna';
$strings['Back'] = 'Edellinen';
$strings['Next'] = 'Seuraava';
$strings['Close Window'] = 'Sulje ikkuna';
$strings['Search'] = 'Etsi';
$strings['Clear'] = 'Tyhjennä';

$strings['Days to Show'] = 'Näytettävä ajanjakso';
$strings['Reservation Offset'] = 'Varaussiirtymä';
$strings['Hidden'] = 'Piilota';
$strings['Show Summary'] = 'Näytä yhteenveto';
$strings['Add Schedule'] = 'Lisää aikatauluun';
$strings['Edit Schedule'] = 'Muokkaa aikataulua';
$strings['No'] = 'Ei';
$strings['Yes'] = 'Kyllä';
$strings['Name'] = 'Nimi';
$strings['First Name'] = 'Etunimi';
$strings['Last Name'] = 'Sukunimi';
$strings['Resource Name'] = 'Resurssin nimi';
$strings['Email'] = 'Sähköpostiosoite';
$strings['Institution'] = 'Järjestö/Yritys';
$strings['Phone'] = 'Puhelin';
$strings['Password'] = 'Salasana';
$strings['Permissions'] = 'Oikeudet';
$strings['View information about'] = 'Näytä tiedot: %s %s';
$strings['Send email to'] = 'Lähetä sähköpostia käyttäjälle %s %s';
$strings['Reset password for'] = 'Nollaa käyttäjän %s %s salasana';
$strings['Edit permissions for'] = 'Muokkaa käyttäjän %s %s oikeuksia';
$strings['Position'] = 'Työnkuva';
$strings['Password (6 char min)'] = 'Salasana (vähintään kuusi kirjainta)';
$strings['Re-Enter Password'] = 'Syötä salasana uudelleen';

$strings['Sort by descending last name'] = 'Järjestä kääntäen, sukunimen mukaan';
$strings['Sort by descending email address'] = 'Järjestä kääntäen, sähköpostiosoitteen mukaan';
$strings['Sort by descending institution'] = 'Järjestä kääntäen, järjestön/yrityksen mukaan';
$strings['Sort by ascending last name'] = 'Järjestä sukunimen mukaan';
$strings['Sort by ascending email address'] = 'Järjestä sähköpostiosoitteen mukaan';
$strings['Sort by ascending institution'] = 'Järjesteä järjestön/yrityksen mukaan';
$strings['Sort by descending resource name'] = 'Järjestä kääntäen resurssin nimen mukaan';
$strings['Sort by descending location'] = 'Järjestä kääntäen sijainnin mukaan';
$strings['Sort by descending schedule title'] = 'Järjestä kääntäen aikataulun mukaan';
$strings['Sort by ascending resource name'] = 'Järjestä resurssin nimen mukaan';
$strings['Sort by ascending location'] = 'Järjestä sijainnin mukaan';
$strings['Sort by ascending schedule title'] = 'Järjestä aikataulun otsikon mukaan';
$strings['Sort by descending date'] = 'Järjestä kääntäen päivämäärän mukaan';
$strings['Sort by descending user name'] = 'Järjestä kääntäen käyttäjän nimen mukaan';
$strings['Sort by descending start time'] = 'Järjestä kääntäen aloitusajankohdan mukaan';
$strings['Sort by descending end time'] = 'Järjestä kääntäen lopetusajankohdan mukaan';
$strings['Sort by ascending date'] = 'Järjestä päivämäärän mukaan';
$strings['Sort by ascending user name'] = 'Järjestä käyttäjän nimen mukaan';
$strings['Sort by ascending start time'] = 'Järjestä aloitusajankohdan mukaan';
$strings['Sort by ascending end time'] = 'Järjestä lopetusajankohdan mukaan';
$strings['Sort by descending created time'] = 'Järjestä kääntäen luontiajankohdan mukaan';
$strings['Sort by ascending created time'] = 'Järjestä luontiajankohdan mukaan';
$strings['Sort by descending last modified time'] = 'Järjestä kääntäen muokkausajankohdan mukaan';
$strings['Sort by ascending last modified time'] = 'Järjestä muokkausajankohdan mukaan';

$strings['Search Users'] = 'Etsi käyttäjiä';
$strings['Location'] = 'Sijainti';
$strings['Schedule'] = 'Aikataulu';
$strings['Notes'] = 'Muistiinpanot';
$strings['Status'] = 'Tila';
$strings['All Schedules'] = 'Kaikki aikataulut';
$strings['All Resources'] = 'Kaikki resurssit';
$strings['All Users'] = 'Kaikki käyttäjät';

$strings['Edit data for'] = 'Muokkaa tietoja: %s';
$strings['Active'] = 'Aktiivinen';
$strings['Inactive'] = 'Inaktiivinen';
$strings['Toggle this resource active/inactive'] = 'Aseta aktiiviseksi/inaktiiviseksi';
$strings['Minimum Reservation Time'] = 'Vähimmäisvarausaika';
$strings['Maximum Reservation Time'] = 'Enimmäisvarausaika';
$strings['Auto-assign permission'] = 'Aseta oikeudet automaattisesti';
$strings['Add Resource'] = 'Lisää resurssi';
$strings['Edit Resource'] = 'Muokkaa resurssia';
$strings['Allowed'] = 'Sallittu';
$strings['Notify user'] = 'Huomauta käyttäjää';
$strings['User Reservations'] = 'Käyttäjävaraukset';
$strings['Date'] = 'Päivämäärä';
$strings['User'] = 'Käyttäjä';
$strings['Subject'] = 'Aihe';
$strings['Message'] = 'Viesti';
$strings['Please select users'] = 'Valitse käyttäjät';
$strings['Send Email'] = 'Lähetä sähköpostia';
$strings['problem sending email'] = 'Sähköpostin lähetys epäonnistui surkeasti. Voit yrittää uudelleen, mutta perinteisten viestintämenetelmien käyttö on luultavasti nopeampaa.';
$strings['The email sent successfully.'] = 'Sähköpostin lähetys onnistui.';
$strings['do not refresh page'] = '<u>Älä</u> lataa tätä sivua uudelleen. Uudelleenlataus lähettää viestin uudelleen.';
$strings['Return to email management'] = 'Palaa sähköpostien hallintaan.';
$strings['Please select which tables and fields to export'] = 'Valitse vietävät taulut ja kentät:';
$strings['all fields'] = '- kaikki kentät -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = 'Plain text';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = 'Vie tietoja';
$strings['Reset Password for'] = 'Nollaa käyttäjän %s salasana';
$strings['Please edit your profile'] = 'Ole hyvä, ja muokkaa profiiliasi';
$strings['Please register'] = 'Ole hyvä, ja rekisteröidy';
$strings['Email address (this will be your login)'] = 'Sähköpostiosoite (toimii myös käyttäjätunnuksenasi)';
$strings['Keep me logged in'] = 'Pysyvä sisäänkirjautuminen <br/>(vaatii keksejä)';
$strings['Edit Profile'] = 'Muokkaa profiilia';
$strings['Please Log In'] = 'Kirjaudu sisään';
$strings['Email address'] = 'Sähköpostiosoite';
$strings['First time user'] = 'Ensimmäinen käyttökertasi?';
$strings['Click here to register'] = 'Klikkaa tässä rekisteröityäksesi';
$strings['Register for phpScheduleIt'] = 'Rekisteröidy phpScheduleIt-käyttäjäksi';
$strings['Log In'] = 'Kirjaudu sisään';
$strings['View Schedule'] = 'Näytä aikataulu';
$strings['View a read-only version of the schedule'] = 'Näytä suojattu versio aikataulusta';
$strings['I Forgot My Password'] = 'Unohdin salasanani';
$strings['Retreive lost password'] = 'Palauta unohtunut salasana';
$strings['Get online help'] = 'Get online help';
$strings['Language'] = 'Kieli';
$strings['(Default)'] = '(Vakio)';

$strings['My Announcements'] = 'Ilmoitukseni';
$strings['My Reservations'] = 'Varaukseni';
$strings['My Permissions'] = 'Oikeuteni';
$strings['My Quick Links'] = 'Pikalinkit';
$strings['Announcements as of'] = '%s mennessä ilmestyneet ilmoitukset';
$strings['There are no announcements.'] = 'Ei ilmoituksia';
$strings['Resource'] = 'Resurssi';
$strings['Created'] = 'Luotu';
$strings['Last Modified'] = 'Muutettu viimeksi';
$strings['View this reservation'] = 'Näytä varaus';
$strings['Modify this reservation'] = 'Muokkaa varausta';
$strings['Delete this reservation'] = 'Poista varaus';
$strings['Bookings'] = 'Bookings';
$strings['Change My Profile Information/Password'] = 'Change Profile';		// @since 1.2.0
$strings['Manage My Email Preferences'] = 'Email Preferences';				// @since 1.2.0
$strings['Mass Email Users'] = 'Lähetä sähköpostia monelle käyttäjälle';
$strings['Search Scheduled Resource Usage'] = 'Search Reservations';		// @since 1.2.0
$strings['Export Database Content'] = 'Vie tietokannan sisältö';
$strings['View System Stats'] = 'Näytä järjestelmän tilastot';
$strings['Email Administrator'] = 'Lähetä postia ylläpitäjälle';

$strings['Email me when'] = 'Lähetä minulle postia, jos:';
$strings['I place a reservation'] = 'Teen varauksen';
$strings['My reservation is modified'] = 'Varaustani on muokattu';
$strings['My reservation is deleted'] = 'Varaukseni on postettu';
$strings['I prefer'] = 'Mieluiten:';
$strings['Your email preferences were successfully saved'] = 'Sähköpostin asetukset tallennettu!';
$strings['Return to My Control Panel'] = 'Palaa ohjauspaneeliin';

$strings['Please select the starting and ending times'] = 'Valitse aloitus- ja lopetusajankohdat:';
$strings['Please change the starting and ending times'] = 'Muuta aloitus -ja lopetusajankohtia:';
$strings['Reserved time'] = 'Varausaika:';
$strings['Minimum Reservation Length'] = 'Vähimmäisvarausaika:';
$strings['Maximum Reservation Length'] = 'Enimmäisvarausaika:';
$strings['Reserved for'] = 'Varattu:';
$strings['Will be reserved for'] = 'Tulee olemaan varattuna:';
$strings['N/A'] = '-- Tyhjä --';
$strings['Update all recurring records in group'] = 'Päivitä kaikki ryhmän uusiutuvat tiedot?';
$strings['Delete?'] = 'Poista?';
$strings['Never'] = '-- Ei koskaan --';
$strings['Days'] = 'Päivää';
$strings['Weeks'] = 'Viikkoa';
$strings['Months (date)'] = 'Kuukausia (pvm)';
$strings['Months (day)'] = 'Kuukausia (päivä)';
$strings['First Days'] = 'Ensimmäiset päivät';
$strings['Second Days'] = 'Toiset päivät';
$strings['Third Days'] = 'Kolmannet päivät';
$strings['Fourth Days'] = 'Neljännet päivät';
$strings['Last Days'] = 'Viimeiset päivät';
$strings['Repeat every'] = 'Toista joka:';
$strings['Repeat on'] = 'Toista aina:';
$strings['Repeat until date'] = 'Toista kunnes:';
$strings['Summary'] = 'Yhteenveto';

$strings['View schedule'] = 'Näytä aikataulu:';
$strings['My Past Reservations'] = 'Menneet varaukset';
$strings['Other Reservations'] = 'Muut varaukset';
$strings['Other Past Reservations'] = 'Muut menneet varaukset';
$strings['Blacked Out Time'] = 'Poissa käytöstä ollut aika';
$strings['Set blackout times'] = 'Aseta pois käytöstä %s ajaksi, aina %s';
$strings['Reserve on'] = 'Varaa %s aina %s';
$strings['Prev Week'] = '&laquo; Ed. Viikko';
$strings['Jump 1 week back'] = 'Viikko taaksepäin';
$strings['Prev days'] = '&#8249; Ed. %d päivää';
$strings['Previous days'] = '&#8249; Edelliset %d päivää';
$strings['This Week'] = 'Tämä viikko';
$strings['Jump to this week'] = 'Siirry tähän viikkoon';
$strings['Next days'] = 'Seuraavat %d päivää &#8250;';
$strings['Next Week'] = 'Seuraava viikko &raquo;';
$strings['Jump To Date'] = 'Siirry päivään';
$strings['View Monthly Calendar'] = 'Näytä kuukausikalenteri';
$strings['Open up a navigational calendar'] = 'Avaa navigointikalenteri';

$strings['View stats for schedule'] = 'Näytä aikataulun tilastot:';
$strings['At A Glance'] = 'Mulkaisu';
$strings['Total Users'] = 'Käyttäjiä yhteensä:';
$strings['Total Resources'] = 'Resursseja yhteensä:';
$strings['Total Reservations'] = 'Varauksia yhteensä:';
$strings['Max Reservation'] = 'Varauksia enintään:';
$strings['Min Reservation'] = 'Varauksia vähintää:';
$strings['Avg Reservation'] = 'Varauksia keskimäärin:';
$strings['Most Active Resource'] = 'Akiivisin resurssi:';
$strings['Most Active User'] = 'Aktiivisimmat käyttäjät:';
$strings['System Stats'] = 'Järjestelmätilasto:';
$strings['phpScheduleIt version'] = 'phpScheduleIt version:';
$strings['Database backend'] = 'Tietokantapalvelin:';
$strings['Database name'] = 'Tietokannan nimi:';
$strings['PHP version'] = 'PHP:n versio:';
$strings['Server OS'] = 'Palvelimen käyttöjärjestelmä:';
$strings['Server name'] = 'Palvelimen nimi:';
$strings['phpScheduleIt root directory'] = 'phpScheduleIt root-hakemisto:';
$strings['Using permissions'] = 'Käytetään oikeuksia:';
$strings['Using logging'] = 'Käytetään sisäänkirjausta:';
$strings['Log file'] = 'Logitiedosto:';
$strings['Admin email address'] = 'Ylläpitäjän sähköpostiosoite:';
$strings['Tech email address'] = 'Teknisen avun sähköpostiosoite:';
$strings['CC email addresses'] = '"CC"-sähköpostiosoitteet:';
$strings['Reservation start time'] = 'Varauksen aloitusaika:';
$strings['Reservation end time'] = 'Varauksen lopetusaika:';
$strings['Days shown at a time'] = 'Päivät näytetään ajalla:';
$strings['Reservations'] = 'Varaukset';
$strings['Return to top'] = 'Palaa yläreunaan';
$strings['for'] = 'kohteelle';

$strings['Select Search Criteria'] = 'Valitse hakuehdot:';
$strings['Schedules'] = 'Aikataulut:';
$strings['Hold CTRL to select multiple'] = 'Pidä pohjassa CTRL-näppäintä valitaksesi useampia';
$strings['Users'] = 'Käyttäjät';
$strings['Resources'] = 'Resurssit';
$strings['Starting Date'] = 'Aloituspäivä:';
$strings['Ending Date'] = 'Lopetuspäivä:';
$strings['Starting Time'] = 'Aloitusaika:';
$strings['Ending Time'] = 'Lopetusaika:';
$strings['Output Type'] = 'Tulosteen tyyppi:';
$strings['Manage'] = 'Hallittse';
$strings['Total Time'] = 'Käytetty aika:';
$strings['Total hours'] = 'Yhteensä tunteja:';
$strings['% of total resource time'] = '% käytetystä resurssiajasta.';
$strings['View these results as'] = 'Näytä resurssit seuraavasti:';
$strings['Edit this reservation'] = 'Muokkaa varausta';
$strings['Search Results'] = 'Haun tulokset';
$strings['Search Resource Usage'] = 'Etsi resurssien käytöstä';
$strings['Search Results found'] = 'Hakutulokset: %d varauksista löytynyt';
$strings['Try a different search'] = 'Yritä toista hakua';
$strings['Search Run On'] = 'Käytä hakua kohteeseen:';
$strings['Member ID'] = 'Käyttäjä-id';
$strings['Previous User'] = '&laquo; Edellinen käyttäjä';
$strings['Next User'] = 'Seuraava käyttäjä &raquo;';

$strings['No results'] = 'Ei tuloksia';
$strings['That record could not be found.'] = 'Tietoa ei löytynyt.';
$strings['This blackout is not recurring.'] = 'Tämä käyttökatkos ei ole toistuva.';
$strings['This reservation is not recurring.'] = 'Tämä varaus ei ole toistuva.';
$strings['There are no records in the table.'] = 'Taulussa %s ei ole tietoja.';
$strings['You do not have any reservations scheduled.'] = 'Aikataulussasi ei ole varauksia.';
$strings['You do not have permission to use any resources.'] = 'Sinulla ei ole oikeuksia resursseihin.';
$strings['No resources in the database.'] = 'Tietokannassa ei ole resursseja.';
$strings['There was an error executing your query'] = 'Kyselysi käsittely päätyi virheeseen.';

$strings['That cookie seems to be invalid'] = 'Keksi ';
$strings['We could not find that email in our database.'] = 'Sähköpostiosoitetta ei löytynyt  tietokannasta.';
$strings['That password did not match the one in our database.'] = 'Sähköposti ei vastannut tietokannassa olevaa.';
$strings['You can try'] = '<br />Voit:<br />Rekisteröidä sähköpostiosoitteen.<br />Tai:<br />Yrittää kirjautua uudelleen.';
$strings['A new user has been added'] = 'Uusi käyttäjä lisätty.';
$strings['You have successfully registered'] = 'Rekisteröinti onnistui!';
$strings['Continue'] = 'Jatka...';
$strings['Your profile has been successfully updated!'] = 'Profiilisi on päivitetty!';
$strings['Please return to My Control Panel'] = 'Palaa ohjauspaneeliin';
$strings['Valid email address is required.'] = '- Vaaditaan kelvollinen sähköpostiosoite';
$strings['First name is required.'] = '- Vaaditaan kelvollinen etunimi';
$strings['Last name is required.'] = '- Vaaditaan kelvollinen sukunimi';
$strings['Phone number is required.'] = '- Vaaditaan puhelinnumero';
$strings['That email is taken already.'] = '- Sähköpostiosoite on jo käytössä<br />Ole hyvä, ja käytä jotain muuta osoitetta.';
$strings['Min 6 character password is required.'] = '- Salasanan on oltava vähintää kuusi merkkiä pitkä.';
$strings['Passwords do not match.'] = '- Salasanat eivät täsmää.';

$strings['Per page'] = 'Per sivu:';
$strings['Page'] = 'Sivu:';

$strings['Your reservation was successfully created'] = 'Varauksesi luotiin onnistuneesti';
$strings['Your reservation was successfully modified'] = 'Varauksesi muokkaus onnistui';
$strings['Your reservation was successfully deleted'] = 'Varauksesi poistettiin onnistuneesti';
$strings['Your blackout was successfully created'] = 'Käyttökatko luotiin onnistuneesti';
$strings['Your blackout was successfully modified'] = 'Käyttökatkon muokkaus onnistui';
$strings['Your blackout was successfully deleted'] = 'Käyttäkatko poistettiin onnistuneesti';
$strings['for the follwing dates'] = 'seuraaville päiville:';
$strings['Start time must be less than end time'] = 'Aloitusajankohdan pitää olla pienempi kuin lopetusajankohdan.';
$strings['Current start time is'] = 'Tämänhetkinen aloitusajankohta on:';
$strings['Current end time is'] = 'Tämänhetkinen lopetusajankohta on:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'Varauksen pituus ei ole sallitun pituuden rajoissa.';
$strings['Your reservation is'] = 'Varauksesi on:';
$strings['Minimum reservation length'] = 'Pienin sallittu varauksen pituus:';
$strings['Maximum reservation length'] = 'Suurin sallittu varauksen pituus:';
$strings['You do not have permission to use this resource.'] = 'Sinulla ei ole oikeuksia käyttää tätä resurssia.';
$strings['reserved or unavailable'] = '%s to %s is reserved or unavailable.';	// @since 1.1.0
$strings['Reservation created for'] = 'Varaus luotu ajalle %s';
$strings['Reservation modified for'] = 'Varaus muokattu ajalle %s';
$strings['Reservation deleted for'] = 'Varaus poistettu ajalle %s';
$strings['created'] = 'luotu';
$strings['modified'] = 'muokattu';
$strings['deleted'] = 'poistettu';
$strings['Reservation #'] = 'Varaus #';
$strings['Contact'] = 'Yhteys';
$strings['Reservation created'] = 'Varaus luotu';
$strings['Reservation modified'] = 'Varausta muokattu';
$strings['Reservation deleted'] = 'Varaus poistettu';

$strings['Reservations by month'] = 'Varaukset / kuukausi';
$strings['Reservations by day of the week'] = 'Varaukset / viikonpäivä';
$strings['Reservations per month'] = 'Varauksia per kuukausi';
$strings['Reservations per user'] = 'Varauksia per käyttäjä';
$strings['Reservations per resource'] = 'Varauksia per resurssi';
$strings['Reservations per start time'] = 'Varauksia per aloitusajankohta';
$strings['Reservations per end time'] = 'Varauksia per lopetusajankohta';
$strings['[All Reservations]'] = '[Kaikki varaukset]';

$strings['Permissions Updated'] = 'Oukeudet päivitetty';
$strings['Your permissions have been updated'] = '%s -oikeutesi on päivitetty';
$strings['You now do not have permission to use any resources.'] = 'Sinulla ei ole oikeutta käyttää resursseja.';
$strings['You now have permission to use the following resources'] = 'Sinulla on nyt oikeus käyttää seuraavia resursseja:';
$strings['Please contact with any questions.'] = 'Yhteyshenkilösi ongelmatilanteissa on: %s';
$strings['Password Reset'] = 'Salasana nollattu';

$strings['This will change your password to a new, randomly generated one.'] = 'Tämä vaihtaa salasanasi satunnaisesti luotuun uuteen.';
$strings['your new password will be set'] = 'Syötettyäsi sähköpostiosoitteen, ja klikattuasi "Vaihda salasana"-nappia,  salasanasi päivitetään ja lähetetään sinulle sähköpostilla.';
$strings['Change Password'] = 'Vaihda salasana';
$strings['Sorry, we could not find that user in the database.'] = 'Käyttäjää ei löytynyt tietokannasta.';
$strings['Your New Password'] = 'Uusi %s salasanasi';
$strings['Your new passsword has been emailed to you.'] = 'Uusi salasanasi on lähetetty sinulle sähköpostila.<br />Saatuasi salasanan,<a href="index.php">kirjaudu sisään</a> käyttämällä sitä, ja vaihda salasana haluamaksesi klikkaamalla &quot;Muokkaa profiilin tietoja/salasanaa&quot; -linkkiä Ohjauspaneelissa.';
$strings['You are not logged in!'] = 'Et ole kirjautunut sisään!';

$strings['Setup'] = 'Asetukset';
$strings['Please log into your database'] = 'Kirjaudu tietokantaan';
$strings['Enter database root username'] = 'Syötä tietokannan root-käyttäjätunnus:';
$strings['Enter database root password'] = 'Syötä tietokannan root-salasana:';
$strings['Login to database'] = 'Kirjaudu tietokantaan';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = 'Root-käyttäjätunnusta <b>ei</b> tarvita. Mikä tahansa käyttäjätunnus, jolla on oikeus luoda tauluja, toimii.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = 'Luodaan kaikki tarpeelliset tietokannat ja taulut phpScheduleIt-ohjelmistolle.';
$strings['It also populates any required tables.'] = 'Myös kaikki tarvittavat taulut alustetaan.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = 'Varoitus: KAIKKI JO OLEMASSA TIETO phpScheduleIt -TIETOKANNOISSA POISTETAAN!';
$strings['Not a valid database type in the config.php file.'] = 'Tietokannan tyyppi tiedostossa config.php ei ole kelvollinen.';
$strings['Database user password is not set in the config.php file.'] = 'Tietokannan käyttäjän salasanaa ei ole annettu config.php -tiedostossa.';
$strings['Database name not set in the config.php file.'] = 'Tietokannan nimeä ei ole annettu config.php-tiedostossa.';
$strings['Successfully connected as'] = 'Yhteys onnistui:';
$strings['Create tables'] = 'Luotaulut &gt;';
$strings['There were errors during the install.'] = 'Asennuksen aikana havaittiin virheitä. On mahdollista, että phpScheduleIt toimii tästä huolimatta, jos virheet olivat pieniä.<br/><br/>Lähetä mahdolliset kysymykset SourceForge-<a href="http://sourceforge.net/forum/?group_id=95547">keskustelualuelle</a>.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = 'phpScheduleIt-asennus onnistui. Voit alkaa käyttämään ohjelmistoa.';
$strings['Thank you for using phpScheduleIt'] = 'Muistathan poistaa \'install\'-hakemisto TÄYDELLISESTI. Tämä on erityisen tärkeää, sillä hakemisto sisältää salasanoja, ja muuta tärkeää tietoa, joka mahdollistaa kenelle tahansa murtautumisen tietokantaan!<br /><br />Kiitos, että valitsit phpScheduleIt:n!';
$strings['This will update your version of phpScheduleIt from 0.9.3 to 1.0.0.'] = 'Tämä päivittää phpScheduleIt-version 0.9.3:sta versioksi 1.0.0';
$strings['There is no way to undo this action'] = 'Tätä toimintoa ei voi peruuttaa!';
$strings['Click to proceed'] = 'Klikkaa jatkaaksesi!';
$strings['This version has already been upgraded to 1.0.0.'] = 'Tämä versio on jo päivitetty versioksi 1.0.0';
$strings['Please delete this file.'] = 'Ole hyvä, ja poista tämä tiedosto.';
$strings['Patch completed successfully'] = 'Päivitys suoritettu onnistuneesti';
$strings['This will populate the required fields for phpScheduleIt 1.0.0 and patch a data bug in 0.9.9.'] = 'Tämä alustaa tarvittavat kentät phpScheduleIt 1.0.0-versiolle, ja päivittää version 0.9.9 data-bugin.<br />Sinun tarvitsee ajaa tämä vain, jos suoritit manuaalisen SQL-päivityksen, tai olet päivittämässä versiosta 0.9.9';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = 'If no value is specified, the default password set in the config file will be used.';
$strings['Notify user that password has been changed?'] = 'Notify user that password has been changed?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'This system requires that you have an email address.';
$strings['Invalid User Name/Password.'] = 'Invalid User Name/Password.';
$strings['Pending User Reservations'] = 'Pending User Reservations';
$strings['Approve'] = 'Approve';
$strings['Approve this reservation'] = 'Approve this reservation';
$strings['Approve Reservations'] ='Approve Reservations';

$strings['Announcement'] = 'Announcement';
$strings['Number'] = 'Number';
$strings['Add Announcement'] = 'Add Announcement';
$strings['Edit Announcement'] = 'Edit Announcement';
$strings['All Announcements'] = 'All Announcements';
$strings['Delete Announcements'] = 'Delete Announcements';
$strings['Use start date/time?'] = 'Use start date/time?';
$strings['Use end date/time?'] = 'Use end date/time?';
$strings['Announcement text is required.'] = 'Announcement text is required.';
$strings['Announcement number is required.'] = 'Announcement number is required.';

$strings['Pending Approval'] = 'Pending Approval';
$strings['My reservation is approved'] = 'My reservation is approved';
$strings['This reservation must be approved by the administrator.'] = 'This reservation must be approved by the administrator.';
$strings['Approval Required'] = 'Approval Required';
$strings['No reservations requiring approval'] = 'No reservations requiring approval';
$strings['Your reservation was successfully approved'] = 'Your reservation was successfully approved';
$strings['Reservation approved for'] = 'Reservation approved for %s';
$strings['approved'] = 'approved';
$strings['Reservation approved'] = 'Reservation approved';

$strings['Valid username is required'] = 'Valid username is required';
$strings['That logon name is taken already.'] = 'That logon name is taken already.';
$strings['this will be your login'] = '(this will be your login)';
$strings['Logon name'] = 'Logon name';
$strings['Your logon name is'] = 'Your logon name is %s';

$strings['Start'] = 'Start';
$strings['End'] = 'End';
$strings['Start date must be less than or equal to end date'] = 'Start date must be less than or equal to end date';
$strings['That starting date has already passed'] = 'That starting date has already passed';
$strings['Basic'] = 'Basic';
$strings['Participants'] = 'Participants';
$strings['Close'] = 'Close';
$strings['Start Date'] = 'Start Date';
$strings['End Date'] = 'End Date';
$strings['Minimum'] = 'Minimum';
$strings['Maximum'] = 'Maximum';
$strings['Allow Multiple Day Reservations'] = 'Allow Multiple Day Reservations';
$strings['Invited Users'] = 'Invited Users';
$strings['Invite Users'] = 'Invite Users';
$strings['Remove Participants'] = 'Remove Participants';
$strings['Reservation Invitation'] = 'Reservation Invitation';
$strings['Manage Invites'] = 'Manage Invites';
$strings['No invite was selected'] = 'No invite was selected';
$strings['reservation accepted'] = '%s Accepted Your Invitation on %s';
$strings['reservation declined'] = '%s Declined Your Invitation on %s';
$strings['Login to manage all of your invitiations'] = 'Login to manage all of your invitiations';
$strings['Reservation Participation Change'] = 'Reservation Participation Change';
$strings['My Invitations'] = 'My Invitations';
$strings['Accept'] = 'Accept';
$strings['Decline'] = 'Decline';
$strings['Accept or decline this reservation'] = 'Accept or decline this reservation';
$strings['My Reservation Participation'] = 'My Reservation Participation';
$strings['End Participation'] = 'End Participation';
$strings['Owner'] = 'Owner';
$strings['Particpating Users'] = 'Particpating Users';
$strings['No advanced options available'] = 'No advanced options available';
$strings['Confirm reservation participation'] = 'Confirm reservation participation';
$strings['Confirm'] = 'Confirm';
$strings['Do for all reservations in the group?'] = 'Do for all reservations in the group?';

$strings['My Calendar'] = 'My Calendar';
$strings['View My Calendar'] = 'View My Calendar';
$strings['Participant'] = 'Participant';
$strings['Recurring'] = 'Recurring';
$strings['Multiple Day'] = 'Multiple Day';
$strings['[today]'] = '[today]';
$strings['Day View'] = 'Day View';
$strings['Week View'] = 'Week View';
$strings['Month View'] = 'Month View';
$strings['Resource Calendar'] = 'Resource Calendar';
$strings['View Resource Calendar'] = 'Schedule Calendar';	// @since 1.2.0
$strings['Signup View'] = 'Signup View';

$strings['Select User'] = 'Select User';
$strings['Change'] = 'Change';

$strings['Update'] = 'Update';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'phpScheduleIt Update is only available for versions 1.0.0 or later';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt is already up to date';
$strings['Migrating reservations'] = 'Migrating reservations';

$strings['Admin'] = 'Admin';
$strings['Manage Announcements'] = 'Manage Announcements';
$strings['There are no announcements'] = 'There are no announcements';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = 'Maximum Participant Capacity';
$strings['Leave blank for unlimited'] = 'Leave blank for unlimited';
$strings['Maximum of participants'] = 'This resource has a maximum capacity of %s participants';
$strings['That reservation is at full capacity.'] = 'That reservation is at full capacity.';
$strings['Allow registered users to join?'] = 'Allow registered users to join?';
$strings['Allow non-registered users to join?'] = 'Allow non-registered users to join?';
$strings['Join'] = 'Join';
$strings['My Participation Options'] = 'My Participation Options';
$strings['Join Reservation'] = 'Join Reservation';
$strings['Join All Recurring'] = 'Join All Recurring';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = 'You are not participating on the following reservation dates because they are at full capacity.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = 'You are already invited to this reservation. Please follow participation instructions previously sent to your email.';
$strings['Additional Tools'] = 'Additional Tools';
$strings['Create User'] = 'Create User';
$strings['Check Availability'] = 'Check Availability';
$strings['Manage Additional Resources'] = 'Manage Additional Resources';
$strings['All Additional Resources'] = 'All Additional Resources';
$strings['Number Available'] = 'Number Available';
$strings['Unlimited'] = 'Unlimited';
$strings['Add Additional Resource'] = 'Add Additional Resource';
$strings['Edit Additional Resource'] = 'Edit Additional Resource';
$strings['Checking'] = 'Checking';
$strings['You did not select anything to delete.'] = 'You did not select anything to delete.';
$strings['Added Resources'] = 'Added Resources';
$strings['Additional resource is reserved'] = 'The additional resource %s only has %s available at a time';
$strings['All Groups'] = 'All Groups';
$strings['Group Name'] = 'Group Name';
$strings['Delete Groups'] = 'Delete Groups';
$strings['Manage Groups'] = 'Manage Groups';
$strings['None'] = 'None';
$strings['Group name is required.'] = 'Group name is required.';
$strings['Groups'] = 'Groups';
$strings['Current Groups'] = 'Current Groups';
$strings['Group Administration'] = 'Group Administration';
$strings['Reminder Subject'] = 'Reservation reminder- %s, %s %s';
$strings['Reminder'] = 'Reminder';
$strings['before reservation'] = 'before reservation';
$strings['My Participation'] = 'My Participation';
$strings['My Past Participation'] = 'My Past Participation';
$strings['Timezone'] = 'Timezone';
$strings['Export'] = 'Export';
$strings['Select reservations to export'] = 'Select reservations to export';
$strings['Export Format'] = 'Export Format';
$strings['This resource cannot be reserved less than x hours in advance'] = 'This resource cannot be reserved less than %s hours in advance';
$strings['This resource cannot be reserved more than x hours in advance'] = 'This resource cannot be reserved more than %s hours in advance';
$strings['Minimum Booking Notice'] = 'Minimum Booking Notice';
$strings['Maximum Booking Notice'] = 'Maximum Booking Notice';
$strings['hours prior to the start time'] = 'hours prior to the start time';
$strings['hours from the current time'] = 'hours from the current time';
$strings['Contains'] = 'Contains';
$strings['Begins with'] = 'Begins with';
$strings['Accessory Name'] = 'Accessory Name';
$strings['Accessories'] = 'Accessories';
$strings['All Accessories'] = 'All Accessories';
$strings['Added Accessories'] = 'Added Accessories';
// end since 1.2.0

/***
  EMAIL MESSAGES
  Please translate these email messages into your language.  You should keep the sprintf (%s) placeholders
   in their current position unless you know you need to move them.
  All email messages should be surrounded by double quotes "
  Each email message will be described below.
***/
// @since 1.1.0
// Email message that a user gets after they register
$email['register'] = "%s, %s \r\n"
				. "You have successfully registered with the following information:\r\n"
				. "Logon: %s\r\n"
				. "Name: %s %s \r\n"
				. "Phone: %s \r\n"
				. "Institution: %s \r\n"
				. "Position: %s \r\n\r\n"
				. "Please log into the scheduler at this location:\r\n"
				. "%s \r\n\r\n"
				. "You can find links to the online scheduler and to edit your profile at My Control Panel.\r\n\r\n"
				. "Please direct any resource or reservation based questions to %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "Ylläpitäjä,\r\n\r\n"
				. "Uusi käyttäjä on rekisteröitynyt seuraavin tiedoin:\r\n"
				. "Sähköposti: %s \r\n"
				. "Nimi: %s %s \r\n"
				. "Puhelin: %s \r\n"
				. "Yritys/järjestö: %s \r\n"
				. "Toimenkuva: %s \r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "You have successfully %s reservation #%s.\r\n\r\n<br/><br/>"
			. "Please use this reservation number when contacting the administrator with any questions.\r\n\r\n<br/><br/>"
			. "A reservation between %s %s and %s %s for %s"
			. " located at %s has been %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "Tämä varaus on toistettu seuraaville päiville:\r\n<br/>";
$email['reservation_activity_3'] = "Kaikki toistuvat varaukset tässä ryhmässä %s myös.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "Varaukselle on annettu seuraavanlainen yhteenveto:\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "Jos teit virheen, ole hyvä, ja ota yhteyttä ylläpitäjään osoitteessa: %s, tai soittamalla numeroon %s.\r\n\r\n<br/><br/>"
			. "Voit tutkia, tai muokata varaustietoja milloin tahansa kirjautumalla %s paikassa:\r\n<br/>"
			. "<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "Lähetä tekniset kysymykset osoitteeseen <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
			. "Reservation #%s has been approved.\r\n\r\n<br/><br/>"
			. "Please use this reservation number when contacting the administrator with any questions.\r\n\r\n<br/><br/>"
			. "A reservation between %s %s and %s %s for %s"
			. " located at %s has been %s.\r\n\r\n<br/><br/>";
			
// Email that the user gets when the administrator changes their password
$email['password_reset'] = "Ylläpitäjä on nollannut %s -salasanasi.\r\n\r\n"
			. "Väliaikainen salasanasi on:\r\n\r\n %s\r\n\r\n"
			. "Käytä tätä  väliaikaista salasanaa (kopio/liimaa ollaksesi varma oikeinkirjoituksesta) kirjautuaksesi %s paikassa %s ja vaihda salasana välittömästi käyttämällä Muokkaa profiilia/salasanaa -linkkiä pikalinkit-taulussa.\r\n\r\n"
			. "Ongelmatilanteissa kysymyksiisi vastaa %s.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\nUusi salasana käyttäjätilillesi %s on:\r\n\r\n"
			. "%s\r\n\r\n"
			. "Kirjadu sisään (%s) tällä salasanalla (kopioi/liimaa varmistaaksesi oikeinkirjoituksen), ja vaihda salasana haluamaksesi klikkaamalla Muokkaa profiilia/salasanaa -linkkiä Ohjauspaneelissa.\r\n\r\n"
			. "Ongelmatilanteissa kysymyksiisi vastaa %s.";
			
// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s has invited you to participate in the following reservation:\r\n\r\n"
		. "Resource: %s\r\n"
		. "Start Date: %s\r\n"
		. "Start Time: %s\r\n"
		. "End Date: %s\r\n"
		. "End Time: %s\r\n"
		. "Summary: %s\r\n"
		. "Repeated Dates (if present): %s\r\n\r\n"
		. "To accept this invitation click this link (copy and paste if it is not highlighted) %s\r\n"
		. "To decline this invitation click this link (copy and paste if it is not highlighted) %s\r\n"
		. "To accept select dates or manage your invitations at a later time, please log into %s at %s";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "You have been removed from the following reservation:\r\n\r\n"
		. "Resource: %s\r\n"
		. "Start Date: %s\r\n"
		. "Start Time: %s\r\n"
		. "End Date: %s\r\n"
		. "End Time: %s\r\n"
		. "Summary: %s\r\n"
		. "Repeated Dates (if present): %s\r\n\r\n";	

// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "Your reservation for %s from %s %s to %s %s is approaching.";
?>