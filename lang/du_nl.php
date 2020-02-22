<?php
/**
 * Copyright 2011-2020 Nick Korbel
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

class du_nl extends en_gb
{
	public function __construct()
	{
		parent::__construct();
	}

	protected function _LoadStrings()
	{
		$strings = parent::_LoadStrings();

		$strings['FirstName'] = 'Voornaam';
		$strings['LastName'] = 'Achternaam';
		$strings['Timezone'] = 'Tijdzonezone';
		$strings['Edit'] = 'Bewerken';
		$strings['Change'] = 'Wijzig';
		$strings['Rename'] = 'Hernoem';
		$strings['Remove'] = 'Verwijder';
		$strings['Delete'] = 'Delete';
		$strings['Update'] = 'Pas aan';
		$strings['Cancel'] = 'Annuleer';
		$strings['Add'] = 'Voeg toe';
		$strings['Name'] = 'Naam';
		$strings['Yes'] = 'Ja';
		$strings['No'] = 'Nee';
		$strings['FirstNameRequired'] = 'Voornaam is vereist.';
		$strings['LastNameRequired'] = 'Achternaam is vereist.';
		$strings['PwMustMatch'] = 'Wachtwoord bevestiging moet overeenkomen met het wachtwoord.';
		$strings['PwComplexity'] = 'Wachtwoord moet minstens 6 karakters lang zijn en bestaan uit een combinatie van alfanumerische tekens en symbolen';
		$strings['ValidEmailRequired'] = 'Een geldig email adres moet opgegeven worden.';
		$strings['UniqueEmailRequired'] = 'Dit email adres is al geregistreerd.';
		$strings['UniqueUsernameRequired'] = 'Deze gebruikersnaam is al geregistreerd.';
		$strings['UserNameRequired'] = 'Een gebruikersnaam is vereist.';
		$strings['CaptchaMustMatch'] = 'Voer exact de letters in zoals afgebeeld op de figuur.';
		$strings['Today'] = 'Vandaag';
		$strings['Week'] = 'Week';
		$strings['Month'] = 'Maand';
		$strings['BackToCalendar'] = 'Terug naar kalendar';
		$strings['BeginDate'] = 'Begin';
		$strings['EndDate'] = 'Einde';
		$strings['Username'] = 'Gebruikersnaam';
		$strings['Password'] = 'Wachtwoord';
		$strings['PasswordConfirmation'] = 'Bevestig wachtwoord';
		$strings['DefaultPage'] = 'Standaard hoofdpagina';
		$strings['MyCalendar'] = 'Mijn kalender';
		$strings['ScheduleCalendar'] = 'Planning kalender';
		$strings['Registration'] = 'Registratie';
		$strings['NoAnnouncements'] = 'Er zijn geen aankondigingen';
		$strings['Announcements'] = 'Aankondigingen';
		$strings['NoUpcomingReservations'] = 'U hebt geen aankomende reserveringen';
		$strings['UpcomingReservations'] = 'Aankomende reserveringen';
		$strings['ShowHide'] = 'Toon/Verberg';
		$strings['Error'] = 'Fout';
		$strings['ReturnToPreviousPage'] = 'Keer terug naar de pagina die u laatst bezocht';
		$strings['UnknownError'] = 'Onbekende fout';
		$strings['InsufficientPermissionsError'] = 'U hebt onvoldoende rechten tot deze bron';
		$strings['MissingReservationResourceError'] = 'Er werd geen bron geselecteerd';
		$strings['MissingReservationScheduleError'] = 'Er werd geen planning geselecteerd';
		$strings['DoesNotRepeat'] = 'Niet herhalen';
		$strings['Daily'] = 'Dagelijks';
		$strings['Weekly'] = 'Wekelijks';
		$strings['Monthly'] = 'Maandelijks';
		$strings['Yearly'] = 'Jaarlijks';
		$strings['RepeatPrompt'] = 'Herhaal';
		$strings['hours'] = 'uren';
		$strings['days'] = 'dagen';
		$strings['weeks'] = 'weken';
		$strings['months'] = 'maanden';
		$strings['years'] = 'jaren';
		$strings['day'] = 'dag';
		$strings['week'] = 'week';
		$strings['month'] = 'maand';
		$strings['year'] = 'jaar';
		$strings['repeatDayOfMonth'] = 'dag van de maand';
		$strings['repeatDayOfWeek'] = 'dag van de week';
		$strings['RepeatUntilPrompt'] = 'Tot';
		$strings['RepeatEveryPrompt'] = 'Elke';
		$strings['RepeatDaysPrompt'] = 'Op';
		$strings['CreateReservationHeading'] = 'Maak een nieuwe reservering';
		$strings['EditReservationHeading'] = 'Wijzig reservering %s';
		$strings['ViewReservationHeading'] = 'Raadpleeg reservering %s';
		$strings['ReservationErrors'] = 'Wijzig reservering';
		$strings['Create'] = 'Maak aan';
		$strings['ThisInstance'] = 'Enkel deze instantie';
		$strings['AllInstances'] = 'Alle instanties';
		$strings['FutureInstances'] = 'Toekomstige instanties';
		$strings['Print'] = 'Print';
		$strings['ShowHideNavigation'] = 'Toon/Verberg navigatie';
		$strings['ReferenceNumber'] = 'Referentie nummer';
		$strings['Tomorrow'] = 'Morgen';
		$strings['LaterThisWeek'] = 'Later deze week';
		$strings['NextWeek'] = 'Volgende week';
		$strings['SignOut'] = 'Uitloggen';
		$strings['LayoutDescription'] = 'Begint op %s, met %s zichtbare dagen';
		$strings['AllResources'] = 'Alle bronnen';
		$strings['TakeOffline'] = 'Breng offline';
		$strings['BringOnline'] = 'Breng online';
		$strings['AddImage'] = 'Voeg afbeelding toe';
		$strings['NoImage'] = 'Geen afbeelding gekoppeld';
		$strings['Move'] = 'Verplaats';
		$strings['AppearsOn'] = 'Verschijnt op %s';
		$strings['Location'] = 'Locatie';
		$strings['NoLocationLabel'] = '(geen locatie vermeld)';
		$strings['Contact'] = 'Contact';
		$strings['NoContactLabel'] = '(geen contact informatie)';
		$strings['Description'] = 'Beschrijving';
		$strings['NoDescriptionLabel'] = '(geen beschrijving)';
		$strings['Notes'] = 'Notities';
		$strings['NoNotesLabel'] = '(geen notities)';
		$strings['NoTitleLabel'] = '(geen titel)';
		$strings['UsageConfiguration'] = 'Gebruik configuratie';
		$strings['ChangeConfiguration'] = 'Wijzig configuratie';
		$strings['ResourceMinLength'] = 'Een reservering moet minimum %s duren';
		$strings['ResourceMinLengthNone'] = 'Er is geen minimale reserveringsduur';
		$strings['ResourceMaxLength'] = 'Reserveringen kunnen niet langer duren dan %s';
		$strings['ResourceMaxLengthNone'] = 'Er is geen maximale reserveringsduur';
		$strings['ResourceRequiresApproval'] = 'Reserveringen vereisen goedkeuring';
		$strings['ResourceRequiresApprovalNone'] = 'Reserveringen zonder goedkeuring';
		$strings['ResourcePermissionAutoGranted'] = 'Toegang wordt automatisch verleend';
		$strings['ResourcePermissionNotAutoGranted'] = 'Toegang wordt niet automatisch verleend';
		$strings['ResourceMinNotice'] = 'Reserveringen moeten minstens %s op voorhand gemaakt worden';
		$strings['ResourceMinNoticeNone'] = 'Reserveringen kunnen gemaakt worden vanaf huidig tijdstip';
		$strings['ResourceMaxNotice'] = 'Reserveringen kunnen niet later eindigen dan %s van het huidige tijdstip';
		$strings['ResourceMaxNoticeNone'] = 'Reserveringen kunnen onbeperkt in de toekomst eindigen';
		$strings['ResourceAllowMultiDay'] = 'Meerdaagse reserveringen mogelijk';
		$strings['ResourceNotAllowMultiDay'] = 'Meerdaagse reserveringen niet toegelaten';
		$strings['ResourceCapacity'] = 'Deze bron heeft een capaciteit van %s personen';
		$strings['ResourceCapacityNone'] = 'Deze bron heeft ongelimiteerde capaciteit';
		$strings['AddNewResource'] = 'Nieuw bron toevoegen';
		$strings['AddNewUser'] = 'Nieuwe gebruiker toevoegen';
		$strings['AddUser'] = 'Gebruiker toevoegen';
		$strings['Schedule'] = 'Planning';
		$strings['AddResource'] = 'Bron toevoegen';
		$strings['Capacity'] = 'Capaciteit';
		$strings['Access'] = 'Toegang';
		$strings['Duration'] = 'Duur';
		$strings['Active'] = 'Actief';
		$strings['Inactive'] = 'Inactief';
		$strings['ResetPassword'] = 'Reset wachtwoord';
		$strings['LastLogin'] = 'Laatst ingelogd';
		$strings['Search'] = 'Zoek';
		$strings['ResourcePermissions'] = 'Toegangsrechten bron';
		$strings['Reservations'] = 'Reserveringen';
		$strings['Groups'] = 'Groepen';
		$strings['ResetPassword'] = 'Reset wachtwoord';
		$strings['AllUsers'] = 'Alle gebruikers';
		$strings['AllGroups'] = 'Alle groepen';
		$strings['AllSchedules'] = 'Alle planningen';
		$strings['UsernameOrEmail'] = 'Gebruikersnaam of email';
		$strings['Members'] = 'Leden';
		$strings['QuickSlotCreation'] = 'Voeg slots toe elke %s minuten tussen %s en %s';
		$strings['ApplyUpdatesTo'] = 'Pas updates toe';
		$strings['CancelParticipation'] = 'Annuleer deelname';
		$strings['Attending'] = 'Wachtend...';
		$strings['QuotaConfiguration'] = 'Op %s voor %s gebruikers in %s zijn beperkt tot %s %s per %s';
		$strings['reservations'] = 'reserveringen';
		$strings['ChangeCalendar'] = 'Wijzig kalender';
		$strings['AddQuota'] = 'Voeg kwota toe';
		$strings['FindUser'] = 'Zoek gebruiker';
		$strings['Created'] = 'Aangemaakt';
		$strings['LastModified'] = 'Laatste wijziging';
		$strings['GroupName'] = 'Groep naam';
		$strings['GroupMembers'] = 'Groep leden';
		$strings['GroupRoles'] = 'Groep rollen';
		$strings['GroupAdmin'] = 'Groep beheerder';
		$strings['Actions'] = 'Acties';
		$strings['CurrentPassword'] = 'Huidig wachtwoord';
		$strings['NewPassword'] = 'Nieuw wachtwoord';
		$strings['InvalidPassword'] = 'Huidig wachtwoord is fout';
		$strings['PasswordChangedSuccessfully'] = 'Uw wachtwoord is succesvol aangepast';
		$strings['SignedInAs'] = 'Ingelogd als';
		$strings['NotSignedIn'] = 'U bent niet ingelogd';
		$strings['ReservationTitle'] = 'Reservering titel';
		$strings['ReservationDescription'] = 'Beschrijving van de reservering';
		$strings['ResourceList'] = 'Te reserveren bronnen';
		$strings['Accessories'] = 'Benodigdheden';
		$strings['Add'] = 'Voeg toe';
		$strings['ParticipantList'] = 'Deelnemers';
		$strings['InvitationList'] = 'Uitgenodigden';
		$strings['AccessoryName'] = 'Naam benodigdheden';
		$strings['QuantityAvailable'] = 'Beschikbare hoeveelheid';
		$strings['Resources'] = 'Bronnen';
		$strings['Participants'] = 'Deelnemers';
		$strings['User'] = 'Gebruiker';
		$strings['Resource'] = 'Bron';
		$strings['Status'] = 'Status';
		$strings['Approve'] = 'Bevestig';
		$strings['Page'] = 'Pagina';
		$strings['Rows'] = 'Rijen';
		$strings['Unlimited'] = 'Onbeperkt';
		$strings['Email'] = 'Email';
		$strings['EmailAddress'] = 'Email adres';
		$strings['Phone'] = 'Telefoon';
		$strings['Organization'] = 'Organisatie';
		$strings['Position'] = 'Functie';
		$strings['Language'] = 'Taal';
		$strings['Permissions'] = 'Toegangsrechten';
		$strings['Reset'] = 'Reset';
		$strings['FindGroup'] = 'Groep zoeken';
		$strings['Manage'] = 'Beheer';
		$strings['None'] = 'Geen';
		$strings['AddToOutlook'] = 'Voeg toe in Outlook';
		$strings['Done'] = 'Klaar';
		$strings['RememberMe'] = 'Herinner me';
		$strings['FirstTimeUser?'] = 'Nieuwe gebruiker?';
		$strings['CreateAnAccount'] = 'Een account aanmaken';
		$strings['ViewSchedule'] = 'Bekijk planning';
		$strings['ForgotMyPassword'] = 'Wachtwoord vergeten';
		$strings['YouWillBeEmailedANewPassword'] = 'U zult via een email een willekeurig gegenereerd wachtwoord toegestuurd krijgen';
		$strings['Close'] = 'Sluit';
		$strings['ExportToCSV'] = 'Exporteer naar CSV';
		$strings['OK'] = 'OK';
		$strings['Working'] = 'Bezig...';
		$strings['Login'] = 'Login';
		$strings['AdditionalInformation'] = 'Bijkomende informatie';
		$strings['AllFieldsAreRequired'] = 'alle velden zijn verplicht';
		$strings['Optional'] = 'optioneel';
		$strings['YourProfileWasUpdated'] = 'Uw profiel is gewijzigd';
		$strings['YourSettingsWereUpdated'] = 'Uw instellingen zijn gewijzigd';
		$strings['Register'] = 'Registreer';
		$strings['SecurityCode'] = 'Veiligheidscode';
		$strings['ReservationCreatedPreference'] = 'Wanneer ik of iemand in mijn naam een reservering maakt';
		$strings['ReservationUpdatedPreference'] = 'Wanneer ik of iemand anders een reservering van me wijzigt';
		$strings['ReservationApprovalPreference'] = 'Wanneer mijn reserveringen uit de wachtrij zijn goedgekeurd';
		$strings['PreferenceSendEmail'] = 'Stuur me een email';
		$strings['PreferenceNoEmail'] = 'Geen melding sturen';
		$strings['ReservationCreated'] = 'Uw reservering is succesvol aangemaakt!';
		$strings['ReservationUpdated'] = 'Uw reservering is succesvol gewijzigd!';
		$strings['ReservationRemoved'] = 'Uw reservering is verwijderd';
		$strings['YourReferenceNumber'] = 'Uw referentie nummer is %s';
		$strings['UpdatingReservation'] = 'Wijzigen reservering bezig';
		$strings['ChangeUser'] = 'Wijzig gebruiker';
		$strings['MoreResources'] = 'Extra bronnen';
		$strings['ReservationLength'] = 'Duur reservering';
		$strings['ParticipantList'] = 'Deelnemerslijst';
		$strings['AddParticipants'] = 'Voeg deelnemers toe';
		$strings['InviteOthers'] = 'Nodig anderen uit';
		$strings['AddResources'] = 'Voeg bron toe';
		$strings['AddAccessories'] = 'Voeg benodigdheden toe';
		$strings['Accessory'] = 'Benodigdheden';
		$strings['QuantityRequested'] = 'Hoeveelheid vereist';
		$strings['CreatingReservation'] = 'Bezig met aanmaken van de reservering';
		$strings['UpdatingReservation'] = 'Bezig met wijzigen van de reservering';
		$strings['DeleteWarning'] = 'Deze actie is permanent en niet terug te draaien!';
		$strings['DeleteAccessoryWarning'] = 'Deze benodigdheden verwijderen betekent dat deze uit alle reserveringen verwijderd zal worden.';
		$strings['AddAccessory'] = 'Voeg benodigdheden toe';
		$strings['AddBlackout'] = 'Voeg geblokkeerde periode toe';
		$strings['AllResourcesOn'] = 'Alle bronnen op';
		$strings['Reason'] = 'Oorzaak';
		$strings['BlackoutShowMe'] = 'Toon de conflicterende reserveringen';
		$strings['BlackoutDeleteConflicts'] = 'Verwijder conflicterende reserveringen';
		$strings['Filter'] = 'Filter';
		$strings['Between'] = 'Tussen';
		$strings['CreatedBy'] = 'Aangemaakt door';
		$strings['BlackoutCreated'] = 'Geblokkeerde tijd aangemaakt!';
		$strings['BlackoutNotCreated'] = 'Deze geblokkeerde periode kan niet aangemaakt worden';
		$strings['BlackoutConflicts'] = 'Er zijn conflicterende geblokkeerde periodes';
		$strings['ReservationConflicts'] = 'Er zijn conflicterende reservering periodes';
		$strings['UsersInGroup'] = 'Gebruikers in deze groep';
		$strings['Browse'] = 'Browse';
		$strings['DeleteGroupWarning'] = 'Deze groep verwijderen resulteert in het verwijderen van alle gekoppelde toegangsrechten op bronnen. Gebruikers in deze groep kunnen derhalve toegangsrechten verliezen.';
		$strings['WhatRolesApplyToThisGroup'] = 'Welke rollen behoren tot deze groep?';
		$strings['WhoCanManageThisGroup'] = 'Wie beheert deze groep?';
		$strings['AddGroup'] = 'Voeg groep toe';
		$strings['AllQuotas'] = 'Alle Kwotas';
		$strings['QuotaReminder'] = 'Opgelet: Kwotas worden toegepast op basis van de tijdzone van de planning.';
		$strings['AllReservations'] = 'Alle reserveringen';
		$strings['PendingReservations'] = 'Openstaande reserveringen';
		$strings['Approving'] = 'Te bevestigen';
		$strings['MoveToSchedule'] = 'Verplaats naar planning';
		$strings['DeleteResourceWarning'] = 'Deze bron verwijderen resulteert in het verwijderen van alle gelinkte informatie';
		$strings['DeleteResourceWarningReservations'] = 'alle gekoppelde afgelopen, huidige en toekomstige reserveringen';
		$strings['DeleteResourceWarningPermissions'] = 'alle gekoppelde toegangsrechten';
		$strings['DeleteResourceWarningReassign'] = 'Wijs alles opnieuw toe wat niet verwijderd mag worden voordat u verder gaat.';
		$strings['ScheduleLayout'] = 'Layout (all times %s)';
		$strings['ReservableTimeSlots'] = 'Reserveerbare tijdsslots';
		$strings['BlockedTimeSlots'] = 'Geblokkeerde tijdsslots';
		$strings['ThisIsTheDefaultSchedule'] = 'Dit is de standaard planning';
		$strings['DefaultScheduleCannotBeBroughtDown'] = 'De standaard planning kan niet omlaag gebracht worden';
		$strings['MakeDefault'] = 'Maak standaard';
		$strings['BringDown'] = 'Omlaag';
		$strings['ChangeLayout'] = 'Wijzig layout';
		$strings['AddSchedule'] = 'Voeg een planning toe';
		$strings['StartsOn'] = 'Begint op';
		$strings['NumberOfDaysVisible'] = 'Aantal zichtbare dagen';
		$strings['UseSameLayoutAs'] = 'Gebruik dezelfde layout als';
		$strings['Format'] = 'Formaat';
		$strings['OptionalLabel'] = 'Optionele label';
		$strings['LayoutInstructions'] = 'Voeg een slot toe per lijn. De volledige 24 uren van een dag moeten worden voorzien beginnend en eindigend om 12:00 AM.';
		$strings['AddUser'] = 'Gebruiker toevoegen';
		$strings['UserPermissionInfo'] = 'De concrete toegang tot de bronnen hangt af van uw rol, groepsrechten en externe toegangsrechten.';
		$strings['DeleteUserWarning'] = 'Wanneer u deze gebruiker verwijdert, worden alle reserveringen uit het verleden en toekomst gewist.';
		$strings['AddAnnouncement'] = 'Voeg een aankondiging toe';
		$strings['Announcement'] = 'Aankondiging';
		$strings['Priority'] = 'Prioriteit';
		$strings['Reservable'] = 'Te reserveren';
		$strings['Unreservable'] = 'Niet te reserveren';
		$strings['Reserved'] = 'Gereserveerd';
		$strings['MyReservation'] = 'Mijn reservering';
		$strings['Pending'] = 'In wachtlijst';
		$strings['Past'] = 'Verleden';
		$strings['Restricted'] = 'Restrictie';
		$strings['ViewAll'] = 'Bekijk Alles';
		$strings['MoveResourcesAndReservations'] = 'Verplaats bronnen en reserveringen naar';
		$strings['TurnOffSubscription'] = 'Meld abonnement van kalender af';
		$strings['TurnOnSubscription'] = 'Sta abonnement op deze kalender toe';
		$strings['SubscribeToCalendar'] = 'Abonneer op deze kalender';
		$strings['SubscriptionsAreDisabled'] = 'De administrator heeft het abonneren op deze kalender geblokkeerd';
		$strings['NoResourceAdministratorLabel'] = '(Geen Bronnen Administrator)';
		$strings['WhoCanManageThisResource'] = 'Wie kan deze bron beheren?';
		$strings['ResourceAdministrator'] = 'Bron Administrator';
		$strings['Private'] = 'Privé';
		$strings['Accept'] = 'Accepteer';
		$strings['Decline'] = 'Weiger';
		$strings['ShowFullWeek'] = 'Laat hele week zien';
		$strings['CustomAttributes'] = 'Aangepaste Attributen';
		$strings['AddAttribute'] = 'Voeg een attribuut toe';
		$strings['EditAttribute'] = 'Update een attribuut';
		$strings['DisplayLabel'] = 'Laat Label zien';
		$strings['Type'] = 'Type';
		$strings['Required'] = 'Verplicht';
		$strings['ValidationExpression'] = 'Validation Expression';
		$strings['PossibleValues'] = 'Mogelijke Possible Waarden';
		$strings['SingleLineTextbox'] = 'Tekstbox met elkele regel';
		$strings['MultiLineTextbox'] = 'Tekstbox met meerdere regels';
		$strings['Checkbox'] = 'Checkbox';
		$strings['SelectList'] = 'Selectie Lijst';
		$strings['CommaSeparated'] = 'komma gescheiden';
		$strings['Category'] = 'Categorie';
		$strings['CategoryReservation'] = 'Reservatie';
		$strings['CategoryGroup'] = 'Groep';
		$strings['SortOrder'] = 'Sorteer Volgorde';
		$strings['Title'] = 'Titel';
		$strings['AdditionalAttributes'] = 'Extra Attributen';
		$strings['True'] = 'Waar';
		$strings['False'] = 'Onwaar';
		$strings['ForgotPasswordEmailSent'] = 'Een email is naar uw account gestuurd met de informatie om uw wachtwoord te resetten';
		$strings['ActivationEmailSent'] = 'Je ontvangt binnekort een email voor activatie.';
		$strings['AccountActivationError'] = 'Sorry, we hebben je account niet kunnen activeren.';
		$strings['Attachments'] = 'Bijlage';
		$strings['AttachFile'] = 'Voeg bestand toe';
		$strings['Maximum'] = 'max';
		$strings['NoScheduleAdministratorLabel'] = 'Geen Plannings Administrator';
		$strings['ScheduleAdministrator'] = 'Plannings Administrator';
		$strings['Total'] = 'Totaal';
		$strings['QuantityReserved'] = 'Aantal Gereserveerd';
		$strings['AllAccessories'] = 'Alle Benodigdheden';
		$strings['GetReport'] = 'Open Rapportage';
		$strings['NoResultsFound'] = 'Geen overeenkomende resultaten gevonden';
		$strings['SaveThisReport'] = 'Sla deze rapportage op';
		$strings['ReportSaved'] = 'Rapportage Opgeslagen!';
		$strings['EmailReport'] = 'Email Rapportage';
		$strings['ReportSent'] = 'Rapportage Verzonden!';
		$strings['RunReport'] = 'Draai Rapportage';
		$strings['NoSavedReports'] = 'Je hebt geen opgeslagen Rapportages.';
		$strings['CurrentWeek'] = 'Huidige Week';
		$strings['CurrentMonth'] = 'Huidige Maand';
		$strings['AllTime'] = 'Alle Tijd';
		$strings['FilterBy'] = 'Gefilter Op';
		$strings['Select'] = 'Selecteer';
		$strings['List'] = 'Lijst';
		$strings['TotalTime'] = 'Totale Tijd';
		$strings['Count'] = 'Aantal';
		$strings['Usage'] = 'Gebruik';
		$strings['AggregateBy'] = 'Gesorteerd op';
		$strings['Range'] = 'Breik';
		$strings['Choose'] = 'Kies';
		$strings['All'] = 'Alle';
		$strings['ViewAsChart'] = 'Bekijk als Grafiek';
		$strings['ReservedResources'] = 'Gereserveerde Bronnen';
		$strings['ReservedAccessories'] = 'Gereserveerde Benodigdheden';
		$strings['ResourceUsageTimeBooked'] = 'Bronnen gebruik - Tijd Geboekt';
		$strings['ResourceUsageReservationCount'] = 'Bronnen gebruik - Gereserveerd Aantal';
		$strings['Top20UsersTimeBooked'] = 'Top 20 Gebruikers - Tijd Geboekt';
		$strings['Top20UsersReservationCount'] = 'Top 20 Gebruikers - Gereserveerd Aantal';
		$strings['ConfigurationUpdated'] = 'Het configuratie bestand is geupdate';
		$strings['ConfigurationUiNotEnabled'] = 'Deze pagina kan niet worden geopent omdat $conf[\'settings\'][\'pages\'][\'enable.configuration\'] niet is geactiveerd of weg is.';
		$strings['ConfigurationFileNotWritable'] = 'Het configuratie bestand is niet schrijfbaar. Controleer de permissies en probeer opnieuw.';
		$strings['ConfigurationUpdateHelp'] = 'Raadpleeg de sectie Configuratie van het <a target=_blank href=%s>Help Bestand</a> voor documentatie van deze instellingen.';
		$strings['GeneralConfigSettings'] = 'instellingen';
		$strings['UseSameLayoutForAllDays'] = 'Gebruik de zelfde layout voor alle dagen';
		$strings['LayoutVariesByDay'] = 'Layout varieert per dag';
		$strings['ManageReminders'] = 'Herinneringen';
		$strings['ReminderUser'] = 'Gebuikers ID';
		$strings['ReminderMessage'] = 'Bericht';
		$strings['ReminderAddress'] = 'Adres';
		$strings['ReminderSendtime'] = 'Tijd om te versturen';
		$strings['ReminderRefNumber'] = 'Reserverings Referentie Nummer';
		$strings['ReminderSendtimeDate'] = 'Datum van Herinnering';
		$strings['ReminderSendtimeTime'] = 'Tijd van Herinnering (HH:MM)';
		$strings['ReminderSendtimeAMPM'] = 'AM / PM';
		$strings['AddReminder'] = 'Voeg Herinnering Toe';
		$strings['DeleteReminderWarning'] = 'Weet je dit zeker?';
		$strings['NoReminders'] = 'Je hebt geen toekomstige herinneringen.';
		$strings['Reminders'] = 'Herinneringen';
		$strings['SendReminder'] = 'Verstuur Herinnering';
		$strings['minutes'] = 'minuten';
		$strings['hours'] = 'uren';
		$strings['days'] = 'dagen';
		$strings['ReminderBeforeStart'] = 'voor de starttijd';
		$strings['ReminderBeforeEnd'] = 'voor de eindtijd';
		$strings['Logo'] = 'Logo';
		$strings['CssFile'] = 'CSS Bestand';
		$strings['ThemeUploadSuccess'] = 'Je veranderingen zijn opgeslagen. Your changes have been saved. Vernieuw de pagina om wijzigingen door te voeren.';
		$strings['MakeDefaultSchedule'] = 'Maak dit mijn standaard planning';
		$strings['DefaultScheduleSet'] = 'Dit is nu jouw standaard planning';
		$strings['FlipSchedule'] = 'Flip de plannings layout';
		$strings['Next'] = 'Volgende';
		$strings['Success'] = 'Success';
		$strings['Participant'] = 'Deelnemer';
		$strings['ResourceFilter'] = 'Bron Filter';
		$strings['ResourceGroups'] = 'Bron Groepen';
		$strings['AddNewGroup'] = 'Voeg een nieuwe groep toe';
		$strings['Quit'] = 'Quit';
		$strings['AddGroup'] = 'Voeg Groep Toe';
		$strings['StandardScheduleDisplay'] = 'Gebruik de standaard plannings weergaven';
		$strings['TallScheduleDisplay'] = 'Gebruik lange plannings weergaven';
		$strings['WideScheduleDisplay'] = 'Gebruik brede plannings weergaven';
		$strings['CondensedWeekScheduleDisplay'] = 'Gebruik geconcentreerde week plannings weergaven';
		$strings['ResourceGroupHelp1'] = 'Slepen naar Bron groepen om te reorganiseren.';
		$strings['ResourceGroupHelp2'] = 'Klik rechts op een bron groepsnaam voor extra acties.';
		$strings['ResourceGroupHelp3'] = 'Sleep naar Bron om toe te voegen aan de groepen.';
		$strings['ResourceGroupWarning'] = 'Als je bron groepen gebruikt zal elke bron toegewezen moeten worden aan minstens een groep. Bronnen die niet zijn toegewezen kunnen niet gereserveerd worden.';
		$strings['ResourceType'] = 'Bron Type';
		$strings['AppliesTo'] = 'Toepassen Pp';
		$strings['UniquePerInstance'] = 'Unieke Per Instantie';
		$strings['AddResourceType'] = 'Voeg Bron Type Toe';
		$strings['NoResourceTypeLabel'] = '(geen bron type geselecteerd)';
		$strings['ClearFilter'] = 'Reset Filter';
		$strings['MinimumCapacity'] = 'Minimale Capaciteit';
		$strings['Color'] = 'Kleur';
		$strings['Available'] = 'Beschikbaar';
		$strings['Unavailable'] = 'Niet Beschikbaar';
		$strings['Hidden'] = 'Verborgen';
		$strings['ResourceStatus'] = 'Bron Status';
		$strings['CurrentStatus'] = 'Huidige Status';
		$strings['AllReservationResources'] = 'Alle Reservatie Bronnen';
		$strings['File'] = 'Bestand';
		$strings['BulkResourceUpdate'] = 'Bulk Bron update';
		$strings['Unchanged'] = 'Ongewijzigd';
		$strings['Common'] = 'Algemeen';
		$strings['AdvancedFilter'] = 'Geavanceerde Filter';
		// End Strings

		// Install
		$strings['InstallApplication'] = 'Installeer Booked Scheduler (MySQL only)';
		$strings['IncorrectInstallPassword'] = 'Sorry, dat wachtwoord is onjuist.';
		$strings['SetInstallPassword'] = 'Je moet een wachtwoord instellen voordat de installatie kan worden uitgevoerd.';
		$strings['InstallPasswordInstructions'] = 'In %s wijzig %s naar een moeilijk wachtwoord dat moeilijk te raden is en ga dan terug naar deze pagina.<br/>Je kan %s gebruiken';
		$strings['NoUpgradeNeeded'] = 'Er is geen upgrade nodig. De installatie zal alle bestaande data verwijderen en zal een nieuwe kopie gemaakt worden van Booked Scheduler!';
		$strings['ProvideInstallPassword'] = 'Geef het wachtwoord van tijdens de installatie op.';
		$strings['InstallPasswordLocation'] = 'Dit kan worden gevonden bij %s in %s.';
		$strings['VerifyInstallSettings'] = 'Controleer de volgende standaardinstellingen voordat je verder gaat. Of je kan ze veranderen in %s.';
		$strings['DatabaseName'] = 'Database Naam';
		$strings['DatabaseUser'] = 'Database Gebruiker';
		$strings['DatabaseHost'] = 'Database Host';
		$strings['DatabaseCredentials'] = 'Je moet een account van MySQL gebruiken die rechten heeft om databases te maken. Als je die niet weet, neem dan contact op met je database administrator. In veel gevallen zal de root account werken.';
		$strings['MySQLUser'] = 'MySQL Account';
		$strings['InstallOptionsWarning'] = 'De volgende opties zullen waarschijnlijk niet werken in een gehoste omgeving. Als je in een gehoste omgeving installeerd, gebruik dan de MySQL wizard om deze stappen uit te voeren.';
		$strings['CreateDatabase'] = 'Maak de database';
		$strings['CreateDatabaseUser'] = 'Maak de database account';
		$strings['PopulateExampleData'] = 'Import voorbeeld data. Maak administrator account: admin/password en gebruiker account: user/password';
		$strings['DataWipeWarning'] = 'Let op: Dit zal alle bestaande data verwijderen';
		$strings['RunInstallation'] = 'Start Installatie';
		$strings['UpgradeNotice'] = 'Je zal nu upgraden van versie <b>%s</b> naar versie <b>%s</b>';
		$strings['RunUpgrade'] = 'Start Upgrade';
		$strings['Executing'] = 'Uitvoeren';
		$strings['StatementFailed'] = 'Mislukt. Details:';
		$strings['SQLStatement'] = 'SQL Statement:';
		$strings['ErrorCode'] = 'Error Code:';
		$strings['ErrorText'] = 'Error Tekst:';
		$strings['InstallationSuccess'] = 'Installatie succesvol afgerond!';
		$strings['RegisterAdminUser'] = 'Registreer je administrator account. Dit is noodzakelijk als je de voorbeeld data niet geimporteerd hebt. Zorg ervoor dat $conf[\'settings\'][\'allow.self.registration\'] = \'true\' in je %s bestand.';
		$strings['LoginWithSampleAccounts'] = 'Als je de voorbeeld data geimporteerd hebt, kan je inloggen met admin/password voor de administrator account of user/password voor de standaard gebruiker.';
		$strings['InstalledVersion'] = 'Je zit nu op versie %s van Booked Scheduler';
		$strings['InstallUpgradeConfig'] = 'Het is aanbevolen om je config bestand to upgraden';
		$strings['InstallationFailure'] = 'Er waren problemen met de installatie. Graag deze corrigeren en probeer de installatie opnieuw.';
		$strings['ConfigureApplication'] = 'Configureer Booked Scheduler';
		$strings['ConfigUpdateSuccess'] = 'Je configuratie bestand is nu bijgewerkt!';
		$strings['ConfigUpdateFailure'] = 'We konden het configuratie bestand niet automatisch updaten. Overschrijf de inhoud van config.php met het volgende:';
		$strings['SelectUser'] = 'Select User';

		// Errors
		$strings['LoginError'] = 'Ongeldige gebruikersnaam of wachtwoord opgegeven';
		$strings['ReservationFailed'] = 'Uw reservering kan niet worden uitgevoerd';
		$strings['MinNoticeError'] = 'Deze reservering moet op voorhand worden aangevraagd. De vroegste reserveringsdatum is %s.';
		$strings['MaxNoticeError'] = 'Deze reservering kan niet zover in de toekomst worden gemaakt. De uiterste reserveringsdatum in de toekomst is %s.';
		$strings['MinDurationError'] = 'Deze reservering moet een minimum duur hebben van %s.';
		$strings['MaxDurationError'] = 'Deze reservering kan niet langer duren dan %s.';
		$strings['ConflictingAccessoryDates'] = 'Er zijn onvoldoende benodigheden voorradig:';
		$strings['NoResourcePermission'] = 'U hebt onvoldoende rechten om toegang tot een of meerdere van de bronnen te verkrijgen';
		$strings['ConflictingReservationDates'] = 'Er zijn conflicterende reserveringen op volgende data:';
		$strings['StartDateBeforeEndDateRule'] = 'De startdatum moet voor de einddatum liggen';
		$strings['StartIsInPast'] = 'Een startdatum in het verleden is ongeldig';
		$strings['EmailDisabled'] = 'De beheerder zette de optie email meldingen af';
		$strings['ValidLayoutRequired'] = 'Slots moeten voor de volledige 24 uren van de dag voorzien worden, beginnend en eindigend om 12:00 AM.';
		$strings['CustomAttributeErrors'] = 'Er zijn problemen met de extra attributen die je ingevuld hebt:';
		$strings['CustomAttributeRequired'] = '%s is een verplicht veld.';
		$strings['CustomAttributeInvalid'] = 'De ingevulde waarde van %s is incorrect.';
		$strings['AttachmentLoadingError'] = 'Sorry, er was a probleem om het opgevraagde bestand te laden.';
		$strings['InvalidAttachmentExtension'] = 'Je kan alleen bestanden uploaden met het extentietype: %s';
		$strings['InvalidStartSlot'] = 'De gevraagde startdatum en tijd is ongeldig.';
		$strings['InvalidEndSlot'] = 'De gevraagde einddatum en tijd is ongeldig.';
		$strings['MaxParticipantsError'] = '%s ondersteunt slechts %s deelnemers.';
		$strings['ReservationCriticalError'] = 'Er was een kritieke fout bij het opslaan van je reservering. Als dit zich herhaalt, neem dan contact op met je systeembeheerder.';
		$strings['InvalidStartReminderTime'] = 'De starttijd van de herrinnering is ongeldig.';
		$strings['InvalidEndReminderTime'] = 'De eindtijd van de herrinnering is ongeldig.';
		$strings['QuotaExceeded'] = 'Kwota limiet overschreden.';
		$strings['MultiDayRule'] = '%s staat reserveringen over meerdere dagen niet toe.';
		$strings['InvalidReservationData'] = 'Er was een probleem met je reserverings aanvraag.';
		$strings['PasswordError'] = 'Wachtwoord moet minsterns %s letters en minstens %s nummers.';
		$strings['PasswordErrorRequirements'] = 'Wachtwoord moet een combinatie van minstens %s hoofdletters en kleine letters en %s nummers.';
		$strings['NoReservationAccess'] = 'Je hebt geen rechten om deze reservatie te wijzigen.';

		// Page Titles
		$strings['CreateReservation'] = 'Maak een reservering';
		$strings['EditReservation'] = 'Wijzig reservering';
		$strings['LogIn'] = 'Inloggen';
		$strings['ManageReservations'] = 'Reserveringen';
		$strings['AwaitingActivation'] = 'Wachtend op activatie';
		$strings['PendingApproval'] = 'Wachtend op goedkeuring';
		$strings['ManageSchedules'] = 'Planningen';
		$strings['ManageResources'] = 'Bronnen';
		$strings['ManageAccessories'] = 'Benodigdheden';
		$strings['ManageUsers'] = 'Gebruikers';
		$strings['ManageGroups'] = 'Groepen';
		$strings['ManageQuotas'] = 'Kwotas';
		$strings['ManageBlackouts'] = 'Geblokkeerde periodes';
		$strings['MyDashboard'] = 'Mijn Dashboard';
		$strings['ServerSettings'] = 'Server instellingen';
		$strings['Dashboard'] = 'Dashboard';
		$strings['Help'] = 'Help';
		$strings['Bookings'] = 'Boekingen';
		$strings['Schedule'] = 'Planning';
		$strings['Reservations'] = 'Reserveringen';
		$strings['Account'] = 'Account';
		$strings['EditProfile'] = 'Wijzig mijn profiel';
		$strings['FindAnOpening'] = 'Een mogelijkheid zoeken';
		$strings['OpenInvitations'] = 'Open uitnodigingen';
		$strings['MyCalendar'] = 'Mijn kalender';
		$strings['ResourceCalendar'] = 'Bron kalender';
		$strings['Reservation'] = 'Nieuwe Reservatie';
		$strings['Install'] = 'Installatie';
		$strings['ChangePassword'] = 'Wijzig wachtwoord';
		$strings['MyAccount'] = 'Mijn account';
		$strings['Profile'] = 'Profiel';
		$strings['ApplicationManagement'] = 'Applicatie beheer';
		$strings['ForgotPassword'] = 'Wachtwoord vergeten';
		$strings['NotificationPreferences'] = 'Melding voorkeuren';
		$strings['ManageAnnouncements'] = 'Aankondigingen';
		$strings['Responsibilities'] = 'Responsibilities';
		$strings['GroupReservations'] = 'Groep Reservaties';
		$strings['ResourceReservations'] = 'Bron Reservaties';
		$strings['Customization'] = 'Customization';
		$strings['Attributes'] = 'Attributen';
		$strings['AccountActivation'] = 'Account Activatie';
		$strings['ScheduleReservations'] = 'Planning Reservaties';
		$strings['Reports'] = 'Rapporten';
		$strings['GenerateReport'] = 'Maak Nieuw Raport';
		$strings['MySavedReports'] = 'Mijn Opgeslagen Rapporten';
		$strings['CommonReports'] = 'Algemene Rapporten';
		$strings['ViewDay'] = 'Belijk Dag';
		$strings['Group'] = 'Groep';
		$strings['ManageConfiguration'] = 'Applicatie Configuratie';
		$strings['LookAndFeel'] = 'Vormgeving';
		$strings['ManageResourceGroups'] = 'Bron Groepen';
		$strings['ManageResourceTypes'] = 'Bron Types';
		$strings['ManageResourceStatus'] = 'Bron Statussen';
		//

		// Day representations
		$strings['DaySundaySingle'] = 'Z';
		$strings['DayMondaySingle'] = 'M';
		$strings['DayTuesdaySingle'] = 'D';
		$strings['DayWednesdaySingle'] = 'W';
		$strings['DayThursdaySingle'] = 'D';
		$strings['DayFridaySingle'] = 'V';
		$strings['DaySaturdaySingle'] = 'Z';

		$strings['DaySundayAbbr'] = 'Zon';
		$strings['DayMondayAbbr'] = 'Maa';
		$strings['DayTuesdayAbbr'] = 'Din';
		$strings['DayWednesdayAbbr'] = 'Woe';
		$strings['DayThursdayAbbr'] = 'Don';
		$strings['DayFridayAbbr'] = 'Vri';
		$strings['DaySaturdayAbbr'] = 'Zat';

		// Email Subjects
		$strings['ReservationApprovedSubject'] = 'Uw reservering is goedgekeurd';
		$strings['ReservationCreatedSubject'] = 'Uw reservering is aangemaakt';
		$strings['ReservationUpdatedSubject'] = 'Uw reservering is aangepast';
		$strings['ReservationCreatedAdminSubject'] = 'Melding: Een reservering is aangemaakt';
		$strings['ReservationUpdatedAdminSubject'] = 'Melding: Een reservering is aangepast';
		$strings['ParticipantAddedSubject'] = 'Melding: deelname aan een reservering';
		$strings['InviteeAddedSubject'] = 'Uitnodiging reservering';
		$strings['ResetPassword'] = 'Verzoek om wachtwoord te resetten';
		$strings['ForgotPasswordEmailSent'] = 'Een email is naar uw account gestuurd met de informatie om uw wachtwoord te resetten';
		$strings['ActivateYourAccount'] = 'Activeer Je Account';
		$strings['ReportSubject'] = 'Je Opgevraagde Rapport (%s)';
		$strings['ReservationStartingSoonSubject'] = 'Reservering voor %s start binnenkort';
		$strings['ReservationEndingSoonSubject'] = 'Reservering voor %s eindigd binnekort';
		$strings['UserAdded'] = 'Een nieuwe gebruiker is toegevoegd.';
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
		$days['full'] = array('Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag');
		// The three letter abbreviation
		$days['abbr'] = array('Zon', 'Maa', 'Din', 'Woe', 'Don', 'Vri', 'Zat');
		// The two letter abbreviation
		$days['two'] = array('Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za');
		// The one letter abbreviation
		$days['letter'] = array('Z', 'M', 'D', 'W', 'D', 'V', 'Z');

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
		$months['full'] = array('Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December');
		// The three letter month name
		$months['abbr'] = array('Jan', 'Feb', 'Mrt', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec');

		$this->Months = $months;
	}

	protected function _LoadLetters()
	{
		$this->Letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	}

	protected function _GetHtmlLangCode()
	{
		return 'du_nl';
	}
}