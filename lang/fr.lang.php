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
* Copyright (C) 2003 - 2006 phpScheduleIt
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
$months_full = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
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
$strings['My Control Panel'] = 'Mon panneau de contrôle';
$strings['Help'] = 'Aide';
$strings['Manage Schedules'] = 'Organisation de la planification';
$strings['Manage Users'] ='Gestion utilisateurs';
$strings['Manage Resources'] ='Gestion des Ressources';
$strings['Manage User Training'] ='Gestion de l\'entrainement des utilisateurs';
$strings['Manage Reservations'] ='Gestion des réservations';
$strings['Email Users'] ='Message électronique aux utilisateurs';
$strings['Export Database Data'] = 'Exportation des données';
$strings['Reset Password'] = 'Ré-initialisation de mot de passe';
$strings['System Administration'] = 'Administration du systeme';
$strings['Successful update'] = 'Mise a jour réussie';
$strings['Update failed!'] = 'Modification échouée !';
$strings['Manage Blackout Times'] = 'Gestion du temps caché';
$strings['Forgot Password'] = 'Oubli du mot de passe';
$strings['Manage My Email Contacts'] = 'Gestion des mes correspondants';
$strings['Choose Date'] = 'Choisir une date';
$strings['Modify My Profile'] = 'Modification de mon profil';
$strings['Register'] = 'Enregistrer';
$strings['Processing Blackout'] = 'Execution du temps caché';
$strings['Processing Reservation'] = 'Mise en oeuvre des réservations';
$strings['Online Scheduler [Read-only Mode]'] = 'Planificateur en ligne [Mode lecture-seule]';
$strings['Online Scheduler'] = 'Planificateur en ligne';
$strings['phpScheduleIt Statistics'] = 'statistiques de phpScheduleIt';
$strings['User Info'] = 'Info Utilisateur:';

$strings['Could not determine tool'] = 'Outil non identifiable. S.V.P Essayez encore à partir du panneau de contrôle.';
$strings['This is only accessable to the administrator'] = 'Ceci n\'est accessible qu\'à l\'administrateur';
$strings['Back to My Control Panel'] = 'Retour à mon panneau de contrôle';
$strings['That schedule is not available.'] = 'Cette planification n\'est pas disponible.';
$strings['You did not select any schedules to delete.'] = 'Vous n\'avez sélectionné aucune planification à effacer.';
$strings['You did not select any members to delete.'] = 'Vous n\'avez séléctionné aucun membre à supprimer.';
$strings['You did not select any resources to delete.'] = 'Vous n\'avez séléctionné aucune ressource à supprimer.';
$strings['Schedule title is required.'] = 'La planification requiert un titre.';
$strings['Invalid start/end times'] = 'Heure de début ou de fin invalide';
$strings['View days is required'] = 'Jours de vision (?) requis';
$strings['Day offset is required'] = 'Plage horaire du jour requise';
$strings['Admin email is required'] = 'L\'adresse électronique de l\'administrateur est requise';
$strings['Resource name is required.'] = 'Le nom de la ressource est requise.';
$strings['Valid schedule must be selected'] = 'Une planification valide est requise';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'Le temps minimum de réservation doit être inférieur ou égal au temps de réservation maxium.';
$strings['Your request was processed successfully.'] = 'Votre demande a été correctement enregistrée.';
$strings['Go back to system administration'] = 'Retour à l\'administration du système.';
$strings['Or wait to be automatically redirected there.'] = 'ou attendre d\'y être automatiquement redirigé.';
$strings['There were problems processing your request.'] = 'Des difficultés ont été rencontrées lors de l\'exécution de votre demande.';
$strings['Please go back and correct any errors.'] = 'Merci de bien vouloir retourner corriger les erreurs eventuelles.';
$strings['Login to view details and place reservations'] = 'Connectez vous pour voir les détails et éffectuer des reservations';
$strings['Memberid is not available.'] = 'L\'identifiant de l\'utilisateur: %s n\'est pas disponible.';

$strings['Schedule Title'] = 'Titre de la planification';
$strings['Start Time'] = 'Heure de début';
$strings['End Time'] = 'Heure de fin';
$strings['Time Span'] = 'Durée';
$strings['Weekday Start'] = 'Jour de début';
$strings['Admin Email'] = 'Adresse de messagerie de l\'administrateur';

$strings['Default'] = 'Défaut';
$strings['Reset'] = 'Ré-initialisation';
$strings['Edit'] = 'Mise à jour';
$strings['Delete'] = 'Effacement';
$strings['Cancel'] = 'Annulation';
$strings['View'] = 'Visualisation';
$strings['Modify'] = 'Modification';
$strings['Save'] = 'Sauvegarde';
$strings['Back'] = 'Retour';
$strings['Next'] = 'Suivant';
$strings['Close Window'] = 'Fermeture de fenêtre';
$strings['Search'] = 'Recherche';
$strings['Clear'] = 'Effacement';

