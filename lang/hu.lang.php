<?php
/**
* Hungarian (hu) translation file.
*
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Attila <atoth@cmr.sote.hu>
* @version 04-04-05
* @package Languages
*
* Copyright (C) 2003 - 2006 phpScheduleIt
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
$charset = 'iso-8859-2';

/***
  DAY NAMES
  All of these arrays MUST start with Sunday as the first element
   and go through the seven day week, ending on Saturday
***/
// The full day name
$days_full = array('Vasárnap', 'Hétfõ', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek', 'Szombat');
// The three letter abbreviation
$days_abbr = array('Vas', 'Hét', 'Ked', 'Sze', 'Csü', 'Pén', 'Szo');
// The two letter abbreviation
$days_two  = array('Va', 'Hé', 'Ke', 'Se', 'Cs', 'Pé', 'So');
// The one letter abbreviation
$days_letter = array('V', 'H', 'K', 'S', 'C', 'P', 'Z');

/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('Január', 'Február', 'Március', 'Április', 'Május', 'Június', 'Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December');
// The three letter month name
$months_abbr = array('Jan', 'Feb', 'Már', 'Ápr', 'Máj', 'Jún', 'Júl', 'Aug', 'Sze', 'Okt', 'Nov', 'Dec');

// All letters of the alphabet starting with A and ending with Z
$letters = array ('A', 'Á', 'B', 'C', 'D', 'E', 'É', 'F', 'G', 'H', 'I', 'Í', 'J', 'K', 'L', 'M', 'N', 'O', 'Ó', 'Ö', 'Õ', 'P', 'Q', 'R', 'S', 'T', 'U', 'Ú', 'Ü', 'Û', 'V', 'W', 'X', 'Y', 'Z');

/***
  DATE FORMATTING
  All of the date formatting must use the PHP strftime() syntax
  You can include any text/HTML formatting in the translation
***/
// General date formatting used for all date display unless otherwise noted
$dates['general_date'] = '%Y.%m.%d.';
// General datetime formatting used for all datetime display unless otherwise noted
// The hour:minute:second will always follow this format
$dates['general_datetime'] = '%Y.%m.%d. @';
// Date in the reservation notification popup and email
$dates['res_check'] = '%Y.%m.%d. %A';
// Date on the scheduler that appears above the resource links
$dates['schedule_daily'] = '%Y.%m.%d.<br/>%A';
// Date on top-right of each page
$dates['header'] = '%Y. %B %d. %A';
// Jump box format on bottom of the schedule page
// This must only include %m %d %Y in the proper order,
//  other specifiers will be ignored and will corrupt the jump box
$dates['jumpbox'] = '%Y.%m.%d.';

/***
  STRING TRANSLATIONS
  All of these strings should be translated from the English value (right side of the equals sign) to the new language.
  - Please keep the keys (between the [] brackets) as they are.  The keys will not always be the same as the value.
  - Please keep the sprintf formatting (%s) placeholders where they are unless you are sure it needs to be moved.
  - Please keep the HTML and punctuation as-is unless you know that you want to change it.
***/
$strings['hours'] = 'Óra';
$strings['minutes'] = 'perc';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = 'hh';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = 'nn';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = 'ÉÉÉÉ';
$strings['am'] = 'de';
$strings['pm'] = 'du';

$strings['Administrator'] = 'Adminisztrátor';
$strings['Welcome Back'] = 'Üdvözlet, %s';
$strings['Log Out'] = 'Kilépés';
$strings['My Control Panel'] = 'Irányító Pult';
$strings['Help'] = 'Segítség';
$strings['Manage Schedules'] = 'Elõjegyzés Kezelés';
$strings['Manage Users'] ='Felhasználó Kezelés';
$strings['Manage Resources'] ='Kontingens Kezelés';
$strings['Manage User Training'] ='Felhasználó Képzés';
$strings['Manage Reservations'] ='Vizsgálat Kezelés';
$strings['Email Users'] ='Körlevél a Felhasználóknak';
$strings['Export Database Data'] = 'Adatbázis Adatok Exportálása';
$strings['Reset Password'] = 'Jelszó Visszaállítása';
$strings['System Administration'] = 'Rendszer Adminisztráció';
$strings['Successful update'] = 'Sikeres Frissítés!';
$strings['Update failed!'] = 'Sikeretlen Frissítés!';
$strings['Manage Blackout Times'] = 'Tiltott Idõszak Kezelés';
$strings['Forgot Password'] = 'Elfelejtett Jelszó';
$strings['Manage My Email Contacts'] = 'Email Kapcsolat Kezelés';
$strings['Choose Date'] = 'Válasszon Dátumot';
$strings['Modify My Profile'] = 'Profil Módosítása';
$strings['Register'] = 'Regisztráció';
$strings['Processing Blackout'] = 'Tiltott Idõszak Feldolgozása';
$strings['Processing Reservation'] = 'Vizsgálat Feldolgozása';
$strings['Online Scheduler [Read-only Mode]'] = 'Elõjegyzés [Csak Olvasható Mód]';
$strings['Online Scheduler'] = 'Elõjegyzés';
$strings['phpScheduleIt Statistics'] = 'phpScheduleIt Statisztikák';
$strings['User Info'] = 'Felhasználói Információ:';

$strings['Could not determine tool'] = 'Érvénytelen eszköz. Térjen vissza a Vezérlõ Pulthoz és próbálkozzon ismét.';
$strings['This is only accessable to the administrator'] = 'Csak az adminisztrátor számára elérhetõ';
$strings['Back to My Control Panel'] = 'Vissza a Vezérlõ Pulthoz';
$strings['That schedule is not available.'] = 'A választott Elõjegyzés nem elérhetõ.';
$strings['You did not select any schedules to delete.'] = 'Nem választotta ki a törlendõ Elõjegyzést.';
$strings['You did not select any members to delete.'] = 'Nem választotta ki a törlendõ Felhasználót.';
$strings['You did not select any resources to delete.'] = 'Nem választotta ki a törlendõ Kontingenst.';
$strings['Schedule title is required.'] = 'Az Elõjegyzés tartalmának megadása kötelezõ.';
$strings['Invalid start/end times'] = 'Érvénytelen kezdõ/befejezõ idõpont';
$strings['View days is required'] = 'Megjelenítendõ napok számának megadása kötelezõ';
$strings['Day offset is required'] = 'Az Elõjegyzés minimális idõbeli távolságának megadása kötelezõ';
$strings['Admin email is required'] = 'Az Adminisztrátor email címének megadása kötelezõ';
$strings['Resource name is required.'] = 'A Kontingens megnevezése kötelezõ.';
$strings['Valid schedule must be selected'] = 'Érvényes Elõjegyzés nevének megadása kötelezõ';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'A legrövidebb vizsgálati idõtartam nem haladhatja meg a maximális idõtartamot.';
$strings['Your request was processed successfully.'] = 'A kérését a Rendszer sikeresen feldolgozta.';
$strings['Go back to system administration'] = 'Vissza a Rendszer Adminisztrációhoz';
$strings['Or wait to be automatically redirected there.'] = 'Vagy várja meg, amíg automatikusan átirányítódik.';
$strings['There were problems processing your request.'] = 'Hiba történt a kérés feldolgozás közben.';
$strings['Please go back and correct any errors.'] = 'Kérem menjen vissza és javítson ki minden hibát.';
$strings['Login to view details and place reservations'] = 'A részletek megtekintéséhez és vizsgálat elõjegyzéshez jelentkezzen be';
$strings['Memberid is not available.'] = 'Az Azonosító: %s nem használható.';

$strings['Schedule Title'] = 'Elõjegyzés Megnevezése';
$strings['Start Time'] = 'Kezdõ idõpont';
$strings['End Time'] = 'Befejezõ idõpont';
$strings['Time Span'] = 'Idõtartam';
$strings['Weekday Start'] = 'A Hét Kezdõ Napja';
$strings['Admin Email'] = 'Admin Email';

$strings['Default'] = 'Alapértelmezett';
$strings['Reset'] = 'Visszaállít';
$strings['Edit'] = 'Szerkesztés';
$strings['Delete'] = 'Törlés';
$strings['Cancel'] = 'Mégse';
$strings['View'] = 'Megtekint';
$strings['Modify'] = 'Módosítás';
$strings['Save'] = 'Mentés';
$strings['Back'] = 'Vissza';
$strings['Next'] = 'Elõre';
$strings['Close Window'] = 'Ablak Bezárása';
$strings['Search'] = 'Keresés';
$strings['Clear'] = 'Kitörlés';

$strings['Days to Show'] = 'Megjelenítendõ Napok Száma';
$strings['Reservation Offset'] = 'Elõjegyzés minimális idõbeli távolsága';
$strings['Hidden'] = 'Rejtett';
$strings['Show Summary'] = 'Összegzés Megjelenítése';
$strings['Add Schedule'] = 'Új Elõjegyzés Hozzáadása';
$strings['Edit Schedule'] = 'Elõjegyzés Szerkesztése';
$strings['No'] = 'Nem';
$strings['Yes'] = 'Igen';
$strings['Name'] = 'Név';
$strings['First Name'] = 'Vezetéknév';
$strings['Last Name'] = 'Keresztnév';
$strings['Resource Name'] = 'Kontingens Neve';
$strings['Email'] = 'Email cím';
$strings['Institution'] = 'Intézmény';
$strings['Phone'] = 'Telefon';
$strings['Password'] = 'Jelszó';
$strings['Permissions'] = 'Jogosultságok';
$strings['View information about'] = 'Tájékoztató megtekintése a következõ felhasználóról: %s %s';
$strings['Send email to'] = 'Email küldése a következõ felhasználónak: %s %s';
$strings['Reset password for'] = 'A következõ felhasználó jelszavának átállítása: %s %s';
$strings['Edit permissions for'] = 'A következõ felhasználó jogosultságainak szerkesztése: %s %s';
$strings['Position'] = 'Beosztás';
$strings['Password (6 char min)'] = 'Jelszó (minimum %s betû)'; // @since 1.1.0
$strings['Re-Enter Password'] = 'A jelszó ismételt megadása';

$strings['Sort by descending last name'] = 'Csökkenõ sorrend a Keresztnév alapján';
$strings['Sort by descending email address'] = 'Csökkenõ sorrend az Email cím alapján';
$strings['Sort by descending institution'] = 'Csökkenõ sorrend az Intézmény megnevezése alapján';
$strings['Sort by ascending last name'] = 'Emelkedõ sorrend a Keresztnév alapján';
$strings['Sort by ascending email address'] = 'Emelkedõ sorrend az Email cím alapján';
$strings['Sort by ascending institution'] = 'Emelkedõ sorrend az Intézmény megnevezése alapján';
$strings['Sort by descending resource name'] = 'Csökkenõ sorrend a Kontingens neve alapján';
$strings['Sort by descending location'] = 'Csökkenõ sorrend Helyszín alapján';
$strings['Sort by descending schedule title'] = 'Csökkenõ sorrend az Elõjegyzés megnevezése alapján';
$strings['Sort by ascending resource name'] = 'Emelkedõ sorrend a Kontingens neve alapján';
$strings['Sort by ascending location'] = 'Emelkedõ sorrend Helyszín alapján';
$strings['Sort by ascending schedule title'] = 'Emelkedõ sorrend az Elõjegyzés megnevezése alapján';
$strings['Sort by descending date'] = 'Csökkenõ sorrend a dátum alapján';
$strings['Sort by descending user name'] = 'Csökkenõ sorrend Felhasználói név alapján';
$strings['Sort by descending start time'] = 'Csökkenõ sorrend a Kezdõ idõpont alapján';
$strings['Sort by descending end time'] = 'Csökkenõ sorrend a Befejezõ idõpont alapján';
$strings['Sort by ascending date'] = 'Emelkedõ sorrend dátum alapján';
$strings['Sort by ascending user name'] = 'Emelkedõ sorrend a Felhasználó név alapján';
$strings['Sort by ascending start time'] = 'Emelkedõ sorrend a Kezdõ idõpont alapján';
$strings['Sort by ascending end time'] = 'Emelkedõ sorrend a Befejezõ idõpont alapján';
$strings['Sort by descending created time'] = 'Csökkenõ sorrend a Létrehozás dátuma alapján';
$strings['Sort by ascending created time'] = 'Emelkedõ sorrend a Létrehozás dátuma alapján';
$strings['Sort by descending last modified time'] = 'Csökkenõ sorrend az utolsó Módosítás ideje alapján';
$strings['Sort by ascending last modified time'] = 'Emelkedõ sorrend az utolsó Módosítás ideje alapján';

$strings['Search Users'] = 'Felhasználó Keresése';
$strings['Location'] = 'Helyszín';
$strings['Schedule'] = 'Elõjegyzés';
$strings['Phone'] = 'Telefon';
$strings['Notes'] = 'Megjegyzés';
$strings['Status'] = 'Állapot';
$strings['All Schedules'] = 'Minden Elõjegyzés';
$strings['All Resources'] = 'Minden Kontingens';
$strings['All Users'] = 'Minden Felhasználó';

$strings['Edit data for'] = 'A következõ adatainak szerkesztése: %s';
$strings['Active'] = 'Aktív';
$strings['Inactive'] = 'Inaktív';
$strings['Toggle this resource active/inactive'] = 'A Kontingens aktiválása/inaktiválása';
$strings['Minimum Reservation Time'] = 'Minimum Vizsgálati idõtartam';
$strings['Maximum Reservation Time'] = 'Maximum Vizsgálati idõtartam';
$strings['Auto-assign permission'] = 'Jogosultságok Automatikus Kiosztása';
$strings['Add Resource'] = 'Kontingens Hozzáadása';
$strings['Edit Resource'] = 'Kontingens Szerkesztése';
$strings['Allowed'] = 'Engedélyezett';
$strings['Notify user'] = 'Felhasználó Értesítése';
$strings['User Reservations'] = 'Felhasználó Vizsgálatai';
$strings['Date'] = 'Dátum';
$strings['User'] = 'Felhasználó';
$strings['Email Users'] = 'Körlevél küldése felhasználó(k)nak';
$strings['Subject'] = 'Tárgy';
$strings['Message'] = 'Szöveg';
$strings['Please select users'] = 'Válasszon Felhasználót';
$strings['Send Email'] = 'Email Küldése';
$strings['problem sending email'] = 'Probléma adódott az email küldése során. Kérem próbálja újra késõbb.';
$strings['The email sent successfully.'] = 'Az emailt sikerült postázni.';
$strings['do not refresh page'] = 'Kérem <u>NE</u> frissítse ezt az oldalt, mert az email újra elküldésre kerül.';
$strings['Return to email management'] = 'Visszatérés az Email Kezeléshez';
$strings['Please select which tables and fields to export'] = 'Kérem válassza ki, hogy melyik táblát és mezõt kívánja exportálni:';
$strings['all fields'] = '- minden mezõ -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = 'Sima szöveg';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = 'Adatok Exportálása';
$strings['Reset Password for'] = '%s Jelszavának visszaállítása';
$strings['Please edit your profile'] = 'Kérem hajtsa végre Profilján a kívánt változtatásokat';
$strings['Please register'] = 'Kérem Regisztráljon';
$strings['Keep me logged in'] = 'A Rendszer õrizzen meg bejelentkezett állapotban <br/>(cookie támogatás szükséges)';
$strings['Edit Profile'] = 'Profil Szerkesztése';
$strings['Register'] = 'Regisztráció';
$strings['Please Log In'] = 'Kérem Jelentkezzen Be';
$strings['Email address'] = 'Email Cím';
$strings['Password'] = 'Jelszó';
$strings['First time user'] = 'Elsõ Alkalom?';
$strings['Click here to register'] = 'Kattintson ide a regisztrációhoz';
$strings['Register for phpScheduleIt'] = 'Regisztráció a phpScheduleIt Rendszerbe';
$strings['Log In'] = 'Bejelentkezés';
$strings['View Schedule'] = 'Elõjegyzések Megtekintése';
$strings['View a read-only version of the schedule'] = 'Megtekintés Csak Olvasható Módban';
$strings['I Forgot My Password'] = 'Elfelejtett Jelszó';
$strings['Retreive lost password'] = 'Elfelejtett jelszó elkérése';
$strings['Get online help'] = 'Online Segítség';
$strings['Language'] = 'Nyelv';
$strings['(Default)'] = '(Alapértelmezett)';

$strings['My Announcements'] = 'Bejelentések';
$strings['My Reservations'] = 'Vizsgálatok';
$strings['My Permissions'] = 'Jogosultságok';
$strings['My Quick Links'] = 'Gyors Linkek';
$strings['Announcements as of'] = 'Bejelentések %s';
$strings['There are no announcements.'] = 'Nincsen Bejelentés.';
$strings['Resource'] = 'Kontingens';
$strings['Created'] = 'Létrehozás';
$strings['Last Modified'] = 'Utolsó Módosítás';
$strings['View this reservation'] = 'Vizsgálat megtekintése';
$strings['Modify this reservation'] = 'Vizsgálat módosítása';
$strings['Delete this reservation'] = 'Vizsgálat törlése';
$strings['Bookings'] = 'Elõjegyzés';
$strings['Change My Profile Information/Password'] = 'Profil Szerkesztés/Jelszó Váltás'; // @since 1.2.0
$strings['Manage My Email Preferences'] = 'Email Beállítások Szerkesztése'; // @since 1.2.0
$strings['Mass Email Users'] = 'Köremail küldése';
$strings['Search Scheduled Resource Usage'] = 'Keresés a kontingensek kihasználtsági adatai között'; // @since 1.2.0
$strings['Export Database Content'] = 'Adatbázis Tartalom Exportálása';
$strings['View System Stats'] = 'Rendszer Statisztika Megtekintése';
$strings['Email Administrator'] = 'Email Küldése az Adminisztrátornak';

$strings['Email me when'] = 'Email küldése a következõ esetben:';
$strings['I place a reservation'] = 'Vizsgálat elõjegyzése';
$strings['My reservation is modified'] = 'Elõjegyzett vizsgálat módosíttása';
$strings['My reservation is deleted'] = 'Elõjegyzett vizsgálat törlése';
$strings['I prefer'] = 'Elõnyben részesített formátum:';
$strings['Your email preferences were successfully saved'] = 'Az email beállítások sikeresen tárolásra kerültek!';
$strings['Return to My Control Panel'] = 'Vissza a Vezérlõ Pulthoz';

$strings['Please select the starting and ending times'] = 'Választhat egy kezdõ és egy befejezõ idõpontot:';
$strings['Please change the starting and ending times'] = 'Módosíthatja a kezdõ és a befejezõ idõpontot:';
$strings['Reserved time'] = 'Fenntartott idõtartam:';
$strings['Minimum Reservation Length'] = 'Minimum Vizsgálati Idõ:';
$strings['Maximum Reservation Length'] = 'Maximum Vizsgálati Idõ:';
$strings['Reserved for'] = 'Fenntartva:';
$strings['Will be reserved for'] = 'Vizsgálatot elõjegyzõ felhasználó:';
$strings['N/A'] = 'N/A';
$strings['Update all recurring records in group'] = 'Ismételt Elõfordulás(ok) Frissítése';
$strings['Delete?'] = 'Törlés?';
$strings['Never'] = '-- Soha --';
$strings['Days'] = 'Naponta';
$strings['Weeks'] = 'Hetenként';
$strings['Months (date)'] = 'Hónapban (Dátum)';
$strings['Months (day)'] = 'Hónapban (Nap)';
$strings['First Days'] = 'Elsõ nap';
$strings['Second Days'] = 'Második napon';
$strings['Third Days'] = 'Harmadik napon';
$strings['Fourth Days'] = 'Negyedik napon';
$strings['Last Days'] = 'Utolsó nap';
$strings['Repeat every'] = 'Ismételt elõfordulás:';
$strings['Repeat on'] = 'Ismétlõdjön:';
$strings['Repeat until date'] = 'Ismétlõdjön a következõ idõpontig:';
$strings['Choose Date'] = 'Válasszon dátumot';
$strings['Summary'] = 'Összegzés';

$strings['View schedule'] = 'Elõjegyzés megtekintése:';
$strings['My Reservations'] = 'Saját Vizsgálat';
$strings['My Past Reservations'] = 'Lejárt Saját Vizsgálat';
$strings['Other Reservations'] = 'Egyéb Vizsgálat';
$strings['Other Past Reservations'] = 'Lejárt Egyéb Vizsgálat';
$strings['Blacked Out Time'] = 'Tiltott Idõpont';
$strings['Set blackout times'] = 'Idõpont Tiltása %s %s';
$strings['Reserve on'] = 'Reserve %s on %s';
$strings['Prev Week'] = '&laquo; Elõzõ Hét';
$strings['Jump 1 week back'] = '1 Héttel Vissza';
$strings['Prev days'] = '&#8249; Elõzõ %d nap';
$strings['Previous days'] = '&#8249; Elõzõ %d nap';
$strings['This Week'] = 'Aktuális Hét';
$strings['Jump to this week'] = 'Ugrás erre a hétre';
$strings['Next days'] = 'Következõ %d nap &#8250;';
$strings['Next Week'] = 'Következõ hét &raquo;';
$strings['Jump To Date'] = 'Ugrás erre a napra';
$strings['View Monthly Calendar'] = 'Naptár Megtekintése Havi Bontásban';
$strings['Open up a navigational calendar'] = 'Navigáló naptár megnyitása';

$strings['View stats for schedule'] = 'Elõjegyzés statisztikáinak megjelenítése:';
$strings['At A Glance'] = 'Egy Pillantra';
$strings['Total Users'] = 'Összes Felhasználó:';
$strings['Total Resources'] = 'Összes Kontingens:';
$strings['Total Reservations'] = 'Összes Vizsgálat:';
$strings['Max Reservation'] = 'Maximum Vizsgálat:';
$strings['Min Reservation'] = 'Minimum Vizsgálat:';
$strings['Avg Reservation'] = 'Átlagos Vizsgálat:';
$strings['Most Active Resource'] = 'Legaktívabb Kontingens:';
$strings['Most Active User'] = 'Legaktívabb Felhasználó:';
$strings['System Stats'] = 'Rendszer Statisztika';
$strings['phpScheduleIt version'] = 'phpScheduleIt verzió:';
$strings['Database backend'] = 'Adatbázis backend:';
$strings['Database name'] = 'Adatbázis név:';
$strings['PHP version'] = 'PHP verziószám:';
$strings['Server OS'] = 'Szerver OS:';
$strings['Server name'] = 'Szerver név:';
$strings['phpScheduleIt root directory'] = 'phpScheduleIt gyökér könyvtár:';
$strings['Using permissions'] = 'Jogosultság kezelés használata:';
$strings['Using logging'] = 'Naplózás használata:';
$strings['Log file'] = 'Napló fájl:';
$strings['Admin email address'] = 'Adminisztrátor email címe:';
$strings['Tech email address'] = 'Technikai támogatás email címe:';
$strings['CC email addresses'] = 'CC email cím:';
$strings['Reservation start time'] = 'Vizsgálat kezdõ idõpont:';
$strings['Reservation end time'] = 'Vizsgálat befejezõ idõpont:';
$strings['Days shown at a time'] = 'Egyszerre megjelnített napok:';
$strings['Reservations'] = 'Vizsgálati elõjegyzés';
$strings['Return to top'] = 'Vissza a tetejére';
$strings['for'] = ':';

$strings['Select Search Criteria'] = 'Keresési Feltétel Kiválasztása';
$strings['Schedules'] = 'Elõjegyzések:';
$strings['All Schedules'] = 'Összes Elõjegyzés';
$strings['Hold CTRL to select multiple'] = 'Többszörös választáshoz tartsa lenyomva a CTRL-t';
$strings['Users'] = 'Felhasználók:';
$strings['All Users'] = 'Összes Felhasználó';
$strings['Resources'] = 'Kontingens:'; // @since 1.2.0
$strings['All Resources'] = 'Összes Kontingens';
$strings['Starting Date'] = 'Kezdõ Dátum:';
$strings['Ending Date'] = 'Befejezõ Dátum:';
$strings['Starting Time'] = 'Kezdõ Idõpont:';
$strings['Ending Time'] = 'Befejezõ Idõpont:';
$strings['Output Type'] = 'Kijelzési Mód:';
$strings['Manage'] = 'Kezelés';
$strings['Total Time'] = 'Összesített Idõtartam';
$strings['Total hours'] = 'Összesített órák:';
$strings['% of total resource time'] = '%-a az összes Vizsgálati Idõnek';
$strings['View these results as'] = 'Az eredmények megtekintése a következõképpen:';
$strings['Edit this reservation'] = 'A Vizsgálat szerkesztése';
$strings['Search Results'] = 'Keresés Eredménye';
$strings['Search Resource Usage'] = 'Kontingens Kihasználtság szerinti keresés';
$strings['Search Results found'] = 'Keresés Eredménye: %d Találat';
$strings['Try a different search'] = 'Másik keresés';
$strings['Search Run On'] = 'Keresés a Következõn Futott:';
$strings['Member ID'] = 'Felhasználói Azonosító';
$strings['Previous User'] = '&laquo; Elõzõ Felhasználó';
$strings['Next User'] = 'Következõ Felhasználó &raquo;';

$strings['No results'] = 'Nincs Találat';
$strings['That record could not be found.'] = 'Ilyen Bejegyzés nem található..';
$strings['This blackout is not recurring.'] = 'A Tiltott Idõpont nem ismétlõdik.';
$strings['This reservation is not recurring.'] = 'A Vizsgálat nem ismétlõdik.';
$strings['There are no records in the table.'] = 'Nincs egy Bejegyzés sem a következõ Táblában: %s.';
$strings['You do not have any reservations scheduled.'] = 'Nem található ön által elõjegyzett Vizsgálat.';
$strings['You do not have permission to use any resources.'] = 'Önnek egyik Kontingens használatához sincs joga.';
$strings['No resources in the database.'] = 'Nincs Kontingens az adatbázisban.';
$strings['There was an error executing your query'] = 'Hiba történt a kérés feldolgozása közben:';

$strings['That cookie seems to be invalid'] = 'A Cookie érvénytelennek tõnik';
$strings['We could not find that logon in our database.'] = 'Nem található ilyen Elérés az adatbázisban.';	// @since 1.1.0
$strings['That password did not match the one in our database.'] = 'A megadott Jelszó nem egyezik az adatbázisban szereplõvel.';
$strings['You can try'] = '<br />Próbálin meg:<br />Regisztrálni egy email címet.<br />Or:<br />Próbáljon belépni újból.';
$strings['A new user has been added'] = 'Az új Felhasználó bejegyzésre került';
$strings['You have successfully registered'] = 'Sikeres Regisztráció!';
$strings['Continue'] = 'Folytatás...';
$strings['Your profile has been successfully updated!'] = 'A Profil sikeresen frissítésre került!';
$strings['Please return to My Control Panel'] = 'Kérem térjen vissza a Vezérlõ Pulthoz';
$strings['Valid email address is required.'] = '- Valós email cím megadása szükséges.';
$strings['First name is required.'] = '- Vezetéknév megadása kötelezõ.';
$strings['Last name is required.'] = '- Keresztnév megadása kötelezõ.';
$strings['Phone number is required.'] = '- Telefonszám megadása kötelezõ.';
$strings['That email is taken already.'] = '- A megadott email cím foglalt.<br />Kérem válasszon egy másikat.';
$strings['Min 6 character password is required.'] = '- Min %s betû hosszú jelszó megadása szükséges.';
$strings['Passwords do not match.'] = '- A jelszó nem egyezik.';

$strings['Per page'] = 'Oldalanként:';
$strings['Page'] = 'Oldal:';

$strings['Your reservation was successfully created'] = 'A Vizsgálat sikeresen bejegyzésre került';
$strings['Your reservation was successfully modified'] = 'A Vizsgálat sikeresen módosításra került';
$strings['Your reservation was successfully deleted'] = 'A Vizsgálat sikeresen törlésre került';
$strings['Your blackout was successfully created'] = 'A Tiltott Idõpont sikeresen bejegyzésre került';
$strings['Your blackout was successfully modified'] = 'A Tiltott Idõpont sikeresen módosításra került';
$strings['Your blackout was successfully deleted'] = 'A Tiltott Idõpont sikeresen törlésre került';
$strings['for the follwing dates'] = 'az alábbi idõpont(ok)ban:';
$strings['Start time must be less than end time'] = 'A Kezdõ Idõpontnak korábbinak kell lenni a Befejezõ Idõpontnál';
$strings['Current start time is'] = 'Aktuális Kezdõ Idõpont:';
$strings['Current end time is'] = 'Aktuális Befejezõ Idõpont:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'A Vizsgálat megadott hossza nem teljesíti az idõtartammal kapcsolatban\ meghatározott feltételeket.';
$strings['Your reservation is'] = 'Az Ön Vizsgálata:';
$strings['Minimum reservation length'] = 'Minimális Vizsgálati Idõtartam:';
$strings['Maximum reservation length'] = 'Maximális Vizsgálati Idõtartam:';
$strings['You do not have permission to use this resource.'] = 'Nincs Jogosultsága az adott Kontingens használatához.';
$strings['reserved or unavailable'] = 'az %s %s foglalt, vagy nem használható.';	// @since 1.1.0
$strings['Reservation created for'] = 'Vizsgálat létrehozva %s';
$strings['Reservation modified for'] = 'Vizsgálat módosítva %s';
$strings['Reservation deleted for'] = 'Vizsgálat törölve %s';
$strings['created'] = 'létrehozva';
$strings['modified'] = 'módosítva';
$strings['deleted'] = 'törölve';
$strings['Reservation #'] = 'Vizsgálat #';
$strings['Contact'] = 'Kapcsolat';
$strings['Reservation created'] = 'Vizsgálat létrehozva';
$strings['Reservation modified'] = 'Vizsgálat módosítva';
$strings['Reservation deleted'] = 'Vizsgálat törölve';

$strings['Reservations by month'] = 'Vizsgálatok Hónapos Bontásban';
$strings['Reservations by day of the week'] = 'Vizsgálatok Napos Bontásban';
$strings['Reservations per month'] = 'Vizsgálatok Hónaponként';
$strings['Reservations per user'] = 'Vizsgálatok Felhasználónként';
$strings['Reservations per resource'] = 'Vizsgálatok Kontingensenként';
$strings['Reservations per start time'] = 'Vizsgálatok Kezdõ Idõpont Alapján';
$strings['Reservations per end time'] = 'Vizsgálatok Befejezõ Idõpont Alapján';
$strings['[All Reservations]'] = '[Minden Vizsgálat]';

$strings['Permissions Updated'] = 'Frissültek a Jogosultságok';
$strings['Your permissions have been updated'] = '%s Jogosultásgok frissítésre kerültek';
$strings['You now do not have permission to use any resources.'] = 'Egy Kontingens használatához sincs Jogosultsága.';
$strings['You now have permission to use the following resources'] = 'Mostantól Jogosultsággal rendelkezik a következõ Kontingens(ek) használatához:';
$strings['Please contact with any questions.'] = 'Kérdés esetén kérem vegye fel a kapcsolatot a következõvel: %s.';
$strings['Password Reset'] = 'Jelszó Visszaállítva';

$strings['This will change your password to a new, randomly generated one.'] = 'Ezzel Jelszava véletlenszerûre fog változni.';
$strings['your new password will be set'] = 'Miután megadta az Email címét és a "Jelszó Megváltoztatása" gombra kattint, az újdonsült Jelszavát a rendszer regisztrálja és elküldi önnek Email-ben.';
$strings['Change Password'] = 'Jelszó Megváltoztatása';
$strings['Sorry, we could not find that user in the database.'] = 'Sajnos a megadott Felhasználó nem található meg az adatbázisban.';
$strings['Your New Password'] = 'Az Ön Új %s Jelszava';
$strings['Your new passsword has been emailed to you.'] = 'Elkészült!<br />'
    			. 'Az Újdonsült Jelszavát a Rendszer elküldte Önnek.<br />'
    			. 'Kérem ellenõrizze postafiókját és a nyítólapon Kattintson a <a href="index.php">Bejelentkezés</a> linkre.'
    			. ' Használja az Új Jelszavát és változtassa meg azonnal a &quot;Profil Szerkesztése/Jelszó Megváltoztatása&quot;'
    			. ' menüpont alatt a Vezérlõ Pultban.';

$strings['You are not logged in!'] = 'Nincs Bejelentkezve!';

$strings['Setup'] = 'Telepítés';
$strings['Please log into your database'] = 'Kérem jelentkezzen be az adatbázisba';
$strings['Enter database root username'] = 'Adja meg az adatbázis felhasználójának azonosítóját:';
$strings['Enter database root password'] = 'Adja meg az adatbázis felhasználójának jelszavát:';
$strings['Login to database'] = 'Bejelentkezés az adatbázisba';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = 'Az adatbázis root felhasználójának megadása <b>nem</b> szükséges. Bármely adatbázis felhasználó megfelel, amelynek van jogosultsága a táblák létrehozására.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = 'Ezzel telepítésre kerül minden szükséges phpScheduleIt Adatbázis és Tábla.';
$strings['It also populates any required tables.'] = 'Valamint feltölti a szükséges Táblákat.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = 'Figyelmeztetés: MINDEN KORÁBBI ADAT TÖRLÉSRE KERÜL A phpScheduleIt ADATBÁZISBÓL!';
$strings['Not a valid database type in the config.php file.'] = 'Érvénytelen adatbázis típus szerepel a config.php fájlban.';
$strings['Database user password is not set in the config.php file.'] = 'Az adatbázis felhasználójának jelszava nincs megadva a config.php fájlban.';
$strings['Database name not set in the config.php file.'] = 'Az adatbázis neve nincs megadva config.php fájlban.';
$strings['Successfully connected as'] = 'Sikeres kapcsolódás a következõ néven';
$strings['Create tables'] = 'Táblák létrehozása &gt;';
$strings['There were errors during the install.'] = 'Hiba történt a telepítés során. Elképzelhetõ, hogy a phpScheduleIt mégis mûködni fog, amennyiben ez csak kis jelentõségû volt.<br/><br/>'
	. 'Kérdésekkel keresse fel a projekt fórumát a <a href="http://sourceforge.net/forum/?group_id=95547">SourceForge</a>-on.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = 'A phpScheduleIt telepítése sikeresen befejezõdött és a Rendszer használatra kész.';
$strings['Thank you for using phpScheduleIt'] = 'Kérem bizonyosodjon meg róla, hogy a \'install\' KÖNYVTÁRAT TELJESEN ELTÁVOLÍTOTTA.'
	. ' A könyvtár törlése alapvetõ biztonsági kérdés, mert bizalmas információkat (adatbázis jelszó) tartalmaz.'
	. ' Elmulasztása széles biztonsági rést hagy nyitva, melyen át bármikor betörhetnek az adatbázisba!'
	. '<br /><br />'
	. 'Köszönet, amiért a phpScheduleIt-et választotta!';
$strings['There is no way to undo this action'] = 'A következõ beavatkozás visszaállítására nincs lehetõség!';
$strings['Click to proceed'] = 'Kattintson a továbblépéshez';
$strings['Please delete this file.'] = 'Kérem törölje ezt a fájlt.';
$strings['Successful update'] = 'A Korszerûsítés sikerrel járt';
$strings['Patch completed successfully'] = 'A foltozás sikeresen befejezõdött';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = 'Ha nincs megadva jelszó, akkor a rendszer konfigurációs fájlban tárolt alapértelmezett jelszót fogja használni.';
$strings['Notify user that password has been changed?'] = 'Kapjon értesítést a felhasználó a jelszó változásról?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'A rendszer használatának elõfeltétele, hogy legyen egy email címe.';
$strings['Invalid User Name/Password.'] = 'Érvénytelen Felhasználó Név/Jelszó.';
$strings['Pending User Reservations'] = 'Az Vizsgálat(ok) bejegyzése a jóváhagyás(uk)ig felfüggesztésre került';
$strings['Approve'] = 'Jóváhagyás';
$strings['Approve this reservation'] = 'A vizsgálat jóváhagyása';
$strings['Approve Reservations'] ='Vizsgálat(ok) jóváhagyása';

$strings['Announcement'] = 'Bejelentés';
$strings['Number'] = 'Szám';
$strings['Add Announcement'] = 'Bejelentés Hozzáadása';
$strings['Edit Announcement'] = 'Bejelentés Szerkesztése';
$strings['All Announcements'] = 'Minden Bejelentés';
$strings['Delete Announcements'] = 'Bejelentés Törlése';
$strings['Use start date/time?'] = 'Használjon kezdõ dátumot/idõpontot?';
$strings['Use end date/time?'] = 'Használjon befejezõ dátumot/idõpontot?';
$strings['Announcement text is required.'] = 'A Bejelentés szövegének megadása kötelezõ.';
$strings['Announcement number is required.'] = 'A Bejelentés számának megadása kötelezõ.';

$strings['Pending Approval'] = 'A Jóváhagyás függõben van';
$strings['My reservation is approved'] = 'A vizsgálata jóváhagyásra került';
$strings['This reservation must be approved by the administrator.'] = 'A vizsgálatot az Adminisztrátornak jóvá kell hagynia.';
$strings['Approval Required'] = 'Jóváhagyás Szükséges';
$strings['No reservations requiring approval'] = 'Nincsen olyan vizsgálat, amely jóváhagyásra vár';
$strings['Your reservation was successfully approved'] = 'A vizsgálatát sikeresen jóváhagyták';
$strings['Reservation approved for'] = 'A vizsgálat jóváhagyásra került a következõ számára: %s';
$strings['approved'] = 'Jóváhagyva';
$strings['Reservation approved'] = 'Vizsgálat jóváhagyva.';

$strings['Valid username is required'] = 'Érvényes Felhasználó Név szükséges';
$strings['That logon name is taken already.'] = 'A Felhasználó Név már foglalt.';
$strings['this will be your login'] = '(ez lesz a Felhasználó Neve)';
$strings['Logon name'] = 'Felhasználó Név';
$strings['Your logon name is'] = 'Az Ön Felhasználó Neve %s';

$strings['Start'] = 'Kezdés';
$strings['End'] = 'Befejezés';
$strings['Start date must be less than or equal to end date'] = 'A Kezdõ idõpontnak korábbinak kell lennie a Befejezõ idõpontnál';
$strings['That starting date has already passed'] = 'A Kezdõ idõpont már elmúlt';
$strings['Basic'] = 'Alap';
$strings['Participants'] = 'Résztvevõk';
$strings['Close'] = 'Bezárás';
$strings['Start Date'] = 'Kezdõ dátum';
$strings['End Date'] = 'Befejezõ dátum';
$strings['Minimum'] = 'Minimum';
$strings['Maximum'] = 'Maximum';
$strings['Allow Multiple Day Reservations'] = 'Többnapos Vizsgálatok enegedélyezése';
$strings['Invited Users'] = 'Meghívott Felhasználók';
$strings['Invite Users'] = 'Felhasználó(k) Meghívása';
$strings['Remove Participants'] = 'Résztvevõ(k) Eltávolítása';
$strings['Reservation Invitation'] = 'Meghívásos Vizsgálat';
$strings['Manage Invites'] = 'Meghívások kezelése';
$strings['No invite was selected'] = 'Nem jelölt ki Meghívást';
$strings['reservation accepted'] = '%s elfogadta a Meghívását a következõre: %s';
$strings['reservation declined'] = '%s visszautasította a Meghívását a következõre: %s';
$strings['Login to manage all of your invitiations'] = 'Lépjen be a Rendszerbe Meghívásai kezeléséhez';
$strings['Reservation Participation Change'] = 'Részvétel Megváltoztatása';
$strings['My Invitations'] = 'Meghívások';
$strings['Accept'] = 'Elfogadás';
$strings['Decline'] = 'Visszautasítás';
$strings['Accept or decline this reservation'] = 'Fogadja el, vagy utasítsa vissza a Meghívást';
$strings['My Reservation Participation'] = 'Részvételek';
$strings['End Participation'] = 'Részvétel Vége';
$strings['Owner'] = 'Tulajdonos';
$strings['Particpating Users'] = 'Résztvevõ Felhasználók';
$strings['No advanced options available'] = 'Nincs elérhetõ további opció';
$strings['Confirm reservation participation'] = 'Vizsgálati elõjegyzésben való részvétel megerõsítése';
$strings['Confirm'] = 'Megerõsítés';
$strings['Do for all reservations in the group?'] = 'Alkalmazza a csoportban szereplõ összes vizsgálatra?';

$strings['My Calendar'] = 'Saját Naptár';
$strings['View My Calendar'] = 'Saját Naptár Megtekintése';
$strings['Participant'] = 'Résztvevõ(k)';
$strings['Recurring'] = 'Ismétlõdõ';
$strings['Multiple Day'] = 'Többnapos';
$strings['[today]'] = '[ma]';
$strings['Day View'] = 'Napi Bontás';
$strings['Week View'] = 'Heti Bontás';
$strings['Month View'] = 'Havi Bontás';
$strings['Resource Calendar'] = 'Kontingens Naptár';
$strings['View Resource Calendar'] = 'Kontingens Naptár Megtekintése';
$strings['Signup View'] = 'Lista Nézet';

$strings['Select User'] = 'Felhasználó Kiválasztása';
$strings['Change'] = 'Módosítás';

$strings['Update'] = 'Frissítés';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'phpScheduleIt Korszerûsítés csak 1.0.0 vagy késõbbi változathoz elérhetõ';
$strings['phpScheduleIt is already up to date'] = 'A phpScheduleIt naprakész állapotban van';
$strings['Migrating reservations'] = 'Vizsgálatok Átvétele';

$strings['Admin'] = 'Adminisztrátor';
$strings['Manage Announcements'] = 'Bejelentés Kezelés';
$strings['There are no announcements'] = 'Nincs érvényes Bejelentés';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = 'Résztvevõk Maximális Száma';
$strings['Leave blank for unlimited'] = 'Hagyja szabadon korlátlan számú Résztvevõhöz';
$strings['Maximum of participants'] = 'A vizsgálati elõjegyzésnek maximum %s résztvevõje lehet';
$strings['That reservation is at full capacity.'] = 'A vizsgálati elõjegyzés elérte a maximális résztvevõ számot.';
$strings['Allow registered users to join?'] = 'Engedélyezi regisztrált felhasználók részvételét?';
$strings['Allow non-registered users to join?'] = 'Engedélyezi nem regisztrált felhasználók részvételét?';
$strings['Join'] = 'Csatlakozás';
$strings['My Participation Options'] = 'Részvételi Beállítások';
$strings['Join Reservation'] = 'Csatlakozás a vizsgálati elõjegyzéshez';
$strings['Join All Recurring'] = 'Csatlakozás Minden Ismétlõdõhöz';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = 'Nem csatlakozhat a következõ vizsgálati elõjegyzés(ek)hez a résztvevõk maximális száma miatt.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = 'Már meghivták ehhez a vizsgálati elõjegyzéshez. Kérem kövesse a részvételi utasításokat, melyeket korábban emailben kapott.';
$strings['Additional Tools'] = 'További Eszközök';
$strings['Create User'] = 'Felhasználó Létrehozása';
$strings['Check Availability'] = 'Elérhetõség ellenõrzése';
$strings['Manage Additional Resources'] = 'Kiegészíto Hozzáadása';
$strings['Number Available'] = 'Számú Elérhetõ';
$strings['Unlimited'] = 'Korlátlan';
$strings['Add Additional Resource'] = 'Kiegészítõ Kontingens Hozzáadása';
$strings['Edit Additional Resource'] = 'Kiegészíto Szerkesztése';
$strings['Checking'] = 'Ellenõrzés';
$strings['You did not select anything to delete.'] = 'Nem választott ki semmi törlendõt.';
$strings['Added Resources'] = 'Hozzáadott Kontingensek';
$strings['Additional resource is reserved'] = 'A(z) %s kiegészítõ kontingensbõl egyszerre csak %s érhetõ el';
$strings['All Groups'] = 'Minden Csoport';
$strings['Group Name'] = 'Csoport Név';
$strings['Delete Groups'] = 'Csoport Törlése';
$strings['Manage Groups'] = 'Csoport Kezelés';
$strings['None'] = 'Nincs';
$strings['Group name is required.'] = 'Csoport nevének megadása szükségeltetik.';
$strings['Groups'] = 'Csoportok';
$strings['Current Groups'] = 'Aktuális Csoportok';
$strings['Group Administration'] = 'Csoport Karbantartás';
$strings['Reminder Subject'] = 'Vizsgálati elõjegyzés emlékeztetõ - %s, %s %s';
$strings['Reminder'] = 'Emlékeztetõ';
$strings['before reservation'] = 'elõjegyzett vizsgálat elõtt';
$strings['My Participation'] = 'Részvétel';
$strings['My Past Participation'] = 'Korábbi Részvétel';
$strings['Timezone'] = 'Idõzóna';
$strings['Export'] = 'Exportálás';
$strings['Select reservations to export'] = 'Válassza ki az exportálni kívánt vizsgálatot';
$strings['Export Format'] = 'Export formátum';
$strings['This resource cannot be reserved more than x hours in advance'] = 'Ebbe a kontingensbe nem jegyezhet elõ %s órával korábban';
$strings['Minimum Booking Notice'] = 'Minimum Booking Notice';
$strings['Maximum Booking Notice'] = 'Maximum Booking Notice';
$strings['hours prior to the start time'] = 'órányira a kezdõ idõpontig';
$strings['hours from the current time'] = 'órányira mostantól';
$strings['Contains'] = 'Tartalmazza';
$strings['Begins with'] = 'Kezdõdik';
$strings['Minimum booking notice is required.'] = 'Minimum elõjegyzési figyelmeztetés szükséges.';
$strings['Maximum booking notice is required.'] = 'Maximum elõjegyzési figyelmeztetés szükséges.';
$strings['Accessory Name'] = 'Kiegészíto Neve';
$strings['Accessories'] = 'Kiegészítok';
$strings['All Accessories'] = 'Összes Kiegészíto';
$strings['Added Accessories'] = 'Hozzáadott Kiegészíto(k)';
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
				. "Sikeresen regisztrált a következõ információkkal:\r\n"
				. "Felhasználó név: %s\r\n"
				. "Név: %s %s \r\n"
				. "Telefon: %s \r\n"
				. "Intézmény: %s \r\n"
				. "Beosztás: %s \r\n\r\n"
				. "Kérem jelentkezzen be a Rendszerbe a következõ helyen:\r\n"
				. "%s \r\n\r\n"
				. "Az Online Elõjegyzéshez és a Profil Szerkesztéséhez vezetõ linket az Irányító Pulton talál.\r\n\r\n"
				. "Kontingessel és elõjegyzéssel kapcsolatos kérdéseivel forduljon a következõhöz: %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "AdminisztrÃ¡tor,\r\n\r\n"
					. "Egy Új Felhasználó regisztrált és az alábbi információkat adta meg:\r\n"
					. "Email cím: %s \r\n"
					. "Név: %s %s \r\n"
					. "Telefon: %s \r\n"
					. "Intézmény: %s \r\n"
					. "Beosztás: %s \r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "Ön sikeresen %s a(z) #%s számú elõjeygzést.\r\n\r\n<br/><br/>"
			. "Kérem hivatkozzon a megadott számra, ha kapcsolatba kíván lépni az Adminsztrátorral.\r\n\r\n<br/><br/>"
			. "A %s %s és %s %s közötti %s elõjegyzés, amely"
			. " a következõ helyen található: %s, %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "A Vizsgálat a következö napokon fog ismétlõdni:\r\n<br/>";
$email['reservation_activity_3'] = "A csoportban elõforduló összes ismétlõdõ Vizsgálat szintén %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "A következõ Összegzést adták meg a Vizsgálat elõjegyzésekor:\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "Amennyiben ez egy tévedés, kérem értesítse az Adminisztrátort: %s"
			. " vagy telefonáljon a következõ számra: %s.\r\n\r\n<br/><br/>"
			. "Az elõjegyzett Vizsgálat részleteit bármikor megnézheti vagy módosíthatja, ha"
			. " Bejelentkezik %s Rendszerbe a következõ helyen:\r\n<br/>"
			. "<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "A technikai jellegû kérdésekkel forduljon a következõhöz: <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
			. "#%s számú Elõjegyzés Elfogadásra került.\r\n\r\n<br/><br/>"
			. "Kérem hivatkozzon a megadott számra, ha kapcsolatba kíván lépni az Adminsztrátorral.\r\n\r\n<br/><br/>"
			. "A %s %s és %s %s közötti %s elõjegyzés, amely"
			. " a következõ helyen található: %s, %s.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "Az Ön %s Jelszavát az Adminisztrátor Visszaállította.\r\n\r\n"
			. "Az Ön ideiglenes jelszava:\r\n\r\n %s\r\n\r\n"
			. "Kérem használja ezt (másolja és illessze be, hogy biztosan helyes legyen) a Belépéshez %s a következõ helyen: %s"
			. " és változtassa meg nyomban a Vezérlõ Pult 'Profil Szerkesztése/Jelszó Megváltoztatása' menüpontjában.\r\n\r\n"
			. "Kérdéseivel kérem keresse meg a következõt: %s.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n"
            . "Az Ön Új Jelszava az %s Eléréséhez a következõ:\r\n\r\n"
            . "%s\r\n\r\n"
            . "Kérem jelentkezzen be a következõ helyen: %s"
            . "és használja az Újdonsült Jelszavát "
            . "(másolja és illessze be, hogy biztosan hibátlanul kerüljön bevitelre) "
            . "majd a jelszó azonnali megváltoztatásához keresse fel a "
            . "Profil Szerkesztése/Jelszó Megváltoztatása menüpontot "
            . "a Vezérlõ Pultban.\r\n\r\n"
            . "Kérdéseivel forduljon a következõhöz: %s.";

// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s Meghívta Önt Résztvevõnek a következõ Elõjegyzésbe:\r\n\r\n"
		. "Kontingens: %s\r\n"
		. "Kezdõ Dátum: %s\r\n"
		. "Kezdõ Idõpont: %s\r\n"
		. "Befejezõ Dátum: %s\r\n"
		. "Befejezõ Idõpont: %s\r\n"
		. "Összegzés: %s\r\n"
		. "Ismételt Elõfordulás (amennyiben érvényes): %s\r\n\r\n"
		. "A Meghívás Elfogadásához kattintson a következõ linkre (másolja és illessze be, ha nem mûködik) %s\r\n"
		. "A Meghívás Visszautasításához kövesse a következõ linket (másolja és illesze be, ha nem mûködik) %s\r\n"
		. "További mûveletekhez jelentkezzen be a %s Rendszerbe a következõ címen: %s";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "Az Ön következõ Elõjegyzése eltávolításra került a Rendszerbõl:\r\n\r\n"
		. "Kontingens: %s\r\n"
		. "Kezdõ Dátum: %s\r\n"
		. "Kezdõ Idõpont: %s\r\n"
		. "Befejezõ Dátum: %s\r\n"
		. "Befejezõ Idõpont: %s\r\n"
		. "Összegzés: %s\r\n"
		. "Ismételt Elõfordulás (amennyiben érvényes): %s\r\n\r\n";

// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "A következõ vizsgálati elõjegyzés ideje közeleg: %s, %s %s - %s %s.";
?>