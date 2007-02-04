<?php
/**
* Italian (it) translation file
*
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator <emiliano.meneghin@tin.it>
* @translator <paolo.ponzano@gmail.com>
* @translator <cristian.mezzetti@gmail.com>
* @version 01-08-07
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
$days_full = array('Domenica', 'Luned&igrave;', 'Marted&igrave;', 'Mercoled&igrave;', 'Gioved&igrave;', 'Venerd&igrave;', 'Sabato');
// The three letter abbreviation
$days_abbr = array('Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab');
// The two letter abbreviation
$days_two  = array('Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa');
// The one letter abbreviation
$days_letter = array('D', 'L', 'M', 'M', 'G', 'V', 'S');

/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');

// The three letter month name
$months_abbr = array('Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic');

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
$strings['hours'] = 'ore';
$strings['minutes'] = 'minuti';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = 'mm';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = 'gg';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = 'aaaa';
$strings['am'] = 'am';
$strings['pm'] = 'pm';

$strings['Administrator'] = 'Amministratore';
$strings['Welcome Back'] = 'Bentornato, %s';
$strings['Log Out'] = 'Esci';
$strings['My Control Panel'] = 'Pannello di Controllo';
$strings['Help'] = 'Aiuto';
$strings['Manage Schedules'] = 'Amministrazione Programmazioni';
$strings['Manage Users'] ='Amministrazione Utenti';
$strings['Manage Resources'] ='Amministrazione Risorse';
$strings['Manage User Training'] ='Amministrazione Addestramento Utenti';
$strings['Manage Reservations'] ='Amministrazione Prenotazioni';
$strings['Email Users'] ='Spedizione Email agli Utenti';
$strings['Export Database Data'] = 'Esportazione Dati Database';
$strings['Reset Password'] = 'Reset Password';
$strings['System Administration'] = 'Amministrazione Sistema';
$strings['Successful update'] = 'Aggiornamento riuscito';
$strings['Update failed!'] = 'Aggiornamento Fallito!';
$strings['Manage Blackout Times'] = 'Amministrazione Blackout';
$strings['Forgot Password'] = 'Password Dimenticata';
$strings['Manage My Email Contacts'] = 'Amministrazione Miei Contatti Email';
$strings['Choose Date'] = 'Scelta Data';
$strings['Modify My Profile'] = 'Modifica il Mio Profilo';
$strings['Register'] = 'Registrazione';
$strings['Processing Blackout'] = 'Elaborazione Blackout';
$strings['Processing Reservation'] = 'Elaborazione Prenotazione';
$strings['Online Scheduler [Read-only Mode]'] = 'Programmazione Online [Modalit&agrave; solo-lettura]';
$strings['Online Scheduler'] = 'Programmazione online';
$strings['phpScheduleIt Statistics'] = 'Statistiche phpScheduleIt';
$strings['User Info'] = 'Informazioni Utente:';

$strings['Could not determine tool'] = 'Non &egrave; possibile determinare lo strumento. Si prega di tornare al Mio Pannello di Controllo e provare pi&ugrave; tardi.';
$strings['This is only accessable to the administrator'] = 'Accessibile solo all\'amministratore';
$strings['Back to My Control Panel'] = 'Indietro al Mio Pannello di Controllo';
$strings['That schedule is not available.'] = 'Questa programmazione non &egrave; disponibile.';
$strings['You did not select any schedules to delete.'] = 'Non hai selezionato nessuna programmazione da cancellare.';
$strings['You did not select any members to delete.'] = 'Non hai selezionato nessun membro da cancellare.';
$strings['You did not select any resources to delete.'] = 'Non hai selezionato nessuna risorsa da cancellare.';
$strings['Schedule title is required.'] = 'Il titolo della Programmazione &agrave; obbligatorio.';
$strings['Invalid start/end times'] = 'I tempi di inizio/fine non sono validi';
$strings['View days is required'] = 'Le viste giornaliere sono obbligatorie';
$strings['Day offset is required'] = 'L\'offset del giorno &egrave; obbligatorio';
$strings['Admin email is required'] = 'L\'email dell\'Amministratore &egrave; obbligatoria';
$strings['Resource name is required.'] = 'Il nome della Risorsa &egrave; obbligatorio.';
$strings['Valid schedule must be selected'] = '&Egrave; obbligatorio selezionare una programmazione valida';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'La Minima Durata della Prenotazione deve essere minore o uguale alla Massima Durata della Prenotazione.';
$strings['Your request was processed successfully.'] = 'La richiesta &egrave; stata elaborata correttamente.';
$strings['Go back to system administration'] = 'Indietro all\'amministrazione del sistema';
$strings['Or wait to be automatically redirected there.'] = 'Oppure attendere per essere automaticamente reindirizzati.';
$strings['There were problems processing your request.'] = 'Ci sono stati dei problemi nell\'elaborare la richiesta.';
$strings['Please go back and correct any errors.'] = 'Si prega di tornare indietro e correggere gli errori.';
$strings['Login to view details and place reservations'] = 'Accedere per vedere i dettagli e fare le prenotazioni';
$strings['Memberid is not available.'] = 'Il Memberid: %s non &egrave; disponibile.';

$strings['Schedule Title'] = 'Titolo della Programmazione';
$strings['Start Time'] = 'Orario d\'Inizio';
$strings['End Time'] = 'Orario di Fine';
$strings['Time Span'] = 'Intervallo';
$strings['Weekday Start'] = 'Giorno iniziale della settimana';
$strings['Admin Email'] = 'Indirizzo Email dell\'amministratore';

$strings['Default'] = 'Default';
$strings['Reset'] = 'Reset';
$strings['Edit'] = 'Edita';
$strings['Delete'] = 'Cancella';
$strings['Cancel'] = 'Annulla';
$strings['View'] = 'Mostra';
$strings['Modify'] = 'Modifica';
$strings['Save'] = 'Salva';
$strings['Back'] = 'Indietro';
$strings['Next'] = 'Prossimo';
$strings['Close Window'] = 'Chiudi Finestra';
$strings['Search'] = 'Cerca';
$strings['Clear'] = 'Pulisci';

$strings['Days to Show'] = 'Giorni da Mostrare';
$strings['Reservation Offset'] = 'Offset della Prenotazione';
$strings['Hidden'] = 'Nascosto';
$strings['Show Summary'] = 'Mostra Sommario';
$strings['Add Schedule'] = 'Aggiungi Programmazione';
$strings['Edit Schedule'] = 'Edita Programmazione';
$strings['No'] = 'No';
$strings['Yes'] = 'S&igrave;';
$strings['Name'] = 'Nome';
$strings['First Name'] = 'Nome';
$strings['Last Name'] = 'Cognome';
$strings['Resource Name'] = 'Nome Risorsa';
$strings['Email'] = 'Email';
$strings['Institution'] = 'Istituzione';
$strings['Phone'] = 'Telefono';
$strings['Password'] = 'Password';
$strings['Permissions'] = 'Permessi';
$strings['View information about'] = 'Visualizza informazioni circa %s %s';
$strings['Send email to'] = 'Manda email a %s %s';
$strings['Reset password for'] = 'Reset password per %s %s';
$strings['Edit permissions for'] = 'Edita permessi per %s %s';
$strings['Position'] = 'Posizione';
$strings['Password (6 char min)'] = 'Password (minimo %s caratteri)';
$strings['Re-Enter Password'] = 'Ri-Inserisci la Password';

$strings['Sort by descending last name'] = 'Ordina in modo descrescente per cognome';
$strings['Sort by descending email address'] = 'Ordina in modo descrescente per indirizzo email';
$strings['Sort by descending institution'] = 'Ordina in modo descrescente per istituzione';
$strings['Sort by ascending last name'] = 'Ordina in modo crescente per cognome';
$strings['Sort by ascending email address'] = 'Ordina in modo crescente per indirizzo';
$strings['Sort by ascending institution'] = 'Ordina in modo crescente per istituzione';
$strings['Sort by descending resource name'] = 'Ordina in modo decrescente per nome risorsa';
$strings['Sort by descending location'] = 'Ordina in modo descrescente per posizione';
$strings['Sort by descending schedule title'] = 'Ordina in modo descrescente per nome programmazione ';
$strings['Sort by ascending resource name'] = 'Ordina in modo crescente per nome risorsa';
$strings['Sort by ascending location'] = 'Ordina in modo crescente per posizione';
$strings['Sort by ascending schedule title'] = 'Ordina in modo crescente per nome programmazione';
$strings['Sort by descending date'] = 'Ordina in modo descrescente per data';
$strings['Sort by descending user name'] = 'Ordina in modo decrescente per nome utente';
$strings['Sort by descending start time'] = 'Ordina in modo decrescente per ora d\'inizio';
$strings['Sort by descending end time'] = 'Ordina in modo decrescente per ora di fine';
$strings['Sort by ascending date'] = 'Ordina in modo crescente per data';
$strings['Sort by ascending user name'] = 'Ordina in modo crescente per nome utente';
$strings['Sort by ascending start time'] = 'Ordina in modo crescente per ora d\'inizio';
$strings['Sort by ascending end time'] = 'Ordina in modo crescente per ora di fine';
$strings['Sort by descending created time'] = 'Ordina in modo decrescente per data di creazione';
$strings['Sort by ascending created time'] = 'Ordina in modo crescente per data di creazione';
$strings['Sort by descending last modified time'] = 'Ordina in modo decrescente per data ultima modifica';
$strings['Sort by ascending last modified time'] = 'Ordina in modo crescente per data ultima modifica';

$strings['Search Users'] = 'Ricerca Utenti';
$strings['Location'] = 'Posizione';
$strings['Schedule'] = 'Programmazione';
$strings['Phone'] = 'Telefono';
$strings['Notes'] = 'Note';
$strings['Status'] = 'Stato';
$strings['All Schedules'] = 'Tutte le Programmazioni';
$strings['All Resources'] = 'Tutte le Risorse';
$strings['All Users'] = 'Tutti gli Utenti';

$strings['Edit data for'] = 'Edita dati per %s';
$strings['Active'] = 'Attivo';
$strings['Inactive'] = 'Inattivo';
$strings['Toggle this resource active/inactive'] = 'Rendi questa risorsa attiva/inattiva';
$strings['Minimum Reservation Time'] = 'Minima Durata della Prenotazione';
$strings['Maximum Reservation Time'] = 'Massima Durata della Prenotazione';
$strings['Auto-assign permission'] = 'Auto-assegnazione permessi';
$strings['Add Resource'] = 'Aggiungi Risorsa';
$strings['Edit Resource'] = 'Edita Risorsa';
$strings['Allowed'] = 'Autorizzato';
$strings['Notify user'] = 'Notifica utente';
$strings['User Reservations'] = 'Prenotazioni Utente';
$strings['Date'] = 'Data';
$strings['User'] = 'Utente';
$strings['Email Users'] = 'Spedisci Email agli utenti';
$strings['Subject'] = 'Oggetto';
$strings['Message'] = 'Messaggio';
$strings['Please select users'] = 'Selezionare gli utenti';
$strings['Send Email'] = 'Spedisci Email';
$strings['problem sending email'] = 'C\'&egrave; stato un problema nella spedizione dell\'Email. Si prega di riprovare pi&ugrave; tardi.';
$strings['The email sent successfully.'] = 'L\'email &egrave; stata spedita con successo.';
$strings['do not refresh page'] = 'Si prega di <u>NON </u> ricaricare questa pagina. Facendolo si spediranno pi&egrave; email.';
$strings['Return to email management'] = 'Ritorna all\'amministrazione delle email';
$strings['Please select which tables and fields to export'] = 'Prego selezionare le tabelle e i campi da esportare:';
$strings['all fields'] = '- tutti i campi -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = 'Testo semplice';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = 'Esporta Dati';
$strings['Reset Password for'] = 'Reset password per %s';
$strings['Please edit your profile'] = 'Si prega di editare il proprio profilo';
$strings['Please register'] = 'Si prega di registrarsi';
$strings['Email address (this will be your login)'] = 'Email address (questo sar&agrave; il nome utente)';
$strings['Keep me logged in'] = 'Mantenere la connessione <br/>(richiede l\'abilitazione dei cookie)';
$strings['Edit Profile'] = 'Edita Profilo';
$strings['Register'] = 'Registrazione';
$strings['Please Log In'] = 'Prego Accedi';
$strings['Email address'] = 'Indirizzo Email';
$strings['Password'] = 'Password';
$strings['First time user'] = 'Utente del sistema per la prima volta?';
$strings['Click here to register'] = 'Clicca qui per registrarti';
$strings['Register for phpScheduleIt'] = 'Registrazione per phpScheduleIt';
$strings['Log In'] = 'Accedi';
$strings['View Schedule'] = 'Vedi Programmazione';
$strings['View a read-only version of the schedule'] = 'Vedi programmazione in sola-lettura';
$strings['I Forgot My Password'] = 'Ho dimenticato la Mia Password';
$strings['Retreive lost password'] = 'Recupera la password dimenticata';
$strings['Get online help'] = 'Ottieni aiuto online ';
$strings['Language'] = 'Lingua';
$strings['(Default)'] = '(Predefinito)';

$strings['My Announcements'] = 'I Miei Annunci';
$strings['My Reservations'] = 'Le Mie Prenotazioni';
$strings['My Permissions'] = 'I Miei Permessi';
$strings['My Quick Links'] = 'I Miei Link';
$strings['Announcements as of'] = 'Annunci al %s';
$strings['There are no announcements.'] = 'Non ci sono annunci.';
$strings['Resource'] = 'Risorsa';
$strings['Created'] = 'Creato';
$strings['Last Modified'] = 'Ultima Modifica';
$strings['View this reservation'] = 'Visualizza questa prenotazione';
$strings['Modify this reservation'] = 'Modifica questa prenotazione';
$strings['Delete this reservation'] = 'Cancella questa prenotazione';
$strings['Bookings'] = 'Prenotazioni';
$strings['Change My Profile Information/Password'] = 'Cambia il Mio Profilo';		// @since 1.2.0
$strings['Manage My Email Preferences'] = 'Preferenze Mia Email';				// @since 1.2.0
$strings['Manage Blackout Times'] = 'Amministrazione Blackout';
$strings['Mass Email Users'] = 'Email di Massa agli Utenti';
$strings['Search Scheduled Resource Usage'] = 'Ricerca prenotazioni';		// @since 1.2.0
$strings['Export Database Content'] = 'Esporta contenuto Database';
$strings['View System Stats'] = 'Visualizza Statistiche di Sistema';
$strings['Email Administrator'] = 'Spedisci Email all\'Amministratore';

$strings['Email me when'] = 'Manda un Email quando:';
$strings['I place a reservation'] = 'Faccio una prenotazione';
$strings['My reservation is modified'] = 'La mia prenotazione &egrave; modificata';
$strings['My reservation is deleted'] = 'La mia prenotazione &egrave; cancellata';
$strings['I prefer'] = 'Preferenze:';
$strings['Your email preferences were successfully saved'] = 'Le tue preferenze email sono state salvate con successo!';
$strings['Return to My Control Panel'] = 'Ritorna al Mio Pannello di Controllo';

$strings['Please select the starting and ending times'] = 'Selezionare l\'ora di inizio e di fine:';
$strings['Please change the starting and ending times'] = 'Cambiare l\'ora di inizio e di fine:';
$strings['Reserved time'] = 'Periodo Riservato:';
$strings['Minimum Reservation Length'] = 'Durata Minima della Prenotazione:';
$strings['Maximum Reservation Length'] = 'Durata Massima della Prenotazione:';
$strings['Reserved for'] = 'Riservato per:';
$strings['Will be reserved for'] = 'Sar&agrave; riservato per:';
$strings['N/A'] = 'N/A';
$strings['Update all recurring records in group'] = 'Aggiornare tutti i record ricorrenti nel gruppo?';
$strings['Delete?'] = 'Cancello?';
$strings['Never'] = '-- Mai --';
$strings['Days'] = 'Giorni';
$strings['Weeks'] = 'Settimane';
$strings['Months (date)'] = 'Mesi (data)';
$strings['Months (day)'] = 'Mesi (giorno)';
$strings['First Days'] = 'Primo Giorno';
$strings['Second Days'] = 'Secondo Giorno';
$strings['Third Days'] = 'Terzo Giorno';
$strings['Fourth Days'] = 'Quarto Giorno';
$strings['Last Days'] = 'Ultimo Giorno';
$strings['Repeat every'] = 'Ripeti ogni:';
$strings['Repeat on'] = 'Ripeti ilu:';
$strings['Repeat until date'] = 'Ripeti fino alla data:';
$strings['Choose Date'] = 'Scegli data';
$strings['Summary'] = 'Sommario';

$strings['View schedule'] = 'Visualizza programmazione:';
$strings['My Reservations'] = 'Le Mie Prenotazioni';
$strings['My Past Reservations'] = 'Le Mie Prenotazioni Passate';
$strings['Other Reservations'] = 'Altre Prenotazioni';
$strings['Other Past Reservations'] = 'Altre Prenotazioni Passate';
$strings['Blacked Out Time'] = 'Periodo in blackout';
$strings['Set blackout times'] = 'Imposta blackout per %s su %s';
$strings['Reserve on'] = 'Riserva %s su %s';
$strings['Prev Week'] = '&laquo; Settimana Precedente';
$strings['Jump 1 week back'] = 'Salta 1 settimana indietro';
$strings['Prev days'] = '&#8249; Prec %d giorni';
$strings['Previous days'] = '&#8249; Precedenti %d giorni';
$strings['This Week'] = 'Questa settimana';
$strings['Jump to this week'] = 'Salta a questa settimana';
$strings['Next days'] = 'Prossimi %d giorni &#8250;';
$strings['Next Week'] = 'Settimana Seguente &raquo;';
$strings['Jump To Date'] = 'Salta alla data';
$strings['View Monthly Calendar'] = 'Visualizza Calendario Mensile';
$strings['Open up a navigational calendar'] = 'Apri un calendario di navigazione';

$strings['View stats for schedule'] = 'Visualizza statistiche per programmazione:';
$strings['At A Glance'] = 'A Prima Vista';
$strings['Total Users'] = 'Totale Utenti:';
$strings['Total Resources'] = 'Totale Risorse:';
$strings['Total Reservations'] = 'Totale Prenotazioni:';
$strings['Max Reservation'] = 'Prenotazioni Max:';
$strings['Min Reservation'] = 'Prenotazioni Min:';
$strings['Avg Reservation'] = 'Media Prenotazioni:';
$strings['Most Active Resource'] = 'Risorsa Pi&ugrave; Attiva:';
$strings['Most Active User'] = 'Utente Pi&ugrave; Attivo:';
$strings['System Stats'] = 'Statistiche Sistema';
$strings['phpScheduleIt version'] = 'phpScheduleIt versione:';
$strings['Database backend'] = 'Database backend:';
$strings['Database name'] = 'Nome Database:';
$strings['PHP version'] = 'PHP versione:';
$strings['Server OS'] = 'Server OS:';
$strings['Server name'] = 'Server nome:';
$strings['phpScheduleIt root directory'] = 'phpScheduleIt root directory:';
$strings['Using permissions'] = 'Utilizzazione permessi:';
$strings['Using logging'] = 'Utilizzazione logging:';
$strings['Log file'] = 'File di Log:';
$strings['Admin email address'] = 'Indirizzo email Amministrazione:';
$strings['Tech email address'] = 'Indirizzo email Tecnici:';
$strings['CC email addresses'] = 'Indirizzo email CC:';
$strings['Reservation start time'] = 'Inizio Prenotazione:';
$strings['Reservation end time'] = 'Fine Prenotazione:';
$strings['Days shown at a time'] = 'Giorni mostrati alla volta:';
$strings['Reservations'] = 'Prenotazioni';
$strings['Return to top'] = 'Ritorna all inizio';
$strings['for'] = 'per';

$strings['Select Search Criteria'] = 'Seleziona un Criterio di Ricerca';
$strings['Schedules'] = 'Programmazione:';
$strings['All Schedules'] = 'Tutte le Programmazioni';
$strings['Hold CTRL to select multiple'] = 'Tieni premuto CTRL per selezioni multiple';
$strings['Users'] = 'Utenti:';
$strings['All Users'] = 'Tutti gli Utenti';
$strings['Resources'] = 'Risorse';
$strings['All Resources'] = 'Tutte le Risorse';
$strings['Starting Date'] = 'Data inizio:';
$strings['Ending Date'] = 'Data Fine:';
$strings['Starting Time'] = 'Ora d\'inizio:';
$strings['Ending Time'] = 'Ora di Fine:';
$strings['Output Type'] = 'Tipo di Output:';
$strings['Manage'] = 'Amministrazione';
$strings['Total Time'] = 'Tempo Totale';
$strings['Total hours'] = 'Ore Totali:';
$strings['% of total resource time'] = '% del tempo totale della risorsa';
$strings['View these results as'] = 'Visualizza questi risultati come:';
$strings['Edit this reservation'] = 'Edita questa prenotazione';
$strings['Search Results'] = 'Ricerca Risultati';
$strings['Search Resource Usage'] = 'Ricerca utilizzo della Risorsa';
$strings['Search Results found'] = 'Risultati Ricerca: %d prenotazioni trovate';
$strings['Try a different search'] = 'Prova una ricerca differente';
$strings['Search Run On'] = 'Cerca su:';
$strings['Member ID'] = 'ID membro';
$strings['Previous User'] = '&laquo; Utente Precedente';
$strings['Next User'] = 'Utente Successivo &raquo;';

$strings['No results'] = 'Nessun Risultato';
$strings['That record could not be found.'] = 'Questa voce non &egrave; stata trovata.';
$strings['This blackout is not recurring.'] = 'Questo blackout non &egrave; ricorrente.';
$strings['This reservation is not recurring.'] = 'Questa prenotazione non &egrave; ricorrente.';
$strings['There are no records in the table.'] = 'Non ci sono record nella tabella %s.';
$strings['You do not have any reservations scheduled.'] = 'Non hai prenotazioni programmate.';
$strings['You do not have permission to use any resources.'] = 'Non hai i permessi per usare nessuna risorsa.';
$strings['No resources in the database.'] = 'Nessuna risorsa nel database.';
$strings['There was an error executing your query'] = 'C\'&egrave; stato un errore eseguendo questa interrogazione:';

$strings['That cookie seems to be invalid'] = 'Questo cookie sembra non essere valido';
$strings['We could not find that logon in our database.'] = 'Impossibile trovare il nome utente nel database.';	// @since 1.1.0
$strings['That password did not match the one in our database.'] = 'Questa password non corrisponde a quella nel nostro database.';
$strings['You can try'] = '<br />Puoi provare:<br />Registrando un indirizzo email.<br />Or:<br />Riprova a loggarti ancora.';
$strings['A new user has been added'] = '&Egrave; stato aggiunto Un nuovo utente';
$strings['You have successfully registered'] = 'Ti sei registrato correttamente!';
$strings['Continue'] = 'Continua...';
$strings['Your profile has been successfully updated!'] = 'Il tuo profilo &egrave; stato aggiornato correttamente!';
$strings['Please return to My Control Panel'] = 'Si prega di tornare al Mio Pannello di Controllo';
$strings['Valid email address is required.'] = '- &Egrave; obbligatorio inserire un indirizzo email valido.';
$strings['First name is required.'] = '- &Egrave; obbligatorio inserire il nome.';
$strings['Last name is required.'] = '- &Egrave; obbligatorio inserire il cognome.';
$strings['Phone number is required.'] = '- &Egrave; obbligatorio inserire il numero di telefono.';
$strings['That email is taken already.'] = '- Questo indirizzo email &egrave; gi&agrave; stato registrato.<br />Si prega di provare ancora con un indirizzo email diverso.';
$strings['Min 6 character password is required.'] = '- La password deve essere minimo di %s caratteri.';
$strings['Passwords do not match.'] = '- La password non corrisponde.';

$strings['Per page'] = 'Per pagina:';
$strings['Page'] = 'Pagina:';

$strings['Your reservation was successfully created'] = 'La tua prenotazione &egrave; stata creata con successo';
$strings['Your reservation was successfully modified'] = 'La tua prenotazione &egrave; stata modificata con successo';
$strings['Your reservation was successfully deleted'] = 'La tua prenotazione &egrave; stata cancellata con successo';
$strings['Your blackout was successfully created'] = 'Il tuo blackout &egrave; stato creato con successo';
$strings['Your blackout was successfully modified'] = 'Il tuo blackout &egrave; stato modificato con successo';
$strings['Your blackout was successfully deleted'] = 'Il tuo blackout &egrave; stato cancellato con successo';
$strings['for the follwing dates'] = 'per le seguenti date:';
$strings['Start time must be less than end time'] = 'L\'ora di inizio deve essere minore di quella finale.';
$strings['Current start time is'] = 'L\'ora di inizio corrente &egrave;:';
$strings['Current end time is'] = 'L\'ora finale corrente &egrave;:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'La durata della prenotazione va oltre a quella permessa per questa risorsa.';
$strings['Your reservation is'] = 'La tua prenotazione &egrave;:';
$strings['Minimum reservation length'] = 'Durata Minima della prenotazione:';
$strings['Maximum reservation length'] = 'Durata Massima della prenotazione:';
$strings['You do not have permission to use this resource.'] = 'Non hai i permessi per usare questa risorsa.';
$strings['reserved or unavailable'] = '%s a %s &egrave; riservata o non disponibile.';	// @since 1.1.0
$strings['Reservation created for'] = 'Prenotazione creata per %s';
$strings['Reservation modified for'] = 'Prenotazione modificata per %s';
$strings['Reservation deleted for'] = 'Prenotazione cancellata per %s';
$strings['created'] = 'creato';
$strings['modified'] = 'modificato';
$strings['deleted'] = 'cancellato';
$strings['Reservation #'] = 'Prenotazione #';
$strings['Contact'] = 'Contatto';
$strings['Reservation created'] = 'Prenotazione creata';
$strings['Reservation modified'] = 'Prenotazione modificata';
$strings['Reservation deleted'] = 'Prenotazione cancellata';

$strings['Reservations by month'] = 'Prenotazioni per mese';
$strings['Reservations by day of the week'] = 'Prenotazioni per giorno della settimana';
$strings['Reservations per month'] = 'Prenotazioni al mese';
$strings['Reservations per user'] = 'Prenotazioni per utente';
$strings['Reservations per resource'] = 'Prenotazioni per risorsa';
$strings['Reservations per start time'] = 'Prenotazioni per ora d\'inizio';
$strings['Reservations per end time'] = 'Prenotazioni per ora di fine';
$strings['[All Reservations]'] = '[Tutte le prenotazioni]';

$strings['Permissions Updated'] = 'Permessi aggiornati';
$strings['Your permissions have been updated'] = 'I tuoi %s permessi sono stati aggiornati';
$strings['You now do not have permission to use any resources.'] = 'Ora non hai i permessi per usare nessuna risorsa.';
$strings['You now have permission to use the following resources'] = 'Ora hai i permessi per usare le seguenti risorse:';
$strings['Please contact with any questions.'] = 'Prego contattare %s per qualsiasi domanda.';
$strings['Password Reset'] = 'Reset password';

$strings['This will change your password to a new, randomly generated one.'] = 'Questo cambier&agrave; la tua password in una nuova, generata casualmente.';
$strings['your new password will be set'] = 'Dopo aver inserito il tuo indirizzo email e cliccato su "Cambia Password", la tua nuova password sar&agrave; impostata dal sistema e ti sar&agrave; spedita per email.';
$strings['Change Password'] = 'Cambia Password';
$strings['Sorry, we could not find that user in the database.'] = 'Non &egrave; possibile trovare questo utente nel database.';
$strings['Your New Password'] = 'La tua Nuova %s Password';
$strings['Your new passsword has been emailed to you.'] = '
    			La nuova password &egrave; stata spedita via email.<br />
    			Si prega di controllare la casella di posta, dopodich&acute; <a href="index.php">Accedere Qui</a>
    			con la nuova password e cambiarla appena possibile tramite il link &quot;Cambia il Mio Profilo/Password&quot;
    			in Mio Pannello di Controllo.';

$strings['You are not logged in!'] = 'Non sei entrato nel sistema';

$strings['Setup'] = 'Setup';
$strings['Please log into your database'] = 'Entra nel tuo database';
$strings['Enter database root username'] = 'Inserisci il nome utente del root database:';
$strings['Enter database root password'] = 'Inserisci la password del root database:';
$strings['Login to database'] = 'Entra nel database';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = 'L\'utente root <b>non &egrave; </b> obbligatorio. Qualsiasi utente del database con i permessi di creare tabelle &egrave; accettabile.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = 'Questo imposter&agrave; tutti i database e le tabelle necessari per phpScheduleIt.';
$strings['It also populates any required tables.'] = 'Inoltre popoler&agrave; ogni tabella necessaria.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = 'Attenzione: QUESTO CANCELLERA\' TUTTI I DATI NEI PRECEDENTI DATABASE DI phpScheduleIt!';
$strings['Not a valid database type in the config.php file.'] = 'Non c\'&egrave; un tipo di database valido nel file config.php.';
$strings['Database user password is not set in the config.php file.'] = 'La password dell\'utente del database non &egrave; impostata nel file config.php.';
$strings['Database name not set in the config.php file.'] = 'Il nome del Database non &egrave; configurato nel file config.php.';
$strings['Successfully connected as'] = 'Connesso con successo come';
$strings['Create tables'] = 'Creo tabelle &gt;';
$strings['There were errors during the install.'] = 'Ci sono stati errori durante l\'installazione. E\' possibile che  phpScheduleIt possa funzionare ugualmente se gli errori sono minimi.<br/><br/>'
	. 'Si prega di rivolgere qualsiasi domanda nei forum su <a href="http://sourceforge.net/forum/?group_id=95547">SourceForge</a>.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = 'Hai completato con successo l\'installazione di phpScheduleIt e ora &egrave; pronto per essere usato.';
$strings['Thank you for using phpScheduleIt'] = 'Prego assicurarsi di RIMUOVERE COMPLETAMENTE LA CARTELLA \'install\' .'
	. ' Questo &egrave; importante perch&eacute; contiene le password del database e altre informazioni sensibili.'
	. ' La non cancellazione lascia le porte aperte a chiunque per entrare nel tuo database!'
	. '<br /><br />'
	. 'Grazie per aver scelto phpScheduleIt!';
$strings['This will update your version of phpScheduleIt from 0.9.3 to 1.0.0.'] = 'Questo aggiornamento porter&agrave; la tua versione di phpScheduleIt dalla 0.9.3 alla 1.0.0.';
$strings['There is no way to undo this action'] = 'Non c\'&egrave; possibilit&agrave; di tornare indietro!';
$strings['Click to proceed'] = 'Premi per procedere';
$strings['This version has already been upgraded to 1.0.0.'] = 'Questa versione &egrave; gi&agrave; stata aggiornata alla 1.0.0.';
$strings['Please delete this file.'] = 'Si prega di cancellare questo file.';
$strings['Successful update'] = 'Aggiornamento completato con successo';
$strings['Patch completed successfully'] = 'Patch applicata con successo';
$strings['This will populate the required fields for phpScheduleIt 1.0.0 and patch a data bug in 0.9.9.'] = 'Questo popoler&agrave; i campi richiesti per phpScheduleIt 1.0.0 e applicher&agrave; le patch per i bug della versione 0.9.9.'
		. '<br />Questo &egrave; richiesto solo se viene eseguito un aggiornamento SQL manuale o se stai aggiornando dalla versione 0.9.9';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = 'Se non &egrave; specificato un valore, verr&agrave; usata la password di default settata nel file di configurazione.';
$strings['Notify user that password has been changed?'] = 'Avvisare l\'utente che la password &egrave; stata cambiata?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'Il sistema richiede che tu sia in possesso di un indirizzo email.';
$strings['Invalid User Name/Password.'] = 'Nome utente/Password invalidi.';
$strings['Pending User Reservations'] = 'Prenotazioni ancora da approvare';
$strings['Approve'] = 'Approva';
$strings['Approve this reservation'] = 'Approva questa Prenotazione';
$strings['Approve Reservations'] ='Approva Prenotazioni';

$strings['Announcement'] = 'Avviso';
$strings['Number'] = 'Numero';
$strings['Add Announcement'] = 'Aggiungi Avviso';
$strings['Edit Announcement'] = 'Modifica Avviso';
$strings['All Announcements'] = 'Tutti gli Avvisi';
$strings['Delete Announcements'] = 'Cancella Avvisi';
$strings['Use start date/time?'] = 'Utilizzare inizio data/ora?';
$strings['Use end date/time?'] = 'Utilizzare fine data/ora?';
$strings['Announcement text is required.'] = 'E\' obbligatorio inserire il testo dell\'Avviso.';
$strings['Announcement number is required.'] = 'E\' obbligatorio il numero dell\'Avviso.';

$strings['Pending Approval'] = 'In attesa di approvazione';
$strings['My reservation is approved'] = 'La prenotazione &egrave; stata approvata';
$strings['This reservation must be approved by the administrator.'] = 'Questa prenotazione deve essere approvata dall\'amministratore';
$strings['Approval Required'] = 'Approvazione Obbligatoria';
$strings['No reservations requiring approval'] = 'Nessuna prenotazione richiede approvazione';
$strings['Your reservation was successfully approved'] = 'La tua prenotazione &egrave; stata approvata con successo';
$strings['Reservation approved for'] = 'Prenotazione approvata per %s';
$strings['approved'] = 'approvata';
$strings['Reservation approved'] = 'Prenotazione approvata';

$strings['Valid username is required'] = 'E\' obbligatorio un nome utente valido';
$strings['That logon name is taken already.'] = 'Questo nome utente &egrave; gi&agrave; stato scelto.';
$strings['this will be your login'] = '(questo sar&agrave; il tuo nome utente)';
$strings['Logon name'] = 'Nome utente';
$strings['Your logon name is'] = 'Il tuo nome utente &egrave; %s';

$strings['Start'] = 'Inizio';
$strings['End'] = 'Fine';
$strings['Start date must be less than or equal to end date'] = 'La data di inizio deve essere inferiore o uguale alla data di fine';
$strings['That starting date has already passed'] = 'Questa data di inizio &egrave; gi&agrave; passata';
$strings['Basic'] = 'Base';
$strings['Participants'] = 'Partecipanti';
$strings['Close'] = 'Chiudi';
$strings['Start Date'] = 'Data di Inizio ';
$strings['End Date'] = 'Data di Fine ';
$strings['Minimum'] = 'Minimo';
$strings['Maximum'] = 'Massimo';
$strings['Allow Multiple Day Reservations'] = 'Consenti prenotazioni su giorni multipli';
$strings['Invited Users'] = 'Utenti Invitati ';
$strings['Invite Users'] = 'Invita Utenti ';
$strings['Remove Participants'] = 'Rimuovi Partecipanti';
$strings['Reservation Invitation'] = 'Invito a questa Prenotazione ';
$strings['Manage Invites'] = 'Gestione Inviti ';
$strings['No invite was selected'] = 'Nessun invito &egrave; stato selezionato';
$strings['reservation accepted'] = '%s ha accettato il tuo invito per %s';
$strings['reservation declined'] = '%s ha rifiutato il tuo infito per %s';
$strings['Login to manage all of your invitiations'] = 'Effettua l\'accesso per gestire i tuoi inviti';
$strings['Reservation Participation Change'] = 'Cambia la prenotazione per le partecipazioni';
$strings['My Invitations'] = 'I Miei Inviti';
$strings['Accept'] = 'Accetta';
$strings['Decline'] = 'Rifiuta';
$strings['Accept or decline this reservation'] = 'Acceta o rifiuta questa prenotazione';
$strings['My Reservation Participation'] = 'Mie Partecipazioni alle Prenotazioni';
$strings['End Participation'] = 'Fine della partecipazione';
$strings['Owner'] = 'Proprietario';
$strings['Particpating Users'] = 'Utenti Partecipanti ';
$strings['No advanced options available'] = 'Non sono disponibili opzioni avanzate';
$strings['Confirm reservation participation'] = 'Conferma la partecipazione alla prenotazione ';
$strings['Confirm'] = 'Conferma';
$strings['Do for all reservations in the group?'] = 'Applicare a tutte le prenotazioni nel gruppo?';

$strings['My Calendar'] = 'Il Mio Calendario';
$strings['View My Calendar'] = 'Visualizza il Mio Calendario';
$strings['Participant'] = 'Partecipanti';
$strings['Recurring'] = 'Ricorrenza';
$strings['Multiple Day'] = 'Giorni Multipli ';
$strings['[today]'] = '[oggi]';
$strings['Day View'] = 'Giornaliera';
$strings['Week View'] = 'Settimanale';
$strings['Month View'] = 'Mensile';
$strings['Resource Calendar'] = 'Calendario delle Risorse ';
$strings['View Resource Calendar'] = 'Calendario Programmazioni';	// @since 1.2.0
$strings['Signup View'] = 'Sottoscrizione ';

$strings['Select User'] = 'Seleziona l\'utente';
$strings['Change'] = 'Cambia';

$strings['Update'] = 'Aggiorna';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'La procedura di aggiornamento di phpScheduleIt &egrave; disponibile solo per le versioni successive alla 1.0.0';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt &egrave; gi&agrave; aggiornato ';
$strings['Migrating reservations'] = 'Migrazione prenotazioni';

$strings['Admin'] = 'Amministratore';
$strings['Manage Announcements'] = 'Gestione Annunci ';
$strings['There are no announcements'] = 'Non ci sono Annunci';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = 'Massima Capienza Partecipanti';
$strings['Leave blank for unlimited'] = 'Lascia vuoto per illimitati';
$strings['Maximum of participants'] = 'Questa risorsa ha una capienza massima di %s partecipanti';
$strings['That reservation is at full capacity.'] = 'Questa prenotazione ha raggiunto la massima capienza.';
$strings['Allow registered users to join?'] = 'Permetti agli utenti registrati di partecipare?';
$strings['Allow non-registered users to join?'] = 'Permetti agli utenti non registrati di partecipare?';
$strings['Join'] = 'Unisciti';
$strings['My Participation Options'] = 'Opzioni Mie Partecipazioni';
$strings['Join Reservation'] = 'Partecipa alla Prenotazione';
$strings['Join All Recurring'] = 'Partecipa a tutte le ricorrenze';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = 'Non parteciperai alle seguenti prenotazioni perch&eacute; hanno raggiunto la massima capienza.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = 'Sei gi&agrave; stato invitato a questa prenotazione. Perfavore segui le istruzioni di partecipazione spedite precedentemente alla tua email.';
$strings['Additional Tools'] = 'Strumenti Aggiuntivi';
$strings['Create User'] = 'Crea Utente';
$strings['Check Availability'] = 'Controlla Disponibilit&agrave;';
$strings['Manage Additional Resources'] = 'Gestione Accessori';
$strings['All Additional Resources'] = 'Tutti gli Accessori';
$strings['Number Available'] = 'Disponibili in numero';
$strings['Unlimited'] = 'Illimitati';
$strings['Add Additional Resource'] = 'Aggiungi Accessorio';
$strings['Edit Additional Resource'] = 'Edita Accessorio';
$strings['Checking'] = 'Verifica';
$strings['You did not select anything to delete.'] = 'Non hai selezionato nulla da cancellare.';
$strings['Added Resources'] = 'Risorsa Aggiunta';
$strings['Additional resource is reserved'] = 'L\'accessorio %s &egrave; disponibile solo %s per volta';
$strings['All Groups'] = 'Tutti i Gruppi';
$strings['Group Name'] = 'Nome Gruppo';
$strings['Delete Groups'] = 'Cancella Gruppi';
$strings['Manage Groups'] = 'Gestione Gruppi';
$strings['None'] = 'Nessuno';
$strings['Group name is required.'] = 'Il nome del gruppo &egrave obbligatorio.';
$strings['Groups'] = 'Gruppi';
$strings['Current Groups'] = 'Gruppi Attuali';
$strings['Group Administration'] = 'Amministrazione Gruppi';
$strings['Reminder Subject'] = 'Promemoria prenotazione - %s, %s %s';
$strings['Reminder'] = 'Promemoria';
$strings['before reservation'] = 'Prima della prenotazione';
$strings['My Participation'] = 'Mie Partecipazioni';
$strings['My Past Participation'] = 'Mie Partecipazioni Passate';
$strings['Timezone'] = 'Fuso orario';
$strings['Export'] = 'Esporta';
$strings['Select reservations to export'] = 'Seleziona le prenotazioni da esportare';
$strings['Export Format'] = 'Formato Esportazione';
$strings['This resource cannot be reserved less than x hours in advance'] = 'Questa risorsa non pu&ograve; essere prenotata con meno di %s ora/e di anticipo';
$strings['This resource cannot be reserved more than x hours in advance'] = 'Questa risorsa non pu&ograve; essere prenotata con pi&ugrave; di %s ore di anticipo';
$strings['Minimum Booking Notice'] = 'Minimo Preavviso di una Prenotazione';
$strings['Maximum Booking Notice'] = 'Massimo Preavviso di una Prenotazione';
$strings['hours prior to the start time'] = 'ore prima dell\'inizio';
$strings['hours from the current time'] = 'ore dall\'orario attuale';
$strings['Contains'] = 'Contiene';
$strings['Begins with'] = 'Inizia per';
$strings['Minimum booking notice is required.'] = 'Il Minimo Preavviso di una Prenotazione &egrave; obbligatorio.';
$strings['Maximum booking notice is required.'] = 'Il Massimo Preavviso di una Prenotazione &egrave; obbligatorio.';
$strings['Accessory Name'] = 'Nome dell\'accessorio';
$strings['Accessories'] = 'Accessori';
$strings['All Accessories'] = 'Tutti gli Accessori';
$strings['Added Accessories'] = 'Accessori Aggiunti';
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
				. "La registrazione &egrave; avvenuta con successo, queste sono le informazioni:\r\n"
				. "Nome utente: %s\r\n"
				. "Nome: %s %s \r\n"
				. "Telefono: %s \r\n"
				. "Istituzione: %s \r\n"
				. "Posizione: %s \r\n\r\n"
				. "Puoi entrare nel sistema di prenotazione a questo indirizzo:\r\n"
				. "%s \r\n\r\n"
				. "Nella sezione Mio Pannello di Controllo si possono trovare i link alla programmazione online e alla modifica del proprio profilo.r\n\r\n"
				. "Per ogni domanda legata alle risorse o alle prenotazioni puoi contattare %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "Amministratore,\r\n\r\n"
					. "Un nuovo utente &egrave; stato registrato con le seguenti informazioni:\r\n"
					. "Email: %s\r\n"
					. "Nome: %s %s\r\n"
					. "Telefono: %s\r\n"
					. "Istituzione: %s\r\n"
					. "Posizione: %s\r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "Hai correttamente %s la prenotazione numero %s.\r\n\r\n<br/><br/>"
			. "Per favore usa questo numero di prenotazione se contatti l'amministratore.\r\n\r\n<br/><br/>"
			. "La prenotazione tra %s %s e %s %s per la risorsa %s"
			. " presso il %s &egrave; stata %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "Questa prenotazione &egrave; stata ripetuta nelle seguenti date:\r\n<br/>";
$email['reservation_activity_3'] = "Tutte le prenotazioni di questo gruppo sono inoltre %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "Il seguente sommario &egrave; stato redatto per questa prenotazione:\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "Se c'&egrave; stato un errore, si prega di contattare l'amministratore all\'indirizzo: %s"
			. " o chiamando il numero %s.\r\n\r\n<br/><br/>"
			. "Puoi vedere o modificare la tua prenotazione in qualsiasi momento "
			. " accedendo ad %s all\'indirizzo:\r\n<br/>"
			. "<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "Si prega di inoltrare tutte le domande tecniche a <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
			. "La prenotazione numero %s &egrave; stata approvata.\r\n\r\n<br/><br/>"
			. "Si prega di usare questo numero di prenotazione se contatti l'amministratore.\r\n\r\n<br/><br/>"
			. "Una prenotazione tra %s %s e %s %s per %s"
			. " presso %s &egrave; stata %s.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "La tua %s password &egrave; stata resettata dall'amministratore.\r\n\r\n"
			. "La tua password temporanea &egrave;:\r\n\r\n %s\r\n\r\n"
			. "Si prega di usare questa password (copia e incolla per essere sicuro di non sbagliare) per accedere in %s a %s"
			. " e cambiarla immediatamente usando il link 'Cambia il Mio Profilo/Password' nella sezione I Miei Link.\r\n\r\n"
			. "Si prega di contattare %s per ogni domanda.";

// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s ti ha invitato a partecipare alla seguente prenotazione:\r\n\r\n"
		. "Risorsa: %s\r\n"
		. "Data d\'inizio: %s\r\n"
		. "Ora d\'inizio: %s\r\n"
		. "Data di fine: %s\r\n"
		. "Ora di fine: %s\r\n"
		. "Sintesi: %s\r\n"
		. "Date ripetute (se presenti): %s\r\n\r\n"
		. "Per accettare questo invito clicca su questo link (copialo e incollalo se non &egrave; evidenziato) %s\r\n"
		. "Per rifiutare questo invito clicca su questo link (copialo e incollalo se non &egrave; evidenziato) %s\r\n"
		. "Per accettare date selezionato o gestire gli inviti ricevuti, perfavore entra in %s a %s";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "Sei stato rimosso dalle seguenti prenotazioni:\r\n\r\n"
		. "Risorsa: %s\r\n"
		. "Data d\'inizio: %s\r\n"
		. "Ora d\'inizio: %s\r\n"
		. "Data di fine: %s\r\n"
		. "Ora di fine: %s\r\n"
		. "Sintesi: %s\r\n"
		. "Date Ripetute (se presenti): %s\r\n\r\n";

// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "La tua prenotazione per %s da %s %s a %s %s si sta avvicinando.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n\r\n"
. "la tua nuova password di %s &egrave;: "
. "%s\r\n\r\n\r\n"
. "Ora puoi accedere su: %s utilizzando la nuova password.\r\n\r\n"
. "Ricordati per&ograve; di cambiarla appena possibile cliccando su \"Pannello di Controllo\" -> \"Cambia Profilo\".\r\n\r\n"
. "Per maggiori informazioni scrivi a: %s.\r\n\r\n\r\n";
?>

