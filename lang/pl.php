<?php
/**
Copyright 2011-2020 Nick Korbel
Translated to Polish by Dariusz Kliszewski

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

class pl extends en_gb
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

        $strings['FirstName'] = 'Imię';
        $strings['LastName'] = 'Nazwisko';
        $strings['Timezone'] = 'Strefa czasowa';
        $strings['Edit'] = 'Edycja';
        $strings['Change'] = 'Zmień';
        $strings['Rename'] = 'Zmień nazwę';
        $strings['Remove'] = 'Usuń';
        $strings['Delete'] = 'Skasuj';
        $strings['Update'] = 'Aktualizuj';
        $strings['Cancel'] = 'Anuluj';
        $strings['Add'] = 'Dodaj';
        $strings['Name'] = 'Nazwa';
        $strings['Yes'] = 'Tak';
        $strings['No'] = 'Nie';
        $strings['FirstNameRequired'] = 'Wymagane jest imię.';
        $strings['LastNameRequired'] = 'Wymagane jest nazwisko.';
        $strings['PwMustMatch'] = 'Hasło potwierdzające musi być identyczne.';
        $strings['PwComplexity'] = 'Hasło musi mieć co najmniej 6 znaków, w tym małe i duże litery oraz cyfry.';
        $strings['ValidEmailRequired'] = 'Wymagany poprawny adres mailowy.';
        $strings['UniqueEmailRequired'] = 'Wybrany adres mailowy już istnieje w bazie.';
        $strings['UniqueUsernameRequired'] = 'Wybrany użytkownik już istnieje w bazie.';
        $strings['UserNameRequired'] = 'Wymagana jest nazwa użytkownika.';
        $strings['CaptchaMustMatch'] = 'Wprowadź znaki z pokazanego obrazka.';
        $strings['Today'] = 'Dziś';
        $strings['Week'] = 'Tydzień';
        $strings['Month'] = 'Miesiąc';
        $strings['BackToCalendar'] = 'Powrót do kalendarza';
        $strings['BeginDate'] = 'Początek';
        $strings['EndDate'] = 'Koniec';
        $strings['Username'] = 'Nazwa użytkownika';
        $strings['Password'] = 'Hasło';
        $strings['PasswordConfirmation'] = 'Potwierdź hasło';
        $strings['DefaultPage'] = 'Domyślna strona główna';
        $strings['MyCalendar'] = 'Mój kalendarz';
        $strings['ScheduleCalendar'] = 'Terminarz';
        $strings['Registration'] = 'Rejestracja';
        $strings['NoAnnouncements'] = 'Brak powiadomień';
        $strings['Announcements'] = 'Powiadomienia';
        $strings['NoUpcomingReservations'] = 'Nie masz żadnych zbliżających się rezerwacji';
        $strings['UpcomingReservations'] = 'Zbliżające się rezerwacje';
        $strings['ShowHide'] = 'Pokaż/Ukryj';
        $strings['Error'] = 'Błąd';
        $strings['ReturnToPreviousPage'] = 'Wróc do poprzedniej strony...';
        $strings['UnknownError'] = 'Nieznany błąd';
        $strings['InsufficientPermissionsError'] = 'Nie masz uprawnień do tego zasobu';
        $strings['MissingReservationResourceError'] = 'Zasób nie został wybrany';
        $strings['MissingReservationScheduleError'] = 'Termin nie został wybrany';
        $strings['DoesNotRepeat'] = 'Bez powtarzania';
        $strings['Daily'] = 'Dziennie';
        $strings['Weekly'] = 'Tygodniowo';
        $strings['Monthly'] = 'Miesięcznie';
        $strings['Yearly'] = 'Rocznie';
        $strings['RepeatPrompt'] = 'Powtórka';
        $strings['hours'] = 'godziny';
        $strings['days'] = 'dni';
        $strings['weeks'] = 'tygodnie';
        $strings['months'] = 'miesiące';
        $strings['years'] = 'lata';
        $strings['day'] = 'dzień';
        $strings['week'] = 'tydzień';
        $strings['month'] = 'miesiąc';
        $strings['year'] = 'rok';
        $strings['repeatDayOfMonth'] = 'dnia miesiąca';
        $strings['repeatDayOfWeek'] = 'dnia tygodnia';
        $strings['RepeatUntilPrompt'] = 'Do kiedy';
        $strings['RepeatEveryPrompt'] = 'Każdego';
        $strings['RepeatDaysPrompt'] = 'Włączone';
        $strings['CreateReservationHeading'] = 'Stwórz nową rezerwację';
        $strings['EditReservationHeading'] = 'Edytuj rezerwację %s';
        $strings['ViewReservationHeading'] = 'Podgląd rezerwacji %s';
        $strings['ReservationErrors'] = 'Zmień rezerwację';
        $strings['Create'] = 'Stwórz';
        $strings['ThisInstance'] = 'Tylko to wystąpienie';
        $strings['AllInstances'] = 'Wszystkie wystąpienia';
        $strings['FutureInstances'] = 'Przyszłe wystąpienia';
        $strings['Print'] = 'Drukuj';
        $strings['ShowHideNavigation'] = 'Pokaż/Ukryj nawigację';
        $strings['ReferenceNumber'] = 'Numer referencyjny';
        $strings['Tomorrow'] = 'Jutro';
        $strings['LaterThisWeek'] = 'Jeszcze w tym tygodniu';
        $strings['NextWeek'] = 'Następny tydzień';
        $strings['SignOut'] = 'Wyloguj się';
        $strings['LayoutDescription'] = 'Rozpoczyna się %s, trwa %s dni';
        $strings['AllResources'] = 'Wszystkie zasoby';
        $strings['TakeOffline'] = 'Deaktywuj';
        $strings['BringOnline'] = 'Aktywuj';
        $strings['AddImage'] = 'Dodaj obraz';
        $strings['NoImage'] = 'Brak przypisanego obrazu';
        $strings['Move'] = 'Przesuń';
        $strings['AppearsOn'] = 'Występuje w %s';
        $strings['Location'] = 'Lokalizacja';
        $strings['NoLocationLabel'] = '(brak ustawionej lokalizacji)';
        $strings['Contact'] = 'Kontakt';
        $strings['NoContactLabel'] = '(brak danych kontaktowych)';
        $strings['Description'] = 'Opis';
        $strings['NoDescriptionLabel'] = '(brak opisu)';
        $strings['Notes'] = 'Notatki';
        $strings['NoNotesLabel'] = '(brak notatek)';
        $strings['NoTitleLabel'] = '(brak tytułu)';
        $strings['UsageConfiguration'] = 'Konfiguracja użycia';
        $strings['ChangeConfiguration'] = 'Zmień konfigurację';
        $strings['ResourceMinLength'] = 'Rezerwacja musi trwać co najmniej %s';
        $strings['ResourceMinLengthNone'] = 'Brak minimalnego czasu rezerwacji';
        $strings['ResourceMaxLength'] = 'Rezerwacja nie może trwać więcej niż %s';
        $strings['ResourceMaxLengthNone'] = 'Brak maksymalnego czasu rezerwacji';
        $strings['ResourceRequiresApproval'] = 'Rezerwacja musi być zatwierdzana';
        $strings['ResourceRequiresApprovalNone'] = 'Rezerwacja nie wymaga zatwierdzania';
        $strings['ResourcePermissionAutoGranted'] = 'Uprawnienia są automatycznie nadawane';
        $strings['ResourcePermissionNotAutoGranted'] = 'Uprawnienia nie są automatycznie nadawane';
        $strings['ResourceMinNotice'] = 'Rezerwacje muszą być dokonane co najmniej %s przed rozpoczęciem';
        $strings['ResourceMinNoticeNone'] = 'Rezerwacje można dokonać aż do chwili rozpoczęcia';
        $strings['ResourceMaxNotice'] = 'Rezerwacja nie może trwać dłużej niż %s od momentu rozpoczecia';
        $strings['ResourceMaxNoticeNone'] = 'Rezerwacja nie są ograniczane czasowo';
        $strings['ResourceAllowMultiDay'] = 'Rezerwacje można dokonać na wiele dni';
        $strings['ResourceNotAllowMultiDay'] = 'Rezerwacje nie można dokonać na wiele dni';
        $strings['ResourceCapacity'] = 'Ten zasób może pomieścić maksymalnie osób: %s ';
        $strings['ResourceCapacityNone'] = 'Ten zasób ma nieograniczoną pojemność';
        $strings['AddNewResource'] = 'Dodaj nowy zasób';
        $strings['AddNewUser'] = 'Dodaj nowego użytkownika';
        $strings['AddUser'] = 'Dodaj użytkownika';
        $strings['Schedule'] = 'Terminarz';
        $strings['AddResource'] = 'Dodaj zasób';
        $strings['Capacity'] = 'Pojemność';
        $strings['Access'] = 'Dostęp';
        $strings['Duration'] = 'Czas trwania';
        $strings['Active'] = 'Aktywny';
        $strings['Inactive'] = 'Nieaktywny';
        $strings['ResetPassword'] = 'Reset hasła';
        $strings['LastLogin'] = 'Ostatnie logowanie';
        $strings['Search'] = 'Szukaj';
        $strings['ResourcePermissions'] = 'Uprawnienia do zasobów';
        $strings['Reservations'] = 'Rezerwacje';
        $strings['Groups'] = 'Grupy';
        $strings['ResetPassword'] = 'Reset Hasła';
        $strings['AllUsers'] = 'Wszyscy użytkownicy';
        $strings['AllGroups'] = 'Wszystkie grupy';
        $strings['AllSchedules'] = 'Wszystkie harmonogramy';
        $strings['UsernameOrEmail'] = 'Nazwa użytkownika lub adres mailowy';
        $strings['Members'] = 'Członkowie';
        $strings['QuickSlotCreation'] = 'Twórz wpisy co %s minut, pomiędzy %s i %s';
        $strings['ApplyUpdatesTo'] = 'Uaktualnij';
        $strings['CancelParticipation'] = 'Anuluj uczestnictwo';
        $strings['Attending'] = 'Uczestnictwo';
        $strings['QuotaConfiguration'] = 'Na %s dla %s użytkowników w %s jest limitowana do %s %s przez %s';
        $strings['reservations'] = 'rezerwacje';
        $strings['ChangeCalendar'] = 'Zmień kalendarz';
        $strings['AddQuota'] = 'Dodaj Limit';
        $strings['FindUser'] = 'Znajdź użytkownika';
        $strings['Created'] = 'Stworzony';
        $strings['LastModified'] = 'Ostatnia modyfikacja';
        $strings['GroupName'] = 'Nazwa grupy';
        $strings['GroupMembers'] = 'Członkowie grupy';
        $strings['GroupRoles'] = 'Role grup';
        $strings['GroupAdmin'] = 'Grupa administratorów';
        $strings['Actions'] = 'Akcje';
        $strings['CurrentPassword'] = 'Aktualne hasło';
        $strings['NewPassword'] = 'Nowe hasło';
        $strings['InvalidPassword'] = 'Wprwadzone hasło jest niepoprawne';
        $strings['PasswordChangedSuccessfully'] = 'Twoje hasło zostało zmienione';
        $strings['SignedInAs'] = 'Zalogowany jako';
        $strings['NotSignedIn'] = 'Nie jesteś zalogowany';
        $strings['ReservationTitle'] = 'Tytuł rezerwacji';
        $strings['ReservationDescription'] = 'Opis rezerwacji';
        $strings['ResourceList'] = 'Zasoby do zarezerwowania';
        $strings['Accessories'] = 'Akcesoria';
        $strings['Add'] = 'Dodaj';
        $strings['ParticipantList'] = 'Uczestnicy';
        $strings['InvitationList'] = 'Zaproszenia';
        $strings['AccessoryName'] = 'Nazwa akcesoria';
        $strings['QuantityAvailable'] = 'Dostepna ilość';
        $strings['Resources'] = 'Zasoby';
        $strings['Participants'] = 'Uczestnicy';
        $strings['User'] = 'Uzytkownik';
        $strings['Resource'] = 'Zasób';
        $strings['Status'] = 'Status';
        $strings['Approve'] = 'Zatwierdź';
        $strings['Page'] = 'Strona';
        $strings['Rows'] = 'Wierszy';
        $strings['Unlimited'] = 'Bez limitu';
        $strings['Email'] = 'Email';
        $strings['EmailAddress'] = 'Adres mailowy';
        $strings['Phone'] = 'Telefon';
        $strings['Organization'] = 'Firma';
        $strings['Position'] = 'Stanowisko';
        $strings['Language'] = 'Język';
        $strings['Permissions'] = 'Uprawnienia';
        $strings['Reset'] = 'Reset';
        $strings['FindGroup'] = 'Znajdź grupę';
        $strings['Manage'] = 'Zarządzaj';
        $strings['None'] = 'Brak';
        $strings['AddToOutlook'] = 'Dodaj do programu Microsoft Outlook';
        $strings['Done'] = 'Wykonaj';
        $strings['RememberMe'] = 'Zapamiętaj mnie';
        $strings['FirstTimeUser?'] = 'Pierwszy raz tutaj?';
        $strings['CreateAnAccount'] = 'Zarejestruj się';
        $strings['ViewSchedule'] = 'Podgląd harmonogramu';
        $strings['ForgotMyPassword'] = 'Zapomniałeś hasła?';
        $strings['YouWillBeEmailedANewPassword'] = 'Zostanie wysłane nowo wygenerowane hasło na twój adres mailowy';
        $strings['Close'] = 'Zamknij';
        $strings['ExportToCSV'] = 'Eksportuj do CSV';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'Pracuje...';
        $strings['Login'] = 'Logowanie';
        $strings['AdditionalInformation'] = 'Dodatkowe informacje';
        $strings['AllFieldsAreRequired'] = 'wszystkie pola są wymagane';
        $strings['Optional'] = 'opcjonalnie';
        $strings['YourProfileWasUpdated'] = 'Twój profil został zaktualizowany';
        $strings['YourSettingsWereUpdated'] = 'Twoje ustawenia zostały zmienione';
        $strings['Register'] = 'Rejestruj';
        $strings['SecurityCode'] = 'Kod zabezpieczający';
        $strings['ReservationCreatedPreference'] = 'Kiedy tworzę rezerwację lub rezerwacja jest tworzona za mnie';
        $strings['ReservationUpdatedPreference'] = 'Kiedy aktualizuję rezerwację lub rezerwacja jest aktualizowana za mnie';
        $strings['ReservationDeletedPreference'] = 'Kiedy usuwam rezerwację lub rezerwacja jest usuwana za mnie';
        $strings['ReservationApprovalPreference'] = 'Kiedy moje rezerwacja zostatnie zatwierdzona';
        $strings['PreferenceSendEmail'] = 'Powiadom mnie mailem';
        $strings['PreferenceNoEmail'] = 'Nie powiadamiaj mnie';
        $strings['ReservationCreated'] = 'Twoja rezerwacja została pomyślnie utworzona!';
        $strings['ReservationUpdated'] = 'Twoja rezerwacja została pomyślnie zaktualizowana!';
        $strings['ReservationRemoved'] = 'Twoja rezerwacja została pomyślnie usunięta';
        $strings['YourReferenceNumber'] = 'Numer twojej rezerwacji to %s';
        $strings['UpdatingReservation'] = 'Aktualizowanie rezerwacji';
        $strings['ChangeUser'] = 'Zmiana użytkownika';
        $strings['MoreResources'] = 'Więcej zasobów';
        $strings['ReservationLength'] = 'Długość rezerwacji';
        $strings['ParticipantList'] = 'Lista uczestników';
        $strings['AddParticipants'] = 'Dodaj uczestników';
        $strings['InviteOthers'] = 'Zaproś innych';
        $strings['AddResources'] = 'Dodaj zasób';
        $strings['AddAccessories'] = 'Dodaj akcesoria';
        $strings['Accessory'] = 'Akcesorium';
        $strings['QuantityRequested'] = 'Wymagana ilość';
        $strings['CreatingReservation'] = 'Tworzenie rezerwacji';
        $strings['UpdatingReservation'] = 'Aktualizowanie rezerwacji';
        $strings['DeleteWarning'] = 'Ta akcja jest trwała i bez możliwości powrotu!';
        $strings['DeleteAccessoryWarning'] = 'Usunięcie tego akcesorium spowoduje usunięcie go ze wszystkich rezerwacji.';
        $strings['AddAccessory'] = 'Dodaj akcesorium';
        $strings['AddBlackout'] = 'Dodaj niedostępność';
        $strings['AllResourcesOn'] = 'Wszystkie zasoby włączone';
        $strings['Reason'] = 'Powód';
        $strings['BlackoutShowMe'] = 'Pokaż mi rezerwacje z konfliktem';
        $strings['BlackoutDeleteConflicts'] = 'Usuń rezerwacje z konfliktem';
        $strings['Filter'] = 'Filtr';
        $strings['Between'] = 'Pomiędzy';
        $strings['CreatedBy'] = 'Utworzone przez';
        $strings['BlackoutCreated'] = 'Niedostępność utworzona!';
        $strings['BlackoutNotCreated'] = 'Niedostępnośc nie mogła zostać utworzona!';
        $strings['BlackoutConflicts'] = 'Istnieją konflikty niedostępności';
        $strings['ReservationConflicts'] = 'Istnieją konflikty rezerwacji';
        $strings['UsersInGroup'] = 'Uzytkownicy w tej grupie';
        $strings['Browse'] = 'Przeglądaj';
        $strings['DeleteGroupWarning'] = 'Usunięcie tej grupy spowoduje wykasowanie wszystkich uprawnień do zasobów. Użytkownicy z tej grupy, mogą utracić uprawnienia do zasobów.';
        $strings['WhatRolesApplyToThisGroup'] = 'Jakie dodać role dla tej grupy?';
        $strings['WhoCanManageThisGroup'] = 'Kto może zarządzać tą grupą?';
        $strings['WhoCanManageThisSchedule'] = 'Kto może zarządzać tym harmonogramem?';
        $strings['AddGroup'] = 'Dodaj grupę';
        $strings['AllQuotas'] = 'Wszystkie limity';
        $strings['QuotaReminder'] = 'Pamiętaj: Limity są egzekwowane na podstawie strefy czasowej harmonogramu';
        $strings['AllReservations'] = 'Wszystkie rezerwacje';
        $strings['PendingReservations'] = 'Oczekujące reserwacje';
        $strings['Approving'] = 'Zatwierdź';
        $strings['MoveToSchedule'] = 'Przenieś do harmonogramu';
        $strings['DeleteResourceWarning'] = 'Usunięcie tego zasobu spowoduje wykasowanie wszystkich danych, włącznie z';
        $strings['DeleteResourceWarningReservations'] = 'jego wszystkimi przeszłymi, obecnymi i przyszłymi rezerwacjami';
        $strings['DeleteResourceWarningPermissions'] = 'wszystkimi przypisanymi uprawnieniami';
        $strings['DeleteResourceWarningReassign'] = 'Proszę przemysleć dokładnie zanim coś zostanie usunięte';
        $strings['ScheduleLayout'] = 'Wygląd (zawsze %s)';
        $strings['ReservableTimeSlots'] = 'Lista wolnych terminów rezerwacji';
        $strings['BlockedTimeSlots'] = 'Lista zablokowanych terminów rezerwacji';
        $strings['ThisIsTheDefaultSchedule'] = 'To jest domyślny harmonogram';
        $strings['DefaultScheduleCannotBeDeleted'] = 'Domyślny harmonogram nie może zostać usunięty';
        $strings['MakeDefault'] = 'Zrób domyślną';
        $strings['BringDown'] = 'Opóźnij';
        $strings['ChangeLayout'] = 'Zmiana wyglądu';
        $strings['AddSchedule'] = 'Dodaj harmonogram';
        $strings['StartsOn'] = 'Rozpoczyna się';
        $strings['NumberOfDaysVisible'] = 'Liczba widocznych dni';
        $strings['UseSameLayoutAs'] = 'Użyj tego samego wyglądu jako';
        $strings['Format'] = 'Format';
        $strings['OptionalLabel'] = 'Opcjonalna nazwa';
        $strings['LayoutInstructions'] = 'Dodawaj jeden wpis w linii. Wpisy muszą być uzupełnione dla wszystkich 24 godzin od rozpoczęcia dnia aż do północy.';
        $strings['AddUser'] = 'Dodaj użytkownika';
        $strings['UserPermissionInfo'] = 'Aktualny dostep do zasobu może być inny w zależności od roli użytkownika, uprawnień grupy lub zewnętrznych ustawień uprawnień';
        $strings['DeleteUserWarning'] = 'Usunięcie tego użytkownika spowoduje usunięcie wszystkich kiedykolwiek utworzonych rezerwacji.';
        $strings['AddAnnouncement'] = 'Dodaj powiadomienie';
        $strings['Announcement'] = 'Powiadomienie';
        $strings['Priority'] = 'Ważność';
        $strings['Reservable'] = 'Dostępne';
        $strings['Unreservable'] = 'Niedostępne';
        $strings['Reserved'] = 'Zarezerwowane';
        $strings['MyReservation'] = 'Moje rezerwacje';
        $strings['Pending'] = 'W oczekiwaniu';
        $strings['Past'] = 'Przeszłe';
        $strings['Restricted'] = 'Ograniczone';
        $strings['ViewAll'] = 'Podgląd wszystkich';
        $strings['MoveResourcesAndReservations'] = 'Przenieś zasoby i rezerwacje do';
        $strings['TurnOffSubscription'] = 'Wyłącz subskrypcję kalendarza';
        $strings['TurnOnSubscription'] = 'Zezwól na subskrypcję tego kalendarza';
        $strings['SubscribeToCalendar'] = 'Subskrybuj ten kalendarz';
        $strings['SubscriptionsAreDisabled'] = 'Administrator wyłączył subskrypcje kalendarza';
        $strings['NoResourceAdministratorLabel'] = '(Brak Administratora Zasobów)';
        $strings['WhoCanManageThisResource'] = 'Kto może zarządzać tym zasobem?';
        $strings['ResourceAdministrator'] = 'Administrator Zasobów';
        $strings['Private'] = 'Prywatny';
        $strings['Accept'] = 'Akceptuj';
        $strings['Decline'] = 'Odrzuć';
        $strings['ShowFullWeek'] = 'Pokaż cały tydzień';
        $strings['CustomAttributes'] = 'Atrybuty niestandardowe';
        $strings['AddAttribute'] = 'Dodaj atrybut';
        $strings['EditAttribute'] = 'Edytuj atrybut';
        $strings['DisplayLabel'] = 'Wyświetl etykietę';
        $strings['Type'] = 'Typ';
        $strings['Required'] = 'Wymagany';
        $strings['ValidationExpression'] = 'Wyrażenie walidacyjne';
        $strings['PossibleValues'] = 'Możliwe wartości';
        $strings['SingleLineTextbox'] = 'Jednoliniowe pole tekstowe';
        $strings['MultiLineTextbox'] = 'Wieloliniowe pole tekstowe';
        $strings['Checkbox'] = 'Pole wyboru';
        $strings['SelectList'] = 'Lista wyboru';
        $strings['CommaSeparated'] = 'rozdzielane przecinkiem';
        $strings['Category'] = 'Kategoria';
        $strings['CategoryReservation'] = 'Rezerwacja';
        $strings['CategoryGroup'] = 'Grupa';
        $strings['SortOrder'] = 'Porządek sortowania';
        $strings['Title'] = 'Tytuł';
        $strings['AdditionalAttributes'] = 'Atrybuty dodatkowe';
        $strings['True'] = 'Prawda';
        $strings['False'] = 'Fałsz';
		$strings['ForgotPasswordEmailSent'] = 'Na podany adres został wysłany email z instrukcjami zresetowania hasła';
		$strings['ActivationEmailSent'] = 'Niedługo otrzymasz emaila aktywacyjnego.';
		$strings['AccountActivationError'] = 'Przepraszamy, nie możemy aktywować Twojego konta.';
		$strings['Attachments'] = 'Załączniki';
		$strings['AttachFile'] = 'Załącz plik';
		$strings['Maximum'] = 'max';
		$strings['NoScheduleAdministratorLabel'] = 'Brak administratora harmonogramu';
		$strings['ScheduleAdministrator'] = 'Administrator harmonogramu';
		$strings['Total'] = 'Razem';
		$strings['QuantityReserved'] = 'Ilość zarezerwowana';
		$strings['AllAccessories'] = 'Wszystkie akcesoria';
		$strings['GetReport'] = 'Generuj raport';
		$strings['NoResultsFound'] = 'Nie znaleziono pasujących wyników';
		$strings['SaveThisReport'] = 'Zapisz ten raport';
		$strings['ReportSaved'] = 'Raport zapisany!';
		$strings['EmailReport'] = 'Wyślij raport mailem';
		$strings['ReportSent'] = 'Raport wysłany!';
		$strings['RunReport'] = 'Uruchom raport';
		$strings['NoSavedReports'] = 'Nie masz zapisanych raportów.';
		$strings['CurrentWeek'] = 'Bieżący tydzień';
		$strings['CurrentMonth'] = 'Bieżący miesiąc';
		$strings['AllTime'] = 'Cały czas';
		$strings['FilterBy'] = 'Filtruj po';
		$strings['Select'] = 'Zaznacz';
		$strings['List'] = 'Lista';
		$strings['TotalTime'] = 'Łączny czas';
		$strings['Count'] = 'Liczba';
		$strings['Usage'] = 'Użycie';
		$strings['AggregateBy'] = 'Grupuj po';
		$strings['Range'] = 'Zakres';
		$strings['Choose'] = 'Wybierz';
		$strings['All'] = 'Wszystko';
		$strings['ViewAsChart'] = 'Zobacz jako wykres';
		$strings['ReservedResources'] = 'Zarezerwowane zasoby';
		$strings['ReservedAccessories'] = 'Zarezerwowane akcesoria';
		$strings['ResourceUsageTimeBooked'] = 'Użycie zasobów - zarezerwowany czas';
		$strings['ResourceUsageReservationCount'] = 'Użycie zasobów - liczba rezerwacji';
		$strings['Top20UsersTimeBooked'] = 'Top 20 użytkowników - zarezerwowany czas';
		$strings['Top20UsersReservationCount'] = 'Top 20 użytkowników - liczba rezerwacji';
		// End Strings

        // Errors
        $strings['LoginError'] = 'Nie możemy odnaleźć twojej nazwy użytkownika lub hasła';
        $strings['ReservationFailed'] = 'Twoja rezerwacja nie mogła zostać utworzona';
        $strings['MinNoticeError'] = 'Ta rezerwacja wymaga dodatkowej uwagi.  Najwcześniejsza data, która może być zarezerwowana to %s.';
        $strings['MaxNoticeError'] = 'Ta rezerwacja nie może być utworzona w tak odległej przyszłości.  Najdalszą datą jest %s.';
        $strings['MinDurationError'] = 'Ta rezerwacja musi trwać co najmniej %s.';
        $strings['MaxDurationError'] = 'Ta rezerwacja nie może trwać dłużej niż %s.';
        $strings['ConflictingAccessoryDates'] = 'Brak wymaganej ilości akcesoriów:';
        $strings['NoResourcePermission'] = 'Nie posiadasz uprawnień do co najmniej jednego zasobu z wybranych';
        $strings['ConflictingReservationDates'] = 'Istnieją konflikty rezerwacji w podanych dniach:';
        $strings['StartDateBeforeEndDateRule'] = 'Data rozpoczęcia musi być wcześniejsza niż data zakończenia';
        $strings['StartIsInPast'] = 'Data rozpoczęcia nie może być datą z przeszłości';
        $strings['EmailDisabled'] = 'Administrator wyłączył powiadomienia mailowe';
        $strings['ValidLayoutRequired'] = 'Wpisy muszą być uzupełnione dla wszystkich 24 godzin od rozpoczęcia dnia aż do północy.';
        $strings['CustomAttributeErrors'] = 'Są problemy z dodatkowymi atrybutami, które podano:';
        $strings['CustomAttributeRequired'] = '%s jest polem wymaganym';
        $strings['CustomAttributeInvalid'] = 'Wartość podana dla %s jest nieprawidłowa';
        $strings['AttachmentLoadingError'] = 'Przepraszamy, ale wystąpił problem podczas ładownia żądanego plik.';
        $strings['InvalidAttachmentExtension'] = 'Możesz dodawać pliki tylko typu: %s';
        // End Errors

        // Page Titles
        $strings['CreateReservation'] = 'Tworzenie rezerwacji';
        $strings['EditReservation'] = 'Edycja rezerwacji';
        $strings['LogIn'] = 'Logowanie';
        $strings['ManageReservations'] = 'Rezerwacje';
        $strings['AwaitingActivation'] = 'W oczekiwaniu na aktywację';
        $strings['PendingApproval'] = 'W oczekiwaniu na zatwierdzenie';
        $strings['ManageSchedules'] = 'Harmonogramy';
        $strings['ManageResources'] = 'Zasoby';
        $strings['ManageAccessories'] = 'Akcesoria';
        $strings['ManageUsers'] = 'Użytkownicy';
        $strings['ManageGroups'] = 'Grupy';
        $strings['ManageQuotas'] = 'Limity';
        $strings['ManageBlackouts'] = 'Zarządzanie niedostępnościami';
        $strings['MyDashboard'] = 'Moja strona';
        $strings['ServerSettings'] = 'Ustawienia serwera';
        $strings['Dashboard'] = 'Strona główna';
        $strings['Help'] = 'Pomoc';
		$strings['Administration'] = 'Administracja';
		$strings['About'] = 'O...';
        $strings['Bookings'] = 'Terminarze';
        $strings['Schedule'] = 'Harmonogram';
        $strings['Reservations'] = 'Rezerwacje';
        $strings['Account'] = 'Konto';
        $strings['EditProfile'] = 'Edycja mojego profilu';
        $strings['FindAnOpening'] = 'Znajdowanie otwarcia';
        $strings['OpenInvitations'] = 'Otwórz zaproszenia';
        $strings['MyCalendar'] = 'Mój kalendarz';
        $strings['ResourceCalendar'] = 'Kalendarz zasobu';
        $strings['Reservation'] = 'Nowa rezerwacja';
        $strings['Install'] = 'Instalacja';
        $strings['ChangePassword'] = 'Zmiana hasła';
        $strings['MyAccount'] = 'Moje konto';
        $strings['Profile'] = 'Profil';
        $strings['ApplicationManagement'] = 'Zarządzanie aplikacją';
        $strings['ForgotPassword'] = 'Przypomnienie hasła';
        $strings['NotificationPreferences'] = 'Ustawienia powiadomień';
        $strings['ManageAnnouncements'] = 'Ogłoszenia';
        $strings['Responsibilities'] = 'Obowiązki';
        $strings['GroupReservations'] = 'Rezerwacje grupowe';
        $strings['ResourceReservations'] = 'Rezerwacje zasobów';
        $strings['Customization'] = 'Dostosowywanie';
        $strings['Attributes'] = 'Atrybuty';
		$strings['AccountActivation'] = 'Aktywacja konta';
		$strings['ScheduleReservations'] = 'Zaplanuj rezerwacje';
		$strings['Reports'] = 'Raporty';
		$strings['GenerateReport'] = 'Utwórz nowy raport';
		$strings['MySavedReports'] = 'Moje zapisane raporty';
		$strings['CommonReports'] = 'Wspólne raporty';
		$strings['ViewDay'] = 'Podgląd dnia';
		$strings['Group'] = 'Grupa';
        // End Page Titles

        // Day representations
        $strings['DaySundaySingle'] = 'N';
        $strings['DayMondaySingle'] = 'Po';
        $strings['DayTuesdaySingle'] = 'W';
        $strings['DayWednesdaySingle'] = 'Śr';
        $strings['DayThursdaySingle'] = 'Cz';
        $strings['DayFridaySingle'] = 'Pi';
        $strings['DaySaturdaySingle'] = 'S';

        $strings['DaySundayAbbr'] = 'Nie';
        $strings['DayMondayAbbr'] = 'Pon';
        $strings['DayTuesdayAbbr'] = 'Wto';
        $strings['DayWednesdayAbbr'] = 'Śro';
        $strings['DayThursdayAbbr'] = 'Czw';
        $strings['DayFridayAbbr'] = 'Pią';
        $strings['DaySaturdayAbbr'] = 'Sob';
		// End Day representations

        // Email Subjects
        $strings['ReservationApprovedSubject'] = 'Twoja rezerwacja została zatwierdzona';
        $strings['ReservationCreatedSubject'] = 'Twoja rezerwacja została utworzona';
        $strings['ReservationUpdatedSubject'] = 'Twoja rezerwacja została zaktualizowana';
        $strings['ReservationDeletedSubject'] = 'Twoja rezerwacja została usunięta';
        $strings['ReservationCreatedAdminSubject'] = 'Powiadomienie: rezerwacja została utworzona';
        $strings['ReservationUpdatedAdminSubject'] = 'Powiadomienie: rezerwacja została zaktualizowana';
        $strings['ReservationDeleteAdminSubject'] = 'Powiadomienie: rezerwacja została usunięta';
        $strings['ParticipantAddedSubject'] = 'Zgłoszenie udziału uczestnictwa';
        $strings['ParticipantDeletedSubject'] = 'Rezerwacja usunięta';
        $strings['InviteeAddedSubject'] = 'Zaproszenie do uczestnictwa';
        $strings['ResetPassword'] = 'Zmiana hasła';
        $strings['ActivateYourAccount'] = 'Proszę aktywować Swoje konto';
		$strings['ReportSubject'] = 'Twój żądany raport (%s)';
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
        $days['full'] = array('Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota');
        // The three letter abbreviation
        $days['abbr'] = array('Nie', 'Pon', 'Wto', 'Śro', 'Czw', 'Pią', 'Sob');
        // The two letter abbreviation
        $days['two'] = array('Nd', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'Sb');
        // The one letter abbreviation
        $days['letter'] = array('N', 'Pn', 'W', 'Ś', 'Cz', 'Pt', 'S');

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
        $months['full'] = array('Styczeń', 'Luty', 'Marzec', 'Kwieceń', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień');
        // The three letter month name
        $months['abbr'] = array('Sty', 'Lut', 'Mar', 'Kwi', 'Maj', 'Cze', 'Lip', 'Sie', 'Wrz', 'Paź', 'Lis', 'Gru');

        $this->Months = $months;

		return $this->Months;
    }

	/**
     * @return array
     */
    protected function _LoadLetters()
    {
        $this->Letters = array('A', 'Ą', 'B', 'C', 'Ć', 'D', 'E', 'Ę', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'Ł', 'M', 'N', 'Ń', 'O', 'Ó', 'P', 'Q', 'R', 'S', 'Ś', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Ż', 'Ź');

		return $this->Letters;
    }

    protected function _GetHtmlLangCode()
    {
        return 'pl';
    }
}
