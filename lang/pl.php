<?php
/**
Copyright 2011-2012 Nick Korbel
Translated to Polish by Dariusz Kliszewski

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

class pl extends Language
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function _LoadDates()
    {
        $dates = array();

        $dates['general_date'] = 'Y-m-d';
        $dates['general_datetime'] = 'Y-m-d H:i:s';
        $dates['schedule_daily'] = 'l, Y-m-d';
        $dates['reservation_email'] = 'Y-m-d @ G:i (e)';
        $dates['res_popup'] = 'Y-m-d G:i';
        $dates['dashboard'] = 'l, Y-m-d G:i';
        $dates['period_time'] = "G:i";
		$dates['general_date_js'] = "dd.mm.yy";

        $this->Dates = $dates;
    }

    protected function _LoadStrings()
    {
        $strings = array();

        $strings['FirstName'] = 'Imiê';
        $strings['LastName'] = 'Nazwisko';
        $strings['Timezone'] = 'Strefa czasowa';
        $strings['Edit'] = 'Edycja';
        $strings['Change'] = 'Zmieñ';
        $strings['Rename'] = 'Zmieñ nazwê';
        $strings['Remove'] = 'Usuñ';
        $strings['Delete'] = 'Skasuj';
        $strings['Update'] = 'Aktualizuj';
        $strings['Cancel'] = 'Anuluj';
        $strings['Add'] = 'Dodaj';
        $strings['Name'] = 'Nazwa';
        $strings['Yes'] = 'Tak';
        $strings['No'] = 'Nie';
        $strings['FirstNameRequired'] = 'Wymagane jest imiê.';
        $strings['LastNameRequired'] = 'Wymagane jest nazwisko.';
        $strings['PwMustMatch'] = 'Has³o potwierdzaj¹ce musi byæ identyczne.';
        $strings['PwComplexity'] = 'Has³o musi mieæ co najmniej 6 znaków, w tym ma³e i du¿e litery oraz cyfry.';
        $strings['ValidEmailRequired'] = 'Wymagany poprawny adres mailowy.';
        $strings['UniqueEmailRequired'] = 'Wybrany adres mailowy ju¿ istnieje w bazie.';
        $strings['UniqueUsernameRequired'] = 'Wybrany u¿ytkownik ju¿ istnieje w bazie.';
        $strings['UserNameRequired'] = 'Wymagana jest nazwa u¿ytkownika.';
        $strings['CaptchaMustMatch'] = 'WprowadŸ znaki z pokazanego obrazka.';
        $strings['Today'] = 'Dziœ';
        $strings['Week'] = 'Tydzieñ';
        $strings['Month'] = 'Miesi¹c';
        $strings['BackToCalendar'] = 'Powrót do kalendarza';
        $strings['BeginDate'] = 'Pocz¹tek';
        $strings['EndDate'] = 'Koniec';
        $strings['Username'] = 'Nazwa u¿ytkownika';
        $strings['Password'] = 'Has³o';
        $strings['PasswordConfirmation'] = 'PotwierdŸ has³o';
        $strings['DefaultPage'] = 'Domyœlna strona g³ówna';
        $strings['MyCalendar'] = 'Mój kalendarz';
        $strings['ScheduleCalendar'] = 'Terminarz';
        $strings['Registration'] = 'Rejestracja';
        $strings['NoAnnouncements'] = 'Brak powiadomieñ';
        $strings['Announcements'] = 'Powiadomienia';
        $strings['NoUpcomingReservations'] = 'Nie masz ¿adnych zbli¿aj¹cych siê rezerwacji';
        $strings['UpcomingReservations'] = 'Zbli¿aj¹ce siê rezerwacje';
        $strings['ShowHide'] = 'Poka¿/Ukryj';
        $strings['Error'] = 'B³¹d';
        $strings['ReturnToPreviousPage'] = 'Wróc do poprzedniej strony...';
        $strings['UnknownError'] = 'Nieznany b³¹d';
        $strings['InsufficientPermissionsError'] = 'Nie masz uprawnieñ do tego zasobu';
        $strings['MissingReservationResourceError'] = 'Zasób nie zosta³ wybrany';
        $strings['MissingReservationScheduleError'] = 'Termin nie zosta³ wybrany';
        $strings['DoesNotRepeat'] = 'Bez powtarzania';
        $strings['Daily'] = 'Dziennie';
        $strings['Weekly'] = 'Tygodniowo';
        $strings['Monthly'] = 'Miesiêcznie';
        $strings['Yearly'] = 'Rocznie';
        $strings['RepeatPrompt'] = 'Powtórka';
        $strings['hours'] = 'godziny';
        $strings['days'] = 'dni';
        $strings['weeks'] = 'tygodnie';
        $strings['months'] = 'miesi¹ce';
        $strings['years'] = 'lata';
        $strings['day'] = 'dzieñ';
        $strings['week'] = 'tydzieñ';
        $strings['month'] = 'miesi¹c';
        $strings['year'] = 'rok';
        $strings['repeatDayOfMonth'] = 'dnia miesi¹ca';
        $strings['repeatDayOfWeek'] = 'dnia tygodnia';
        $strings['RepeatUntilPrompt'] = 'Do kiedy';
        $strings['RepeatEveryPrompt'] = 'Ka¿dego';
        $strings['RepeatDaysPrompt'] = 'W³¹czone';
        $strings['CreateReservationHeading'] = 'Stwórz now¹ rezerwacjê';
        $strings['EditReservationHeading'] = 'Edytuj rezerwacjê %s';
        $strings['ViewReservationHeading'] = 'Podgl¹d rezerwacji %s';
        $strings['ReservationErrors'] = 'Zmieñ rezerwacjê';
        $strings['Create'] = 'Stwórz';
        $strings['ThisInstance'] = 'Tylko to wyst¹pienie';
        $strings['AllInstances'] = 'Wszystkie wyst¹pienia';
        $strings['FutureInstances'] = 'Przysz³e wyst¹pienia';
        $strings['Print'] = 'Drukuj';
        $strings['ShowHideNavigation'] = 'Poka¿/Ukryj Nawigacjê';
        $strings['ReferenceNumber'] = 'Numer referencyjny';
        $strings['Tomorrow'] = 'Jutro';
        $strings['LaterThisWeek'] = 'Jeszcze w tym tygodniu';
        $strings['NextWeek'] = 'Nastêpny tydzieñ';
        $strings['SignOut'] = 'Wyloguj siê';
        $strings['LayoutDescription'] = 'Rozpoczyna siê %s, trwa %s dni';
        $strings['AllResources'] = 'Wszystkie zasoby';
        $strings['TakeOffline'] = 'Deaktywuj';
        $strings['BringOnline'] = 'Aktywuj';
        $strings['AddImage'] = 'Dodaj obraz';
        $strings['NoImage'] = 'Brak przypisanego obrazu';
        $strings['Move'] = 'Przesuñ';
        $strings['AppearsOn'] = 'Utworzone dnia %s';
        $strings['Location'] = 'Lokalizacja';
        $strings['NoLocationLabel'] = '(brak ustawionej lokalizacji)';
        $strings['Contact'] = 'Kontakt';
        $strings['NoContactLabel'] = '(brak danych kontaktowych)';
        $strings['Description'] = 'Opis';
        $strings['NoDescriptionLabel'] = '(brak opisu)';
        $strings['Notes'] = 'Notatki';
        $strings['NoNotesLabel'] = '(brak notatek)';
        $strings['NoTitleLabel'] = '(brak tytu³u)';
        $strings['UsageConfiguration'] = 'Konfiguracja u¿ycia';
        $strings['ChangeConfiguration'] = 'Zmieñ konfiguracjê';
        $strings['ResourceMinLength'] = 'Rezerwacja musi trwaæ co najmniej %s';
        $strings['ResourceMinLengthNone'] = 'Brak minimalnego czasu rezerwacji';
        $strings['ResourceMaxLength'] = 'Rezerwacja nie mo¿e trwaæ wiêcej ni¿ %s';
        $strings['ResourceMaxLengthNone'] = 'Brak maksymalnego czasu rezerwacji';
        $strings['ResourceRequiresApproval'] = 'Rezerwacja musi byæ zatwierdzana';
        $strings['ResourceRequiresApprovalNone'] = 'Rezerwacja nie wymaga zatwierdzania';
        $strings['ResourcePermissionAutoGranted'] = 'Uprawnienia s¹ automatycznie nadawane';
        $strings['ResourcePermissionNotAutoGranted'] = 'Uprawnienia nie s¹ automatycznie nadawane';
        $strings['ResourceMinNotice'] = 'Rezerwacje musz¹ byæ dokonane co najmniej %s przed rozpoczêciem';
        $strings['ResourceMinNoticeNone'] = 'Rezerwacje mo¿na dokonaæ a¿ do chwili rozpoczêcia';
        $strings['ResourceMaxNotice'] = 'Rezerwacja nie mo¿e trwaæ d³u¿ej ni¿ %s od momentu rozpoczecia';
        $strings['ResourceMaxNoticeNone'] = 'Rezerwacja nie s¹ ograniczane czasowo';
        $strings['ResourceAllowMultiDay'] = 'Rezerwacje mo¿na dokonaæ na wiele dni';
        $strings['ResourceNotAllowMultiDay'] = 'Rezerwacje nie mo¿na dokonaæ na wiele dni';
        $strings['ResourceCapacity'] = 'Ten zasób mo¿e pomieœciæ maksymalnie osób: %s ';
        $strings['ResourceCapacityNone'] = 'Ten zasób ma nieograniczon¹ pojemnoœæ';
        $strings['AddNewResource'] = 'Dodaj nowy zasób';
        $strings['AddNewUser'] = 'Dodaj nowego u¿ytkownika';
        $strings['AddUser'] = 'Dodaj u¿ytkownika';
        $strings['Schedule'] = 'Terminarz';
        $strings['AddResource'] = 'Dodaj zasób';
        $strings['Capacity'] = 'Pojemnoœæ';
        $strings['Access'] = 'Dostêp';
        $strings['Duration'] = 'Czas trwania';
        $strings['Active'] = 'Aktywuj';
        $strings['Inactive'] = 'Deaktywuj';
        $strings['ResetPassword'] = 'Reset Has³a';
        $strings['LastLogin'] = 'Ostatnie logowanie';
        $strings['Search'] = 'Szukaj';
        $strings['ResourcePermissions'] = 'Uprawnienia do zasobów';
        $strings['Reservations'] = 'Rezerwacje';
        $strings['Groups'] = 'Grupy';
        $strings['ResetPassword'] = 'Reset Has³a';
        $strings['AllUsers'] = 'Wszyscy u¿ytkownicy';
        $strings['AllGroups'] = 'Wszystkie grupy';
        $strings['AllSchedules'] = 'Wszystkie rezerwacje';
        $strings['UsernameOrEmail'] = 'Nazwa u¿ytkownika lub adres mailowy';
        $strings['Members'] = 'Cz³onkowie';
        $strings['QuickSlotCreation'] = 'Twórz wpisy co %s minut, pomiêdzy %s i %s';
        $strings['ApplyUpdatesTo'] = 'Uaktualnij';
        $strings['CancelParticipation'] = 'Anuluj uczestnictwo';
        $strings['Attending'] = 'Uczestnictwo';
        $strings['QuotaConfiguration'] = 'Na %s dla %s u¿ytkowników w %s jest limitowana do %s %s przez %s';
        $strings['reservations'] = 'rezerwacje';
        $strings['ChangeCalendar'] = 'Zmieñ kalendarz';
        $strings['AddQuota'] = 'Dodaj Quota';
        $strings['FindUser'] = 'ZnajdŸ u¿ytkownika';
        $strings['Created'] = 'Stworzony';
        $strings['LastModified'] = 'Ostatnia modyfikacja';
        $strings['GroupName'] = 'Nazwa grupy';
        $strings['GroupMembers'] = 'Cz³onkowie grupy';
        $strings['GroupRoles'] = 'Role grup';
        $strings['GroupAdmin'] = 'Grupa administratorów';
        $strings['Actions'] = 'Akcje';
        $strings['CurrentPassword'] = 'Aktualne has³o';
        $strings['NewPassword'] = 'Nowe has³o';
        $strings['InvalidPassword'] = 'Wprwadzone has³o jest niepoprawne';
        $strings['PasswordChangedSuccessfully'] = 'Twoje has³o zosta³o zmienione';
        $strings['SignedInAs'] = 'Zalogowany jako';
        $strings['NotSignedIn'] = 'Nie jesteœ zalogowany';
        $strings['ReservationTitle'] = 'Tytu³ rezerwacji';
        $strings['ReservationDescription'] = 'Opis rezerwacji';
        $strings['ResourceList'] = 'Zasoby do zarezerwowania';
        $strings['Accessories'] = 'Akcesoria';
        $strings['Add'] = 'Dodaj';
        $strings['ParticipantList'] = 'Uczestnicy';
        $strings['InvitationList'] = 'Zaproszenia';
        $strings['AccessoryName'] = 'Nazwa akcesoria';
        $strings['QuantityAvailable'] = 'Dostepna iloœæ';
        $strings['Resources'] = 'Zasoby';
        $strings['Participants'] = 'Uczestnicy';
        $strings['User'] = 'Uzytkownik';
        $strings['Resource'] = 'Zasób';
        $strings['Status'] = 'Status';
        $strings['Approve'] = 'ZatwierdŸ';
        $strings['Page'] = 'Strona';
        $strings['Rows'] = 'Wierszy';
        $strings['Unlimited'] = 'Bez limitu';
        $strings['Email'] = 'Email';
        $strings['EmailAddress'] = 'Adres mailowy';
        $strings['Phone'] = 'Telefon';
        $strings['Organization'] = 'Firma';
        $strings['Position'] = 'Stanowisko';
        $strings['Language'] = 'Jêzyk';
        $strings['Permissions'] = 'Uprawnienia';
        $strings['Reset'] = 'Reset';
        $strings['FindGroup'] = 'ZnajdŸ grupê';
        $strings['Manage'] = 'Zarz¹dzaj';
        $strings['None'] = 'Brak';
        $strings['AddToOutlook'] = 'Dodaj do programu Microsoft Outlook';
        $strings['Done'] = 'Wykonaj';
        $strings['RememberMe'] = 'Zapamiêtaj mnie';
        $strings['FirstTimeUser?'] = 'Pierwszy raz tutaj?';
        $strings['CreateAnAccount'] = 'Zarejestruj siê';
        $strings['ViewSchedule'] = 'Podgl¹d rezerwacji';
        $strings['ForgotMyPassword'] = 'Zapomnia³eœ has³a?';
        $strings['YouWillBeEmailedANewPassword'] = 'Zostanie wys³ane nowo wygenerowane has³o na twój adres mailowy';
        $strings['Close'] = 'Zamknij';
        $strings['ExportToCSV'] = 'Eksportuj do CSV';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'Pracuje...';
        $strings['Login'] = 'Logowanie';
        $strings['AdditionalInformation'] = 'Dodatkowe informacje';
        $strings['AllFieldsAreRequired'] = 'wszystkie pola s¹ wymagane';
        $strings['Optional'] = 'opcjonalnie';
        $strings['YourProfileWasUpdated'] = 'Twój profil zosta³ zaktualizowany';
        $strings['YourSettingsWereUpdated'] = 'Twoje ustawenia zosta³y zmienione';
        $strings['Register'] = 'Rejestruj';
        $strings['SecurityCode'] = 'Kod zabezpieczaj¹cy';
        $strings['ReservationCreatedPreference'] = 'Kiedy tworzê rezerwacjê lub rezerwacja jest tworzona za mnie';
        $strings['ReservationUpdatedPreference'] = 'Kiedy aktualizujê rezerwacjê lub rezerwacja jest aktualizowana za mnie';
        $strings['ReservationApprovalPreference'] = 'Kiedy moje rezerwacja zostatnie zatwierdzona';
        $strings['PreferenceSendEmail'] = 'Powiadom mnie mailem';
        $strings['PreferenceNoEmail'] = 'Nie powiadamiaj mnie';
        $strings['ReservationCreated'] = 'Twoja rezerwacja zosta³a pomyœlnie utworzona!';
        $strings['ReservationUpdated'] = 'Twoja rezerwacja zosta³a pomyœlnie zaktualizowana!';
        $strings['ReservationRemoved'] = 'Twoja rezerwacja zosta³a pomyœlnie usuniêta';
        $strings['YourReferenceNumber'] = 'Numer twojej rezerwacji to %s';
        $strings['UpdatingReservation'] = 'Aktualizowanie rezerwacji';
        $strings['ChangeUser'] = 'Zmiana u¿ytkownika';
        $strings['MoreResources'] = 'Wiêcej zasobów';
        $strings['ReservationLength'] = 'D³ugoœæ rezerwacji';
        $strings['ParticipantList'] = 'Lista uczestników';
        $strings['AddParticipants'] = 'Dodaj uczestników';
        $strings['InviteOthers'] = 'Zaproœ innych';
        $strings['AddResources'] = 'Dodaj zasób';
        $strings['AddAccessories'] = 'Dodaj akcesoria';
        $strings['Accessory'] = 'Akcesorium';
        $strings['QuantityRequested'] = 'Wymagana iloœæ';
        $strings['CreatingReservation'] = 'Tworzenie rezerwacji';
        $strings['UpdatingReservation'] = 'Aktualizowanie rezerwacji';
        $strings['DeleteWarning'] = 'Tak akcja jest trwa³a i bez mo¿liwoœci powrotu!';
        $strings['DeleteAccessoryWarning'] = 'Usuniêcie tego akcesorium spowoduje usuniêcie go ze wszystkich rezerwacji.';
        $strings['AddAccessory'] = 'Dodaj akcesorium';
        $strings['AddBlackout'] = 'Dodaj niedostêpnoœæ';
        $strings['AllResourcesOn'] = 'Wszystkie zasoby w³¹czone';
        $strings['Reason'] = 'Powód';
        $strings['BlackoutShowMe'] = 'Poka¿ mi rezerwacje z konfliktem';
        $strings['BlackoutDeleteConflicts'] = 'Usuñ rezerwacje z konfliktem';
        $strings['Filter'] = 'Filtr';
        $strings['Between'] = 'Pomiêdzy';
        $strings['CreatedBy'] = 'Utworzone przez';
        $strings['BlackoutCreated'] = 'Niedostêpnoœæ utworzona!';
        $strings['BlackoutNotCreated'] = 'Niedostêpnoœc nie mog³a zostaæ utworzona!';
        $strings['BlackoutConflicts'] = 'Istniej¹ konflikty niedostêpnoœci';
        $strings['ReservationConflicts'] = 'Istniej¹ konflikty rezerwacji';
        $strings['UsersInGroup'] = 'Uzytkownicy w tej grupie';
        $strings['Browse'] = 'Przegl¹daj';
        $strings['DeleteGroupWarning'] = 'Usuniêcie tej grupy spowoduje wykasowanie wszystkich uprawnieñ do zasobów. U¿ytkownicy z tej grupy, mog¹ utraciæ uprawnienia do zasobów.';
        $strings['WhatRolesApplyToThisGroup'] = 'Jakie dodaæ role dla tej grupy?';
        $strings['WhoCanManageThisGroup'] = 'Kto mo¿e zarz¹dzaæ t¹ grup¹?';
        $strings['AddGroup'] = 'Dodaj grupê';
        $strings['AllQuotas'] = 'Dodaj Quotas';
        $strings['QuotaReminder'] = 'Pamiêtaj: Quotas s¹ egzekwowane na podstawie strefy czasowej harmonogramu';
        $strings['AllReservations'] = 'Wszystkie rezerwacje';
        $strings['PendingReservations'] = 'Oczekuj¹ce reserwacje';
        $strings['Approving'] = 'ZatwierdŸ';
        $strings['MoveToSchedule'] = 'Przenieœ do rezerwacji';
        $strings['DeleteResourceWarning'] = 'Usuniêcie tego zasobu spowoduje wykasowanie wszystkich danych, w³¹cznie z';
        $strings['DeleteResourceWarningReservations'] = 'jego wszystkimi przesz³ymi, obecnymi i przysz³ymi rezerwacjami';
        $strings['DeleteResourceWarningPermissions'] = 'wszystkimi przypisanymi uprawnieniami';
        $strings['DeleteResourceWarningReassign'] = 'Proszê przemysleæ dok³adnie zanim coœ zostanie usuniête';
        $strings['ScheduleLayout'] = 'Wygl¹d (zawsze %s)';
        $strings['ReservableTimeSlots'] = 'Lista wolnych terminów rezerwacji';
        $strings['BlockedTimeSlots'] = 'Lista zablokowanych terminów rezerwacji';
        $strings['ThisIsTheDefaultSchedule'] = 'To jest domyœlna rezerwacja';
        $strings['DefaultScheduleCannotBeDeleted'] = 'Domyœlna rezerwacja nie mo¿e zostaæ usuniêta';
        $strings['MakeDefault'] = 'Zrób domyœln¹';
        $strings['BringDown'] = 'OpóŸnij';
        $strings['ChangeLayout'] = 'Zmiana wygl¹du';
        $strings['AddSchedule'] = 'Dodaj rezerwacjê';
        $strings['StartsOn'] = 'Rozpoczyna siê';
        $strings['NumberOfDaysVisible'] = 'Liczba widocznych dni';
        $strings['UseSameLayoutAs'] = 'U¿yj tego samego wygl¹du jako';
        $strings['Format'] = 'Format';
        $strings['OptionalLabel'] = 'Opcjonalna nazwa';
        $strings['LayoutInstructions'] = 'Dodawaj jeden wpis w linii.  Wpisy musz¹ byæ uzupe³nione dla wszystkich 24 godzin od rozpoczêcia dnia a¿ do pó³nocy.';
        $strings['AddUser'] = 'Dodaj u¿ytkownika';
        $strings['UserPermissionInfo'] = 'Aktualny dostep do zasobu mo¿e byæ inny w zale¿noœci od roli u¿ytkownika, uprawnieñ grupy lub zewnêtrznych ustawieñ uprawnieñ';
        $strings['DeleteUserWarning'] = 'Usuniêcie tego u¿ytkownika spowoduje usuniêcie wszystkich kiedykolwiek utworzonych rezerwacji.';
        $strings['AddAnnouncement'] = 'Dodaj powiadomienie';
        $strings['Announcement'] = 'Powiadomienie';
        $strings['Priority'] = 'Wa¿noœæ';
        $strings['Reservable'] = 'Zastrze¿one';
        $strings['Unreservable'] = 'Niezastrze¿one';
        $strings['Reserved'] = 'Zarezerwowane';
        $strings['MyReservation'] = 'Moje rezerwacje';
        $strings['Pending'] = 'W oczekiwaniu';
        $strings['Past'] = 'Przesz³e';
        $strings['Restricted'] = 'Ograniczone';
        $strings['ViewAll'] = 'Podgl¹d wszystkich';
        $strings['MoveResourcesAndReservations'] = 'Przenieœ zasoby i rezerwacje do';

        // Errors
        $strings['LoginError'] = 'Nie mo¿emy odnaleŸæ twojej nazwy u¿ytkownika lub has³a';
        $strings['ReservationFailed'] = 'Twoja rezerwacja nie mog³a zostaæ utworzona';
        $strings['MinNoticeError'] = 'Ta rezerwacja wymaga dodatkowej uwagi.  Najwczeœniejsza data, która mo¿e byæ zarezerwowana to %s.';
        $strings['MaxNoticeError'] = 'Ta rezerwacja nie mo¿e byæ utworzona w tak odleg³ej przysz³oœci.  Najdalsz¹ dat¹ jest %s.';
        $strings['MinDurationError'] = 'Ta rezerwacja musi trwaæ co najmniej %s.';
        $strings['MaxDurationError'] = 'Ta rezerwacja nie mo¿e trwaæ d³u¿ej ni¿ %s.';
        $strings['ConflictingAccessoryDates'] = 'Brak wymaganej iloœci akcesoriów:';
        $strings['NoResourcePermission'] = 'Nie posiadasz uprawnieñ do co najmniej jednego zasobu z wybranych';
        $strings['ConflictingReservationDates'] = 'Istniej¹ konflikty rezerwacji w podanych dniach:';
        $strings['StartDateBeforeEndDateRule'] = 'Data rozpoczêcia musi byæ wczeœniejsza ni¿ data zakoñczenia';
        $strings['StartIsInPast'] = 'Data rozpoczêcia nie mo¿e byæ dat¹ z przesz³oœci';
        $strings['EmailDisabled'] = 'Administrator wy³¹czy³ powiadomienia mailowe';
        $strings['ValidLayoutRequired'] = 'Wpisy musz¹ byæ uzupe³nione dla wszystkich 24 godzin od rozpoczêcia dnia a¿ do pó³nocy.';

        // Page Titles
        $strings['CreateReservation'] = 'Tworzenie rezerwacji';
        $strings['EditReservation'] = 'Edycja rezerwacji';
        $strings['LogIn'] = 'Logowanie';
        $strings['ManageReservations'] = 'Rezerwacje';
        $strings['AwaitingActivation'] = 'W oczekiwaniu na aktywacjê';
        $strings['PendingApproval'] = 'W oczekiwaniu na zatwierdzenie';
        $strings['ManageSchedules'] = 'Rezerwacje';
        $strings['ManageResources'] = 'Zasoby';
        $strings['ManageAccessories'] = 'Akcesoria';
        $strings['ManageUsers'] = 'U¿ytkownicy';
        $strings['ManageGroups'] = 'Grupy';
        $strings['ManageQuotas'] = 'Quotas';
        $strings['ManageBlackouts'] = 'Zarz¹dzanie niedostêpnoœciami';
        $strings['MyDashboard'] = 'Moja strona';
        $strings['ServerSettings'] = 'Ustawienia serwera';
        $strings['Dashboard'] = 'Strona g³ówna';
        $strings['Help'] = 'Pomoc';
        $strings['Bookings'] = 'Terminarze';
        $strings['Schedule'] = 'Rezerwacja';
        $strings['Reservations'] = 'Rezerwacje';
        $strings['Account'] = 'Konto';
        $strings['EditProfile'] = 'Edycja mojego profilu';
        $strings['FindAnOpening'] = 'Znajdowanie otwarcia';
        $strings['OpenInvitations'] = 'Otwórz zaproszenia';
        $strings['MyCalendar'] = 'Mój kalendarz';
        $strings['ResourceCalendar'] = 'Kalendarz zasobu';
        $strings['Reservation'] = 'Nowa rezerwacja';
        $strings['Install'] = 'Instalacja';
        $strings['ChangePassword'] = 'Zmiana has³a';
        $strings['MyAccount'] = 'Moje konto';
        $strings['Profile'] = 'Profil';
        $strings['ApplicationManagement'] = 'Zarz¹dzanie aplikacj¹';
        $strings['ForgotPassword'] = 'Przypomnienie has³a';
        $strings['NotificationPreferences'] = 'Ustawienia powiadomieñ';
        $strings['ManageAnnouncements'] = 'Og³oszenia';
        //

        // Day representations
        $strings['DaySundaySingle'] = 'N';
        $strings['DayMondaySingle'] = 'Po';
        $strings['DayTuesdaySingle'] = 'W';
        $strings['DayWednesdaySingle'] = 'Œr';
        $strings['DayThursdaySingle'] = 'Cz';
        $strings['DayFridaySingle'] = 'Pi';
        $strings['DaySaturdaySingle'] = 'S';

        $strings['DaySundayAbbr'] = 'Nie';
        $strings['DayMondayAbbr'] = 'Pon';
        $strings['DayTuesdayAbbr'] = 'Wto';
        $strings['DayWednesdayAbbr'] = 'Œro';
        $strings['DayThursdayAbbr'] = 'Czw';
        $strings['DayFridayAbbr'] = 'Pi¹';
        $strings['DaySaturdayAbbr'] = 'Sob';

        // Email Subjects
        $strings['ReservationApprovedSubject'] = 'Twoja rezerwacja zosta³a zatwierdzona';
        $strings['ReservationCreatedSubject'] = 'Twoja rezerwacja zosta³a utworzona';
        $strings['ReservationUpdatedSubject'] = 'Twoja rezerwacja zosta³a zaktualizowana';
        $strings['ReservationCreatedAdminSubject'] = 'Powiadomienie: rezerwacja zosta³a utworzona';
        $strings['ReservationUpdatedAdminSubject'] = 'Powiadomienie: rezerwacja zosta³a zaktualizowana';
        $strings['ParticipantAddedSubject'] = 'Zg³oszenie udzia³u uczestnictwa';
        $strings['InviteeAddedSubject'] = 'Zaproszenie do uczestnictwa';
        $strings['ResetPassword'] = 'Zmiana has³a';
        $strings['ForgotPasswordEmailSent'] = 'Wiadomoœæ mailowa zosta³a wys³ana do odbiorcy z instrukcj¹ zresetowania has³a';
        //

        $this->Strings = $strings;
    }

    protected function _LoadDays()
    {
        $days = array();

        /***
        DAY NAMES
        All of these arrays MUST start with Sunday as the first element
        and go through the seven day week, ending on Saturday
         ***/
        // The full day name
        $days['full'] = array('Niedziela', 'Poniedzia³ek', 'Wtorek', 'Œroda', 'Czwartek', 'Pi¹tek', 'Sobota');
        // The three letter abbreviation
        $days['abbr'] = array('Nie', 'Pon', 'Wto', 'Œro', 'Czw', 'Pi¹', 'Sob');
        // The two letter abbreviation
        $days['two'] = array('Nd', 'Pn', 'Wt', 'Œr', 'Cz', 'Pt', 'Sb');
        // The one letter abbreviation
        $days['letter'] = array('N', 'Pn', 'W', 'Œ', 'Cz', 'Pt', 'S');

        $this->Days = $days;
    }

    protected function _LoadMonths()
    {
        $months = array();

        /***
        MONTH NAMES
        All of these arrays MUST start with January as the first element
        and go through the twelve months of the year, ending on December
         ***/
        // The full month name
        $months['full'] = array('Styczeñ', 'Luty', 'Marzec', 'Kwieceñ', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpieñ', 'Wrzesieñ', 'PaŸdziernik', 'Listopad', 'Grudzieñ');
        // The three letter month name
        $months['abbr'] = array('Sty', 'Lut', 'Mar', 'Kwi', 'Maj', 'Cze', 'Lip', 'Sie', 'Wrz', 'PaŸ', 'Lis', 'Gru');

        $this->Months = $months;
    }

    protected function _LoadLetters()
    {
        $this->Letters = array('A', 'B', 'C', 'Æ', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', '£', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'Œ', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '¯', '');
    }

    protected function _GetHtmlLangCode()
    {
        return 'pl';
    }
}

?>