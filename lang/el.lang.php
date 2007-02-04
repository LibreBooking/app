<?php
/**
* Greek (el) translation file.
*
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Socrates Katsoudas <mx5gr@hotmail.com>
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
$charset = 'iso-8859-7';

/***
  DAY NAMES
  All of these arrays MUST start with Sunday as the first element
   and go through the seven day week, ending on Saturday
***/
// The full day name
$days_full = array('Κυριακή', 'Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή', 'Σάββατο');
// The three letter abbreviation
$days_abbr = array('Κυρ', 'Δευ', 'Τρι', 'Τετ', 'Πεμ', 'Παρ', 'Σαβ');
// The two letter abbreviation
$days_two  = array('Κυ', 'Δε', 'Τρ', 'Τε', 'Πε', 'Πα', 'Σα');
// The one letter abbreviation
$days_letter = array('Κ', 'Δ', 'Τ', 'Τ', 'Π', 'Π', 'Σ');

/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('Ιανουάριος', 'Φεβρουάριος', 'Μάρτιος', 'Απρίλιος', 'Μάιος', 'Ιούνιος', 'Ιούλιος', 'Αύγουστος', 'Σεπτέμβριος', 'Οκτώβριος', 'Νοέμβριος', 'Δεκέμβριος');
// The three letter month name
$months_abbr = array('Ιαν', 'Φεβ', 'Μαρ', 'Απρ', 'Μάι', 'Ιον', 'Ιολ', 'Αυγ', 'Σεπ', 'Οκτ', 'Νοε', 'Δεκ');