$strings['Days to Show'] = 'Jours à visualiser';
$strings['Reservation Offset'] = 'Période de réservation';
$strings['Hidden'] = 'Caché';
$strings['Show Summary'] = 'Visualisation du sommaire';
$strings['Add Schedule'] = 'Ajout d\'une planification';
$strings['Edit Schedule'] = 'Modification d\'une planification';
$strings['No'] = 'Non';
$strings['Yes'] = 'Oui';
$strings['Name'] = 'Nom';
$strings['First Name'] = 'Prénom';
$strings['Last Name'] = 'Nom de famille';
$strings['Resource Name'] = 'Nom de la Ressource';
$strings['Email'] = 'Adresse de messagerie';
$strings['Institution'] = 'Société';
$strings['Phone'] = 'Téléphone';
$strings['Password'] = 'Mot de passe';
$strings['Permissions'] = 'Permissions';
$strings['View information about'] = 'Visualisation des information de %s %s';
$strings['Send email to'] = 'Envoi d\'un message électronique à  %s %s';
$strings['Reset password for'] = 'Ré-initialisation du mot de passe de %s %s';
$strings['Edit permissions for'] = 'Modification des privilèges pour %s %s';
$strings['Position'] = 'Position';
$strings['Password (6 char min)'] = 'Mot de passe (%s char min)';
$strings['Re-Enter Password'] = 'Re-Entrer le mot de passe';

$strings['Sort by descending last name'] = 'Tri décroissant par nom de famille';
$strings['Sort by descending email address'] = 'Tri décroissant par adresse électronique';
$strings['Sort by descending institution'] = 'Tri décroissant par société';
$strings['Sort by ascending last name'] = 'Tri croissant par nom de famille';
$strings['Sort by ascending email address'] = 'Tri croissant par adresse éléctronique';
$strings['Sort by ascending institution'] = 'Tri croissant par société';
$strings['Sort by descending resource name'] = 'Tri décroissant par nom de ressource';
$strings['Sort by descending location'] = 'Tri décroissant par emplacement';
$strings['Sort by descending schedule title'] = 'Tri décroissant par titre de planification';
$strings['Sort by ascending resource name'] = 'Tri croissant par nom de ressource';
$strings['Sort by ascending location'] = 'Tri croissant par emplacement';
$strings['Sort by ascending schedule title'] = 'Tri croissant pat titre de planification';
$strings['Sort by descending date'] = 'Tri décroissant par date';
$strings['Sort by descending user name'] = 'Tri décroissant par nom d\'utilisateur';
// duplicate $strings['Sort by descending resource name'] = 'Tri décroissant par nom de ressource';
$strings['Sort by descending start time'] = 'Tri décroissant par heure de début';
$strings['Sort by descending end time'] = 'Tri décroissant par heure de fin';
$strings['Sort by ascending date'] = 'Tri croissant par date';
$strings['Sort by ascending user name'] = 'Tri croissant par nom d\'utilisateur';
$strings['Sort by ascending resource name'] = 'Tri croissant par nom de ressource';
$strings['Sort by ascending start time'] = 'Tri croissant par heure de début';
$strings['Sort by ascending end time'] = 'Tri croissant par heure de fin';
$strings['Sort by descending created time'] = 'Tri décroissant par date de création';
$strings['Sort by ascending created time'] = 'Tri croissant par date de création';
$strings['Sort by descending last modified time'] = 'Tri décroissant par heure de dernière modification';
$strings['Sort by ascending last modified time'] = 'Tri croissant par heure de dernière modification';

$strings['Search Users'] = 'Recherche utilisateurs';
$strings['Location'] = 'Emplacement';
$strings['Schedule'] = 'Planification';
$strings['Phone'] = 'Téléphone';
$strings['Notes'] = 'Notes';
$strings['Status'] = 'Etat';
$strings['All Schedules'] = 'Toutes planifications';
$strings['All Resources'] = 'Toutes ressources';
$strings['All Users'] = 'Tout utilisateurs';

$strings['Edit data for'] = 'Modification des données pour %s';
$strings['Active'] = 'Actif';
$strings['Inactive'] = 'Inactif';
$strings['Toggle this resource active/inactive'] = 'Bascule cette ressource active/inactive';
$strings['Minimum Reservation Time'] = 'Période minimum de reservation';
$strings['Maximum Reservation Time'] = 'Période maximum de reservation';
$strings['Auto-assign permission'] = 'Accord de permission automatique';
$strings['Add Resource'] = 'Ajout d\'une Ressource';
$strings['Edit Resource'] = 'Modification d\'une Ressource';
$strings['Allowed'] = 'Permis';
$strings['Notify user'] = 'Notification utilisateur';
$strings['User Reservations'] = 'Reservations de l\'utilisateur';
$strings['Date'] = 'Date';
$strings['User'] = 'Utilisateur';
$strings['Email Users'] = 'Adresse électronique de l\'utilisateur';
$strings['Subject'] = 'Sujet';
$strings['Message'] = 'Message';
$strings['Please select users'] = 'S.V.P. sélectionner un/des utilisateurs';
$strings['Send Email'] = 'Envoi du message électronique';
$strings['problem sending email'] = 'Désolé, des difficultés on étés rencontrées lors de l\'envoi du message. S.V.P. Essayez de nouveau plus tard.';
$strings['The email sent successfully.'] = 'Le message électronique a été envoyé avec succés.';
$strings['do not refresh page'] = 'S.V.P <u>ne pas</u> ré-actualiser cette page. Le faire enverait deux fois le message.';
$strings['Return to email management'] = 'Retour à la gestion des messages électroniques';
$strings['Please select which tables and fields to export'] = 'Merci de choisir les tables et les champs à exporter :';
$strings['all fields'] = '- tous les champs -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = 'Texte brut';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = 'Exporter les données';
$strings['Reset Password for'] = 'Ré-initialisation du mot de passe de  %s';
$strings['Please edit your profile'] = 'Merci de mettre votre profile à jour';
$strings['Please register'] = 'Merci de vous enregister';
$strings['Email address (this will be your login)'] = 'Adresse électronique (Ce sera votre nom de connexion)';
$strings['Keep me logged in'] = 'Maintenir ma connexion <br/>(utilisation de cookies requise )';
$strings['Edit Profile'] = 'Modification du profil';
$strings['Register'] = 'Enregistrer';
$strings['Please Log In'] = 'Merci de vous identifier';
$strings['Email address'] = 'Adresse électronique';
$strings['Password'] = 'Mot de passe';
$strings['First time user'] = 'Si vous venez pour la première fois?';
$strings['Click here to register'] = 'Cliquez ici pour vous enregistrer';
$strings['Register for phpScheduleIt'] = 'S\'enregistrer pour phpScheduleIt';
$strings['Log In'] = 'Se connecter';
$strings['View Schedule'] = 'Visualisation de planification';
$strings['View a read-only version of the schedule'] = 'Visualisation d\'une version en lecture seule d\'une planification';
$strings['I Forgot My Password'] = 'J\'ai oublié mon mot de passe';
$strings['Retreive lost password'] = 'Récupérer un mot de passe oublié';
$strings['Get online help'] = 'Obtenir de l\'aide en ligne';
$strings['Language'] = 'Langage';
$strings['(Default)'] = '(Défaut)';

