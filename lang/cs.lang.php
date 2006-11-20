<?php
/**
* Czech (cs) translation file.
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator <jindrich@natur.cuni.cz>
* @version 05-13-06
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
$days_full = array('Nedìle', 'Pondìlí', 'Úterý', 'Støeda', 'Ètvrtek', 'Pátek', 'Sobota');
// The three letter abbreviation
$days_abbr = array('Ned', 'Pon', 'Úte', 'Stø', 'Ètv', 'Pát', 'Sob');
// The two letter abbreviation
$days_two  = array('Ne', 'Po', 'Út', 'St', 'Èt', 'Pá', 'So');
// The one letter abbreviation
$days_letter = array('n', 'P', 'U', 'S', 'È', 'p', 's');

/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('Leden', 'Únor', 'Bøezen', 'Duben', 'Kvìten', 'Èerven', 'Èervenec', 'Srpen', 'Záøí', 'Øíjen', 'Listopad', 'Prosinec');
// The three letter month name
$months_abbr = array('Led', 'Úno', 'Bøe', 'Dub', 'Kvì', 'Èen', 'Èec', 'Srp', 'Záø', 'Øíj', 'Lis', 'Pro');

// All letters of the alphabet starting with A and ending with Z
$letters = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

/***
  DATE FORMATTING
  All of the date formatting must use the PHP strftime() syntax
  You can include any text/HTML formatting in the translation
***/
// General date formatting used for all date display unless otherwise noted
$dates['general_date'] = '%d/%m/%Y';
// General datetime formatting used for all datetime display unless otherwise noted
// The hour:minute:second will always follow this format
$dates['general_datetime'] = '%d/%m/%Y @';
// Date in the reservation notification popup and email
$dates['res_check'] = '%A %d/%m/%Y';
// Date on the scheduler that appears above the resource links
$dates['schedule_daily'] = '%A,<br/>%d/%m/%Y';
// Date on top-right of each page
$dates['header'] = '%A, %B %d, %Y';
// Jump box format on bottom of the schedule page
// This must only include %m %d %Y in the proper order,
//  other specifiers will be ignored and will corrupt the jump box 
$dates['jumpbox'] = '%d %m %Y';

/***
  STRING TRANSLATIONS
  All of these strings should be translated from the English value (right side of the equals sign) to the new language.
  - Please keep the keys (between the [] brackets) as they are.  The keys will not always be the same as the value.
  - Please keep the sprintf formatting (%s) placeholders where they are unless you are sure it needs to be moved.
  - Please keep the HTML and punctuation as-is unless you know that you want to change it.
***/
$strings['hours'] = 'hodiny';
$strings['minutes'] = 'minuty';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = 'mm';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = 'dd';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = 'rrrr';
$strings['am'] = 'am';
$strings['pm'] = 'pm';

$strings['Administrator'] = 'Administrator';
$strings['Welcome Back'] = 'Vítejte zpìt, %s';
$strings['Log Out'] = 'Odhlásit se';
$strings['My Control Panel'] = 'Mùj Øídící Panel';
$strings['Help'] = 'Nápovìda';
$strings['Manage Schedules'] = 'Správa rozvrhù';
$strings['Manage Users'] ='Správa u¾ivatelù';
$strings['Manage Resources'] ='Správa zdrojù';
$strings['Manage User Training'] ='Správa ¹kolení u¾ivatelù';
$strings['Manage Reservations'] ='Správa rezervací';
$strings['Email Users'] ='Email u¾ivatelùm';
$strings['Export Database Data'] = 'Export dat z databáze';
$strings['Reset Password'] = 'Reset hesla';
$strings['System Administration'] = 'Administrace systému';
$strings['Successful update'] = 'Úspì¹ná aktualizace';
$strings['Update failed!'] = 'Aktualizace selhala!';
$strings['Manage Blackout Times'] = 'Správa èasù výpadkù';
$strings['Forgot Password'] = 'Heslo zapomenuto';
$strings['Manage My Email Contacts'] = 'Správa mých email kontaktù';
$strings['Choose Date'] = 'Vyberte datum';
$strings['Modify My Profile'] = 'Zmìnit mùj profil';
$strings['Register'] = 'Registrovat';
$strings['Processing Blackout'] = 'Zpracovávání výpadkù';
$strings['Processing Reservation'] = 'Zpracovávání rezervací';
$strings['Online Scheduler [Read-only Mode]'] = 'Online Plánovaè[jen ke ètení]';
$strings['Online Scheduler'] = 'Online Plánovaè';
$strings['phpScheduleIt Statistics'] = 'Statistika rezervací';
$strings['User Info'] = 'Informace o u¾ivateli:';

$strings['Could not determine tool'] = 'Nebylo mo¾né urèit nástroj. Vra»te se prosím na vá¹ øídící panel a zkuste znovu pozdìji.';
$strings['This is only accessable to the administrator'] = 'Toto je pøístupné pouze pro administrátora';
$strings['Back to My Control Panel'] = 'Zpìt na Mùj øídící panel';
$strings['That schedule is not available.'] = 'Tento rozvrh není pøístupný.';
$strings['You did not select any schedules to delete.'] = 'Nevybral jste ¾ádný rozvrh k odstranìní.';
$strings['You did not select any members to delete.'] = 'Nevybral jste ¾ádné u¾ivatele k odstranìní.';
$strings['You did not select any resources to delete.'] = 'Nevybral jste ¾ádné zdroje k odstranìní.';
$strings['Schedule title is required.'] = 'Název rozvrhu je vy¾adován.';
$strings['Invalid start/end times'] = 'Neplatný èasy zaèátku/konce';
$strings['View days is required'] = 'View days je vy¾adován';
$strings['Day offset is required'] = 'Day offset je vy¾adován';
$strings['Admin email is required'] = 'Email administrátora je vy¾adován';
$strings['Resource name is required.'] = 'Název zdroje je vy¾adován.';
$strings['Valid schedule must be selected'] = 'Musí být vybrán platný rozvrh.';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'Minimální délka rezervace musí být stejná nebo men¹í ne¾ maximální.';
$strings['Your request was processed successfully.'] = 'Vá¹ po¾adavek byl úspì¹nì zpracován.';
$strings['Go back to system administration'] = 'Jdìte zpìt na administraci systému';
$strings['Or wait to be automatically redirected there.'] = 'Nebo poèkejte dokud tam nebudete automaticky pøesmìrováni.';
$strings['There were problems processing your request.'] = 'Pøi zpracování va¹eho po¾adavku se vyskytly problémy.';
$strings['Please go back and correct any errors.'] = 'Prosím vra»te se a opravte chyby.';
$strings['Login to view details and place reservations'] = 'Zalogujte se k prohlí¾ení podrobností a zadávání rezervací';
$strings['Memberid is not available.'] = 'Memberid: %s není dostupný.';

