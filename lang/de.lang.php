<?php
/**
* German (de) translation file.
*
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Ilja Kogan <ilja@kogan-family.de>
* @translator Anna <majestic_12@users.sourceforge.net>
* @translator Stephan �stephan.tillmanns@online.de>
* @version 04-16-07
* @package Languages
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
///////////////////////////////////////////////////////////
// INSTRUCTIONS
///////////////////////////////////////////////////////////
// This file contains all of the strings that are used throughout phpScheduleit.
//
// To make phpScheduleIt available in another language, simply translate each
//  of the following strings into the appropriate one for the language.  Please be sure
//  to make the proper additions the /config/langs.php file (instructions are in the file).
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
$days_full = array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag');
// The three letter abbreviation - Weil das auf Deutsch nicht existiert: ebenfalls nur zwei Buchstaben!
$days_abbr = array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa');
// The two letter abbreviation
$days_two  = array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa');
// The one letter abbreviation
$days_letter = array('S', 'M', 'D', 'M', 'D', 'F', 'S');


/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('Januar', 'Februar', 'M�rz', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');
// The three letter month name
$months_abbr = array('Jan', 'Feb', 'M�r', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez');

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
$dates['header'] = '%A, %d. %B, %Y';
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
$strings['hours'] = 'Stunden';
$strings['minutes'] = 'Minuten';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = 'MM';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = 'TT';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = 'JJJJ';
$strings['am'] = 'am';
$strings['pm'] = 'pm';
$strings['Administrator'] = 'Administrator';
$strings['Welcome Back'] = 'Willkommen Zur�ck, %s';
$strings['Log Out'] = 'Abmelden';
$strings['My Control Panel'] = 'Kontrolpanel';
$strings['Help'] = 'Hilfe';
$strings['Manage Schedules'] = 'Zeitplanverwaltung';
$strings['Manage Users'] ='Benutzerverwaltung';
$strings['Manage Resources'] ='Ressourcenverwaltung';
$strings['Manage User Training'] ='Benutzer-Trainingsverwaltung';
$strings['Manage Reservations'] ='Reservierungsverwaltung';
$strings['Email Users'] ='Einem Benutzer E-Mail schreiben';
$strings['Export Database Data'] = 'Datenbank Daten exportieren';
$strings['Reset Password'] = 'Passwort zur�cksetzen';
$strings['System Administration'] = 'System Administration';
$strings['Successful update'] = 'Update erfolgreich';
$strings['Update failed!'] = 'Update fehlgeschlagen!';
$strings['Manage Blackout Times'] = 'Blockzeitenverwaltung';
$strings['Forgot Password'] = 'Passwort vergessen';
$strings['Manage My Email Contacts'] = 'E-Mail-Kontakt Verwaltung';
$strings['Choose Date'] = 'Datum w�hlen';
$strings['Modify My Profile'] = 'Mein Profil �ndern';
$strings['Register'] = 'Registrierung';
$strings['Processing Blackout'] = 'Block abwickeln';
$strings['Processing Reservation'] = 'Reservierung abwickeln';
$strings['Online Scheduler [Read-only Mode]'] = 'Online Zeitplan [Nur-Lese-Modus]';
$strings['Online Scheduler'] = 'Online Zeitplan';
$strings['phpScheduleIt Statistics'] = 'phpScheduleIt Statistiken';
$strings['User Info'] = 'Benutzer Info:';

$strings['Could not determine tool'] = 'Das Werkzeug konnte nicht ermittelt werden. Bitte kehren Sie zur�ck zum Kontrolpanel und versuchen Sie es sp�ter nocheinmal.';
$strings['This is only accessable to the administrator'] = 'Hier ist der Zugriff nur dem Administrator gestattet.';
$strings['Back to My Control Panel'] = 'Zur�ck zum Kontrolpanel';
$strings['That schedule is not available.'] = 'Dieser Zeitplan ist nicht verf�gbar.';
$strings['You did not select any schedules to delete.'] = 'Sie haben keine Zeitpl�ne zum l�schen ausgew�hlt.';
$strings['You did not select any members to delete.'] = 'Sie haben keine Benutzer zum L�schen ausgew�hlt.';
$strings['You did not select any resources to delete.'] = 'Sie haben keine Ressourcen zum L�schen ausgew�hlt.';
$strings['Schedule title is required.'] = 'Ein Zeitplantitel wird ben�tigt.';
$strings['Invalid start/end times'] = 'Ung�ltige Start/End Zeiten';
$strings['View days is required'] = 'Tage Anzeigen wird ben�tigt';
$strings['Day offset is required'] = 'Day offset wird ben�tigt';
$strings['Admin email is required'] = 'Admininstrator E-mail wird ben�tigt';
$strings['Resource name is required.'] = 'Ressourcen Name wird ben�tigt.';
$strings['Valid schedule must be selected'] = 'G�ltiger Zeitplan muss ausgew�hlt werden.';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'Minimale Reservierungsdauer muss kleiner als oder gleich gross wie die maximale Reservierungsdauer sein.';
$strings['Your request was processed successfully.'] = 'Ihre Anfrage wurde erfolgreich weitergeleitet.';
$strings['Go back to system administration'] = 'Zur�ck zur System Administration';
$strings['Or wait to be automatically redirected there.'] = 'Oder  auf die automatische Weiterleitung warten.';
$strings['There were problems processing your request.'] = 'Es gab Probleme beim Weiterleiten Ihrer Anfrage.';
$strings['Please go back and correct any errors.'] = 'Bitte kehren Sie zur�ck und korrigieren Sie alle Fehler.';
$strings['Login to view details and place reservations'] = 'Loggen Sie sich ein um Details zu sehen und Reservierungen zu erstellen.';
$strings['Memberid is not available.'] = 'BenutzerID: %s ist nicht verf�gbar.';


$strings['Schedule Title'] = 'Zeitplantitel';
$strings['Start Time'] = 'Start Zeit';
$strings['End Time'] = 'End Zeit';
$strings['Time Span'] = 'Zeitspanne';
$strings['Weekday Start'] = 'Wochentag Start';
$strings['Admin Email'] = 'Administrator E-mail';

$strings['Default'] = 'Vorgabe';
$strings['Reset'] = 'Zur�cksetzen';
$strings['Edit'] = 'Bearbeiten';
$strings['Delete'] = 'L�schen';
$strings['Cancel'] = 'Abbrechen';
$strings['View'] = 'Anschauen';
$strings['Modify'] = 'Ver�ndern';
$strings['Save'] = 'Speichern';
$strings['Back'] = 'Zur�ck';
$strings['Next'] = 'N�chste';
$strings['Close Window'] = 'Fenster schlie�en';
$strings['Search'] = 'Suchen';
$strings['Clear'] = 'S�ubern';


$strings['Days to Show'] = 'Tage anzeigen';
$strings['Reservation Offset'] = 'Reservation Offset';
$strings['Hidden'] = 'Versteckt';
$strings['Show Summary'] = 'Zusammenfassung anzeigen';
$strings['Add Schedule'] = 'Zeitplan hinzuf�gen';
$strings['Edit Schedule'] = 'Zeitplan bearbeiten';
$strings['No'] = 'Nein';
$strings['Yes'] = 'Ja';
$strings['Name'] = 'Name';
$strings['First Name'] = 'Vorname';
$strings['Last Name'] = 'Nachname';
$strings['Resource Name'] = 'Ressourcen Name';
$strings['Email'] = 'E-Mail';
$strings['Institution'] = 'Institution';
$strings['Phone'] = 'Telefon';
$strings['Password'] = 'Passwort';
$strings['Permissions'] = 'Rechte';
$strings['View information about'] = 'Anschauen von Informationen �ber %s %s';
$strings['Send email to'] = 'Senden einer E-Mail an %s %s';
$strings['Reset password for'] = 'Passwort zur�cksetzen f�r %s %s';
$strings['Edit permissions for'] = 'Rechte bearbeiten f�r %s %s';
$strings['Position'] = 'Stellung';
$strings['Password (6 char min)'] = 'Passwort (Mind. %s Zeichen)';
$strings['Re-Enter Password'] = 'Passwort wiederholen';

$strings['Sort by descending last name'] = 'Absteigend nach Nachnamen sortieren';
$strings['Sort by descending email address'] = 'Absteigund nach E-Mail Adresse sortieren';
$strings['Sort by descending institution'] = 'Absteigend nach Instutition sortieren';
$strings['Sort by ascending last name'] = 'Aufsteigend nach Nachnamen sortieren';
$strings['Sort by ascending email address'] = 'Aufsteigend nach E-Mail Adresse sortieren';
$strings['Sort by ascending institution'] = 'Aufsteigend nach Instution sortieren';
$strings['Sort by descending resource name'] = 'Absteigend nach Ressource Namen sortieren';
$strings['Sort by descending location'] = 'Absteigend nach Ort sortieren';
$strings['Sort by descending schedule title'] = 'Absteidgend nach Zeiplan-Titel sortieren';
$strings['Sort by ascending resource name'] = 'Aufsteigend nach Ressource Namen sortieren';
$strings['Sort by ascending location'] = 'Aufsteigend nach Ort sortieren';
$strings['Sort by ascending schedule title'] = 'Austeigend nach Zeitplan-Titel sortieren';
$strings['Sort by descending date'] = 'Absteigend nach Datum sortieren';
$strings['Sort by descending user name'] = 'Absteigend nach Benutzer-Namen sortieren';
$strings['Sort by descending start time'] = 'Absteigend nach Startzeit sortieren';
$strings['Sort by descending end time'] = 'Absteigend nach Endzeit sortieren';
$strings['Sort by ascending date'] = 'Aufsteigend nach Datum sortieren';
$strings['Sort by ascending user name'] = 'Aufsteigend nach Benutzernamen sortieren';
$strings['Sort by ascending start time'] = 'Aufsteigend nach Start Zeit sortieren';
$strings['Sort by ascending end time'] = 'Aufsteigend nach End Zeit sortieren';
$strings['Sort by descending created time'] = 'Absteigend nach Erstellungszeit sortieren';
$strings['Sort by ascending created time'] = 'Aufsteigend nach Erstellungszeit sortieren';
$strings['Sort by descending last modified time'] = 'Absteigend nach letzter �ndererung sortieren';
$strings['Sort by ascending last modified time'] = 'Aufsteigend nach letzter �ndererung sortieren';

$strings['Search Users'] = 'Benutzer suchen';
$strings['Location'] = 'Ort';
$strings['Schedule'] = 'Zeiptlan';
$strings['Phone'] = 'Telefon';
$strings['Notes'] = 'Bemerkungen';
$strings['Status'] = 'Status';
$strings['All Schedules'] = 'Alle Zeitpl�ne';
$strings['All Resources'] = 'Alle Ressourcen';
$strings['All Users'] = 'Alle Benutzer';

$strings['Edit data for'] = 'Bearbeiten der Daten f�r %s';
$strings['Active'] = 'Aktiv';
$strings['Inactive'] = 'Inaktiv';
$strings['Toggle this resource active/inactive'] = 'Toggle this resource active/inactive';
$strings['Minimum Reservation Time'] = 'Minimale Reservierungszeit';
$strings['Maximum Reservation Time'] = 'Maximale Reservierungszeit';
$strings['Auto-assign permission'] = 'Rechte automatische Zuweisen';
$strings['Add Resource'] = 'Ressource hinzuf�gen';
$strings['Edit Resource'] = 'Ressource bearbeiten';
$strings['Allowed'] = 'Erlaubt';
$strings['Notify user'] = 'Benutzer benachrichten';
$strings['User Reservations'] = 'Benutzer Reservierungen';
$strings['Date'] = 'Datum';
$strings['User'] = 'Benutzer';
$strings['Email Users'] = 'Dem Benutzer eine E-Mail schreiben';
$strings['Subject'] = 'Betreff.';
$strings['Message'] = 'Nachricht';
$strings['Please select users'] = 'Bitte Benutzer ausw�hlen';
$strings['Send Email'] = 'E-Mail senden';
$strings['problem sending email'] = 'Leider gab es ein Problem beim E-Mail-Versand, bitte versuchen Sie es sp�ter nocheinmal. ';
$strings['The email sent successfully.'] = 'Die E-Mail wurde erfolgreich versandt.';
$strings['do not refresh page'] = 'Bitte laden Sie diese Seite <u>nicht</u> neu, da sonst die E-Mail nocheinmal vesandt wird. ';
$strings['Return to email management'] = 'Zur�ck zur E-Mail-Verwaltung';
$strings['Please select which tables and fields to export'] = 'Bitte w�hlen Sie aus, welche Felder zu exportieren sind. :';
$strings['all fields'] = '- alle Felder -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = 'einfacher Text';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = 'Daten exportieren';
$strings['Reset Password for'] = 'Passwort zur�cksetzen f�r %s';
$strings['Please edit your profile'] = 'Bitte bearbeiten Sie Ihr Profil';
$strings['Please register'] = 'Bitte registrieren Sie sich.';
$strings['Email address (this will be your login)'] = 'E-Mail Addresse (Das wird Ihr Log-In sein.)';
$strings['Keep me logged in'] = 'Eingeloggt bleiben. <br/>(erfordert Cookies)';
$strings['Edit Profile'] = 'Profil bearbeiten';
$strings['Register'] = 'Registrieren';
$strings['Please Log In'] = 'Bitte Loggen Sie sich ein';
$strings['Email address'] = 'E-Mail Addresse';
$strings['Password'] = 'Passwort';
$strings['First time user'] = 'Das erste mal hier?';
$strings['Click here to register'] = 'Klicken Sie hier um sich zu registrieren.';
$strings['Register for phpScheduleIt'] = ' In phpScheduleIt registrieren';
$strings['Log In'] = 'Log-in';
$strings['View Schedule'] = 'Zeitplan anschauen';
$strings['View a read-only version of the schedule'] = 'Eine Nur-Lese Version des Zeitplans anschauen.';
$strings['I Forgot My Password'] = 'Passwort vergessen';
$strings['Retreive lost password'] = 'Verlorenes Passwort abfragen';
$strings['Get online help'] = 'Online-Hilfe';
$strings['Language'] = 'Sprache';
$strings['(Default)'] = '(Vorgabe)';
$strings['Next Week'] = 'N�chste Woche &raquo;';
$strings['for'] = 'f�r';

$strings['My Announcements'] = 'Meine Ank�ndigungen';
$strings['My Reservations'] = 'Meine Reservierungen';
$strings['My Permissions'] = 'Meine Rechteverwaltung';
$strings['My Quick Links'] = 'Meine Schnell-Links';
$strings['Announcements as of'] = 'Ank�ndigungen von %s';
$strings['There are no announcements.'] = 'Es gibt keine Ank�ndigungen.';
$strings['Resource'] = 'Ressource';
$strings['Created'] = 'Erstellt';
$strings['Last Modified'] = 'Letzte Ver�nderung';
$strings['View this reservation'] = 'Reservierung anschauen';
$strings['Modify this reservation'] = 'Reservierung ver�ndern';
$strings['Delete this reservation'] = 'Reservierung l�schen';
$strings['Bookings'] = 'Buchungen';										// @since 1.2.0
$strings['Change My Profile Information/Password'] = 'Benutzerdaten �ndern';		// @since 1.2.0
$strings['Manage My Email Preferences'] = 'Email Einstellungen �ndern';				// @since 1.2.0
$strings['Mass Email Users'] = 'Massen-E-Mail an Benutzer';
$strings['Search Scheduled Resource Usage'] = 'Reservierungen suchen';		// @since 1.2.0
$strings['Export Database Content'] = 'Datenbankinhalt exportieren';
$strings['View System Stats'] = 'System-Statisitken anschauen';
$strings['Email Administrator'] = 'E-Mail an Administrator';

$strings['Email me when'] = 'E-Mail an mich, wenn:';
$strings['I place a reservation'] = 'Ich eine Reservierung erstelle';
$strings['My reservation is modified'] = 'Meine Reservierung ver�ndert wird';
$strings['My reservation is deleted'] = 'Meine Reservierung gel�scht wird';
$strings['I prefer'] = 'Ich bevorzuge:';
$strings['Your email preferences were successfully saved'] = 'Ihre E-Mail Einstellungen wurden erfolgreich gespeichert!';
$strings['Return to My Control Panel'] = 'Zur�ck zum Kontrol-Panel';

$strings['Please select the starting and ending times'] = 'Bitte w�hlen Sie Start und End Zeiten aus.:';
$strings['Please change the starting and ending times'] = 'Bitte �ndern Sie Start und End Zeiten:';
$strings['Reserved time'] = 'Reservierte Zeit:';
$strings['Minimum Reservation Length'] = 'Minimale Reservierungsdauer:';
$strings['Maximum Reservation Length'] = 'Maximale Reservierungsdauer:';
$strings['Reserved for'] = 'Reserviert f�r:';
$strings['Will be reserved for'] = 'Wird reserviert f�r:';
$strings['N/A'] = 'k.A.';
$strings['Update all recurring records in group'] = 'Alle wiederkehrenden Eintr�ge in der Gruppe updaten?';
$strings['Delete?'] = 'L�schen?';
$strings['Never'] = '-- Niemals --';
$strings['Days'] = 'Tage';
$strings['Weeks'] = 'Wochen';
$strings['Months (date)'] = 'Monate (Datum)';
$strings['Months (day)'] = 'Monate (Tag)';
$strings['First Days'] = 'Erste Tage';
$strings['Second Days'] = 'Zweite Tage';
$strings['Third Days'] = 'Dritte Tage';
$strings['Fourth Days'] = 'Vierte Tage';
$strings['Last Days'] = 'Letzte Tage';
$strings['Repeat every'] = 'Wiederhole jede:';
$strings['Repeat on'] = 'Wiederhole am:';
$strings['Repeat until date'] = 'Wiederhole bis zum Datum:';
$strings['Choose Date'] = 'Datum w�hlen';
$strings['Summary'] = 'Zusammenfassung';

$strings['View schedule'] = 'Zeitplan anschauen:';
$strings['My Reservations'] = 'Meine Reservierungen';
$strings['My Past Reservations'] = 'Meine vergangene Reservierungen';
$strings['Other Reservations'] = 'Andere Reservierungen';
$strings['Other Past Reservations'] = 'Andere vergangene Reservierungen';
$strings['Blacked Out Time'] = 'Geblockte Zeiten';
$strings['Set blackout times'] = 'Geblockte Zeit setzen von %s bis %s';
$strings['Reserve on'] = 'Reserviere %s am %s';
$strings['Prev Week'] = '&laquo; Vorherige Woche';
$strings['Jump 1 week back'] = '1 Woche zur�ck springen';
$strings['Prev days'] = ' Vorher. %d Tage';
$strings['Previous days'] = ' Vorherige %d Tage';
$strings['This Week'] = 'Diese Woche';
$strings['Jump to this week'] = 'Zu dieser Woche springen.';
$strings['Next days'] = 'N�chste %d Tage';
$strings['Jump To Date'] = 'Zum Datum springen';
$strings['View Monthly Calendar'] = 'Monatsansicht anschauen';
$strings['Open up a navigational calendar'] = 'Einen Orientierungskalender �ffnen';

$strings['View stats for schedule'] = 'Statistiken f�r Zeitplan anschauen:';
$strings['At A Glance'] = 'Auf einen Blick';
$strings['Total Users'] = 'Benutzer Gesamt:';
$strings['Total Resources'] = 'Ressourcen Gesamt:';
$strings['Total Reservations'] = 'Reservierungen Gesamt:';
$strings['Max Reservation'] = 'Max. Reservierungen:';
$strings['Min Reservation'] = 'Min. Reservierung:';
$strings['Avg Reservation'] = 'Durchschn. Reservierung:';
$strings['Most Active Resource'] = 'Am meisten aktive Ressource:';
$strings['Most Active User'] = 'Am meisten aktiver Benutzer:';
$strings['System Stats'] = 'System-Statistiken';
$strings['phpScheduleIt version'] = 'phpScheduleIt Version:';
$strings['Database backend'] = 'Datenbank Backend:';
$strings['Database name'] = 'Datenbank Name:';
$strings['PHP version'] = 'PHP Version:';
$strings['Server OS'] = 'Server Betriebssystem:';
$strings['Server name'] = 'Server Name:';
$strings['phpScheduleIt root directory'] = 'phpScheduleIt Root Verzeichnis:';
$strings['Using permissions'] = 'Benutze Rechte:';
$strings['Using logging'] = 'Benutze Logging:';
$strings['Log file'] = 'Log-Datei:';
$strings['Admin email address'] = 'Admin E-Mail Adresse:';
$strings['Tech email address'] = 'Technische E-Mail Adresse:';
$strings['CC email addresses'] = 'CC E-Mail Adressen:';
$strings['Reservation start time'] = 'Reservierungs-Start-Zeit:';
$strings['Reservation end time'] = 'Reservierungs-End-Zeit:';
$strings['Days shown at a time'] = 'Tage, die gleichzeitig gezeigt werden:';
$strings['Reservations'] = 'Reservierungen';
$strings['Return to top'] = 'Zur�ck nach oben';

$strings['Select Search Criteria'] = 'Suchkriterien ausw�hlen';
$strings['Schedules'] = 'Zeitpl�ne:';
$strings['All Schedules'] = 'Alle Zeitpl�ne';
$strings['Hold CTRL to select multiple'] = 'Halte STRG-Taste gedr�ckt um mehrere auszuw�hlen.';
$strings['Users'] = 'Benutzer:';
$strings['All Users'] = 'Alle Benutzer';
$strings['Resources'] = 'Ressourcen';
$strings['All Resources'] = 'Alle Ressourcen';
$strings['Starting Date'] = 'Startdatum:';
$strings['Ending Date'] = 'Enddatum:';
$strings['Starting Time'] = 'Startzeit:';
$strings['Ending Time'] = 'Endzeit:';
$strings['Output Type'] = 'Ausgabetyp:';
$strings['Manage'] = 'Verwalten';
$strings['Total Time'] = 'Gesamtzeit';
$strings['Total hours'] = 'Stunden Gesamt:';
$strings['% of total resource time'] = '% der Gesamtzeit der Ressource';
$strings['View these results as'] = 'Diese Ergebnisse anschauen als :';
$strings['Edit this reservation'] = 'Diese Reservierung bearbeiten';
$strings['Search Results'] = 'Ergebnisse suchen';
$strings['Search Resource Usage'] = 'Ressourcebenutzung suchen';
$strings['Search Results found'] = 'Suchresultate: %d Reservierungen gefunden';
$strings['Try a different search'] = 'Eine andere Suche probieren';
$strings['Search Run On'] = 'Search Run On:';
$strings['Member ID'] = 'Benutzer ID';
$strings['Previous User'] = '&laquo; Vorheriger Benutzer';
$strings['Next User'] = 'N�chster Benutzer &raquo;';

$strings['No results'] = 'Keine Ergebnisse';
$strings['That record could not be found.'] = 'Diese Eintragung konnte nicht gefunden werden.';
$strings['This blackout is not recurring.'] = 'Dieser Block ist nicht wiederkehrend.';
$strings['This reservation is not recurring.'] = 'Diese Reservierung ist nicht wiederkehrend.';
$strings['There are no records in the table.'] = 'Es gibt keine Eintragungen in der Tabelle %s .';
$strings['You do not have any reservations scheduled.'] = 'Sie haben keine Reservierungen geplant.';
$strings['You do not have permission to use any resources.'] = 'Sie haben nicht gen�gend Rechte um Ressourcen zu nutzen.';
$strings['No resources in the database.'] = 'Keine Ressourcen in der Datenbank.';
$strings['There was an error executing your query'] = 'Es gab einen Fehler beim Ausf�hren der Anfrage:';

$strings['That cookie seems to be invalid'] = 'Dieser Cookie scheint ung�ltig zu sein';
$strings['We could not find that email in our database.'] = 'Wir konnten diese E-Mail in unserer Datenbank nicht finden.';
$strings['That password did not match the one in our database.'] = 'Dieses Passwort stimmt mit dem in unserer Datenbank nicht �berein.';
$strings['You can try'] = '<br />Sie k�nnen versuchen:<br />Eine E-Mail-Adresse registrieren.<br />oder:<br />Versuchen nochmal einzuloggen.';
$strings['A new user has been added'] = 'Ein neuer Benutzer wurde angelegt';
$strings['You have successfully registered'] = 'Sie haben sich erfolgreich registriert!';
$strings['Continue'] = 'Fortsetzen...';
$strings['Your profile has been successfully updated!'] = 'Das Profil wurde erfolgreich aktualisiert!';
$strings['Please return to My Control Panel'] = 'Bitte zum Kontol-Panel zur�ckkehren';
$strings['Valid email address is required.'] = '- G�ltige E-Mail-Adresse wird ben�tigt.';
$strings['First name is required.'] = '- Vorname wird ben�tigt.';
$strings['Last name is required.'] = '- Nachname wird ben�tigt.';
$strings['Phone number is required.'] = '- Telefonnumer wird ben�tigt.';
$strings['That email is taken already.'] = '- Diese E-Mail-Adresse wird bereits benutzt.<br />Bitte nochmal mit einer anderen versuchen.';
$strings['Min 6 character password is required.'] = '- Ein Passwort mit mind. %s Zeichen wird ben�tigt.';
$strings['Passwords do not match.'] = '- Passw�rter stimmen nicht �berein.';

$strings['Per page'] = 'Pro Seite:';
$strings['Page'] = 'Seite:';

$strings['Your reservation was successfully created'] = 'Die Reservierung wurde erfolgreich angelegt';
$strings['Your reservation was successfully modified'] = 'Die Reservierung wurde ge�ndert';
$strings['Your reservation was successfully deleted'] = 'Die Reservierung wurde erfolgreich gel�scht';
$strings['Your blackout was successfully created'] = 'Der Block wurde erfolgreich angelegt.';
$strings['Your blackout was successfully modified'] = 'Der Block wurde erfolgreich ver�ndert';
$strings['Your blackout was successfully deleted'] = 'Der Block wurde erfolgreich gel�scht';
$strings['for the follwing dates'] = 'f�r die folgenden Daten:';
$strings['Start time must be less than end time'] = 'Die Startzeit muss vor der Endzeit sein.';

$strings['Current start time is'] = 'Aktuelle Startzeit ist:';
$strings['Current end time is'] = 'Aktuelle Endzeit ist:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'Die angegebene Reservierungsdauer ist l�nger als die f�r diese Ressource erlaubte Reservierungsdauer.';
$strings['Your reservation is'] = 'Die Reservierung ist:';
$strings['Minimum reservation length'] = 'Minimale  Reservierungsdauer:';
$strings['Maximum reservation length'] = 'Maximale Reservierungsdauer:';
$strings['You do not have permission to use this resource.'] = 'Sie haben nicht gen�gend Rechte, um diese Ressource zu nutzen.';
$strings['reserved or unavailable'] = '%s bis %s ist reserviert oder nicht verf�gbar.';		// @since 1.1.0
$strings['Reservation created for'] = 'Reservierung angelegt f�r: %s';
$strings['Reservation modified for'] = 'Reservierung ge�ndert f�r: %s';
$strings['Reservation deleted for'] = 'Reservierung gel�scht f�r %s';
$strings['created'] = 'angelegt';
$strings['modified'] = 'ge�ndert';
$strings['deleted'] = 'gel�scht';
$strings['Reservation #'] = 'Reservierung #';
$strings['Contact'] = 'Kontakt';
$strings['Reservation created'] = 'Reservierung angelegt';
$strings['Reservation modified'] = 'Reservierung ge�ndert';
$strings['Reservation deleted'] = 'Reservierung gel�scht';

$strings['Reservations by month'] = 'Reservierungen nach Monaten';
$strings['Reservations by day of the week'] = 'Reservierungen nach Wochentag';
$strings['Reservations per month'] = 'Reservierungen pro Monat';
$strings['Reservations per user'] = 'Reservierungen pro Benutzer';
$strings['Reservations per resource'] = 'Reservierungen pro Ressource';
$strings['Reservations per start time'] = 'Reservierungen pro Startzeit';
$strings['Reservations per end time'] = 'Reservierungen pro Endzeit';
$strings['[All Reservations]'] = '[Alle Reservierungen]';

$strings['Permissions Updated'] = 'Rechte aktualisiert';
$strings['Your permissions have been updated'] = 'Die %s Rechte wurden aktualisiert';
$strings['You now do not have permission to use any resources.'] = 'Sie haben leider kein Rechte mehr, um Ressourcen zu nutzen.';
$strings['You now have permission to use the following resources'] = 'Sie haben nun die Rechte, die folgenden Ressourcen zu nutzen:';
$strings['Please contact with any questions.'] = 'F�r alle Fragen bitte %s kontaktieren.';
$strings['Password Reset'] = 'Passwort zur�cksetzen';


$strings['This will change your password to a new, randomly generated one.'] = 'Dies wird Ihr Passwort zu einem neuen, zufallsgenerierten �ndern.';
$strings['your new password will be set'] = 'Nach der Eingabe Ihrer E-Mail-Adresse und einem Klick auf "Passwort �ndern", wird das neue Passwort Ihnen zugesandt';
$strings['Change Password'] = 'Passwort �ndern';
$strings['Sorry, we could not find that user in the database.'] = 'Leider konnte dieser Benutzer nicht in der Datenbank gefunden werden.';
$strings['Your New Password'] = 'Ihr neues Passwort %s';
$strings['Your new passsword has been emailed to you.'] = 'Gratuliere!<br />
    			Ihr neues Passwort wurde Ihnen soeben zugemailt.<br />
    			Bitte �berpr�fen sie Ihr E-Mail-Postfach, um sich mit dem neuen Passwort <a href="index.php">einzuloggen.</a>
    			Bitte �ndern Sie es nach dem Login sofort zu einem eigenen unter dem Men�punkt &quot;Meine Profil Informationen und Passwort �ndern&quot;
    			im Kontrolpanel.';


$strings['You are not logged in!'] = 'Sie sind nicht eingeloggt!';

$strings['Setup'] = 'Setup';
$strings['Please log into your database'] = 'Bitte in die Datenbank einloggen';
$strings['Enter database root username'] = 'Datenbank-Root-Benutzernamen eingeben:';
$strings['Enter database root password'] = 'Datenbank-Root Passwort eingeben:';
$strings['Login to database'] = 'Login zur Datenbank';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = 'Root Benutzer ist <b>nicht</b> unbedingt n�tig. Jeder Datenbank Benutzer, der gen�gend Rechte hat um Tabellen anzulegen ist m�glich.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = 'Das wird alle f�r phpScheduleIt ben�tigten Datenbanken und Tabellen einriechten.';
$strings['It also populates any required tables.'] = 'Es f�llt auch alle ben�tigten Tabellen aus.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = 'Achtung: DAS WIRD ALLE DATEN IN VORHERIGEN phpScheduleIt DATENBANKEN L�SCHEN!';
$strings['Not a valid database type in the config.php file.'] = 'Ung�ltiger Datenbanktyp in der config.php Datei.';
$strings['Database user password is not set in the config.php file.'] = 'Das Datenbankbenutzer-Passwort ist in der config.php Datei nicht gesetzt.';
$strings['Database name not set in the config.php file.'] = 'Datenbank Name ist in der config.php Datei nicht gesetzt.';
$strings['Successfully connected as'] = 'Erfolgreich verbunden als:';
$strings['Create tables'] = 'Tabellen anlegen >';
$strings['There were errors during the install.'] = 'Es trat Fehler w�hrend der Installation auf. Es ist m�glich, dass phpScheduleIt trotzdem funktionieren wird, wenn die Fehler nur gering waren.<br/><br/>'
	. 'Bitte posten Sie alle Fragen in die Foren auf <a href="http://sourceforge.net/forum/?group_id=95547">SourceForge</a>.';

$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = 'phpScheduleIt wurde erfolgreich eingerichtet und ist jetzt zum Benutzen bereit';

$strings['Thank you for using phpScheduleIt'] = ' Bitte vergewissern Sie sich sich den Ordner \'install\' vollst�ndig gel�scht zu haben! '
	. ' Das ist sehr wichtig, da er die Passw�rter f�r die Datenbank und andere sensible Informationen enth�lt.'
	. ' Wenn Sie den Ordner bestehen lassen, schaffen sie damit ein riesiges Einfallstor f�r Angreifer!'
	. '<br /><br />'
	. 'Danke, dass sie phpScheduleIt verwenden.';

$strings['This will update your version of phpScheduleIt from 0.9.3 to 1.0.0.'] = 'Dies wird Ihre phpScheduleIt Version von 0.9.3 auf 1.0.0. updaten';
/* Why two times?
	$strings['Thank you for using phpScheduleIt'] = 'Bitte vergessen Sie nicht das \'install\' Verzeichnis vollst�ndig zu entfernen.'
	. ' Das ist sehr wichtig, weil es Datenbank-Passw�rter und andere sesiblen Informationen enth�lt.'
	. ' Das vers�umen des Entfernens f�hrt dazu, das die Pforte f�r jeden Angreifer meilenweit offen ist um die Datenbnk anzugreifen!'
	. '<br /><br />'
	. 'Danke, f�r das Benutzen von phpScheduleIt!'; */