$strings['My Announcements'] = 'Mes annonces';
$strings['My Reservations'] = 'Mes reservations';
$strings['My Permissions'] = 'Mes privilèges';
$strings['My Quick Links'] = 'Mes liens rapides';
$strings['Announcements as of'] = 'Annonces de  %s';
$strings['There are no announcements.'] = 'Il n\'y pas d\'annonces.';
$strings['Resource'] = 'Ressource';
$strings['Created'] = 'Créé';
$strings['Last Modified'] = 'Dernière modification';
$strings['View this reservation'] = 'Visualisation de cette reservation';
$strings['Modify this reservation'] = 'Modification de cette reservation';
$strings['Delete this reservation'] = 'Effacement de cette reservation';
$strings['Go to the Online Scheduler'] = 'Allez sur le planificateur en ligne';
$strings['Change My Profile Information/Password'] = 'Changer mon Profil/Mot de passe';		// @since 1.2.0
$strings['Manage My Email Preferences'] = 'Préferences de messagerie';				// @since 1.2.0
$strings['Manage Blackout Times'] = 'Gestion du temps masqué';
$strings['Mass Email Users'] = 'Publipostage';
$strings['Search Scheduled Resource Usage'] = 'Chercher le taux d\'utilisation de la ressource réservée';		// @since 1.2.0
$strings['Export Database Content'] = 'Exportation du contenu de la base de données';
$strings['View System Stats'] = 'Visuallisation des statistiques systèmes';
$strings['Email Administrator'] = 'Envoi d\'un message électronique à l\'administrateur';

$strings['Email me when'] = 'M\'envoyer un message électronique chaque fois que :';
$strings['I place a reservation'] = 'j\'effectue une reservation';
$strings['My reservation is modified'] = 'ma réservation est modifiée';
$strings['My reservation is deleted'] = 'ma réservation est effacée';
$strings['I prefer'] = 'Je préfère:';
$strings['Your email preferences were successfully saved'] = 'Vos messages électronique ont étés sauvegardés!';
$strings['Return to My Control Panel'] = 'Retour à mon Panneau de contrôle';

$strings['Please select the starting and ending times'] = 'Merci de choisir les heures de début et de fin :';
$strings['Please change the starting and ending times'] = 'Merci de modifier les heures de début et de fin';
$strings['Reserved time'] = 'Heure de réservation :';
$strings['Minimum Reservation Length'] = 'Durée minimum de réservation :';
$strings['Maximum Reservation Length'] = 'Durée maximum de réservation :';
$strings['Reserved for'] = 'Réservé pour :';
$strings['Will be reserved for'] = 'sera réservé pour:';
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
$strings['Third Days'] = 'Troisième jour';
$strings['Fourth Days'] = 'Quatrième jour';
$strings['Last Days'] = 'Dernier jour';
$strings['Repeat every'] = 'Répète tous les :';
$strings['Repeat on'] = 'Répete chaque:';
$strings['Repeat until date'] = 'Répète juqu\'à :';
$strings['Choose Date'] = 'Choisir une date';
$strings['Summary'] = 'Résumé';

$strings['View schedule'] = 'Visualisation de la planification:';
$strings['My Reservations'] = 'Mes réservations';
$strings['My Past Reservations'] = 'Mes anciennes réservations';
$strings['Other Reservations'] = 'Les autres reservations';
$strings['Other Past Reservations'] = 'Les autes anciennes réservations';
$strings['Blacked Out Time'] = 'Temps masqué';
$strings['Set blackout times'] = 'Etablissement du temps masqué %s sur %s';
$strings['Reserve on'] = 'Reserve %s sur %s';
$strings['Prev Week'] = '&laquo; Sem. Préc.';
$strings['Next Week'] = 'Sem. Suiv. &raquo;';
$strings['Jump 1 week back'] = 'Sauter 1 Sem. en Arr.';
$strings['Prev days'] = '&#8249; %d jours préc.';
$strings['Previous days'] = '&#8249; %d jours précédents';
$strings['This Week'] = 'Cette semaine';
$strings['Jump to this week'] = 'ALler à cette semaine';
$strings['Next days'] = 'prochains %d jours &#8250;';
$strings['Jump To Date'] = 'Aller à cette date';
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
$strings['System Stats'] = 'Statistiques systèmes';
$strings['phpScheduleIt version'] = 'phpScheduleIt version:';
$strings['Database backend'] = 'Base de données principale :';
$strings['Database name'] = 'Nom de base de données :';
$strings['PHP version'] = 'PHP version:';
$strings['Server OS'] = 'Server OS:';
$strings['Server name'] = 'Server name:';
$strings['phpScheduleIt root directory'] = 'répertoire racine de phpScheduleIt:';
$strings['Using permissions'] = 'Utilise les permissions:';
$strings['Using logging'] = 'Utilise les fichiers historiques:';
$strings['Log file'] = 'Fichier historique :';
$strings['Admin email address'] = 'Adresse de messagerie administrateur:';
$strings['Tech email address'] = 'Adresse de messagerie technique:';
$strings['CC email addresses'] = 'Adresses de messagerie à CC:';
$strings['Reservation start time'] = 'Heure de début de reservation :';
$strings['Reservation end time'] = 'Heure de fin de reservation :';
$strings['Days shown at a time'] = 'Nombre de jours visualisés d\'un coup:';
$strings['Reservations'] = 'Réservations';
$strings['Return to top'] = 'Retour en haut';
$strings['for'] = 'pour';