$strings['Schedule Title'] = 'Název rozvrhu';
$strings['Start Time'] = 'Poèáteèní èas';
$strings['End Time'] = 'Koncový èas';
$strings['Time Span'] = 'Èasové rozpìtí';
$strings['Weekday Start'] = 'Poèátek týdne';
$strings['Admin Email'] = 'Email administrátora';

$strings['Default'] = 'Výchozí';
$strings['Reset'] = 'Reset';
$strings['Edit'] = 'Upravit';
$strings['Delete'] = 'Odstranit';
$strings['Cancel'] = 'Zru¹it';
$strings['View'] = 'Zobrazit';
$strings['Modify'] = 'Zmìnit';
$strings['Save'] = 'Ulo¾it';
$strings['Back'] = 'Zpìt';
$strings['Next'] = 'Dal¹í';
$strings['Close Window'] = 'Zavøít okno';
$strings['Search'] = 'Hledat';
$strings['Clear'] = 'Vymazat';

$strings['Days to Show'] = 'Ukázat dny';
$strings['Reservation Offset'] = 'Offset rezervace';
$strings['Hidden'] = 'Skryt';
$strings['Show Summary'] = 'Ukázat souhrn';
$strings['Add Schedule'] = 'Pøidat rozvrh';
$strings['Edit Schedule'] = 'Upravit rozvrh';
$strings['No'] = 'Ne';
$strings['Yes'] = 'Ano';
$strings['Name'] = 'Jméno';
$strings['First Name'] = 'Køestní jméno';
$strings['Last Name'] = 'Pøíjmení';
$strings['Resource Name'] = 'Název zdroje';
$strings['Email'] = 'Email';
$strings['Institution'] = 'Instituce';
$strings['Phone'] = 'Telefon';
$strings['Password'] = 'Heslo';
$strings['Permissions'] = 'Oprávnìní';
$strings['View information about'] = 'Zobrazit informaci pro: %s %s';
$strings['Send email to'] = 'Poslat email komu: %s %s';
$strings['Reset password for'] = 'Reset hesla pro:  %s %s';
$strings['Edit permissions for'] = 'Upravit oprávnìní pro: %s %s';
$strings['Position'] = 'Pozice';
$strings['Password (6 char min)'] = 'Heslo (%s znakù minimálnì)';	// @since 1.1.0
$strings['Re-Enter Password'] = 'Znovu vlo¾it heslo';

$strings['Sort by descending last name'] = 'Setøídit sestupnì podle pøíjmení';
$strings['Sort by descending email address'] = 'Setøídit sestupnì podle emailu';
$strings['Sort by descending institution'] = 'Setøídit sestupnì podle instituce';
$strings['Sort by ascending last name'] = 'Setøídit vzestupnì podle pøíjmení';
$strings['Sort by ascending email address'] = 'Setøídit vzestupnì podle emailu';
$strings['Sort by ascending institution'] = 'Setøídit vzestupnì podle instituce';
$strings['Sort by descending resource name'] = 'Setøídit sestupnì podle názvu zdroje';
$strings['Sort by descending location'] = 'Setøídit sestupnì podle umístìní';
$strings['Sort by descending schedule title'] = 'Setøídit sestupnì podle názvu rozvrhu';
$strings['Sort by ascending resource name'] = 'Setøídit vzestupnì podle názvu zdroje';
$strings['Sort by ascending location'] = 'Setøídit vzestupnì podle umístìní';
$strings['Sort by ascending schedule title'] = 'Setøídit vzestupnì podle názvu rozvrhu';
$strings['Sort by descending date'] = 'Setøídit sestupnì podle data';
$strings['Sort by descending user name'] = 'Sestøídit sestupnì podle jména u¾ivatele';
$strings['Sort by descending start time'] = 'Setøídit sestupnì podle poèáteèního èasu';
$strings['Sort by descending end time'] = 'Setøídit sestupnì podle koncového èasu';
$strings['Sort by ascending date'] = 'Setøídit vzestupnì podle data';
$strings['Sort by ascending user name'] = 'Setøídit vzestupnì podle jména u¾ivatele';
$strings['Sort by ascending start time'] = 'Setøídit vzestupnì podle poèáteèního èasu';
$strings['Sort by ascending end time'] = 'Setøídit vzestupnì podle koncového èasu';
$strings['Sort by descending created time'] = 'Setøídit sestupnì podle èasu vytvoøení';
$strings['Sort by ascending created time'] = 'Setøídit vzestupnì podle èasu vytvoøení';
$strings['Sort by descending last modified time'] = 'Setøídit sestupnì podle èasu poslední zmìny';
$strings['Sort by ascending last modified time'] = 'Setøídit vzestupnì podle èasu poslední zmìny';

$strings['Search Users'] = 'Vyhledat u¾ivatele';
$strings['Location'] = 'Umístìní';
$strings['Schedule'] = 'Rozvrh';
$strings['Phone'] = 'Telefon';
$strings['Notes'] = 'Poznámky';
$strings['Status'] = 'Stav';
$strings['All Schedules'] = 'V¹echny rozvrhy';
$strings['All Resources'] = 'V¹echny zdroje';
$strings['All Users'] = 'V¹ichni u¾ivatelé';