$strings['There is no way to undo this action'] = 'Es gibt keine M�glichkeit diese Handlung r�ckg�ngig zu machen!';
$strings['Click to proceed'] = 'Klicken Sie um fortzusetzen';
$strings['This version has already been upgraded to 1.0.0.'] = 'Diese Version wurde bereits zu  1.0.0. upgedated';
$strings['Please delete this file.'] = 'Bitte l�schen Sie diese Datei.';
$strings['Successful update'] = 'Das Update war erfolgreich.';
$strings['Patch completed successfully'] = 'Patch erfolgreich';
$strings['This will populate the required fields for phpScheduleIt 1.0.0 and patch a data bug in 0.9.9.'] = 'Das wird die n�tig Felder f�r phpScheduleIt 1.0.0 f�llen und ein Daten-Bug von 0.9.9. berichtigen'
		. '<br />Das wird nur ben�tigt, wenn ein manueller SQL-Update von 0.9.9 durchgef�hrt wurde';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = 'Wenn kein Wert gesetzt ist, dann wird das Passwort verwendet, welches in der Konfigurationsdatei angegeben wurde.';
$strings['Notify user that password has been changed?'] = 'Benutzer �ber Passwort�nderung benachrichtigen?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'Das System erfordert, dass Sie eine E-Mail-Adresse haben.';
$strings['Invalid User Name/Password.'] = 'Ung�ltiger Benutzername/Passwort User Name/Password.';
$strings['Pending User Reservations'] = 'Unbest�tigte Benutzerreservierungen';
$strings['Approve'] = 'Erlauben';
$strings['Approve this reservation'] = 'Diese Reservierung erlauben.';
$strings['Approve Reservations'] ='Reservierungen erlauben';