$strings['Select Search Criteria'] = 'Choix des critères de sélection';
$strings['Schedules'] = 'Planifications:';
$strings['All Schedules'] = 'Toutes planifications';
$strings['Hold CTRL to select multiple'] = 'Maintenir la touche CTRL pour un choix multiple';
$strings['Users'] = 'Utilisateurs :';
$strings['All Users'] = 'Tout utilisateurs';
$strings['Resources'] = 'Ressources';
$strings['All Resources'] = 'Toutes Ressources';
$strings['Starting Date'] = 'Date de début :';
$strings['Ending Date'] = 'Date de fin :';
$strings['Starting Time'] = 'Heure de début :';
$strings['Ending Time'] = 'Heure de fin :';
$strings['Output Type'] = 'Type d\'affichage :';
$strings['Manage'] = 'Gérer';
$strings['Total Time'] = 'Temps total :';
$strings['Total hours'] = 'Heures totales :';
$strings['% of total resource time'] = '% du temps de ressource total';
$strings['View these results as'] = 'Visualisation de ce résultat comme :';
$strings['Edit this reservation'] = 'Modifie cette réservation';
$strings['Search Results'] = 'Résultats de la recherche';
$strings['Search Resource Usage'] = 'Cherche l\'utilisation des ressources';
$strings['Search Results found'] = 'Résultats de la recherche: %d reservations trouvées';
$strings['Try a different search'] = 'Essayer une recherche différente';
$strings['Search Run On'] = 'La recherche s\'effectue sur :';
$strings['Member ID'] = 'Member ID';
$strings['Previous User'] = '&laquo; Utilisateur précédent';
$strings['Next User'] = 'Utilisateur suivant &raquo;';

$strings['No results'] = 'Pas de résultat';
$strings['That record could not be found.'] = 'Cet enregistrement ne peut être trouvé.';
$strings['This blackout is not recurring.'] = 'Ce temps masqué ne se reproduit pas.';
$strings['This reservation is not recurring.'] = 'Cette réservation n\'est pas cyclique.';
$strings['There are no records in the table.'] = 'Il n\'y a aucun enregistrements dans cette table %s.';
$strings['You do not have any reservations scheduled.'] = 'Vous n\'avez aucune reservation planifiée.';
$strings['You do not have permission to use any resources.'] = 'Vous n\'avez pas la permission d\'utilser les ressources.';
$strings['No resources in the database.'] = 'Il n\'y a aucune ressource définie dans la base de données.';
$strings['There was an error executing your query'] = 'Une erreur s\'est produite lors de l\'exécution du la requête:';

$strings['That cookie seems to be invalid'] = 'Ce cookie semble invalide';
$strings['We could not find that logon in our database.'] = 'Identifiant de connexion inconnu dans notre database.';  // @since 1.1.0
$strings['That password did not match the one in our database.'] = 'Le mot de passe n\'est pas identique à celui contenu dans la base de données.';
$strings['You can try'] = '<br />Vous pouvez essayer:<br />d\'enregister une adresse email.<br />Ou :<br />Essayer de vous connecter à nouveau.';
$strings['A new user has been added'] = 'Un nouvel utilisateur a été ajouté';
$strings['You have successfully registered'] = 'Vous avez été enregistré correctement!';
$strings['Continue'] = 'Continuer...';
$strings['Your profile has been successfully updated!'] = 'Votre profil a été correctement modifié!';
$strings['Please return to My Control Panel'] = 'Merci de retourner au panneau de contrôle';
$strings['Valid email address is required.'] = '- Une adresse électronique valide est requise.';
$strings['First name is required.'] = '- Le prénom est requis.';
$strings['Last name is required.'] = '- Le nom de famille est requis.';
$strings['Phone number is required.'] = '- Le numéro de téléphone est requis.';
$strings['That email is taken already.'] = '- Cet adresse électronique est déjà utilisée.<br />Merci d\'essayer de nouveau avec une autre adresse électronique.';
$strings['Min 6 character password is required.'] = '- Le mot de passe requiert un minimum de %s caractéres.';
$strings['Passwords do not match.'] = '- Les mots de passe ne correspondent pas.';

$strings['Per page'] = 'Par page:';
$strings['Page'] = 'Page:';