$strings['Edit data for'] = 'Upravit data pro: %s';
$strings['Active'] = 'Aktivní';
$strings['Inactive'] = 'Neaktivní';
$strings['Toggle this resource active/inactive'] = 'Pøepnìte tento zdroj - aktivní/neaktivní';
$strings['Minimum Reservation Time'] = 'Minimální doba rezervace';
$strings['Maximum Reservation Time'] = 'Maximální doba rezervace';
$strings['Auto-assign permission'] = 'Automatické pøiøazení oprávnìní';
$strings['Add Resource'] = 'Pøidat zdroj';
$strings['Edit Resource'] = 'Upravit zdroj';
$strings['Allowed'] = 'Povolen';
$strings['Notify user'] = 'Uvìdomit u¾ivatele';
$strings['User Reservations'] = 'Reservace u¾ivatele';
$strings['Date'] = 'Datum';
$strings['User'] = 'U¾ivatel';
$strings['Email Users'] = 'Email u¾ivatelùm';
$strings['Subject'] = 'Subjekt';
$strings['Message'] = 'Zpráva';
$strings['Please select users'] = 'Prosím vyberte u¾ivatele';
$strings['Send Email'] = 'Poslat email';
$strings['problem sending email'] = 'Promiòte, nepodaøilo se odeslat vá¹ email. Zkuste to prosím pozdìji.';
$strings['The email sent successfully.'] = 'Email byl úspì¹nì odeslán.';
$strings['do not refresh page'] = 'Prosím <u>neobnovujte</u> tuto stránku. Email by byl poslán znovu.';
$strings['Return to email management'] = 'Zpìt ke správì emailu';
$strings['Please select which tables and fields to export'] = 'Prosím vyberte tabulky a pole k exportu:';
$strings['all fields'] = '- v¹echna pole -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = 'Prostý text';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = 'Export Dat';
$strings['Reset Password for'] = 'Reset hesla pro: %s';
$strings['Please edit your profile'] = 'Prosím, upravte vá¹ profil';
$strings['Please register'] = 'Prosím, registrujte se';
$strings['Keep me logged in'] = 'Udr¾ujte mì pøihlá¹eného<br/>(vy¾aduje cookies)';
$strings['Edit Profile'] = 'Upravit profil';
$strings['Register'] = 'Registrace';
$strings['Please Log In'] = 'Prosím, pøihla¹te se';
$strings['Email address'] = 'Emailová adresa';
$strings['Password'] = 'Heslo';
$strings['First time user'] = 'Prvnì pøipojen?';
$strings['Click here to register'] = 'Kliknìte zde pro registraci';
$strings['Register for phpScheduleIt'] = 'Registrace pro rezervace';
$strings['Log In'] = 'Pøihlá¹ení';
$strings['View Schedule'] = 'Zobrazit rozvrh';
$strings['View a read-only version of the schedule'] = 'Verze rozvrhu pouze ke ètení';
$strings['I Forgot My Password'] = 'Zapomnìl jsem své heslo';
$strings['Retreive lost password'] = 'Získání ztraceného hesla';
$strings['Get online help'] = 'Online nápovìda';
$strings['Language'] = 'Jazyk';
$strings['(Default)'] = '(Výchozí)';

$strings['My Announcements'] = 'Moje oznámení';
$strings['My Reservations'] = 'Moje rezervace';
$strings['My Permissions'] = 'Moje oprávnìní';
$strings['My Quick Links'] = 'Moje rychlé odkazy';
$strings['Announcements as of'] = 'Oznámení: %s';
$strings['There are no announcements.'] = '®ádná oznámení.';
$strings['Resource'] = 'Zdroj';
$strings['Created'] = 'Vytvoøeno';
$strings['Last Modified'] = 'Poslední zmìna';
$strings['View this reservation'] = 'Zobraz tuto rezervaci';
$strings['Modify this reservation'] = 'Zmìò tuto rezervaci';
$strings['Delete this reservation'] = 'Odstranit tuto rezervaci';
$strings['Bookings'] = 'Pøehled rezervací';											// @since 1.2.0
$strings['Change My Profile Information/Password'] = 'Zmìnit profil';		// @since 1.2.0
$strings['Manage My Email Preferences'] = 'Nastavení emailu';				// @since 1.2.0
$strings['Mass Email Users'] = 'Hromadný email u¾ivatelùm';
$strings['Search Scheduled Resource Usage'] = 'Hledat rezervace';		// @since 1.2.0
$strings['Export Database Content'] = 'Export obsahu databáze';
$strings['View System Stats'] = 'Zobrazit statistiku systému';
$strings['Email Administrator'] = 'Email administrátorovi';

$strings['Email me when'] = 'Po¹li mi email, kdy¾:';
$strings['I place a reservation'] = 'Zadám rezervaci';
$strings['My reservation is modified'] = 'Moje rezervace je zmìnìna';
$strings['My reservation is deleted'] = 'Moje rezervace je odstranìna';
$strings['I prefer'] = 'Upøednostòuji:';
$strings['Your email preferences were successfully saved'] = 'Va¹e emailová nastavení byla úspì¹nì ulo¾ena!';
$strings['Return to My Control Panel'] = 'Zpìt na Mùj øídící panel';

$strings['Please select the starting and ending times'] = 'Prosím zvolte poèáteèní a koncové èasy:';
$strings['Please change the starting and ending times'] = 'Prosím zmìòte poèáteèní a koncové èasy:';
$strings['Reserved time'] = 'Reservovaný èas:';
$strings['Minimum Reservation Length'] = 'Délka minimální rezervace:';
$strings['Maximum Reservation Length'] = 'Délka maximální rezervace:';
$strings['Reserved for'] = 'Rezervováno pro:';
$strings['Will be reserved for'] = 'Bude rezervováno pro:';
$strings['N/A'] = 'N/A';
$strings['Update all recurring records in group'] = 'Aktualizovat v¹echny opakující se záznamy ve skupinì?';
$strings['Delete?'] = 'Odstranit?';
$strings['Never'] = '-- Nikdy --';
$strings['Days'] = 'Dny';
$strings['Weeks'] = 'Týdny';
$strings['Months (date)'] = 'Mìsíce (datum)';
$strings['Months (day)'] = 'Mìsíce (den)';
$strings['First Days'] = 'První dny';
$strings['Second Days'] = 'Druhé dny';
$strings['Third Days'] = 'Tøetí dny';
$strings['Fourth Days'] = 'Ètvrté dny';
$strings['Last Days'] = 'Poslední dny';
$strings['Repeat every'] = 'Opakuj ka¾dý:';
$strings['Repeat on'] = 'Opakuj kdy:';
$strings['Repeat until date'] = 'Opakuj do data:';
$strings['Choose Date'] = 'Vyberte datum';
$strings['Summary'] = 'Souhrn';

