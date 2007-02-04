<?php
/**
* Slovak (sk) translation file.
*
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Marián Murín <murin@netkosice.sk>
* @version 05-20-06
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
$charset = 'windows-1250';

/***
  DAY NAMES
  All of these arrays MUST start with Sunday as the first element
   and go through the seven day week, ending on Saturday
***/
// The full day name
$days_full = array('Nede¾a', 'Pondelok', 'Utorok', 'Streda', 'Štvrtok', 'Piatok', 'Sobota');
// The three letter abbreviation
$days_abbr = array('Ned', 'Pon', 'Uto', 'Str', 'Štv', 'Pia', 'Sob');
// The two letter abbreviation
$days_two  = array('Ne', 'Po', 'Ut', 'St', 'Št', 'Pi', 'So');
// The one letter abbreviation
$days_letter = array('N', 'P', 'U', 'S', 'Š', 'P', 'S');

/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('Január', 'Február', 'Marec', 'Apríl', 'Máj', 'Jún', 'Júl', 'August', 'September', 'Október', 'November', 'December');
// The three letter month name
$months_abbr = array('Jan', 'Feb', 'Mar', 'Apr', 'Máj', 'Jún', 'Júl', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec');

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
$strings['minutes'] = 'minúty';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = 'mm';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = 'dd';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = 'rrrr';
$strings['am'] = 'am';
$strings['pm'] = 'pm';

$strings['Administrator'] = 'Administrator';
$strings['Welcome Back'] = 'Vitajte spä, %s';
$strings['Log Out'] = 'Odhlási sa';
$strings['My Control Panel'] = 'Môj Riadiaci Panel';
$strings['Help'] = 'Pomoc';
$strings['Manage Schedules'] = 'Správa rozvrhov';
$strings['Manage Users'] ='Správa uívate¾ov';
$strings['Manage Resources'] ='Správa zdrojov';
$strings['Manage User Training'] ='Správa školení uívate¾ov';
$strings['Manage Reservations'] ='Správa rezervácií';
$strings['Email Users'] ='Email uívate¾om';
$strings['Export Database Data'] = 'Export dát z databázy';
$strings['Reset Password'] = 'Reset hesla';
$strings['System Administration'] = 'Adminstrácia systému';
$strings['Successful update'] = 'Úspešná aktualizácia';
$strings['Update failed!'] = 'Aktualizácia neúspešná!';
$strings['Manage Blackout Times'] = 'Správa èasov vıpadkov';
$strings['Forgot Password'] = 'Heslo zabudnuté';
$strings['Manage My Email Contacts'] = 'Správa mojich email kontaktov';
$strings['Choose Date'] = 'Vyberte dátum';
$strings['Modify My Profile'] = 'Zmeni môj profil';
$strings['Register'] = 'Registrova';
$strings['Processing Blackout'] = 'Spracovanie vıpadkov';
$strings['Processing Reservation'] = 'Spracovanie rezervácií';
$strings['Online Scheduler [Read-only Mode]'] = 'Online Plánovaè [len na èítanie]';
$strings['Online Scheduler'] = 'Online Plánovaè';
$strings['phpScheduleIt Statistics'] = 'Štatistika rezervácií';
$strings['User Info'] = 'Informácie o uívate¾ovi:';

$strings['Could not determine tool'] = 'Nebolo moné urèi nástroj. Vráte sa prosím na váš riadiaci panel a skuste znovu nekôr.';
$strings['This is only accessable to the administrator'] = 'Toto je prístupné len pre administrátora';
$strings['Back to My Control Panel'] = 'Spä na Môj riadiaci panel';
$strings['That schedule is not available.'] = 'Tento rozvrh nie je prístupnı.';
$strings['You did not select any schedules to delete.'] = 'Nevybrali ste iadny rozvrh na odstránenie.';
$strings['You did not select any members to delete.'] = 'Nevybrali ste iadnych uívate¾ov na odstránenie.';
$strings['You did not select any resources to delete.'] = 'Nevybrali ste iadne zdroje na odstránenie.';
$strings['Schedule title is required.'] = 'Názov rozvrhu je povinnı.';
$strings['Invalid start/end times'] = 'Neplatné èasy zaèiatku/konca';
$strings['View days is required'] = 'View days je povinnı';
$strings['Day offset is required'] = 'Day offset je povinnı';
$strings['Admin email is required'] = 'Email administrátora je povinnı';
$strings['Resource name is required.'] = 'Názov zdroja je povinnı.';
$strings['Valid schedule must be selected'] = 'Musí by vybranı platnı rozvrh.';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'Minimálna dåka rezervácie musí by rovnaká alebo menšia ne maximálna.';
$strings['Your request was processed successfully.'] = 'Vaša poiadavka bola úspešne spracovaná.';
$strings['Go back to system administration'] = 'Spä na administráciu systému';
$strings['Or wait to be automatically redirected there.'] = 'Alebo poèkajte pokia¾ budete automaticky presmerovaní.';
$strings['There were problems processing your request.'] = 'Pri spracovaní vašej poiadavky sa vyskytli problémy.';
$strings['Please go back and correct any errors.'] = 'Prosím vráte sa a opravte chyby.';
$strings['Login to view details and place reservations'] = 'Prihláste sa prosím k preh¾adávaniu podrobností a zadávaniu rezervácií';
$strings['Memberid is not available.'] = 'Memberid: %s nie je dostupné.';

$strings['Schedule Title'] = 'Názov rozvrhu';
$strings['Start Time'] = 'Poèiatoènı èas';
$strings['End Time'] = 'Koncovı èas';
$strings['Time Span'] = 'Èasové rozpätie';
$strings['Weekday Start'] = 'Zaèiatok tıdòa';
$strings['Admin Email'] = 'e-mail administrátora';

$strings['Default'] = 'Predvolené';
$strings['Reset'] = 'Reset';
$strings['Edit'] = 'Upravi';
$strings['Delete'] = 'Odstráni';
$strings['Cancel'] = 'Zruši';
$strings['View'] = 'Zobrazi';
$strings['Modify'] = 'Zmeni';
$strings['Save'] = 'Uloi';
$strings['Back'] = 'Spä';
$strings['Next'] = 'Ïalší';
$strings['Close Window'] = 'Zatvori okno';
$strings['Search'] = 'H¾ada';
$strings['Clear'] = 'Vymaza';

$strings['Days to Show'] = 'Ukáza dni';
$strings['Reservation Offset'] = 'Posuv pre rezerváciu';
$strings['Hidden'] = 'Skry';
$strings['Show Summary'] = 'Ukáza súhrn';
$strings['Add Schedule'] = 'Prida rozvrh';
$strings['Edit Schedule'] = 'Upravi rozvrh';
$strings['No'] = 'Nie';
$strings['Yes'] = 'Áno';
$strings['Name'] = 'Méno';
$strings['First Name'] = 'Krstné meno';
$strings['Last Name'] = 'Priezvisko';
$strings['Resource Name'] = 'Názov zdroja';
$strings['Email'] = 'Email';
$strings['Institution'] = 'Inštitúcia';
$strings['Phone'] = 'Telefón';
$strings['Password'] = 'Heslo';
$strings['Permissions'] = 'Oprávnenia';
$strings['View information about'] = 'Zobrazi informáciu pre: %s %s';
$strings['Send email to'] = 'Posla email komu: %s %s';
$strings['Reset password for'] = 'Reset hesla pre:  %s %s';
$strings['Edit permissions for'] = 'Upravi oprávnenia pre: %s %s';
$strings['Position'] = 'Pozícia';
$strings['Password (6 char min)'] = 'Heslo (%s znakov minimálne)';	// @since 1.1.0
$strings['Re-Enter Password'] = 'Znovu zvoli heslo';

$strings['Sort by descending last name'] = 'Zoradi zhora nadol pod¾a priezviska';
$strings['Sort by descending email address'] = 'Zoradi zhora nadol pod¾a emailu';
$strings['Sort by descending institution'] = 'Zoradi zhora nadol pod¾a inštitúcie';
$strings['Sort by ascending last name'] = 'Zoradi zdola nahor pod¾a priezviska';
$strings['Sort by ascending email address'] = 'Zoradi zdola nahor pod¾a emailu';
$strings['Sort by ascending institution'] = 'Zoradi zdola nahor pod¾a inštitúcie';
$strings['Sort by descending resource name'] = 'Zoradi zhora nadol pod¾a názvu zdroja';
$strings['Sort by descending location'] = 'Zoradi zhora nadol pod¾a umiestnenia';
$strings['Sort by descending schedule title'] = 'Zoradi zhora nadol pod¾a názvu rozvrhu';
$strings['Sort by ascending resource name'] = 'Zoradi zdola nahor pod¾a názvu zdroja';
$strings['Sort by ascending location'] = 'Zoradi zdola nahor pod¾a umiestnenia';
$strings['Sort by ascending schedule title'] = 'Zoradi zdola nahor pod¾a názvu rozvrhu';
$strings['Sort by descending date'] = 'Zoradi zhora nadol pod¾a dátumu';
$strings['Sort by descending user name'] = 'Zoradi zhora nadol pod¾a mena uívate¾a';
$strings['Sort by descending start time'] = 'Zoradi zhora nadol pod¾a poèiatoèného èasu';
$strings['Sort by descending end time'] = 'Zoradi zhora nadol pod¾a koncového èasu';
$strings['Sort by ascending date'] = 'Zoradi zdola nahor pod¾a dátumu';
$strings['Sort by ascending user name'] = 'Zoradi zdola nahor pod¾a mena uívate¾a';
$strings['Sort by ascending start time'] = 'Zoradi zdola nahor pod¾a poèiatoèného èasu';
$strings['Sort by ascending end time'] = 'Zoradi zdola nahor pod¾a koncového èasu';
$strings['Sort by descending created time'] = 'Zoradi zhora nadol pod¾a èasu vytvorenia';
$strings['Sort by ascending created time'] = 'Zoradi zdola nahor pod¾a èasu vytvorenia';
$strings['Sort by descending last modified time'] = 'Zoradi zhora nadol pod¾a èasu poslednej zmeny';
$strings['Sort by ascending last modified time'] = 'Zoradi zdola nahor pod¾a èasu poslednej zmeny';

$strings['Search Users'] = 'Vyh¾ada uívate¾a';
$strings['Location'] = 'Umiestnenie';
$strings['Schedule'] = 'Rozvrh';
$strings['Phone'] = 'Telefón';
$strings['Notes'] = 'Poznámky';
$strings['Status'] = 'Stav';
$strings['All Schedules'] = 'Všetky rozvrhy';
$strings['All Resources'] = 'Všetky zdroje';
$strings['All Users'] = 'Všetci uívatelia';

$strings['Edit data for'] = 'Upravi dáta pre: %s';
$strings['Active'] = 'Aktívny';
$strings['Inactive'] = 'Neaktívny';
$strings['Toggle this resource active/inactive'] = 'Prepnite tento zdroj - aktívny/neaktívny';
$strings['Minimum Reservation Time'] = 'Minimálna doba rezervácie';
$strings['Maximum Reservation Time'] = 'Maximálna doba rezervácie';
$strings['Auto-assign permission'] = 'Automatické priradenie oprávnenia';
$strings['Add Resource'] = 'Prida zdroj';
$strings['Edit Resource'] = 'Upravi zdroj';
$strings['Allowed'] = 'Povolenı';
$strings['Notify user'] = 'Upovedomi uívate¾a';
$strings['User Reservations'] = 'Rezervácia uívate¾a';
$strings['Date'] = 'Dátum';
$strings['User'] = 'Uívate¾';
$strings['Email Users'] = 'Email uívate¾om';
$strings['Subject'] = 'Subjekt';
$strings['Message'] = 'Správa';
$strings['Please select users'] = 'Prosím vyberte uívate¾a';
$strings['Send Email'] = 'Posla email';
$strings['problem sending email'] = 'Prepáète, nepodarilo sa odosla váš email. Skúste to prosím neskôr.';
$strings['The email sent successfully.'] = 'Email bol úspešne odoslanı.';
$strings['do not refresh page'] = 'Prosím <u>neobnovujte</u> túto stránku. Email by bol poslanı znovu.';
$strings['Return to email management'] = 'Spä ku správe emailu';
$strings['Please select which tables and fields to export'] = 'Prosím vyberte tabu¾ky a polia pre export:';
$strings['all fields'] = '- všetky polia -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = 'Obyèajnı text';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = 'Export dát';
$strings['Reset Password for'] = 'Reset hesla pre: %s';
$strings['Please edit your profile'] = 'Prosím, upravte váš profil';
$strings['Please register'] = 'Prosím, zaregistrujte sa';
$strings['Keep me logged in'] = 'Udrujte ma prihláseného<br/>(vyaduje cookies)';
$strings['Edit Profile'] = 'Upravi profil';
$strings['Register'] = 'Registrácia';
$strings['Please Log In'] = 'Prosím, prihláste sa';
$strings['Email address'] = 'Emailová adresa';
$strings['Password'] = 'Heslo';
$strings['First time user'] = 'Prvıkrát pripojenı?';
$strings['Click here to register'] = 'Kliknite tu pre registráciu';
$strings['Register for phpScheduleIt'] = 'Registrácia pre rezervácie';
$strings['Log In'] = 'Prihlásenie';
$strings['View Schedule'] = 'Zobrazi rozvrh';
$strings['View a read-only version of the schedule'] = 'Verzia rozvrhu len na èítanie';
$strings['I Forgot My Password'] = 'Zabudol som svoje heslo';
$strings['Retreive lost password'] = 'Získanie strateného hesla';
$strings['Get online help'] = 'Online pomoc';
$strings['Language'] = 'Jazyk';
$strings['(Default)'] = '(Predvolenı)';

$strings['My Announcements'] = 'Moje oznámenia';
$strings['My Reservations'] = 'Moje rezervácie';
$strings['My Permissions'] = 'Moje oprávnenia';
$strings['My Quick Links'] = 'Moje rıchle odkazy';
$strings['Announcements as of'] = 'Oznámenia: %s';
$strings['There are no announcements.'] = 'iadne oznámenia.';
$strings['Resource'] = 'Zdroj';
$strings['Created'] = 'Vytvorené';
$strings['Last Modified'] = 'Posledná zmena';
$strings['View this reservation'] = 'Zobrazi túto rezerváciu';
$strings['Modify this reservation'] = 'Zmeni túto rezerváciu';
$strings['Delete this reservation'] = 'Odstráni túto rezerváciu';
$strings['Bookings'] = 'Rezervácie';											// @since 1.2.0
$strings['Change My Profile Information/Password'] = 'Zmena profilu';		// @since 1.2.0
$strings['Manage My Email Preferences'] = 'Nastavenia Emailu';				// @since 1.2.0
$strings['Mass Email Users'] = 'Hromadnı email uívate¾om';
$strings['Search Scheduled Resource Usage'] = 'H¾ada rezervácie';		// @since 1.2.0
$strings['Export Database Content'] = 'Export obsahu databázy';
$strings['View System Stats'] = 'Zobrazi štatistiku systému';
$strings['Email Administrator'] = 'Email administrátorovi';

$strings['Email me when'] = 'Pošli mi email, keï:';
$strings['I place a reservation'] = 'Zadám rezerváciu';
$strings['My reservation is modified'] = 'Moja rezervácia je zmenená';
$strings['My reservation is deleted'] = 'Moja rezervácia je odstránená';
$strings['I prefer'] = 'Uprednostòujem:';
$strings['Your email preferences were successfully saved'] = 'Vaše emailové nastavenia boli úspešne uloené!';
$strings['Return to My Control Panel'] = 'Spä na Môj riadiaci panel';

$strings['Please select the starting and ending times'] = 'Prosím zvo¾te poèiatoèné a koncové èasy:';
$strings['Please change the starting and ending times'] = 'Prosím zmeòte poèiatoèné a koncové èasy:';
$strings['Reserved time'] = 'Rezervovanı èas:';
$strings['Minimum Reservation Length'] = 'Dåka minimálnej rezervácie:';
$strings['Maximum Reservation Length'] = 'Dåka maximálnej rezervácie:';
$strings['Reserved for'] = 'Rezervované pre:';
$strings['Will be reserved for'] = 'Bude rezervované pre:';
$strings['N/A'] = 'N/A';
$strings['Update all recurring records in group'] = 'Aktualizova všetky opakujúce sa záznamy pre  skupinu?';
$strings['Delete?'] = 'Odstráni?';
$strings['Never'] = '-- Nikdy --';
$strings['Days'] = 'Dni';
$strings['Weeks'] = 'Tıdne';
$strings['Months (date)'] = 'Mesiace (dátum)';
$strings['Months (day)'] = 'Mesiace (den)';
$strings['First Days'] = 'Prvé dni';
$strings['Second Days'] = 'Druhé dni';
$strings['Third Days'] = 'Tretie dni';
$strings['Fourth Days'] = 'Štvrté dni';
$strings['Last Days'] = 'Posledné dni';
$strings['Repeat every'] = 'Opakuj kadı:';
$strings['Repeat on'] = 'Opakuj keï:';
$strings['Repeat until date'] = 'Opakuj do dátumu:';
$strings['Choose Date'] = 'Vyberte dátum';
$strings['Summary'] = 'Súhrn';

$strings['View schedule'] = 'Zobrazi rozvrh:';
$strings['My Reservations'] = 'Moje rezervácie';
$strings['My Past Reservations'] = 'Moje minulé rezervácie';
$strings['Other Reservations'] = 'Ïalšie rezervácie';
$strings['Other Past Reservations'] = 'Ïalšie minulé rezervácie';
$strings['Blacked Out Time'] = 'Vıpadkovı èas';
$strings['Set blackout times'] = 'Nastavi vıpadkové èasy pre %s na %s';
$strings['Reserve on'] = 'Rezervova %s na %s';
$strings['Prev Week'] = '&laquo; Predchádzajúci tıdeò';
$strings['Jump 1 week back'] = 'Skoèit 1 tıdeò spä';
$strings['Prev days'] = '&#8249; Predch. %d dni';
$strings['Previous days'] = '&#8249; Predchádzajúce %d dni';
$strings['This Week'] = 'Tento tıdeò';
$strings['Jump to this week'] = 'Skoèi do tohto tıdòa';
$strings['Next days'] = 'Ïalších %d dní &#8250;';
$strings['Next Week'] = 'Ïalší tıdeò &raquo;';
$strings['Jump To Date'] = 'Skoèi na dátum';
$strings['View Monthly Calendar'] = 'Zobrazi mesaènı kalendár';
$strings['Open up a navigational calendar'] = 'Otvori navigaènı kalendár';

$strings['View stats for schedule'] = 'Zobrazi štatistiku pre rozvrh:';
$strings['At A Glance'] = 'Zbene';
$strings['Total Users'] = 'Celkovo uívatelia:';
$strings['Total Resources'] = 'Celkovo zdroje:';
$strings['Total Reservations'] = 'Celkovo rezervácie:';
$strings['Max Reservation'] = 'Max rezervácie:';
$strings['Min Reservation'] = 'Min rezervácie:';
$strings['Avg Reservation'] = 'Priemerné rezervácie:';
$strings['Most Active Resource'] = 'Najaktívnejší zdroj:';
$strings['Most Active User'] = 'Najaktívnejší uívate¾:';
$strings['System Stats'] = 'Štatistika systému';
$strings['phpScheduleIt version'] = 'Verzia phpScheduleIt:';
$strings['Database backend'] = 'Pouitı databázovı systém:';
$strings['Database name'] = 'Názov databázy:';
$strings['PHP version'] = 'Verzia PHP:';
$strings['Server OS'] = 'OS serveru:';
$strings['Server name'] = 'Názov serveru:';
$strings['phpScheduleIt root directory'] = 'Koreòovı adresár systému:';
$strings['Using permissions'] = 'Pouívané oprávnenia:';
$strings['Using logging'] = 'Pouívané logovania:';
$strings['Log file'] = 'Logovací súbor:';
$strings['Admin email address'] = 'Email administrátora:';
$strings['Tech email address'] = 'Email technickej podpory:';
$strings['CC email addresses'] = 'CC emailové adresy:';
$strings['Reservation start time'] = 'Poèiatoènı èas rezervácie:';
$strings['Reservation end time'] = 'Koncovı èas rezervácie:';
$strings['Days shown at a time'] = 'Poèet naraz zobrazovanıch dní:';
$strings['Reservations'] = 'Rezervácie';
$strings['Return to top'] = 'Spä na zaèiatok';
$strings['for'] = 'pre';

$strings['Select Search Criteria'] = 'Vyberte vyh¾adávacie kritériá';
$strings['Schedules'] = 'Rozvrhy:';
$strings['All Schedules'] = 'Všetky rozvrhy';
$strings['Hold CTRL to select multiple'] = 'Drte CTRL k viacnásobnému vıberu';
$strings['Users'] = 'Uívatelia:';
$strings['All Users'] = 'Všetci uívatelia';
$strings['Resources'] = 'Zdroje';
$strings['All Resources'] = 'Všetky zdroje';
$strings['Starting Date'] = 'Poèiatoènı dátum:';
$strings['Ending Date'] = 'Koncovı dátum:';
$strings['Starting Time'] = 'Poèiatoènı èas:';
$strings['Ending Time'] = 'Koncovı èas:';
$strings['Output Type'] = 'Typ vıstupu:';
$strings['Manage'] = 'Spravova';
$strings['Total Time'] = 'Celkovı èas';
$strings['Total hours'] = 'Spolu hodín:';
$strings['% of total resource time'] = '% celkového èasu zdroja';
$strings['View these results as'] = 'Zobrazi tieto vısledky ako:';
$strings['Edit this reservation'] = 'Upravi túto rezerváciu';
$strings['Search Results'] = 'Preh¾ada vısledky';
$strings['Search Resource Usage'] = 'Vyh¾ada vyuitie zdroja';
$strings['Search Results found'] = 'Vısledky vyh¾adávania: %d rezervácii nájdenıch';
$strings['Try a different search'] = 'Skúste iné vyh¾adávanie';
$strings['Search Run On'] = 'Spusti vyh¾adávanie na:';
$strings['Member ID'] = 'ID uívate¾a';
$strings['Previous User'] = '&laquo; Predchádzajúci uívate¾';
$strings['Next User'] = 'Další uívate¾ &raquo;';

$strings['No results'] = 'iadne vısledky';
$strings['That record could not be found.'] = 'Tento záznam sa nenašiel.';
$strings['This blackout is not recurring.'] = 'Tento vıpadok nie je opakovanı.';
$strings['This reservation is not recurring.'] = 'Táto rezervácia nie je opakovaná.';
$strings['There are no records in the table.'] = 'V tabu¾ke %s nie sú iadne záznamy.';
$strings['You do not have any reservations scheduled.'] = 'Nemáte naplánované iadne rezervácie.';
$strings['You do not have permission to use any resources.'] = 'Nemáte oprávnenie pouíva akıko¾vek zdroj.';
$strings['No resources in the database.'] = 'V databáze nie sú iadne zdroje.';
$strings['There was an error executing your query'] = 'Pri spracovávaní vašej poiadavky došlo k  chybe:';

$strings['That cookie seems to be invalid'] = 'Tento cookie je neplatnı';
$strings['We could not find that logon in our database.'] = 'Toto prihlásenie sa v našej databáze nenašlo.';	// @since 1.1.0
$strings['That password did not match the one in our database.'] = 'Toto heslo sa nezhodovalo s heslom z našej databázy.';
$strings['You can try'] = '<br />Môete vyskúša:<br />Registrova email adresu.<br />Alebo:<br />Skúste prihlásenie znovu.';
$strings['A new user has been added'] = 'Novı uívate¾ bol pridanı';
$strings['You have successfully registered'] = 'Úspešne ste sa zaregistrovali!';
$strings['Continue'] = 'Pokraèova...';
$strings['Your profile has been successfully updated!'] = 'Váš profil bol úspešne zmenenı!';
$strings['Please return to My Control Panel'] = 'Prosím vráte sa na Môj riadiaci panel';
$strings['Valid email address is required.'] = '- je poadovaná platná emailová adresa.';
$strings['First name is required.'] = '- Krstné meno je poadované.';
$strings['Last name is required.'] = '- Priezvisko je poadované.';
$strings['Phone number is required.'] = '- Telefónne èíslo je poadované.';
$strings['That email is taken already.'] = '- Táto emailová adresa u existuje.<br />Prosím zadajte inú emailovú adresu.';
$strings['Min 6 character password is required.'] = '- Je poadované heslo s minimálne %s znakmi.';
$strings['Passwords do not match.'] = '- Heslá sa nezhodujú.';

$strings['Per page'] = 'Na stránku:';
$strings['Page'] = 'Stránka:';

$strings['Your reservation was successfully created'] = 'Vaša rezervácia bola úspešne vytvorená';
$strings['Your reservation was successfully modified'] = 'Vaša rezervácia bola úspešne zmenená';
$strings['Your reservation was successfully deleted'] = 'Vaša rezervácia bola úspešne odstránená';
$strings['Your blackout was successfully created'] = 'Váš vıpadok bol úspešne vytvorenı';
$strings['Your blackout was successfully modified'] = 'Váš vıpadok bol úspešne zmenenı';
$strings['Your blackout was successfully deleted'] = 'Váš vıpadok bol úspešne odstránenı';
$strings['for the follwing dates'] = 'pre nasledujúce dáta:';
$strings['Start time must be less than end time'] = 'Poèiatoènı èas musí by menší ne koncovı èas.';
$strings['Current start time is'] = 'Aktuálny poèiatoènı èas je:';
$strings['Current end time is'] = 'Aktuálny koncovı èas je:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'Dåka rezervácie nie je v intervale povolenej dåky pre tento zdroj.';
$strings['Your reservation is'] = 'Vaša rezervácia je:';
$strings['Minimum reservation length'] = 'Minimálna dåka rezervácie:';
$strings['Maximum reservation length'] = 'Maximálna dåka rezervácie:';
$strings['You do not have permission to use this resource.'] = 'Nemáte oprávnenie k pouívaniu tohto zdroja.';
$strings['reserved or unavailable'] = '%s a %s je rezervovanı alebo neprístupnı.';	// @since 1.1.0
$strings['Reservation created for'] = 'Rezervácia vytvorená pre %s';
$strings['Reservation modified for'] = 'Rezervácia zmenená pre %s';
$strings['Reservation deleted for'] = 'Rezervácia odstránená pre %s';
$strings['created'] = 'vytvorené';
$strings['modified'] = 'zmenené';
$strings['deleted'] = 'odstránené';
$strings['Reservation #'] = 'Rezervácia #';
$strings['Contact'] = 'Kontakt';
$strings['Reservation created'] = 'Rezervácia vytvorená';
$strings['Reservation modified'] = 'Rezervácia zmenená';
$strings['Reservation deleted'] = 'Rezervácia odstránená';

$strings['Reservations by month'] = 'Rezervácie po mesiacoch';
$strings['Reservations by day of the week'] = 'Rezervácie po dòoch v tıdni';
$strings['Reservations per month'] = 'Rezervácie po dòoch v mesiaci';
$strings['Reservations per user'] = 'Rezervácie na uívate¾a';
$strings['Reservations per resource'] = 'Rezervácie na zdroj';
$strings['Reservations per start time'] = 'Rezervácie pod¾a poèiatoèného èasu';
$strings['Reservations per end time'] = 'Rezervácie pod¾a koncového èasu';
$strings['[All Reservations]'] = '[Všetky rezervácie]';

$strings['Permissions Updated'] = 'Oprávnenia aktualizované';
$strings['Your permissions have been updated'] = 'Vaše %s oprávnenia boli aktualizované';
$strings['You now do not have permission to use any resources.'] = 'Teraz nemáte oprávnenie k pouitiu iadneho zdroja.';
$strings['You now have permission to use the following resources'] = 'Teraz máte oprávnenie k pouitiu následujúceho zdroja:';
$strings['Please contact with any questions.'] = 'Prosím kontaktujte %s s ¾ubovo¾nou poiadavkou.';
$strings['Password Reset'] = 'Reset hesla';

$strings['This will change your password to a new, randomly generated one.'] = 'Toto zmení vaše heslo na nové, náhodne vygenerované.';
$strings['your new password will be set'] = 'Po vloení vášho emailu a kliknutí na "Zmeni heslo" vám systém nastaví nové heslo a zašle ho emailom.';
$strings['Change Password'] = 'Zmeni heslo';
$strings['Sorry, we could not find that user in the database.'] = 'Prepáète, tohoto uívate¾a sme nenašli v databáze.';
$strings['Your New Password'] = 'Vaše nové %s heslo';
$strings['Your new passsword has been emailed to you.'] = 'Úspech!<br />'
    			. 'Vaše nové heslo vám bolo poslané emailom.<br />'
    			. 'Prosím skontrolujte si vašu emailovú schránku, kde bude nové heslo, potom sa <a href="index.php">prihláste</a>'
    			. ' s tımto novım heslom a urıchlene ho zmeòte kliknutím na odkaz &quot;Zmeni môj profil/heslo&quot;'
    			. ' v oblasti Môj riadiaci panel.';

$strings['You are not logged in!'] = 'Nie ste prihlásenı!';

$strings['Setup'] = 'Nastavenie';
$strings['Please log into your database'] = 'Prosím prihláste sa do vašej databázy';
$strings['Enter database root username'] = 'Vlote uívate¾ské meno administrátora databázy:';
$strings['Enter database root password'] = 'Vlote heslo administrátora databázy:';
$strings['Login to database'] = 'Prihlásenie do databázy';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = 'Administrátorské práva <b>nie sú potrebné</b>. Ktorıko¾vek uívate¾ databázy s právom vytvára tabu¾ky postaèuje.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = 'Toto nastaví potrebné databázy a tabu¾ky pre phpScheduleIt.';
$strings['It also populates any required tables.'] = 'Toto tie vyplní potrebné tabu¾ky.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = 'Varovanie: TOTO ODSTRÁNI VŠETKY DÁTA V PREDCHÁDZAJÚCICH DATABÁZACH phpScheduleIt!';
$strings['Not a valid database type in the config.php file.'] = 'Neplatnı typ databázy v súbore config.php.';
$strings['Database user password is not set in the config.php file.'] = 'Heslo pre uívate¾a databázy nie je nastavené v súbore config.php.';
$strings['Database name not set in the config.php file.'] = 'Názov databázy nie je nastavenı v súbore config.php.';
$strings['Successfully connected as'] = 'Úspešne pripojenı ako';
$strings['Create tables'] = 'Vytvori tabu¾ky &gt;';
$strings['There were errors during the install.'] = 'Behom inštalácie sa vyskytly chyby. Je moné, e phpScheduleIt bude aj tak fungova, pokia¾ chyby neboli závané.<br/><br/>'
	. 'Prosím akéko¾vek dotazy uvádzajte v diskusnıch fórach na <a href="http://sourceforge.net/forum/?group_id=95547">SourceForge</a>.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = 'Úspešne ste dokonèili nastavenie phpScheduleIt a môete ho zaèa pouíva.';
$strings['Thank you for using phpScheduleIt'] = 'Prosím zabezpeète ÚPLNÉ ODSTRÁNENIE ADRESÁRA \'install\' .'
	. ' To je ve¾mi dôleité, pretoe obsahuje heslá do databázy a ïalšie citlivé informácie.'
	. ' Pokia¾ to nezabezpeèíte, necháte tak otvorené dvere k preniknutiu do vašej databázy!'
	. '<br /><br />'
	. 'Ïakujeme vám, e pouívate phpScheduleIt!';
$strings['There is no way to undo this action'] = 'Túto akciu nie je moné vráti spä!';
$strings['Click to proceed'] = 'Kliknite pre pokraèovanie';
$strings['Please delete this file.'] = 'Prosím odstráòte tento súbor.';
$strings['Successful update'] = 'Aktualizácia prebehla vporiadku';
$strings['Patch completed successfully'] = 'Záplata bola úspešne aplikovaná';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = 'Pokia¾ nie je uvedená iadna hodnota, bude pouité heslo uvedené v konfiguraènom súbore.';
$strings['Notify user that password has been changed?'] = 'Upovedomi uívate¾a, e heslo bolo zmenené?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'Tento systém vyaduje, aby ste mali emailovú adresu.';
$strings['Invalid User Name/Password.'] = 'Neplatné uívate¾ské meno/heslo.';
$strings['Pending User Reservations'] = 'Nevybavené uívate¾ské rezervácie';
$strings['Approve'] = 'Schváli';
$strings['Approve this reservation'] = 'Schváli túto rezerváciu';
$strings['Approve Reservations'] ='Schváli rezervácie';

$strings['Announcement'] = 'Oznámenie';
$strings['Number'] = 'Èíslo';
$strings['Add Announcement'] = 'Prida oznámenie';
$strings['Edit Announcement'] = 'Upravi oznámenie';
$strings['All Announcements'] = 'Všetky oznámenia';
$strings['Delete Announcements'] = 'Odstráni oznámenia';
$strings['Use start date/time?'] = 'Poui poèiatoènı dátum/èas?';
$strings['Use end date/time?'] = 'Poui koncovı dátum/èas?';
$strings['Announcement text is required.'] = 'Text oznámenia je poadovanı.';
$strings['Announcement number is required.'] = 'Èíslo oznámenia je poadované.';

$strings['Pending Approval'] = 'Nevybavené schválenie';
$strings['My reservation is approved'] = 'Moja rezervácia je schválená';
$strings['This reservation must be approved by the administrator.'] = 'Táto rezervácia musí by schválená administrátorom.';
$strings['Approval Required'] = 'Schválenie je poadované';
$strings['No reservations requiring approval'] = 'iadne rezervácie na schválenie';
$strings['Your reservation was successfully approved'] = 'Vaša rezervácia bola úspešne schválená';
$strings['Reservation approved for'] = 'Rezervácia schválená pre %s';
$strings['approved'] = 'schválené';
$strings['Reservation approved'] = 'Rezervácia schválená';

$strings['Valid username is required'] = 'Je poadované platné uívate¾ské meno';
$strings['That logon name is taken already.'] = 'Toto prihlasovacie meno je u pouívané.';
$strings['this will be your login'] = '(toto bude vaše prihlasovacie meno)';
$strings['Logon name'] = 'Prihlasovacie meno';
$strings['Your logon name is'] = 'Vaše prihlasovacie meno je %s';

$strings['Start'] = 'Zaèiatok';
$strings['End'] = 'Koniec';
$strings['Start date must be less than or equal to end date'] = 'Poèiatoènı dátum musí by menší alebo rovnı koncovému dátumu';
$strings['That starting date has already passed'] = 'Poèiatoènı dátum u uplynul';
$strings['Basic'] = 'Základnı';
$strings['Participants'] = 'Úèastníci';
$strings['Close'] = 'Zatvori';
$strings['Start Date'] = 'Poèiatoènı dátum';
$strings['End Date'] = 'Koncovı dátum';
$strings['Minimum'] = 'Minimum';
$strings['Maximum'] = 'Maximum';
$strings['Allow Multiple Day Reservations'] = 'Povoli viacdòové rezervácie';
$strings['Invited Users'] = 'Pozvaní uívatelia';
$strings['Invite Users'] = 'Pozva uívate¾ov';
$strings['Remove Participants'] = 'Odstráni úèastníkov';
$strings['Reservation Invitation'] = 'Pozvanie Rezervácie';
$strings['Manage Invites'] = 'Správa pozvánok';
$strings['No invite was selected'] = 'Neboli vybrané iadne pozvánky';
$strings['reservation accepted'] = '%s Vaše pozvanie na %s prijaté';
$strings['reservation declined'] = '%s Vaše pozvanie na %s zamietnuté';
$strings['Login to manage all of your invitiations'] = 'Prihláste sa ku správe všetkıch Vašich pozvaní';
$strings['Reservation Participation Change'] = 'Zmena úèasti na rezervácii';
$strings['My Invitations'] = 'Moje pozvania';
$strings['Accept'] = 'Prija';
$strings['Decline'] = 'Zamietnu';
$strings['Accept or decline this reservation'] = 'Prija alebo zamietnu túto rezerváciu';
$strings['My Reservation Participation'] = 'Moja úèas na rezervácii';
$strings['End Participation'] = 'Koniec úèasti';
$strings['Owner'] = 'Vlastník';
$strings['Particpating Users'] = 'Zúèastnení uívatelia';
$strings['No advanced options available'] = 'iadne pokroèilé vo¾by nie sú prístupné';
$strings['Confirm reservation participation'] = 'Potvrïte úèas na rezervácii';
$strings['Confirm'] = 'Potvrdi';
$strings['Do for all reservations in the group?'] = 'Vykona pre všetky rezervácie v skupine?';

$strings['My Calendar'] = 'Môj kalendár';
$strings['View My Calendar'] = 'Zobrazi Môj kalendár';
$strings['Participant'] = 'Úèastník';
$strings['Recurring'] = 'Opakujúci sa';
$strings['Multiple Day'] = 'Viacej dní';
$strings['[today]'] = '[dnes]';
$strings['Day View'] = 'Zobrazenie dòa';
$strings['Week View'] = 'Zobrazenie tıdòa';
$strings['Month View'] = 'Zobrazenie mesiaca';
$strings['Resource Calendar'] = 'Kalendár zdrojov';
$strings['View Resource Calendar'] = 'Plánovací kalendár';	// @since 1.2.0
$strings['Signup View'] = 'Zobrazenie registrácie';

$strings['Select User'] = 'Vybra uívate¾a';
$strings['Change'] = 'Zmeni';

$strings['Update'] = 'Aktualizova';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'Aktualizácia  phpScheduleIt je dostupná len pre verziu 1.0.0 a vyššie';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt je aktualizovanı';
$strings['Migrating reservations'] = 'Migrujúce rezervácie';

$strings['Admin'] = 'Admin';
$strings['Manage Announcements'] = 'Spravovanie oznámení';
$strings['There are no announcements'] = 'Nie sú iadne oznámenia';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = 'Maximálna kapacita úèastníkov';
$strings['Leave blank for unlimited'] = 'Nevyplòajte pre neobmedzenı poèet';
$strings['Maximum of participants'] = 'Tento zdroj má maximálnu kapacitu %s úèastníkov';
$strings['That reservation is at full capacity.'] = 'Táto rezervácia je obsadená.';
$strings['Allow registered users to join?'] = 'Umoni pridanie pre registrovanıch uívate¾ov?';
$strings['Allow non-registered users to join?'] = 'Umoni pridanie pre neregistrovanıch uívate¾ov?';
$strings['Join'] = 'Prida sa';
$strings['My Participation Options'] = 'Nastavenia pre moju úèas';
$strings['Join Reservation'] = 'Prida sa k rezervácii';
$strings['Join All Recurring'] = 'Prida sa ku všetkım opakujúcim';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = 'Nie ste úèastníkom nasledujúcich rezervaènıch termínov, pretoe sú obsadené.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = 'U ste boli pozvaní k tejto rezervácii. Pozrite si prosím inštrukcie pre úèas, ktoré boli poslané na Vašu emailovú adresu.';
$strings['Additional Tools'] = 'Doplnkové nástroje';
$strings['Create User'] = 'Vytvori uívate¾a';
$strings['Check Availability'] = 'Skontrolova dostupnos';
$strings['Manage Additional Resources'] = 'Správa dodatocnıch zdrojov';
$strings['Number Available'] = 'Poèet dostupnıch';
$strings['Unlimited'] = 'Neobmedzenı';
$strings['Add Additional Resource'] = 'Pridat dodatocnı zdroj';
$strings['Edit Additional Resource'] = 'Zmenit dodatocnı zdroj';
$strings['Checking'] = 'Overenie';
$strings['You did not select anything to delete.'] = 'Nevybrali ste niè na zmazanie.';
$strings['Added Resources'] = 'Pridané zdroje';
$strings['Additional resource is reserved'] = 'Dodatoènı zdroj %s má dostupnıch len %s v tomto èase';
$strings['All Groups'] = 'Všetky skupiny';
$strings['Group Name'] = 'Meno skupiny';
$strings['Delete Groups'] = 'Zmaza skupiny';
$strings['Manage Groups'] = 'Spravovanie skupín';
$strings['None'] = 'iadny';
$strings['Group name is required.'] = 'Je poadované meno skupiny.';
$strings['Groups'] = 'Skupiny';
$strings['Current Groups'] = 'Aktuálne skupiny';
$strings['Group Administration'] = 'Skupinová administrácia';
$strings['Reminder Subject'] = 'Pripomienkovaè pre rezerváciu- %s, %s %s';
$strings['Reminder'] = 'Pripomienkovaè';
$strings['before reservation'] = 'pred rezerváciou';
$strings['My Participation'] = 'Moja úèas';
$strings['My Past Participation'] = 'Moja posledná úèas';
$strings['Timezone'] = 'Èasové pásmo';
$strings['Export'] = 'Export';
$strings['Select reservations to export'] = 'Vyberte rezervácie na export';
$strings['Export Format'] = 'Formát exportu';
$strings['This resource cannot be reserved less than x hours in advance'] = 'Tento zdroj nesmie by rezervovanı menej ne %s hodín vopred';
$strings['This resource cannot be reserved more than x hours in advance'] = 'Tento zdroj nesmie by rezervovanı viac ne %s hodín vopred';
$strings['Minimum Booking Notice'] = 'Minimálny poèet oznamov pre rezerváciu';
$strings['Maximum Booking Notice'] = 'Maximálny poèet oznamov pre rezerváciu';
$strings['hours prior to the start time'] = 'hodín pred poèiatoènım èasom';
$strings['hours from the current time'] = 'hodín od aktuálneho èasu';
$strings['Contains'] = 'Obsahuje';
$strings['Begins with'] = 'Zaèína s';
$strings['Minimum booking notice is required.'] = 'Minimálny poèet oznamov pre rezerváciu je poadovanı.';
$strings['Maximum booking notice is required.'] = 'Maximálny poèet oznamov pre rezerváciu je poadovanı.';
$strings['Accessory Name'] = 'Meno doplnku';
$strings['Accessories'] = 'Doplnky';
$strings['All Accessories'] = 'Všetky doplnky';
$strings['Added Accessories'] = 'Pridané doplnky';
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
				. "Boli ste úspešne zaregistrovanı s následujucími údajmi:\r\n"
				. "Prihlasovacie meno: %s\r\n"
				. "Meno: %s %s \r\n"
				. "Telefón: %s \r\n"
				. "Inštitúcia: %s \r\n"
				. "Pozícia: %s \r\n\r\n"
				. "Prosím prihláste sa pre vyuívanie Plánovaèa na tejto adrese:\r\n"
				. "%s \r\n\r\n"
				. "Upravi svoj profil a nájs odkazy na online Plánovaè môete v sekcii Môj riadiaci panel.\r\n\r\n"
				. "Pošlite prosím akéko¾vek otázky oh¾adom zdrojov alebo rezervácií na adresu %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "Administrátor,\r\n\r\n"
					. "Bol zaregistrovanı novı uívate¾ s nasledujúcimi údajmi:\r\n"
					. "Email: %s \r\n"
					. "Meno: %s %s \r\n"
					. "Telefón: %s \r\n"
					. "Inštitúcia: %s \r\n"
					. "Pozícia: %s \r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "Máte úspešnú %s rezerváciu #%s.\r\n\r\n<br/><br/>"
			. "Pouívajte prosím toto èíslo rezervácie pri kontakte administrátora s akouko¾vek  otázkou.\r\n\r\n<br/><br/>"
			. "Rezervácia medzi %s %s a %s %s pre %s"
			. " v mieste %s bola %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "Táto rezervácia sa opakuje v nasledujúce dni:\r\n<br/>";
$email['reservation_activity_3'] = "Všetky opakujúce sa rezervácie v tejto skupine boli také %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "Pre túto rezerváciu bol poskytnutı nasledujúci súhrn :\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "Pokia¾ ide o chybu, kontaktujte prosím administrátora na: %s"
			. " alebo volajte  %s.\r\n\r\n<br/><br/>"
			. "Informácie o vašej rezervácii môete prezera alebo meni kedyko¾vek po"
			. " prihlásení do %s na adrese:\r\n<br/>"
			. "<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "Všetky technické otázky smerujte na <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
			. "Rezervácia #%s bola schválená.\r\n\r\n<br/><br/>"
			. "Prosím pouívajte toto èíslo rezervácie pri kontakte administrátora s akouko¾vek  otázkou.\r\n\r\n<br/><br/>"
			. "Rezervácia medzi %s %s a %s %s pre %s"
			. " umiestnená v %s bola %s.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "Vaše %s heslo bolo resetované administrátorom.\r\n\r\n"
			. "Vaše doèasné heslo je:\r\n\r\n %s\r\n\r\n"
			. "Prosím pouijte toto doèasné heslo (k zabezpeèeniu správnosti pouijte funkciu Úpravy | Kopírova a Vloit) pre prihlásenie do %s na %s"
			. " a okamite ho zmeòte pomocou odkazu 'Zmeni Môj profil/Heslo' z tabu¾ky Moje rıchle odkazy.\r\n\r\n"
			. "Prosím, kontaktujte %s s akouko¾vek poiadavkou.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n"
            . "Vaše nové heslo pre váš %s úèet je:\r\n\r\n"
            . "%s\r\n\r\n"
            . "Prosím, prihláste se na %s "
            . "s tımto heslom "
            . "(k zabezpeèeniu správnosti pouijte funkciu Úpravy | Kopírova a Vloi) "
            . "a okamite zmeòte vaše heslo kliknutím na "
            . "odkaz Zmeni Môj profil/Heslo "
            . "v sekcii Môj riadiaci panel.\r\n\r\n"
            . "Prosím, akéko¾vek poiadavky smerujte na %s.";

// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s vás pozval k úèasti pre následujúcu rezerváciu:\r\n\r\n"
		. "Zdroj: %s\r\n"
		. "Poèiatoènı dátum: %s\r\n"
		. "Poèiatoènı èas: %s\r\n"
		. "Koncovı dátum: %s\r\n"
		. "Koncovı èas: %s\r\n"
		. "Súhrn: %s\r\n"
		. "Opakované dáta (pokia¾ sú dostupné): %s\r\n\r\n"
		. "Pre prijatie tejto pozvánky kliknite na tento odkaz (Kopírujte a Vlote, pokia¾ nie je zvıraznenı) %s\r\n"
		. "Pre odmietnutie tejto pozvánky kliknite na tento link (Kopírujte a Vlote, pokia¾ nie je zvıraznenı) %s\r\n"
		. "Pre neskoršie prijatie vybranıch dát alebo správu pozvánok sa prihlaste do %s na %s";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "Boli ste odstránenı z následujúcej rezervácie:\r\n\r\n"
		. "Zdroj: %s\r\n"
		. "Poèiatoènı dátum: %s\r\n"
		. "Poèiatoènı èas: %s\r\n"
		. "Koncovı dátum: %s\r\n"
		. "Koncovı èas: %s\r\n"
		. "Súhrn: %s\r\n"
		. "Opakované dáta (pokia¾ sú dostupné): %s\r\n\r\n";

// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "Vaša rezervácia pre %s od %s %s do %s %s sa blíi.";
?>