$strings['Your reservation was successfully created'] = 'Votre réservation a été correctement enregistrée';
$strings['Your reservation was successfully modified'] = 'Votre réservation a été correctement modifiée';
$strings['Your reservation was successfully deleted'] = 'Votre réservation a été correctement effacée';
$strings['Your blackout was successfully created'] = 'Votre temps masqué a été correctement créé';
$strings['Your blackout was successfully modified'] = 'Votre temps masqué a été correctement modifié';
$strings['Your blackout was successfully deleted'] = 'Votre temps masqué a été correctement effacé';
$strings['for the follwing dates'] = 'pour les dates suivantes:';
$strings['Start time must be less than end time'] = 'L\'heure de début doit être inférieure à l\'heure de fin.';
$strings['Current start time is'] = 'L\'actuelle heure de début est :';
$strings['Current end time is'] = 'L\'actuelle heure de fin est :';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'La durée de reservation n\'est pas compatible avec la durée de réservation autorisée.';
$strings['Your reservation is'] = 'Votre réservation est :';
$strings['Minimum reservation length'] = 'Durée minimum de réservation :';
$strings['Maximum reservation length'] = 'Durée maximum de réservation :';
$strings['You do not have permission to use this resource.'] = 'Vous n\'avez pas les droits d\'utilisation de cette ressource.';
$strings['reserved or unavailable'] = '%s à %s est reservé ou indisponible.';   // @since 1.1.0
$strings['Reservation created for'] = 'Reservation créée pour %s';
$strings['Reservation modified for'] = 'Reservation modifiée pour %s';
$strings['Reservation deleted for'] = 'Reservation effacée %s';
$strings['created'] = 'créé';
$strings['modified'] = 'modifié';
$strings['deleted'] = 'effacé';
$strings['Reservation #'] = 'Reservation #';
$strings['Contact'] = 'Contact';
$strings['Reservation created'] = 'Reservation créée';
$strings['Reservation modified'] = 'Reservation modifiée';
$strings['Reservation deleted'] = 'Reservation effacée';

$strings['Reservations by month'] = 'Réservations par mois';
$strings['Reservations by day of the week'] = 'Réservations par jour de la semaine';
$strings['Reservations per month'] = 'Réservations par mois';
$strings['Reservations per user'] = 'Réservations par utilisateur';
$strings['Reservations per resource'] = 'Réservations par ressource';
$strings['Reservations per start time'] = 'Réservations par date de début';
$strings['Reservations per end time'] = 'Réservations par date de fin';
$strings['[All Reservations]'] = 'Toutes les réservations';

$strings['Permissions Updated'] = 'Privilèges modifiés';
$strings['Your permissions have been updated'] = 'Vos %s privilèges ont été modifiés';
$strings['You now do not have permission to use any resources.'] = 'Vous n\'avez les droits d\'utilisation d\'aucune ressource.';
$strings['You now have permission to use the following resources'] = 'Vous avez désormais les droits d\'utilisation des ressources suivantes :';
$strings['Please contact with any questions.'] = 'Merci de contacter %s pour toutes questions.';
$strings['Password Reset'] = 'Ré-initialisation du mot de passe';

$strings['This will change your password to a new, randomly generated one.'] = 'Cela remplacera votre mot de passe par un mot de passe déterminé de façon aléatoire.';
$strings['your new password will be set'] = 'Après avoir indiqué votre adresse électronique et cliqué sur "Modification du mot de passe", votre nouveau mot de passe sera effectif et vous sera envoyé.';
$strings['Change Password'] = 'Modification du mot de passe';
$strings['Sorry, we could not find that user in the database.'] = 'Désolé nous ne pouvons trouver cet utilisateur dans notre base de données.';
$strings['Your New Password'] = 'Votre nouveau mot de passe %s ';
$strings['Your new passsword has been emailed to you.'] = 'Succès!<br />
          Votre nouveau mot de passe vous a été envoyé par message électronique.<br />
          Merci de contrôler le contenu de votre boite aux lettres, puis <a href="index.php">Connectez vous</a>
          avec votre nouveau mot de passe et modifiez le en cliquant &quot;Modifie les information de mon profil/mot de passe&quot;
          dans mon Panneau de contrôle.';

$strings['You are not logged in!'] = 'Vous n\'êtes pas connecté!';

$strings['Setup'] = 'Installation';
$strings['Please log into your database'] = 'Merci de vous connecter à votre base de données';
$strings['Enter database root username'] = 'Indiquez le nom de l\'administrateur de la base de données:';
$strings['Enter database root password'] = 'Indiquez le mot de passe de l\'administrateur de la base de données:';
$strings['Login to database'] = 'Connexion à la base de données';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = 'L\'administrateur  <b>n\'est pas </b> requis. Tout utilisateur qui a les droits de création de tables est suffisant.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = 'Cela va installer toutes les bases et tables nécessaire à phpScheduleIt.';
$strings['It also populates any required tables.'] = 'Cela remplit également toutes les tables nécessaires.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = 'Attention: CELA VA EFFACER TOUTES LES DONNEES DANS LES BASES DE DONNEES PRECEDENTES DE phpScheduleIt !';
$strings['Not a valid database type in the config.php file.'] = 'Un type de base de donnée invalide figure dans le script config.php.';
$strings['Database user password is not set in the config.php file.'] = 'Le mot de passe d\'accès à la base de donnée n\'est pas indiqué dans config.php.';
$strings['Database name not set in the config.php file.'] = 'Le nom de la base de donnée n\'est pas indiqué dans config.php.';
$strings['Successfully connected as'] = 'Connecté avec succès en tant que ';
$strings['Create tables'] = 'Créé les tables &gt;';
$strings['There were errors during the install.'] = 'Des erreurs se sont produites durant l\'installation. Il est possible que phpScheduleIt fonctionne correctement si les erreurs sont mineures.<br/><br/>'
  . 'Merci de poser toute question sur le forum <a href="http://sourceforge.net/forum/?group_id=95547">SourceForge</a>.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = 'Vous avez terminé d\'installer phpScheduleIt avec succès et êtes prêt à l\'utiliser.';