$strings['View schedule'] = 'Zobrazit rozvrh:';
$strings['My Reservations'] = 'Moje rezervace';
$strings['My Past Reservations'] = 'Moje minulé rezervace';
$strings['Other Reservations'] = 'Dal¹í rezervace';
$strings['Other Past Reservations'] = 'Dal¹í minulé rezervace';
$strings['Blacked Out Time'] = 'Výpadkový èas';
$strings['Set blackout times'] = 'Nastavit výpadkové èasy pro %s na %s'; 
$strings['Reserve on'] = 'Rezervovat %s na %s';
$strings['Prev Week'] = '&laquo; Pøedchozí týden';
$strings['Jump 1 week back'] = 'Skoèit 1 týden zpìt';
$strings['Prev days'] = '&#8249; Pøedch. %d dny';
$strings['Previous days'] = '&#8249; Pøedchozí %d dny';
$strings['This Week'] = 'Tento týden';
$strings['Jump to this week'] = 'Skoèit do tohoto týdne';
$strings['Next days'] = 'Dal¹ích %d dní &#8250;';
$strings['Next Week'] = 'Dal¹í týden &raquo;';
$strings['Jump To Date'] = 'Skoèit na datum';
$strings['View Monthly Calendar'] = 'Zobrazit mìsíèní kalendáø';
$strings['Open up a navigational calendar'] = 'Otevøít navigaèní kalendáø';

$strings['View stats for schedule'] = 'Zobrazit statistiku pro rozvrh:';
$strings['At A Glance'] = 'Zbì¾nì';
$strings['Total Users'] = 'Celkovì u¾ivatelé:';
$strings['Total Resources'] = 'Celkovì zdroje:';
$strings['Total Reservations'] = 'Celkovì rezervace:';
$strings['Max Reservation'] = 'Max rezervace:';
$strings['Min Reservation'] = 'Min rezervace:';
$strings['Avg Reservation'] = 'Pøùmìr rezervace:';
$strings['Most Active Resource'] = 'Nejaktivnìj¹í zdroj:';
$strings['Most Active User'] = 'Nejaktivnìj¹í u¾ivatel:';
$strings['System Stats'] = 'Statistika systému';
$strings['phpScheduleIt version'] = 'Verze phpScheduleIt:';
$strings['Database backend'] = 'Pou¾itý databázový systém:';
$strings['Database name'] = 'Název databáze:';
$strings['PHP version'] = 'Verze PHP:';
$strings['Server OS'] = 'OS serveru:';
$strings['Server name'] = 'Název serveru:';
$strings['phpScheduleIt root directory'] = 'Koøenový adresáø systému:';
$strings['Using permissions'] = 'U¾ívána oprávnìní:';
$strings['Using logging'] = 'U¾íváno logování:';
$strings['Log file'] = 'Logovací soubor:';
$strings['Admin email address'] = 'Email administrátora:';
$strings['Tech email address'] = 'Email technické podpory:';
$strings['CC email addresses'] = 'CC emailové adresy:';
$strings['Reservation start time'] = 'Poèáteèní èas rezervace:';
$strings['Reservation end time'] = 'Koncový èas rezervace:';
$strings['Days shown at a time'] = 'Poèet najednou zobrazovaných dní:';
$strings['Reservations'] = 'Rezervace';
$strings['Return to top'] = 'Zpìt na zaèátek';
$strings['for'] = 'pro';

$strings['Select Search Criteria'] = 'Vyberte vyhledávácí kritéria';
$strings['Schedules'] = 'Rozvrhy:';
$strings['All Schedules'] = 'V¹echny rozvrhy';
$strings['Hold CTRL to select multiple'] = 'Dr¾te CTRL k vícenásobnému výbìru';
$strings['Users'] = 'U¾ivatelé:';
$strings['All Users'] = 'V¹ichni u¾ivatelé';
$strings['Resources'] = 'Zdroje';
$strings['All Resources'] = 'V¹echny zdroje';
$strings['Starting Date'] = 'Poèáteèní datum:';
$strings['Ending Date'] = 'Koncové datum:';
$strings['Starting Time'] = 'Poèáteèní èas:';
$strings['Ending Time'] = 'Koncový èas:';
$strings['Output Type'] = 'Typ výstupu:';
$strings['Manage'] = 'Spravovat';
$strings['Total Time'] = 'Cekovì èas';
$strings['Total hours'] = 'Celovì hodin:';
$strings['% of total resource time'] = '% celkového èasu zdroje';
$strings['View these results as'] = 'Zobrazit tyto výsledky jako:';
$strings['Edit this reservation'] = 'Upravit tuto rezervaci';
$strings['Search Results'] = 'Prohledat výsledky';
$strings['Search Resource Usage'] = 'Vyhledat vyu¾ití zdroje';
$strings['Search Results found'] = 'Výsledky vyhledávání: %d rezervací nalezeno';
$strings['Try a different search'] = 'Zkuste jiné vyhledávání';
$strings['Search Run On'] = 'Spustit vyhledávání na:';
$strings['Member ID'] = 'ID u¾ivatele';
$strings['Previous User'] = '&laquo; Pøedchozí u¾ivatel';
$strings['Next User'] = 'Dal¹í u¾ivatel &raquo;';

$strings['No results'] = '®ádné výsledky';
$strings['That record could not be found.'] = 'Tento záznam nebyl nalezen.';
$strings['This blackout is not recurring.'] = 'Tento výpadek není opakovaný.';
$strings['This reservation is not recurring.'] = 'Tato rezervace není opakovaná.';
$strings['There are no records in the table.'] = 'V tabulce %s nejsou ¾ádné záznamy.';
$strings['You do not have any reservations scheduled.'] = 'Nemáte naplánovány ¾ádné rezervace.';
$strings['You do not have permission to use any resources.'] = 'Nemáte oprávnìní pou¾ívat jakýkoli zdroj.';
$strings['No resources in the database.'] = 'V databázi nejsou ¾ádné zdroje.';
$strings['There was an error executing your query'] = 'Pøi zpracovávání va¹eho dotazu do¹lo k chybì:';