$strings['Announcement'] = 'Ank�ndigung';
$strings['Number'] = 'Nummer';
$strings['Add Announcement'] = 'Ank�ndigung hinzuf�gen';
$strings['Edit Announcement'] = 'Ank�ndigung bearbeiten';
$strings['All Announcements'] = 'Alle Ank�ndigungen';
$strings['Delete Announcements'] = 'Ank�ndigungen l�schen';
$strings['Use start date/time?'] = 'Anfangszeit/Datum verwenden?';
$strings['Use end date/time?'] = 'Endzeit/Datum verwenden?';
$strings['Announcement text is required.'] = 'Ank�ndigungstext wird ben�tigt.';
$strings['Announcement number is required.'] = 'Ank�ndigungsnummer wird ben�tigt.';


$strings['Pending Approval'] = 'Unbest�tigte Erlaubnis';
$strings['My reservation is approved'] = 'Meine Reservierung ist erlaubt';
$strings['This reservation must be approved by the administrator.'] = 'Diese Reservierung muss erst vom Administrator erlaubt werden.';
$strings['Approval Required'] = 'Erlaubnis erforderlich';
$strings['No reservations requiring approval'] = 'Keine Reservierungen ben�tigen eine Erlaubnis';
$strings['Your reservation was successfully approved'] = 'Ihre Reservierung wurde erfolgreich erlaubt.';
$strings['Reservation approved for'] = 'Erservierung f�r %s erlaubt.';
$strings['approved'] = 'erlaubt';
$strings['Reservation approved'] = 'Reservierung erlaubt.';

