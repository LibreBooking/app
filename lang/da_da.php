<?php
/**
Copyright 2011-2019 Nick Korbel, Boris Vatin

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
require_once('en_gb.php');

class da_da extends en_gb
{
    public function __construct()
    {
        parent::__construct();
    }

	/**
	 * @return array
	 */
    protected function _LoadStrings()
    {
        $strings = parent::_LoadStrings();

        $strings['FirstName'] = 'Fornavn';
        $strings['LastName'] = 'Efternavn';
        $strings['Timezone'] = 'Tidzone';
        $strings['Edit'] = 'Rediger';
        $strings['Change'] = 'Skift';
        $strings['Rename'] = 'Omdøb';
        $strings['Remove'] = 'Fjern';
        $strings['Delete'] = 'Slet';
        $strings['Update'] = 'Updater';
        $strings['Cancel'] = 'Afbryd';
        $strings['Add'] = 'Tilføj';
        $strings['Name'] = 'Navn';
        $strings['Yes'] = 'Ja';
        $strings['No'] = 'Nej';
        $strings['FirstNameRequired'] = 'Fornavn kræves.';
        $strings['LastNameRequired'] = 'Efternavn kræves.';
        $strings['PwMustMatch'] = 'Adgangskode skal matche valgte Adgangskode.';
        $strings['PwComplexity'] = 'Adgangskoden skal være mindst 6 tegn med en kombination af bogstaver, tal og symboler.';
        $strings['ValidEmailRequired'] = 'En gyldig E-mail kræves.';
        $strings['UniqueEmailRequired'] = 'Denne e-mail-adresse er allerede registreret.';
        $strings['UniqueUsernameRequired'] = 'Brugernavn findes allerede.';
        $strings['UserNameRequired'] = 'Brugernavn kræves.';
        $strings['CaptchaMustMatch'] = 'Indtast tegnene fra Captcha nøjagtigt som vist.';
        $strings['Today'] = 'Idag';
        $strings['Week'] = 'Uge';
        $strings['Month'] = 'måned';
        $strings['BackToCalendar'] = 'Tillbage til kalenderen';
        $strings['BeginDate'] = 'Start';
        $strings['EndDate'] = 'Slut';
        $strings['Username'] = 'Brugernavn';
        $strings['Password'] = 'Adgangskode';
        $strings['PasswordConfirmation'] = 'Bekræft adgangskoden';
        $strings['DefaultPage'] = 'Startside';
        $strings['MyCalendar'] = 'Min kalender';
        $strings['ScheduleCalendar'] = 'Reservations Kalender';
        $strings['Registration'] = 'Registrering';
        $strings['NoAnnouncements'] = 'Der er ingen Meddelelser';
        $strings['Announcements'] = 'Meddelelser';
        $strings['NoUpcomingReservations'] = 'Du har ingen kommende reservationer';
        $strings['UpcomingReservations'] = 'Kommende reservationer';
		$strings['AllNoUpcomingReservations'] = 'Det findes ingen kommnde reservationer';
		$strings['AllUpcomingReservations'] = 'Alle kommende reservationer';
		$strings['ShowHide'] = 'Vis/Skjul';
        $strings['Error'] = 'Fejl';
        $strings['ReturnToPreviousPage'] = 'Tilbage til forrige side';
        $strings['UnknownError'] = 'ukendt fejl';
        $strings['InsufficientPermissionsError'] = 'Du har ikke adgang til denne tjeneste';   //usikker på oversettelse resource
        $strings['MissingReservationResourceError'] = 'Ingen service valgt';
        $strings['MissingReservationScheduleError'] = 'Reservationsplan ikke valgt';
        $strings['DoesNotRepeat'] = 'Gentages ikke';
        $strings['Daily'] = 'Dagligt';
        $strings['Weekly'] = 'Ugentligt';
        $strings['Monthly'] = 'Månedsvis';
        $strings['Yearly'] = 'Årligt';
        $strings['RepeatPrompt'] = 'Gentag';
        $strings['hours'] = 'timmer';
        $strings['days'] = 'dage';
        $strings['weeks'] = 'uger';
        $strings['months'] = 'måneder';
        $strings['years'] = 'år';
        $strings['day'] = 'dag';
        $strings['week'] = 'Uge';
        $strings['month'] = 'måned';
        $strings['year'] = 'år';
        $strings['repeatDayOfMonth'] = 'dag i måneden';
        $strings['repeatDayOfWeek'] = 'dag i ugen';
        $strings['RepeatUntilPrompt'] = 'Til';
        $strings['RepeatEveryPrompt'] = 'Hver';
        $strings['RepeatDaysPrompt'] = 'På';
        $strings['CreateReservationHeading'] = 'Opret ny reservation';
        $strings['EditReservationHeading'] = 'Rediger reservation %s';
        $strings['ViewReservationHeading'] = 'Vis reservationen %s';
        $strings['ReservationErrors'] = 'Ændre reservationen';
        $strings['Create'] = 'Opret';
        $strings['ThisInstance'] = 'Kun denne forekomst';
        $strings['AllInstances'] = 'Alle forekomster';
        $strings['FutureInstances'] = 'Fremtidige forekomster';
        $strings['Print'] = 'Udskriv';
        $strings['ShowHideNavigation'] = 'Vis / Skjul navigation';
        $strings['ReferenceNumber'] = 'Referencenummer';
        $strings['Tomorrow'] = 'I morgen';
        $strings['LaterThisWeek'] = 'Senere denne uge';
        $strings['NextWeek'] = 'Næste uge';
        $strings['SignOut'] = 'Log ud'; //usikker oversettelse                                         
		$strings['LayoutDescription'] = 'Start på %s, viser %s dage ad gangen';
        $strings['AllResources'] = 'Alle services';
        $strings['TakeOffline'] = 'Gå offline';
        $strings['BringOnline'] = 'Gå online';
        $strings['AddImage'] = 'Tilføj et billede';
        $strings['NoImage'] = 'Billedet blev ikke tilføjet';
        $strings['Move'] = 'Flyt';
        $strings['AppearsOn'] = 'Vis i %s';
        $strings['Location'] = 'Stedangivelse';
        $strings['NoLocationLabel'] = '(Ingen placering valgt)';
        $strings['Contact'] = 'Kontakt';
        $strings['NoContactLabel'] = '(Ingen kontaktinformationer)';
        $strings['Description'] = 'Beskrivelse';
        $strings['NoDescriptionLabel'] = '(ingen beskrivelse)';
        $strings['Notes'] = 'Notater';
        $strings['NoNotesLabel'] = '(ingen notater)';
        $strings['NoTitleLabel'] = '(ingen titel)';
        $strings['UsageConfiguration'] = 'Brugs konfiguration';
        $strings['ChangeConfiguration'] = 'Ændre konfigurationen';
        $strings['ResourceMinLength'] = 'reservationen skal mindst være %s';
        $strings['ResourceMinLengthNone'] = 'Der er ingen minimum reservation tid';
        $strings['ResourceMaxLength'] = 'reservationen må ikke være længere end %s';
        $strings['ResourceMaxLengthNone'] = 'Der er ikke noget maksimum reservation tid';
        $strings['ResourceRequiresApproval'] = 'reservationen skal godkendes';
        $strings['ResourceRequiresApprovalNone'] = 'reservationen behøver ikke godkendelse';
		$strings['ResourcePermissionAutoGranted'] = 'Godkendes automatisk';
        $strings['ResourcePermissionNotAutoGranted'] = 'Tilladelse gives ikke automatisk';
        $strings['ResourceMinNotice'] = 'Reservation skal foretages mindst %s før booket tid';
        $strings['ResourceMinNoticeNone'] = 'Reservation kan ske indtil den bookede tid';
        $strings['ResourceMaxNotice'] = 'Reservation kan ikke stoppe tidligere end %s fra aktuel tid';
        $strings['ResourceMaxNoticeNone'] = 'Reservationer kan slutte på ethvert tidspunkt i fremtiden';
		$strings['ResourceBufferTime'] = 'Det skal være %s mellem reservationer';
		$strings['ResourceBufferTimeNone'] = 'Der er ingen buffer mellem reservasjoner';
        $strings['ResourceAllowMultiDay'] = 'Reservation kan ske i løbet af dage';
        $strings['ResourceNotAllowMultiDay'] = 'Reservation kan ikke foretages over dage';
        $strings['ResourceCapacity'] = 'Denne service har en kapacitet på %s personer';
        $strings['ResourceCapacityNone'] = 'Denne service er ubegrænset';
        $strings['AddNewResource'] = 'Tilføj ny service';
        $strings['AddNewUser'] = 'Tilføj ny bruger';
        $strings['AddUser'] = 'Tilføj bruger';
        $strings['Schedule'] = 'Skema';
        $strings['AddResource'] = 'Tilføj service';
        $strings['Capacity'] = 'Kapasitet';
        $strings['Access'] = 'Adgang';
        $strings['Duration'] = 'Varighed';
        $strings['Active'] = 'Aktiv';
        $strings['Inactive'] = 'Inaktiv';
        $strings['ResetPassword'] = 'Gendan Adgangskode';
        $strings['LastLogin'] = 'seneste Login';
        $strings['Search'] = 'Søg';
        $strings['ResourcePermissions'] = 'tilladelse til service';
        $strings['Reservations'] = 'Reservationer';
        $strings['Groups'] = 'Grupper';
		$strings['Users'] = 'Brugere';
        $strings['ResetPassword'] = 'Gendan Adgangskode';
        $strings['AllUsers'] = 'Alle brugere';
        $strings['AllGroups'] = 'Alle Grupper';
        $strings['AllSchedules'] = 'Alle skemaer';
        $strings['UsernameOrEmail'] = 'Brugernavn eller E-mail';
        $strings['Members'] = 'Medlemmer';
        $strings['QuickSlotCreation'] = 'Opret booking interval med %s minuter imellem %s og %s';
        $strings['ApplyUpdatesTo'] = 'Anvend updateringer på';
        $strings['CancelParticipation'] = 'Fortryd deltagelse';
        $strings['Attending'] = 'Nuværende';
        $strings['QuotaConfiguration'] = 'På %s får %s brugere i %s er begrænset til %s %s per %s';
        $strings['reservations'] = 'reservationer';
		$strings['reservation'] = 'reservation';
        $strings['ChangeCalendar'] = 'Byt Kalender';
        $strings['AddQuota'] = 'Tilføj et filter';
        $strings['FindUser'] = 'Søg bruger';
        $strings['Created'] = 'Oprettet';
        $strings['LastModified'] = 'seneste uændret';
        $strings['GroupName'] = 'Gruppenavn';
        $strings['GroupMembers'] = 'Gruppemedlemmer';
        $strings['GroupRoles'] = 'Grupperolle';
        $strings['GroupAdmin'] = 'Gruppeadministrator';
        $strings['Actions'] = 'Handlinger';
        $strings['CurrentPassword'] = 'Nuværende Adgangskode';
        $strings['NewPassword'] = 'Ny Adgangskode';
        $strings['InvalidPassword'] = 'Adgangskode er forkert';
        $strings['PasswordChangedSuccessfully'] = 'Dit adgangskode er blevet ændret';
        $strings['SignedInAs'] = 'Logget ind som';
        $strings['NotSignedIn'] = 'Du er ikke logget ind';
        $strings['ReservationTitle'] = 'Overskrift på reservationen';
        $strings['ReservationDescription'] = 'Yderligere information';
        $strings['ResourceList'] = 'Reservation af værelser';
        $strings['Accessories'] = 'Tilbehør';
        $strings['ParticipantList'] = 'Deltagare';
        $strings['InvitationList'] = 'inviterede';
        $strings['AccessoryName'] = 'Navn på tilbehør';
        $strings['QuantityAvailable'] = 'Tilgængeligt antal';
        $strings['Resources'] = 'Services';
        $strings['Participants'] = 'Deltagare';
        $strings['User'] = 'Brugere';
        $strings['Resource'] = 'Service';
        $strings['Status'] = 'Status';
        $strings['Approve'] = 'Godkend';
        $strings['Page'] = 'Side';
        $strings['Rows'] = 'Rækker';
        $strings['Unlimited'] = 'Ubegrænset';
        $strings['Email'] = 'E-mail';
        $strings['EmailAddress'] = 'E-mail Adresse';
        $strings['Phone'] = 'Mobiltelefon';
        $strings['Organization'] = 'gade';
        $strings['Position'] = 'Postnr / sted';
        $strings['Language'] = 'Sprog';
        $strings['Permissions'] = 'Tilladelser';
        $strings['Reset'] = 'Gendan';
        $strings['FindGroup'] = 'Søg Gruppe';
        $strings['Manage'] = 'Håndter';
        $strings['None'] = 'Ingen';
        $strings['AddToOutlook'] = 'Tilføj i kalendern';
        $strings['Done'] = 'Klart';
        $strings['RememberMe'] = 'Husk mig';
        $strings['FirstTimeUser?'] = 'Første gang du er her?';
        $strings['CreateAnAccount'] = 'Opret en konto';
        $strings['ViewSchedule'] = 'Vis kalender';
        $strings['ForgotMyPassword'] = 'Glemt adgangskode';
        $strings['YouWillBeEmailedANewPassword'] = 'Vi sender et nyt tilfældigt genereret adgangskode til din e-mail';
        $strings['Close'] = 'Luk';
        $strings['ExportToCSV'] = 'Eksporter til CSV';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'fungerer...';
        $strings['Login'] = 'Login';
        $strings['AdditionalInformation'] = 'Yderligere information';
        $strings['AllFieldsAreRequired'] = 'Alle felter er obligatoriske';
        $strings['Optional'] = 'frivilligt';
        $strings['YourProfileWasUpdated'] = 'din profil er opdatert';
        $strings['YourSettingsWereUpdated'] = 'Dine indstillinger blev opdateret';
        $strings['Register'] = 'Registrer';
        $strings['SecurityCode'] = 'Sikkerhedskode';
        $strings['ReservationCreatedPreference'] = 'Når jeg opretter en reservation eller en reservation oprettes på mine vegne';
        $strings['ReservationUpdatedPreference'] = 'Når jeg uppdaterar en reservation eller en reservation opdateres på mine vegne';
        $strings['ReservationDeletedPreference'] = 'Når jeg fjerner bort en reservation eller en reservation fjernes på mine vegne';
        $strings['ReservationApprovalPreference'] = 'Afventer at min reservation bliver godkendt';
        $strings['PreferenceSendEmail'] = 'Send en e-mail til mig';
        $strings['PreferenceNoEmail'] = 'Underret mig ikke';
        $strings['ReservationCreated'] = 'Din reservation blev oprettet!';
        $strings['ReservationUpdated'] = 'Din reservation er opdateret!';
		$strings['ReservationRemoved'] = 'Din reservation blev fjernet';
		$strings['ReservationRequiresApproval'] = 'En eller flere af reservationerne skal godkendes, før den er gældende. Denne reservation er kun midlertidig, indtil den er godkendt.';
        $strings['YourReferenceNumber'] = 'Dit referencenummer er %s';
        $strings['UpdatingReservation'] = 'Opdaterer reservationen';
        $strings['ChangeUser'] = 'Ændre bruger';
        $strings['MoreResources'] = 'Reserver flere værelser';
        $strings['ReservationLength'] = 'Reservationens længde';
        $strings['ParticipantList'] = 'Deltagarliste';
        $strings['AddParticipants'] = 'Tilføj deltagare';
        $strings['InviteOthers'] = 'Inviter andre';
        $strings['AddResources'] = 'Tilføj tilbehør';
        $strings['AddAccessories'] = 'Tilføj tilbehør';
        $strings['Accessory'] = 'Tilbehør';
        $strings['QuantityRequested'] = 'Antal ';
        $strings['CreatingReservation'] = 'Opretter reservation';
        $strings['UpdatingReservation'] = 'Opdaterer reservationen';
        $strings['DeleteWarning'] = 'Denne handling er permanent og kan ikke fortrydes!';
        $strings['DeleteAccessoryWarning'] = 'Fjerner du dette tilbehør bliver det i slettet i alle reservationer.';
        $strings['AddAccessory'] = 'Tilføj tilbehør';
        $strings['AddBlackout'] = 'Tilføj Ikke tilgængelig tid';
        $strings['AllResourcesOn'] = 'Alle tillgange er med';
        $strings['Reason'] = 'Årsag';
        $strings['BlackoutShowMe'] = 'Vis Ikke tilgængelig Tid i konflikt';
        $strings['BlackoutDeleteConflicts'] = 'Fjern Ikke tilgængelig Tid som er i konflikt';
        $strings['Filter'] = 'Filter';
        $strings['Between'] = 'Mellem';
        $strings['CreatedBy'] = 'Oprettet af';
        $strings['BlackoutCreated'] = 'Ikke tilgængelig Tid Oprettet!';
        $strings['BlackoutNotCreated'] = 'Ikke tilgængelig Tid kunne ikke oprettes!';
		$strings['BlackoutUpdated'] = 'Ikke tilgængelig Tid opdatert';
		$strings['BlackoutNotUpdated'] = 'Ikke tilgængelig Tid kunne ikke opdateres';
        $strings['BlackoutConflicts'] = 'Der er Ikke tilgængelig Tid i konflikt';
        $strings['ReservationConflicts'] = 'Det er modstridende reservationstider';
        $strings['UsersInGroup'] = 'Brugere i denne gruppe';
        $strings['Browse'] = 'Gennemse';
        $strings['DeleteGroupWarning'] = 'Fjerner du denne gruppe vil alle servicerelationer blive slettet . Brugere i denne gruppe kan miste adgang til services.';
        $strings['WhatRolesApplyToThisGroup'] = 'Hvilken roller gælder for denne gruppe?';
        $strings['WhoCanManageThisGroup'] = 'Hvem administrerer denne gruppe?';
 		$strings['WhoCanManageThisSchedule'] = 'Hvem kan administrere denne reservationskalenderen?';
       $strings['AddGroup'] = 'Tilføj gruppe';
        $strings['AllQuotas'] = 'Alle filter';
        $strings['QuotaReminder'] = 'Husk: anvendte filtre baseres på tidsplanen \ s tidszone.';
        $strings['AllReservations'] = 'Alle reservationer';
        $strings['PendingReservations'] = 'Ej godkente reservationer';
        $strings['Approving'] = 'Godkender';
        $strings['MoveToSchedule'] = 'Flyt til kalendern';
        $strings['DeleteResourceWarning'] = 'Fjerner du denne service, vil alle tilknyttede data blive slettet, inklusive';
        $strings['DeleteResourceWarningReservations'] = 'Alle tidligere, nuværende og framtidige reservationer associeret med denne';
        $strings['DeleteResourceWarningPermissions'] = 'Alle tilladte opgaver';
        $strings['DeleteResourceWarningReassign'] = 'Du bedes markere alt som du ikke vil have fjernet inden du går videre';
        $strings['ScheduleLayout'] = 'Layout (Alle tider %s)';
        $strings['ReservableTimeSlots'] = 'Reservervationsbare tidsintervaller';
        $strings['BlockedTimeSlots'] = 'Blokkerede tidsintervaller';
        $strings['ThisIsTheDefaultSchedule'] = 'Denne kalender er forvalgt';
        $strings['DefaultScheduleCannotBeDeleted'] = 'Den forvalgte kalender kan ikke slettes';
        $strings['MakeDefault'] = 'Angiv som forvalgt';
        $strings['BringDown'] = 'Flytta ner';
        $strings['ChangeLayout'] = 'Ændre Layout';
        $strings['AddSchedule'] = 'Tilføj reservationskalender';
        $strings['StartsOn'] = 'Start på';
        $strings['NumberOfDaysVisible'] = 'Antal synlige dage';
        $strings['UseSameLayoutAs'] = 'Anvend samme indstillinger som';
        $strings['Format'] = 'Format';
        $strings['OptionalLabel'] = 'Valgfrit felt';
        $strings['LayoutInstructions'] = 'Tilføj et tidsinterval per ræke.  Tidsinterval skal tildeles alle 24 timer af døgnet, begynde og slutte 12.00.';
        $strings['AddUser'] = 'Tilføj brugere';
        $strings['UserPermissionInfo'] = 'Adgang til tjenesten, kan variere afhængigt af brugerens rolle, medlemskab gruppe eller ekstern tilladelsesindstillinger';
        $strings['DeleteUserWarning'] = 'Hvis du fjerner denne bruger fjernes denne brugers samtlige reservationer.';
        $strings['AddAnnouncement'] = 'Tilføj besked';
        $strings['Announcement'] = 'Besked';
        $strings['Priority'] = 'Prioritet';
        $strings['Reservable'] = 'Ledig';
        $strings['Unreservable'] = 'Ikke Reserverbar';
        $strings['Reserved'] = 'Reserveret';
        $strings['MyReservation'] = 'Mine Reservationer';
        $strings['Pending'] = 'Afventende';
        $strings['Past'] = 'Tidligere';
        $strings['Restricted'] = 'Begrænset';
        $strings['ViewAll'] = 'Vis allt';
        $strings['MoveResourcesAndReservations'] = 'Flyt services og reservationer til';
        $strings['TurnOffSubscription'] = 'Luk for abonnement i kalendern';
        $strings['TurnOnSubscription'] = 'Tillad abonnement i denne kalender';
        $strings['SubscribeToCalendar'] = 'Abonnér på denne kalender';
        $strings['SubscriptionsAreDisabled'] = 'Administratorens abonnement blev inaktiveret i kalender';
        $strings['NoResourceAdministratorLabel'] = '(Ingen administrator af servicen)';
        $strings['WhoCanManageThisResource'] = 'Hvem kan administrere denne service?';
        $strings['ResourceAdministrator'] = 'Administrator af servicen';
        $strings['Private'] = 'Privat';
        $strings['Accept'] = 'Godkend';
        $strings['Decline'] = 'Afvis';
        $strings['ShowFullWeek'] = 'Vis hele Ugen';
        $strings['CustomAttributes'] = 'Egen attribut';
        $strings['AddAttribute'] = 'Tilføj et attribut';
        $strings['EditAttribute'] = 'Opdater attribut';
        $strings['DisplayLabel'] = 'Vis Etiket';
        $strings['Type'] = 'Type';
        $strings['Required'] = 'Kræves';
        $strings['ValidationExpression'] = 'Validation Expression';
        $strings['PossibleValues'] = 'Mulig værdi';
        $strings['SingleLineTextbox'] = 'En linje Textbox';
        $strings['MultiLineTextbox'] = 'Flere linjer Textbox';
        $strings['Checkbox'] = 'Checkbox';
        $strings['SelectList'] = 'Vælg liste';
        $strings['CommaSeparated'] = 'komma separeret';
        $strings['Category'] = 'Kategori';
        $strings['CategoryReservation'] = 'Reservation';
        $strings['CategoryGroup'] = 'Gruppe';
        $strings['SortOrder'] = 'Sorteringsordning';
        $strings['Title'] = 'Rubrik';
        $strings['AdditionalAttributes'] = 'Valgfrie oplysninger';
        $strings['True'] = 'Sandt';
        $strings['False'] = 'Falsk';
			$strings['ForgotPasswordEmailSent'] = 'En e-mail blev sendt til din e-mail-adresse med instruktione på hvordan du nulstiller din adgangskode';
		$strings['ActivationEmailSent'] = 'En aktivering e-mail blev sendt til dig.';
		$strings['AccountActivationError'] = 'Der opstod et problem under aktivering af din konto, kontoen kunne ikke aktiveres. Du bedes prøve igen.';
		$strings['Attachments'] = 'vedhæftede filer';
		$strings['AttachFile'] = 'Vedhæft fil';
		$strings['Maximum'] = 'Max';
		$strings['NoScheduleAdministratorLabel'] = 'Ingen administrator for reservationakalender';
		$strings['ScheduleAdministrator'] = 'Administrator reservationakalender';
		$strings['Total'] = 'Totalt';
		$strings['QuantityReserved'] = 'Antal reservert';
	$strings['AllAccessories'] = 'Alle tilbehør';
		$strings['GetReport'] = 'Download rapport';
		$strings['NoResultsFound'] = 'Fandt ingen Rapporter';
		$strings['SaveThisReport'] = 'Gem denne Rapport';
		$strings['ReportSaved'] = 'Rapport gemt!';
		$strings['EmailReport'] = 'Send rapport med e-mail';
		$strings['ReportSent'] = 'Rapport sendt!';
		$strings['RunReport'] = 'Kør rapport';
		$strings['NoSavedReports'] = 'Der findes ingen gemte rapporter';
		$strings['CurrentMonth'] = 'Denne måned';
		$strings['CurrentWeek'] = 'Denne Uge';
		$strings['AllTime'] = 'Hele Tidsperioden';
		$strings['FilterBy'] = 'Filtrer efter:';
		$strings['Select'] = 'Vælg rapport:';
		$strings['List'] = 'Liste';
		$strings['TotalTime'] = 'Total Tid';
		$strings['Count'] = 'Tæl';
		$strings['Usage'] = 'Vælg efter type:';
		$strings['AggregateBy'] = 'Vælg efter:';
		$strings['Range'] = 'Vælg interval:';
		$strings['Choose'] = 'Vælg';
		$strings['All'] = 'Alt';
		$strings['ViewAsChart'] = 'Vis som søjlediagram';
		$strings['ReservedResources'] = 'Reserverede Services';
		$strings['ReservedAccessories'] = 'Reserverede tilbehør';
		$strings['ResourceUsageTimeBooked'] = 'Reserverede Services - Reserveret Tid';
		$strings['ResourceUsageReservationCount'] = 'Benyttede Services - Antal Reservationer';
		$strings['Top20UsersTimeBooked'] = 'Top 20 Brugere - Totalt reserveret tid';
		$strings['Top20UsersReservationCount'] = 'Top 20 Brugere - Totale antal reservationer';
		$strings['ConfigurationUpdated'] = 'Konfigurationsfilen blev opdatert';
		$strings['ConfigurationUiNotEnabled'] = 'Denne side er der ikke adgang til, fordi $conf[\'settings\'][\'pages\'][\'enable.configuration\'] er sat til falsk eller mangler.';
                $strings['ConfigurationFileNotWritable'] = 'Der kan ikke skrives tilonfigurationsfilen. Vær venligt at kontrollere adgangstighederne til denne fil og prøv igen.';
		$strings['ConfigurationUpdateHelp'] = 'Vis konfigurationsinnstillingerne i <a target=_blank href=%s>Hjælpefil</a> ';
		$strings['GeneralConfigSettings'] = 'indstillinger';
		$strings['UseSameLayoutForAllDays'] = 'Brug samme layout til alle dage';
		$strings['LayoutVariesByDay'] = 'Layout varierer dag for dag';
		$strings['ManageReminders'] = 'Administrer Meddelelser';
		$strings['ReminderUser'] = 'Bruger ID Meddelelse';
		$strings['ReminderMessage'] = 'Påmindelse om besked';
		$strings['ReminderAddress'] = 'Addresser for meddelelser';
		$strings['ReminderSendtime'] = 'Tid for at sende meddelelse';
		$strings['ReminderRefNumber'] = 'Meddelelse referansenummer';
		$strings['ReminderSendtimeDate'] = 'Dato for meddelelse';
		$strings['ReminderSendtimeTime'] = 'Tid for meddelelse (TT:MM)';
		$strings['ReminderSendtimeAMPM'] = 'AM / PM';
		$strings['AddReminder'] = 'Tilføje meddelelse';
		$strings['DeleteReminderWarning'] = 'Vil du virkelig slette meddelelsen?';
		$strings['NoReminders'] = 'Du har ingen kommende meddelelser.';
		$strings['Reminders'] = 'Meddelelser';
		$strings['SendReminder'] = 'Send meddelelse';
		$strings['minutes'] = 'minutter';
		$strings['hours'] = 'timer';
		$strings['days'] = 'dage';
		$strings['ReminderBeforeStart'] = 'før starttid';
		$strings['ReminderBeforeEnd'] = 'før afslutning';
		$strings['Logo'] = 'Logo';
		$strings['CssFile'] = 'CSS Fil';
		$strings['ThemeUploadSuccess'] = 'Dine ændringer er gemt. Genindlæs siden (F5) for at opdatere siden.';
		$strings['MakeDefaultSchedule'] = 'Vælg som standard kalender';
		$strings['DefaultScheduleSet'] = 'Dette er nu din standardkalender';
		$strings['FlipSchedule'] = 'Skift design på reservations kalenderen';
		$strings['Next'] = 'Næste';
		$strings['Success'] = 'succes';
		$strings['Participant'] = 'Deltager';
		$strings['ResourceFilter'] = 'Enhedsfilter';
		$strings['ResourceGroups'] = 'Enhedsgrupper';
		$strings['AddNewGroup'] = 'Tilføj ny gruppe';
		$strings['Quit'] = 'Afslut';
		$strings['AddGroup'] = 'Tilføj gruppe';
		$strings['StandardScheduleDisplay'] = 'Brug standard kalendervisning';
		$strings['TallScheduleDisplay'] = 'Brug høj kalendervisning';
		$strings['WideScheduleDisplay'] = 'Brug udvidet kalendervisning';
		$strings['CondensedWeekScheduleDisplay'] = 'Brug komprimert Ugevisning';
		$strings['ResourceGroupHelp1'] = 'Træk og slip enhedsgrupper for at reorganisere.';
		$strings['ResourceGroupHelp2'] = 'Højreklik på en enhedsgruppes navn for flere valgmuligheder.';
		$strings['ResourceGroupHelp3'] = 'Træk og slip enheder for at føje dem til grupper.';
		$strings['ResourceGroupWarning'] = 'Hvis enhedsgrupper bruges, skal hver enhed tildeles mindst én gruppe. Enheder, der ikke er tildelt en gruppe kan ikke reserveres.';
		$strings['ResourceType'] = 'Enhedstype';
		$strings['AppliesTo'] = 'Tilhører';
		$strings['UniquePerInstance'] = 'Unik pr instans';
		$strings['AddResourceType'] = 'Tilføj enhedstype';
		$strings['NoResourceTypeLabel'] = '(Ingen Ryd filter enhedstype valgt)';
		$strings[''] = 'Rens filter';
		$strings['MinimumCapacity'] = 'Minimum kapacitet';
		$strings['Color'] = 'Farve';
		$strings['Available'] = 'Tilgængelig';
		$strings['Unavailable'] = 'Ikke tilgængelig';
		$strings['Hidden'] = 'Skjult';
		$strings['ResourceStatus'] = 'Enhedsstatus';
		$strings['CurrentStatus'] = 'Nuværende status';
		$strings['AllReservationResources'] = 'Alle reserverbare enheder';
		$strings['File'] = 'Fil';
		$strings['BulkResourceUpdate'] = 'Multiopdatering af enheder';		
		$strings['Unchanged'] = 'Uændret';
		$strings['Common'] = 'Almindelig';
		$strings['AdvancedFilter'] = 'Avanceret Filter';
		$strings['AllParticipants'] = 'Alle deltagere';
		$strings['ResourceAvailability'] = 'Tilgængelige enheder';
		$strings['UnavailableAllDay'] = 'Utilgængelig hele dagen';
		$strings['AvailableUntil'] = 'Tilgængelig frem til';
		$strings['AvailableBeginningAt'] = 'Tilgængelig begynder kl';
		$strings['AllowParticipantsToJoin'] = 'Tillad deltagere at bliv medlem';
		$strings['JoinThisReservation'] = 'Deltag i denne reservation';
		$strings['Import'] = 'Import';
		$strings['GetTemplate'] = 'Hent skabelon';
		$strings['UserImportInstructions'] = 'Filen skal være i CSV-format. Brugernavn og e-mail skal udfyldes. Efterlades andre felter tomme vil de sættes til standardværdier og \'password\' som brugeres\ password. rug den medfølgende skabelon som et eksempel.';
		$strings['RowsImported'] = 'Rækker Importeret';
		$strings['RowsSkipped'] = 'Rækker udeladt';
		$strings['DateTime'] = 'Dato tid';
		$strings['SendAsEmail'] = 'Send som e-mail';
		$strings['IncludeDeleted'] = 'Medtag slettede';
		$strings['Deleted'] = 'slettet';
		$strings['OnlyIcs'] = 'Kan *.ics filer kan uploadedes.';
		$strings['IcsLocationsAsResources'] = 'Beliggenheder vil blive importeret som ressourcer.';
		$strings['IcsMissingOrganizer'] = 'Enhver begivenhed der mangler en arrangør vil vlive tildelt den aktuelle bruger som ejeren .';
		$strings['IcsWarning'] = 'Reservation regler vil ikke blive håndhævet - konflikter, dubletter, osv er mulige.';
		$strings['DuplicateReservation'] = 'Kopier reservationen';
		$strings['BlackoutAroundConflicts'] = 'Blokerede modstridende reservationer';
		// End Strings

		// Install
		$strings['InstallApplication'] = 'Installer Booked Scheduler (kun MySQL)';
		$strings['IncorrectInstallPassword'] = 'Beklager, orkert adgangskode.';
		$strings['SetInstallPassword'] = 'Du skal oprette en installation adgangskode, før du kan fortsætte.';
		$strings['InstallPasswordInstructions'] = 'I %s Du skal angiv %s en adgangskode, der er tilfældig og svært at gætte, og derefter vende tilbage til denne side.<br/>Du kan bruge %s';
		$strings['NoUpgradeNeeded'] = 'Ingen opdatering nødvendig. Ved at køre en ny installation, vil alle eksisterende data blive slettet, og en ny kopi af Bookede Scheduler vil blive installeret!';
		$strings['ProvideInstallPassword'] = 'Du bedes indtaste din adgangskode for opsætning.';
		$strings['InstallPasswordLocation'] = 'Dette finder du på %s i %s.';
		$strings['VerifyInstallSettings'] = 'Godkend følgende standardinnstillinger før du fortsetter. Eller du kan ændre dem i %s.';
		$strings['DatabaseName'] = 'Navn på database';
		$strings['DatabaseUser'] = 'Database Brugernavn';
		$strings['DatabaseHost'] = 'Databasens hostingsvært';
		$strings['DatabaseCredentials'] = 'Du skal indtaste oplysninger om en MySQL bruger, der har rettigheder til at oprette databaser. Hvis du ikke kender en, skal du kontakte administratoren af databasen. I mange tilfælde vil installation på root niveau.';
		$strings['MySQLUser'] = 'MySQL-bruger';
		$strings['InstallOptionsWarning'] = 'Følgende muligheter vil måske ikke virke i et værtsmiljø. Hvis du innstallerer på en vært, brug MySQL-wizard verktøjet eller PhpMySql for at fuldføre disse trin.';
		$strings['CreateDatabase'] = 'Opret databasen';
		$strings['CreateDatabaseUser'] = 'Opret databasebruger';
		$strings['PopulateExampleData'] = 'Importer eksempeldata. Oprett adminkonto: admin/password og brugerkonto: bruger/password';
		$strings['DataWipeWarning'] = 'Advarsel: Dette vil slette eksisterende data';
		$strings['RunInstallation'] = 'Kør installation';
		$strings['UpgradeNotice'] = 'Du opgraderer fra vertion <b>%s</b> til vertion <b>%s</b>';
		$strings['RunUpgrade'] = 'Kør opgradering';
		$strings['Executing'] = 'Udfører';
		$strings['StatementFailed'] = 'Fejlede. Detaljer:';
		$strings['SQLStatement'] = 'SQL Udryk:';
		$strings['ErrorCode'] = 'Fejlkode:';
		$strings['ErrorText'] = 'Fejlmelding:';
		$strings['InstallationSuccess'] = 'Installationen er gennemført!';
		$strings['RegisterAdminUser'] = 'Registrer  administratorbruger. Dette er påkrævet hvis du ikke importerte eksempeldata. Kontroller at $conf[\'settings\'][\'allow.self.registration\'] = \'true\' er i %s filen.';
		$strings['LoginWithSampleAccounts'] = 'Hvis du importerte eksempeldata, kan du nu logge ind med admin/password for adminbruger eller user/password for basisbruger.';
		$strings['InstalledVersion'] = 'Du kjører nu vertion %s af Booked Scheduler';
		$strings['InstallUpgradeConfig'] = 'Det  anbefales at oppgradere konfigurationsfilen';
		$strings['InstallationFailure'] = 'Der opstod et problem unde installationen. Du Bedes rette fejlen, og prøve igen.';
		$strings['ConfigureApplication'] = 'Konfigurer Booked Scheduler';
		$strings['ConfigUpdateSuccess'] = 'Konfigurationsfilen er nu opdateret!';
		$strings['ConfigUpdateFailure'] = 'Kunne ikke automatisk opdatere konfigurationsfilen. Du bedes erstatte indholdet i filen config.php med følgende:';
		$strings['SelectUser'] = 'Vælg bruger';
		// End Install

        // Errors
        $strings['LoginError'] = 'Brugernavn eller Adgangskode er forkert';
        $strings['ReservationFailed'] = 'Din reservation kunne ikke gennemføres';
        $strings['MinNoticeError'] = 'Denne reservation kræver forhåndsanmeldelse. Den første dag der kan reserveres er %s.';
        $strings['MaxNoticeError'] = 'Denne reservation kan ikke gennemføres så langt frem i tiden. Det seneste dato og tid som kan reserveres er %s.';
        $strings['MinDurationError'] = 'Denne reservation skal mindst være %s.';
        $strings['MaxDurationError'] = 'Denne reservation kan ikke overstige %s.';
        $strings['ConflictingAccessoryDates'] = 'Det findes ikke tilstrækkeligt af følgende tilbehør:';
        $strings['NoResourcePermission'] = 'Du har ikke adgang til/den ønskede service/services';
        $strings['ConflictingReservationDates'] = 'Der er modstridende reservationer på følgende dato:';
        $strings['StartDateBeforeEndDateRule'] = 'Startdato og tid skal være før slutdatoen og tid';
        $strings['StartIsInPast'] = 'Start dato og tid kan ikke være i fortiden';
        $strings['EmailDisabled'] = 'Administratoren har inaktiveret e-mails';
        $strings['ValidLayoutRequired'] = 'Tidsintervaller skal angives foralle 24 timer i døgnet, begynde og slutte 12:00 .';
        $strings['CustomAttributeErrors'] = 'Der er et problem med attribut er angivet:';
        $strings['CustomAttributeRequired'] = '%s er et påkrævet felt';
        $strings['CustomAttributeInvalid'] = 'Den værdi, du indtastede for %s er ugyldigt';
        $strings['AttachmentLoadingError'] = 'Ett problem uppstod vid uppladdning af den begärda filen.';
        $strings['InvalidAttachmentExtension'] = 'Du kan kun uploade filer af typen: %s';
		$strings['InvalidStartSlot'] = 'Ønsket starttidspunkt er ikke gyldigt.';
		$strings['InvalidEndSlot'] = 'Ønsket sluttidspunkt er ikke gyldigt.';
		$strings['MaxParticipantsError'] = '%s kan kun have %s deltagere.';
		$strings['ReservationCriticalError'] = 'Der opstod en kritisk fejl under lagringen af din reservation. Kontakt administrator hvis problemet fortsætter.';
		$strings['InvalidStartReminderTime'] = 'Starttid for besked ikke gyldig.';
		$strings['InvalidEndReminderTime'] = 'Sluttid for besked ikke gyldig.';
		$strings['QuotaExceeded'] = 'Kvotegrænsen overskredet.';
		$strings['MultiDayRule'] = '%s tillader ikke reservatiner over flere dage.';
		$strings['InvalidReservationData'] = 'Der opstod et problem med din anmodning om reservation.';
		$strings['PasswordError'] = 'Adgangskoden skal indeholde mindst %s bogstaver og mindst %s tal.';
		$strings['PasswordErrorRequirements'] = 'Adgangskoden skal inneholde en kombination af minsdt %s store og små bogstaver og %s tal.';
		$strings['NoReservationAccess'] = 'Du har ikke rettigheder til at ændre denne reservationen.';
		$strings['PasswordControlledExternallyError'] = 'Adgangskoden er kontrollert af et eksternt system og kan ikke ændres her.';
		$strings['NoResources'] = 'Du har ikke tilføjet nogen enheder.';
		$strings['ParticipationNotAllowed'] = 'Du har ikke tilladelse til at deltage i denne reservation.';
		$strings['InsecureRequestError'] = 'Usikker anmodning. Hvis du fortsætter med at se denne fejl, skal du logge ind igen, og prøv igen din anmodning.';
		$strings['RemoveExistingPermissions'] = 'Fjern eksisterende tilladelser?';
        // End Errors

        // Page Titles
        $strings['CreateReservation'] = 'Opret reservation';
        $strings['EditReservation'] = 'Ændre reservation';
        $strings['LogIn'] = 'Log ind';
        $strings['ManageReservations'] = 'Reservationer';
        $strings['AwaitingActivation'] = 'Afventer aktivering';
        $strings['PendingApproval'] = 'Afventer godkännande';
        $strings['ManageSchedules'] = 'Kalender';
        $strings['ManageResources'] = 'Services';
        $strings['ManageAccessories'] = 'Tilbehør';
        $strings['ManageUsers'] = 'Brugere';
        $strings['ManageGroups'] = 'Grupper';
        $strings['ManageQuotas'] = 'Filter';
        $strings['ManageBlackouts'] = 'Blokerede tider';
        $strings['MyDashboard'] = 'min opslagstavle';
        $strings['ServerSettings'] = 'server indstillinger';
        $strings['Dashboard'] = 'opslagstavle';
        $strings['Help'] = 'Hjælp';
		$strings['Administration'] = 'Administration';
		$strings['About'] = 'Om';
        $strings['Bookings'] = 'Reservationer';
        $strings['Schedule'] = 'Kalender';
        $strings['Reservations'] = 'Reservering';
        $strings['Account'] = 'Konto';
        $strings['EditProfile'] = 'Ændre profil';
        $strings['FindAnOpening'] = 'Find en åbning';
        $strings['OpenInvitations'] = 'Invitation';
        $strings['MyCalendar'] = 'Min kalender';
        $strings['ResourceCalendar'] = 'Servicekalender';
        $strings['Reservation'] = 'Reservationen';
        $strings['Install'] = 'Installation';
        $strings['ChangePassword'] = 'Ændre Adgangskode';
        $strings['MyAccount'] = 'Min konto';
        $strings['Profile'] = 'Profil';
        $strings['ApplicationManagement'] = 'Administration';
        $strings['ForgotPassword'] = 'Glemt adgangskode';
        $strings['NotificationPreferences'] = 'Besked indstillinger';
        $strings['ManageAnnouncements'] = 'Besked';
        $strings['Responsibilities'] = 'Ansvar';
        $strings['GroupReservations'] = 'Gruppereservationer';
        $strings['ResourceReservations'] = 'Reservation af services';
        $strings['Customization'] = 'Tilpasninger';
        $strings['Attributes'] = 'Attribut';
		$strings['AccountActivation'] = 'Aktivering af konto';
		$strings['ScheduleReservations'] = 'Opret reservationer';
		$strings['Reports'] = 'Rapporter';
		$strings['GenerateReport'] = 'Opret ny rapport';
		$strings['MySavedReports'] = 'Mine gemte rapporter';
		$strings['CommonReports'] = 'Mest almindelige rapporter';
		$strings['ViewDay'] = 'Vis dag';
		$strings['Group'] = 'Gruppe';
		$strings['ManageConfiguration'] = 'Administrer konfiguration';
		$strings['LookAndFeel'] = 'Web-udseende';
		$strings['ManageResourceGroups'] = 'Enhedsgrupper';
		$strings['ManageResourceTypes'] = 'Enhedstyper';
		$strings['ManageResourceStatus'] = 'Enhedsstatuser';
		$strings['ImportICS'] = 'Importer ICS fil';
		$strings['ImportQuartzy'] = 'Importer Quartzy File';
        // End Page Titles

        // Day representations
        $strings['DaySundaySingle'] = 'S';
        $strings['DayMondaySingle'] = 'M';
        $strings['DayTuesdaySingle'] = 'T';
        $strings['DayWednesdaySingle'] = 'O';
        $strings['DayThursdaySingle'] = 'T';
        $strings['DayFridaySingle'] = 'F';
        $strings['DaySaturdaySingle'] = 'L';

        $strings['DaySundayAbbr'] = 'Søn';
        $strings['DayMondayAbbr'] = 'Man';
        $strings['DayTuesdayAbbr'] = 'Tir';
        $strings['DayWednesdayAbbr'] = 'Ons';
        $strings['DayThursdayAbbr'] = 'Tor';
        $strings['DayFridayAbbr'] = 'Fre';
        $strings['DaySaturdayAbbr'] = 'Lør';
		// End Day representations

        // Email Subjects
        $strings['ReservationApprovedSubject'] = 'reservationen blev godkendt';
        $strings['ReservationCreatedSubject'] = 'reservationen blev oprettet';
        $strings['ReservationUpdatedSubject'] = 'reservationen blev opdateret';
        $strings['ReservationDeletedSubject'] = 'reservationen blev fjernet';
        $strings['ReservationCreatedAdminSubject'] = 'Besked: En reservation blev oprettet';
        $strings['ReservationUpdatedAdminSubject'] = 'Besked: En reservation blev opdateret';
        $strings['ReservationDeleteAdminSubject'] = 'Besked: En reservation blev opdateret';
		$strings['ReservationApprovalAdminSubject'] = 'Besked: En reservation kræver godkendelse';
        $strings['ParticipantAddedSubject'] = 'Besked om reservation deltagelse';
        $strings['ParticipantDeletedSubject'] = 'reservationen fjernet';
        $strings['InviteeAddedSubject'] = 'Reservervations invitation';
        $strings['ResetPassword'] = 'Gendan adgangskode';
        $strings['ActivateYourAccount'] = 'Du bedes aktivere din konto';
		$strings['ReportSubject'] = 'Din anmodede rapport (%s)';
		$strings['ReservationStartingSoonSubject'] = 'Reservationen af %s starter om kort tid';
		$strings['ReservationEndingSoonSubject'] = 'Reservationen af %s slutter snart';
		$strings['UserAdded'] = 'En ny bruger er tilføjet';
		$strings['UserDeleted'] = 'Brugerkonto for %s blev slettet af %s';
		$strings['AnnouncementSubject'] = 'En ny besked blev indsendt af %s';
// End Email Subjects

        $this->Strings = $strings;
		
		return $this->Strings;
    }

	/**
	 * @return array
	 */

    protected function _LoadDays()
    {
        $days = parent::_LoadDays();

        /***
        DAY NAMES
        All of these arrays MUST start with Sunday as the first element
        and go through the seven day week, ending on Saturday
         ***/
        // The full day name
         $days['full'] = array('Søndag', 'Mandag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag');
        // The three letter abbreviation
        $days['abbr'] = array('Søn', 'Man', 'Tir', 'Ons', 'Tor', 'Fre', 'Lør');
        // The two letter abbreviation
        $days['two'] = array('Sö', 'Sø', 'Ma', 'Ti', 'On', 'To', 'Fr', 'Lø');
        // The one letter abbreviation
        $days['letter'] = array('S', 'M', 'T', 'O', 'T', 'F', 'L');

        $this->Days = $days;

		return $this->Days;
    }

	/**
	 * @return array
	 */
    protected function _LoadMonths()
    {
        $months = parent::_LoadMonths();

        /***
        MONTH NAMES
        All of these arrays MUST start with January as the first element
        and go through the twelve months of the year, ending on December
         ***/
        // The full month name
        $months['full'] = array('Januar', 'Februar', 'Marts', 'April', 'Maj', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'December');
        // The three letter month name
        $months['abbr'] = array('Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec');

        $this->Months = $months;

		return $this->Months;
    }

	/**
	 * @return array
	 */
    protected function _LoadLetters()
    {
        $this->Letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Æ', 'Ø', 'Å');
    }

    protected function _GetHtmlLangCode()
    {
        return 'da_da';
    }
}

?>