$strings['That cookie seems to be invalid'] = 'Tento cookie je neplatný';
$strings['We could not find that logon in our database.'] = 'Toto pøihlá¹ení nebylo v na¹í databázi nalezeno.';	// @since 1.1.0
$strings['That password did not match the one in our database.'] = 'Toto heslo se neshodovalo s tím z na¹í databáze.';
$strings['You can try'] = '<br />Mù¾ete zkusit:<br />Registrovat email adresu.<br />Nebo:<br />Zkusit pøihlá¹ení znovu.';
$strings['A new user has been added'] = 'Nový u¾ivatel byl pøidán';
$strings['You have successfully registered'] = 'Byl jste úspì¹nì zaregistrován!';
$strings['Continue'] = 'Pokraèovat...';
$strings['Your profile has been successfully updated!'] = 'Vá¹ profil byl úspì¹nì aktualizován!';
$strings['Please return to My Control Panel'] = 'Prosím vrátit na Mùj øídící panel';
$strings['Valid email address is required.'] = '- je vy¾adována platná emailová adresa.';
$strings['First name is required.'] = '- Køestní jméno je vy¾adováno.';
$strings['Last name is required.'] = '- Pøíjmení je vy¾adováno.';
$strings['Phone number is required.'] = '- Telefonní èíslo je vy¾adováno.';
$strings['That email is taken already.'] = '- Tento email je ji¾ obsazen.<br />Prosím zkuste znovu s rozdílnou emailovou adresou.';
$strings['Min 6 character password is required.'] = '- Je vy¾adováno heslo s nejménì %s znaky.';
$strings['Passwords do not match.'] = '- Hesla se neshodují.';

$strings['Per page'] = 'Na stránku:';
$strings['Page'] = 'Stránka:';

$strings['Your reservation was successfully created'] = 'Va¹e rezervace byla úspì¹nì vytvoøena';
$strings['Your reservation was successfully modified'] = 'Va¹e rezervace byla úspì¹nì zmìnìna';
$strings['Your reservation was successfully deleted'] = 'Va¹e rezervace byla úspì¹nì odstranìna';
$strings['Your blackout was successfully created'] = 'Vá¹ výpadek byl úspì¹nì vytvoøen';
$strings['Your blackout was successfully modified'] = 'Vá¹ výpadek byl úspì¹nì zmìnìn';
$strings['Your blackout was successfully deleted'] = 'Vá¹ výpadek byl úspì¹nì odstranìn';
$strings['for the follwing dates'] = 'pro následující data:';
$strings['Start time must be less than end time'] = 'Poèáteèní èas musí být men¹í ne¾ koncový èas.';
$strings['Current start time is'] = 'Aktuální poèáteèní èas je:';
$strings['Current end time is'] = 'Aktuální koncový èas je:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'Délka rezervace je není v intervalu povolené délky pro tento zdroj.';
$strings['Your reservation is'] = 'Va¹e rezervace je:';
$strings['Minimum reservation length'] = 'Minimální délka rezervace:';
$strings['Maximum reservation length'] = 'Maximální délka rezervace:';
$strings['You do not have permission to use this resource.'] = 'Nemáte oprávnìní k pou¾ití tohoto zdroje.';
$strings['reserved or unavailable'] = '%s a¾ %s je rezervován nebo nepøístupný.';	// @since 1.1.0
$strings['Reservation created for'] = 'Rezervace vytvoøena pro %s';
$strings['Reservation modified for'] = 'Rezervace zmìnìna pro %s';
$strings['Reservation deleted for'] = 'Rezervace odstranìna pro %s';
$strings['created'] = 'vytvoøeno';
$strings['modified'] = 'zmìnìno';
$strings['deleted'] = 'odstranìno';
$strings['Reservation #'] = 'Rezervace #';
$strings['Contact'] = 'Kontakt';
$strings['Reservation created'] = 'Rezervace vytvoøena';
$strings['Reservation modified'] = 'Rezervace zmìnìna';
$strings['Reservation deleted'] = 'Rezervace odstranìna';

$strings['Reservations by month'] = 'Rezervace po mìsících';
$strings['Reservations by day of the week'] = 'Rezervace po dnech v týdnu';
$strings['Reservations per month'] = 'Rezervace po dnech v mìsíci';
$strings['Reservations per user'] = 'Rezervace na u¾ivatele';
$strings['Reservations per resource'] = 'Rezervace na zdroj';
$strings['Reservations per start time'] = 'Rezervace podle poèáteèního èasu';
$strings['Reservations per end time'] = 'Rezervace podle koncového èasu';
$strings['[All Reservations]'] = '[V¹echny rezervace]';

$strings['Permissions Updated'] = 'Oprávnìní aktualizována';
$strings['Your permissions have been updated'] = 'Va¹e %s oprávnìní byla aktualizována';
$strings['You now do not have permission to use any resources.'] = 'Nyní nemáte oprávnìní k pou¾ití ¾ádného zdroje.';
$strings['You now have permission to use the following resources'] = 'Nyní máte oprávnìní k pou¾ití následující zdroje:';
$strings['Please contact with any questions.'] = 'Prosím kontaktujte %s s jakýmkoli dotazem.';
$strings['Password Reset'] = 'Reset hesla';

$strings['This will change your password to a new, randomly generated one.'] = 'Toto zmìní va¹e heslo na nové, náhodnì vygenerované.';
$strings['your new password will be set'] = 'Po vlo¾ení va¹eho emailu a kliknutí na "Zmìnit heslo", nastaví vám systém nastaví nové heslo a za¹le ho emailem.';
$strings['Change Password'] = 'Zmìnit heslo';
$strings['Sorry, we could not find that user in the database.'] = 'Promiòte, nemohli jsme najít tohoto u¾ivatele v databázi.';
$strings['Your New Password'] = 'Va¹e nové %s heslo';
$strings['Your new passsword has been emailed to you.'] = 'Úspìch!<br />'
    			. 'Va¹e nové heslo vám bylo zasláno emailem.<br />'
    			. 'Prosím podívejte se do va¹í emailové schránky na nové heslo, pak se <a href="index.php">pøihla¹te</a>'
    			. ' s tímto novým heslem a urychlenì ho zmìòte kliknutím na odkaz &quot;Zmìnit mùj profil/heslo&quot;'
    			. ' v Mém øídícím panelu.';