$strings['Thank you for using phpScheduleIt'] = 'Merci de vous assurer de détruire le répertoire \'install\'.'
  . ' C\'est essentiel car il contient des informations confidentielles d\'accès.'
  . ' Ne pas agir ainsi vous expose à des intrusions malveilantes de nature à détruire votre site !'
  . '<br /><br />'
  . 'Merci d\'utiliser phpScheduleIt!';
$strings['This will update your version of phpScheduleIt from 0.9.3 to 1.0.0.'] = 'Ceci va mettre à jour votre phpScheduleIt de la verion 0.9.3 à 1.0.0.';
$strings['There is no way to undo this action'] = 'Il ne sera pas possible de revenir en arrière après cette action !';
$strings['Click to proceed'] = 'Cliquez pour exécuter';
$strings['This version has already been upgraded to 1.0.0.'] = 'Cette version a déjà été mise à jour en 1.0.0.';
$strings['Please delete this file.'] = 'Merci de détruire ce fichier.';
$strings['Successful update'] = 'La mise à jour s\'est déroulée avec succès';
$strings['Patch completed successfully'] = 'Le correctif a été appliqué avec succès';
$strings['This will populate the required fields for phpScheduleIt 1.0.0 and patch a data bug in 0.9.9.'] = 'Cela va remplir les champs nécessaires à  phpScheduleIt 1.0.0 and corriger un problème dans la 0.9.9.'
    . '<br />Il est seulement nécessaire d\'exécuter ceci si vous procédez à une mise à jour manuelle d\' SQL ou que vous venez de 0.9.9';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = 'Si aucune valeur n\'est précisée, le mot de passe par défaut spécifié dans le fichier de configuration (config.php) sera utilisé.';
$strings['Notify user that password has been changed?'] = 'L\'utilisateur doit il être prévenu que son mot de passe a été changé ?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'Pour ce système il est impératif que vous possédiez une adresse de messagerie électronique';
$strings['Invalid User Name/Password.'] = 'Nom d\'utilisateur ou mot de passe invalide.';
$strings['Pending User Reservations'] = 'Réservations en cours pour l\' utilisateur';
$strings['Approve'] = 'Confirme';
$strings['Approve this reservation'] = 'Approuvez cette réservation';
$strings['Approve Reservations'] ='Approuvez ces réservations';

$strings['Announcement'] = 'Annonce';
$strings['Number'] = 'Nombre';
$strings['Add Announcement'] = 'Ajouter une Annonce';
$strings['Edit Announcement'] = 'modifier une Annonce';
$strings['All Announcements'] = 'Toutes les Annonces';
$strings['Delete Announcements'] = 'Supprimer une Annonce';
$strings['Use start date/time?'] = 'Utiliser date/heure de début ?';
$strings['Use end date/time?'] = 'Utiliser date/heure de fin?';
$strings['Announcement text is required.'] = 'Le texte de l\'annonce est nécessaire.';
$strings['Announcement number is required.'] = 'Le numéro de l\'annonce est nécessaire.';

$strings['Pending Approval'] = 'Approbation en cours';
$strings['My reservation is approved'] = 'Ma réservation est approuvée';
$strings['This reservation must be approved by the administrator.'] = 'Cette réservation doit être approuvée par l\'administrateur.';
$strings['Approval Required'] = 'Approbation nécessaire';
$strings['No reservations requiring approval'] = 'Aucune réservation ne nécessite d\'approbation.';
$strings['Your reservation was successfully approved'] = 'Votre réservation a été approuvée.';
$strings['Reservation approved for'] = 'Reservation approuvée pour %s';
$strings['approved'] = 'Approuvée';
$strings['Reservation approved'] = 'Reservation approuvée';

$strings['Valid username is required'] = 'Un nom d\'utlisateur valide est nécessaire.';
$strings['That logon name is taken already.'] = 'Cet identifiant de connexion est déjà utilisé.';
$strings['this will be your login'] = '(Ce sera votre identifiant de connexion.)';
$strings['Logon name'] = 'Identifiant de connexion';
$strings['Your logon name is'] = 'Votre identifiant de connexion est %s';

