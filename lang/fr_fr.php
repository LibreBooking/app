<?php
/**
 * Copyright 2011-2019 Nick Korbel, Boris Vatin
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once('Language.php');
require_once('en_gb.php');

class fr_fr extends en_gb
{
	public function __construct()
	{
		parent::__construct();
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
		$strings['ScheduleCalendar'] = 'Calendrier du planning';
		$strings['Registration'] = 'Enregistrement';
		$strings['NoAnnouncements'] = 'Il n\'y a aucune annonce';
		$strings['Announcements'] = 'Annonces';
		$strings['NoUpcomingReservations'] = 'Vous n\'avez aucune réservation à venir';
		$strings['UpcomingReservations'] = 'Réservations à venir';
		$strings['AllNoUpcomingReservations'] = 'Il n\'y a pas de réservations dans les %s prochains jours';
		$strings['AllUpcomingReservations'] = 'Toutes les Réservations à Venir';
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
		$strings['EditReservationHeading'] = 'Editer la réservation %s';
		$strings['ViewReservationHeading'] = 'Visualisation de la réservation %s';
		$strings['ReservationErrors'] = 'Changer la Réservation';
		$strings['Create'] = 'Créer';
		$strings['ThisInstance'] = 'Cette Instance seule';
		$strings['AllInstances'] = 'Toutes les Instances';
		$strings['FutureInstances'] = 'Futures Instances';
		$strings['Print'] = 'Imprimer';
		$strings['ShowHideNavigation'] = 'Afficher/Cacher le Menu';
		$strings['ReferenceNumber'] = 'Numéro de Référence';
		$strings['Tomorrow'] = 'Demain';
		$strings['LaterThisWeek'] = 'Reste de la semaine';
		$strings['NextWeek'] = 'La semaine prochaine';
		$strings['SignOut'] = 'Déconnexion';
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
		$strings['UsageConfiguration'] = 'Règles d\'Utilisation';
		$strings['ChangeConfiguration'] = 'Modifier';
		$strings['ResourceMinLength'] = 'Les réservations doivent durer au minimum %s';
		$strings['ResourceMinLengthNone'] = 'Pas de durée minimum de réservation';
		$strings['ResourceMaxLength'] = 'Les réservations ne peuvent durer plus de %s';
		$strings['ResourceMaxLengthNone'] = 'Pas de durée maximum de réservation';
		$strings['ResourceRequiresApproval'] = 'Les réservations nécessitent une approbation';
		$strings['ResourceRequiresApprovalNone'] = 'Les réservations ne nécessitent pas d\'approbation';
		$strings['ResourcePermissionAutoGranted'] = 'La permission est automatique';
		$strings['ResourcePermissionNotAutoGranted'] = 'La permission n\'est pas automatique';
		$strings['ResourceMinNotice'] = 'Les réservations doivent être créées au moins %s avant l\'heure de début de réservation';
		$strings['ResourceMinNoticeNone'] = 'Les réservations peuvent être saisies jusqu\'au dernier moment ';
		$strings['ResourceMaxNotice'] = 'Les réservations ne doivent pas finir plus loin que %s du moment présent';
		$strings['ResourceMaxNoticeNone'] = 'Les réservations peuvent finir n\'importe quand';
		$strings['ResourceBufferTime'] = 'Il doit y avoir %s entre les réservations';
		$strings['ResourceBufferTimeNone'] = 'Il n\'y a pas de laps de temps entre les réservations';
		$strings['ResourceAllowMultiDay'] = 'Les réservations peuvent être à cheval sur plusieurs jours';
		$strings['ResourceNotAllowMultiDay'] = 'Les réservations ne peuvent pas être à cheval sur plusieurs jours';
		$strings['ResourceCapacity'] = 'Cette ressource a une capacité de %s personne(s)';
		$strings['ResourceCapacityNone'] = 'Cette ressource a une capacité non limitée';
		$strings['AddNewResource'] = 'Ajouter une Nouvelle Ressource';
		$strings['AddNewUser'] = 'Ajouter un Nouvel Utilisateur';
		$strings['AddResource'] = 'Ajouter une Ressource';
		$strings['Capacity'] = 'Capacité';
		$strings['Access'] = 'Accès';
		$strings['Duration'] = 'Durée';
		$strings['Active'] = 'Actif';
		$strings['Inactive'] = 'Inactif';
		$strings['ResetPassword'] = 'Réinitialiser le Mot de Passe';
		$strings['LastLogin'] = 'Dernière Connexion';
		$strings['Search'] = 'Chercher';
		$strings['ResourcePermissions'] = 'Permissions de la Ressource';
		$strings['Reservations'] = 'Réservations';
		$strings['Groups'] = 'Groupes';
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
		$strings['QuotaEnforcement'] = 'Contrainte %s %s';
		$strings['reservations'] = 'réservations';
		$strings['ChangeCalendar'] = 'Changer de Calendrier';
		$strings['AddQuota'] = 'Ajouter un Quota';
		$strings['FindUser'] = 'Chercher un Utilisateur';
		$strings['Created'] = 'Créé';
		$strings['LastModified'] = 'Dernière Modification';
		$strings['GroupName'] = 'Nom du Groupe';
		$strings['GroupMembers'] = 'Membres du Groupe';
		$strings['GroupRoles'] = 'Rôles du Groupe';
		$strings['GroupAdmin'] = 'Administrateur du Groupe';
		$strings['Actions'] = 'Actions';
		$strings['CurrentPassword'] = 'Mot de Passe Actuel';
		$strings['NewPassword'] = 'Nouveau Mot de Passe';
		$strings['InvalidPassword'] = 'Le Mot de Passe Actuel est incorrect';
		$strings['PasswordChangedSuccessfully'] = 'Votre Mot de Passe a été modifié avec succès';
		$strings['SignedInAs'] = 'Utilisateur :';
		$strings['NotSignedIn'] = 'Vous n\'êtes pas connecté !';
		$strings['ReservationTitle'] = 'Libellé de la réservation';
		$strings['ReservationDescription'] = 'Description de la réservation';
		$strings['ResourceList'] = 'Ressources réservables';
		$strings['Accessories'] = 'Accessoires';
		$strings['InvitationList'] = 'Invités';
		$strings['AccessoryName'] = 'Nom de l\'accessoire';
		$strings['QuantityAvailable'] = 'Quantité disponible';
		$strings['Resources'] = 'Ressources';
		$strings['Participants'] = 'Participants';
		$strings['User'] = 'Utilisateur';
		$strings['Resource'] = 'Ressource';
		$strings['Status'] = 'Statut';
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
		$strings['Reset'] = 'Réinitialisation';
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
		$strings['AdditionalInformation'] = 'Informations complémentaires';
		$strings['AllFieldsAreRequired'] = 'Tous les champs sont obligatoires';
		$strings['Optional'] = 'optionnel';
		$strings['YourProfileWasUpdated'] = 'Votre compte à été mis à jour';
		$strings['YourSettingsWereUpdated'] = 'Vos préférences ont été mises à jour';
		$strings['Register'] = 'Enregistrer';
		$strings['SecurityCode'] = 'Code de Sécurité';
		$strings['ReservationCreatedPreference'] = 'Quand je crée une réservation ou qu\'on la crée en mon nom';
		$strings['ReservationUpdatedPreference'] = 'Quand je mets à jour une réservation ou que quelqu\'un le fait en mon nom';
		$strings['ReservationApprovalPreference'] = 'Quand ma réservation en attente est approuvée';
		$strings['ReservationDeletedPreference'] = 'Quand j\'efface une réservation ou qu\'on l\'efface en mon nom';
		$strings['PreferenceSendEmail'] = 'Envoyez-moi un email';
		$strings['PreferenceNoEmail'] = 'Ne me prévenez pas';
		$strings['ReservationCreated'] = 'Votre réservation a été créée avec succès!';
		$strings['ReservationUpdated'] = 'Votre réservation a été mise à jour avec succès!!';
		$strings['ReservationRemoved'] = 'Votre réservation a été effacée!';
		$strings['ReservationRequiresApproval'] = 'Une ou plusieurs ressources réservées nécessitent une approbation. Cette réservation est donc mise en attente jusqu\'à ce qu\'elle soit approuvée';
		$strings['YourReferenceNumber'] = 'Votre numéro de référence est le %s';
		$strings['ChangeUser'] = 'Changer d\'Utilisateur';
		$strings['MoreResources'] = '+ de  Resources';
		$strings['ReservationLength'] = 'Durée de la réservation :';
		$strings['ParticipantList'] = 'Liste des participants';
		$strings['AddParticipants'] = 'Ajouter des Participants';
		$strings['InviteOthers'] = 'Autres Invités';
		$strings['AddResources'] = 'Ajouter des Ressources';
		$strings['AddAccessories'] = 'Ajouter des Accessoires';
		$strings['Accessory'] = 'Accessoire';
		$strings['QuantityRequested'] = 'Quantité Demandée';
		$strings['CreatingReservation'] = 'Création de Réservation';
		$strings['UpdatingReservation'] = 'Mise à jour de la Réservation';
		$strings['DeleteWarning'] = 'Cette action est définitive et non récupérable!';
		$strings['DeleteAccessoryWarning'] = 'Effacer cet accessoire le supprimera de toutes les réservations.';
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
		$strings['BlackoutConflicts'] = 'Il y a des périodes de Mises Hors Service en conflit';
		$strings['ReservationConflicts'] = 'Il y a des heures de réservation en conflit';
		$strings['UsersInGroup'] = 'Utilisateur(s) dans ce groupe';
		$strings['Browse'] = 'Parcourir';
		$strings['DeleteGroupWarning'] = 'Effacer ce groupe supprimera toutes les permissions de ressources associées. Les utilisateurs concernés pourraient perdre l\'acces à ces ressources.';
		$strings['WhatRolesApplyToThisGroup'] = 'Quel rôles appliquer à ce groupe?';
		$strings['WhoCanManageThisGroup'] = 'Qui gère ce groupe?';
		$strings['AddGroup'] = 'Ajouter un Groupe';
		$strings['AllQuotas'] = 'Tous les Quotas';
		$strings['QuotaReminder'] = 'Attention: les Quotas sont forcément basés sur le fuseau horaire du planning.';
		$strings['AllReservations'] = 'Toutes les Réservations';
		$strings['PendingReservations'] = 'Réservations en attente';
		$strings['Approving'] = 'Approbation en cours';
		$strings['MoveToSchedule'] = 'Déplacer sur le planning';
		$strings['DeleteResourceWarning'] = 'Effacer cette ressource supprimera les données associées, incluant';
		$strings['DeleteResourceWarningReservations'] = 'toutes les réservations passées, en cours et futures associées';
		$strings['DeleteResourceWarningPermissions'] = 'toutes les permissions attribuées';
		$strings['DeleteResourceWarningReassign'] = 'Réassignez tout ce que vous ne voulez pas perdre avant de valider';
		$strings['ScheduleLayout'] = 'Configuration (Toutes heures %s)';
		$strings['ReservableTimeSlots'] = 'Créneaux Réservables';
		$strings['BlockedTimeSlots'] = 'Créneaux Bloqués';
		$strings['ThisIsTheDefaultSchedule'] = 'Planning par défaut';
		$strings['DefaultScheduleCannotBeDeleted'] = 'Le planning par défaut ne peut pas être désactivé';
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
		$strings['DeleteUserWarning'] = 'Effacer cet utilisateur supprimera toutes ses réservations passées, actuelles et futures.';
		$strings['AddAnnouncement'] = 'Ajouter une Annonce';
		$strings['Announcement'] = 'Annonce';
		$strings['Priority'] = 'Priorité';
		$strings['Reservable'] = 'Réservable';
		$strings['Unreservable'] = 'Non Réservable';
		$strings['Reserved'] = 'Réservé';
		$strings['MyReservation'] = 'Mes Réservations';
		$strings['Pending'] = 'En attente';
		$strings['Past'] = 'Passé';
		$strings['Restricted'] = 'Restreint';
		$strings['ViewAll'] = 'Tout Voir';
		$strings['MoveResourcesAndReservations'] = 'Déplacer les ressources et réservations vers';
		$strings['TurnOffSubscription'] = 'Bloquer les inscriptions au Calendrier';
		$strings['TurnOnSubscription'] = 'Permettre les inscriptions au Calendrier';
		$strings['SubscribeToCalendar'] = 'S\'inscrire au Calendrier';
		$strings['SubscriptionsAreDisabled'] = 'L\'administrateur a bloqué les inscriptions à ce Calendrier';
		$strings['NoResourceAdministratorLabel'] = '(Pas d\'Administrateur de ressources)';
		$strings['WhoCanManageThisResource'] = 'Qui peut gérer cette ressource ?';
		$strings['ResourceAdministrator'] = 'Administrateur de la Ressource';
		$strings['Private'] = 'Privé';
		$strings['Accept'] = 'Accepter';
		$strings['Decline'] = 'Refuser';
		$strings['ShowFullWeek'] = 'Montrer la semaine entière';
		$strings['CustomAttributes'] = 'Attributs Personnalisés';
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
		$strings['Category'] = 'Catégorie';
		$strings['CategoryReservation'] = 'Réservation';
		$strings['CategoryGroup'] = 'Groupe';
		$strings['SortOrder'] = 'Tri';
		$strings['Title'] = 'Titre';
		$strings['AdditionalAttributes'] = 'Attribut supplémentaire';
		$strings['True'] = 'Vrai';
		$strings['False'] = 'Faux';

		$strings['ActivationEmailSent'] = 'Vous recevrez bientôt un email d\'activation.';
		$strings['AccountActivationError'] = 'Désolé, impossible d\'activer votre compte.';
		$strings['Attachments'] = 'Pièces-jointes';
		$strings['AttachFile'] = 'Joindre un fichier';
		$strings['Maximum'] = 'max';
		$strings['NoScheduleAdministratorLabel'] = 'Pas d\'administrateur de planning';
		$strings['ScheduleAdministrator'] = 'Administrateur de planning';
		$strings['Total'] = 'Total';
		$strings['QuantityReserved'] = 'Quantité Réservée';
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
		$strings['Select'] = 'Sélectionnez';
		$strings['List'] = 'Liste';
		$strings['TotalTime'] = 'Temps total';
		$strings['Count'] = 'Compte';
		$strings['Usage'] = 'Utilisation';
		$strings['AggregateBy'] = 'Grouper par';
		$strings['Range'] = 'Période';
		$strings['Choose'] = 'Choisir';
		$strings['All'] = 'Tout';
		$strings['ViewAsChart'] = 'Voir en Graphique';
		$strings['ReservedResources'] = 'Ressources Réservées';
		$strings['ReservedAccessories'] = 'Accessoires Réservés';
		$strings['ResourceUsageTimeBooked'] = 'Utilisation des Ressources - Durée des Réservations';
		$strings['ResourceUsageReservationCount'] = 'Utilisation des Ressources - Nombre de Réservations';
		$strings['Top20UsersTimeBooked'] = 'Top 20 des Utilisateurs - Durée des Réservations';
		$strings['Top20UsersReservationCount'] = 'Top 20 des Utilisateurs - Nombre de Réservations';
		$strings['ConfigurationUpdateHelp'] = 'Veuillez vous référer à la section Configuration du <a target=_blank href=%s>fichier d\'aide</a> pour la documentation concernant ces paramètres.';
		$strings['GeneralConfigSettings'] = 'paramètres';
		$strings['UseSameLayoutForAllDays'] = 'Utiliser la même disposition pour tous les jours';
		$strings['MakeDefaultSchedule'] = 'Faire de cette page mon planning par défault';
		$strings['Next'] = 'Suivant';
		$strings['Success'] = 'Réussi';
		$strings['ResourceFilter'] = 'Filtre de Ressources';
		$strings['ResourceGroups'] = 'Groupes de la Ressource';
		$strings['AddNewGroup'] = 'Ajouter un nouveau groupe';
		$strings['StandardScheduleDisplay'] = 'Afficher le planning standard';
		$strings['TallScheduleDisplay'] = 'Afficher le planning en mode étroit';
		$strings['WideScheduleDisplay'] = 'Afficher le planning en mode large';
		$strings['CondensedWeekScheduleDisplay'] = 'Afficher le planning de la semaine en mode compact';
		$strings['ResourceGroupHelp1'] = 'Faire un glisser/déposer pour réorganiser les groupes des ressources.';
		$strings['ResourceGroupHelp2'] = 'Faire un clic droit sur le nom d\'un groupe pour effectuer des actions supplémentaires.';
		$strings['ResourceGroupHelp3'] = 'Faire un glisser/déposer sur une ressource pour l\'ajouter à un groupe.';
		$strings['ResourceGroupWarning'] = 'Si des groupes sont utilisés pour les ressources, chaque ressource doit être associée à au moins un groupe. Les ressources non associées ne peuvent pas être réservées.';
		$strings['ResourceType'] = 'Type de Ressources';
		$strings['AddResourceType'] = 'Ajouter un Type de Ressources';
		$strings['NoResourceTypeLabel'] = '(aucun type de ressources défini)';
		$strings['ClearFilter'] = 'Supprimer le Filtre';
		$strings['MinimumCapacity'] = 'Capacité Minimale';
		$strings['Color'] = 'Couleur';
		$strings['Available'] = 'Disponible';
		$strings['Unavailable'] = 'Indisponible';
		$strings['Hidden'] = 'Caché';
		$strings['File'] = 'Fichier';
		$strings['BulkResourceUpdate'] = 'Modifier les Ressources en Bloc';
		$strings['Unchanged'] = 'Inchangé';
		$strings['Common'] = 'Commun';
		$strings['AdminOnly'] = 'Administrateurs Seulement';
		$strings['ChangeLanguage'] = 'Changer la Langue';
		$strings['AddRule'] = 'Ajouter la Règle';
		$strings['Attribute'] = 'Attribut';
		$strings['RequiredValue'] = 'Valeur Requise';
		$strings['ReservationCustomRuleAdd'] = 'Si %s alors la couleur de la réservation sera';
		$strings['AddReservationColorRule'] = 'Ajouter une Règle de Couleur pour les Réservations';
		$strings['LimitAttributeScope'] = 'Afficher dans des Cas Spécifiques';
		$strings['CollectFor'] = 'Afficher pour';
		$strings['SignIn'] = 'Connexion';
		$strings['AllParticipants'] = 'Tous les Participants';
		$strings['More'] = 'Plus';
		$strings['ResourceAvailability'] = 'Disponibilité des Ressources';
		$strings['UnavailableAllDay'] = 'Indisponible toute la Journée';
		$strings['AvailableUntil'] = 'Disponible jusqu\'au';
		$strings['AllResourceTypes'] = 'Tous les Types de Ressources';
		$strings['AllResourceStatuses'] = 'Tous les États de Ressources';
		$strings['Import'] = 'Importer';
		$strings['Columns'] = 'Colonnes';
		$strings['Reserve'] = 'Réserver';
		$strings['AllDay'] = 'Toute la Journée';
		$strings['Everyday'] = 'Tous les Jours';
		$strings['IncludingCompletedReservations'] = 'Inclure les Réservations déjà Terminées';
		$strings['NotCountingCompletedReservations'] = 'Ne pas inclure les Réservations déjà Terminées';
		$strings['ResourceColor'] = 'Couleur de la Ressource';
		$strings['RequiresCheckInNotification'] = 'Requiert un check in/out';
		$strings['NoCheckInRequiredNotification'] = 'Ne requiert pas de check in/out';
		$strings['Users'] = 'Utilisateurs';
		$strings['MoreOptions'] = 'Plus d\'options';
		$strings['SendAsEmail'] = 'Envoyer par Email';
		$strings['UsersInGroups'] = 'Utilisateurs dans le Groupe';
		$strings['UsersWithAccessToResources'] = 'Utilisateurs avec Accès à la Ressource';
		$strings['Day'] = 'Jour';
		$strings['PrintQRCode'] = 'Imprimer le code QR';
		$strings['FindATime'] = 'Trouver une Disponibilité';
		$strings['AnyResource'] = 'Toutes les Ressources';
		$strings['ThisWeek'] = 'Cette Semaine';
		$strings['Hours'] = 'Heures';
		$strings['Minutes'] = 'Minutes';
		$strings['ImportICS'] = 'Importer depuis ICS';
		$strings['ImportQuartzy'] = 'Importer depuis Quartzy';
		$strings['BlackoutAroundConflicts'] = 'Mettre hors service autour des réservations qui sont en conflit';
		$strings['DuplicateReservation'] = 'Dupliquer';
		$strings['CollectedFor'] = 'Associé à';
		$strings['IncludeDeleted'] = 'Inclure les Réservations Supprimées';
		$strings['Back'] = 'Précédent';
		$strings['Forward'] = 'Suivant';
		$strings['DateRange'] = 'Intervalle de Temps';
		// End Strings

		// Install
		$strings['InstallApplication'] = 'Installer Booked Scheduler (seulement avec MySQL)';
		$strings['IncorrectInstallPassword'] = 'Désolé, ce mot de passe est incorrect.';
		$strings['SetInstallPassword'] = 'Vous devez définir un mot de passe pour votre installation avant de pouvoir poursuivre votre installation.';
		$strings['InstallPasswordInstructions'] = 'Dans %s veuillez définir %s avec un mot de passe qui est aléatoire et difficile à trouver, ensuite retournez à cette page.<br/>Vous pouvez utiliser %s';
		$strings['NoUpgradeNeeded'] = 'Booked est à jour. Aucune mise à jour n\'est nécessaire.';
		$strings['ProvideInstallPassword'] = 'Veuillez entrer le mot de passe de votre installation.';
		$strings['InstallPasswordLocation'] = 'Il se trouve dans %s sous %s.';
		$strings['VerifyInstallSettings'] = 'Veuillez vérifier les paramètres par défaut suivants avant de continuer. Vous pouvez les modifier dans %s.';
		$strings['DatabaseName'] = 'Nom de la base de données';
		$strings['DatabaseUser'] = 'Nom d\'utilisateur de la base';
		$strings['DatabaseHost'] = 'Nom d\'hôte de la base';
		$strings['DatabaseCredentials'] = 'Veuillez fournir l\'identifiant d\'un utilisateur MySQL qui a les privilèges pour créer des bases de données. Si vous n\'en connaissez pas, veuillez contacter votre administrateur de bases de données. Dans la plupart des cas, le compte \'root\' devrait fonctionner.';
		$strings['MySQLUser'] = 'Nom d\'utilisateur MySQL';
		$strings['InstallOptionsWarning'] = 'Les options suivantes ne fonctionnent probablement pas dans un environnement hébergé. Dans ce cas, veuillez utiliser l\'assistant MySQL pour effectuer ces étapes.';
		$strings['CreateDatabase'] = 'Créer la base de données';
		$strings['CreateDatabaseUser'] = 'Créer le compte utilisateur de la base';
		$strings['PopulateExampleData'] = 'Importer des exemples de données. Cela va créer le compte administrateur: admin/password et le compte utilisateur: user/password';
		$strings['DataWipeWarning'] = 'Attention: cela va effacer toutes les données existantes';
		$strings['RunInstallation'] = 'Effectuer l\'installation';
		$strings['UpgradeNotice'] = 'Vous effectuez une mise à jour de la version <b>%s</b> vers la version <b>%s</b>';
		$strings['RunUpgrade'] = 'Effectuer la mise à jour';
		$strings['Executing'] = 'En cours d\'exécution';
		$strings['StatementFailed'] = 'Echec. Détails:';
		$strings['SQLStatement'] = 'Commande SQL:';
		$strings['ErrorCode'] = 'Code d\'erreur:';
		$strings['ErrorText'] = 'Texte d\'erreur:';
		$strings['InstallationSuccess'] = 'L\'installation s\'est achevée avec succès!';
		$strings['RegisterAdminUser'] = 'Enregistrer votre compte administrateur. Ceci est obligatoire si vous n\'avez pas importé les exemples de données. Vérifiez que $conf[\'settings\'][\'allow.self.registration\'] = \'true\' dans votre fichier %s.';
		$strings['LoginWithSampleAccounts'] = 'Si vous avez importé les exemples de données, vous pouvez vous connecter avec admin/password pour être administrateur ou avec user/password pour un simple compte utilisateur.';
		$strings['InstalledVersion'] = 'Vous utilisez à présent la version %s de Booked Scheduler';
		$strings['InstallUpgradeConfig'] = 'Il est recommandé de mettre à jour votre fichier de configuration';
		$strings['InstallationFailure'] = 'Il y a des problèmes avec l\'installation. Veuillez les corriger et réessayer.';
		$strings['ConfigureApplication'] = 'Configurer Booked Scheduler';
		$strings['ConfigUpdateSuccess'] = 'Votre fichier de configuration est maintenant à jour!';
		$strings['ConfigUpdateFailure'] = 'Nous n\'avons pas pu mettre à jour votre fichier de configuration automatiquement. Veuillez modifier le contenu de votre fichier config.php avec les données suivantes:';
		$strings['SelectUser'] = 'Sélectionner un Utilisateur';
		$strings['InviteUsers'] = 'Inviter des Utilisateurs';
		$strings['InviteUsersLabel'] = 'Entrer les adresses email des personnes à inviter';
		// End Install

		// Errors
		$strings['LoginError'] = 'Nom d\'utilisateur ou mot de passe inconnu';
		$strings['ReservationFailed'] = 'Votre réservation ne peut être créée';
		$strings['MinNoticeError'] = 'Cette réservation possède une contrainte de délai.  Vous pourrez réserver au plus tôt le %s.';
		$strings['MaxNoticeError'] = 'Cette réservation ne peut être créée à une date si éloignée.  Il est possible de réserver jusqu\'au %s.';
		$strings['MinDurationError'] = 'Cette réservation doit durer au minimum %s.';
		$strings['MaxDurationError'] = 'Cette réservation ne peut durer plus de %s.';
		$strings['ConflictingAccessoryDates'] = 'Il n\'y a pas assez d\'accessoires suivants:';
		$strings['NoResourcePermission'] = 'Vous n\'avez pas la permission d\'accéder à une ou plusieurs des ressources demandées';
		$strings['ConflictingReservationDates'] = 'Il y a des réservations en conflit à la date suivante:';
		$strings['StartDateBeforeEndDateRule'] = 'La date de départ doit être avant la date de fin';
		$strings['StartIsInPast'] = 'La date de départ ne peut être passée';
		$strings['EmailDisabled'] = 'L\'administrateur a désactivé les notifications par email.';
		$strings['ValidLayoutRequired'] = 'Les créneaux doivent couvrir 24 heures (de minuit à minuit).';

		$strings['CustomAttributeErrors'] = 'Il y a un problème avec l\'attribut supplémentaire que vous avez ajouté :';
		$strings['CustomAttributeRequired'] = '%s est un champ obligatoire';
		$strings['CustomAttributeInvalid'] = 'La valeur saisie pour %s est invalide';
		$strings['AttachmentLoadingError'] = 'Désolé, il y a eu un problème de chargement du fichier demandé.';
		$strings['InvalidAttachmentExtension'] = 'Vous pouvez uniquement uploader des fichiers de type : %s';
		$strings['PasswordControlledExternallyError'] = 'Votre mot de passe est contrôlé par un système externe et ne peut pas être mis à jour ici.';


		// Page Titles
		$strings['CreateReservation'] = 'Créer une Réservation';
		$strings['EditReservation'] = 'Editer une Réservation';
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
		$strings['ManageBlackouts'] = 'Périodes de Mise Hors Service';
		$strings['MyDashboard'] = 'Mon tableau de bord';
		$strings['ServerSettings'] = 'Préférences du Serveur';
		$strings['Dashboard'] = 'Tableau de Bord';
		$strings['Help'] = 'Aide';
		$strings['Administration'] = 'Administration';
		$strings['About'] = 'À propos';
		$strings['Bookings'] = 'Réservations';
		$strings['Schedule'] = 'Planning';
		$strings['Account'] = 'Compte';
		$strings['EditProfile'] = 'Editer Mon Profil';
		$strings['FindAnOpening'] = 'Trouver une invitation';
		$strings['OpenInvitations'] = 'Invitations';
		$strings['ResourceCalendar'] = 'Calendrier des Ressources';
		$strings['Reservation'] = 'Nouvelle Réservation';
		$strings['Install'] = 'Installation';
		$strings['ChangePassword'] = 'Modifier le Mot de Passe';
		$strings['MyAccount'] = 'Mon Compte';
		$strings['Profile'] = 'Profil';
		$strings['ApplicationManagement'] = 'Gestion de l\'Application';
		$strings['ForgotPassword'] = 'Mot de Passe perdu';
		$strings['NotificationPreferences'] = 'Préférences de Messagerie';
		$strings['ManageAnnouncements'] = 'Annonces';
		$strings['Responsibilities'] = 'Responsables';
		$strings['GroupReservations'] = 'Réservations de Groupe';
		$strings['ResourceReservations'] = 'Réservations de Ressource ';
		$strings['Customization'] = 'Personnalisation';
		$strings['Attributes'] = 'Attributs';
		$strings['AccountActivation'] = 'Activation de compte';
		$strings['ScheduleReservations'] = 'Réservations du Planning';
		$strings['Reports'] = 'Rapports';
		$strings['GenerateReport'] = 'Nouveau Rapport';
		$strings['MySavedReports'] = 'Rapports Sauvegardés';
		$strings['CommonReports'] = 'Rapports Standards';
		$strings['ViewDay'] = 'Vue/Jour';
		$strings['Group'] = 'Groupe';
		$strings['ManageConfiguration'] = 'Configuration de l\'Application';
		$strings['LookAndFeel'] = 'Apparence';
		$strings['ManageResourceGroups'] = 'Groupes de la Ressource';
		$strings['ManageResourceTypes'] = 'Types de Ressources';
		$strings['ManageResourceStatus'] = 'États des Ressources';
		$strings['ReservationColors'] = 'Couleurs des Réservations';
		// End Page Titles

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
		$strings['ParticipantDeletedSubject'] = 'Réservation Effacée';
		$strings['InviteeAddedSubject'] = 'Invitation à une Réservation';
		$strings['ResetPasswordRequest'] = 'Demande de Réinitialisation du Mot de Passe';
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
		 * DAY NAMES
		 * All of these arrays MUST start with Sunday as the first element
		 * and go through the seven day week, ending on Saturday
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
		 * MONTH NAMES
		 * All of these arrays MUST start with January as the first element
		 * and go through the twelve months of the year, ending on December
		 ***/
		// The full month name
		$months['full'] = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
		// The three letter month name
		$months['abbr'] = array('Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc');

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