$strings['You are not logged in!'] = 'Nejste pøihlá¹en!';

$strings['Setup'] = 'Setup';
$strings['Please log into your database'] = 'Prosím pøihla¹te se do va¹í databáze';
$strings['Enter database root username'] = 'Vlo¾te u¾ivatelské jméno adminitrátora databáze:';
$strings['Enter database root password'] = 'Vlo¾te heslo administrátora databáze:';
$strings['Login to database'] = 'Pøihlá¹ení do databáze';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = 'Administrátorská práva <b>nejsou vy¾adována</b>. Kterýkoli u¾ivatel databáze s právem vytváøet tabulky postaèuje.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = 'Toto nastaví nezbytné databáze a tabulky pro phpScheduleIt.';
$strings['It also populates any required tables.'] = 'Vypní rovnì¾ potøebné tabulky.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = 'Varování: TOTO ODSTRANÍ V©ECHNA DATA V PØEDCHOZÍCH DATABÁZÍCH phpScheduleIt!';
$strings['Not a valid database type in the config.php file.'] = 'Neplatný typ databáze v souboru config.php.';
$strings['Database user password is not set in the config.php file.'] = 'Heslo pro u¾ivatele databáze není nastaveno v souboru config.php.';
$strings['Database name not set in the config.php file.'] = 'Název databáze není nastaven v souboru config.php.';
$strings['Successfully connected as'] = 'Úspì¹nì pøipojen jako';
$strings['Create tables'] = 'Vytvoøit tabulky &gt;';
$strings['There were errors during the install.'] = 'Bìhem instalace se vyskytly chyby. Je mo¾né, ¾e phpScheduleIt bude it tak fungovat, pokud chyby nebyly záva¾né.<br/><br/>'
	. 'Prostím vzneste jakékoli dotazy v diskuzních fórech na <a href="http://sourceforge.net/forum/?group_id=95547">SourceForge</a>.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = 'Úsìp¹nì jste dokonèili nastavení phpScheduleIt a mù¾ete ho zaèít pou¾ívat.';
$strings['Thank you for using phpScheduleIt'] = 'Prosím zajistìte ÚPLNÉ ODSTRANÌNÍ ADRESÁØE \'install\' .'
	. ' To je velmi dùle¾ité, proto¾e obsahuje hesla do databáze a dal¹í citlivé informace.'
	. ' Pokud to neprovedete, necháte zcela otevøené dveøe komukoli k proniknutí do va¹í databáze!'
	. '<br /><br />'
	. 'Dìkujeme vám, ¾e pou¾íváte phpScheduleIt!';
$strings['There is no way to undo this action'] = 'Tuto akci není ¾ádným zpùsobem mo¾né vrátit zpìt!';
$strings['Click to proceed'] = 'Kliknìte pro pokraèování';
$strings['Please delete this file.'] = 'Prosím odstraòte tento soubor.';
$strings['Successful update'] = 'Aktualizace probìhla naprosto v poøádku';
$strings['Patch completed successfully'] = 'Záplata byla úspì¹nì aplikována';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = 'Pokud není uvedena ¾ádná hodnota, bude pou¾ito heslo uvedené v konfiguraèním souboru.';
$strings['Notify user that password has been changed?'] = 'Uvìdomit u¾ivatele, ¾e bylo heslo zmìnìno?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'Tento systém vy¾aduje, abyste mìli emailovou adresu.';
$strings['Invalid User Name/Password.'] = 'Neplatné u¾ivatelské jméno/heslo.';
$strings['Pending User Reservations'] = 'Nevyøízené u¾ivatelské rezervace';
$strings['Approve'] = 'Schválit';
$strings['Approve this reservation'] = 'Schválit tuto rezervaci';
$strings['Approve Reservations'] ='Schválit rezervace';

$strings['Announcement'] = 'Oznámení';
$strings['Number'] = 'Èíslo';
$strings['Add Announcement'] = 'Pøidat oznámení';
$strings['Edit Announcement'] = 'Upravit oznámení';
$strings['All Announcements'] = 'V¹echna oznámení';
$strings['Delete Announcements'] = 'Odstranit oznámení';
$strings['Use start date/time?'] = 'Pou¾ít poèáteèní datum/èas?';
$strings['Use end date/time?'] = 'Pou¾ít koncové datum/èas?';
$strings['Announcement text is required.'] = 'Text oznámení je vy¾adován.';
$strings['Announcement number is required.'] = 'Èíslo oznámení je vy¾adováno.';

$strings['Pending Approval'] = 'Nevyøízené schválení';
$strings['My reservation is approved'] = 'Moje rezervace je schválena';
$strings['This reservation must be approved by the administrator.'] = 'Tato rezervace musí být schválena administrátorem.';
$strings['Approval Required'] = 'Schválení je vy¾adováno';
$strings['No reservations requiring approval'] = '®ádné rezervace vy¾adující schválení';
$strings['Your reservation was successfully approved'] = 'Va¹e rezervace byla úspì¹nì schválena';
$strings['Reservation approved for'] = 'Rezervace schválena pro %s';
$strings['approved'] = 'schváleno';
$strings['Reservation approved'] = 'Rezervace schválena';

$strings['Valid username is required'] = 'Je vy¾adováno platné u¾ivatelské jméno';
$strings['That logon name is taken already.'] = 'Toto pøihla¹ovací jméno je ji¾ pou¾íváno.';
$strings['this will be your login'] = '(toto bude va¹e pøihla¹ovací jméno)';
$strings['Logon name'] = 'Pøihla¹ovací jméno';
$strings['Your logon name is'] = 'Va¹e pøihla¹ovací jméno je %s';

