<?php
/**
* French (fr) translation file.
* This also serves as the base translation file from which to derive
*
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator J. Pe. <jpe@chez.com>
* @translator Kim Phan <kimphan@users.sourceforge.net>
* @translator Benoit Mortier <benoit.mortier@opensides.be>
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
$days_full = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
// The three letter abbreviation
$days_abbr = array('Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam');
// The two letter abbreviation
$days_two  = array('Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa');
// The one letter abbreviation
$days_letter = array('D', 'L', 'M', 'M', 'J', 'V', 'S');

/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('Janvier', 'F�vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Ao�t', 'Septembre', 'Octobre', 'Novembre', 'D�cembre');
// The three letter month name
$months_abbr = array('Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec');

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
$strings['hours'] = 'heures';
$strings['minutes'] = 'minutes';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = 'mm';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = 'jj';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = 'aaaa';
$strings['am'] = 'am';
$strings['pm'] = 'pm';

$strings['Administrator'] = 'Administrateur';
$strings['Welcome Back'] = 'Bienvenue, %s';
$strings['Log Out'] = 'Quitter';
$strings['My Control Panel'] = 'Mon panneau de contr�le';
$strings['Help'] = 'Aide';
$strings['Manage Schedules'] = 'Organisation de la planification';
$strings['Manage Users'] ='Gestion utilisateurs';
$strings['Manage Resources'] ='Gestion des Ressources';
$strings['Manage User Training'] ='Gestion de l\'entrainement des utilisateurs';
$strings['Manage Reservations'] ='Gestion des r�servations';
$strings['Email Users'] ='Message �lectronique aux utilisateurs';
$strings['Export Database Data'] = 'Exportation des donn�es';
$strings['Reset Password'] = 'R�-initialisation de mot de passe';
$strings['System Administration'] = 'Administration du systeme';
$strings['Successful update'] = 'Mise a jour r�ussie';
$strings['Update failed!'] = 'Modification �chou�e !';
$strings['Manage Blackout Times'] = 'Gestion du temps cach�';
$strings['Forgot Password'] = 'Oubli du mot de passe';
$strings['Manage My Email Contacts'] = 'Gestion des mes correspondants';
$strings['Choose Date'] = 'Choisir une date';
$strings['Modify My Profile'] = 'Modification de mon profil';
$strings['Register'] = 'Enregistrer';
$strings['Processing Blackout'] = 'Execution du temps cach�';
$strings['Processing Reservation'] = 'Mise en oeuvre des r�servations';
$strings['Online Scheduler [Read-only Mode]'] = 'Planificateur en ligne [Mode lecture-seule]';
$strings['Online Scheduler'] = 'Planificateur en ligne';
$strings['phpScheduleIt Statistics'] = 'statistiques de phpScheduleIt';
$strings['User Info'] = 'Info Utilisateur:';

$strings['Could not determine tool'] = 'Outil non identifiable. S.V.P Essayez encore � partir du panneau de contr�le.';
$strings['This is only accessable to the administrator'] = 'Ceci n\'est accessible qu\'� l\'administrateur';
$strings['Back to My Control Panel'] = 'Retour � mon panneau de contr�le';
$strings['That schedule is not available.'] = 'Cette planification n\'est pas disponible.';
$strings['You did not select any schedules to delete.'] = 'Vous n\'avez s�lectionn� aucune planification � effacer.';
$strings['You did not select any members to delete.'] = 'Vous n\'avez s�l�ctionn� aucun membre � supprimer.';
$strings['You did not select any resources to delete.'] = 'Vous n\'avez s�l�ctionn� aucune ressource � supprimer.';
$strings['Schedule title is required.'] = 'La planification requiert un titre.';
$strings['Invalid start/end times'] = 'Heure de d�but ou de fin invalide';
$strings['View days is required'] = 'Jours de vision (?) requis';
$strings['Day offset is required'] = 'Plage horaire du jour requise';
$strings['Admin email is required'] = 'L\'adresse �lectronique de l\'administrateur est requise';
$strings['Resource name is required.'] = 'Le nom de la ressource est requise.';
$strings['Valid schedule must be selected'] = 'Une planification valide est requise';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'Le temps minimum de r�servation doit �tre inf�rieur ou �gal au temps de r�servation maxium.';
$strings['Your request was processed successfully.'] = 'Votre demande a �t� correctement enregistr�e.';
$strings['Go back to system administration'] = 'Retour � l\'administration du syst�me.';
$strings['Or wait to be automatically redirected there.'] = 'ou attendre d\'y �tre automatiquement redirig�.';
$strings['There were problems processing your request.'] = 'Des difficult�s ont �t� rencontr�es lors de l\'ex�cution de votre demande.';
$strings['Please go back and correct any errors.'] = 'Merci de bien vouloir retourner corriger les erreurs eventuelles.';
$strings['Login to view details and place reservations'] = 'Connectez vous pour voir les d�tails et �ffectuer des reservations';
$strings['Memberid is not available.'] = 'L\'identifiant de l\'utilisateur: %s n\'est pas disponible.';

$strings['Schedule Title'] = 'Titre de la planification';
$strings['Start Time'] = 'Heure de d�but';
$strings['End Time'] = 'Heure de fin';
$strings['Time Span'] = 'Dur�e';
$strings['Weekday Start'] = 'Jour de d�but';
$strings['Admin Email'] = 'Adresse de messagerie de l\'administrateur';

$strings['Default'] = 'D�faut';
$strings['Reset'] = 'R�-initialisation';
$strings['Edit'] = 'Mise � jour';
$strings['Delete'] = 'Effacement';
$strings['Cancel'] = 'Annulation';
$strings['View'] = 'Visualisation';
$strings['Modify'] = 'Modification';
$strings['Save'] = 'Sauvegarde';
$strings['Back'] = 'Retour';
$strings['Next'] = 'Suivant';
$strings['Close Window'] = 'Fermeture de fen�tre';
$strings['Search'] = 'Recherche';
$strings['Clear'] = 'Effacement';

$strings['Days to Show'] = 'Jours � visualiser';
$strings['Reservation Offset'] = 'P�riode de r�servation';
$strings['Hidden'] = 'Cach�';
$strings['Show Summary'] = 'Visualisation du sommaire';
$strings['Add Schedule'] = 'Ajout d\'une planification';
$strings['Edit Schedule'] = 'Modification d\'une planification';
$strings['No'] = 'Non';
$strings['Yes'] = 'Oui';
$strings['Name'] = 'Nom';
$strings['First Name'] = 'Pr�nom';
$strings['Last Name'] = 'Nom de famille';
$strings['Resource Name'] = 'Nom de la Ressource';
$strings['Email'] = 'Adresse de messagerie';
$strings['Institution'] = 'Soci�t�';
$strings['Phone'] = 'T�l�phone';
$strings['Password'] = 'Mot de passe';
$strings['Permissions'] = 'Permissions';
$strings['View information about'] = 'Visualisation des information de %s %s';
$strings['Send email to'] = 'Envoi d\'un message �lectronique �  %s %s';
$strings['Reset password for'] = 'R�-initialisation du mot de passe de %s %s';
$strings['Edit permissions for'] = 'Modification des privil�ges pour %s %s';
$strings['Position'] = 'Position';
$strings['Password (6 char min)'] = 'Mot de passe (%s char min)';
$strings['Re-Enter Password'] = 'Re-Entrer le mot de passe';

$strings['Sort by descending last name'] = 'Tri d�croissant par nom de famille';
$strings['Sort by descending email address'] = 'Tri d�croissant par adresse �lectronique';
$strings['Sort by descending institution'] = 'Tri d�croissant par soci�t�';
$strings['Sort by ascending last name'] = 'Tri croissant par nom de famille';
$strings['Sort by ascending email address'] = 'Tri croissant par adresse �l�ctronique';
$strings['Sort by ascending institution'] = 'Tri croissant par soci�t�';
$strings['Sort by descending resource name'] = 'Tri d�croissant par nom de ressource';
$strings['Sort by descending location'] = 'Tri d�croissant par emplacement';
$strings['Sort by descending schedule title'] = 'Tri d�croissant par titre de planification';
$strings['Sort by ascending resource name'] = 'Tri croissant par nom de ressource';
$strings['Sort by ascending location'] = 'Tri croissant par emplacement';
$strings['Sort by ascending schedule title'] = 'Tri croissant pat titre de planification';
$strings['Sort by descending date'] = 'Tri d�croissant par date';
$strings['Sort by descending user name'] = 'Tri d�croissant par nom d\'utilisateur';
// duplicate $strings['Sort by descending resource name'] = 'Tri d�croissant par nom de ressource';
$strings['Sort by descending start time'] = 'Tri d�croissant par heure de d�but';
$strings['Sort by descending end time'] = 'Tri d�croissant par heure de fin';
$strings['Sort by ascending date'] = 'Tri croissant par date';
$strings['Sort by ascending user name'] = 'Tri croissant par nom d\'utilisateur';
$strings['Sort by ascending resource name'] = 'Tri croissant par nom de ressource';
$strings['Sort by ascending start time'] = 'Tri croissant par heure de d�but';
$strings['Sort by ascending end time'] = 'Tri croissant par heure de fin';
$strings['Sort by descending created time'] = 'Tri d�croissant par date de cr�ation';
$strings['Sort by ascending created time'] = 'Tri croissant par date de cr�ation';
$strings['Sort by descending last modified time'] = 'Tri d�croissant par heure de derni�re modification';
$strings['Sort by ascending last modified time'] = 'Tri croissant par heure de derni�re modification';

$strings['Search Users'] = 'Recherche utilisateurs';
$strings['Location'] = 'Emplacement';
$strings['Schedule'] = 'Planification';
$strings['Phone'] = 'T�l�phone';
$strings['Notes'] = 'Notes';
$strings['Status'] = 'Etat';
$strings['All Schedules'] = 'Toutes planifications';
$strings['All Resources'] = 'Toutes ressources';
$strings['All Users'] = 'Tout utilisateurs';

$strings['Edit data for'] = 'Modification des donn�es pour %s';
$strings['Active'] = 'Actif';
$strings['Inactive'] = 'Inactif';
$strings['Toggle this resource active/inactive'] = 'Bascule cette ressource active/inactive';
$strings['Minimum Reservation Time'] = 'P�riode minimum de reservation';
$strings['Maximum Reservation Time'] = 'P�riode maximum de reservation';
$strings['Auto-assign permission'] = 'Accord de permission automatique';
$strings['Add Resource'] = 'Ajout d\'une Ressource';
$strings['Edit Resource'] = 'Modification d\'une Ressource';
$strings['Allowed'] = 'Permis';
$strings['Notify user'] = 'Notification utilisateur';
$strings['User Reservations'] = 'Reservations de l\'utilisateur';
$strings['Date'] = 'Date';
$strings['User'] = 'Utilisateur';
$strings['Email Users'] = 'Adresse �lectronique de l\'utilisateur';
$strings['Subject'] = 'Sujet';
$strings['Message'] = 'Message';
$strings['Please select users'] = 'S.V.P. s�lectionner un/des utilisateurs';
$strings['Send Email'] = 'Envoi du message �lectronique';
$strings['problem sending email'] = 'D�sol�, des difficult�s on �t�s rencontr�es lors de l\'envoi du message. S.V.P. Essayez de nouveau plus tard.';
$strings['The email sent successfully.'] = 'Le message �lectronique a �t� envoy� avec succ�s.';
$strings['do not refresh page'] = 'S.V.P <u>ne pas</u> r�-actualiser cette page. Le faire enverait deux fois le message.';
$strings['Return to email management'] = 'Retour � la gestion des messages �lectroniques';
$strings['Please select which tables and fields to export'] = 'Merci de choisir les tables et les champs � exporter :';
$strings['all fields'] = '- tous les champs -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = 'Texte brut';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = 'Exporter les donn�es';
$strings['Reset Password for'] = 'R�-initialisation du mot de passe de  %s';
$strings['Please edit your profile'] = 'Merci de mettre votre profile � jour';
$strings['Please register'] = 'Merci de vous enregister';
$strings['Email address (this will be your login)'] = 'Adresse �lectronique (Ce sera votre nom de connexion)';
$strings['Keep me logged in'] = 'Maintenir ma connexion <br/>(utilisation de cookies requise )';
$strings['Edit Profile'] = 'Modification du profil';
$strings['Register'] = 'Enregistrer';
$strings['Please Log In'] = 'Merci de vous identifier';
$strings['Email address'] = 'Adresse �lectronique';
$strings['Password'] = 'Mot de passe';
$strings['First time user'] = 'Si vous venez pour la premi�re fois?';
$strings['Click here to register'] = 'Cliquez ici pour vous enregistrer';
$strings['Register for phpScheduleIt'] = 'S\'enregistrer pour phpScheduleIt';
$strings['Log In'] = 'Se connecter';
$strings['View Schedule'] = 'Visualisation de planification';
$strings['View a read-only version of the schedule'] = 'Visualisation d\'une version en lecture seule d\'une planification';
$strings['I Forgot My Password'] = 'J\'ai oubli� mon mot de passe';
$strings['Retreive lost password'] = 'R�cup�rer un mot de passe oubli�';
$strings['Get online help'] = 'Obtenir de l\'aide en ligne';
$strings['Language'] = 'Langage';
$strings['(Default)'] = '(D�faut)';

$strings['My Announcements'] = 'Mes annonces';
$strings['My Reservations'] = 'Mes reservations';
$strings['My Permissions'] = 'Mes privil�ges';
$strings['My Quick Links'] = 'Mes liens rapides';
$strings['Announcements as of'] = 'Annonces de  %s';
$strings['There are no announcements.'] = 'Il n\'y pas d\'annonces.';
$strings['Resource'] = 'Ressource';
$strings['Created'] = 'Cr��';
$strings['Last Modified'] = 'Derni�re modification';
$strings['View this reservation'] = 'Visualisation de cette reservation';
$strings['Modify this reservation'] = 'Modification de cette reservation';
$strings['Delete this reservation'] = 'Effacement de cette reservation';
$strings['Go to the Online Scheduler'] = 'Allez sur le planificateur en ligne';
$strings['Change My Profile Information/Password'] = 'Changer mon Profil/Mot de passe';		// @since 1.2.0
$strings['Manage My Email Preferences'] = 'Pr�ferences de messagerie';				// @since 1.2.0
$strings['Manage Blackout Times'] = 'Gestion du temps masqu�';
$strings['Mass Email Users'] = 'Publipostage';
$strings['Search Scheduled Resource Usage'] = 'Chercher le taux d\'utilisation de la ressource r�serv�e';		// @since 1.2.0
$strings['Export Database Content'] = 'Exportation du contenu de la base de donn�es';
$strings['View System Stats'] = 'Visuallisation des statistiques syst�mes';
$strings['Email Administrator'] = 'Envoi d\'un message �lectronique � l\'administrateur';

$strings['Email me when'] = 'M\'envoyer un message �lectronique chaque fois que :';
$strings['I place a reservation'] = 'j\'effectue une reservation';
$strings['My reservation is modified'] = 'ma r�servation est modifi�e';
$strings['My reservation is deleted'] = 'ma r�servation est effac�e';
$strings['I prefer'] = 'Je pr�f�re:';
$strings['Your email preferences were successfully saved'] = 'Vos messages �lectronique ont �t�s sauvegard�s!';
$strings['Return to My Control Panel'] = 'Retour � mon Panneau de contr�le';

$strings['Please select the starting and ending times'] = 'Merci de choisir les heures de d�but et de fin :';
$strings['Please change the starting and ending times'] = 'Merci de modifier les heures de d�but et de fin';
$strings['Reserved time'] = 'Heure de r�servation :';
$strings['Minimum Reservation Length'] = 'Dur�e minimum de r�servation :';
$strings['Maximum Reservation Length'] = 'Dur�e maximum de r�servation :';
$strings['Reserved for'] = 'R�serv� pour :';
$strings['Will be reserved for'] = 'sera r�serv� pour:';
$strings['N/A'] = 'N/A';
$strings['Update all recurring records in group'] = 'Modifie tous les enregistrements cycliques dans le groupe?';
$strings['Delete?'] = 'Efface ?';
$strings['Never'] = '-- Jamais --';
$strings['Days'] = 'Jours';
$strings['Weeks'] = 'Semaines';
$strings['Months (date)'] = 'Mois (date)';
$strings['Months (day)'] = 'Mois (jour)';
$strings['First Days'] = 'Premiers jour';
$strings['Second Days'] = 'Second jour';
$strings['Third Days'] = 'Troisi�me jour';
$strings['Fourth Days'] = 'Quatri�me jour';
$strings['Last Days'] = 'Dernier jour';
$strings['Repeat every'] = 'R�p�te tous les :';
$strings['Repeat on'] = 'R�pete chaque:';
$strings['Repeat until date'] = 'R�p�te juqu\'� :';
$strings['Choose Date'] = 'Choisir une date';
$strings['Summary'] = 'R�sum�';

$strings['View schedule'] = 'Visualisation de la planification:';
$strings['My Reservations'] = 'Mes r�servations';
$strings['My Past Reservations'] = 'Mes anciennes r�servations';
$strings['Other Reservations'] = 'Les autres reservations';
$strings['Other Past Reservations'] = 'Les autes anciennes r�servations';
$strings['Blacked Out Time'] = 'Temps masqu�';
$strings['Set blackout times'] = 'Etablissement du temps masqu� %s sur %s';
$strings['Reserve on'] = 'Reserve %s sur %s';
$strings['Prev Week'] = '&laquo; Sem. Pr�c.';
$strings['Next Week'] = 'Sem. Suiv. &raquo;';
$strings['Jump 1 week back'] = 'Sauter 1 Sem. en Arr.';
$strings['Prev days'] = '&#8249; %d jours pr�c.';
$strings['Previous days'] = '&#8249; %d jours pr�c�dents';
$strings['This Week'] = 'Cette semaine';
$strings['Jump to this week'] = 'ALler � cette semaine';
$strings['Next days'] = 'prochains %d jours &#8250;';
$strings['Jump To Date'] = 'Aller � cette date';
$strings['View Monthly Calendar'] = 'Visualisation du calendrier mensuel';
$strings['Open up a navigational calendar'] = 'Ouverture du calendrier de navigation';

$strings['View stats for schedule'] = 'Visualisation des statistique pour la planification:';
$strings['At A Glance'] = 'D\'un coup d\'oeil';
$strings['Total Users'] = 'Total utilisateurs:';
$strings['Total Resources'] = 'Total Ressources:';
$strings['Total Reservations'] = 'Total Reservations:';
$strings['Max Reservation'] = 'Max Reservation:';
$strings['Min Reservation'] = 'Min Reservation:';
$strings['Avg Reservation'] = 'Moy Reservation:';
$strings['Most Active Resource'] = 'Ressource la plus active :';
$strings['Most Active User'] = 'L\'utilisateur le plus actif :';
$strings['System Stats'] = 'Statistiques syst�mes';
$strings['phpScheduleIt version'] = 'phpScheduleIt version:';
$strings['Database backend'] = 'Base de donn�es principale :';
$strings['Database name'] = 'Nom de base de donn�es :';
$strings['PHP version'] = 'PHP version:';
$strings['Server OS'] = 'Server OS:';
$strings['Server name'] = 'Server name:';
$strings['phpScheduleIt root directory'] = 'r�pertoire racine de phpScheduleIt:';
$strings['Using permissions'] = 'Utilise les permissions:';
$strings['Using logging'] = 'Utilise les fichiers historiques:';
$strings['Log file'] = 'Fichier historique :';
$strings['Admin email address'] = 'Adresse de messagerie administrateur:';
$strings['Tech email address'] = 'Adresse de messagerie technique:';
$strings['CC email addresses'] = 'Adresses de messagerie � CC:';
$strings['Reservation start time'] = 'Heure de d�but de reservation :';
$strings['Reservation end time'] = 'Heure de fin de reservation :';
$strings['Days shown at a time'] = 'Nombre de jours visualis�s d\'un coup:';
$strings['Reservations'] = 'R�servations';
$strings['Return to top'] = 'Retour en haut';
$strings['for'] = 'pour';

$strings['Select Search Criteria'] = 'Choix des crit�res de s�lection';
$strings['Schedules'] = 'Planifications:';
$strings['All Schedules'] = 'Toutes planifications';
$strings['Hold CTRL to select multiple'] = 'Maintenir la touche CTRL pour un choix multiple';
$strings['Users'] = 'Utilisateurs :';
$strings['All Users'] = 'Tout utilisateurs';
$strings['Resources'] = 'Ressources';
$strings['All Resources'] = 'Toutes Ressources';
$strings['Starting Date'] = 'Date de d�but :';
$strings['Ending Date'] = 'Date de fin :';
$strings['Starting Time'] = 'Heure de d�but :';
$strings['Ending Time'] = 'Heure de fin :';
$strings['Output Type'] = 'Type d\'affichage :';
$strings['Manage'] = 'G�rer';
$strings['Total Time'] = 'Temps total :';
$strings['Total hours'] = 'Heures totales :';
$strings['% of total resource time'] = '% du temps de ressource total';
$strings['View these results as'] = 'Visualisation de ce r�sultat comme :';
$strings['Edit this reservation'] = 'Modifie cette r�servation';
$strings['Search Results'] = 'R�sultats de la recherche';
$strings['Search Resource Usage'] = 'Cherche l\'utilisation des ressources';
$strings['Search Results found'] = 'R�sultats de la recherche: %d reservations trouv�es';
$strings['Try a different search'] = 'Essayer une recherche diff�rente';
$strings['Search Run On'] = 'La recherche s\'effectue sur :';
$strings['Member ID'] = 'Member ID';
$strings['Previous User'] = '&laquo; Utilisateur pr�c�dent';
$strings['Next User'] = 'Utilisateur suivant &raquo;';

$strings['No results'] = 'Pas de r�sultat';
$strings['That record could not be found.'] = 'Cet enregistrement ne peut �tre trouv�.';
$strings['This blackout is not recurring.'] = 'Ce temps masqu� ne se reproduit pas.';
$strings['This reservation is not recurring.'] = 'Cette r�servation n\'est pas cyclique.';
$strings['There are no records in the table.'] = 'Il n\'y a aucun enregistrements dans cette table %s.';
$strings['You do not have any reservations scheduled.'] = 'Vous n\'avez aucune reservation planifi�e.';
$strings['You do not have permission to use any resources.'] = 'Vous n\'avez pas la permission d\'utilser les ressources.';
$strings['No resources in the database.'] = 'Il n\'y a aucune ressource d�finie dans la base de donn�es.';
$strings['There was an error executing your query'] = 'Une erreur s\'est produite lors de l\'ex�cution du la requ�te:';

$strings['That cookie seems to be invalid'] = 'Ce cookie semble invalide';
$strings['We could not find that logon in our database.'] = 'Identifiant de connexion inconnu dans notre database.';  // @since 1.1.0
$strings['That password did not match the one in our database.'] = 'Le mot de passe n\'est pas identique � celui contenu dans la base de donn�es.';
$strings['You can try'] = '<br />Vous pouvez essayer:<br />d\'enregister une adresse email.<br />Ou :<br />Essayer de vous connecter � nouveau.';
$strings['A new user has been added'] = 'Un nouvel utilisateur a �t� ajout�';
$strings['You have successfully registered'] = 'Vous avez �t� enregistr� correctement!';
$strings['Continue'] = 'Continuer...';
$strings['Your profile has been successfully updated!'] = 'Votre profil a �t� correctement modifi�!';
$strings['Please return to My Control Panel'] = 'Merci de retourner au panneau de contr�le';
$strings['Valid email address is required.'] = '- Une adresse �lectronique valide est requise.';
$strings['First name is required.'] = '- Le pr�nom est requis.';
$strings['Last name is required.'] = '- Le nom de famille est requis.';
$strings['Phone number is required.'] = '- Le num�ro de t�l�phone est requis.';
$strings['That email is taken already.'] = '- Cet adresse �lectronique est d�j� utilis�e.<br />Merci d\'essayer de nouveau avec une autre adresse �lectronique.';
$strings['Min 6 character password is required.'] = '- Le mot de passe requiert un minimum de %s caract�res.';
$strings['Passwords do not match.'] = '- Les mots de passe ne correspondent pas.';

$strings['Per page'] = 'Par page:';
$strings['Page'] = 'Page:';

$strings['Your reservation was successfully created'] = 'Votre r�servation a �t� correctement enregistr�e';
$strings['Your reservation was successfully modified'] = 'Votre r�servation a �t� correctement modifi�e';
$strings['Your reservation was successfully deleted'] = 'Votre r�servation a �t� correctement effac�e';
$strings['Your blackout was successfully created'] = 'Votre temps masqu� a �t� correctement cr��';
$strings['Your blackout was successfully modified'] = 'Votre temps masqu� a �t� correctement modifi�';
$strings['Your blackout was successfully deleted'] = 'Votre temps masqu� a �t� correctement effac�';
$strings['for the follwing dates'] = 'pour les dates suivantes:';
$strings['Start time must be less than end time'] = 'L\'heure de d�but doit �tre inf�rieure � l\'heure de fin.';
$strings['Current start time is'] = 'L\'actuelle heure de d�but est :';
$strings['Current end time is'] = 'L\'actuelle heure de fin est :';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'La dur�e de reservation n\'est pas compatible avec la dur�e de r�servation autoris�e.';
$strings['Your reservation is'] = 'Votre r�servation est :';
$strings['Minimum reservation length'] = 'Dur�e minimum de r�servation :';
$strings['Maximum reservation length'] = 'Dur�e maximum de r�servation :';
$strings['You do not have permission to use this resource.'] = 'Vous n\'avez pas les droits d\'utilisation de cette ressource.';
$strings['reserved or unavailable'] = '%s � %s est reserv� ou indisponible.';   // @since 1.1.0
$strings['Reservation created for'] = 'Reservation cr��e pour %s';
$strings['Reservation modified for'] = 'Reservation modifi�e pour %s';
$strings['Reservation deleted for'] = 'Reservation effac�e %s';
$strings['created'] = 'cr��';
$strings['modified'] = 'modifi�';
$strings['deleted'] = 'effac�';
$strings['Reservation #'] = 'Reservation #';
$strings['Contact'] = 'Contact';
$strings['Reservation created'] = 'Reservation cr��e';
$strings['Reservation modified'] = 'Reservation modifi�e';
$strings['Reservation deleted'] = 'Reservation effac�e';

$strings['Reservations by month'] = 'R�servations par mois';
$strings['Reservations by day of the week'] = 'R�servations par jour de la semaine';
$strings['Reservations per month'] = 'R�servations par mois';
$strings['Reservations per user'] = 'R�servations par utilisateur';
$strings['Reservations per resource'] = 'R�servations par ressource';
$strings['Reservations per start time'] = 'R�servations par date de d�but';
$strings['Reservations per end time'] = 'R�servations par date de fin';
$strings['[All Reservations]'] = 'Toutes les r�servations';

$strings['Permissions Updated'] = 'Privil�ges modifi�s';
$strings['Your permissions have been updated'] = 'Vos %s privil�ges ont �t� modifi�s';
$strings['You now do not have permission to use any resources.'] = 'Vous n\'avez les droits d\'utilisation d\'aucune ressource.';
$strings['You now have permission to use the following resources'] = 'Vous avez d�sormais les droits d\'utilisation des ressources suivantes :';
$strings['Please contact with any questions.'] = 'Merci de contacter %s pour toutes questions.';
$strings['Password Reset'] = 'R�-initialisation du mot de passe';

$strings['This will change your password to a new, randomly generated one.'] = 'Cela remplacera votre mot de passe par un mot de passe d�termin� de fa�on al�atoire.';
$strings['your new password will be set'] = 'Apr�s avoir indiqu� votre adresse �lectronique et cliqu� sur "Modification du mot de passe", votre nouveau mot de passe sera effectif et vous sera envoy�.';
$strings['Change Password'] = 'Modification du mot de passe';
$strings['Sorry, we could not find that user in the database.'] = 'D�sol� nous ne pouvons trouver cet utilisateur dans notre base de donn�es.';
$strings['Your New Password'] = 'Votre nouveau mot de passe %s ';
$strings['Your new passsword has been emailed to you.'] = 'Succ�s!<br />
          Votre nouveau mot de passe vous a �t� envoy� par message �lectronique.<br />
          Merci de contr�ler le contenu de votre boite aux lettres, puis <a href="index.php">Connectez vous</a>
          avec votre nouveau mot de passe et modifiez le en cliquant &quot;Modifie les information de mon profil/mot de passe&quot;
          dans mon Panneau de contr�le.';

$strings['You are not logged in!'] = 'Vous n\'�tes pas connect�!';

$strings['Setup'] = 'Installation';
$strings['Please log into your database'] = 'Merci de vous connecter � votre base de donn�es';
$strings['Enter database root username'] = 'Indiquez le nom de l\'administrateur de la base de donn�es:';
$strings['Enter database root password'] = 'Indiquez le mot de passe de l\'administrateur de la base de donn�es:';
$strings['Login to database'] = 'Connexion � la base de donn�es';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = 'L\'administrateur  <b>n\'est pas </b> requis. Tout utilisateur qui a les droits de cr�ation de tables est suffisant.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = 'Cela va installer toutes les bases et tables n�cessaire � phpScheduleIt.';
$strings['It also populates any required tables.'] = 'Cela remplit �galement toutes les tables n�cessaires.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = 'Attention: CELA VA EFFACER TOUTES LES DONNEES DANS LES BASES DE DONNEES PRECEDENTES DE phpScheduleIt !';
$strings['Not a valid database type in the config.php file.'] = 'Un type de base de donn�e invalide figure dans le script config.php.';
$strings['Database user password is not set in the config.php file.'] = 'Le mot de passe d\'acc�s � la base de donn�e n\'est pas indiqu� dans config.php.';
$strings['Database name not set in the config.php file.'] = 'Le nom de la base de donn�e n\'est pas indiqu� dans config.php.';
$strings['Successfully connected as'] = 'Connect� avec succ�s en tant que ';
$strings['Create tables'] = 'Cr�� les tables &gt;';
$strings['There were errors during the install.'] = 'Des erreurs se sont produites durant l\'installation. Il est possible que phpScheduleIt fonctionne correctement si les erreurs sont mineures.<br/><br/>'
  . 'Merci de poser toute question sur le forum <a href="http://sourceforge.net/forum/?group_id=95547">SourceForge</a>.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = 'Vous avez termin� d\'installer phpScheduleIt avec succ�s et �tes pr�t � l\'utiliser.';
$strings['Thank you for using phpScheduleIt'] = 'Merci de vous assurer de d�truire le r�pertoire \'install\'.'
  . ' C\'est essentiel car il contient des informations confidentielles d\'acc�s.'
  . ' Ne pas agir ainsi vous expose � des intrusions malveilantes de nature � d�truire votre site !'
  . '<br /><br />'
  . 'Merci d\'utiliser phpScheduleIt!';
$strings['This will update your version of phpScheduleIt from 0.9.3 to 1.0.0.'] = 'Ceci va mettre � jour votre phpScheduleIt de la verion 0.9.3 � 1.0.0.';
$strings['There is no way to undo this action'] = 'Il ne sera pas possible de revenir en arri�re apr�s cette action !';
$strings['Click to proceed'] = 'Cliquez pour ex�cuter';
$strings['This version has already been upgraded to 1.0.0.'] = 'Cette version a d�j� �t� mise � jour en 1.0.0.';
$strings['Please delete this file.'] = 'Merci de d�truire ce fichier.';
$strings['Successful update'] = 'La mise � jour s\'est d�roul�e avec succ�s';
$strings['Patch completed successfully'] = 'Le correctif a �t� appliqu� avec succ�s';
$strings['This will populate the required fields for phpScheduleIt 1.0.0 and patch a data bug in 0.9.9.'] = 'Cela va remplir les champs n�cessaires �  phpScheduleIt 1.0.0 and corriger un probl�me dans la 0.9.9.'
    . '<br />Il est seulement n�cessaire d\'ex�cuter ceci si vous proc�dez � une mise � jour manuelle d\' SQL ou que vous venez de 0.9.9';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = 'Si aucune valeur n\'est pr�cis�e, le mot de passe par d�faut sp�cifi� dans le fichier de configuration (config.php) sera utilis�.';
$strings['Notify user that password has been changed?'] = 'L\'utilisateur doit il �tre pr�venu que son mot de passe a �t� chang� ?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'Pour ce syst�me il est imp�ratif que vous poss�diez une adresse de messagerie �lectronique';
$strings['Invalid User Name/Password.'] = 'Nom d\'utilisateur ou mot de passe invalide.';
$strings['Pending User Reservations'] = 'R�servations en cours pour l\' utilisateur';
$strings['Approve'] = 'Confirme';
$strings['Approve this reservation'] = 'Approuvez cette r�servation';
$strings['Approve Reservations'] ='Approuvez ces r�servations';

$strings['Announcement'] = 'Annonce';
$strings['Number'] = 'Nombre';
$strings['Add Announcement'] = 'Ajouter une Annonce';
$strings['Edit Announcement'] = 'modifier une Annonce';
$strings['All Announcements'] = 'Toutes les Annonces';
$strings['Delete Announcements'] = 'Supprimer une Annonce';
$strings['Use start date/time?'] = 'Utiliser date/heure de d�but ?';
$strings['Use end date/time?'] = 'Utiliser date/heure de fin?';
$strings['Announcement text is required.'] = 'Le texte de l\'annonce est n�cessaire.';
$strings['Announcement number is required.'] = 'Le num�ro de l\'annonce est n�cessaire.';

$strings['Pending Approval'] = 'Approbation en cours';
$strings['My reservation is approved'] = 'Ma r�servation est approuv�e';
$strings['This reservation must be approved by the administrator.'] = 'Cette r�servation doit �tre approuv�e par l\'administrateur.';
$strings['Approval Required'] = 'Approbation n�cessaire';
$strings['No reservations requiring approval'] = 'Aucune r�servation ne n�cessite d\'approbation.';
$strings['Your reservation was successfully approved'] = 'Votre r�servation a �t� approuv�e.';
$strings['Reservation approved for'] = 'Reservation approuv�e pour %s';
$strings['approved'] = 'Approuv�e';
$strings['Reservation approved'] = 'Reservation approuv�e';

$strings['Valid username is required'] = 'Un nom d\'utlisateur valide est n�cessaire.';
$strings['That logon name is taken already.'] = 'Cet identifiant de connexion est d�j� utilis�.';
$strings['this will be your login'] = '(Ce sera votre identifiant de connexion.)';
$strings['Logon name'] = 'Identifiant de connexion';
$strings['Your logon name is'] = 'Votre identifiant de connexion est %s';

$strings['Start'] = 'D�but';
$strings['End'] = 'Fin';
$strings['Start date must be less than or equal to end date'] = 'La date de d�but doit �tre inf�rieure ou �gale � la date de fin.';
$strings['That starting date has already passed'] = 'La date de d�part est d\'ores et d�j� pass�e.';
$strings['Basic'] = 'de base';
$strings['Participants'] = 'Participants';
$strings['Close'] = 'Fermer';
$strings['Start Date'] = 'Date de d�but';
$strings['End Date'] = 'Date de fin';
$strings['Minimum'] = 'Minimum';
$strings['Maximum'] = 'Maximum';
$strings['Allow Multiple Day Reservations'] = 'Permet des jours de r�servation multiples';
$strings['Invited Users'] = 'Utilisateur invit�s';
$strings['Invite Users'] = 'Inviter des utilisateurs';
$strings['Remove Participants'] = 'Retirer des participants';
$strings['Reservation Invitation'] = 'Invitation � une r�servation';
$strings['Manage Invites'] = 'G�rer les invites';
$strings['No invite was selected'] = 'Aucun invit� n\'a �t� s�lectionn�';
$strings['reservation accepted'] = '%s � accepter votre invitation le %s';
$strings['reservation declined'] = '%s � d�cliner votre invitation le %s';
$strings['Login to manage all of your invitiations'] = 'Connexion pour g�rer toutes vos invitations';
$strings['Reservation Participation Change'] = 'Modification de la participation � la r�servation';
$strings['My Invitations'] = 'Mes invitations';
$strings['Accept'] = 'Accepter';
$strings['Decline'] = 'D�cliner';
$strings['Accept or decline this reservation'] = 'Accepter ou d�cliner cette r�servation';
$strings['My Reservation Participation'] = 'Ma participation � la r�servation';
$strings['End Participation'] = 'Fin de participatioin';
$strings['Owner'] = 'Propri�taire';
$strings['Particpating Users'] = 'Utilisateurs participants';
$strings['No advanced options available'] = 'Aucune option avanc�e disponible';
$strings['Confirm reservation participation'] = 'Confirmez la participation � la r�servation ';
$strings['Confirm'] = 'Confirmer';
$strings['Do for all reservations in the group?'] = 'Ex�cution pour toutes les r�servations de ce groupe ?';

$strings['My Calendar'] = 'Mon calendrier';
$strings['View My Calendar'] = 'Voir mon calendrier';
$strings['Participant'] = 'Participant';
$strings['Recurring'] = 'R�p�titif';
$strings['Multiple Day'] = 'Jour multiple';
$strings['[today]'] = '[aujourd\'hui]';
$strings['Day View'] = 'Vue journali�re';
$strings['Week View'] = 'Vue hebdomadaire';
$strings['Month View'] = 'Vue mensuelle';
$strings['Resource Calendar'] = 'Calendrier des ressources';
$strings['View Resource Calendar'] = 'Voir le calendrier des ressources';	// @since 1.2.0
$strings['Signup View'] = 'Vue des connexions';

$strings['Select User'] = 'Choisir un utilisateur';
$strings['Change'] = 'Modification';

$strings['Update'] = 'Mise � jour';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'La mise � jour de phpScheduleIt n\'est disponible que pour les versions 1.0.0 et suivantes.';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt est d�j� � jour';
$strings['Migrating reservations'] = 'Passage des r�servations d\'une version � l\'autre.';

$strings['Admin'] = 'Administrateur';
$strings['Manage Announcements'] = 'Gestion des annonces';
$strings['There are no announcements'] = 'Il n\'y a pas d\'annonce';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = 'Nombre maximum de participants';
$strings['Leave blank for unlimited'] ='Laisser blanc pour illimit�';
$strings['Maximum of participants'] = 'Cette ressource � une capacit� maximum de %s participants';
$strings['That reservation is at full capacity.'] = 'Cette reservation est compl�te.';
$strings['Allow registered users to join?'] = 'Permettre au utilisateurs enregistr�s de se joindre?';
$strings['Allow non-registered users to join?'] = 'Permettre au utilisateurs non enregistr�s de se joindre?';
$strings['Join'] = 'Rejoindre';
$strings['My Participation Options'] = 'Mes options de participation';
$strings['Join Reservation'] = 'Joindre la r�servation';
$strings['Join All Recurring'] = 'Joindre tout les r�currences';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = 'Vous ne participez pas aux reservations � ces dates parcequ\'elles sont compl�tes.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = 'Vous �tes d�j� invited pour cette reservation. Veuillez suivre les instructions qui vous ont �t�s envoy�s dans l\'email de participation.';
$strings['Additional Tools'] = 'Outils additionnels';
$strings['Create User'] = 'Cr�er un utilisateur';
$strings['Check Availability'] = 'V�rifier la disponibilit�';
$strings['Manage Additional Resources'] = 'G�rer les accessoires';
$strings['Number Available'] = 'Nombre disponible';
$strings['Unlimited'] = 'Illimit�';
$strings['Add Additional Resource'] = 'Ajouter l\'accessoire';
$strings['Edit Additional Resource'] = 'Editer l\'accessoire';
$strings['Checking'] = 'V�rifier';
$strings['You did not select anything to delete.'] = 'Vous n\'avez rien � s�lectionn� pour l\'effacement.';
$strings['Added Resources'] = 'Ressources ajout�es';
$strings['Additional resource is reserved'] = 'The additional resource %s only has %s available at a time';
$strings['All Groups'] = 'Tout les groupes';
$strings['Group Name'] = 'Nom du groupe';
$strings['Delete Groups'] = 'Effacer les groupes';
$strings['Manage Groups'] = 'G�rer les groupes';
$strings['None'] = 'Aucun';
$strings['Group name is required.'] = 'Le nom du groupe est n�cessaire.';
$strings['Groups'] = 'Groupes';
$strings['Current Groups'] = 'Groupes actuels';
$strings['Group Administration'] = 'Administration du groupe';
$strings['Reminder Subject'] = 'Rappel de r�servation- %s, %s %s';
$strings['Reminder'] = 'Rappel';
$strings['before reservation'] = 'avant la reservation';
$strings['My Participation'] = 'Ma Participation';
$strings['My Past Participation'] = 'Mes participations pass�e';
$strings['Timezone'] = 'Fuseau horaire';
$strings['Export'] = 'Exportation';
$strings['Select reservations to export'] = 'Selectionner les reservations � exporter';
$strings['Export Format'] = 'Format d\'exportation';
$strings['This resource cannot be reserved less than x hours in advance'] = 'Cette resource ne peut pas �tre moins de %s heures � l\'avance';
$strings['This resource cannot be reserved more than x hours in advance'] = 'Cette resource ne peut pas �tre r�serv�e plus de %s heures � l\'avance';
$strings['Minimum Booking Notice'] = 'Notification minimum de r�servation';
$strings['Maximum Booking Notice'] = 'Notification maximum de r�servation';
$strings['hours prior to the start time'] = 'heures avant l\'heure de d�but';
$strings['hours from the current time'] = 'heures � partir de l\'heure actuelle';
$strings['Contains'] = 'Contient';
$strings['Begins with'] = 'Commence avec';
$strings['Minimum booking notice is required.'] = 'L\'avertissement si la r�servation est presque vide est obligatoire.';
$strings['Maximum booking notice is required.'] = 'L\'avertissement si la r�servation est compl�te est obligatoire.';
$strings['Accessory Name'] = 'Nom de l\'accessoire';
$strings['Accessories'] = 'Accessoires';
$strings['All Accessories'] = 'Tout les accessoires';
$strings['Added Accessories'] = 'Accessoires rajout�s';
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
        . "Vous avez �t� correctement enregistr� avec les informations suivantes :\r\n"
        . "Identifiant : %s\r\n"
        . "Nom : %s %s \r\n"
        . "T�l�phone : %s \r\n"
        . "Soci�t� : %s \r\n"
        . "Position : %s \r\n\r\n"
        . "Merci de vous connecter au planificateur � cet emplacement :\r\n"
        . "%s \r\n\r\n"
        . "Vous trouverez des liens hypertexte pour acc�der au planificateur en ligne et � Mon Panneau de Contr�le.\r\n\r\n"
        . "Merci d\'adresser toutes questions concernant les ressources ou les r�servations � %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "Administrateur,\r\n\r\n"
          . "Un nouvel utilisateur a �t� ajout� avec les informations :\r\n"
          . "Adresse de messagerie : %s\r\n"
          . "Nom : %s %s\r\n"
          . "T�l�phone : %s\r\n"
          . "Soci�t� : %s\r\n"
          . "Position : %s\r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
      . "Vous avez r�serv� %s num�ro de r�servation #%s avec succ�s.\r\n\r\n<br/><br/>"
      . "Merci d\'utiliser ce num�ro de r�servation lors de toute question � l\'administrateur.\r\n\r\n<br/><br/>"
      . "Une r�servation entre %s %s et %s %s pour %s"
      . " situ�e � %s a �t� %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "Cette r�servation a �t� r�p�t�e pour les dates suivantes :\r\n<br/>";
$email['reservation_activity_3'] = "Toutes les reservations cycliques de ce groupe sont aussi %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "Le r�sum� suivant a �t� �tabli pour la r�servation suivante :\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "S'il s'agissait d'une erreur, merci de contacter l'administrateur � : %s"
      . " ou en appelant le %s.\r\n\r\n<br/><br/>"
      . "Vous pouvez voir et/ou modifier les informations relatives � vos r�servation � tout moment en "
      . " vous connectant %s � :\r\n<br/>"
      . "<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "Merci d'adresser toutes questions techniques � <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
      . "La r�servation  #%s a �t� confirm�e.\r\n\r\n<br/><br/>"
      . "Merci d\'utiliser ce num�ro de r�servation lors de toute question � l\'administrateur.\r\n\r\n<br/><br/>"
      . "Une r�servation entre %s %s et %s %s pour %s"
      . " situ�e � %s a �t� %s.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "Votre mot de passe %s a �t� r�-initialis� par l'administrateur.\r\n\r\n"
      . "Votre mot de passe temporaire est :\r\n\r\n %s\r\n\r\n"
      . "Merci d'utiliser ce mot de passe temporaire (faire copier/coller afin d'�tre s�r qu'il soit correct) pour vous connecter %s au %s"
      . " ,changez le immediatement en utilisant 'Modifier les informations de mon profil/mot de passe' situ� dans la table Mes liens rapides.\r\n\r\n"
      . "Merci de contacter %s pour toutes questions.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n"
            . "Votre nouveau mot de passe pour votre compte %s est :\r\n\r\n"
            . "%s\r\n\r\n"
            . "Merci de vous connecter � %s "
            . "avec ce nouveau mot de passe "
            . "(faire copier/coller afin d'�tre s�r qu'il soit correct) "
            . "et changer le rapidement en clickant sur "
            . "Modifier les informations de mon profil/mot de passe "
            . "situ� dans mon panneau de contr�le.\r\n\r\n"
            . "Merci d'adresser toutes questions � %s.";

// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s vous a invit� � participer � la r�servation suivante :\r\n\r\n"
    . "Resource : %s\r\n"
    . "Date de d�but : %s\r\n"
    . "Heure de d�but : %s\r\n"
    . "Date de fin : %s\r\n"
    . "Heure de fin : %s\r\n"
    . "R�sum� : %s\r\n"
    . "Dates r�p�titives (s\'il y en a): %s\r\n\r\n"
    . "Pour accepter cette invitation cliquer sur ce lien (faire un copier/coller s\'il n\'est pas actif) %s\r\n"
    . "Pour d�cliner cette invitation cliquer sur ce lien (faire un copier/coller s\'il n\'est pas actif) %s\r\n"
    . "Pour accepter choisir des dats ou g�rez vos invitations ult�rieurement, merci de vous connecter � %s � %s";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "Vous avez �t� retir� de la r�servation suivante :\r\n\r\n"
    . "Resource : %s\r\n"
    . "Date de d�but : %s\r\n"
    . "Heure de d�but : %s\r\n"
    . "Date de fin : %s\r\n"
    . "Heure de fin : %s\r\n"
    . "R�sum� : %s\r\n"
    . "Dates r�p�titives (s\'il y en a): %s\r\n\r\n";

// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "Votre reservation pour %s de %s %s � %s %s se rapproche.";
?>