$strings['Start'] = 'Début';
$strings['End'] = 'Fin';
$strings['Start date must be less than or equal to end date'] = 'La date de début doit être inférieure ou égale à la date de fin.';
$strings['That starting date has already passed'] = 'La date de départ est d\'ores et déjà passée.';
$strings['Basic'] = 'de base';
$strings['Participants'] = 'Participants';
$strings['Close'] = 'Fermer';
$strings['Start Date'] = 'Date de début';
$strings['End Date'] = 'Date de fin';
$strings['Minimum'] = 'Minimum';
$strings['Maximum'] = 'Maximum';
$strings['Allow Multiple Day Reservations'] = 'Permet des jours de réservation multiples';
$strings['Invited Users'] = 'Utilisateur invités';
$strings['Invite Users'] = 'Inviter des utilisateurs';
$strings['Remove Participants'] = 'Retirer des participants';
$strings['Reservation Invitation'] = 'Invitation à une réservation';
$strings['Manage Invites'] = 'Gèrer les invites';
$strings['No invite was selected'] = 'Aucun invité n\'a été sélectionné';
$strings['reservation accepted'] = '%s à accepter votre invitation le %s';
$strings['reservation declined'] = '%s à décliner votre invitation le %s';
$strings['Login to manage all of your invitiations'] = 'Connexion pour gérer toutes vos invitations';
$strings['Reservation Participation Change'] = 'Modification de la participation à la réservation';
$strings['My Invitations'] = 'Mes invitations';
$strings['Accept'] = 'Accepter';
$strings['Decline'] = 'Décliner';
$strings['Accept or decline this reservation'] = 'Accepter ou décliner cette réservation';
$strings['My Reservation Participation'] = 'Ma participation à la réservation';
$strings['End Participation'] = 'Fin de participatioin';
$strings['Owner'] = 'Propriétaire';
$strings['Particpating Users'] = 'Utilisateurs participants';
$strings['No advanced options available'] = 'Aucune option avancée disponible';
$strings['Confirm reservation participation'] = 'Confirmez la participation à la réservation ';
$strings['Confirm'] = 'Confirmer';
$strings['Do for all reservations in the group?'] = 'Exécution pour toutes les réservations de ce groupe ?';

$strings['My Calendar'] = 'Mon calendrier';
$strings['View My Calendar'] = 'Voir mon calendrier';
$strings['Participant'] = 'Participant';
$strings['Recurring'] = 'Répétitif';
$strings['Multiple Day'] = 'Jour multiple';
$strings['[today]'] = '[aujourd\'hui]';
$strings['Day View'] = 'Vue journalière';
$strings['Week View'] = 'Vue hebdomadaire';
$strings['Month View'] = 'Vue mensuelle';
$strings['Resource Calendar'] = 'Calendrier des ressources';
$strings['View Resource Calendar'] = 'Voir le calendrier des ressources';	// @since 1.2.0
$strings['Signup View'] = 'Vue des connexions';

$strings['Select User'] = 'Choisir un utilisateur';
$strings['Change'] = 'Modification';

$strings['Update'] = 'Mise à jour';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'La mise à jour de phpScheduleIt n\'est disponible que pour les versions 1.0.0 et suivantes.';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt est déjà à jour';
$strings['Migrating reservations'] = 'Passage des réservations d\'une version à l\'autre.';

$strings['Admin'] = 'Administrateur';
$strings['Manage Announcements'] = 'Gestion des annonces';
$strings['There are no announcements'] = 'Il n\'y a pas d\'annonce';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = 'Nombre maximum de participants';
$strings['Leave blank for unlimited'] ='Laisser blanc pour illimité';
$strings['Maximum of participants'] = 'Cette ressource à une capacité maximum de %s participants';
$strings['That reservation is at full capacity.'] = 'Cette reservation est complète.';
$strings['Allow registered users to join?'] = 'Permettre au utilisateurs enregistrés de se joindre?';
$strings['Allow non-registered users to join?'] = 'Permettre au utilisateurs non enregistrés de se joindre?';
$strings['Join'] = 'Rejoindre';
$strings['My Participation Options'] = 'Mes options de participation';
$strings['Join Reservation'] = 'Joindre la réservation';
$strings['Join All Recurring'] = 'Joindre tout les récurrences';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = 'Vous ne participez pas aux reservations à ces dates parcequ\'elles sont complètes.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = 'Vous êtes déjà invited pour cette reservation. Veuillez suivre les instructions qui vous ont étés envoyés dans l\'email de participation.';
$strings['Additional Tools'] = 'Outils additionnels';
$strings['Create User'] = 'Créer un utilisateur';
$strings['Check Availability'] = 'Vérifier la disponibilité';
$strings['Manage Additional Resources'] = 'Gèrer les accessoires';
$strings['Number Available'] = 'Nombre disponible';
$strings['Unlimited'] = 'Illimité';
$strings['Add Additional Resource'] = 'Ajouter l\'accessoire';
$strings['Edit Additional Resource'] = 'Editer l\'accessoire';
$strings['Checking'] = 'Vérifier';
$strings['You did not select anything to delete.'] = 'Vous n\'avez rien à sélectionné pour l\'effacement.';
$strings['Added Resources'] = 'Ressources ajoutées';
$strings['Additional resource is reserved'] = 'The additional resource %s only has %s available at a time';
$strings['All Groups'] = 'Tout les groupes';
$strings['Group Name'] = 'Nom du groupe';
$strings['Delete Groups'] = 'Effacer les groupes';
$strings['Manage Groups'] = 'Gérer les groupes';
$strings['None'] = 'Aucun';
$strings['Group name is required.'] = 'Le nom du groupe est nécessaire.';
$strings['Groups'] = 'Groupes';
$strings['Current Groups'] = 'Groupes actuels';
$strings['Group Administration'] = 'Administration du groupe';
$strings['Reminder Subject'] = 'Rappel de réservation- %s, %s %s';
$strings['Reminder'] = 'Rappel';
$strings['before reservation'] = 'avant la reservation';
$strings['My Participation'] = 'Ma Participation';
$strings['My Past Participation'] = 'Mes participations passée';
$strings['Timezone'] = 'Fuseau horaire';
$strings['Export'] = 'Exportation';
$strings['Select reservations to export'] = 'Selectionner les reservations à exporter';
$strings['Export Format'] = 'Format d\'exportation';
$strings['This resource cannot be reserved less than x hours in advance'] = 'Cette resource ne peut pas être moins de %s heures à l\'avance';
$strings['This resource cannot be reserved more than x hours in advance'] = 'Cette resource ne peut pas être réservée plus de %s heures à l\'avance';
$strings['Minimum Booking Notice'] = 'Notification minimum de réservation';
$strings['Maximum Booking Notice'] = 'Notification maximum de réservation';
$strings['hours prior to the start time'] = 'heures avant l\'heure de début';
$strings['hours from the current time'] = 'heures à partir de l\'heure actuelle';
$strings['Contains'] = 'Contient';
$strings['Begins with'] = 'Commence avec';
$strings['Minimum booking notice is required.'] = 'L\'avertissement si la réservation est presque vide est obligatoire.';
$strings['Maximum booking notice is required.'] = 'L\'avertissement si la réservation est complète est obligatoire.';
$strings['Accessory Name'] = 'Nom de l\'accessoire';
$strings['Accessories'] = 'Accessoires';
$strings['All Accessories'] = 'Tout les accessoires';
$strings['Added Accessories'] = 'Accessoires rajoutés';
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
        . "Vous avez été correctement enregistré avec les informations suivantes :\r\n"
        . "Identifiant : %s\r\n"
        . "Nom : %s %s \r\n"
        . "Téléphone : %s \r\n"
        . "Société : %s \r\n"
        . "Position : %s \r\n\r\n"
        . "Merci de vous connecter au planificateur à cet emplacement :\r\n"
        . "%s \r\n\r\n"
        . "Vous trouverez des liens hypertexte pour accèder au planificateur en ligne et à Mon Panneau de Contrôle.\r\n\r\n"
        . "Merci d\'adresser toutes questions concernant les ressources ou les réservations à %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "Administrateur,\r\n\r\n"
          . "Un nouvel utilisateur a été ajouté avec les informations :\r\n"
          . "Adresse de messagerie : %s\r\n"
          . "Nom : %s %s\r\n"
          . "Téléphone : %s\r\n"
          . "Société : %s\r\n"
          . "Position : %s\r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
      . "Vous avez réservé %s numéro de réservation #%s avec succès.\r\n\r\n<br/><br/>"
      . "Merci d\'utiliser ce numéro de réservation lors de toute question à l\'administrateur.\r\n\r\n<br/><br/>"
      . "Une réservation entre %s %s et %s %s pour %s"
      . " située à %s a été %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "Cette réservation a été répétée pour les dates suivantes :\r\n<br/>";