$strings['Valid username is required'] = 'G�ltiger Benutzername wird ben�titgt';
$strings['That logon name is taken already.'] = 'Dieser Log-in Name ist bereits vergeben.';
$strings['this will be your login'] = '(Das wird ihr Log-in sein)';
$strings['Logon name'] = 'Log-in Name';
$strings['Your logon name is'] = 'Ihr Log-in Name ist %s';

$strings['Start'] = 'Anfang';
$strings['End'] = 'Ende';
$strings['Start date must be less than or equal to end date'] = 'Anfangsdatum muss vor oder gleich dem Enddatum sein.';
$strings['That starting date has already passed'] = 'Dieses Anfangsdatum ist bereits vorbei.';
$strings['Basic'] = 'Basis';
$strings['Participants'] = 'Teilnehmer';
$strings['Close'] = 'Schlie�en';
$strings['Start Date'] = 'Anfangsdatum';
$strings['End Date'] = 'Enddatum';
$strings['Minimum'] = 'Minimum';
$strings['Maximum'] = 'Maximum';
$strings['Allow Multiple Day Reservations'] = 'Mehrt�gige Reservierungen erlauben';
$strings['Invited Users'] = 'Eingeladene Benutzer';
$strings['Invite Users'] = 'Benutzer einladen';
$strings['Remove Participants'] = 'Teilnehmer entfernen';
$strings['Reservation Invitation'] = 'Reservierungseinladung';
$strings['Manage Invites'] = 'Einladungen verwalten';
$strings['No invite was selected'] = 'Keine Einladung wurde ausgew�hlt';
$strings['reservation accepted'] = '%s hat Ihre Einladung am %s akzeptiert';
$strings['reservation declined'] = '%s hat Ihre Einladung am %s abgelehnt';
$strings['Login to manage all of your invitiations'] = 'Loggen Sie sich ein um Ihre Einladungen zu verwalten';
$strings['Reservation Participation Change'] = 'Reservierung Teilnahme �nderung';
$strings['My Invitations'] = 'Meine Einladugen';
$strings['Accept'] = 'Akzeptieren';
$strings['Decline'] = 'Ablehnen';
$strings['Accept or decline this reservation'] = 'Diese Reservierung akzeptieren oder ablehnen.';
$strings['My Reservation Participation'] = 'Meine Reservierung Teilnahme';
$strings['End Participation'] = 'Teilnahme Beenden';
$strings['Owner'] = 'Besitzer';
$strings['Particpating Users'] = 'Teilnehmende Benutzer';
$strings['No advanced options available'] = 'Keine erweiterten Optionen verf�gbar';
$strings['Confirm reservation participation'] = 'Reservierung Teilnahme best�tigen';
$strings['Confirm'] = 'Best�tigen';
$strings['Do for all reservations in the group?'] = 'F�r alle Reservierungen in der Gruppe?';