$strings['Start'] = 'Poèátek';
$strings['End'] = 'Konec';
$strings['Start date must be less than or equal to end date'] = 'Poèáteèní datum musí být men¹í ne¾ nebo rovno koncovému datu';
$strings['That starting date has already passed'] = 'Poèáteèní datum ji¾ ubìhlo';
$strings['Basic'] = 'Základní';
$strings['Participants'] = 'Úèastníci';
$strings['Close'] = 'Zavøít';
$strings['Start Date'] = 'Poèáteèní datum';
$strings['End Date'] = 'Koncové datum';
$strings['Minimum'] = 'Od';
$strings['Maximum'] = 'Do';
$strings['Allow Multiple Day Reservations'] = 'Povolit rezervaci více dní';
$strings['Invited Users'] = 'Pozvaní u¾ivatelé';
$strings['Invite Users'] = 'Pozvat u¾ivatele';
$strings['Remove Participants'] = 'Odstranit úèastníky';
$strings['Reservation Invitation'] = 'Pozvání rezervace';
$strings['Manage Invites'] = 'Správa pozvánek';
$strings['No invite was selected'] = 'Nebyly vybrány ¾ádné pozvánky';
$strings['reservation accepted'] = '%s Va¹e pozvání na %s pøijato';
$strings['reservation declined'] = '%s Va¹o pozvání na %s zamítnuto';
$strings['Login to manage all of your invitiations'] = 'Pøihla¹te se ke správì v¹ech Va¹ich pozvání';
$strings['Reservation Participation Change'] = 'Zmìna úèasti na rezervaci';
$strings['My Invitations'] = 'Moje pozvání';
$strings['Accept'] = 'Pøijmout';
$strings['Decline'] = 'Zamítnout';
$strings['Accept or decline this reservation'] = 'Pøijmout nebo zamítnout tuto rezervaci';
$strings['My Reservation Participation'] = 'Moje úèast na rezervaci';
$strings['End Participation'] = 'Konec úèasti';
$strings['Owner'] = 'Vlastník';
$strings['Particpating Users'] = 'Úèastnící se u¾ivatelé';
$strings['No advanced options available'] = '®ádné pokroèilé volby nejsou pøístupné';
$strings['Confirm reservation participation'] = 'Potvrïte úèast na rezervaci';
$strings['Confirm'] = 'Potvrdit';
$strings['Do for all reservations in the group?'] = 'Provést pro v¹echny rezervace ve skupinì?';

$strings['My Calendar'] = 'Mùj kalendáø';
$strings['View My Calendar'] = 'Zobrazi Mùj kalendáø';
$strings['Participant'] = 'Úèastník';
$strings['Recurring'] = 'Opakující se';
$strings['Multiple Day'] = 'Více dní';
$strings['[today]'] = '[dnes]';
$strings['Day View'] = 'Zobrazení dne';
$strings['Week View'] = 'Zobrazení týdne';
$strings['Month View'] = 'Zobrazení mìsíce';
$strings['Resource Calendar'] = 'Kalendáø zdrojù';
$strings['View Resource Calendar'] = 'Kalendáø rozvrhù';	// @since 1.2.0
$strings['Signup View'] = 'Zobrazení registrace';

$strings['Select User'] = 'Vybrat u¾ivatele';
$strings['Change'] = 'Zmìnit';

$strings['Update'] = 'Aktualizovat';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'Aktualizace phpScheduleIt je dostupná pouze pro verze 1.0.0 a pozdìj¹í';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt je ji¾ aktualizován';
$strings['Migrating reservations'] = 'Migrující rezervace';

$strings['Admin'] = 'Admin';
$strings['Manage Announcements'] = 'Správa oznámení';
$strings['There are no announcements'] = 'Nejsou ¾ádná oznámení';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = 'Maximální kapacita úèastníkù';
$strings['Leave blank for unlimited'] = 'Nechte prázdné pro bez omezení';
$strings['Maximum of participants'] = 'Tento zdroj má maximální kapacitu %s uèastníkù';
$strings['That reservation is at full capacity.'] = 'Tato rezervace je zcela zaplnìna.';
$strings['Allow registered users to join?'] = 'Umo¾nit pøipojit se registrovným u¾ivatelùm?';
$strings['Allow non-registered users to join?'] = 'Umo¾nit pøipojit se neregistrovaným u¾ivatelùm?';
$strings['Join'] = 'Pøipojit se';
$strings['My Participation Options'] = 'Mé úèastnícké nastavení';
$strings['Join Reservation'] = 'Pøipojit se k rezervacím';
$strings['Join All Recurring'] = 'Pøipojit se ke v¹em opakovaným';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = 'Neúèastníte se následujících rezervací, proto¾e mají zaplnìnou kapacitu.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = 'K této rezervaci jste ji¾ byl pozván. Prosím dr¾te se instrukcí pro uèastníky zaslané emailem.';
$strings['Additional Tools'] = 'Dal¹í nástroje';
$strings['Create User'] = 'Vytvoøit u¾ivatele';
$strings['Check Availability'] = 'Zjisti dostupnost';
$strings['Manage Additional Resources'] = 'Nasatevní dodateèných zdrojù';
$strings['All Additional Resources'] = 'V¹echny dodateèné zdroje';
$strings['Number Available'] = 'Poèet dostupných';
$strings['Unlimited'] = 'Neomezený';
$strings['Add Additional Resource'] = 'Pøidat dodateèný zdroj';
$strings['Edit Additional Resource'] = 'Upravit dodateèný zdroj';
$strings['Checking'] = 'Checking';
$strings['You did not select anything to delete.'] = 'Nebylo nic vybráno ke smazání';
$strings['Added Resources'] = 'Pøidané zdroje';
$strings['Additional resource is reserved'] = 'Dodateèný zdroj %s je dostupný pouze v poètu %s';
$strings['All Groups'] = 'V¹echny skupiny';
$strings['Group Name'] = 'Název skupiny';
$strings['Delete Groups'] = 'Smazat skupiny';
$strings['Manage Groups'] = 'Správa skupin';
$strings['None'] = '®ádný';
$strings['Group name is required.'] = 'Název skupiny je vy¾adován.';
$strings['Groups'] = 'Skupiny';
$strings['Current Groups'] = 'Aktuální skupiny';
$strings['Group Administration'] = 'Správa skupin';
$strings['Reminder Subject'] = 'Pøipomínka rezervace - %s, %s %s';
$strings['Reminder'] = 'Pøipomínka';
$strings['before reservation'] = 'pøed rezervací';
$strings['My Participation'] = 'Moje úèast';
$strings['My Past Participation'] = 'Moje minulá úèast';
$strings['Timezone'] = 'Èasová zóna';
$strings['Export'] = 'Export';
$strings['Select reservations to export'] = 'Vyberte rezervace pro export';
$strings['Export Format'] = 'Formát pro export';
$strings['This resource cannot be reserved less than x hours in advance'] = 'Tento zdroj nemù¾e být rezervován ménì ne¾ %s hodin pøedem';
$strings['This resource cannot be reserved more than x hours in advance'] = 'Tento zdroj nemù¾e být rezervován více ne¾ %s hodin pøedem';
$strings['Minimum Booking Notice'] = 'Oznámení o zaèátku rezervace';
$strings['Maximum Booking Notice'] = 'Oznámení o konci rezervace';
$strings['hours prior to the start time'] = 'hodin pøed zaèátkem';
$strings['hours from the current time'] = 'hodin od aktuálního èasu';
$strings['Contains'] = 'Obsahuje';
$strings['Begins with'] = 'Zaèíná na';
$strings['Minimum booking notice is required.'] = 'Oznámení o poèátku rezervaci je vy¾adováno.';
$strings['Maximum booking notice is required.'] = 'Oznámení o konci rezervace je vy¾adováno.';
$strings['Accessory Name'] = 'Název doplòku';
$strings['Accessories'] = 'Doplòky';
$strings['All Accessories'] = 'V¹echny doplòky';
$strings['Added Accessories'] = 'Pøidané doplòky';
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
				. "Byl jste úspì¹nì registrován s následujícími údaji:\r\n"
				. "Pøihla¹ovací jméno: %s\r\n"
				. "Jméno: %s %s \r\n"
				. "Telefon: %s \r\n"
				. "Instituce: %s \r\n"
				. "Pozice: %s \r\n\r\n"
				. "Prosím pøihla¹te se k Plánovaèi na této adrese:\r\n"
				. "%s \r\n\r\n"
				. "Upravit svùj profil a najít odkazy na online Plánovaè mù¾ete v sekci Mùj øídící panel.\r\n\r\n"
				. "Prosím po¹lete jakékoli dotazy ohlednì zdrojù nebo rezervací na adresu %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "Administrátor,\r\n\r\n"
					. "Byl registrován nový u¾ivatel s následujícími údaji:\r\n"
					. "Email: %s \r\n"
					. "Jméno: %s %s \r\n"
					. "Telefon: %s \r\n"
					. "Instituce: %s \r\n"
					. "Pozice: %s \r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "Máte úspì¹nou %s rezervaci #%s.\r\n\r\n<br/><br/>"
			. "Prosím pou¾ívejte toto èíslo rezervace pøi kontaktu administrátora s jakoukoli otázkou.\r\n\r\n<br/><br/>"
			. "Rezervace mezi %s %s a %s %s pro %s"
			. " v místì %s byla %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "Tato rezervace se opakuje v následující dny:\r\n<br/>";
