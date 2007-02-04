<?php
/**
* Slovenian (sl) translation file.
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator E. Dras <e.dras@hidra.si>
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
$charset = 'windows-1250';

/***
  DAY NAMES
  All of these arrays MUST start with Sunday as the first element 
   and go through the seven day week, ending on Saturday
***/
// The full day name
$days_full = array('Nedelja', 'Ponedeljek', 'Torek', 'Sreda', 'Èetrtek', 'Petek', 'Sobota');
// The three letter abbreviation
$days_abbr = array('Ned', 'Pon', 'Tor', 'Sre', 'Èet', 'Pet', 'Sob');
// The two letter abbreviation
$days_two  = array('Ne', 'Po', 'To', 'Sr', 'Èe', 'Pe', 'So');
// The one letter abbreviation
$days_letter = array('N', 'P', 'T', 'S', 'È', 'P', 'S');

/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('Januar', 'Februar', 'Marec', 'April', 'Maj', 'Junij', 'Julij', 'Avgust', 'September', 'Oktober', 'November', 'December');
// The three letter month name
$months_abbr = array('Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Avg', 'Sep', 'Okt', 'Nov', 'Dec');

// All letters of the alphabet starting with A and ending with Z
$letters = array ('A', 'B', 'C', 'È', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'Š', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

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
$dates['header'] = '%A, %d %B, %Y';
// Jump box format on bottom of the schedule page
// This must only include %m %d %Y in the proper order,
//  other specifiers will be ignored and will corrupt the jump box 
$dates['jumpbox'] = '%d/%m/%Y';

/***
  STRING TRANSLATIONS
  All of these strings should be translated from the English value (right side of the equals sign) to the new language.
  - Please keep the keys (between the [] brackets) as they are.  The keys will not always be the same as the value.
  - Please keep the sprintf formatting (%s) placeholders where they are unless you are sure it needs to be moved.
  - Please keep the HTML and punctuation as-is unless you know that you want to change it.
***/
$strings['hours'] = 'ur';
$strings['minutes'] = 'minut';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = 'mm';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = 'dd';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = 'LLLL';
$strings['am'] = 'am';
$strings['pm'] = 'pm';

$strings['Administrator'] = 'Administrator';
$strings['Welcome Back'] = 'Pozdravljeni, %s';
$strings['Log Out'] = 'Odjavi se';
$strings['My Control Panel'] = 'Nadzorna plošèa';
$strings['Help'] = 'Pomoè';
$strings['Manage Schedules'] = 'Urejanje urnikov';
$strings['Manage Users'] ='Urejanje uporabnikov';
$strings['Manage Resources'] ='Urejanje sredstev';
$strings['Manage User Training'] ='Manage User Training';
$strings['Manage Reservations'] ='Urejanje rezervacij';
$strings['Email Users'] ='Email Users';
$strings['Export Database Data'] = 'Izvozite podatke iz podatkovne baze';
$strings['Reset Password'] = 'Reset Password';
$strings['System Administration'] = 'Administracija sistema';
$strings['Successful update'] = 'Uspešno spremenjeno';
$strings['Update failed!'] = 'Sprememba ni uspela!';
$strings['Manage Blackout Times'] = 'Upravljanje nerazpoložljivih terminov';
$strings['Forgot Password'] = 'Pozabil sem geslo';
$strings['Manage My Email Contacts'] = 'Upravljanje mojih email kontaktov';
$strings['Choose Date'] = 'Izberi datum';
$strings['Modify My Profile'] = 'Sprememba mojega profila';
$strings['Register'] = 'Registriraj se';
$strings['Processing Blackout'] = 'Processing Blackout';
$strings['Processing Reservation'] = 'Processing Reservation';
$strings['Online Scheduler [Read-only Mode]'] = 'Spletni urnik [Samo pogled]';
$strings['Online Scheduler'] = 'Spletni urnik';
$strings['phpScheduleIt Statistics'] = 'phpScheduleIt Statistike';
$strings['User Info'] = 'Informacije o uporabniku:';

$strings['Could not determine tool'] = 'Could not determine tool. Prosim vrnite se na nadzorno plošèo in poskusite kasneje.';
$strings['This is only accessable to the administrator'] = 'Dostop ima samo administrator';
$strings['Back to My Control Panel'] = 'Nazaj na nadzorno plošèo';
$strings['That schedule is not available.'] = 'Ta urnik ni dosegljiv.';
$strings['You did not select any schedules to delete.'] = 'Niste izbrali nobenega urnika za izbris.';
$strings['You did not select any members to delete.'] = 'Niste izbrali nobenega èlana za izbris.';
$strings['You did not select any resources to delete.'] = 'Nisite izbrali nobenih sredstev za izbris.';
$strings['Schedule title is required.'] = 'Potreben je naslov urnika.';
$strings['Invalid start/end times'] = 'Neveljavni zaèetek/konec èasi';
$strings['View days is required'] = 'View days is required';
$strings['Day offset is required'] = 'Day offset is required';
$strings['Admin email is required'] = 'Potreben je Admin email';
$strings['Resource name is required.'] = 'Potrebno je doloèiti ime sredstva.';
$strings['Valid schedule must be selected'] = 'Izbran mora biti veljaven urnik';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'Minimalen èas rezervacije mora biti manjši ali enak èasu maksimalne rezervacije.';
$strings['Your request was processed successfully.'] = 'Vaša zahteva je bila uspešno izvedena.';
$strings['Go back to system administration'] = 'Pojdite nazaj na administracijo sistema';
$strings['Or wait to be automatically redirected there.'] = 'Ali poèakajte, da boste avtomatièno preusmerjeni tja.';
$strings['There were problems processing your request.'] = 'So problemi z izvedbo vaše zahteve.';
$strings['Please go back and correct any errors.'] = 'Prosim pojdite nazaj in popravite kakršnekoli napake.';
$strings['Login to view details and place reservations'] = 'Prijavite se, da bi videli detajle in vpisali rezervacije';
$strings['Memberid is not available.'] = 'ID èlana: %s ni na razpolago.';

$strings['Schedule Title'] = 'Ime Urnika';
$strings['Start Time'] = 'Èas zaèetka';
$strings['End Time'] = 'Èas konca';
$strings['Time Span'] = 'Èasovna enota';
$strings['Weekday Start'] = 'Zaèetek tedna';
$strings['Admin Email'] = 'Email Administratorju';

$strings['Default'] = 'Privzeto';
$strings['Reset'] = 'Osveži';
$strings['Edit'] = 'Uredi';
$strings['Delete'] = 'Izbriši';
$strings['Cancel'] = 'Preklièi';
$strings['View'] = 'Poglej';
$strings['Modify'] = 'Spremeni';
$strings['Save'] = 'Shrani';
$strings['Back'] = 'Nazaj';
$strings['Next'] = 'Naprej';
$strings['Close Window'] = 'Zapri okno';
$strings['Search'] = 'Išèi';
$strings['Clear'] = 'Briši';

$strings['Days to Show'] = 'Prikazani dnevi';
$strings['Reservation Offset'] = 'Rezervacija najmanj dni pred';
$strings['Hidden'] = 'Skrito';
$strings['Show Summary'] = 'Prikaži povzetek';
$strings['Add Schedule'] = 'Dodaj urnik';
$strings['Edit Schedule'] = 'Uredi urnik';
$strings['No'] = 'Ne';
$strings['Yes'] = 'Da';
$strings['Name'] = 'Ime';
$strings['First Name'] = 'Ime';
$strings['Last Name'] = 'Priimek';
$strings['Resource Name'] = 'Ime sredstva';
$strings['Email'] = 'Email';
$strings['Institution'] = 'Institucija';
$strings['Phone'] = 'Telefon';
$strings['Password'] = 'Geslo';
$strings['Permissions'] = 'Dovoljenja';
$strings['View information about'] = 'Poglej informacije o %s %s';
$strings['Send email to'] = 'Pošlji email %s %s';
$strings['Reset password for'] = 'Novo geslo za %s %s';
$strings['Edit permissions for'] = 'Uredi dovoljenja za %s %s';
$strings['Position'] = 'Položaj';
$strings['Password (6 char min)'] = 'Geslo (%s èrk min)';	// @since 1.1.0
$strings['Re-Enter Password'] = 'Ponovno vpiši geslo';

$strings['Sort by descending last name'] = 'Razvrsti padajoèe po priimku';
$strings['Sort by descending email address'] = 'Razvrsti padajoèe po emailu';
$strings['Sort by descending institution'] = 'Razvrsti padajoèe po instituciji';
$strings['Sort by ascending last name'] = 'Razvrsti narašèajoèe po priimku';
$strings['Sort by ascending email address'] = 'Razvrsti narašèajoèe po emailu';
$strings['Sort by ascending institution'] = 'Razvrsti narašèajoèe po instituciji';
$strings['Sort by descending resource name'] = 'Razvrsti padajoèe po imenu sredstva';
$strings['Sort by descending location'] = 'Razvrsti padajoèe po naslovu';
$strings['Sort by descending schedule title'] = 'Razvrsti padajoèe po imenu urnika';
$strings['Sort by ascending resource name'] = 'Razvrsti narašèajoèe po imenu sredstva';
$strings['Sort by ascending location'] = 'Razvrsti narašèajoèe po naslovu';
$strings['Sort by ascending schedule title'] = 'Razvrsti narašèajoèe po imenu urnika';
$strings['Sort by descending date'] = 'Razvrsti padajoèe po datumu';
$strings['Sort by descending user name'] = 'Razvrsti padajoèe po uporabniškem imenu';
$strings['Sort by descending start time'] = 'Razvrsti padajoèe po èasu zaèetka';
$strings['Sort by descending end time'] = 'Razvrsti padajoèe po èasu konca';
$strings['Sort by ascending date'] = 'Razvrsti narašèajoèe po datumu';
$strings['Sort by ascending user name'] = 'Razvrsti narašèajoèe po uporabniškem imenu';
$strings['Sort by ascending start time'] = 'Razvrsti narašèajoèe po èasu zaèetka';
$strings['Sort by ascending end time'] = 'Razvrsti narašèajoèe po èasu konca';
$strings['Sort by descending created time'] = 'Razvrsti padajoèe po èasu vpisa';
$strings['Sort by ascending created time'] = 'Razvrsti narašèajoèe po èasu vpisa';
$strings['Sort by descending last modified time'] = 'Sort by descending last modified time';
$strings['Sort by ascending last modified time'] = 'Razvrsti narašèajoèe po zadnjem èasu spremembe';

$strings['Search Users'] = 'Poišèi uporabnike';
$strings['Location'] = 'Naslov';
$strings['Schedule'] = 'Urnik';
$strings['Phone'] = 'Telefon';
$strings['Notes'] = 'Beležka';
$strings['Status'] = 'Status';
$strings['All Schedules'] = 'Vsi urniki';
$strings['All Resources'] = 'Vsa sredstva';
$strings['All Users'] = 'Vsi uporabniki';

$strings['Edit data for'] = 'Uredi podatke za %s';
$strings['Active'] = 'Aktivno';
$strings['Inactive'] = 'Neaktivno';
$strings['Toggle this resource active/inactive'] = 'Doloèi to sredstvo kot aktivno/neaktivno';
$strings['Minimum Reservation Time'] = 'Minimalen èas rezervacije';
$strings['Maximum Reservation Time'] = 'Maximalen èas rezervacije';
$strings['Auto-assign permission'] = 'Avtomatièno dovoljenje';
$strings['Add Resource'] = 'Dodaj sredstvo';
$strings['Edit Resource'] = 'Uredi sredstvo';
$strings['Allowed'] = 'Dovoljeno';
$strings['Notify user'] = 'Obvesti uporabnika';
$strings['User Reservations'] = 'Rezervacije uporabnika';
$strings['Date'] = 'Datum';
$strings['User'] = 'Uporabnik';
$strings['Email Users'] = 'Pošlji email uporabnikom';
$strings['Subject'] = 'Zadeva';
$strings['Message'] = 'Sporoèilo';
$strings['Please select users'] = 'Prosim izberi uporabnike';
$strings['Send Email'] = 'Pošlji email';
$strings['problem sending email'] = '®al so problemi s pošiljanjem vašega emaila. Prosim poskusite kasneje.';
$strings['The email sent successfully.'] = 'Email je bil uspešno poslan.';
$strings['do not refresh page'] = 'Prosin <u>ne</u> osvežite te strani. Èe boste, bo email ponovno poslan.';
$strings['Return to email management'] = 'Vrni se na upravljanje E-sporoèil';
$strings['Please select which tables and fields to export'] = 'Prosim izberi tabele in polja za izvoz:';
$strings['all fields'] = '- vsa polja -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = 'Navaden tekst';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = 'Izvozi podatke';
$strings['Reset Password for'] = 'Ponovno geslo za %s';
$strings['Please edit your profile'] = 'Prosim uredi svoj profil';
$strings['Please register'] = 'Prosim registriraj se';
//$strings['Email address (this will be your login)'] = 'E-naslov (to bo vaše geslo)';
$strings['Keep me logged in'] = 'Drži me prijavljenega <br/>(Potrebni so cookie-ji)';
$strings['Edit Profile'] = 'Uredi profil';
$strings['Register'] = 'Registriraj se';
$strings['Please Log In'] = 'Prosim prijavite se';
$strings['Email address'] = 'E-naslov';
$strings['Password'] = 'Geslo';
$strings['First time user'] = 'Nov uporabnik?';
$strings['Click here to register'] = 'Klikni tukaj za registracijo';
$strings['Register for phpScheduleIt'] = 'Registriraj se za phpScheduleIt';
$strings['Log In'] = 'Prijavi se';
$strings['View Schedule'] = 'Poglej urnik';
$strings['View a read-only version of the schedule'] = 'Urnik samo za pogled';
$strings['I Forgot My Password'] = 'Pozabil sem svoje geslo';
$strings['Retreive lost password'] = 'Ponovno pridobi izgubljeno geslo';
$strings['Get online help'] = 'Pomoè na spletu';
$strings['Language'] = 'Jezik';
$strings['(Default)'] = '(Privzeto)';

$strings['My Announcements'] = 'Moja obvestila';
$strings['My Reservations'] = 'Moje rezervacije';
$strings['My Permissions'] = 'Moja dovoljenja';
$strings['My Quick Links'] = 'Moje hitre povezave';
$strings['Announcements as of'] = 'Obvestila za %s';
$strings['There are no announcements.'] = 'Tukaj ni obvestil.';
$strings['Resource'] = 'Sredstvo';
$strings['Created'] = 'Vpisano';
$strings['Last Modified'] = 'Nazadnje spremenjeno';
$strings['View this reservation'] = 'Poglej to rezervacijo';
$strings['Modify this reservation'] = 'Spremeni to rezervacijo';
$strings['Delete this reservation'] = 'Briši to rezervacijo';
$strings['Bookings'] = 'Rezervacije';											// @since 1.2.0
$strings['Change My Profile Information/Password'] = 'Spremeni profil';		// @since 1.2.0
$strings['Manage My Email Preferences'] = 'Email Nastavitve';				// @since 1.2.0
$strings['Mass Email Users'] = 'Skupinsko pošiljanje E-pošte uporabnikom';
$strings['Search Scheduled Resource Usage'] = 'Išèi Rezervacije';		// @since 1.2.0
$strings['Export Database Content'] = 'Izvozi vsebino podatkovne baze';
$strings['View System Stats'] = 'Poglej statistiko sistema';
$strings['Email Administrator'] = 'Pošlji Email Administratorju';

$strings['Email me when'] = 'Pošlji mi E-sporoèilo ko:';
$strings['I place a reservation'] = 'vpišem rezervacijo';
$strings['My reservation is modified'] = 'je moja rezervacija spremenjena';
$strings['My reservation is deleted'] = 'je moja rezervacija izbrisana';
$strings['I prefer'] = 'Prednost dajem:';
$strings['Your email preferences were successfully saved'] = 'Nastavitve vaše E-pošte so bile uspešno spremenjene!';
$strings['Return to My Control Panel'] = 'Vrni me na mojo nadzorno plošèo';

$strings['Please select the starting and ending times'] = 'Prosim izberi èas zaèetka in èas konca:';
$strings['Please change the starting and ending times'] = 'Prosim spremeni èas zaèetka in èas konca:';
$strings['Reserved time'] = 'Rezerviran èas:';
$strings['Minimum Reservation Length'] = 'Minimalen èas rezervacije:';
$strings['Maximum Reservation Length'] = 'Maximalen èas rezervacije:';
$strings['Reserved for'] = 'Rezervirano za:';
$strings['Will be reserved for'] = 'Rezervacija za:';
$strings['N/A'] = '02/4716156';
$strings['Update all recurring records in group'] = 'Posodobi vse ponavljajoèe se vpise v skupini?';
$strings['Delete?'] = 'Izbriši?';
$strings['Never'] = '-- Nikoli --';
$strings['Days'] = 'Dni';
$strings['Weeks'] = 'Tedne';
$strings['Months (date)'] = 'Mesece (datum)';
$strings['Months (day)'] = 'Mesece (dan)';
$strings['First Days'] = 'Prvi teden';
$strings['Second Days'] = 'Drugi teden';
$strings['Third Days'] = 'Tretji teden';
$strings['Fourth Days'] = 'Èetrti teden';
$strings['Last Days'] = 'Zadnji teden';
$strings['Repeat every'] = 'Ponovi vsake:';
$strings['Repeat on'] = 'Ponovi na:';
$strings['Repeat until date'] = 'Ponavljaj do datuma:';
$strings['Choose Date'] = 'Izberi';
$strings['Summary'] = 'Povzetek';

$strings['View schedule'] = 'Poglej urnik:';
$strings['My Reservations'] = 'Moje rezervacije';
$strings['My Past Reservations'] = 'Moje pretekle rezervacije';
$strings['Other Reservations'] = 'Druge rezervacije';
$strings['Other Past Reservations'] = 'Druge pretekle rezervacije';
$strings['Blacked Out Time'] = 'Nerazpoložljiv èas';
$strings['Set blackout times'] = 'Vstavi nerazpoložljiv èas za %s na %s'; 
$strings['Reserve on'] = 'Rezerviraj %s na %s';
$strings['Prev Week'] = '&laquo; Prejšnji teden';
$strings['Jump 1 week back'] = 'Skoèi 1 teden nazaj';
$strings['Prev days'] = '&#8249; Prejšnji %d dnevi';
$strings['Previous days'] = '&#8249; Prejšnji %d dnevi';
$strings['This Week'] = 'Sedanji teden';
$strings['Jump to this week'] = 'Skoèi na ta teden';
$strings['Next days'] = 'Naslednji %d dnevi &#8250;';
$strings['Next Week'] = 'Naslednji teden &raquo;';
$strings['Jump To Date'] = 'Skoèi na datum';
$strings['View Monthly Calendar'] = 'Poglej meseèni koledar';
$strings['Open up a navigational calendar'] = 'Odpri navigacijski koledar';

$strings['View stats for schedule'] = 'Poglej statistiko za urnik:';
$strings['At A Glance'] = 'Na pogled';
$strings['Total Users'] = 'Vsh uporabnikov:';
$strings['Total Resources'] = 'Vseh sredstev:';
$strings['Total Reservations'] = 'Vseh rezervacij:';
$strings['Max Reservation'] = 'Max rezervacija:';
$strings['Min Reservation'] = 'Min Rezervacija:';
$strings['Avg Reservation'] = 'Povpreèna rezervacija:';
$strings['Most Active Resource'] = 'Najaktivnejše sredstvo:';
$strings['Most Active User'] = 'Najaktivnejši uporabnik:';
$strings['System Stats'] = 'Statistika sistema';
$strings['phpScheduleIt version'] = 'phpScheduleIt verzija:';
$strings['Database backend'] = 'Database backend:';
$strings['Database name'] = 'Ime podatkovne baze:';
$strings['PHP version'] = 'PHP verzija:';
$strings['Server OS'] = 'Server OS:';
$strings['Server name'] = 'Ime serverja:';
$strings['phpScheduleIt root directory'] = 'phpScheduleIt korenski directorij:';
$strings['Using permissions'] = 'Using permissions:';
$strings['Using logging'] = 'Using logging:';
$strings['Log file'] = 'Log datoteka:';
$strings['Admin email address'] = 'E-poštni naslov administratorja:';
$strings['Tech email address'] = 'Tehnièni E-poštni naslov:';
$strings['CC email addresses'] = 'CC E-poštni naslov:';
$strings['Reservation start time'] = 'Zaèetni èas rezervacije:';
$strings['Reservation end time'] = 'Konèni èas rezervacijee:';
$strings['Days shown at a time'] = 'Prikaži dni naenkrat:';
$strings['Reservations'] = 'Rezervacije';
$strings['Return to top'] = 'Vrni na vrh';
$strings['for'] = 'za';

$strings['Select Search Criteria'] = 'Izberi kriterij za iskanje';
$strings['Schedules'] = 'Urniki:';
$strings['All Schedules'] = 'Vsi urniki';
$strings['Hold CTRL to select multiple'] = 'Drži CTRL, da jih izbereš veè';
$strings['Users'] = 'Uporabniki:';
$strings['All Users'] = 'Vsi uporabniki';
$strings['Resources'] = 'Sredstva';
$strings['All Resources'] = 'Vsa sredstva';
$strings['Starting Date'] = 'Datum zaèetka:';
$strings['Ending Date'] = 'Datum konca:';
$strings['Starting Time'] = 'Èas zaèetka:';
$strings['Ending Time'] = 'Èas konca:';
$strings['Output Type'] = 'Vrsta izpisa:';
$strings['Manage'] = 'Uredi';
$strings['Total Time'] = 'Skupen èas';
$strings['Total hours'] = 'Skupno ur:';
$strings['% of total resource time'] = '% of total resource time';
$strings['View these results as'] = 'Glej te rezultate kot:';
$strings['Edit this reservation'] = 'Uredi to rezervacijo';
$strings['Search Results'] = 'Išèi rezultate';
$strings['Search Resource Usage'] = 'Išèi uporabo po sredstvu';
$strings['Search Results found'] = 'Išèi rezultate: %d najdenih rezervacij';
$strings['Try a different search'] = 'Poskusi iskati drugaèe';
$strings['Search Run On'] = 'Išèi Run On:';
$strings['Member ID'] = 'ID èlana';
$strings['Previous User'] = '&laquo; Prejšnji uporabnik';
$strings['Next User'] = 'Naslednji uporabnik &raquo;';

$strings['No results'] = 'Ni rezultatov';
$strings['That record could not be found.'] = 'Vpisa ni bilo mogoère najti.';
$strings['This blackout is not recurring.'] = 'Ta vpis nerazpoložljivega èasa se ne ponavlja.';
$strings['This reservation is not recurring.'] = 'Ta rezervacija se ne  ponavlja.';
$strings['There are no records in the table.'] = 'Ni rezultatov v %s tabeli.';
$strings['You do not have any reservations scheduled.'] = 'Nobenih rezervacij nimate vpisanih.';
$strings['You do not have permission to use any resources.'] = 'Nimaš dovoljenja za uporabo kateregakoli sredstva.';
$strings['No resources in the database.'] = 'V podatkovni bazi ni sredstev.';
$strings['There was an error executing your query'] = 'Napaka pri izvedbi vaše poizvedbe:';

$strings['That cookie seems to be invalid'] = 'Izgleda da je ta kolaèek neveljaven';
$strings['We could not find that logon in our database.'] = 'We could not find that logon in our database.';	// @since 1.1.0
$strings['That password did not match the one in our database.'] = 'To geslo se ne ujema s tem v naši podatkovni bazi.';
$strings['You can try'] = '<br />Poskusite lahko:<br />Registrirati E-poštni naslov.<br />Ali:<br />Ponovno se prijaviti.';
$strings['A new user has been added'] = 'Dodan je bil nov uporabnik';
$strings['You have successfully registered'] = 'Uspešno ste se registrirali!';
$strings['Continue'] = 'Nadaljuj...';
$strings['Your profile has been successfully updated!'] = 'Vaš profil je bil uspešno obnovljen!';
$strings['Please return to My Control Panel'] = 'Prosim vrni me na mojo nadzorno plošèo';
$strings['Valid email address is required.'] = '- Potreben je veljaven E-naslov.';
$strings['First name is required.'] = '- Potrebno je ime.';
$strings['Last name is required.'] = '- Potreben je priimek.';
$strings['Phone number is required.'] = '- Potrebna je telefonska številka.';
$strings['That email is taken already.'] = '- Ta E-naslov je že zaseden.<br />Prosim poskusite ponovno z drugim E-poštnim naslovom.';
$strings['Min 6 character password is required.'] = '- Geslo mora vsebovati min %s znakov.';
$strings['Passwords do not match.'] = '- Gesli se ne ujemata.';

$strings['Per page'] = 'Na stran:';
$strings['Page'] = 'Stran:';

$strings['Your reservation was successfully created'] = 'Vaša rezervacija je bila uspešno vpisana';
$strings['Your reservation was successfully modified'] = 'Vaša rezervacija je bila uspešno spremenjena';
$strings['Your reservation was successfully deleted'] = 'Vaša rezervacija je bila uspešno izbrisana';
$strings['Your blackout was successfully created'] = 'Vaš nerazpoložljiv èas je bil uspešno vpisan';
$strings['Your blackout was successfully modified'] = 'Vaš nerazpoložljiv èas je bil uspešno spremenjen';
$strings['Your blackout was successfully deleted'] = 'Vaš nerazpoložljiv èas je bil uspešno izbrisan';
$strings['for the follwing dates'] = 'za sledeèe datume:';
$strings['Start time must be less than end time'] = 'Zaèetni èas mora biti manjši od konènega.';
$strings['Current start time is'] = 'Zdajšnji zaèetni èas je:';
$strings['Current end time is'] = 'Zdajšnji konèni èas je:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'Dolžina rezervacije presega dovoljeno mejo tega sredstva.';
$strings['Your reservation is'] = 'Vaša rezervacija je:';
$strings['Minimum reservation length'] = 'Minimalna dolžina rezervacije:';
$strings['Maximum reservation length'] = 'Maksimalna dolžina rezervacije:';
$strings['You do not have permission to use this resource.'] = 'Nimate dovoljenja za uporabo tega sredstva.';
$strings['reserved or unavailable'] = '%s do %s je rezerviran ali nerazpoložljiv.';	// @since 1.1.0
$strings['Reservation created for'] = 'Rezervacija vpisana za %s';
$strings['Reservation modified for'] = 'Rezervacija spremenjena za %s';
$strings['Reservation deleted for'] = 'Rezervacija izbrisana za %s';
$strings['created'] = 'vpisali';
$strings['modified'] = 'spremenjeno';
$strings['deleted'] = 'izbrisano';
$strings['Reservation #'] = 'Rezervacija #';
$strings['Contact'] = 'Kontakt';
$strings['Reservation created'] = 'Rezervacija ustvarjena';
$strings['Reservation modified'] = 'Rezervacija spremenjena';
$strings['Reservation deleted'] = 'Reservation izbrisana';

$strings['Reservations by month'] = 'Rezervacije po mesecu';
$strings['Reservations by day of the week'] = 'Rezervacije po dnevu v tednu';
$strings['Reservations per month'] = 'Rezervacij na mesec';
$strings['Reservations per user'] = 'Rezervacij na uporabnika';
$strings['Reservations per resource'] = 'Rezervacij po sredstvu';
$strings['Reservations per start time'] = 'Rezervacije po zaèetnem èasu';
$strings['Reservations per end time'] = 'Rezervacije po konènem èasu';
$strings['[All Reservations]'] = '[Vse rezervacije]';

$strings['Permissions Updated'] = 'Dovoljenja obnovljena';
$strings['Your permissions have been updated'] = 'Vaša %s dovoljenja so bila obnovljena';
$strings['You now do not have permission to use any resources.'] = 'Nimate dovoljenja za uporabo sredstva.';
$strings['You now have permission to use the following resources'] = 'Sedaj imate dovoljenje za uporabo sledeèih sredstev:';
$strings['Please contact with any questions.'] = 'Prosim kontaktiraj %s, èe imate kakršnakoli vprašanja.';
$strings['Password Reset'] = 'Ponovno pridobi geslo';

$strings['This will change your password to a new, randomly generated one.'] = 'To bo spremenilo vaše geslo v novo, nakljuèno pridobljeno geslo.';
$strings['your new password will be set'] = 'Po vpisu vašega E-naslova in po kliku na "Spremeni geslo", bo vaše novo geslo vstavljeno v sistem in poslano na vaš E-poštni naslov.';
$strings['Change Password'] = 'Spremeni geslo';
$strings['Sorry, we could not find that user in the database.'] = '®al nismo našli tega uporabnika v podatkovni bazi.';
$strings['Your New Password'] = 'Vaše novo %s geslo';
$strings['Your new passsword has been emailed to you.'] = 'Uspešno opravljeno!<br />'
    			. 'Vaše novo geslo vam je bilo poslano po E-pošti.<br />'
    			. 'Prosim preverite svojo E-pošto in se <a href="index.php">prijavite</a>'
    			. ' s tem novim geslom in ga nemudoma spremenite s klikom na &quot;Change My Profile Information/Password&quot;'
    			. ' link in My Control Panel.';

$strings['You are not logged in!'] = 'You are not logged in!';

$strings['Setup'] = 'Setup';
$strings['Please log into your database'] = 'Please log into your database';
$strings['Enter database root username'] = 'Enter database root username:';
$strings['Enter database root password'] = 'Enter database root password:';
$strings['Login to database'] = 'Login to database';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = 'Korenski uporabnik <b>ni</b> zahtevan. Sprejemljiv je katerikoli uporabnik, ki ima dovoljenje za ustvarjanje tabelRoot user is <b>not</b> required. Any database user who has permission to create tables is acceptable.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = 'To bo instaliralo vse potrebne podatkovne baze in tabele za phpScheduleIt.';
$strings['It also populates any required tables.'] = 'It also populates any required tables.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = 'Opozorilo: TO BO IZBRISALO VSE PODATKE V PREJŠNJIH phpScheduleIt PODATKOVNIH BAZAH!';
$strings['Not a valid database type in the config.php file.'] = 'Neveljaven tip podatkovne baze v config.php datoteki.';
$strings['Database user password is not set in the config.php file.'] = 'Uporabniško geslo podatkovne baze v config.php datoteki ni vpisano.';
$strings['Database name not set in the config.php file.'] = 'Ime podatkovne baze v config.php datoteki ni vpisano.';
$strings['Successfully connected as'] = 'Uspešno povezano kot';
$strings['Create tables'] = 'Ustvari tabele &gt;';
$strings['There were errors during the install.'] = 'Med instalacijo so bile napake. Lahko da bo phpScheduleIt še vedno deloval, èe so bile napake manj pomembne.<br/><br/>'
	. 'Prosim naslovite kakršnakoli vprašanja na forum na <a href="http://sourceforge.net/forum/?group_id=95547">SourceForge</a>.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = 'Uspešno ste konèali instalacijo phpScheduleIt in ste pripravljeni na uporabo.';
$strings['Thank you for using phpScheduleIt'] = 'Prosim ne pozabite POPOLNOMA ODSTRANITI \'install\' DIREKTORIJ.'
	. ' To je bistvenega pomena, kajti vsebuje gesla podatkovne baze in druge obèutljive informacije.'
	. ' Èe tega ne napravite, so vrata odprta za kogarkoli, ki želi vstopiti v vašo podatkovno bazo!'
	. '<br /><br />'
	. 'Hvala za uporabo programa phpScheduleIt!';
//$strings['This will update your version of phpScheduleIt from 0.9.3 to 1.0.0.'] = 'To bo nadgradilo vašo verzijo phpScheduleIt z 0.9.3 na 1.0.0.';
$strings['There is no way to undo this action'] = 'Ni naèina za povrnitev tega dejanja!';
$strings['Click to proceed'] = 'Klikni za nadaljevanje';
//$strings['This version has already been upgraded to 1.0.0.'] = 'Ta verzija je že bila nadgrajena na 1.0.0.';
$strings['Please delete this file.'] = 'Prosim izbriši to datoteko.';
$strings['Successful update'] = 'Posodobitev je v popolnosti uspela';
$strings['Patch completed successfully'] = 'Popravek uspešno izveden';
//$strings['This will populate the required fields for phpScheduleIt 1.0.0 and patch a data bug in 0.9.9.'] = 'To bo ustvarilo potrebna polja za phpScheduleIt 1.0.0 in popravilo napake iz 0.9.9.'
//		. '<br />To je potrebno samo, èe ste roèno posodobili SQL ali nadgrajujete iz verzije 0.9.9';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = 'Èe ni doloèena nobena vrednost, potem bo uporabljeno privzeto geslo iz datoteke config.php.';
$strings['Notify user that password has been changed?'] = 'Obvesti uporabnika, da je bilo geslo spremenjeno?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'Ta sistem zahteva, da imate E-poštni naslov.';
$strings['Invalid User Name/Password.'] = 'Neveljavno uporabniško ime/geslo.';
$strings['Pending User Reservations'] = 'Viseèe rezervacije uporabnikov';
$strings['Approve'] = 'Approve';
$strings['Approve this reservation'] = 'Odobri to rezervacijo';
$strings['Approve Reservations'] ='Odobri rezervacije';

$strings['Announcement'] = 'Obvestilo';
$strings['Number'] = 'Številka';
$strings['Add Announcement'] = 'Dodaj obvestilo';
$strings['Edit Announcement'] = 'Uredi obvestilo';
$strings['All Announcements'] = 'Vsa obvestila';
$strings['Delete Announcements'] = 'Izbriši obvestila';
$strings['Use start date/time?'] = 'Uporabi zaèeten datum/èas?';
$strings['Use end date/time?'] = 'Uporabi konèen datum/èas?';
$strings['Announcement text is required.'] = 'Zahtevan je tekst obvestila.';
$strings['Announcement number is required.'] = 'Zahtevana je številka obvestila.';


$strings['Pending Approval'] = 'Odobritev viseèih rezervacij';
$strings['My reservation is approved'] = 'je moja rezervacija odobrena';
$strings['This reservation must be approved by the administrator.'] = 'Ta rezervacija mora biti odobrena od administratorja.';
$strings['Approval Required'] = 'Zahtevana odobritev';
$strings['No reservations requiring approval'] = 'Nobena rezervacija ne potrebuje odobritve';
$strings['Your reservation was successfully approved'] = 'Vaše rezervacije so bile uspešno odobrene';
$strings['Reservation approved for'] = 'Rezervacija odobrena za %s';
$strings['approved'] = 'odobreno';
$strings['Reservation approved'] = 'Rezervacija odobrena';

$strings['Valid username is required'] = 'Potrebno je veljavno uporabniško ime';
$strings['That logon name is taken already.'] = 'To uporabniško ime je že zavzeto.';
$strings['this will be your login'] = '(to bo vaše geslo)';
$strings['Logon name'] = 'Uporabniško ime';
$strings['Your logon name is'] = 'Vaše uporabniško ime je %s';

$strings['Start'] = 'Zaèetek';
$strings['End'] = 'Konec';
$strings['Start date must be less than or equal to end date'] = 'Zaèetni datum mora biti manjši ali enak konènemu datumu';
$strings['That starting date has already passed'] = 'Ta zaèeten datum je že minil';
$strings['Basic'] = 'Osnovno';
$strings['Participants'] = 'Udeleženci';
$strings['Close'] = 'Zapri';
$strings['Start Date'] = 'Datum zaèetka';
$strings['End Date'] = 'Datum konca';
$strings['Minimum'] = 'Minimum';
$strings['Maximum'] = 'Maksimum';
$strings['Allow Multiple Day Reservations'] = 'Dovoli veèdnevne rezervacije';
$strings['Invited Users'] = 'Povabljeni uporabniki';
$strings['Invite Users'] = 'Povabi uporabnike';
$strings['Remove Participants'] = 'Odstrani udeležence';
$strings['Reservation Invitation'] = 'Povabilo k rezervaciji';
$strings['Manage Invites'] = 'Uredi povabila';
$strings['No invite was selected'] = 'Nobeno povabilo ni bilo izbrano';
$strings['reservation accepted'] = '%s Accepted Your Invitation on %s';
$strings['reservation declined'] = '%s Declined Your Invitation on %s';
$strings['Login to manage all of your invitiations'] = 'Prijavite se, da bi lahko urejali svoja povabila';
$strings['Reservation Participation Change'] = 'Spremeni udeležence rezervacije';
$strings['My Invitations'] = 'Moja povabila';
$strings['Accept'] = 'Sprejmi';
$strings['Decline'] = 'Odkloni';
$strings['Accept or decline this reservation'] = 'Sprejmi ali odkloni to rezervacijo';
$strings['My Reservation Participation'] = 'Moja udeležba pri rezervacijah';
$strings['End Participation'] = 'Odstrani udeležbo';
$strings['Owner'] = 'Lastnik';
$strings['Particpating Users'] = 'Potrjeni udeleženci';
$strings['No advanced options available'] = 'Napredne možnosti niso na voljo';
$strings['Confirm reservation participation'] = 'Potrdi udeležbo pri rezervaciji';
$strings['Confirm'] = 'Potrdi';
$strings['Do for all reservations in the group?'] = 'Za vse rezervacije v skupini?';

$strings['My Calendar'] = 'Moj koledar';
$strings['View My Calendar'] = 'Poglej moj koledar';
$strings['Participant'] = 'Udeleženec';
$strings['Recurring'] = 'Ponavljajoèe';
$strings['Multiple Day'] = 'Veè dni';
$strings['[today]'] = '[danes]';
$strings['Day View'] = 'Dnevni pogled';
$strings['Week View'] = 'Tedenski pogled';
$strings['Month View'] = 'Meseèni pogled';
$strings['Resource Calendar'] = 'Koledar sredstev';
$strings['View Resource Calendar'] = 'Urnik - Koledar';	// @since 1.2.0
$strings['Signup View'] = 'Signup View';

$strings['Select User'] = 'Izberi uporabnika';
$strings['Change'] = 'Spremeni';

$strings['Update'] = 'Posodobi';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'phpScheduleIt Nadgradnja je na voljo samo verzijo za 1.0.0 ali poznejšo';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt - to je najnovejša razlièica';
$strings['Migrating reservations'] = 'Preseli rezervacije';

$strings['Admin'] = 'Admin';
$strings['Manage Announcements'] = 'Uredi obvestila';
$strings['There are no announcements'] = 'Ni obvestil';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = 'Maksimalna kapaciteta udeležencev';
$strings['Leave blank for unlimited'] = 'Pusti prazno za neskonèno';
$strings['Maximum of participants'] = 'Maksimalna kapaciteta tega sredstva je %s udeležencev';
$strings['That reservation is at full capacity.'] = 'Ta rezervacija je zasedena.';
$strings['Allow registered users to join?'] = 'Dovoli registriranim uporabnikom, da se pridružijo?';
$strings['Allow non-registered users to join?'] = 'Dovoli ne-registriranim uporabnikom, da se pridružijo?';
$strings['Join'] = 'Pridruži se';
$strings['My Participation Options'] = 'Možnosti za moje sodelovanje';
$strings['Join Reservation'] = 'Pridruži se Rezervaciji';
$strings['Join All Recurring'] = 'Pridruži se vsem ponavljajoèim';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = 'Ne sodeluješ pri sledeèih rezervacijah, ker so polno zasedene.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = 'K tej rezervaciji si že povabljen. Prosim sledi navodilom za sodelovanje pri rezervaciji, ki so bila poslana na tvoj email.';
$strings['Additional Tools'] = 'Dodatna Orodja';
$strings['Create User'] = 'Ustvari Uporabnika';
$strings['Check Availability'] = 'Preveri Zasedenost';
$strings['Manage Additional Resources'] = 'Urejanje dodatnih Sredstev';
$strings['All Additional Resources'] = 'Vsa dodatna Sredstva';
$strings['Number Available'] = 'Številka je na voljo';
$strings['Unlimited'] = 'Neomejeno';
$strings['Add Additional Resource'] = 'Dodaj dodatno Sredstvo';
$strings['Edit Additional Resource'] = 'Uredi dodatno Sredstvo';
$strings['Checking'] = 'Preveri';
$strings['You did not select anything to delete.'] = 'Nièesar nisi izbral za izbris.';
$strings['Added Resources'] = 'Dodana Sredstva';
$strings['Additional resource is reserved'] = 'Dodatno sredstvo %s ima na voljo samo %s ';
$strings['All Groups'] = 'Vse Skupine';
$strings['Group Name'] = 'Ime Skupine';
$strings['Delete Groups'] = 'Izbriši Skupino';
$strings['Manage Groups'] = 'Urejanje Skupin';
$strings['None'] = 'Nobena';
$strings['Group name is required.'] = 'Potrebno je ime Skupine.';
$strings['Groups'] = 'Skupine';
$strings['Current Groups'] = 'Tekoèe Skupine';
$strings['Group Administration'] = 'Administracija Skupine';
$strings['Reminder Subject'] = 'Opomnik rezervacije- %s, %s %s';
$strings['Reminder'] = 'Opomnik';
$strings['before reservation'] = 'pred rezervacijo';
$strings['My Participation'] = 'Moja udeležba';
$strings['My Past Participation'] = 'Moja pretekla udeležba';
$strings['Timezone'] = 'Èasovni pas';
$strings['Export'] = 'Izvozi';
$strings['Select reservations to export'] = 'Izberi rezervacije za Izvoz';
$strings['Export Format'] = 'Format za Izvoz';
$strings['This resource cannot be reserved less than x hours in advance'] = 'To sredstvo ne more biti rezervirano manj kot %s ur v naprej';
$strings['This resource cannot be reserved more than x hours in advance'] = 'To sredstvo ne more biti rezervirano veè kot %s ur v naprej';
$strings['Minimum Booking Notice'] = 'Minimalna Opomba za Rezervacijo';
$strings['Maximum Booking Notice'] = 'Maksimalna Opomba za Rezervacijo';
$strings['hours prior to the start time'] = 'ur pred èasom zaèetka';
$strings['hours from the current time'] = 'ur od tega trenutka';
$strings['Contains'] = 'Vsebuje';
$strings['Begins with'] = 'Se zaène z';
$strings['Minimum booking notice is required.'] = 'Potrebna je minimalna opomba za to rezervacijo.';
$strings['Maximum booking notice is required.'] = 'Potrebna je maximalna opomba za to rezervacijo.';
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
				. "Uspešno ste se registrirali s sledeèimi informacijami:\r\n"
				. "Prijava: %s\r\n"
				. "Ime: %s %s \r\n"
				. "Telefon: %s \r\n"
				. "Institucija: %s \r\n"
				. "Položaj: %s \r\n\r\n"
				. "Prosim prijavite se v urnik na sledeèem naslovu:\r\n"
				. "%s \r\n\r\n"
				. "Povezave za spletni urnik in urejanje svojega profila lahko najdeš v Nadzorni plošèi.\r\n\r\n"
				. "Prosim naslovite vsa vprašanja v zvezi z rezervacijami na %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "Administrator,\r\n\r\n"
					. "Nov uporabnik se je registriral s sledeèimi informacijami:\r\n"
					. "E-naslov: %s \r\n"
					. "Ime: %s %s \r\n"
					. "Telefon: %s \r\n"
					. "Institutcija: %s \r\n"
					. "Položaj: %s \r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "uspešno ste %s rezervacijo #%s.\r\n\r\n<br/><br/>"
			. "Prosim uporabite številko te rezervacije, ko s kakršnimi koli vprašanji kontaktirate administratorja.\r\n\r\n<br/><br/>"
			. "Rezervacija je bila vpisana med %s %s in %s %s za %s"
			. " na lokaciji %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "Ta rezervacija je bila ponovljena na sledeèe datume:\r\n<br/>";
$email['reservation_activity_3'] = "Vse ponavljajoèe se rezervacije v tej skupini so bile tudi %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "Za to rezervacijo je bil napravljen sledeè povzetek:\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "Èe je to napaka, prosim kontaktirajte administratorja na: %s"
			. " ali po telefonu: %s.\r\n\r\n<br/><br/>"
			. "Informacije glede svoje rezervacijo lahko vidite kadarkoli, tako da se"
			. " prijavite v %s tukaj:\r\n<br/>"
			. "<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "Vsa tehnièna vprašanja prosim naslovite na <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
			. "Rezervacija #%s je bila odobrena.\r\n\r\n<br/><br/>"
			. "Prosim uporabite številko te rezervacije, ko s kakršnimi koli vprašanji kontaktirate administratorja.\r\n\r\n<br/><br/>"
			. "Rezervacija med %s %s in %s %s za %s"
			. " v %s je bila vpisana.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "Vaše %s geslo je bilo obnovljeno s strani administratorja.\r\n\r\n"
			. "Vaše zaèasno geslo je:\r\n\r\n %s\r\n\r\n"
			. "Prosim uporabite to zaèasno geslo (kopiraj in prilepi, da boš siguren v pravilnost) za prijavo v %s na %s"
			. " in ga nemudoma spremeni z uporabo 'Spremeni informacije mojega profila/gesla' povezave v Moje hitre povezave tabeli.\r\n\r\n"
			. "Prosim kontaktirajte %s , èe imate kakršnakoli vprašanja.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n"
            . "Vaše novo geslo za vaš %s raèun je:\r\n\r\n"
            . "%s\r\n\r\n"
            . "Prosim prijavite se tukaj: %s "
            . "s tem novim geslom "
            . "(kopiraj in prilepi, da bo sigurno pravilno) "
            . "in nemudoma spremenite svoje geslo s klikom na "
            . "Spremeni informacije mojega profila/gesla "
            . "povezava na mojo nadzorno plošèo.\r\n\r\n"
            . "Prosim naslovite kakršnakoli vprašanja na %s.";

// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s vas je povabil/a k sledeèi rezervaciji:\r\n\r\n"
		. "Sredstvo: %s\r\n"
		. "Datum zaèetka: %s\r\n"
		. "Èas zaèetka: %s\r\n"
		. "Datum konca: %s\r\n"
		. "Èas konca: %s\r\n"
		. "Povzetek: %s\r\n"
		. "Ponavljajoèi se datumi (èe so kakšni): %s\r\n\r\n"
		. "Da bi sprejeli to povabilo, kliknite sledeèo povezavo (kopiraj in prilepi, èe ni obarvana) %s\r\n"
		. "Da bi zavrnili to povabilo, kliknite to povezavo (kopiraj in prilepi, èe ni obarvana) %s\r\n"
		. "Da bi sprejeli izbrane datume ali uredili svoja povabila pozneje, se prosim prijavite v %s na %s";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "Bili ste izbrisani iz sledeèe rezervacije:\r\n\r\n"
		. "Sredstvo: %s\r\n"
		. "Datum zaèetka: %s\r\n"
		. "Èas zaèetka: %s\r\n"
		. "Datum konca: %s\r\n"
		. "Èas konca: %s\r\n"
		. "Povzetek: %s\r\n"
		. "Ponavljajoèi se datumi (èe so kakšni): %s\r\n\r\n";
		
// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "Približuje se tvoja rezervacija za %s od %s %s do %s %s .";
?>