$strings['My Calendar'] = 'Mein Kalender';
$strings['View My Calendar'] = 'Meinen Kalender anschauen';
$strings['Participant'] = 'Teilnehmer';
$strings['Recurring'] = 'Wiederkehrend';
$strings['Multiple Day'] = 'Mehrt�gig';
$strings['[today]'] = '[Heute]';
$strings['Day View'] = 'Tagesansicht';
$strings['Week View'] = 'Wochenansicht';
$strings['Month View'] = 'Monatsansicht';
$strings['Resource Calendar'] = 'Ressourcen Kalender';
$strings['View Resource Calendar'] = 'Ressourcen Kalender ansehen';	// @since 1.2.0
$strings['Signup View'] = 'Anmeldeansicht';

$strings['Select User'] = 'Benutzer ausw�hlen';
$strings['Change'] = '�ndern';

$strings['Update'] = 'Updaten';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'phpScheduleIt Update ist nur f�r Version 1.0.0 oder sp�ter verf�gbar';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt ist bereits aktuell';
$strings['Migrating reservations'] = 'Reservierungen migrieren';

$strings['Admin'] = 'Admininstrator';
$strings['Manage Announcements'] = 'Ank�ndigungen verwalten';
$strings['There are no announcements'] = 'There are no announcements';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = 'Maximale Teilnehmerzahl';
$strings['Leave blank for unlimited'] = 'Leer lassen f�r unbegrenzt.';
$strings['Maximum of participants'] = 'Diese Ressource hat maximal %s Teilnehmer';
$strings['That reservation is at full capacity.'] = 'Diese Ressource ist ausgebucht.';
$strings['Allow registered users to join?'] = 'Sind registrierte Benutzer erlaubt?';
$strings['Allow non-registered users to join?'] = 'Sind nicht registrierte Benutzer erlaubt?';
$strings['Join'] = 'Teilnehmen';
$strings['My Participation Options'] = 'Meine Teilnahmeoptionen';
$strings['Join Reservation'] = 'An Reservierung teilnehmen';
$strings['Join All Recurring'] = 'An allen wiederkehrenden Terminen teilnehmen';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = 'Sie k�nnen an folgenden Terminen nicht teilnehmen, weil sie bereits ausgebucht sind.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = 'Sie wurden hierzu bereits eingeladen. Bitte folgen Sie den Anweisungen zum Teilnehmen in der vorhergegangen Email.';
$strings['Additional Tools'] = 'Zus�tzliche Funktionen';
$strings['Create User'] = 'Benutzer anlegen';
$strings['Check Availability'] = 'Check Availability';
//$strings['Add Resources'] = 'Add Resources';
$strings['Manage Additional Resources'] = 'Zubeh�r verwalten';
$strings['All Additional Resources'] = 'Alles Zubeh�r';
$strings['Number Available'] = 'Verf�gbare Anzahl';
$strings['Unlimited'] = 'Unbegrenzt';
$strings['Add Additional Resource'] = 'Zubeh�r hinzuf�gen';
$strings['Edit Additional Resource'] = 'Zubeh�r bearbeiten';
$strings['Checking'] = 'Pr�fe';
$strings['You did not select anything to delete.'] = 'Sie haben nichts zum l�schen ausgew�hlt.';
$strings['Added Resources'] = 'Hinzugef�gtes Zubeh�r';
$strings['Additional resource is reserved'] = 'Das Zubeh�r %s kann nur %s gleichzeitig gebucht werden.';
$strings['All Groups'] = 'Alle Gruppen';
$strings['Group Name'] = 'Gruppen Name';
$strings['Delete Groups'] = 'Gruppen l�schen';
$strings['Manage Groups'] = 'Gruppen verwalten';
$strings['None'] = 'Nichts';
$strings['Group name is required.'] = 'Gruppenname wird zwingend ben�tigt.';
$strings['Groups'] = 'Gruppen';
$strings['Current Groups'] = 'Gegenw�rtige Gruppe';
$strings['Group Administration'] = 'Gruppen Verwaltung';
$strings['Reminder Subject'] = 'Reservierungserinnerung- %s, %s %s';
$strings['Reminder'] = 'Erinnerung';
$strings['before reservation'] = 'vor der Reservierung';
$strings['My Participation'] = 'Meine Teilnahme';
$strings['My Past Participation'] = 'Meine vergangene Teilnahme';
$strings['Timezone'] = 'Zeitzone';
$strings['Export'] = 'Export';
$strings['Select reservations to export'] = 'W�hlen Sie die zu exportierenden Reservierungen';
$strings['Export Format'] = 'Export Format';
$strings['This resource cannot be reserved less than x hours in advance'] = 'Diese Ressource kann nicht weniger als %s Stunden im voraus aufgehoben werden';
$strings['This resource cannot be reserved more than x hours in advance'] = 'Diese Ressource kann nicht mehr als %s Stunden im voraus aufgehoben werden';
$strings['Minimum Booking Notice'] = 'Minimale Buchungsm�glichkeit';
$strings['Maximum Booking Notice'] = 'Maximale Buchungsm�glichkeit';
$strings['hours prior to the start time'] = 'Stunden vor der Startzeit';
$strings['hours from the current time'] = 'Stunden von der aktuellen Uhrzeit';
$strings['Contains'] = 'Enth�lt';
$strings['Begins with'] = 'Beginnt mit';
$strings['Minimum booking notice is required.'] = 'Minimale Buchungsnotiz wird zwingend ben�tigt.';
$strings['Maximum booking notice is required.'] = 'Maximale Buchungsnotiz wird zwingend ben�tigt.';
$strings['Accessory Name'] = 'Zubeh�r Name';
$strings['Accessories'] = 'Zubeh�r';
$strings['All Accessories'] = 'Das ganze Zubeh�r';
$strings['Added Accessories'] = 'Hinzugef�gtes Zubeh�r';
// end since 1.2.0