$email['reservation_activity_3'] = "Toutes les reservations cycliques de ce groupe sont aussi %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "Le résumé suivant a été établi pour la réservation suivante :\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "S'il s'agissait d'une erreur, merci de contacter l'administrateur à : %s"
      . " ou en appelant le %s.\r\n\r\n<br/><br/>"
      . "Vous pouvez voir et/ou modifier les informations relatives à vos réservation à tout moment en "
      . " vous connectant %s à :\r\n<br/>"
      . "<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "Merci d'adresser toutes questions techniques à <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
      . "La réservation  #%s a été confirmée.\r\n\r\n<br/><br/>"
      . "Merci d\'utiliser ce numéro de réservation lors de toute question à l\'administrateur.\r\n\r\n<br/><br/>"
      . "Une réservation entre %s %s et %s %s pour %s"
      . " située à %s a été %s.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "Votre mot de passe %s a été ré-initialisé par l'administrateur.\r\n\r\n"
      . "Votre mot de passe temporaire est :\r\n\r\n %s\r\n\r\n"
      . "Merci d'utiliser ce mot de passe temporaire (faire copier/coller afin d'être sûr qu'il soit correct) pour vous connecter %s au %s"
      . " ,changez le immediatement en utilisant 'Modifier les informations de mon profil/mot de passe' situé dans la table Mes liens rapides.\r\n\r\n"
      . "Merci de contacter %s pour toutes questions.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n"
            . "Votre nouveau mot de passe pour votre compte %s est :\r\n\r\n"
            . "%s\r\n\r\n"
            . "Merci de vous connecter à %s "
            . "avec ce nouveau mot de passe "
            . "(faire copier/coller afin d'être sûr qu'il soit correct) "
            . "et changer le rapidement en clickant sur "
            . "Modifier les informations de mon profil/mot de passe "
            . "situé dans mon panneau de contrôle.\r\n\r\n"
            . "Merci d'adresser toutes questions à %s.";

// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s vous a invité à participer à la réservation suivante :\r\n\r\n"
    . "Resource : %s\r\n"
    . "Date de début : %s\r\n"
    . "Heure de début : %s\r\n"
    . "Date de fin : %s\r\n"
    . "Heure de fin : %s\r\n"
    . "Résumé : %s\r\n"
    . "Dates répétitives (s\'il y en a): %s\r\n\r\n"
    . "Pour accepter cette invitation cliquer sur ce lien (faire un copier/coller s\'il n\'est pas actif) %s\r\n"
    . "Pour décliner cette invitation cliquer sur ce lien (faire un copier/coller s\'il n\'est pas actif) %s\r\n"
    . "Pour accepter choisir des dats ou gérez vos invitations ultérieurement, merci de vous connecter à %s à %s";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "Vous avez été retiré de la réservation suivante :\r\n\r\n"
    . "Resource : %s\r\n"
    . "Date de début : %s\r\n"
    . "Heure de début : %s\r\n"
    . "Date de fin : %s\r\n"
    . "Heure de fin : %s\r\n"
    . "Résumé : %s\r\n"
    . "Dates répétitives (s\'il y en a): %s\r\n\r\n";

// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "Votre reservation pour %s de %s %s à %s %s se rapproche.";
?>
