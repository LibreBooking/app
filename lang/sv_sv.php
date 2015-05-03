<?php
/**
Copyright 2011-2015 Nick Korbel, Boris Vatin

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

class sv_sv extends en_us
{
    public function __construct()
    {
        parent::__construct();
    }

	protected function _LoadDates()
	{
		$dates = parent::_LoadDates();

		$dates['general_date'] = 'd/m-Y';
        $dates['general_datetime'] = 'd/m-Y H:i:s';
        $dates['schedule_daily'] = 'l, d/m-Y';
        $dates['reservation_email'] = 'd/m/Y @ H:i  (e)';
        $dates['res_popup'] = 'd/m-Y H:i ';
        $dates['dashboard'] = 'l, d/m-Y H:i ';
        $dates['period_time'] = 'H:i ';
		$dates['general_date_js'] = 'yy-mm-dd';
		$dates['calendar_time'] = 'h:mmt';
		$dates['calendar_dates'] = 'd/M';

		$this->Dates = $dates;
	}

    protected function _LoadStrings()
    {
        $strings = parent::_LoadStrings();

        $strings['FirstName'] = 'Förnamn';
        $strings['LastName'] = 'Efternamn';
        $strings['Timezone'] = 'Tidzon';
        $strings['Edit'] = 'Ändra';
        $strings['Change'] = 'Byt';
        $strings['Rename'] = 'Ändra namn';
        $strings['Remove'] = 'Avlägsna';
        $strings['Delete'] = 'Ta bort';
        $strings['Update'] = 'Uppdatera';
        $strings['Cancel'] = 'Avbryt';
        $strings['Add'] = 'Lägg till';
        $strings['Name'] = 'Namn';
        $strings['Yes'] = 'Ja';
        $strings['No'] = 'Nej';
        $strings['FirstNameRequired'] = 'Förnamn krävs.';
        $strings['LastNameRequired'] = 'Efternamn krävs.';
        $strings['PwMustMatch'] = 'Bekräftat lösenord måste matcha lösenordet.';
        $strings['PwComplexity'] = 'Lösenordet måste bestå av minst 6 tecken med en kombination av bokstäver, siffror och symboler.';
        $strings['ValidEmailRequired'] = 'En giltig E-postadress krävs.';
        $strings['UniqueEmailRequired'] = 'Den här e-postadressen är redan registrerad.';
        $strings['UniqueUsernameRequired'] = 'Användarnamnet finns redan.';
        $strings['UserNameRequired'] = 'Användarnamn krävs.';
        $strings['CaptchaMustMatch'] = 'Ange bokstäverna från säkerhetesbilden exakt som de visas.';
        $strings['Today'] = 'Idag';
        $strings['Week'] = 'Vecka';
        $strings['Month'] = 'Månad';
        $strings['BackToCalendar'] = 'Tillbaka till kalendern';
        $strings['BeginDate'] = 'Börjar';
        $strings['EndDate'] = 'Slutar';
        $strings['Username'] = 'Användarnamn';
        $strings['Password'] = 'Lösenord';
        $strings['PasswordConfirmation'] = 'Bekräfta lösenordet';
        $strings['DefaultPage'] = 'Startsida';
        $strings['MyCalendar'] = 'Min kalender';
        $strings['ScheduleCalendar'] = 'Schedule Calendar';
        $strings['Registration'] = 'Registrering';
        $strings['NoAnnouncements'] = 'Det finns inga meddelanden';
        $strings['Announcements'] = 'Meddelanden';
        $strings['NoUpcomingReservations'] = 'Det finns inga bokningar';
        $strings['UpcomingReservations'] = 'Kommande bokningar';
        $strings['ShowHide'] = 'Visa/Dölj';
        $strings['Error'] = 'Fel';
        $strings['ReturnToPreviousPage'] = 'Tillbaka till föregående sida';
        $strings['UnknownError'] = 'Okänt fel';
        $strings['InsufficientPermissionsError'] = 'Du har inte behörighet att komma åt denna tjänst';
        $strings['MissingReservationResourceError'] = 'En tjänst har inte valts';
        $strings['MissingReservationScheduleError'] = 'Ett schema har inte valts';
        $strings['DoesNotRepeat'] = 'Upprepas inte';
        $strings['Daily'] = 'Dagligen';
        $strings['Weekly'] = 'Veckovis';
        $strings['Monthly'] = 'Månadsvis';
        $strings['Yearly'] = 'Årsvis';
        $strings['RepeatPrompt'] = 'Upprepa';
        $strings['hours'] = 'timmar';
        $strings['days'] = 'dag/ar';
        $strings['weeks'] = 'vecka/or';
        $strings['months'] = 'månad/er';
        $strings['years'] = 'år';
        $strings['day'] = 'dag';
        $strings['week'] = 'vecka';
        $strings['month'] = 'månad';
        $strings['year'] = 'år';
        $strings['repeatDayOfMonth'] = 'dag i månad';
        $strings['repeatDayOfWeek'] = 'dag i vecka';
        $strings['RepeatUntilPrompt'] = 'Till';
        $strings['RepeatEveryPrompt'] = 'Under';
        $strings['RepeatDaysPrompt'] = 'På';
        $strings['CreateReservationHeading'] = 'Ny bokning';
        $strings['EditReservationHeading'] = 'Redigera bokning %s';
        $strings['ViewReservationHeading'] = 'Visa bokning %s';
        $strings['ReservationErrors'] = 'Ändra bokning';
        $strings['Create'] = 'Skapa';
        $strings['ThisInstance'] = 'Bara denna instans';
        $strings['AllInstances'] = 'Alla instanser';
        $strings['FutureInstances'] = 'Framtida instanser';
        $strings['Print'] = 'Skriv ut';
        $strings['ShowHideNavigation'] = 'Visa / Dölj Navigering';
        $strings['ReferenceNumber'] = 'Referens nummer';
        $strings['Tomorrow'] = 'Imorgon';
        $strings['LaterThisWeek'] = 'Senare denna vecka';
        $strings['NextWeek'] = 'Nästa vecka';
        $strings['SignOut'] = 'Logga ut';
        $strings['LayoutDescription'] = 'Börja på %s, visar %s dagar i sänder';
        $strings['AllResources'] = 'Alla tjänster';
		$strings['AllAccessories'] = 'Alla tillbehör';
		$strings['List'] = 'Lista';
		$strings['TotalTime'] = 'Total Tid';
		$strings['Count'] = 'Räkna';
		$strings['Group'] = 'Grupp';
		$strings['CurrentMonth'] = 'Denna Månad';
		$strings['CurrentWeek'] = 'Denna Vecka';
		$strings['Total'] = 'Totalt';
		$strings['AllTime'] = 'All Tid';
		$strings['GetReport'] = 'Hämta Rapport';
		$strings['Select'] = 'Välj Rapport:';
		$strings['AggregateBy'] = 'Välj Efter:';
		$strings['houers'] = 'Timmar:';
		$strings['Usage'] = 'Välj Typ Av:';
		$strings['Range'] = 'Välj Intervall:';
		$strings['FilterBy'] = 'Filtrera Efter:';
        $strings['TakeOffline'] = 'Gå offline';
        $strings['BringOnline'] = 'Gå Online';
        $strings['AddImage'] = 'Lägg till bild';
        $strings['NoImage'] = 'Bild inte tilldelad';
        $strings['Move'] = 'Flytta';
        $strings['AppearsOn'] = 'Visas på %s';
        $strings['Location'] = 'Plats';
        $strings['NoLocationLabel'] = '(Ingen plats utsatt)';
        $strings['Contact'] = 'Kontakt';
        $strings['NoContactLabel'] = '(Ingen kontaktinformation)';
        $strings['Description'] = 'Beskrivning';
        $strings['NoDescriptionLabel'] = '(ingen beskrivning)';
        $strings['Notes'] = 'Anteckningar';
        $strings['NoNotesLabel'] = '(inga anteckningar)';
        $strings['NoTitleLabel'] = '(ingen titel)';
        $strings['UsageConfiguration'] = 'Användar konfigurering';
        $strings['ChangeConfiguration'] = 'Ändra konfigurering';
        $strings['ResourceMinLength'] = 'Bokning måste vara minst %s';
        $strings['ResourceMinLengthNone'] = 'Det finns ingen minsta reservationstid';
        $strings['ResourceMaxLength'] = 'Bokning kan inte vara längre än %s';
        $strings['ResourceMaxLengthNone'] = 'Det finns ingen längsta reservationstid';
        $strings['ResourceRequiresApproval'] = 'Bokning måste bli godkänd';
        $strings['ResourceRequiresApprovalNone'] = 'Bokning behöver inte godkännas';
        $strings['ResourcePermissionAutoGranted'] = 'Tillstånd beviljas automatiskt';
        $strings['ResourcePermissionNotAutoGranted'] = 'Tillstånd beviljas inte automatiskt';
        $strings['ResourceMinNotice'] = 'Bokning måste göras minst %s före bokad tid';
        $strings['ResourceMinNoticeNone'] = 'Bokning kan göras fram till bokad tid';
        $strings['ResourceMaxNotice'] = 'Bokningar får inte sluta mer än %s från nuvarande tid';
        $strings['ResourceMaxNoticeNone'] = 'Bokningar kan sluta vid vilken tidpunkt som helst i framtiden';
        $strings['ResourceAllowMultiDay'] = 'Bokning kan göras över dagar';
        $strings['ResourceNotAllowMultiDay'] = 'Bokningar kan inte göras över dagar';
        $strings['ResourceCapacity'] = 'Denna tjänst har en kapacitet av %s människor';
        $strings['ResourceCapacityNone'] = 'Denna tjänst är obegränsad';
        $strings['AddNewResource'] = 'Lägg till ny tjänst';
        $strings['AddNewUser'] = 'Lägg till ny användare';
        $strings['AddUser'] = 'Lägg till användare';
        $strings['Schedule'] = 'Schema';
        $strings['AddResource'] = 'Lägg till tjänst';
        $strings['Capacity'] = 'Kapasitet';
        $strings['Access'] = 'Tillträde';
        $strings['Duration'] = 'Längd';
        $strings['Active'] = 'Aktiv';
        $strings['Inactive'] = 'Inaktiv';
        $strings['ResetPassword'] = 'Återställ lösenord';
        $strings['LastLogin'] = 'Senaste inloggning';
        $strings['Search'] = 'Sök';
        $strings['ResourcePermissions'] = 'Tillstånd av tjänst';
        $strings['Reservations'] = 'Bokning';
        $strings['Groups'] = 'Grupp';
        $strings['ResetPassword'] = 'Återställ lösenord';
        $strings['AllUsers'] = 'Alla användare';
        $strings['AllGroups'] = 'Alla Grupper';
        $strings['AllSchedules'] = 'Alla scheman';
        $strings['UsernameOrEmail'] = 'Användarnamn eller E-post';
        $strings['Members'] = 'Medlem';
        $strings['QuickSlotCreation'] = 'Skapa bokningsintervall var %s minut mellan %s och %s';
        $strings['ApplyUpdatesTo'] = 'Tillämpa uppdateringar på';
        $strings['CancelParticipation'] = 'Ångra deltagandet';
        $strings['Attending'] = 'Närvarande';
        $strings['QuotaConfiguration'] = 'På %s får %s användare i %s är begränsade till %s %s per %s';
        $strings['reservations'] = 'bokningar';
        $strings['ChangeCalendar'] = 'Byt Kalender';
        $strings['AddQuota'] = 'Lägg till ett filter';
        $strings['FindUser'] = 'sök användare';
        $strings['Created'] = 'Skapad';
        $strings['LastModified'] = 'Senast ändrad';
        $strings['GroupName'] = 'Gruppnamn';
        $strings['GroupMembers'] = 'Gruppmedlemmar';
        $strings['GroupRoles'] = 'Grupproll';
        $strings['GroupAdmin'] = 'Gruppadministratör';
        $strings['Actions'] = 'Åtgärd';
        $strings['CurrentPassword'] = 'Nuvarande Lösenord';
        $strings['NewPassword'] = 'Nytt Lösenord';
        $strings['InvalidPassword'] = 'Lösenord är felaktigt';
        $strings['PasswordChangedSuccessfully'] = 'Ditt lösenord har ändrats';
        $strings['SignedInAs'] = 'Inloggad som';
        $strings['NotSignedIn'] = 'Du är inte inloggad';
        $strings['ReservationTitle'] = 'Rubrik på bokningen';
        $strings['ReservationDescription'] = 'Övrig information';
        $strings['ResourceList'] = 'Bokning av rum';
        $strings['Accessories'] = 'Tillbehör';
        $strings['Add'] = 'Lägg till';
        $strings['ParticipantList'] = 'Deltagare';
        $strings['InvitationList'] = 'Inbjudna';
        $strings['AccessoryName'] = 'Namn på tillbehör';
        $strings['QuantityAvailable'] = 'Tillgängligt antal';
        $strings['Resources'] = 'Tjänster';
        $strings['Participants'] = 'Deltagare';
        $strings['User'] = 'Användare';
        $strings['Resource'] = 'Tjänst';
        $strings['Status'] = 'Status';
        $strings['Approve'] = 'Godkänna';
        $strings['Page'] = 'Sida';
        $strings['Rows'] = 'Rad';
        $strings['Unlimited'] = 'Obegränsat';
        $strings['Email'] = 'Email';
        $strings['EmailAddress'] = 'Email Adress';
        $strings['Phone'] = 'Mobiltelefon';
        $strings['Organization'] = 'Gata';
        $strings['Position'] = 'Postnr / Ort';
        $strings['Language'] = 'Språk';
        $strings['Permissions'] = 'Behörighet';
        $strings['Reset'] = 'Återställ';
        $strings['FindGroup'] = 'Sök Grupp';
        $strings['Manage'] = 'Hantera';
        $strings['None'] = 'Ingen';
        $strings['AddToOutlook'] = 'Lägg till i kalendern';
        $strings['Done'] = 'Klart';
        $strings['RememberMe'] = 'Komihåg mig';
        $strings['FirstTimeUser?'] = 'Första gången ni är här?';
        $strings['CreateAnAccount'] = 'Skapa ett konto';
        $strings['ViewSchedule'] = 'Visa kalender';
        $strings['ForgotMyPassword'] = 'Glömt lösenordet';
        $strings['YouWillBeEmailedANewPassword'] = 'Vi skickar ett nytt slumpmässigt genererat lösenord till er E-post';
        $strings['Close'] = 'Stäng';
        $strings['ExportToCSV'] = 'Exportera till CSV';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'fungerar...';
        $strings['Login'] = 'Login';
        $strings['AdditionalInformation'] = 'Ytterligare information';
        $strings['AllFieldsAreRequired'] = 'alla fält är obligatoriska';
        $strings['Optional'] = 'frivilligt';
        $strings['YourProfileWasUpdated'] = 'din profil är uppdaterad';
        $strings['YourSettingsWereUpdated'] = 'Dina inställningar har uppdaterats';
        $strings['Register'] = 'Registrera';
        $strings['SecurityCode'] = 'Säkerhetskod';
        $strings['ReservationCreatedPreference'] = 'När jag skapar en bokning eller en bokning skapas för min räkning';
        $strings['ReservationUpdatedPreference'] = 'När jag uppdaterar en bokning eller en bokning uppdateras för min räkning';
        $strings['ReservationDeletedPreference'] = 'När jag tar bort en bokning eller en bokning tas bort för min räkning';
        $strings['ReservationApprovalPreference'] = 'I avvaktan på att min bokning blir godkänd';
        $strings['PreferenceSendEmail'] = 'Skicka ett email till mig';
        $strings['PreferenceNoEmail'] = 'Meddela mig inte';
        $strings['ReservationCreated'] = 'Din bokning har skapats!';
        $strings['ReservationUpdated'] = 'Din bokning är uppdaterad!';
        $strings['ReservationRemoved'] = 'Din bokning har tagits bort';
        $strings['YourReferenceNumber'] = 'Ert referensnummer är %s';
        $strings['UpdatingReservation'] = 'Uppdaterar bokning';
        $strings['ChangeUser'] = 'ändra användare';
        $strings['MoreResources'] = 'Boka flera rum';
        $strings['ReservationLength'] = 'Bokningens längd';
        $strings['ParticipantList'] = 'Deltagarlista';
        $strings['AddParticipants'] = 'Lägg till deltagare';
        $strings['InviteOthers'] = 'Bjud in andra';
        $strings['AddResources'] = 'Lägg till tillbehör';
        $strings['AddAccessories'] = 'Lägg till tillbehör';
        $strings['Accessory'] = 'Tillbehör';
        $strings['QuantityRequested'] = 'Antal ';
        $strings['CreatingReservation'] = 'Skapar bokning';
        $strings['UpdatingReservation'] = 'Uppdaterar bokning';
        $strings['DeleteWarning'] = 'Denna åtgärd är permanent och går inte att ångra!';
        $strings['DeleteAccessoryWarning'] = 'Tar du bort detta tillbehör kommer det att raderas det från alla bokningar.';
        $strings['AddAccessory'] = 'Lägg till tillbehör';
        $strings['AddBlackout'] = 'Lägg till Ej Tillgänglig Tid';
        $strings['AllResourcesOn'] = 'Alla tillgångar är på';
        $strings['Reason'] = 'Orsak';
        $strings['BlackoutShowMe'] = 'Visa Ej Tillgänglig Tid i konflikt';
        $strings['BlackoutDeleteConflicts'] = 'Ta bort Ej Tillgänglig Tid som är i konflikt';
        $strings['Filter'] = 'Filter';
        $strings['Between'] = 'Mellan';
        $strings['CreatedBy'] = 'Skapad av';
        $strings['BlackoutCreated'] = 'Ej Tillgänglig Tid Skapad!';
        $strings['BlackoutNotCreated'] = 'Ej Tillgänglig Tid kunde inte skapas!';
        $strings['BlackoutConflicts'] = 'Det finns Ej Tillgänglig Tid i konflikt';
        $strings['ReservationConflicts'] = 'Det finns motstridiga reservationstider';
        $strings['UsersInGroup'] = 'Användare i denna grupp';
        $strings['Browse'] = 'Bläddra';
        $strings['DeleteGroupWarning'] = 'Tar du bort denna grupp kommer alla tjänstetillhörigheter att raderas . Användare i denna grupp kan förlora tillgången till tjänsterna.';
        $strings['WhatRolesApplyToThisGroup'] = 'Vilka roller gäller i denna grupp?';
        $strings['WhoCanManageThisGroup'] = 'Vem hanterar denna grupp?';
        $strings['AddGroup'] = 'Lägg till grupp';
        $strings['AllQuotas'] = 'Alla filter';
        $strings['QuotaReminder'] = 'Komihåg: tillämpade filter bygger på schemat \ s tidszon.';
        $strings['AllReservations'] = 'Alla bokningar';
        $strings['PendingReservations'] = 'Ej godkända bokningar';
        $strings['Approving'] = 'Godkänner';
        $strings['MoveToSchedule'] = 'Flytta till kalendern';
        $strings['DeleteResourceWarning'] = 'Tar du bort denna tjänst kommer all tillhörande data tas bort, inklusive';
        $strings['DeleteResourceWarningReservations'] = 'alla tidigare, nuvarande och framtida bokningar associerade med den';
        $strings['DeleteResourceWarningPermissions'] = 'alla behörighetstilldelningar';
        $strings['DeleteResourceWarningReassign'] = 'Vänligen tilldela allt som du inte vill ska tas bort innan du går vidare';
        $strings['ScheduleLayout'] = 'Layout (alla tider %s)';
        $strings['ReservableTimeSlots'] = 'Bokningsbara tidsintervaller';
        $strings['BlockedTimeSlots'] = 'Blockerade tidsintervaller';
        $strings['ThisIsTheDefaultSchedule'] = 'Denna kalendern är förvald';
        $strings['DefaultScheduleCannotBeDeleted'] = 'Den förvalda kalendern kan inte raderas';
        $strings['MakeDefault'] = 'Ange som förvald';
        $strings['BringDown'] = 'Flytta ner';
        $strings['ChangeLayout'] = 'Ändra Layout';
        $strings['AddSchedule'] = 'Lägg till bokningskalender';
        $strings['StartsOn'] = 'Börjar på';
        $strings['NumberOfDaysVisible'] = 'Antal synliga dagar';
        $strings['UseSameLayoutAs'] = 'Använd samma inställningar som';
        $strings['Format'] = 'Format';
        $strings['OptionalLabel'] = 'Valfritt fält';
        $strings['LayoutInstructions'] = 'Lägg till ett tidsintervall per rad.  Tidsintervall måste tilldelas alla 24 timmar på dygnet med början och slut 12.00.';
        $strings['AddUser'] = 'Lägg till användare';
        $strings['UserPermissionInfo'] = 'Faktisk åtkomst till tjänstenen kan variera beroende på användarens roll, grupptillhörighet eller externa behörighetsinställningar';
        $strings['DeleteUserWarning'] = 'Om du raderar den här användaren avlägsnas denna användares samtliga bokningar.';
        $strings['AddAnnouncement'] = 'Lägg till meddelande';
        $strings['Announcement'] = 'Meddelande';
        $strings['Priority'] = 'Prioritet';
        $strings['Reservable'] = 'Bokningsbar';
        $strings['Unreservable'] = 'Ej bokningsbar';
        $strings['Reserved'] = 'Reserverad';
        $strings['MyReservation'] = 'Mina bokningar';
        $strings['Pending'] = 'Avvaktande';
        $strings['Past'] = 'tidigare';
        $strings['Restricted'] = 'Begränsat';
        $strings['ViewAll'] = 'Visa allt';
        $strings['MoveResourcesAndReservations'] = 'Flytta tjänster och bokningar till';
        $strings['TurnOffSubscription'] = 'Stäng av prenumeration på kalendern';
        $strings['TurnOnSubscription'] = 'Tillåt Prenumeration av denna kalender';
        $strings['SubscribeToCalendar'] = 'Prenumerera på denna kalender';
        $strings['SubscriptionsAreDisabled'] = 'Administratören har inaktiverat abonnemang av kalendern';
        $strings['NoResourceAdministratorLabel'] = '(Ingen administratör av tjänst)';
        $strings['WhoCanManageThisResource'] = 'Vem kan hantera denna tjänst?';
        $strings['ResourceAdministrator'] = 'Administratör av tjänst';
        $strings['Private'] = 'Privat';
        $strings['Accept'] = 'Acceptera';
        $strings['Decline'] = 'Avböj';
        $strings['ShowFullWeek'] = 'Visa hel vecka';
        $strings['CustomAttributes'] = 'Eget attribut';
        $strings['AddAttribute'] = 'Lägg till ett attribut';
        $strings['EditAttribute'] = 'Uppdatera attribut';
        $strings['DisplayLabel'] = 'Visa Etikett';
        $strings['Type'] = 'Typ';
        $strings['Required'] = 'Obligatorisk';
        $strings['ValidationExpression'] = 'Validation Expression';
        $strings['PossibleValues'] = 'Möjliga värden';
        $strings['SingleLineTextbox'] = 'Enradig Textbox';
        $strings['MultiLineTextbox'] = 'Flerradig Textbox';
        $strings['Checkbox'] = 'Checkbox';
        $strings['SelectList'] = 'Välj lista';
        $strings['CommaSeparated'] = 'komma separerad';
        $strings['Category'] = 'Kategori';
        $strings['CategoryReservation'] = 'Reservation';
        $strings['CategoryGroup'] = 'Grupp';
        $strings['SortOrder'] = 'Sorteringsordning';
        $strings['Title'] = 'Rubrik';
        $strings['AdditionalAttributes'] = 'Frivilliga uppgifter';
        $strings['True'] = 'Sant';
        $strings['False'] = 'Falskt';
		$strings['NoResultsFound'] = 'Hittade Inga Rapporter';
		$strings['NoSavedReports'] = 'Det finns inga sparade rapporter';
		$strings['GenerateReports'] = 'Skapa Rapport';
		$strings['ForgotPasswordEmailSent'] = 'Ett e-postmeddelande har skickats till er e-postadress med instruktione om hur du återställer ditt lösenord';
		$strings['ActivationEmailSent'] = 'Ett aktiveringsmail har skickats till dig.';
		$strings['AccountActivationError'] = 'Ett problem uppstod vid aktiveringen av ert konto, kontot kunde inte aktiveras. Vänligen försök igen.';
		$strings['Attachments'] = 'Bilaga';
		$strings['AttachFile'] = 'Bifoga fil';
		$strings['Maximum'] = 'Max';
		// End Strings

		// Reports
		$strings['Working'] = 'Arbetar...';
		$strings['Created'] = 'Skapad';
		$strings['ViewAsChart'] = 'Visa som Stapeldiagram';
		$strings['SaveThisReport'] = 'Spara denna Rapport';
		$strings['NoSavedReports'] = 'Inga sparade Rapporter';
		$strings['RunReport'] = 'Kör Rapport';
		$strings['EmailReport'] = 'Skicka Rapport med E-post';
		$strings['Delete'] = 'Ta Bort';
		$strings['Edit'] = 'Ändra';
		$strings['ReservedResources'] = 'Bokade Tjänster';
		$strings['ReservedAccessories'] = 'Bokade Tillbehör';
		$strings['ResourceUsageTimeBooked'] = 'Bokade Tjänster - Bokad Tid';
		$strings['ResourceUsageReservationCount'] = 'Utnyttjade Tjänster - Antal Bokningar';
		$strings['Top20UsersTimeBooked'] = 'Topp 20 Användare - Totalt Bokad Tid';
		$strings['Top20UsersReservationCount'] = 'Topp 20 Användare - Totalt Antal Bokningar';
        // End Strings

        // Errors
        $strings['LoginError'] = 'Användarnamn eller lösenord är felaktigt';
        $strings['ReservationFailed'] = 'Din bokning kunde inte göras';
        $strings['MinNoticeError'] = 'Denna bokning kräver förhandsanmälan. Den första dagen som kan bokas är %s.';
        $strings['MaxNoticeError'] = 'Denna bokning kan inte göras så långt i framtiden. Det senaste datum och tid som kan reserveras är %s.';
        $strings['MinDurationError'] = 'Denna bokning måste vara minst %s.';
        $strings['MaxDurationError'] = 'Denna bokning kan inte vara längre än %s.';
        $strings['ConflictingAccessoryDates'] = 'Det finns inte tillräckligt av följande tillbehör:';
        $strings['NoResourcePermission'] = 'Du har ingen behörighet att komma åt den/dom begärda tjänsten/tjänsterna';
        $strings['ConflictingReservationDates'] = 'Det finns motstridiga reservationer på följande datum:';
        $strings['StartDateBeforeEndDateRule'] = 'Startdatum och tid måste vara före slutdatum och tid';
        $strings['StartIsInPast'] = 'Startdatum och tid kan inte vara i det förflutna';
        $strings['EmailDisabled'] = 'Administratören har inaktiverat e-postmeddelanden';
        $strings['ValidLayoutRequired'] = 'Tidsintervall skall lämnas för alla 24 timmar på dagen med början och slut vid 12:00 .';
        $strings['CustomAttributeErrors'] = 'Ett problem har uppstått med attributet som har angetts:';
        $strings['CustomAttributeRequired'] = '%s är ett obligatoriskt fält';
        $strings['CustomAttributeInvalid'] = 'Värdet du angett får %s är ogiltigt';
        $strings['AttachmentLoadingError'] = 'Ett problem uppstod vid uppladdning av den begärda filen.';
        $strings['InvalidAttachmentExtension'] = 'Du kan endast ladda upp filer av typen: %s';
        // End Errors

        // Page Titles
        $strings['CreateReservation'] = 'Bokning';
        $strings['EditReservation'] = 'Ändra bokning';
        $strings['LogIn'] = 'Inloggning';
        $strings['ManageReservations'] = 'Bokningar';
        $strings['AwaitingActivation'] = 'Avvaktar aktivering';
        $strings['PendingApproval'] = 'Avvaktar godkännande';
        $strings['ManageSchedules'] = 'Kalender';
        $strings['ManageResources'] = 'Tjänster';
        $strings['ManageAccessories'] = 'Tillbehör';
        $strings['ManageUsers'] = 'Användare';
        $strings['ManageGroups'] = 'Grupper';
        $strings['ManageQuotas'] = 'Filter';
        $strings['ManageBlackouts'] = 'Blockerade tider';
        $strings['MyDashboard'] = 'Min anslagstavla';
        $strings['ServerSettings'] = 'Serverinställningar';
        $strings['Dashboard'] = 'Anslagstavla';
        $strings['Help'] = 'Hjälp';
        $strings['Bookings'] = 'Bokningar';
        $strings['Schedule'] = 'Kalender';
        $strings['Reservations'] = 'Reservering';
        $strings['Account'] = 'Konto';
        $strings['EditProfile'] = 'Ändra profil';
        $strings['FindAnOpening'] = 'Hitta en öppning';
        $strings['OpenInvitations'] = 'Inbjudan';
        $strings['MyCalendar'] = 'Min kalender';
        $strings['ResourceCalendar'] = 'Tjänstekalender';
        $strings['Reservation'] = 'Bokning';
        $strings['Install'] = 'Installation';
        $strings['ChangePassword'] = 'Ändra lösenord';
        $strings['MyAccount'] = 'Mitt konto';
        $strings['Profile'] = 'Ändra profil';
        $strings['ApplicationManagement'] = 'Administration';
        $strings['ForgotPassword'] = 'Glömt lösenordet';
        $strings['NotificationPreferences'] = 'Meddelande inställning';
        $strings['ManageAnnouncements'] = 'Meddelande';
        $strings['Responsibilities'] = 'Ansvar';
        $strings['GroupReservations'] = 'Gruppbokning';
        $strings['ResourceReservations'] = 'Bokning av Tjänst';
        $strings['Customization'] = 'Anpassningar';
        $strings['Attributes'] = 'Attribut';
		$strings['AccountActivation'] = 'Aktivering av konto';
		$strings['Reports'] = 'Rapporter';
		$strings['GenerateReport'] = 'Skapa ny rapport';
		$strings['CommonReports'] = 'Vanligaste Rapporterna';
		$strings['MySavedReports'] = 'Mina sparade rapporter';
		$strings['About'] = 'Om';
		$strings['hours'] = 'timmar';
        // End Page Titles

        // Day representations
        $strings['DaySundaySingle'] = 'S';
        $strings['DayMondaySingle'] = 'M';
        $strings['DayTuesdaySingle'] = 'T';
        $strings['DayWednesdaySingle'] = 'O';
        $strings['DayThursdaySingle'] = 'T';
        $strings['DayFridaySingle'] = 'F';
        $strings['DaySaturdaySingle'] = 'L';

        $strings['DaySundayAbbr'] = 'Sön';
        $strings['DayMondayAbbr'] = 'Mån';

        $strings['DayTuesdayAbbr'] = 'Tis';
        $strings['DayWednesdayAbbr'] = 'Ons';
        $strings['DayThursdayAbbr'] = 'Tor';
        $strings['DayFridayAbbr'] = 'Fre';
        $strings['DaySaturdayAbbr'] = 'Lör';
		// End Day representations

        // Email Subjects
        $strings['ReservationApprovedSubject'] = 'Bokning har blivit godkänd';
        $strings['ReservationCreatedSubject'] = 'Bokning har skapats';
        $strings['ReservationUpdatedSubject'] = 'Bokning har uppdaterats';
        $strings['ReservationDeletedSubject'] = 'Bokning har tagits bort';
        $strings['ReservationCreatedAdminSubject'] = 'Underrättelse: En bokning har gjorts';
        $strings['ReservationUpdatedAdminSubject'] = 'Underrättelse: En bokning har uppdaterats';
        $strings['ReservationDeleteAdminSubject'] = 'Underrättelse: En bokning har uppdaterats';
        $strings['ParticipantAddedSubject'] = 'Underrättelse om bokningsdeltagande';
        $strings['ParticipantDeletedSubject'] = 'Bokning borttagen';
        $strings['InviteeAddedSubject'] = 'Bokningsinbjudan';
        $strings['ResetPassword'] = 'Återställningsbegäran av lösenord';
        $strings['ActivateYourAccount'] = 'Var vänlig och aktivera ert konto';
        // End Email Subjects

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
         $days['full'] = array('Söndag', 'Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lördag');
        // The three letter abbreviation
        $days['abbr'] = array('Sön', 'Mån', 'Tis', 'Ons', 'Tor', 'Fre', 'Lör');
        // The two letter abbreviation
        $days['two'] = array('Sö', 'Må', 'Ti', 'On', 'To', 'Fr', 'Lö');
        // The one letter abbreviation
        $days['letter'] = array('S', 'M', 'T', 'O', 'T', 'F', 'L');

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
        $months['full'] = array('Januari', 'Februari', 'Mars', 'April', 'Maj', 'Juni', 'Juli', 'Augusti', 'September', 'Oktober', 'November', 'December');
        // The three letter month name
        $months['abbr'] = array('Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec');

        $this->Months = $months;
    }

    protected function _LoadLetters()
    {
        $this->Letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    }

    protected function _GetHtmlLangCode()
    {
        return 'sv';
    }
}

?>