$email['reservation_activity_3'] = "V¹echny opakující se rezervace v této skupinì byly také %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "Pro tuto rezervaci byl poskytnut následující souhrn :\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "Pokud se jedná o chybu, prosím kontaktujte administrátora na: %s"
			. " nebo volejte  %s.\r\n\r\n<br/><br/>"
			. "Informace o va¹í rezervaci mù¾ete prohlí¾et nebo mìnit kdykoli po"
			. " pøihlá¹ení do %s na adrese:\r\n<br/>"
			. "<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "Prosím smìøujte v¹echny technické dotazy na <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
			. "Rezervace #%s byla schválena.\r\n\r\n<br/><br/>"
			. "Prosím pou¾ívejte toto èíslo rezervace pøi kontaktu administrátora s jakýmkoli dotazem.\r\n\r\n<br/><br/>"
			. "Rezervace mezi %s %s a %s %s pro %s"
			. " umístìná v %s byla %s.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "Va¹e %s heslo bylo resetováno administrátorem.\r\n\r\n"
			. "Va¹e doèasné heslo je:\r\n\r\n %s\r\n\r\n"
			. "Prosím pou¾ijte toto doèasné heslo (k zaji¹tìní správnosti pou¾ijte funkce Úpravy | Kopírovat a Vlo¾it) pro pøihlá¹ení do %s na %s"
			. " a okam¾itì ho zmìòte pomocí odkazu 'Zmìnit Mùj profil/Heslo' z tabulky Moje rychlé odkazy.\r\n\r\n"
			. "Prosím, kontaktujte %s s jakýmkoli dotazem.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n"
            . "Va¹e nové heslo pro vá¹ %s úèet je:\r\n\r\n"
            . "%s\r\n\r\n"
            . "Prosím, pøihla¹te se na %s "
            . "s tímto heslem "
            . "(k zaji¹tìní správnosti pou¾ijte funkce Úpravy | Kopírovat a Vlo¾it) "
            . "a okam¾itì zmìòte va¹e heslo kliknutím na "
            . "odkaz Zmìnit Mùj profil/Heslo "
            . "v sekci Mùj øídící panel.\r\n\r\n"
            . "Prosím, smìøujte jakékoli dotazy na %s.";

// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s vás pozval k úèasti na následující rezervaci:\r\n\r\n"
		. "Zdroj: %s\r\n"
		. "Poèáteèní datum: %s\r\n"
		. "Poèáteèní èas: %s\r\n"
		. "Koncové datum: %s\r\n"
		. "Koncový èas: %s\r\n"
		. "Souhrn: %s\r\n"
		. "Opakovaná data (pokud jsou pøítomna): %s\r\n\r\n"
		. "Pro pøijetí této pozvánky kliknìte na tento odkaz (Kopírujte a Vlo¾te, pokud není zvýraznìn) %s\r\n"
		. "Pro odmítnutí této pozvánky kliknìte na tento link (Kopírujte a Vlo¾te, pokud není zvýraznìn) %s\r\n"
		. "Pro pøijetí vybraných dat nebo správu pozvánek pozdìji se pøihla¹to do %s na %s";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "Byl jste odstranìn z následujících rezervace:\r\n\r\n"
		. "Zdroj: %s\r\n"
		. "Poèáteèní datum: %s\r\n"
		. "Poèáteèní èas: %s\r\n"
		. "Koncové datum: %s\r\n"
		. "Koncový èas: %s\r\n"
		. "Souhrn: %s\r\n"
		. "Opakovaná data (pokud jsou pøítomna): %s\r\n\r\n";
		
// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "Va¹e rezervace na %s od %s %s do %s %s se blí¾í.";
?>