<?php
/**
Copyright 2011-2014 Nick Korbel, Boris Vatin

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once('Language.php');
require_once('en_us.php');

class fr_fr extends en_us
{
    public function __construct()
    {
        parent::__construct();
    }

	protected function _LoadDates()
	{
		$dates = parent::_LoadDates();

		$dates['general_date'] = 'd/m/Y';
		$dates['general_datetime'] = 'd/m/Y H:i:s';
		$dates['schedule_daily'] = 'l, d/m/Y';
		$dates['reservation_email'] = 'd/m/Y @ g:i A (e)';
		$dates['res_popup'] = 'd/m/Y g:i A';
		$dates['dashboard'] = 'l, d/m/Y g:i A';
		$dates['period_time'] = "g:i A";
		$dates['general_date_js'] = "dd/mm/yy";

		$this->Dates = $dates;
	}

    protected function _LoadStrings()
    {
        $strings = parent::_LoadStrings();

        $strings['FirstName'] = 'Prénom';
        $strings['LastName'] = 'Nom';
        $strings['Timezone'] = 'Fuseau horaire';
        $strings['Edit'] = 'Editer';
        $strings['Change'] = 'Modifier';
        $strings['Rename'] = 'Renommer';
        $strings['Remove'] = 'Enlever';
        $strings['Delete'] = 'Effacer';
        $strings['Update'] = 'Enregistrer';
        $strings['Cancel'] = 'Annuler';
        $strings['Add'] = 'Ajouter';
        $strings['Name'] = 'Nom';
        $strings['Yes'] = 'Oui';
        $strings['No'] = 'Non';
        $strings['FirstNameRequired'] = 'Le prénom est obligatoire.';
        $strings['LastNameRequired'] = 'Le nom est obligatoire.';
        $strings['PwMustMatch'] = 'La confirmation du mot de passe doit correspondre avec le mot de passe.';
        $strings['PwComplexity'] = 'Le mot de passe doit avoir au minimum 6 caractères et être une combinaison de lettres, nombres et symboles.';
        $strings['ValidEmailRequired'] = 'Un email valide est obligatoire.';
        $strings['UniqueEmailRequired'] = 'Cette adresse email est déjà enregistrée.';
        $strings['UniqueUsernameRequired'] = 'Ce nom d\'utilisateur est déjà enregistré.';
        $strings['UserNameRequired'] = 'Le nom d\'utilisateur est obligatoire.';
        $strings['CaptchaMustMatch'] = 'Veuillez saisir les lettres contenues dans l\'image (sécurité).';
        $strings['Today'] = 'Aujourd\'hui';
        $strings['Week'] = 'Semaine';
        $strings['Month'] = 'Mois';
        $strings['BackToCalendar'] = 'Retour au calendrier';
        $strings['BeginDate'] = 'Début';
        $strings['EndDate'] = 'Fin';
        $strings['Username'] = 'Nom d\'utilisateur';
        $strings['Password'] = 'Mot de Passe';
        $strings['PasswordConfirmation'] = 'Confirmez votre mot de passe';
        $strings['DefaultPage'] = 'Page d\'accueil';
        $strings['MyCalendar'] = 'Mon Calendrier';
        $strings['ScheduleCalendar'] = 'Calendier du planning';
        $strings['Registration'] = 'Enregistrement';
        $strings['NoAnnouncements'] = 'Il n\'y a aucune annonce';
        $strings['Announcements'] = 'Annonces';
        $strings['NoUpcomingReservations'] = 'Vous n\'avez aucune réservation à venir';
        $strings['UpcomingReservations'] = 'Réservations à venir';
        $strings['ShowHide'] = 'Afficher/Cacher';
        $strings['Error'] = 'Erreur';
        $strings['ReturnToPreviousPage'] = 'Retour à la page précédente';
        $strings['UnknownError'] = 'Erreur inconnue';
        $strings['InsufficientPermissionsError'] = 'Vous n\'avez pas le droit d\'accéder à cette ressource';
        $strings['MissingReservationResourceError'] = 'Pas de ressource sélectionnée';
        $strings['MissingReservationScheduleError'] = 'Pas de planning sélectionné';
        $strings['DoesNotRepeat'] = 'Aucune';
        $strings['Daily'] = 'Journalière';
        $strings['Weekly'] = 'Hebdomadaire';
        $strings['Monthly'] = 'Mensuelle';
        $strings['Yearly'] = 'Annuelle';
        $strings['RepeatPrompt'] = 'Répétition';
        $strings['hours'] = 'heures';
        $strings['days'] = 'jours';
        $strings['weeks'] = 'semaines';
        $strings['months'] = 'mois';
        $strings['years'] = 'années';
        $strings['day'] = 'jour';
        $strings['week'] = 'semaine';
        $strings['month'] = 'mois';
        $strings['year'] = 'année';
        $strings['repeatDayOfMonth'] = 'Jour du mois';
        $strings['repeatDayOfWeek'] = 'Jour de la semaine';
        $strings['RepeatUntilPrompt'] = 'Jusqu\'au';
        $strings['RepeatEveryPrompt'] = 'Tous les';
        $strings['RepeatDaysPrompt'] = 'On';//
        $strings['CreateReservationHeading'] = 'Créer une nouvelle réservation';
        $strings['EditReservationHeading'] = 'Editer la reservation %s';
        $strings['ViewReservationHeading'] = 'Visualisation de la réservation %s';
        $strings['ReservationErrors'] = 'Changer la Réservation';
        $strings['Create'] = 'Créer';
        $strings['ThisInstance'] = 'Cette Instance seule';
        $strings['AllInstances'] = 'Toutes les Instances';
        $strings['FutureInstances'] = 'Futures Instances';
        $strings['Print'] = 'Imprimer';
        $strings['ShowHideNavigation'] = 'Afficher/Cacher le Menu';
        $strings['ReferenceNumber'] = 'Numéro Référence';
        $strings['Tomorrow'] = 'Demain';
        $strings['LaterThisWeek'] = 'Reste de la semaine';
        $strings['NextWeek'] = 'La semaine prochaine';
        $strings['SignOut'] = 'Deconnexion';
        $strings['LayoutDescription'] = 'Commence le %s, Affiche %s jours à la fois';
        $strings['AllResources'] = 'Toutes les Ressources';
        $strings['TakeOffline'] = 'Désactiver';
        $strings['BringOnline'] = 'Activer';
        $strings['AddImage'] = 'Ajouter une Image';
        $strings['NoImage'] = 'Pas d\'image';
        $strings['Move'] = 'Déplacer';
        $strings['AppearsOn'] = 'Affiché sur %s';
        $strings['Location'] = 'Emplacement';
        $strings['NoLocationLabel'] = '(pas d\'emplacement)';
        $strings['Contact'] = 'Contact';
        $strings['NoContactLabel'] = '(aucun contact disponible)';
        $strings['Description'] = 'Description';
        $strings['NoDescriptionLabel'] = '(pas de description)';
        $strings['Notes'] = 'Notes';
        $strings['NoNotesLabel'] = '(pas de notes)';
        $strings['NoTitleLabel'] = '(pas de titre)';
        $strings['UsageConfiguration'] = 'Rêgles d\'Utilisation';
        $strings['ChangeConfiguration'] = 'Modifier';
        $strings['ResourceMinLength'] = 'Les réservations doivent durer au minimum %s';
        $strings['ResourceMinLengthNone'] = 'Pas de durée minimum de réservation';
        $strings['ResourceMaxLength'] = 'Les réservations ne peuvent durer plus de %s';
        $strings['ResourceMaxLengthNone'] = 'Pas de durée maximum de réservation';
        $strings['ResourceRequiresApproval'] = 'Les réservations necessitent une approbation';
        $strings['ResourceRequiresApprovalNone'] = 'Les réservations ne necessitent pas d\' approbation';
        $strings['ResourcePermissionAutoGranted'] = 'La permission est automatique';
        $strings['ResourcePermissionNotAutoGranted'] = 'La permission n\'est pas automatique';
        $strings['ResourceMinNotice'] = 'Les réservations doivent être créées au moins %s avant l\'heure de début de réservation';
        $strings['ResourceMinNoticeNone'] = 'Les réservations peuvent être saisie jusqu\'au dernier moment ';
        $strings['ResourceMaxNotice'] = 'Les réservations ne doivent pas finir plus loin que %s du moment présent';
        $strings['ResourceMaxNoticeNone'] = 'Les réservations peuvent finir n\'importe quand';
        $strings['ResourceAllowMultiDay'] = 'Les réservations peuvent être à cheval sur plusieurs jours';
        $strings['ResourceNotAllowMultiDay'] = 'Les réservations ne peuvent pas être à cheval sur plusieurs jours';
        $strings['ResourceCapacity'] = 'Cette resssource a une capacité de %s personne(s)';
        $strings['ResourceCapacityNone'] = 'Cette ressource a une capacité non limitée';
        $strings['AddNewResource'] = 'Ajouter une Nouvelle Ressource';
        $strings['AddNewUser'] = 'Ajouter un Nouvel Utilisateur';
        $strings['AddUser'] = 'Ajouter un Utilisateur';
        $strings['Schedule'] = 'Planning';
        $strings['AddResource'] = 'Ajouter une Ressource';
        $strings['Capacity'] = 'Capacité';
        $strings['Access'] = 'Accès';
        $strings['Duration'] = 'Durée';
        $strings['Active'] = 'Actif';
        $strings['Inactive'] = 'Inactif';
        $strings['ResetPassword'] = 'Reinitialiser le Mot de Passe';
        $strings['LastLogin'] = 'Dernière Connexion';
        $strings['Search'] = 'Chercher';
        $strings['ResourcePermissions'] = 'Permissions de la Ressource';
        $strings['Reservations'] = 'Reservations';
        $strings['Groups'] = 'Groupes';
        $strings['ResetPassword'] = 'Reinitialiser le Mot de Passe';
        $strings['AllUsers'] = 'Tous les Utilisateurs';
        $strings['AllGroups'] = 'Tous les Groupes';
        $strings['AllSchedules'] = 'Tous les Plannings';
        $strings['UsernameOrEmail'] = 'Nom d\'utilisateur ou Email';
        $strings['Members'] = 'Membres';
        $strings['QuickSlotCreation'] = 'Créer des créneaux toutes les %s minutes entre %s et %s';
        $strings['ApplyUpdatesTo'] = 'Appliquer les Mises à jour à';
        $strings['CancelParticipation'] = 'Annuler la Participation';
        $strings['Attending'] = 'Attending';//
        $strings['QuotaConfiguration'] = 'Sur %s pour %s les utilisateurs de %s sont limités à %s %s par %s';
        $strings['reservations'] = 'reservations';
        $strings['ChangeCalendar'] = 'Changer de Calendrier';
        $strings['AddQuota'] = 'Ajouter un Quota';
        $strings['FindUser'] = 'Chercher un Utilisateur';
        $strings['Created'] = 'Créé';
        $strings['LastModified'] = 'Dernière Modification';
        $strings['GroupName'] = 'Nom du Groupe';
        $strings['GroupMembers'] = 'Membres du Groupe';
        $strings['GroupRoles'] = 'Roles du Groupe';
        $strings['GroupAdmin'] = 'Administrateur du Groupe';
        $strings['Actions'] = 'Actions';
        $strings['CurrentPassword'] = 'Mot de Passe Actuel';
        $strings['NewPassword'] = 'Nouveau Mot de Passe';
        $strings['InvalidPassword'] = 'Le Mot de Passe Actuel est incorrecte';
        $strings['PasswordChangedSuccessfully'] = 'Votre Mot de Passe a été modifié avec succès';
        $strings['SignedInAs'] = 'Utilisateur :';
        $strings['NotSignedIn'] = 'Vous n\'êtes pas connecté !';
        $strings['ReservationTitle'] = 'Libellé de la réservation';
        $strings['ReservationDescription'] = 'Description de la réservation';
        $strings['ResourceList'] = 'Ressources réservables';
        $strings['Accessories'] = 'Accessoires';
        $strings['Add'] = 'Ajouter';
        $strings['ParticipantList'] = 'Participants';
        $strings['InvitationList'] = 'Invités';
        $strings['AccessoryName'] = 'Nom de l\'accessoire';
        $strings['QuantityAvailable'] = 'Quantité disponible';
        $strings['Resources'] = 'Ressources';
        $strings['Participants'] = 'Participants';
        $strings['User'] = 'Utilisateur';
        $strings['Resource'] = 'Ressource';
        $strings['Status'] = 'Status';
        $strings['Approve'] = 'Approuver';
        $strings['Page'] = 'Page';
        $strings['Rows'] = 'Lignes';
        $strings['Unlimited'] = 'Illimité';
        $strings['Email'] = 'Email';
        $strings['EmailAddress'] = 'Adresse Email';
        $strings['Phone'] = 'Téléphone';
        $strings['Organization'] = 'Organisation';
        $strings['Position'] = 'Poste';
        $strings['Language'] = 'Langue';
        $strings['Permissions'] = 'Permissions';
        $strings['Reset'] = 'Reinitialistion';
        $strings['FindGroup'] = 'Chercher un Groupe';
        $strings['Manage'] = 'Gérer';
        $strings['None'] = 'Aucun';
        $strings['AddToOutlook'] = 'Ajouter à Outlook';
        $strings['Done'] = 'Valider';
        $strings['RememberMe'] = 'Se souvenir de moi';
        $strings['FirstTimeUser?'] = 'Débutant ?';
        $strings['CreateAnAccount'] = 'Créer un compte';
        $strings['ViewSchedule'] = 'Voir le planning';
        $strings['ForgotMyPassword'] = 'J\'ai oublié mon Mot de Passe';
        $strings['YouWillBeEmailedANewPassword'] = 'Vous allez recevoir par email un nouveau mot de passe généré automatiquement';
        $strings['Close'] = 'Fermer';
        $strings['ExportToCSV'] = 'Exporter en CSV';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'Patientez...';
        $strings['Login'] = 'Utilisateur';
        $strings['AdditionalInformation'] = 'Informations compléméntaires';
        $strings['AllFieldsAreRequired'] = 'Tous les champs sont obligatoires';
        $strings['Optional'] = 'optionnel';
        $strings['YourProfileWasUpdated'] = 'Votre compte à été mis à jour';
        $strings['YourSettingsWereUpdated'] = 'Vos préférences ont été mises à jour';
        $strings['Register'] = 'Enregistrer';
        $strings['SecurityCode'] = 'Code de Sécurité';
        $strings['ReservationCreatedPreference'] = 'Quand je crée une réservation ou qu\'on la crée en mon nom';
        $strings['ReservationUpdatedPreference'] = 'Quand je mets à jour une réservation ou que quelqu\'un le fait en mon nom';
        $strings['ReservationApprovalPreference'] = 'Quand ma reservation en attente est approuvée';
	$strings['ReservationDeletedPreference'] = 'Quand j\'efface une réservation ou qu\'on l\'efface en mon nom';
        $strings['PreferenceSendEmail'] = 'Envoyez moi un email';
        $strings['PreferenceNoEmail'] = 'Ne me prévenez pas';
        $strings['ReservationCreated'] = 'Votre réservation a été créée avec succès!';
        $strings['ReservationUpdated'] = 'Votre réservation a été mise à jour avec succès!!';
        $strings['ReservationRemoved'] = 'Votre réservation a été effacée!';
        $strings['YourReferenceNumber'] = 'Votre numéro de référence est le %s';
        $strings['UpdatingReservation'] = 'Mise à jour de la réservation';
        $strings['ChangeUser'] = 'Changer d\'Utilisateur';
        $strings['MoreResources'] = '+ de  Resources';
        $strings['ReservationLength'] = 'Durée de reservation :';
        $strings['ParticipantList'] = 'Liste des participants';
        $strings['AddParticipants'] = 'Ajouter des Participants';
        $strings['InviteOthers'] = 'Autres Invités';
        $strings['AddResources'] = 'Ajouter des Ressources';
        $strings['AddAccessories'] = 'Ajouter des Accessoires';
        $strings['Accessory'] = 'Accessoire';
        $strings['QuantityRequested'] = 'Quantité Demandée';
        $strings['CreatingReservation'] = 'Creation de  Réservation';
        $strings['UpdatingReservation'] = 'Mise à jour de Réservation';
        $strings['DeleteWarning'] = 'Cette action est définitive et non récupérable!';
        $strings['DeleteAccessoryWarning'] = 'Effacer cette accessoire le supprimera de toutes les réservations.';
        $strings['AddAccessory'] = 'Ajouter un Accessoire';
        $strings['AddBlackout'] = 'Ajouter une Mise Hors Service';
        $strings['AllResourcesOn'] = 'Appliquer à toutes les ressources';
        $strings['Reason'] = 'Motif';
        $strings['BlackoutShowMe'] = 'M\'afficher les réservations qui sont en conflit';
        $strings['BlackoutDeleteConflicts'] = 'Effacer les réservations en conflit';
        $strings['Filter'] = 'Filtrer';
        $strings['Between'] = 'Entre';
        $strings['CreatedBy'] = 'Créé par';
        $strings['BlackoutCreated'] = 'Mise Hors Service créée';
        $strings['BlackoutNotCreated'] = 'La Mise Hors Service n\'a pas pu être créée!';
        $strings['BlackoutConflicts'] = 'Il y a des periodes de Mises Hors Service en conflit';
        $strings['ReservationConflicts'] = 'Il y a des heures de réservation en conflit';
        $strings['UsersInGroup'] = 'Utilisateur(s) dans ce groupe';
        $strings['Browse'] = 'Parcourir';
        $strings['DeleteGroupWarning'] = 'Effacer ce groupe supprimera toutes les permissions de ressources associées. Les utilisateurs concernés pourraient perdre l\'acces à ces ressources.';
        $strings['WhatRolesApplyToThisGroup'] = 'Quel roles appliquer à ce groupe?';
        $strings['WhoCanManageThisGroup'] = 'Qui gère ce groupe?';
        $strings['AddGroup'] = 'Ajouter un Groupe';
        $strings['AllQuotas'] = 'Tous les Quotas';
        $strings['QuotaReminder'] = 'Attention: les Quotas sont forcément basés sur le fuseau horaire du planning.';
        $strings['AllReservations'] = 'Toutes les Réservations';
        $strings['PendingReservations'] = 'Reservations en attente';
        $strings['Approving'] = 'Approbation en cours';
        $strings['MoveToSchedule'] = 'Déplacer sur le planning';
        $strings['DeleteResourceWarning'] = 'Effacer cette this resource supprimera les données associées, incluant';
        $strings['DeleteResourceWarningReservations'] = 'toutes les reservations passeés, en cours et futures associées';
        $strings['DeleteResourceWarningPermissions'] = 'toutes les permissions attibuées';
        $strings['DeleteResourceWarningReassign'] = 'Réassignez tout ce que vous ne voulez pas perdre avant de valider';
        $strings['ScheduleLayout'] = 'Configuration (Toutes heures %s)';
        $strings['ReservableTimeSlots'] = 'Créneaux Réservables';
        $strings['BlockedTimeSlots'] = 'Créneaux Bloqués';
        $strings['ThisIsTheDefaultSchedule'] = 'Planning par défaut';
        $strings['DefaultScheduleCannotBeBroughtDown'] = 'Le Planning par défaut ne peut être désactivé';
        $strings['MakeDefault'] = 'Mettre par Défaut';
        $strings['BringDown'] = 'Désactiver';
        $strings['ChangeLayout'] = 'Modifier sa configuration';
        $strings['AddSchedule'] = 'Ajouter un Planning';
        $strings['StartsOn'] = 'Commence le';
        $strings['NumberOfDaysVisible'] = 'Nombre de jours visibles';
        $strings['UseSameLayoutAs'] = 'Utilise la même configuration que';
        $strings['Format'] = 'Format';
        $strings['OptionalLabel'] = 'Libellé optionnel';
        $strings['LayoutInstructions'] = 'Saisir un créneau par ligne.  Les créneaux doivent couvrir 24 heures (de minuit à minuit)';
        $strings['AddUser'] = 'Ajouter un Utilisateur';
        $strings['UserPermissionInfo'] = 'L\'accès réel aux ressources peut parfois être different de ce qui est indiqué ici (rôle de l\'utilisateur, permissions du groupe, réglages de permissions autres)';
        $strings['DeleteUserWarning'] = 'Effacer cet utilisateur supprimera toutes ces réservations passées, actuels et futures.';
        $strings['AddAnnouncement'] = 'Ajouter une Annonce';
        $strings['Announcement'] = 'Annonce';
        $strings['Priority'] = 'Priorité';
        $strings['Reservable'] = 'Reservable';
        $strings['Unreservable'] = 'Non Reservable';
        $strings['Reserved'] = 'Reservé';
        $strings['MyReservation'] = 'Mes Réservations';
        $strings['Pending'] = 'En attente';
        $strings['Past'] = 'Passé';
        $strings['Restricted'] = 'Restreint';
	$strings['ViewAll'] = 'Tout Voir';
        $strings['MoveResourcesAndReservations'] = 'Déplacer les ressources et réservations vers';
        $strings['TurnOffSubscription'] = 'Bloquer les inscriptions au Calendrier';
        $strings['TurnOnSubscription'] = 'Permettre les inscriptions au Calendrier';
        $strings['SubscribeToCalendar'] = 'S\'inscrire au Calendrier';
        $strings['SubscriptionsAreDisabled'] = 'L\'administrateur a bloqué les inscriptions a ce Calendrier';
        $strings['NoResourceAdministratorLabel'] = '(Pas d\'Administrateur de ressources)';
        $strings['WhoCanManageThisResource'] = 'Qui peut gérer cette ressource ?';
        $strings['ResourceAdministrator'] = 'Administrateur de ressources';
        $strings['Private'] = 'Privé';
        $strings['Accept'] = 'Accepter';
        $strings['Decline'] = 'Refuser';
        $strings['ShowFullWeek'] = 'Montrer semaine entière';
        $strings['CustomAttributes'] = 'Attributs personnalisés';
        $strings['AddAttribute'] = 'Ajouter un Attribut';
        $strings['EditAttribute'] = 'Mise à Jour d\'un Attribut';
        $strings['DisplayLabel'] = 'Titre affiché';
        $strings['Type'] = 'Type';
        $strings['Required'] = 'Obligatoire';
        $strings['ValidationExpression'] = 'Expression de Validation ';
        $strings['PossibleValues'] = 'Valeurs possibles';
        $strings['SingleLineTextbox'] = 'Champ de texte simple';
        $strings['MultiLineTextbox'] = 'Champ de texte multiligne';
        $strings['Checkbox'] = 'Case à cocher';
        $strings['SelectList'] = 'Liste de sélection';
        $strings['CommaSeparated'] = 'Séparé par des virgules';
        $strings['Category'] = 'Categorie';
        $strings['CategoryReservation'] = 'Réservation';
        $strings['CategoryGroup'] = 'Groupe';
        $strings['SortOrder'] = 'Tri';
        $strings['Title'] = 'Titre';
        $strings['AdditionalAttributes'] = 'Attribut supplémentaire';
        $strings['True'] = 'Vrai';
        $strings['False'] = 'Faux';

		$strings['ActivationEmailSent'] = 'Vous recevrez bientôt un email d\'activation.';
		$strings['AccountActivationError'] = 'Désolé, imposible d\'activer votre compte.';
		$strings['Attachments'] = 'Pièces jointes';
		$strings['AttachFile'] = 'Joindre un fichier';
		$strings['Maximum'] = 'max';
		$strings['NoScheduleAdministratorLabel'] = 'Pas d\'aministrateur de planning';
		$strings['ScheduleAdministrator'] = 'Aministrateur de planning';
		$strings['Total'] = 'Total';
		$strings['QuantityReserved'] = 'Quantité Reservée';
		$strings['AllAccessories'] = 'Tous les Accessoires';
		$strings['GetReport'] = 'Obtenir un Rapport';
		$strings['NoResultsFound'] = 'Aucun résultat trouvé';
		$strings['SaveThisReport'] = 'Enregistrer ce rapport';
		$strings['ReportSaved'] = 'Rapport enregistré!';
		$strings['EmailReport'] = 'Envoyer le rapport par mail';
		$strings['ReportSent'] = 'Rapport envoyé!';
		$strings['RunReport'] = 'Lancer le rapport';
		$strings['NoSavedReports'] = 'Aucun rapport enregistré.';
		$strings['CurrentWeek'] = 'Semaine en cours';
		$strings['CurrentMonth'] = 'Mois en cours';
		$strings['AllTime'] = 'Tout';
		$strings['FilterBy'] = 'Filtré par';
		$strings['Select'] = 'Selectionnez';
		$strings['List'] = 'Liste';
		$strings['TotalTime'] = 'Temps total';
		$strings['Count'] = 'Compte';
		$strings['Usage'] = 'Utilisation';
		$strings['AggregateBy'] = 'Grouper par';
		$strings['Range'] = 'Période';
		$strings['Choose'] = 'Choisir';
		$strings['All'] = 'Tout';
		$strings['ViewAsChart'] = 'Voir en Graphique';



        // Errors
        $strings['LoginError'] = 'Nom d\'utilisateur ou mot de passe inconnu';
        $strings['ReservationFailed'] = 'Votre réservation ne peut être créée';
        $strings['MinNoticeError'] = 'Cette réservation possède une contrainte de délai.  Vous pourrez réserver au plus tôt le %s.';
        $strings['MaxNoticeError'] = 'Cette réservation ne peut être créée à une date si éloignée.  Il est possible de réserver jusqu\'au %s.';
        $strings['MinDurationError'] = 'Cette reservation doit durer au minimum %s.';
        $strings['MaxDurationError'] = 'Cette réservation ne peut durer plus de %s.';
        $strings['ConflictingAccessoryDates'] = 'Il n\'y a pas assez d\'accessoires suivants:';
        $strings['NoResourcePermission'] = 'Vous n\'avez pas la permission d\'accceder à une ou plusieur des ressources demandées';
        $strings['ConflictingReservationDates'] = 'Il y a des réservations en conflit à la date suivante:';
        $strings['StartDateBeforeEndDateRule'] = 'La date de départ doit être avant la date de fin';
        $strings['StartIsInPast'] = 'La date de départ ne peut être passée';
        $strings['EmailDisabled'] = 'L\'administrateur a désactivé les notifications par email';
        $strings['ValidLayoutRequired'] = 'Les créneaux doivent couvrir 24 heures (de minuit à minuit).';

        $strings['CustomAttributeErrors'] = 'Il y a un problème avec l\'attribut supplémentaire que vous avez ajouté :';
        $strings['CustomAttributeRequired'] = '%s est un champ obligatoire';
        $strings['CustomAttributeInvalid'] = 'La valeur saisie pour %s est invalide';
        $strings['AttachmentLoadingError'] = 'Désolé, il ya eu un problème de chargement du fichier demandé.';
        $strings['InvalidAttachmentExtension'] = 'Vous pouvez uniquement uploader des fichiers de type : %s';



        // Page Titles
        $strings['CreateReservation'] = 'Créer une Réservation';
        $strings['EditReservation'] = 'Editer un Réservation';
        $strings['LogIn'] = 'Connexion';
        $strings['ManageReservations'] = 'Réservations';
        $strings['AwaitingActivation'] = 'En attente d\'Activation';
        $strings['PendingApproval'] = 'En attente d\'Approbation';
        $strings['ManageSchedules'] = 'Plannings';
        $strings['ManageResources'] = 'Ressources';
        $strings['ManageAccessories'] = 'Accessoires';
        $strings['ManageUsers'] = 'Utilisateurs';
        $strings['ManageGroups'] = 'Groupes';
        $strings['ManageQuotas'] = 'Quotas';
        $strings['ManageBlackouts'] = 'Periodes de Mise Hors Service';
        $strings['MyDashboard'] = 'Mon tableau de bord';
        $strings['ServerSettings'] = 'Préferences du serveur';
        $strings['Dashboard'] = 'Tableau de bord';
        $strings['Help'] = 'Aide';
        $strings['Bookings'] = 'Réservations';
        $strings['Schedule'] = 'Planning';
        $strings['Reservations'] = 'Réservations';
        $strings['Account'] = 'Compte';
        $strings['EditProfile'] = 'Editer Mon Profil';
        $strings['FindAnOpening'] = 'Trouver une invitation';
        $strings['OpenInvitations'] = 'Invitations';
        $strings['MyCalendar'] = 'Mon Calendrier';
        $strings['ResourceCalendar'] = 'Calendrier des Ressources';
        $strings['Reservation'] = 'Nouvelle Réservation';
        $strings['Install'] = 'Installation';
        $strings['ChangePassword'] = 'Modifier le Mot de Passe';
        $strings['MyAccount'] = 'Mon Compte';
        $strings['Profile'] = 'Profil';
        $strings['ApplicationManagement'] = 'Gestion de l\'Application';
        $strings['ForgotPassword'] = 'Mot de Passe perdu';
        $strings['NotificationPreferences'] = 'Préférences de messagerie';

        $strings['ManageAnnouncements'] = 'Annonces';
        $strings['Responsibilities'] = 'Responsables';
        $strings['GroupReservations'] = 'Reservations de Groupe';
        $strings['ResourceReservations'] = 'Reservations de Resource ';
        $strings['Customization'] = 'Personnalisation';
        $strings['Attributes'] = 'Attributs';
	$strings['AccountActivation'] = 'Activation de compte';
	$strings['ScheduleReservations'] = 'Reservations du Planning';
	$strings['Reports'] = 'Rapports';
	$strings['GenerateReport'] = 'Nouveau Rapport';
	$strings['MySavedReports'] = 'Rapports sauvegardés';
	$strings['CommonReports'] = 'Rapports Standards';
	$strings['ViewDay'] = 'Vue/Jour';
	$strings['Group'] = 'Groupe';

        //

        // Day representations
        $strings['DaySundaySingle'] = 'D';
        $strings['DayMondaySingle'] = 'L';
        $strings['DayTuesdaySingle'] = 'M';
        $strings['DayWednesdaySingle'] = 'M';
        $strings['DayThursdaySingle'] = 'J';
        $strings['DayFridaySingle'] = 'V';
        $strings['DaySaturdaySingle'] = 'S';

        $strings['DaySundayAbbr'] = 'Dim';
        $strings['DayMondayAbbr'] = 'Lun';
        $strings['DayTuesdayAbbr'] = 'Mar';
        $strings['DayWednesdayAbbr'] = 'Mer';
        $strings['DayThursdayAbbr'] = 'Jeu';
        $strings['DayFridayAbbr'] = 'Ven';


        $strings['DaySaturdayAbbr'] = 'Sam';

        // Email Subjects
        $strings['ReservationApprovedSubject'] = 'Votre réservation a été approuvée';
        $strings['ReservationCreatedSubject'] = 'Votre réservation a été créée';
        $strings['ReservationUpdatedSubject'] = 'Votre réservation a été mise à jour';
        $strings['ReservationDeletedSubject'] = 'Votre réservation a été effacée';
        $strings['ReservationCreatedAdminSubject'] = 'Notification: Une réservation a été créée';
        $strings['ReservationUpdatedAdminSubject'] = 'Notification: Une réservation a été mise à jour';
        $strings['ReservationDeleteAdminSubject'] = 'Notification: Une réservation a été effacée';
        $strings['ParticipantAddedSubject'] = 'Notication de Participation à une Réservation';
        $strings['ParticipantDeletedSubject'] = 'Reservation Effacée';
        $strings['InviteeAddedSubject'] = 'Invitation à une Réservation';
        $strings['ResetPassword'] = 'Demande de réinitialisation de Mot de Passe';
        $strings['ForgotPasswordEmailSent'] = 'Un email contenant les instructions pour réinitialiser votre mot de passe vous a été envoyé.';
        $strings['ActivateYourAccount'] = 'Activez votre compte SVP';
        $strings['ReportSubject'] = 'Le rapport demandé (%s)';
        //

        $this->Strings = $strings;
    }

    protected function _LoadDays()
    {
        $days = parent::_LoadDays();

        /***
        DAY NAMES
        All of these arrays MUST start with Sunday as the first element
        and go through the seven day week, ending on Saturday
         ***/
        // The full day name
        $days['full'] = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
        // The three letter abbreviation
        $days['abbr'] = array('Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam');
        // The two letter abbreviation
        $days['two'] = array('Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa');
        // The one letter abbreviation
        $days['letter'] = array('D', 'L', 'M', 'M', 'J', 'V', 'S');

        $this->Days = $days;
    }

    protected function _LoadMonths()
    {
        $months = parent::_LoadMonths();

        /***
        MONTH NAMES
        All of these arrays MUST start with January as the first element
        and go through the twelve months of the year, ending on December
         ***/
        // The full month name
        $months['full'] = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
        // The three letter month name
        $months['abbr'] = array('Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec');

        $this->Months = $months;
    }

    protected function _LoadLetters()
    {
        $this->Letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    }

    protected function _GetHtmlLangCode()
    {
        return 'fr';
    }
}

?>