// All letters of the alphabet starting with A and ending with Z
$letters = array ('Α', 'Β', 'Γ', 'Δ', 'Ε', 'Ζ', 'Η', 'Θ', 'Ι', 'Κ', 'Λ', 'Μ', 'Ν', 'Ξ', 'Ο', 'Π', 'Ρ', 'Σ', 'Τ', 'Υ', 'Φ', 'Χ', 'Ψ', 'Ω', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

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
$dates['header'] = '%A, %d %B %Y';
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
$strings['hours'] = 'ώρες';
$strings['minutes'] = 'λεπτά';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = 'μμ';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = 'ηη';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = 'εεεε';
$strings['am'] = 'πμ';
$strings['pm'] = 'μμ';

$strings['Administrator'] = 'Διαχειριστής Συστήματος';
$strings['Welcome Back'] = 'Καλωσήρθες, %s';
$strings['Log Out'] = 'Έξοδος';
$strings['My Control Panel'] = 'Πίνακας Ελέγχου';
$strings['Help'] = 'Βοήθεια';
$strings['Manage Schedules'] = 'Διαχείριση Προγραμμάτων';
$strings['Manage Users'] ='Διαχείριση Χρηστών';
$strings['Manage Resources'] ='Διαχείριση Πόρων';
$strings['Manage User Training'] ='Διαχείριση Εκπαίδευσης Χρηστών';
$strings['Manage Reservations'] ='Διαχείριση Κρατήσεων';
$strings['Email Users'] ='Email Χρήστες';
$strings['Export Database Data'] = 'Εξαγωγή Δεδομένων Βάσης';
$strings['Reset Password'] = 'Μηδενισμός Κωδικού';
$strings['System Administration'] = 'Διαχείριση Συστήματος';
$strings['Successful update'] = 'Επιτυχής ενημέρωση';
$strings['Update failed!'] = 'Σφάλμα κατά την ενημέρωση!';
$strings['Manage Blackout Times'] = 'Διαχείριση Μη Διαθέσιμων Ωρών';
$strings['Forgot Password'] = 'Αποστολή Κωδικού';
$strings['Manage My Email Contacts'] = 'Επεξεργασία Επαφών Email';
$strings['Choose Date'] = 'Επιλογή Ημερομηνίας';
$strings['Modify My Profile'] = 'Μεταβολή Προφίλ';
$strings['Register'] = 'Καταχώρηση Στοιχείων';
$strings['Processing Blackout'] = 'Επεξεργασία Μη Διαθεσίμων';
$strings['Processing Reservation'] = 'Επεξεργασία Κρατήσεων';
$strings['Online Scheduler [Read-only Mode]'] = 'Ισχύον Πρόγραμμα [Μόνο Ανάγνωση]';
$strings['Online Scheduler'] = 'Ισχύον Πρόγραμμα';
$strings['Statistics'] = 'Στατιστικά στοιχεία';
$strings['User Info'] = 'Στοιχεία Χρήστη:';

$strings['Could not determine tool'] = 'Το εργαλείο δεν βρέθηκε. Παρακαλώ επιστρέψτε στον Πίνακα Ελέγχου και ξαναπροσπαθείστε αργότερα.';
$strings['This is only accessable to the administrator'] = 'Η λειτουργία αυτή είναι προσβάσιμη μόνο από τον Διαχειριστή';
$strings['Back to My Control Panel'] = 'Επιστροφή στον Πίνακα Ελέγχου';
$strings['That schedule is not available.'] = 'Το πρόγραμμα αυτό δεν είναι διαθέσιμο.';
$strings['You did not select any schedules to delete.'] = 'Δεν επιλέξατε πρόγραμμα προς διαγραφή.';
$strings['You did not select any members to delete.'] = 'Δεν επιλέξατε μέλος προς διαγραφή.';
$strings['You did not select any resources to delete.'] = 'Δεν επιλέξατε πόρους προς διαγραφή.';
$strings['Schedule title is required.'] = 'Το Πρόγραμμα πρέπει να έχει τίτλο.';
$strings['Invalid start/end times'] = 'Ανύπαρκτοι χρόνοι έναρξης/λήξης';
$strings['View days is required'] = 'Η προβολή ημερών είναι απαραίτητη';
$strings['Day offset is required'] = 'Η αντιστάθμιση ημέρας είναι απαραίτητη';
$strings['Admin email is required'] = 'Το email του διαχειριστή είναι απαραίτητο';
$strings['Resource name is required.'] = 'Το όνομα πόρου είναι απαραίτητο.';
$strings['Valid schedule must be selected'] = 'Επιλέξτε κάποιο έγκυρο πρόγραμμα';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'Η ελάχιστη περίοδος κράτησης πρέπει να είναι μικρότερη ή ίση με την μέγιστη περίοδο κράτησης.';
$strings['Your request was processed successfully.'] = 'Το αίτημά σας επεξεργάστηκε με επιτυχία.';
$strings['Go back to system administration'] = 'Επιστροφή στην Διαχείριση Συστήματος';
$strings['Or wait to be automatically redirected there.'] = 'Η αναμείνατε την αυτόματη μετάβασή σας εκεί.';
$strings['There were problems processing your request.'] = 'Παρουσιάστηκαν προβλήματα κατά την επεξεργασία του αιτήματός σας.';
$strings['Please go back and correct any errors.'] = 'Παρακαλώ επιστρέψτε και διορθώστε όλα τα σφάλματα.';
$strings['Login to view details and place reservations'] = 'Συνδεθείτε για την προβολή λεπτομερειών και την καταχώρηση κρατήσεων';
$strings['Memberid is not available.'] = 'Ο Αριθμός Μέλους: %s δεν είναι διαθέσιμος.';

$strings['Schedule Title'] = 'Τίτλος Προγράμματος';
$strings['Start Time'] = 'Ωρα Έναρξης: ';
$strings['End Time'] = 'Ώρα Λήξης';
$strings['Time Span'] = 'Εύρος Ωρας';
$strings['Weekday Start'] = 'Έναρξη Ημέρας';
$strings['Admin Email'] = 'Email Διαχειριστή';

$strings['Default'] = 'Προεπιλογή';
$strings['Reset'] = 'Επανεκκίνηση';
$strings['Edit'] = 'Επεξεργασία';
$strings['Delete'] = 'Διαγραφή';
$strings['Cancel'] = 'Ακύρωση';
$strings['View'] = 'Προβολή';
$strings['Modify'] = 'Τροποποίηση';
$strings['Save'] = 'Αποθήκευση';
$strings['Back'] = 'Προηγούμενο';
$strings['Next'] = 'Επόμενο';
$strings['Close Window'] = 'Κλείσιμο Παραθύρου';
$strings['Search'] = 'Αναζήτηση';
$strings['Clear'] = 'Καθαρισμός';

$strings['Days to Show'] = 'Ημέρες προς Προβολή';
$strings['Reservation Offset'] = 'Αντιστάθμιση Κρατήσεων';
$strings['Hidden'] = 'Μη εμφανίσημο';
$strings['Show Summary'] = 'Προβολή Περίληψης';
$strings['Add Schedule'] = 'Πρόσθεση Προγράμματος';
$strings['Edit Schedule'] = 'Επεξεργασία Προγράμματος';
$strings['No'] = 'Όχι';
$strings['Yes'] = 'Ναι';
$strings['Name'] = 'Ονοματεπώνυμο';
$strings['First Name'] = 'Όνομα';
$strings['Last Name'] = 'Επώνυμο';
$strings['Resource Name'] = 'Ονομα Πόρου';
$strings['Email'] = 'Email';
$strings['Institution'] = 'Οργανισμός';
$strings['Phone'] = 'Τηλέφωνο';
$strings['Password'] = 'Συνθηματικό';
$strings['Permissions'] = 'Δικαιώματα';
$strings['View information about'] = 'Προβολή πληροφοριών για τον χρήστη %s %s';
$strings['Send email to'] = 'Αποστολή email στον χρήστη %s %s';
$strings['Reset password for'] = 'Μηδενισμός κωδικού του χρήστη %s %s';
$strings['Edit permissions for'] = 'Επεξεργασία δικαιωμάτων του χρήστη %s %s';
$strings['Position'] = 'Θέση';
$strings['Password (6 char min)'] = 'Συνθηματικό (6 χαρακ. ελαχ.)';
$strings['Re-Enter Password'] = 'Επανεισαγωγή Συνθηματικού';

$strings['Sort by descending last name'] = 'Φιλτράρισμα ανά επώνυμο με φθίνουσα σειρά';
$strings['Sort by descending email address'] = 'Φιλτράρισμα ανά e-mail με φθίνουσα σειρά';
$strings['Sort by descending institution'] = 'Φιλτράρισμα ανά οργανισμό με φθίνουσα σειρά';
$strings['Sort by ascending last name'] = 'Φιλτράρισμα ανά επώνυμο με αύξουσα σειρά';
$strings['Sort by ascending email address'] = 'Φιλτράρισμα ανά e-mail με αύξουσα σειρά';
$strings['Sort by ascending institution'] = 'Φιλτράρισμα ανά οργανισμό με αύξουσα σειρά';
$strings['Sort by descending resource name'] = 'Φιλτράρισμα ανά όνομα πόρου με φθίνουσα σειρά';
$strings['Sort by descending location'] = 'Φιλτράρισμα ανά τοποθεσία με φθίνουσα σειρά';
$strings['Sort by descending schedule title'] = 'Φιλτράρισμα ανά τίτλο προγράμματος με φθίνουσα σειρά';
$strings['Sort by ascending resource name'] = 'Φιλτράρισμα ανά πόρο με αύξουσα σειρά';
$strings['Sort by ascending location'] = 'Φιλτράρισμα ανά τοποθεσία με αύξουσα σειρά';
$strings['Sort by ascending schedule title'] = 'Φιλτράρισμα ανά τίτλο προγράμματος με αύξουσα σειρά';
$strings['Sort by descending date'] = 'Φιλτράρισμα ανά ημερομηνία με φθίνουσα σειρά';
$strings['Sort by descending user name'] = 'Φιλτράρισμα ανά όνομα χρήστη με φθίνουσα σειρά';
$strings['Sort by descending resource name'] = 'Φιλτράρισμα ανά πόρο με φθίνουσα σειρά';
$strings['Sort by descending start time'] = 'Φιλτράρισμα ανά ώρα έναρξης με φθίνουσα σειρά';
$strings['Sort by descending end time'] = 'Φιλτράρισμα ανά ώρα λήξης με φθίνουσα σειρά';
$strings['Sort by ascending date'] = 'Φιλτράρισμα ανά ημερομηνία με αύξουσα σειρά';
$strings['Sort by ascending user name'] = 'Φιλτράρισμα ανά όνομα χρήστη με αύξουσα σειρά';
$strings['Sort by ascending resource name'] = 'Φιλτράρισμα ανά πόρο με αύξουσα σειρά';
$strings['Sort by ascending start time'] = 'Φιλτράρισμα ανά ώρα έναρξης με αύξουσα σειρά';
$strings['Sort by ascending end time'] = 'Φιλτράρισμα ανά ώρα λήξης με αύξουσα σειρά';
$strings['Sort by descending created time'] = 'Φιλτράρισμα ανά ημερομηνία δημιουργίας με φθίνουσα σειρά';
$strings['Sort by ascending created time'] = 'Φιλτράρισμα ανά ημερομηνία δημιουργίας με αύξουσα σειρά';
$strings['Sort by descending last modified time'] = 'Φιλτράρισμα ανά ημερομηνία μεταβολής με φθίνουσα σειρά';
$strings['Sort by ascending last modified time'] = 'Φιλτράρισμα ανά ημερομηνία μεταβολής με αύξουσα σειρά';
$strings['Sort by descending summary'] = 'Φιλτράρισμα ανά περίληψη με φθίνουσα σειρά';
$strings['Sort by ascending summary'] = 'Φιλτράρισμα ανά αρ.κυκλοφορίας με αύξουσα σειρά';

$strings['Search Users'] = 'Αναζήτηση Χρηστών';
$strings['Location'] = 'Τοποθεσία';
$strings['Schedule'] = 'Πρόγραμμα';
$strings['Phone'] = 'Τηλέφωνο';
$strings['Notes'] = 'Σημείωση';
$strings['Status'] = 'Κατάσταση';
$strings['All Schedules'] = 'Ολα τα Προγράμματα';
$strings['All Resources'] = 'Ολοι οι Πόροι';
$strings['All Users'] = 'Ολοι οι Χρήστες';

$strings['Edit data for'] = 'Επεξεργασία δεδομένων για %s';
$strings['Active'] = 'Ενεργός';
$strings['Inactive'] = 'Ανενεργός';
$strings['Toggle this resource active/inactive'] = 'Ενεργοποίηση/Απενεργοποίηση Πόρου';
$strings['Minimum Reservation Time'] = 'Ελάχιστος Χρόνος Κράτησης';
$strings['Maximum Reservation Time'] = 'Μέγιστος Χρόνος Κράτησης';
$strings['Auto-assign permission'] = 'Αυτόματη εκχώρηση δικαιωμάτων';
$strings['Add Resource'] = 'Προσθήκη Πόρου';
$strings['Edit Resource'] = 'Επεξεργασία Πόρου';
$strings['Allowed'] = 'Επιτρέπεται';
$strings['Notify user'] = 'Ενημέρωση χρήστη';
$strings['User Reservations'] = 'Κρατήσεις Χρηστών';
$strings['Date'] = 'Ημερομηνία';
$strings['User'] = 'Χρήστης';
$strings['Email Users'] = 'Αποστολή Email στους Χρήστες';
$strings['Subject'] = 'Θέμα';
$strings['Message'] = 'Μήνυμα';
$strings['Please select users'] = 'Παρακαλώ επιλέξτε χρήστες';
$strings['Send Email'] = 'Αποστολή Email';
$strings['problem sending email'] = 'Υπήρξε σφάλμα κατά την αποστολή του email. Παρακαλώ ξαναπροσπαθείστε αργότερα.';
$strings['The email sent successfully.'] = 'Το email εστάλη με επιτυχία.';
$strings['do not refresh page'] = 'Παρακαλώ <u>μην</u> ανανεώσετε την σελίδα αυτή. Αν το κάνετε, το email θα ξανασταλθεί.';
$strings['Return to email management'] = 'Επιστροφή στην διαχείριση email';
$strings['Please select which tables and fields to export'] = 'Παρακαλώ επιλέξτε πίνακες και πεδία προς εξαγωγή:';
$strings['all fields'] = '- όλα τα πεδία -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = 'Απλό κείμενο';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = 'Εξαγωγή Δεδομένων';
$strings['Reset Password for'] = 'Μηδενισμός Κωδικού για τον χρήστη %s';
$strings['Please edit your profile'] = 'Παρακαλώ μεταβάλλετε το προφίλ σας';
$strings['Please register'] = 'Παρακαλώ καταχωρείστε τα στοιχεία σας';
$strings['Email address (this will be your login)'] = 'Διεύθυνση Email (αποτελεί και τον κωδικό χρήστη)';
$strings['Keep me logged in'] = 'Να παραμείνω συνδεδεμένος <br/>(απαιτεί cookies)';
$strings['Edit Profile'] = 'Επεξεργασία Προφίλ';
$strings['Register'] = 'Καταχώρηση';
$strings['Please Log In'] = 'Παρακαλώ Συνδεθείτε';
$strings['Email address'] = 'Διεύθυνση Email';
$strings['Password'] = 'Κωδικός';
$strings['First time user'] = 'Νέος χρήστης?';
$strings['Click here to register'] = 'Πατήστε εδώ για καταχώρηση των στοιχείων σας';
$strings['Register for'] = 'Καταχώρηση Στοιχείων';
$strings['Log In'] = 'Σύνδεση';
$strings['View Schedule'] = 'Προβολή Προγράμματος';
$strings['View a read-only version of the schedule'] = 'Εμφάνιση μιας αποκλειστικά αναγνώσιμης έκδοσης του προγράμματος';
$strings['I Forgot My Password'] = 'Ξέχασα το Συνθηματικό μου';
$strings['Retreive lost password'] = 'Επανάκτηση χαμένου συνθηματικού';
$strings['Get online help'] = 'Βοήθεια';
$strings['Language'] = 'Γλώσσα';
$strings['(Default)'] = '(Προεπιλογή)';

$strings['My Announcements'] = 'Οι Ανακοινώσεις μου';
$strings['My Reservations'] = 'Κατάλογος Κρατήσεων';
$strings['My Permissions'] = 'Τα Δικαιώματά μου';
$strings['My Quick Links'] = 'Οι Γρήγοροι Σύνδεσμοί μου';
$strings['Announcements as of'] = 'Ανακοινώσεις της %s';
$strings['There are no announcements.'] = 'Δεν υπάρχουν ανακοινώσεις.';
$strings['Resource'] = 'Πόρος';
$strings['Created'] = 'Δημιουργήθηκε';
$strings['Last Modified'] = 'Τελευταία Επεξεργασία';
$strings['View this reservation'] = 'Προβολή αυτής της κράτησης';
$strings['Modify this reservation'] = 'Επεξεργασία αυτής της κράτησης';
$strings['Delete this reservation'] = 'Διαγραφή αυτής της κράτησης';
$strings['Bookings'] = 'Δεσμεύσεις';				// @since 1.2.0

$strings['Change My Profile Information/Password'] = 'Αλλαγή Προφίλ';		// @since 1.2.0
$strings['Manage My Email Preferences'] = 'Επιλογές Email';				// @since 1.2.0
$strings['Manage Schedules'] = 'Διαχείριση Προγραμμάτων';
$strings['Manage Resources'] = 'Διαχείριση Πόρων';
$strings['Manage Users'] = 'Διαχείριση Χρηστών';
$strings['Manage Reservations'] = 'Διαχείριση Κρατήσεων';
$strings['Manage Blackout Times'] = 'Διαχείριση Μη Διαθέσιμων Περιόδων';
$strings['Mass Email Users'] = 'Μαζική αποστολή Email στους Χρήστες';
$strings['Search Scheduled Resource Usage'] = 'Αναζήτηση Κρατήσεων';		// @since 1.2.0
$strings['Export Database Content'] = 'Εξαγωγή Περιεχομένου Βάσης';
$strings['View System Stats'] = 'Εμφάνιση Στατιστικών Συστήματος';
$strings['Email Administrator'] = 'Αποστολή Email στον Διαχειριστή';

$strings['Email me when'] = 'Αποστολή Email όταν:';
$strings['I place a reservation'] = 'Καταχωρώ μια κράτηση';
$strings['My reservation is modified'] = 'Η κράτησή μου αλλάξει';
$strings['My reservation is deleted'] = 'Η κράτησή μου διαγραφεί';
$strings['I prefer'] = 'Προτιμώ:';
$strings['Your email preferences were successfully saved'] = 'Οι επιλογές σας email αποθηκεύθηκαν με επιτυχία!';
$strings['Return to My Control Panel'] = 'Επιστροφή στον Πίνακα Ελέγχου';

$strings['Please select the starting and ending times'] = 'Παρακαλώ επιλέξτε τους χρόνους έναρξης και λήξης:';
$strings['Please change the starting and ending times'] = 'Παρακαλώ μεταβάλλετε τους χρόνους έναρξης και λήξης:';
$strings['Reserved time'] = 'Χρόνος κράτησης:';
$strings['Minimum Reservation Length'] = 'Ελάχιστος Χρόνος Κράτησης:';
$strings['Maximum Reservation Length'] = 'Μέγιστος Χρόνος Κράτησης:';
$strings['Expected Reservation Length'] = 'Εκτιμώμενος Χρόνος Ελέγχου:';
$strings['Reserved for'] = 'Κρατήθηκε για:';
$strings['Will be reserved for'] = 'Θα κρατηθεί για:';
$strings['N/A'] = 'Μ/Δ';
$strings['Update all recurring records in group'] = 'Ενημέρωση όλων των εγγραφών στην ομάδα?';
$strings['Delete?'] = 'Διαγραφή?';
$strings['Never'] = '-- Ποτέ --';
$strings['Days'] = 'Ημέρες';
$strings['Weeks'] = 'Εβδομάδες';
$strings['Months (date)'] = 'Μήνες (ημερομηνία)';
$strings['Months (day)'] = 'Μήνες (ημέρα)';
$strings['First Days'] = 'Πρώτες Ημέρες';
$strings['Second Days'] = 'Δεύτερες Ημέρες';
$strings['Third Days'] = 'Τρίτες Ημέρες';
$strings['Fourth Days'] = 'Τέταρτες Ημέρες';
$strings['Last Days'] = 'Τελευταίες Ημέρες';
$strings['Repeat every'] = 'Επανάληψη κάθε:';
$strings['Repeat on'] = 'Επαναλήψη στις:';
$strings['Repeat until date'] = 'Επανάληψη μέχρι:';
$strings['Choose Date'] = 'Επιλογή Ημέρας';
$strings['Summary'] = 'Σχόλια ελέγχου - Αρ.κυκλοφορίας';

$strings['View schedule'] = 'Εμφάνιση προγράμματος:';
$strings['My Reservations'] = 'Κατάλογος Κρατήσεων';
$strings['My Past Reservations'] = 'Οι Προηγούμενες Κρατήσεις μου';
$strings['Other Reservations'] = 'Αλλες Κρατήσεις';
$strings['Other Past Reservations'] = 'Αλλες Προηγούμενες Κρατήσεις';
$strings['Blacked Out Time'] = 'Χρόνος Μη Διαθέσιμος';
$strings['Set blackout times'] = 'Ενεργοποίηση μη διαθέσιμης περιόδου για %s στις %s';
$strings['Reserve on'] = 'Κράτηση για %s στις %s';
$strings['Prev Week'] = '&laquo; Προηγ Εβδομ';
$strings['Jump 1 week back'] = 'Πίσω 1 εβδομάδα';
$strings['Prev days'] = '&#8249; Προηγ %d ημέρες';
$strings['Previous days'] = '&#8249; Προηγούμενες %d ημέρες';
$strings['This Week'] = 'Αυτήν την Εβδομάδα';
$strings['Jump to this week'] = 'Μετάβαση σε αυτήν την εβδομάδα';
$strings['Next days'] = 'Επόμενες %d ημέρες &#8250;';
$strings['Next Week'] = 'Επόμενη Εβδομάδα &raquo;';
$strings['Jump To Date'] = 'Μετάβαση σε Ημερομηνία';
$strings['View Monthly Calendar'] = 'Εμφάνιση Μηνιαίου Ημερολογίου';
$strings['Open up a navigational calendar'] = 'Ανοιγμα πλοηγίσιμου ημερολογίου';

$strings['View stats for schedule'] = 'Εμφάνιση στατιστικών για πρόγραμμα:';
$strings['At A Glance'] = 'Με μια ματιά';
$strings['Total Users'] = 'Συνολικοί Χρήστες:';
$strings['Total Resources'] = 'Συνολικοί Πόροι:';
$strings['Total Reservations'] = 'Συνολικές Κρατήσεις:';
$strings['Max Reservation'] = 'Μεγ Κράτηση:';
$strings['Min Reservation'] = 'Ελαχ Κράτηση:';
$strings['Avg Reservation'] = 'Μέση Κράτηση:';
$strings['Most Active Resource'] = 'Πιο Ενεργός Πόρος:';
$strings['Most Active User'] = 'Πιο Ενεργός Χρήστης:';
$strings['System Stats'] = 'Στατιστικά Συστήματος';
$strings['version'] = 'Εκδοση προγραμματιστή:';
$strings['Database backend'] = 'Υποδομή Βάσης:';
$strings['Database name'] = 'Ονομα Βάσης:';
$strings['PHP version'] = 'Εκδοση PHP:';
$strings['Server OS'] = 'Λειτουργικό Διακομιστή:';
$strings['Server name'] = 'Ονομα Διακομιστή:';
$strings['root directory'] = 'Αρχικός κατάλογος:';
$strings['Using permissions'] = 'Γίνεται χρήση δικαιωμάτων:';
$strings['Using logging'] = 'Γίνεται καταγραφή:';
$strings['Log file'] = 'Αρχείο καταγραφής:';
$strings['Admin email address'] = 'Διεύθυνση email διαχειριστή:';
$strings['Tech email address'] = 'Διεύθυνση email τεχνικής υποστήριξης:';
$strings['CC email addresses'] = 'Διεύθυνση email ειδοποίησης (CC):';
$strings['Reservation start time'] = 'Εναρξη Κράτησης:';
$strings['Reservation end time'] = 'Λήξη Κράτησης:';
$strings['Days shown at a time'] = 'Ημέρες που εμφανίζονται κάθε φορά:';
$strings['Reservations'] = 'Κρατήσεις';
$strings['Return to top'] = 'Επιστροφή στην κορυφή';
$strings['for'] = 'για';

$strings['Select Search Criteria'] = 'Επιλέξτε Κριτήρια Αναζήτησης';
$strings['Schedules'] = 'Προγράμματα:';
$strings['All Schedules'] = 'Ολα τα προγράμματα';
$strings['Hold CTRL to select multiple'] = 'Κρατήστε πατημένο το CTRL για επιλογή πολλαπλών';
$strings['Users'] = 'Χρήστες:';
$strings['All Users'] = 'Όλοι οι χρήστες';
$strings['Resources'] = 'Πόροι';
$strings['All Resources'] = 'Όλοι οι πόροι';
$strings['Starting Date'] = 'Ημερομηνία έναρξης:';
$strings['Ending Date'] = 'Ημερομηνία λήξης:';
$strings['Starting Time'] = 'Ώρα έναρξης:';
$strings['Ending Time'] = 'Ώρα λήξης:';
$strings['Output Type'] = 'Τύπος Εμφάνισης:';
$strings['Manage'] = 'Διαχείριση';
$strings['Total Time'] = 'Συνολικός χρόνος:';
$strings['Total hours'] = 'Συνολικές ώρες:';
$strings['% of total resource time'] = '% συνολικού χρόνου πόρων';
$strings['View these results as'] = 'Εμφάνιση των αποτελεσμάτων ως:';
$strings['Edit this reservation'] = 'Επεξεργασία αυτής της κράτησης';
$strings['Search Results'] = 'Αποτελέσματα Αναζήτησης';
$strings['Search Resource Usage'] = 'Αναζήτηση Χρήσης Πόρου';
$strings['Search Results found'] = 'Αποτελέσματα Αναζήτησης: Βρέθηκαν %d κρατήσεις';
$strings['Try a different search'] = 'Δοκιμάστε μια διαφορετική αναζήτηση';
$strings['Search Run On'] = 'Η αναζήτηση έτρεξε στις:';
$strings['Member ID'] = 'Αριθμός Μέλους';
$strings['Previous User'] = '&laquo; Προηγούμενος Χρήστης';
$strings['Next User'] = 'Επόμενος Χρήστης &raquo;';

$strings['No results'] = 'Δεν βρέθηκαν αποτελέσματα';
$strings['That record could not be found.'] = 'Αυτή η καταχώρηση δεν βρέθηκε.';
$strings['This blackout is not recurring.'] = 'Ο περιορισμένος αυτός χρόνος δεν επαναλαμβάνεται.';
$strings['This reservation is not recurring.'] = 'Αυτή η κράτηση δεν επαναλαμβάνεται.';
$strings['There are no records in the table.'] = 'Δεν υπάρχουν καταχωρήσεις στον πίνακα %s.';
$strings['You do not have any reservations scheduled.'] = 'Δεν έχετε προγραμματισμένες κρατήσεις.';
$strings['You do not have permission to use any resources.'] = 'Δεν έχεται δικαιώματα για χρήση κάποιου πόρου.';
$strings['No resources in the database.'] = 'Δεν υπάρχουν πόροι στην βάση.';
$strings['There was an error executing your query'] = 'Υπήρξε σφάλμα κατά την εκτέλεση της αναζήτησής σας:';

$strings['That cookie seems to be invalid'] = 'Το cookie αυτό δεν είναι έγκυρο';
$strings['We could not find that email in our database.'] = 'Το email αυτό δεν βρέθηκε στην βάση.';
$strings['That password did not match the one in our database.'] = 'Το συνθηματικό δεν ταιριάζει με αυτό που βρίσκεται αποθηκευμένος στην βάση.';
$strings['You can try'] = '<br />Μπορείτε να δοκιμάσετε:<br />Να καταχωρήσετε μια διεύθυνση email.<br />Η:<br />Να δοκιμάσετε να συνδεθείτε ξανά.';
$strings['A new user has been added'] = 'Ένας νέος χρήστης προστέθηκε';
$strings['You have successfully registered'] = 'Εχετε καταχωρήσει τα στοιχεία σας με επιτυχία!';
$strings['Continue'] = 'Συνέχεια...';
$strings['Your profile has been successfully updated!'] = 'Το προφίλ σας ενημερώθηκε με επιτυχία!';
$strings['Please return to My Control Panel'] = 'Παρακαλώ επιστρέψτε στον Πίνακα Ελέγχου';
$strings['Valid email address is required.'] = '- Η διεύθυνση email δεν είναι έγκυρη.';
$strings['First name is required.'] = '- Το ονομα είναι απαραίτητο.';
$strings['Last name is required.'] = '- Το επώνυμο είναι απαραίτητο.';
$strings['Phone number is required.'] = '- Ο αριθμός τηλεφώνου είναι απαραίτητος.';
$strings['That email is taken already.'] = '- Το email αυτό ήδη υπάρχει στην βάση.<br />Παρακαλώ ξαναπροσπαθείστε με μια διαφορετική διεύθυνση email.';
$strings['Min 6 character password is required.'] = '- Χρειάζονται τουλάχιστον 6 χαρακτήρες σαν κωδικός.';
$strings['Passwords do not match.'] = '- Οι κωδικοί δεν ταιριάζουν.';

$strings['Per page'] = 'Ανά σελίδα:';
$strings['Page'] = 'Σελίδα:';

$strings['Your reservation was successfully created'] = 'Η κράτησή σας δημιουργήθηκε με επιτυχία';
$strings['Your reservation was successfully modified'] = 'Η κράτησή σας τροποποιήθηκε με επιτυχία';
$strings['Your reservation was successfully deleted'] = 'Η κράτησή σας διαγράφηκε με επιτυχία';
$strings['Your blackout was successfully created'] = 'Η μη διαθέσιμη ώρα δημιουργήθηκε με επιτυχία';
$strings['Your blackout was successfully modified'] = 'Η μη διαθέσιμη ώρα τροποποιήθηκε με επιτυχία';
$strings['Your blackout was successfully deleted'] = 'Η μη διαθέσιμη ώρα διαγράφηκε με επιτυχία';
$strings['for the follwing dates'] = 'για τις ακόλουθες ημερομηνίες:';
$strings['Start time must be less than end time'] = 'Η ώρα έναρξης πρέπει να είναι μικρότερη ή ίση της ώρας λήξης.';
$strings['Current start time is'] = 'Η τωρινή ώρα έναρξης είναι:';
$strings['Current end time is'] = 'Η τωρινή ώρα λήξης είναι:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'Η διάρκεια της κράτησης δεν τηρεί τους περιορισμούς που έχουν τεθεί για τον πόρο αυτό.';
$strings['Your reservation is'] = 'Η κράτησή σας έχει ως ακολούθως:';
$strings['Minimum reservation length'] = 'Ελάχιστη διάρκεια κράτησης:';
$strings['Maximum reservation length'] = 'Μέγιστη διάρκεια κράτησης:';
$strings['You do not have permission to use this resource.'] = 'Δεν έχετε δικαιώματα χρήσης σε αυτόν τον πόρο.';
$strings['reserved or unavailable'] = 'Ο πόρος %s από %s έως %s είναι κρατημένος ή μη διαθέσιμος.';
$strings['Reservation created for'] = 'Δημιουργήθηκε κράτηση για %s';
$strings['Reservation modified for'] = 'Τροποποιήθηκε κράτηση για %s';
$strings['Reservation deleted for'] = 'Διαγράφηκε κράτηση για %s';
$strings['created'] = 'δημιουργήθηκε';
$strings['modified'] = 'τροποποιήθηκε';
$strings['deleted'] = 'διαγράφηκε';
$strings['Reservation #'] = 'Κράτηση #';
$strings['Contact'] = 'Επικοινωνία';
$strings['Reservation created'] = 'Η κράτηση δημιουργήθηκε';
$strings['Reservation modified'] = 'Η κράτηση τροποποιήθηκε';
$strings['Reservation deleted'] = 'Η κράτηση διαγράφηκε';

$strings['Reservations by month'] = 'Κρατήσεις ανά μήνα';
$strings['Reservations by day of the week'] = 'Κρατήσεις ανά ημέρα της εβδομάδας';
$strings['Reservations per month'] = 'Κρατήσεις ανά μήνα';
$strings['Reservations per user'] = 'Κρατήσεις ανά χρήστη';
$strings['Reservations per resource'] = 'Κρατήσεις ανά πόρο';
$strings['Reservations per start time'] = 'Κρατήσεις ανά ώρα έναρξης';
$strings['Reservations per end time'] = 'Κρατήσεις ανά ώρα λήξης';
$strings['[All Reservations]'] = '[Ολες οι κρατήσεις]';

$strings['Permissions Updated'] = 'Τα δικαιώματα χρήσης ενημερώθηκαν';
$strings['Your permissions have been updated'] = 'Τα δικαιώματα %s ενημερώθηκαν';
$strings['You now do not have permission to use any resources.'] = 'Δεν έχετε πλέον δικαιώματα χρήσης σε κανέναν πόρο.';
$strings['You now have permission to use the following resources'] = 'Εχετε πλέον δικαιώματα χρήσης στους ακόλουθους πόρους:';
$strings['Please contact with any questions.'] = 'Παρακαλώ επικοινωνήστε με τον %s για όποιες απορίες.';
$strings['Password Reset'] = 'Το συνθηματικό μηδενίστηκε';

$strings['This will change your password to a new, randomly generated one.'] = 'Η λειτουργία αυτή θα αλλάξει το συνθηματικό σας σε ένα νέο, τυχαίο συνθηματικό.';
$strings['your new password will be set'] = 'Αφού εισάγετε την διεύθυνση email σας και επιλέξετε την "Αλλαγή κωδικού", το νέο σας συνθηματικό θα αλλάξει στο σύστημα και θα σας αποσταλεί με email.';
$strings['Change Password'] = 'Αλλαγή συνθηματικού';
$strings['Sorry, we could not find that user in the database.'] = 'Ο χρήστης αυτός δεν βρέθηκε στην βάση.';
$strings['Your New Password'] = 'Το νέο σας συνθηματικό';
$strings['Your new passsword has been emailed to you.'] = 'Επιτυχία!<br />'
    			. 'Το νέο σας συνθηματικό σας απεστάλει με email.<br />'
    			. 'Παρακαλώ κοιτάξτε το ηλεκτρονικό σας ταχυδρομείο για το νέο σας συνθηματικό, ακολούθως <a href="index.php">Συνδεθείτε</a>'
    			. ' με το νέο αυτό συνθηματικό και αλλάξτε το άμεσα επιλέγοντας την &quot;Αλλαγή πληροφοριών του Προφίλ/Συνθηματικού μου&quot;'
    			. ' στον Πίνακα Ελέγχου.';

$strings['You are not logged in!'] = 'Δεν έχετε συνδεθεί!';

$strings['Heading Instructions for reservation'] = 'Οδηγίες συμπλήρωσης φόρμας κράτησης';
$strings['Search Summary'] = 'Αναζήτηση Σχολίων';
$strings['Memberid'] = 'Χρήστης';

$strings['We could not find that logon in our database.'] = 'Ο Κωδικός Χρήστη δεν βρέθηκε στην βάση.';	// @since 1.1.0

$strings['reserved or unavailable'] = '%s έως %s είναι κρατημένες ή μή διαθέσιμες.';	// @since 1.1.0

// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'Αυτό το σύστημα επιβάλλει να διαθέτετε διεύθυνση email.';
$strings['Invalid User Name/Password.'] = 'Ανύπαρκτος Κωδικός Χρήστη/Συνθηματικό.';
$strings['Pending User Reservations'] = 'Κρατήσεις σε Εκκρεμότητα';
$strings['Approve'] = 'Εγκριση';
$strings['Approve this reservation'] = 'Εγκριση αυτής της κράτησης';
$strings['Approve Reservations'] ='Εγκριση Κρατήσεων';

$strings['Announcement'] = 'Ανακοίνωση';
$strings['Number'] = 'Αριθμός';
$strings['Manage Announcements'] = 'Διαχείριση Ανακοινώσεων';
$strings['Add Announcement'] = 'Πρόσθεση Ανακοίνωσης';
$strings['Edit Announcement'] = 'Επεξεργασία Ανακοίνωσης';
$strings['All Announcements'] = 'Ολες οι Ανακοινώσεις';
$strings['Delete Announcements'] = 'Διαγραφή Ανακοινώσεων';
$strings['Use start date/time?'] = 'Χρήση ημέρας/ωρας έναρξης?';
$strings['Use end date/time?'] = 'Χρήση ημέρας/ωρας λήξης?';
$strings['Announcement text is required.'] = 'Ειναι απαραίτητο το κείμενο ανακοίνωσης.';
$strings['Announcement number is required.'] = 'Ειναι απαραίτητος ο αριθμός ανακοίνωσης.';

$strings['Pending Approval'] = 'Αναμένει Εγκριση';
$strings['My reservation is approved'] = 'Η κράτησή μου εγκρίθηκε';
$strings['This reservation must be approved by the administrator.'] = 'Αυτή η κράτηση πρέπει να εγκριθεί από τον Διαχειριστή.';
$strings['Approval Required'] = 'Χρειάζεται Εγκριση';
$strings['No reservations requiring approval'] = 'Καμμία κράτηση δεν χρειάζεται έγκριση';
$strings['Your reservation was successfully approved'] = 'Η κράτησή σας εγκρίθηκε με επιτυχία';
$strings['Reservation approved for'] = 'Εγκρίθηκε κράτηση για %s';
$strings['approved'] = 'εγκρίθηκε';
$strings['Reservation approved'] = 'Η κράτηση εγκρίθηκε';

$strings['Valid username is required'] = 'Απαιτείται έγκυρος Κωδικός Χρήστη';
$strings['That logon name is taken already.'] = 'Αυτός ο Κωδικός Χρήστη χρησιμοποιείται ήδη.';
$strings['this will be your login'] = '(αυτός θα είναι ο Κωδικός Χρήστη σας)';
$strings['Logon name'] = 'Κωδικός Χρήστη';
$strings['Your logon name is'] = 'Ο Κωδικός Χρήστη σας είναι %s';

$strings['Start'] = 'Από';
$strings['End'] = 'Εως';
$strings['Start date must be less than or equal to end date'] = 'Start date must be less than or equal to end date';
$strings['That starting date has already passed'] = 'Η ημερομηνία έναρξης που δώσατε έχει ήδη περάσει';
$strings['Basic'] = 'Βασικό';
$strings['Participants'] = 'Συμμετέχοντες';
$strings['Close'] = 'Κλείσιμο';
$strings['Start Date'] = 'Ημερομηνία Εναρξης';
$strings['End Date'] = 'Ημερομηνία Λήξης';
$strings['Minimum'] = 'Ελάχιστο';
$strings['Maximum'] = 'Μέγιστο';
$strings['Allow Multiple Day Reservations'] = 'Να επιτρέπονται Κρατήσεις πολλαπλών ημερών';
$strings['Invited Users'] = 'Προσκεκλημένοι Χρήστες';
$strings['Invite Users'] = 'Προσκαλέστε Χρήστες';
$strings['Remove Participants'] = 'Απαλειφή Συμμετεχόντων';
$strings['Reservation Invitation'] = 'Πρόσκληση Κράτησης';
$strings['Manage Invites'] = 'Διαχείρηση Συμμετεχόντων';
$strings['No invite was selected'] = 'Δεν επιλέχθηκε συμμετέχων';
$strings['reservation accepted'] = '%s απεδέχθει την Πρόσκλησή σας στις %s';
$strings['reservation declined'] = '%s αρνήθηκε την Πρόσκλησή σας στις %s';
$strings['Login to manage all of your invitiations'] = 'Συνδεθείτε για να διαχειριστείτε όλες τις προσκλήσεις σας';
$strings['Reservation Participation Change'] = 'Μεταβολή Συμμετοχής Κράτησης';
$strings['My Invitations'] = 'Οι Προσκλησεις μου';
$strings['Accept'] = 'Αποδοχή';
$strings['Decline'] = 'Αρνηση';
$strings['Accept or decline this reservation'] = 'Αποδοχή ή άρνηση της κράτησης αυτής';
$strings['My Reservation Participation'] = 'Συμμετοχές μου σε Κρατήσεις';
$strings['End Participation'] = 'Τέλος Συμμετοχής';
$strings['Owner'] = 'Ιδιοκτήτης';
$strings['Particpating Users'] = 'Συμμετέχοντες Χρήστες';
$strings['No advanced options available'] = 'Δεν υπάρχουν περαιτέρω επιλογές';
$strings['Confirm reservation participation'] = 'Επιβεβαίωση συμμετοχής στην κράτηση';
$strings['Confirm'] = 'Επιβεβαίωση';
$strings['Do for all reservations in the group?'] = 'Επανάληψη για όλες τις κρατήσεις της ομάδας?';

$strings['My Calendar'] = 'Το ημερολόγιό μου';
$strings['View My Calendar'] = 'Προβολή Ημερολογίου';
$strings['Participant'] = 'Συμμετέχων';
$strings['Recurring'] = 'Επαναλαμβανόμενο';
$strings['Multiple Day'] = 'Πολλαπλή Ημέρα';
$strings['[today]'] = '[σήμερα]';
$strings['Day View'] = 'Προβολή ανά Ημέρα';
$strings['Week View'] = 'Προβολή ανά Εβδομάδα';
$strings['Month View'] = 'Προβολή ανά Μήνα';
$strings['Resource Calendar'] = 'Ημερολόγιο Πόρου';
$strings['View Resource Calendar'] = 'Schedule Calendar';	// @since 1.2.0
$strings['Signup View'] = 'Προβολή ανά Εγγραφή';

$strings['Select User'] = 'Επιλέξτε Χρήστη';
$strings['Change'] = 'Αλλαγή';

$strings['Update'] = 'Ενημέρωση';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'Ενημέρωση του phpScheduleIt είναι διαθέσιμη για τις εκδόσεις από την 1.0.0 και μετά';
$strings['phpScheduleIt is already up to date'] = 'Το phpScheduleIt είναι ήδη ενημερωμένο';
$strings['Migrating reservations'] = 'Συρραφή Κρατήσεων';

$strings['Admin'] = 'Διαχειριστής';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = 'Μέγιστη Χωρητικότητα Συμμετεχόντων';
$strings['Leave blank for unlimited'] = 'Αφήστε το κενό για απεριόριστο';
$strings['Maximum of participants'] = 'Αυτός ο Πόρος έχει μέγιστη χωρητικότητα %s συμμετεχόντων';
$strings['That reservation is at full capacity.'] = 'Η κράτηση αυτή είναι πλήρης.';
$strings['Allow registered users to join?'] = 'Να επιτρέπεται σε καταχωρημένους χρήστες να συμμετέχουν?';
$strings['Allow non-registered users to join?'] = 'Να επιτρέπεται σε μη καταχωρημένους χρήστες να συμμετέχουν?';
$strings['Join'] = 'Συμμετοχή';
$strings['My Participation Options'] = 'Επιλογές Συμμετοχής μου';
$strings['Join Reservation'] = 'Συμμετοχή στην Κράτηση';
$strings['Join All Recurring'] = 'Συμμετοχή σε Ολες τις Επαναλαμβανόμενες';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = 'Δεν συμμετέχετε στις ακόλουθες ημερομηνίες κράτησης, καθώς είναι πλήρης.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = 'Εχετε ήδη προσκληθεί σε αυτήν την κράτηση. Παρακαλώ ακολουθήστε τις οδυγίες συμμετοχής που σας έχουν ήδη αποσταλλεί στο e-mail σας.';
$strings['Additional Tools'] = 'Πρόσθετα Εργαλεία';
$strings['Create User'] = 'Δημιουργία Χρήστη';
$strings['Check Availability'] = 'Ελεγχος Διαθεσιμότητας';
$strings['Manage Additional Resources'] = 'Διαχείριση Επιπρόσθετων Πόρων';
$strings['Number Available'] = 'Διαθέσιμος Αριθμός';
$strings['Unlimited'] = 'Απεριόριστο';
$strings['Add Additional Resource'] = 'Προσθήκη Επιπρόσθετου Πόρου';
$strings['Edit Additional Resource'] = 'Επεξεργασία Επιπρόσθετου Πόρου';
$strings['Checking'] = 'Ελεγχος';
$strings['You did not select anything to delete.'] = 'Δεν επελέγη κάτι προς διαγραφή.';
$strings['Added Resources'] = 'Πρόσθετοι Πόροι';
$strings['Additional resource is reserved'] = 'Ο πρόσθετος πόρος %s διαθέτει μόνο %s διαθέσιμα ανά περίπτωση';
$strings['All Groups'] = 'Ολες οι Ομάδες';
$strings['Group Name'] = 'Ονομα Ομάδας';
$strings['Delete Groups'] = 'Διαγραφή Ομάδων';
$strings['Manage Groups'] = 'Διαχείριση Ομάδων';
$strings['None'] = 'Καμμία';
$strings['Group name is required.'] = 'Το όνομα της Ομάδας είναι υποχρεωτικό.';
$strings['Groups'] = 'Ομάδες';
$strings['Current Groups'] = 'Τωρινές Ομάδες';
$strings['Group Administration'] = 'Διαχείριση Ομάδων';
$strings['Reminder Subject'] = 'Υπενθύμιση Κράτησης  - %s, %s %s';
$strings['Reminder'] = 'Υπενθύμιση';
$strings['before reservation'] = 'before reservation';
$strings['My Participation'] = 'Οι Συμμετοχές μου';
$strings['My Past Participation'] = 'Οι Προηγούμενες Συμμετοχές μου';
$strings['Timezone'] = 'Ζώνη Ωρας';
$strings['Export'] = 'Εξαγωγή';
$strings['Select reservations to export'] = 'Επιλογή κρατήσεων προς εξαγωγή';
$strings['Export Format'] = 'Είδος Εξαγωγής';
$strings['This resource cannot be reserved less than x hours in advance'] = 'Ο πόρος αυτός δεν μπορεί να κρατηθεί λιγότερο από %s ώρες πρωτύτερα';
$strings['This resource cannot be reserved more than x hours in advance'] = 'Ο πόρος αυτός δεν μπορεί να κρατηθεί περισσότερο από %s ώρες πρωτύτερα';
$strings['Minimum Booking Notice'] = 'Ελάχιστη Ενημέρωση Κράτησης';
$strings['Maximum Booking Notice'] = 'Μέγιστη Ενημέρωση Κράτησης';
$strings['hours prior to the start time'] = 'ώρες πριν από την ώρα έναρξης';
$strings['hours from the current time'] = 'ώρες πριν από την παρούσα ώρα';
$strings['Contains'] = 'Περιέχει';
$strings['Begins with'] = 'Αρχίζει με';
$strings['Minimum booking notice is required.'] = 'Απαιτείται η ελάχιστη ενημέρωση κράτησης.';
$strings['Maximum booking notice is required.'] = 'Απαιτείται η μέγιστη ενημέρωση κράτησης.';
$strings['Accessory Name'] = 'Ονομα Επιπρόσθετου Πόρου';
$strings['Accessories'] = 'Επιπρόσθετοι Πόροι';
$strings['All Accessories'] = 'Ολοι οι Επιπρόσθετοι Πόροι';
$strings['Added Accessories'] = 'Επιπρόσθετοι Πόροι';
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
				. "Εχετε εγγραφεί με επιτυχία με τα ακόλουθα στοιχεία:\r\n"
				. "Κωδικός Χρήστη: %s\r\n"
				. "Ονομα: %s %s \r\n"
				. "Τηλέφωνο: %s \r\n"
				. "Οργανισμός: %s \r\n"
				. "Θέση: %s \r\n\r\n"
				. "Παρακαλώ συνδεθείτε με το πρόγραμμα σε αυτήν τη διεύθυνση:\r\n"
				. "%s \r\n\r\n"
				. "Μπορείτε να βρείτε συνδέσμους στο online πρόγραμμα και να επεξεργαστείτε το προφίλ σας στον Πίνακα Ελέγχου.\r\n\r\n"
				. "Παρακαλούμε απευθύνεται οιαδήποτε ερωτηση σχετικά με το πρόγραμμα ή τον πόρο στην διεύθυνση %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "Διαχειριστή Συστήματος,\r\n\r\n"
					. "Ενας νέος χρήστης καταχώρησε τα στοιχεία του, ως ακολούθως:\r\n"
					. "Email: %s \r\n"
					. "Ονοματεπώνυμο: %s %s \r\n"
					. "Αριθμός Τηλεφώνου: %s \r\n"
					. "Οργανισμός: %s \r\n"
					. "Θέση: %s \r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "Εχετε %s με επιτυχία την κράτηση #%s.\r\n\r\n<br/><br/>"
			. "Παρακαλούμε χρησιμοποιείστε αυτόν τον αριθμό κράτησης οταν επικοινωνείτε με τον Διαχειριστή με οιαδήποτε ερώτηση.\r\n\r\n<br/><br/>"
			. "Μια κράτηση μεταξύ %s %s και %s %s για %s"
			. " βρισκόμενη σε %s εχει %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "Αυτή η κράτηση έχει επαναληφθεί τις ακόλουθες ημερομηνίες:\r\n<br/>";
$email['reservation_activity_3'] = "Ολες οι επαναλαμβανόμενες κρατήσεις στην ομάδα αυτήν επίσης %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "Δημιουργήθηκε η ακόλουθη περίληψη για την κράτηση αυτή:\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "Εάν τα αναγραφόμενα είναι λανθασμένα, παρακαλώ επικοινωνήστε με τον Διαχειριστή Συστήματος: %s"
			. " ή καλέστε %s.\r\n\r\n<br/><br/>"
			. "Μπορείτε να δείτε ή να τροποιήσετε τις κρατήσεις σας οποιαδήποτε στιγμή"
			. " συνδεόμενοι με το %s στη διεύθυνση:\r\n<br/>"
			. "<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "Παρακαλώ απευθύνετε όλες τις ερωτήσεις σας περί τεχνικών θεμάτων του παρόντος ιστοχώρου στην διεύθυνση <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
			. "Η κράτηση #%s εχει εγκριθεί.\r\n\r\n<br/><br/>"
			. "Παρακαλούμε χρησιμοποιείστε αυτόν τον αριθμό κράτησης οταν επικοινωνείτε με τον Διαχειριστή με οιαδήποτε ερώτηση.\r\n\r\n<br/><br/>"
			. "Μια κράτηση μεταξύ %s %s και %s %s για %s"
			. " βρισκόμενη σε %s εχει %s.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "Το συνθηματικό σας άλλαξε από τον Διαχειριστή Συστήματος.\r\n\r\n"
			. "Το προσωρινό σας συνθηματικό είναι:\r\n\r\n %s\r\n\r\n"
			. "Παρακαλώ χρησιμοποιήστε το προσωρινό συνθηματικό αυτό για να συνδεθείτε με το %s στην διεύθυνση %s"
			. " και αλλάξτε τον άμεσα, χρησιμοποιώντας την συντόμευση 'Αλλαγή πληροφοριών του Προφίλ/Συνθηματικού μου' στον πίνακα ΄Γρήγορων Συνδέσμων.\r\n\r\n"
			. "Παρακαλώ επικοινωνήστε με τον %s για όποιες ερωτήσεις.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n"
            . "Το νέο συνθηματικό για τον λογαριασμό %s είναι:\r\n\r\n"
            . "%s\r\n\r\n"
            . "Παρακαλώ Συνδεθείτε στην διεύθυνση %s"
            . "με το νέο αυτό συνθηματικό "
            . "και αλλάξτε το, επιλέγοτας την συντόμευση "
            . "Αλλαγή πληροφοριών του Προφίλ/Συνθηματικού μου  "
            . "στον Πίνακα Ελέγχου.\r\n\r\n"
            . "Παρακαλώ επικοινωνήστε με τον %s για όποιες ερωτήσεις.";

// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "Ο/Η %s σας έχει προσκαλέσει να συμμετάσχετε στην ακόλουθη κράτηση:\r\n\r\n"
		. "Πόρος: %s\r\n"
		. "Ημερομηνία Εναρξης: %s\r\n"
		. "Ωρα Εναρξης: %s\r\n"
		. "Ημερομηνία Λήξης: %s\r\n"
		. "Ωρα Λήξης: %s\r\n"
		. "Περίληψη: %s\r\n"
		. "Επαναλαμβανόμενες Ημερομηνίες (εάν υπάρχουν): %s\r\n\r\n"
		. "Για να δεχθείτε την πρόταση αυτή, πατήστε τον ακόλουθο σύνδεσμο (αντιγράψτε και επικολλήστε τον εάν δεν είναι ενεργοποιημένος) %s\r\n"
		. "Για να απορρίψετε την πρόταση αυτή, πατήστε τον ακόλουθο σύνδεσμο (αντιγράψτε και επικολλήστε τον εάν δεν είναι ενεργοποιημένος) %s\r\n"
		. "Για να αποδεχθείτε τις συγκεκριμένες ημερομηνίες ή να διαχειριστείτε τις κρατήσεις σας, παρακαλούμε συνδεθείτε στο %s στη διεύθυνση %s";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "Εχετε διαγραφεί από την ακόλουθη κράτηση:\r\n\r\n"
		. "Πόρος: %s\r\n"
		. "Ημερομηνία Εναρξης: %s\r\n"
		. "Ωρα Εναρξης: %s\r\n"
		. "Ημερομηνία Λήξης: %s\r\n"
		. "Ωρα Λήξης: %s\r\n"
		. "Περίληψη: %s\r\n"
		. "Επαναλαμβανόμενες Ημερομηνίες (εάν υπάρχουν): %s\r\n\r\n";

// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "Η κράτησή σας για %s από %s %s εως %s %s πλησιάζει.";
?>