/***
  EMAIL MESSAGES
  Please translate these email messages into your language.  You should keep the sprintf (%s) placeholders
   in their current position unless you know you need to move them.
  All email messages should be surrounded by double quotes "
  Each email message will be described below.
***/
// Email message that a user gets after they register

$email['register'] = "%s, %s\n\r\n"
				. "Sie haben sich erfolgreich mit den folgenden Daten registriert:\r\n"
				. "Name: %s %s\r\n"
				. "Tel: %s\r\n"
				. "Institution: %s\r\n"
				. "Stellung: %s\r\n\r\n"
				. "Bitte loggen Sie sich in den Zeitplan hier ein::\r\n"
				. "%s\r\n\r\n"
				. "Im Kontrol-Panel k�nnen Verweise auf den Online-Zeitplan und das Profil gefunden werden.\r\n\r\n"
				. "Bitte richten Sie alle Fragen �ber die Ressourcen oder Reservierungen an %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "Administrator,\r\n\r\n"
					. "Ein neuer Benutzer wurde registriert mit den folgenden Daten:\r\n"
					. "Email: %s\r\n"
					. "Name: %s %s\r\n"
					. "Tel: %s\r\n"
					. "Institution: %s\r\n"
					. "Stellung: %s\r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "Sie haben erfolgreich %s: Reservierung  #%s.\r\n\r\n<br/><br/>"
			. "Bitte benutzen Sie diese Reservierungsnummer, wenn Sie den Administrator f�r Fragen kontaktieren.\r\n\r\n<br/><br/>"
			. "Ihre Reservierung: VON %s, %s Uhr BIS %s, %s Uhr;"
			. " RAUM: %s, %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "Diese Reservierung wird an folgenden Daten wiederholt:\r\n<br/>";
