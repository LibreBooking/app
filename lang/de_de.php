<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once('Language.php');

class de_de extends en_us
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return array
     */
    protected function _LoadDates()
    {
		$dates = parent::_LoadDates();

        $dates['general_date'] = 'd.m.Y';
        $dates['general_datetime'] = 'd.m.Y H:i:s';
        $dates['schedule_daily'] = 'l, d.m.Y';
        $dates['reservation_email'] = 'd.m.Y @ H:i (e)';
        $dates['res_popup'] = 'd.m.Y H:i';
        $dates['dashboard'] = 'l, d.m.Y H:i';
        $dates['period_time'] = 'H:i';
                $dates['general_date_js'] = 'dd.mm.yy';
                $dates['calendar_time'] = 'H:mm';
                $dates['calendar_dates'] = 'd.M';
                                                                                
        $this->Dates = $dates;

        return $this->Dates;
    }

    /**
     * @return array
     */
    protected function _LoadStrings()
    {
		$strings = parent::_LoadStrings();

        $strings['FirstName'] = 'Vorname';
        $strings['LastName'] = 'Nachname';
        $strings['Timezone'] = 'Zeitzone';
        $strings['Edit'] = 'Bearbeiten';
        $strings['Change'] = '&Auml;ndern';
        $strings['Rename'] = 'Umbenennen';
        $strings['Remove'] = 'L&ouml;schen';
        $strings['Delete'] = 'L&ouml;schen';
        $strings['Update'] = 'Update';
        $strings['Cancel'] = 'Abbrechen';
        $strings['Add'] = 'Hinzuf&uuml;gen';
        $strings['Name'] = 'Name';
        $strings['Yes'] = 'Ja';
        $strings['No'] = 'Nein';
        $strings['FirstNameRequired'] = 'Vorname wird ben&ouml;tigt.';
        $strings['LastNameRequired'] = 'Nachname wird ben&ouml;tigt.';
        $strings['PwMustMatch'] = 'Kennw&ouml;rter m&uuml;ssen &uuml;bereinstimmen.';
        $strings['PwComplexity'] = 'Das Kennwort muss mindestens 6 STellen besitzen und aus Buchstaben, Zahlen und Symbolen bestehen.';
        $strings['ValidEmailRequired'] = 'Emailadresse wird ben&ouml;tigt.';
        $strings['UniqueEmailRequired'] = 'Diese Emailadresse wurde bereits verwendet.';
        $strings['UniqueUsernameRequired'] = 'Diese Benutzername wird bereits verwendet.';
        $strings['UserNameRequired'] = 'Benutzername wird ben&ouml;tigt.';
        $strings['CaptchaMustMatch'] = 'Bitte die Sicherheitsabfrage korrekt beantworten.';
        $strings['Today'] = 'Heute';
        $strings['Week'] = 'Woche';
        $strings['Month'] = 'Monat';
        $strings['BackToCalendar'] = 'Zur&uuml;ck zum Kalender';
        $strings['BeginDate'] = 'Beginn';
        $strings['EndDate'] = 'Ende';
        $strings['Username'] = 'Benutzername';
        $strings['Password'] = 'Passwort';
        $strings['PasswordConfirmation'] = 'Passwort wiederholen';
        $strings['DefaultPage'] = 'Standard Satrtseite';
        $strings['MyCalendar'] = 'Mein Kalender';
        $strings['ScheduleCalendar'] = 'zeitplan Kalender';
        $strings['Registration'] = 'Registrierung';
        $strings['NoAnnouncements'] = 'Keine Ank&uuml;ndigungen';
        $strings['Announcements'] = 'Ank&uuml;ndigungen';
        $strings['NoUpcomingReservations'] = 'Sie haben keine aktuellen Reservierungen.';
        $strings['UpcomingReservations'] = 'Aktuelle Reservierungen';
        $strings['ShowHide'] = 'Einblenden/Ausblenden';
        $strings['Error'] = 'Fehler';
        $strings['ReturnToPreviousPage'] = 'Zur&uuml;ck zur vorigen Seite';
        $strings['UnknownError'] = 'Unbekannter Fehler';
        $strings['InsufficientPermissionsError'] = 'Sie d&uuml;rfen diese Ressource nicht ausleihen.';
        $strings['MissingReservationRessourceError'] = 'Keine Ressource ausgew&auml;hlt';
        $strings['MissingReservationScheduleError'] = 'Kein Plan ausgew&auml;hlt';
        $strings['DoesNotRepeat'] = 'Nicht wiederholend';
        $strings['Daily'] = 'T&auml;glich';
        $strings['Weekly'] = 'W&ouml;chentlich';
        $strings['Monthly'] = 'Monatlich';
        $strings['Yearly'] = 'J&auml;hrlich';
        $strings['RepeatPrompt'] = 'Wiederholen';
        $strings['hours'] = 'Stunden';
        $strings['days'] = 'Tage';
        $strings['weeks'] = 'Wochen';
        $strings['months'] = 'Monate';
        $strings['years'] = 'Jahre';
        $strings['day'] = 'Tag';
        $strings['week'] = 'Woche';
        $strings['month'] = 'Monat';
        $strings['year'] = 'Jahr';
        $strings['repeatDayOfMonth'] = 'Tag im Monat';
        $strings['repeatDayOfWeek'] = 'Tag in Woche';
        $strings['RepeatUntilPrompt'] = 'Bis';
        $strings['RepeatEveryPrompt'] = 'Jeden';
        $strings['RepeatDaysPrompt'] = 'Ja';
        $strings['CreateReservationHeading'] = 'Neue Reservierung';
        $strings['EditReservationHeading'] = 'Reservierung %s bearbeiten';
        $strings['ViewReservationHeading'] = 'Reservierung %s anzeigen';
        $strings['ReservationErrors'] = 'Reservierung &auml;ndern';
        $strings['Create'] = 'Anlegen';
        $strings['ThisInstance'] = 'In dieser Instanz';
        $strings['AllInstances'] = 'Alle Instanzen';
        $strings['FutureInstances'] = 'Zuk&uuml;nftige Instanzen';
        $strings['Print'] = 'Drucken';
        $strings['ShowHideNavigation'] = 'Navigation Einblenden/Ausblenden';
        $strings['ReferenceNumber'] = 'Referenznummer';
        $strings['Tomorrow'] = 'Morgen';
        $strings['LaterThisWeek'] = 'Sp&auml;ter diese Woche';
        $strings['NextWeek'] = 'N&auml;chste Woche';
        $strings['SignOut'] = 'Abmelden';
        $strings['LayoutDescription'] = 'Beginnend %s, zeige %s Tage';
        $strings['AllResources'] = 'Alle Ressourcen';
        $strings['TakeOffline'] = 'Offline gehen';
        $strings['BringOnline'] = 'Online gehen';
        $strings['AddImage'] = 'Bild hinzuf&uuml;gen';
        $strings['NoImage'] = 'Kein Bild zugewiesen';
        $strings['Move'] = 'Verschieben';
        $strings['AppearsOn'] = 'Erscheint an %s';
        $strings['Location'] = 'Position';
        $strings['NoLocationLabel'] = '(keine Position gesetzt)';
        $strings['Contact'] = 'Kontakt';
        $strings['NoContactLabel'] = '(keine Kontaktinformationen)';
        $strings['Description'] = 'Beschreibung';
        $strings['NoDescriptionLabel'] = '(keine Beschreibung)';
        $strings['Notes'] = 'Notizen';
        $strings['NoNotesLabel'] = '(keine Notizen)';
        $strings['NoTitleLabel'] = '(kein Titel)';
        $strings['UsageConfiguration'] = 'Gebrauchskonfiguration';
        $strings['ChangeConfiguration'] = 'Konfiguration &auml;ndern';
        $strings['ResourceMinLength'] = 'Reservierung muss mindestens %s dauern';
        $strings['ResourceMinLengthNone'] = 'Es gibt keine minimale Reservierungsdauer';
        $strings['ResourceMaxLength'] = 'Reservierungen d&uuml;rfen nicht l&auml;nger als %s dauern';
        $strings['ResourceMaxLengthNone'] = 'Es gibt keine maximale Reservierungsdauer';
        $strings['ResourceRequiresApproval'] = 'Reservierungen m&uuml;ssen best&auml;tigt werden';
        $strings['ResourceRequiresApprovalNone'] = 'Reservierungen m&uuml;ssen nicht best&auml;tigt werden';
        $strings['ResourcePermissionAutoGranted'] = 'Berechtigung wird automatisch gew&auml;hrt';
        $strings['ResourcePermissionNotAutoGranted'] = 'Berechtigung wird nicht automatisch gew&auml;hrt';
        $strings['ResourceMinNotice'] = 'Reservierungen m&uuml;ssen mindestens %s vor der Startzeit get&auml;tigt werden';
        $strings['ResourceMinNoticeNone'] = 'Reservierungen k&ouml;nnen ohne Vorlaufzeit get&auml;tigt werden';
        $strings['ResourceMaxNotice'] = 'Reservierungen d&uuml;rfen nicht %s vor der aktuellen Zeit enden';
        $strings['ResourceMaxNoticeNone'] = 'Reservierungen k&ouml;nne zu jeder Zeit enden';
        $strings['ResourceAllowMultiDay'] = 'Reservierungen k&ouml;nnen sich &uuml;ber mehrere Tage erstrecken';
        $strings['ResourceNotAllowMultiDay'] = 'Reservierungen d&uuml;rfen sich nicht &uuml;ber mehrere Tage erstrecken';
        $strings['ResourceCapacity'] = 'Diese Ressource hat eine Kapazit&auml;t von %s Personen';
        $strings['ResourceCapacityNone'] = 'Diese Ressource hat unlimitierte Kapazit&auml;t';
        $strings['AddNewResource'] = 'Neue Ressource hinzuf&uuml;gen';
        $strings['AddNewUser'] = 'Neuen Benutzer hinzuf&uuml;gen';
        $strings['AddUser'] = 'Benutzer hinzuf&uuml;gen';
        $strings['Schedule'] = 'Zeitplan';
        $strings['AddResource'] = 'Ressource hinzuf&uuml;gen';
        $strings['Capacity'] = 'Kapazit&auml;t';
        $strings['Access'] = 'Zugriff';
        $strings['Duration'] = 'Dauer';
        $strings['Active'] = 'Aktiv';
        $strings['Inactive'] = 'Inaktiv';
        $strings['LastLogin'] = 'Letzter Login';
        $strings['Search'] = 'Suchen';
        $strings['ResourcePermissions'] = 'Ressourcen Berechtigungen';
        $strings['Reservations'] = 'Reservierungen';
        $strings['Groups'] = 'Gruppen';
        $strings['ResetPassword'] = 'Reset Passwort';
        $strings['AllUsers'] = 'Alle Benutzer';
        $strings['AllGroups'] = 'Alle Gruppen';
        $strings['AllSchedules'] = 'Alle Zeitpl&auml;ne';
        $strings['UsernameOrEmail'] = 'Benutzername oder Email';
        $strings['Members'] = 'Mitglieder';
        $strings['QuickSlotCreation'] = 'Erzeuge Zeitschlitze alle %s Minuten zwischen %s und %s';
        $strings['ApplyUpdatesTo'] = 'Updates anwenden';
        $strings['CancelParticipation'] = 'Teilnahme beenden';
        $strings['Attending'] = 'Teilnahme';
        $strings['QuotaConfiguration'] = 'Bei %s f&uuml;r %s Benutzer in %s sind limitiert auf %s %s pro %s';
        $strings['reservations'] = 'Reservierungen';
        $strings['ChangeCalendar'] = 'Kalender &auml;ndern';
        $strings['AddQuota'] = 'Quota hinzuf&uuml;gen';
        $strings['FindUser'] = 'Benutzer finden';
        $strings['Created'] = 'Erzeugt';
        $strings['LastModified'] = 'Zuletzt ge&auml;ndert';
        $strings['GroupName'] = 'Gruppen Name';
        $strings['GroupMembers'] = 'Gruppe Mitglied';
        $strings['GroupRoles'] = 'Gruppe Rollen';
        $strings['GroupAdmin'] = 'Gruppe Administrator';
        $strings['Actions'] = 'Aktionen';
        $strings['CurrentPassword'] = 'Aktuelles Kennwort';
        $strings['NewPassword'] = 'Neues Kennwort';
        $strings['InvalidPassword'] = 'Das Kennwort ist falsch';
        $strings['PasswordChangedSuccessfully'] = 'Das Kennwort wurde ge&auml;ndert';
        $strings['SignedInAs'] = 'Eingeloggt als';
        $strings['NotSignedIn'] = 'Sie sind nicht angemeldet';
        $strings['ReservationTitle'] = 'Titel der Reservierung';
        $strings['ReservationDescription'] = 'Beschreibung der Reservierung';
        $strings['ResourceList'] = 'Zu reservierende Ressourcen';
        $strings['Accessories'] = 'Zubeh&ouml;r';
        $strings['Add'] = 'Hinzuf&uuml;gen';
        $strings['ParticipantList'] = 'Teilnehmer';
        $strings['InvitationList'] = 'Eingeladene';
        $strings['AccessoryName'] = 'Zubeh&ouml;r Name';
        $strings['QuantityAvailable'] = 'Verf&uuml;gbare Menge';
        $strings['Resources'] = 'Ressourcen';
        $strings['Participants'] = 'Teilnehmer';
        $strings['User'] = 'Benutzer';
        $strings['Resource'] = 'Ressource';
        $strings['Status'] = 'Status';
        $strings['Approve'] = 'Freigeben';
        $strings['Page'] = 'Seite';
        $strings['Rows'] = 'Zeilen';
        $strings['Unlimited'] = 'Unlimitiert';
        $strings['Email'] = 'Email';
        $strings['EmailAddress'] = 'Email Addresse';
        $strings['Phone'] = 'Telefon';
        $strings['Organization'] = 'Organisation';
        $strings['Position'] = 'Position';
        $strings['Language'] = 'Sprache';
        $strings['Permissions'] = 'Berechtigungen';
        $strings['Reset'] = 'Reset';
        $strings['FindGroup'] = 'Gruppe finden';
        $strings['Manage'] = 'Verwalten';
        $strings['None'] = 'Nichts';
        $strings['AddToOutlook'] = 'Zu Outlook hinzuf&uuml;gen';
        $strings['Done'] = 'Erledigt';
        $strings['RememberMe'] = 'Merke mich';
        $strings['FirstTimeUser?'] = 'Neuer Benutzer?';
        $strings['CreateAnAccount'] = 'Account hinzuf&uuml;gen';
        $strings['ViewSchedule'] = 'Zeitplan ansehen';
        $strings['ForgotMyPassword'] = 'Kennwort vergessen';
        $strings['YouWillBeEmailedANewPassword'] = 'Sie bekommen ein neues, zuf&auml;lliges Kennwort zugeschickt';
        $strings['Close'] = 'Schliessen';
        $strings['ExportToCSV'] = 'Export zu CSV';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'Arbeite';
        $strings['Login'] = 'Login';
        $strings['AdditionalInformation'] = 'Zus&auml;tzliche Informationen';
        $strings['AllFieldsAreRequired'] = 'Alle Felder werden ben&ouml;tigt';
        $strings['Optional'] = 'optional';
        $strings['YourProfileWasUpdated'] = 'Ihr Profil wurde aktualisiert';
        $strings['YourSettingsWereUpdated'] = 'Ihre Einstellungen wurden aktualisiert';
        $strings['Register'] = 'Registrieren';
        $strings['SecurityCode'] = 'Sicherheitscode';
        $strings['ReservationCreatedPreference'] = 'Wenn ich eine Reservierung t&auml;tige oder eine Reservierung in meinem Auftrag get&auml;tigt wird';
        $strings['ReservationUpdatedPreference'] = 'Wenn ich eine Reservierung aktualisiere oder eine Reservierung in meinem Auftrag aktualisiert wird';
        $strings['ReservationDeletedPreference'] = 'Wenn ich eine Reservierung l&ouml;sche oder eine Reservierung in meinem Auftrag gel&ouml;scht wird';
        $strings['ReservationApprovalPreference'] = 'Wenn meine bevorstehende Reservierung freigegeben wird';
        $strings['PreferenceSendEmail'] = 'Email senden';
        $strings['PreferenceNoEmail'] = 'Mich nicht informieren';
        $strings['ReservationCreated'] = 'Ihre Reservierung wurde erfolgreich angelegt!';
        $strings['ReservationUpdated'] = 'Ihre Reservierung wurde erfolgreich aktualisiert!';
        $strings['ReservationRemoved'] = 'Ihre Reservierung wurde erfolgreich gel&ouml;scht';
        $strings['YourReferenceNumber'] = 'Ihre Referenznummer ist %s';
        $strings['UpdatingReservation'] = 'Aktualisiere Reservierung';
        $strings['ChangeUser'] = 'Benutzer &auml;ndern';
        $strings['MoreResources'] = 'Weitere Ressourcen';
        $strings['ReservationLength'] = 'Reservierungsl&auml;nge';
        $strings['ParticipantList'] = 'Teilnehmerliste';
        $strings['AddParticipants'] = 'Teilnehmer hinzuf&uuml;gen';
        $strings['InviteOthers'] = 'Weitere einladen';
        $strings['AddResources'] = 'Ressourcen hinzuf&uuml;gen';
        $strings['AddAccessories'] = 'Zubeh&ouml;r hinzuf&uuml;gen';
        $strings['Accessory'] = 'Zubeh&ouml;r';
        $strings['QuantityRequested'] = 'Menge angefordert';
        $strings['CreatingReservation'] = 'Lege Reservierung an';
        $strings['UpdatingReservation'] = 'Aktualisiere Reservierung';
        $strings['DeleteWarning'] = 'Diese Aktion kann nicht r&uuml;ckg&auml;ngig gemacht werden!';
        $strings['DeleteAccessoryWarning'] = 'Beim l&ouml;schen wird diese Zubeh&ouml;r auch aus s&auml;mtlichen Reservierungen gel&ouml;scht.';
        $strings['AddAccessory'] = 'Zubeh&ouml;r hinzuf&uuml;gen';
        $strings['AddBlackout'] = 'Sperrzeit hinzuf&uuml;gen';
        $strings['AllResourcesOn'] = 'Alle Ressourcen Ein';
        $strings['Reason'] = 'Grund';
        $strings['BlackoutShowMe'] = 'Zeige in Konflikt stehende Reservierungen';
        $strings['BlackoutDeleteConflicts'] = 'L&ouml;sche in Konflikt stehende Reservierungen';
        $strings['Filter'] = 'Filter';
        $strings['Between'] = 'Zwischen';
        $strings['CreatedBy'] = 'Erzeugt von';
        $strings['BlackoutCreated'] = 'Sperrzeit angelegt!';
        $strings['BlackoutNotCreated'] = 'Sperrzeit konnte nicht angelegt werden!';
        $strings['BlackoutConflicts'] = 'Sperrzeiten stehen im Konflikt zueinander';
        $strings['ReservationConflicts'] = 'Reservierungszeiten stehen im Konflikt zueinander';
        $strings['UsersInGroup'] = 'Benutzer in dieser Gruppe';
        $strings['Browse'] = 'Durchsuchen';
        $strings['DeleteGroupWarning'] = 'Beim l&ouml;schen dieser Gruppe werden alle verkn&uuml;pften Berechtigungen gel&ouml;scht.  Benutzer in dieser Gruppe werden die Berechtigungen zu den Ressourcen verlieren.';
        $strings['WhatRolesApplyToThisGroup'] = 'Welche Rollen sollen der Gruppe zugewiesen werden?';
        $strings['WhoCanManageThisGroup'] = 'Wer darf diese Gruppe verwalten?';
        $strings['AddGroup'] = 'Gruppe hinzuf&uuml;gen';
        $strings['AllQuotas'] = 'Alle Quotas';
        $strings['QuotaReminder'] = 'Beachte: Quotas werden basierend auf der Zeitzone des Zeitplans erzwungen';
        $strings['AllReservations'] = 'Alle Reservierungen';
        $strings['PendingReservations'] = 'Anstehende Reservierungen';
        $strings['Approving'] = 'Anerkennen';
        $strings['MoveToSchedule'] = 'Zum Zeitplan verschieben';
        $strings['DeleteResourceWarning'] = 'Beim l&ouml;schen dieser Ressource werden alle verkn&uuml;pften Daten gel&ouml;scht, inklusive';
        $strings['DeleteResourceWarningReservations'] = 'alle in Verbindung stehenden Reservierungen';
        $strings['DeleteResourceWarningPermissions'] = 'alle zugewiesenen Berechtigungen';
        $strings['DeleteResourceWarningReassign'] = 'Bitte alles erneut hinzuf&uuml;gen, was nicht gel&ouml;scht werden soll';
        $strings['ScheduleLayout'] = 'Layout (Alle Zeiten %s)';
        $strings['ReservableTimeSlots'] = 'Buchbare Zeitschlitze';
        $strings['BlockedTimeSlots'] = 'Geblockte Zeitschlitze';
        $strings['ThisIsTheDefaultSchedule'] = 'Dies ist der Standard Zeitplan';
        $strings['DefaultScheduleCannotBeDeleted'] = 'Der Standard Zeitplan kann nicht gel&ouml;scht werden';
        $strings['MakeDefault'] = 'Als Standard';
        $strings['BringDown'] = 'Nach Unten';
        $strings['ChangeLayout'] = 'Layout &auml;ndern';
        $strings['AddSchedule'] = 'Zeitplan hinzuf&uuml;gen';
        $strings['StartsOn'] = 'Beginnt um';
        $strings['NumberOfDaysVisible'] = 'Anzahl der sichtbaren Tage';
        $strings['UseSameLayoutAs'] = 'Gleiches Layout verwenden wie';
        $strings['Format'] = 'Format';
        $strings['OptionalLabel'] = 'Optionales Etikett';
        $strings['LayoutInstructions'] = 'Gebe einen Zeitschlitz pro Zeile ein. Zeitschlitze m&uuml;ssen f&uuml;r alle 24 Stunden eines Tages vorgegeben werden, von und bis 0 Uhr.';
        $strings['AddUser'] = 'Benutzer hinzuf&uuml;gen';
        $strings['UserPermissionInfo'] = 'Aktueller Zugriff zur Ressource unterscheidet sich in AAbh&auml;ngigkeit der Benutzerrolle, der Gruppenberechtigungen oder externer Zugriffseinstellungen';
        $strings['DeleteUserWarning'] = 'Das L&ouml;schen des Benutzers f&uuml;hrt auch zum Entfernen seiner momentanen, zuk&uuml;nftigen und vergangenen Reservierungen.';
        $strings['AddAnnouncement'] = 'Ank&uuml;ndigung hinzuf&uuml;gen';
        $strings['Announcement'] = 'Ank&uuml;ndigung';
        $strings['Priority'] = 'Priorit&auml;t';
        $strings['Reservable'] = 'reservierbar';
        $strings['Unreservable'] = 'nicht reservierbar';
        $strings['Reserved'] = 'reserviert';
        $strings['MyReservation'] = 'Meine Reservierung';
        $strings['Pending'] = 'Unbestätigt';
        $strings['Past'] = 'Vergangen';
        $strings['Restricted'] = 'Beschr&auml;nkt';
        $strings['ViewAll'] = 'Alle anzeigen';
        $strings['MoveResourcesAndReservations'] = 'Ressourcen und Reservierungen verschieben nach';
        $strings['TurnOffSubscription'] = 'Kalender Abonnement abschalten';
        $strings['TurnOnSubscription'] = 'Kalender Abonnement erlauben';
        $strings['SubscribeToCalendar'] = 'Kalender abonnieren';
        $strings['SubscriptionsAreDisabled'] = 'Das abonnieren des Kalenders wurde vom Administrator deaktiviert';
        $strings['NoResourceAdministratorLabel'] = '(Kein Ressourcen Administrator)';
        $strings['WhoCanManageThisResource'] = 'Wer darf diese Ressource verwalten?';
        $strings['ResourceAdministrator'] = 'Ressourcen Administrator';
        $strings['Private'] = 'Privat';
        $strings['Accept'] = 'Akzeptieren';
        $strings['Decline'] = 'Ablehnen';
        $strings['ShowFullWeek'] = 'Ganze Woche anzeigen';
        // End Strings

        // Errors
        $strings['LoginError'] = 'Benutzername oder Kennwort falsch';
        $strings['ReservationFailed'] = 'Ihre Reservierung konnte nicht angelegt werden';
        $strings['MinNoticeError'] = 'Diese Reservierung ben&ouml;tigt eine Vorank&uuml;ndigung. Der fr&uuml;heste zu reservierende Zeitpunkt ist %s.';
        $strings['MaxNoticeError'] = 'Die Reservierung liegt zu weit in der Zukunft. Der sp&auml;teste Zeitpunkt ist %s.';
        $strings['MinDurationError'] = 'Diese Reservierung muss mindestens %s dauern.';
        $strings['MaxDurationError'] = 'Diese Reservierung kann nicht l&auml;nger als %s dauern.';
        $strings['ConflictingAccessoryDates'] = 'Es gibt nicht genug der folgenden Zubeh&ouml;rteile:';
        $strings['NoResourcePermission'] = 'Sie haben keine Berechtigung f&uuml;r eine oder mehrere der angefragten Ressourcen';
        $strings['ConflictingReservationDates'] = 'Es gibt in Konflikt stehende Reservierungen an folgenden Tagen:';
        $strings['StartDateBeforeEndDateRule'] = 'Der Startzeitpunkt muss vor dem Endzeitpunkt liegen';
        $strings['StartIsInPast'] = 'Der Startzeitpunkt darf nicht in der Vergangenheit liegen';
        $strings['EmailDisabled'] = 'Emailbenachrichtigngen wurden vom Administrator deaktiviert';
        $strings['ValidLayoutRequired'] = 'Zeitschlitze m&uuml;ssen f&uuml;r alle 24 Stunden eines Tages vorgegeben werden, von und bis 0 Uhr.';
        // End Errors

        // Page Titles
        $strings['CreateReservation'] = 'Reservierung anlegen';
        $strings['EditReservation'] = 'Reservierung bearbeiten';
        $strings['LogIn'] = 'Einloggen';
        $strings['ManageReservations'] = 'Reservierungen';
        $strings['AwaitingActivation'] = 'Erwarte Aktivierung';
        $strings['PendingApproval'] = 'Ausstehende Genehmigung';
        $strings['ManageSchedules'] = 'Zeitpl&auml;ne';
        $strings['ManageResources'] = 'Ressourcen';
        $strings['ManageAccessories'] = 'Zubeh&ouml;r';
        $strings['ManageUsers'] = 'Benutzer';
        $strings['ManageGroups'] = 'Gruppen';
        $strings['ManageQuotas'] = 'Quotas';
        $strings['ManageBlackouts'] = 'Zeiten ausblenden';
        $strings['MyDashboard'] = 'Meine &Uuml;bersicht';
        $strings['ServerSettings'] = 'Server Einstellungen';
        $strings['Dashboard'] = '&Uuml;bersicht';
        $strings['Help'] = 'Hilfe';
        $strings['Bookings'] = 'Buchungen';
        $strings['Schedule'] = 'Zeitplan';
        $strings['Reservations'] = 'Reservierungen';
        $strings['Account'] = 'Account';
        $strings['EditProfile'] = 'Mein Profil bearbeiten';
        $strings['FindAnOpening'] = 'Einen Anfang finden';
        $strings['OpenInvitations'] = '&Ouml;ffne Einladungen';
        $strings['MyCalendar'] = 'Mein Kalender';
        $strings['ResourceCalendar'] = 'Ressourcen Kalender';
        $strings['Reservation'] = 'Neue Reservierung';
        $strings['Install'] = 'Installation';
        $strings['ChangePassword'] = 'Kennwort &auml;ndern';
        $strings['MyAccount'] = 'Mein Account';
        $strings['Profile'] = 'Profil';
        $strings['ApplicationManagement'] = 'Anwendungsverwaltung';
        $strings['ForgotPassword'] = 'Kennwort vergessen';
        $strings['NotificationPreferences'] = 'Benachrichtigungseinstellungen';
        $strings['ManageAnnouncements'] = 'Ank&uuml;ndigungen';
        $strings['Responsibilities'] = 'Zust&auml;ndigkeiten';
        $strings['GroupReservations'] = 'Gruppenreservierungen';
        $strings['ResourceReservations'] = 'Ressourcen Reservierungen';
        // End Page Titles

        // Day representations
        $strings['DaySundaySingle'] = 'S';
        $strings['DayMondaySingle'] = 'M';
        $strings['DayTuesdaySingle'] = 'D';
        $strings['DayWednesdaySingle'] = 'M';
        $strings['DayThursdaySingle'] = 'D';
        $strings['DayFridaySingle'] = 'F';
        $strings['DaySaturdaySingle'] = 'S';

        $strings['DaySundayAbbr'] = 'So';
        $strings['DayMondayAbbr'] = 'Mo';
        $strings['DayTuesdayAbbr'] = 'Di';
        $strings['DayWednesdayAbbr'] = 'Mi';
        $strings['DayThursdayAbbr'] = 'Do';
        $strings['DayFridayAbbr'] = 'Fr';
        $strings['DaySaturdayAbbr'] = 'Sa';

        // Email Subjects
        $strings['ReservationApprovedSubject'] = 'Ihre Reservierung wurde genehmigt';
        $strings['ReservationCreatedSubject'] = 'Ihre Reservierung wurde angelegt';
        $strings['ReservationUpdatedSubject'] = 'Ihre Reservierung wurde aktualisiert';
        $strings['ReservationDeletedSubject'] = 'Ihre Reservierung wurde gel&ouml;scht';
        $strings['ReservationCreatedAdminSubject'] = 'Benachrichtigung: Eine Reservierung wurde angelegt';
        $strings['ReservationUpdatedAdminSubject'] = 'Benachrichtigung: Eine Reservierung wurde aktualisiert';
        $strings['ReservationDeleteAdminSubject'] = 'Benachrichtigung: Eine Reservierung wurde gel&ouml;scht';
        $strings['ParticipantAddedSubject'] = 'Reservierung Teilnahme Benachrichtigung';
        $strings['ParticipantDeletedSubject'] = 'Reservierung gel&ouml;scht';
        $strings['InviteeAddedSubject'] = 'Reservierungs Einladung';
        $strings['ResetPassword'] = 'Kennwort zur&uuml;cksetzen Anfrage';
        $strings['ForgotPasswordEmailSent'] = 'Eine Email mit der Vorgehensweise zum Zur&uuml;cksetzen des Kennworts wurde an die angegebene Adresse geschickt';
        //

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
        $days['full'] = array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag');
        // The three letter abbreviation
        $days['abbr'] = array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa');
        // The two letter abbreviation
        $days['two'] = array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa');
        // The one letter abbreviation
        $days['letter'] = array('S', 'M', 'D', 'M', 'D', 'F', 'S');

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
        $months['full'] = array('Januar', 'Februar', 'M&auml;rz', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');
        // The three letter month name
        $months['abbr'] = array('Jan', 'Feb', 'Mrz', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez');

        $this->Months = $months;

        return $this->Months;
    }

    /**
     * @return array
     */
    protected function _LoadLetters()
    {
        $this->Letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        return $this->Letters;
    }

    protected function _GetHtmlLangCode()
    {
        return 'de';
    }
}

?>