$email['reservation_activity_3'] = "Alle wiederkehrenden Reservierungen in dieser Gruppe wurden auch %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "Die folgende Zusammenfassung wurde geliefert f�r folgende Reservierung: \r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "Wenn dies ein Fehler sein sollte, kontaktieren Sie bitte den Administrator �ber : %s"
			. " oder rufen Sie ihn an : %s.\r\n\r\n<br/><br/>"
			. "Die Reservierungsdaten k�nnen jederzeit angeschaut und ver�ndert werden durch "
			. " das einloggen in %s auf:\r\n<br/>"
			. "<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "Bitte richten Sie alle technischen Fragen an: <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "Ihr %s Passwort wurde vom Administrator zur�ckgesetzt.\r\n\r\n"
			. "Ihr tempor�res Passwort lautet: \r\n\r\n %s\r\n\r\n"
			. "Bitte benutzen Sie dieses Passwort (um ganz sicher zu sein kopieren und einf�gen) um sich in %s auf %s einzuloggen."
			. " Es sollte sofort in 'Meine Profil Informationen und Passwort �ndern' in Meine Schnell-Links ge�ndert werden .\r\n\r\n"
			. "Bitte kontaktieren Sie  %s bei allen Fragen.";

// Email that the user gets when they change their lost password using the 'Password Reset' form

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n"
            . "Ihr neues Passwort  %s f�r ihr Account ist:\r\n\r\n"
            . "%s\r\n\r\n"
            . "Bitte einloggen auf %s "
            . "mit dem neuem Passwort "
            . "(einfach kopieren und einf�gen um ganz sicher zu sein) "
            . "und �ndern Sie Ihr Passwort sofort, indem Sie auf "
            . "Meine Profil Informationen und Passwort �ndern "
            . "in Meine Schnell-Links klicken.\r\n\r\n"
            . "Bitte alle Fragen an %s.";

// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "Ihre Reservierung f�r %s von %s %s bis %s %s beginnt gleich.";
?>