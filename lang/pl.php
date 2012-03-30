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
require_once('en_us.php');

class pl extends en_us
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function _LoadDates()
    {
        $dates = parent::_LoadDates();

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
        $strings = parent::_LoadStrings();

        $strings['FirstName'] = 'Imi�';
        $strings['LastName'] = 'Nazwisko';
        $strings['Timezone'] = 'Strefa czasowa';
        $strings['Edit'] = 'Edycja';
        $strings['Change'] = 'Zmie�';
        $strings['Rename'] = 'Zmie� nazw�';
        $strings['Remove'] = 'Usu�';
        $strings['Delete'] = 'Skasuj';
        $strings['Update'] = 'Aktualizuj';
        $strings['Cancel'] = 'Anuluj';
        $strings['Add'] = 'Dodaj';
        $strings['Name'] = 'Nazwa';
        $strings['Yes'] = 'Tak';
        $strings['No'] = 'Nie';
        $strings['FirstNameRequired'] = 'Wymagane jest imi�.';
        $strings['LastNameRequired'] = 'Wymagane jest nazwisko.';
        $strings['PwMustMatch'] = 'Has�o potwierdzaj�ce musi by� identyczne.';
        $strings['PwComplexity'] = 'Has�o musi mie� co najmniej 6 znak�w, w tym ma�e i du�e litery oraz cyfry.';
        $strings['ValidEmailRequired'] = 'Wymagany poprawny adres mailowy.';
        $strings['UniqueEmailRequired'] = 'Wybrany adres mailowy ju� istnieje w bazie.';
        $strings['UniqueUsernameRequired'] = 'Wybrany u�ytkownik ju� istnieje w bazie.';
        $strings['UserNameRequired'] = 'Wymagana jest nazwa u�ytkownika.';
        $strings['CaptchaMustMatch'] = 'Wprowad� znaki z pokazanego obrazka.';
        $strings['Today'] = 'Dzi�';
        $strings['Week'] = 'Tydzie�';
        $strings['Month'] = 'Miesi�c';
        $strings['BackToCalendar'] = 'Powr�t do kalendarza';
        $strings['BeginDate'] = 'Pocz�tek';
        $strings['EndDate'] = 'Koniec';
        $strings['Username'] = 'Nazwa u�ytkownika';
        $strings['Password'] = 'Has�o';
        $strings['PasswordConfirmation'] = 'Potwierd� has�o';
        $strings['DefaultPage'] = 'Domy�lna strona g��wna';
        $strings['MyCalendar'] = 'M�j kalendarz';
        $strings['ScheduleCalendar'] = 'Terminarz';
        $strings['Registration'] = 'Rejestracja';
        $strings['NoAnnouncements'] = 'Brak powiadomie�';
        $strings['Announcements'] = 'Powiadomienia';
        $strings['NoUpcomingReservations'] = 'Nie masz �adnych zbli�aj�cych si� rezerwacji';
        $strings['UpcomingReservations'] = 'Zbli�aj�ce si� rezerwacje';
        $strings['ShowHide'] = 'Poka�/Ukryj';
        $strings['Error'] = 'B��d';
        $strings['ReturnToPreviousPage'] = 'Wr�c do poprzedniej strony...';
        $strings['UnknownError'] = 'Nieznany b��d';
        $strings['InsufficientPermissionsError'] = 'Nie masz uprawnie� do tego zasobu';
        $strings['MissingReservationResourceError'] = 'Zas�b nie zosta� wybrany';
        $strings['MissingReservationScheduleError'] = 'Termin nie zosta� wybrany';
        $strings['DoesNotRepeat'] = 'Bez powtarzania';
        $strings['Daily'] = 'Dziennie';
        $strings['Weekly'] = 'Tygodniowo';
        $strings['Monthly'] = 'Miesi�cznie';
        $strings['Yearly'] = 'Rocznie';
        $strings['RepeatPrompt'] = 'Powt�rka';
        $strings['hours'] = 'godziny';
        $strings['days'] = 'dni';
        $strings['weeks'] = 'tygodnie';
        $strings['months'] = 'miesi�ce';
        $strings['years'] = 'lata';
        $strings['day'] = 'dzie�';
        $strings['week'] = 'tydzie�';
        $strings['month'] = 'miesi�c';
        $strings['year'] = 'rok';
        $strings['repeatDayOfMonth'] = 'dnia miesi�ca';
        $strings['repeatDayOfWeek'] = 'dnia tygodnia';
        $strings['RepeatUntilPrompt'] = 'Do kiedy';
        $strings['RepeatEveryPrompt'] = 'Ka�dego';
        $strings['RepeatDaysPrompt'] = 'W��czone';
        $strings['CreateReservationHeading'] = 'Stw�rz now� rezerwacj�';
        $strings['EditReservationHeading'] = 'Edytuj rezerwacj� %s';
        $strings['ViewReservationHeading'] = 'Podgl�d rezerwacji %s';
        $strings['ReservationErrors'] = 'Zmie� rezerwacj�';
        $strings['Create'] = 'Stw�rz';
        $strings['ThisInstance'] = 'Tylko to wyst�pienie';
        $strings['AllInstances'] = 'Wszystkie wyst�pienia';
        $strings['FutureInstances'] = 'Przysz�e wyst�pienia';
        $strings['Print'] = 'Drukuj';
        $strings['ShowHideNavigation'] = 'Poka�/Ukryj Nawigacj�';
        $strings['ReferenceNumber'] = 'Numer referencyjny';
        $strings['Tomorrow'] = 'Jutro';
        $strings['LaterThisWeek'] = 'Jeszcze w tym tygodniu';
        $strings['NextWeek'] = 'Nast�pny tydzie�';
        $strings['SignOut'] = 'Wyloguj si�';
        $strings['LayoutDescription'] = 'Rozpoczyna si� %s, trwa %s dni';
        $strings['AllResources'] = 'Wszystkie zasoby';
        $strings['TakeOffline'] = 'Deaktywuj';
        $strings['BringOnline'] = 'Aktywuj';
        $strings['AddImage'] = 'Dodaj obraz';
        $strings['NoImage'] = 'Brak przypisanego obrazu';
        $strings['Move'] = 'Przesu�';
        $strings['AppearsOn'] = 'Utworzone dnia %s';
        $strings['Location'] = 'Lokalizacja';
        $strings['NoLocationLabel'] = '(brak ustawionej lokalizacji)';
        $strings['Contact'] = 'Kontakt';
        $strings['NoContactLabel'] = '(brak danych kontaktowych)';
        $strings['Description'] = 'Opis';
        $strings['NoDescriptionLabel'] = '(brak opisu)';
        $strings['Notes'] = 'Notatki';
        $strings['NoNotesLabel'] = '(brak notatek)';
        $strings['NoTitleLabel'] = '(brak tytu�u)';
        $strings['UsageConfiguration'] = 'Konfiguracja u�ycia';
        $strings['ChangeConfiguration'] = 'Zmie� konfiguracj�';
        $strings['ResourceMinLength'] = 'Rezerwacja musi trwa� co najmniej %s';
        $strings['ResourceMinLengthNone'] = 'Brak minimalnego czasu rezerwacji';
        $strings['ResourceMaxLength'] = 'Rezerwacja nie mo�e trwa� wi�cej ni� %s';
        $strings['ResourceMaxLengthNone'] = 'Brak maksymalnego czasu rezerwacji';
        $strings['ResourceRequiresApproval'] = 'Rezerwacja musi by� zatwierdzana';
        $strings['ResourceRequiresApprovalNone'] = 'Rezerwacja nie wymaga zatwierdzania';
        $strings['ResourcePermissionAutoGranted'] = 'Uprawnienia s� automatycznie nadawane';
        $strings['ResourcePermissionNotAutoGranted'] = 'Uprawnienia nie s� automatycznie nadawane';
        $strings['ResourceMinNotice'] = 'Rezerwacje musz� by� dokonane co najmniej %s przed rozpocz�ciem';
        $strings['ResourceMinNoticeNone'] = 'Rezerwacje mo�na dokona� a� do chwili rozpocz�cia';
        $strings['ResourceMaxNotice'] = 'Rezerwacja nie mo�e trwa� d�u�ej ni� %s od momentu rozpoczecia';
        $strings['ResourceMaxNoticeNone'] = 'Rezerwacja nie s� ograniczane czasowo';
        $strings['ResourceAllowMultiDay'] = 'Rezerwacje mo�na dokona� na wiele dni';
        $strings['ResourceNotAllowMultiDay'] = 'Rezerwacje nie mo�na dokona� na wiele dni';
        $strings['ResourceCapacity'] = 'Ten zas�b mo�e pomie�ci� maksymalnie os�b: %s ';
        $strings['ResourceCapacityNone'] = 'Ten zas�b ma nieograniczon� pojemno��';
        $strings['AddNewResource'] = 'Dodaj nowy zas�b';
        $strings['AddNewUser'] = 'Dodaj nowego u�ytkownika';
        $strings['AddUser'] = 'Dodaj u�ytkownika';
        $strings['Schedule'] = 'Terminarz';
        $strings['AddResource'] = 'Dodaj zas�b';
        $strings['Capacity'] = 'Pojemno��';
        $strings['Access'] = 'Dost�p';
        $strings['Duration'] = 'Czas trwania';
        $strings['Active'] = 'Aktywuj';
        $strings['Inactive'] = 'Deaktywuj';
        $strings['ResetPassword'] = 'Reset Has�a';
        $strings['LastLogin'] = 'Ostatnie logowanie';
        $strings['Search'] = 'Szukaj';
        $strings['ResourcePermissions'] = 'Uprawnienia do zasob�w';
        $strings['Reservations'] = 'Rezerwacje';
        $strings['Groups'] = 'Grupy';
        $strings['ResetPassword'] = 'Reset Has�a';
        $strings['AllUsers'] = 'Wszyscy u�ytkownicy';
        $strings['AllGroups'] = 'Wszystkie grupy';
        $strings['AllSchedules'] = 'Wszystkie rezerwacje';
        $strings['UsernameOrEmail'] = 'Nazwa u�ytkownika lub adres mailowy';
        $strings['Members'] = 'Cz�onkowie';
        $strings['QuickSlotCreation'] = 'Tw�rz wpisy co %s minut, pomi�dzy %s i %s';
        $strings['ApplyUpdatesTo'] = 'Uaktualnij';
        $strings['CancelParticipation'] = 'Anuluj uczestnictwo';
        $strings['Attending'] = 'Uczestnictwo';
        $strings['QuotaConfiguration'] = 'Na %s dla %s u�ytkownik�w w %s jest limitowana do %s %s przez %s';
        $strings['reservations'] = 'rezerwacje';
        $strings['ChangeCalendar'] = 'Zmie� kalendarz';
        $strings['AddQuota'] = 'Dodaj Quota';
        $strings['FindUser'] = 'Znajd� u�ytkownika';
        $strings['Created'] = 'Stworzony';
        $strings['LastModified'] = 'Ostatnia modyfikacja';
        $strings['GroupName'] = 'Nazwa grupy';
        $strings['GroupMembers'] = 'Cz�onkowie grupy';
        $strings['GroupRoles'] = 'Role grup';
        $strings['GroupAdmin'] = 'Grupa administrator�w';
        $strings['Actions'] = 'Akcje';
        $strings['CurrentPassword'] = 'Aktualne has�o';
        $strings['NewPassword'] = 'Nowe has�o';
        $strings['InvalidPassword'] = 'Wprwadzone has�o jest niepoprawne';
        $strings['PasswordChangedSuccessfully'] = 'Twoje has�o zosta�o zmienione';
        $strings['SignedInAs'] = 'Zalogowany jako';
        $strings['NotSignedIn'] = 'Nie jeste� zalogowany';
        $strings['ReservationTitle'] = 'Tytu� rezerwacji';
        $strings['ReservationDescription'] = 'Opis rezerwacji';
        $strings['ResourceList'] = 'Zasoby do zarezerwowania';
        $strings['Accessories'] = 'Akcesoria';
        $strings['Add'] = 'Dodaj';
        $strings['ParticipantList'] = 'Uczestnicy';
        $strings['InvitationList'] = 'Zaproszenia';
        $strings['AccessoryName'] = 'Nazwa akcesoria';
        $strings['QuantityAvailable'] = 'Dostepna ilo��';
        $strings['Resources'] = 'Zasoby';
        $strings['Participants'] = 'Uczestnicy';
        $strings['User'] = 'Uzytkownik';
        $strings['Resource'] = 'Zas�b';
        $strings['Status'] = 'Status';
        $strings['Approve'] = 'Zatwierd�';
        $strings['Page'] = 'Strona';
        $strings['Rows'] = 'Wierszy';
        $strings['Unlimited'] = 'Bez limitu';
        $strings['Email'] = 'Email';
        $strings['EmailAddress'] = 'Adres mailowy';
        $strings['Phone'] = 'Telefon';
        $strings['Organization'] = 'Firma';
        $strings['Position'] = 'Stanowisko';
        $strings['Language'] = 'J�zyk';
        $strings['Permissions'] = 'Uprawnienia';
        $strings['Reset'] = 'Reset';
        $strings['FindGroup'] = 'Znajd� grup�';
        $strings['Manage'] = 'Zarz�dzaj';
        $strings['None'] = 'Brak';
        $strings['AddToOutlook'] = 'Dodaj do programu Microsoft Outlook';
        $strings['Done'] = 'Wykonaj';
        $strings['RememberMe'] = 'Zapami�taj mnie';
        $strings['FirstTimeUser?'] = 'Pierwszy raz tutaj?';
        $strings['CreateAnAccount'] = 'Zarejestruj si�';
        $strings['ViewSchedule'] = 'Podgl�d rezerwacji';
        $strings['ForgotMyPassword'] = 'Zapomnia�e� has�a?';
        $strings['YouWillBeEmailedANewPassword'] = 'Zostanie wys�ane nowo wygenerowane has�o na tw�j adres mailowy';
        $strings['Close'] = 'Zamknij';
        $strings['ExportToCSV'] = 'Eksportuj do CSV';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'Pracuje...';
        $strings['Login'] = 'Logowanie';
        $strings['AdditionalInformation'] = 'Dodatkowe informacje';
        $strings['AllFieldsAreRequired'] = 'wszystkie pola s� wymagane';
        $strings['Optional'] = 'opcjonalnie';
        $strings['YourProfileWasUpdated'] = 'Tw�j profil zosta� zaktualizowany';
        $strings['YourSettingsWereUpdated'] = 'Twoje ustawenia zosta�y zmienione';
        $strings['Register'] = 'Rejestruj';
        $strings['SecurityCode'] = 'Kod zabezpieczaj�cy';
        $strings['ReservationCreatedPreference'] = 'Kiedy tworz� rezerwacj� lub rezerwacja jest tworzona za mnie';
        $strings['ReservationUpdatedPreference'] = 'Kiedy aktualizuj� rezerwacj� lub rezerwacja jest aktualizowana za mnie';
        $strings['ReservationApprovalPreference'] = 'Kiedy moje rezerwacja zostatnie zatwierdzona';
        $strings['PreferenceSendEmail'] = 'Powiadom mnie mailem';
        $strings['PreferenceNoEmail'] = 'Nie powiadamiaj mnie';
        $strings['ReservationCreated'] = 'Twoja rezerwacja zosta�a pomy�lnie utworzona!';
        $strings['ReservationUpdated'] = 'Twoja rezerwacja zosta�a pomy�lnie zaktualizowana!';
        $strings['ReservationRemoved'] = 'Twoja rezerwacja zosta�a pomy�lnie usuni�ta';
        $strings['YourReferenceNumber'] = 'Numer twojej rezerwacji to %s';
        $strings['UpdatingReservation'] = 'Aktualizowanie rezerwacji';
        $strings['ChangeUser'] = 'Zmiana u�ytkownika';
        $strings['MoreResources'] = 'Wi�cej zasob�w';
        $strings['ReservationLength'] = 'D�ugo�� rezerwacji';
        $strings['ParticipantList'] = 'Lista uczestnik�w';
        $strings['AddParticipants'] = 'Dodaj uczestnik�w';
        $strings['InviteOthers'] = 'Zapro� innych';
        $strings['AddResources'] = 'Dodaj zas�b';
        $strings['AddAccessories'] = 'Dodaj akcesoria';
        $strings['Accessory'] = 'Akcesorium';
        $strings['QuantityRequested'] = 'Wymagana ilo��';
        $strings['CreatingReservation'] = 'Tworzenie rezerwacji';
        $strings['UpdatingReservation'] = 'Aktualizowanie rezerwacji';
        $strings['DeleteWarning'] = 'Tak akcja jest trwa�a i bez mo�liwo�ci powrotu!';
        $strings['DeleteAccessoryWarning'] = 'Usuni�cie tego akcesorium spowoduje usuni�cie go ze wszystkich rezerwacji.';
        $strings['AddAccessory'] = 'Dodaj akcesorium';
        $strings['AddBlackout'] = 'Dodaj niedost�pno��';
        $strings['AllResourcesOn'] = 'Wszystkie zasoby w��czone';
        $strings['Reason'] = 'Pow�d';
        $strings['BlackoutShowMe'] = 'Poka� mi rezerwacje z konfliktem';
        $strings['BlackoutDeleteConflicts'] = 'Usu� rezerwacje z konfliktem';
        $strings['Filter'] = 'Filtr';
        $strings['Between'] = 'Pomi�dzy';
        $strings['CreatedBy'] = 'Utworzone przez';
        $strings['BlackoutCreated'] = 'Niedost�pno�� utworzona!';
        $strings['BlackoutNotCreated'] = 'Niedost�pno�c nie mog�a zosta� utworzona!';
        $strings['BlackoutConflicts'] = 'Istniej� konflikty niedost�pno�ci';
        $strings['ReservationConflicts'] = 'Istniej� konflikty rezerwacji';
        $strings['UsersInGroup'] = 'Uzytkownicy w tej grupie';
        $strings['Browse'] = 'Przegl�daj';
        $strings['DeleteGroupWarning'] = 'Usuni�cie tej grupy spowoduje wykasowanie wszystkich uprawnie� do zasob�w. U�ytkownicy z tej grupy, mog� utraci� uprawnienia do zasob�w.';
        $strings['WhatRolesApplyToThisGroup'] = 'Jakie doda� role dla tej grupy?';
        $strings['WhoCanManageThisGroup'] = 'Kto mo�e zarz�dza� t� grup�?';
        $strings['AddGroup'] = 'Dodaj grup�';
        $strings['AllQuotas'] = 'Dodaj Quotas';
        $strings['QuotaReminder'] = 'Pami�taj: Quotas s� egzekwowane na podstawie strefy czasowej harmonogramu';
        $strings['AllReservations'] = 'Wszystkie rezerwacje';
        $strings['PendingReservations'] = 'Oczekuj�ce reserwacje';
        $strings['Approving'] = 'Zatwierd�';
        $strings['MoveToSchedule'] = 'Przenie� do rezerwacji';
        $strings['DeleteResourceWarning'] = 'Usuni�cie tego zasobu spowoduje wykasowanie wszystkich danych, w��cznie z';
        $strings['DeleteResourceWarningReservations'] = 'jego wszystkimi przesz�ymi, obecnymi i przysz�ymi rezerwacjami';
        $strings['DeleteResourceWarningPermissions'] = 'wszystkimi przypisanymi uprawnieniami';
        $strings['DeleteResourceWarningReassign'] = 'Prosz� przemysle� dok�adnie zanim co� zostanie usuni�te';
        $strings['ScheduleLayout'] = 'Wygl�d (zawsze %s)';
        $strings['ReservableTimeSlots'] = 'Lista wolnych termin�w rezerwacji';
        $strings['BlockedTimeSlots'] = 'Lista zablokowanych termin�w rezerwacji';
        $strings['ThisIsTheDefaultSchedule'] = 'To jest domy�lna rezerwacja';
        $strings['DefaultScheduleCannotBeDeleted'] = 'Domy�lna rezerwacja nie mo�e zosta� usuni�ta';
        $strings['MakeDefault'] = 'Zr�b domy�ln�';
        $strings['BringDown'] = 'Op�nij';
        $strings['ChangeLayout'] = 'Zmiana wygl�du';
        $strings['AddSchedule'] = 'Dodaj rezerwacj�';
        $strings['StartsOn'] = 'Rozpoczyna si�';
        $strings['NumberOfDaysVisible'] = 'Liczba widocznych dni';
        $strings['UseSameLayoutAs'] = 'U�yj tego samego wygl�du jako';
        $strings['Format'] = 'Format';
        $strings['OptionalLabel'] = 'Opcjonalna nazwa';
        $strings['LayoutInstructions'] = 'Dodawaj jeden wpis w linii.  Wpisy musz� by� uzupe�nione dla wszystkich 24 godzin od rozpocz�cia dnia a� do p�nocy.';
        $strings['AddUser'] = 'Dodaj u�ytkownika';
        $strings['UserPermissionInfo'] = 'Aktualny dostep do zasobu mo�e by� inny w zale�no�ci od roli u�ytkownika, uprawnie� grupy lub zewn�trznych ustawie� uprawnie�';
        $strings['DeleteUserWarning'] = 'Usuni�cie tego u�ytkownika spowoduje usuni�cie wszystkich kiedykolwiek utworzonych rezerwacji.';
        $strings['AddAnnouncement'] = 'Dodaj powiadomienie';
        $strings['Announcement'] = 'Powiadomienie';
        $strings['Priority'] = 'Wa�no��';
        $strings['Reservable'] = 'Zastrze�one';
        $strings['Unreservable'] = 'Niezastrze�one';
        $strings['Reserved'] = 'Zarezerwowane';
        $strings['MyReservation'] = 'Moje rezerwacje';
        $strings['Pending'] = 'W oczekiwaniu';
        $strings['Past'] = 'Przesz�e';
        $strings['Restricted'] = 'Ograniczone';
        $strings['ViewAll'] = 'Podgl�d wszystkich';
        $strings['MoveResourcesAndReservations'] = 'Przenie� zasoby i rezerwacje do';

        // Errors
        $strings['LoginError'] = 'Nie mo�emy odnale�� twojej nazwy u�ytkownika lub has�a';
        $strings['ReservationFailed'] = 'Twoja rezerwacja nie mog�a zosta� utworzona';
        $strings['MinNoticeError'] = 'Ta rezerwacja wymaga dodatkowej uwagi.  Najwcze�niejsza data, kt�ra mo�e by� zarezerwowana to %s.';
        $strings['MaxNoticeError'] = 'Ta rezerwacja nie mo�e by� utworzona w tak odleg�ej przysz�o�ci.  Najdalsz� dat� jest %s.';
        $strings['MinDurationError'] = 'Ta rezerwacja musi trwa� co najmniej %s.';
        $strings['MaxDurationError'] = 'Ta rezerwacja nie mo�e trwa� d�u�ej ni� %s.';
        $strings['ConflictingAccessoryDates'] = 'Brak wymaganej ilo�ci akcesori�w:';
        $strings['NoResourcePermission'] = 'Nie posiadasz uprawnie� do co najmniej jednego zasobu z wybranych';
        $strings['ConflictingReservationDates'] = 'Istniej� konflikty rezerwacji w podanych dniach:';
        $strings['StartDateBeforeEndDateRule'] = 'Data rozpocz�cia musi by� wcze�niejsza ni� data zako�czenia';
        $strings['StartIsInPast'] = 'Data rozpocz�cia nie mo�e by� dat� z przesz�o�ci';
        $strings['EmailDisabled'] = 'Administrator wy��czy� powiadomienia mailowe';
        $strings['ValidLayoutRequired'] = 'Wpisy musz� by� uzupe�nione dla wszystkich 24 godzin od rozpocz�cia dnia a� do p�nocy.';

        // Page Titles
        $strings['CreateReservation'] = 'Tworzenie rezerwacji';
        $strings['EditReservation'] = 'Edycja rezerwacji';
        $strings['LogIn'] = 'Logowanie';
        $strings['ManageReservations'] = 'Rezerwacje';
        $strings['AwaitingActivation'] = 'W oczekiwaniu na aktywacj�';
        $strings['PendingApproval'] = 'W oczekiwaniu na zatwierdzenie';
        $strings['ManageSchedules'] = 'Rezerwacje';
        $strings['ManageResources'] = 'Zasoby';
        $strings['ManageAccessories'] = 'Akcesoria';
        $strings['ManageUsers'] = 'U�ytkownicy';
        $strings['ManageGroups'] = 'Grupy';
        $strings['ManageQuotas'] = 'Quotas';
        $strings['ManageBlackouts'] = 'Zarz�dzanie niedost�pno�ciami';
        $strings['MyDashboard'] = 'Moja strona';
        $strings['ServerSettings'] = 'Ustawienia serwera';
        $strings['Dashboard'] = 'Strona g��wna';
        $strings['Help'] = 'Pomoc';
        $strings['Bookings'] = 'Terminarze';
        $strings['Schedule'] = 'Rezerwacja';
        $strings['Reservations'] = 'Rezerwacje';
        $strings['Account'] = 'Konto';
        $strings['EditProfile'] = 'Edycja mojego profilu';
        $strings['FindAnOpening'] = 'Znajdowanie otwarcia';
        $strings['OpenInvitations'] = 'Otw�rz zaproszenia';
        $strings['MyCalendar'] = 'M�j kalendarz';
        $strings['ResourceCalendar'] = 'Kalendarz zasobu';
        $strings['Reservation'] = 'Nowa rezerwacja';
        $strings['Install'] = 'Instalacja';
        $strings['ChangePassword'] = 'Zmiana has�a';
        $strings['MyAccount'] = 'Moje konto';
        $strings['Profile'] = 'Profil';
        $strings['ApplicationManagement'] = 'Zarz�dzanie aplikacj�';
        $strings['ForgotPassword'] = 'Przypomnienie has�a';
        $strings['NotificationPreferences'] = 'Ustawienia powiadomie�';
        $strings['ManageAnnouncements'] = 'Og�oszenia';
        //

        // Day representations
        $strings['DaySundaySingle'] = 'N';
        $strings['DayMondaySingle'] = 'Po';
        $strings['DayTuesdaySingle'] = 'W';
        $strings['DayWednesdaySingle'] = '�r';
        $strings['DayThursdaySingle'] = 'Cz';
        $strings['DayFridaySingle'] = 'Pi';
        $strings['DaySaturdaySingle'] = 'S';

        $strings['DaySundayAbbr'] = 'Nie';
        $strings['DayMondayAbbr'] = 'Pon';
        $strings['DayTuesdayAbbr'] = 'Wto';
        $strings['DayWednesdayAbbr'] = '�ro';
        $strings['DayThursdayAbbr'] = 'Czw';
        $strings['DayFridayAbbr'] = 'Pi�';
        $strings['DaySaturdayAbbr'] = 'Sob';

        // Email Subjects
        $strings['ReservationApprovedSubject'] = 'Twoja rezerwacja zosta�a zatwierdzona';
        $strings['ReservationCreatedSubject'] = 'Twoja rezerwacja zosta�a utworzona';
        $strings['ReservationUpdatedSubject'] = 'Twoja rezerwacja zosta�a zaktualizowana';
        $strings['ReservationCreatedAdminSubject'] = 'Powiadomienie: rezerwacja zosta�a utworzona';
        $strings['ReservationUpdatedAdminSubject'] = 'Powiadomienie: rezerwacja zosta�a zaktualizowana';
        $strings['ParticipantAddedSubject'] = 'Zg�oszenie udzia�u uczestnictwa';
        $strings['InviteeAddedSubject'] = 'Zaproszenie do uczestnictwa';
        $strings['ResetPassword'] = 'Zmiana has�a';
        $strings['ForgotPasswordEmailSent'] = 'Wiadomo�� mailowa zosta�a wys�ana do odbiorcy z instrukcj� zresetowania has�a';
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
        $days['full'] = array('Niedziela', 'Poniedzia�ek', 'Wtorek', '�roda', 'Czwartek', 'Pi�tek', 'Sobota');
        // The three letter abbreviation
        $days['abbr'] = array('Nie', 'Pon', 'Wto', '�ro', 'Czw', 'Pi�', 'Sob');
        // The two letter abbreviation
        $days['two'] = array('Nd', 'Pn', 'Wt', '�r', 'Cz', 'Pt', 'Sb');
        // The one letter abbreviation
        $days['letter'] = array('N', 'Pn', 'W', '�', 'Cz', 'Pt', 'S');

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
        $months['full'] = array('Stycze�', 'Luty', 'Marzec', 'Kwiece�', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpie�', 'Wrzesie�', 'Pa�dziernik', 'Listopad', 'Grudzie�');
        // The three letter month name
        $months['abbr'] = array('Sty', 'Lut', 'Mar', 'Kwi', 'Maj', 'Cze', 'Lip', 'Sie', 'Wrz', 'Pa�', 'Lis', 'Gru');

        $this->Months = $months;
    }

    protected function _LoadLetters()
    {
        $this->Letters = array('A', 'B', 'C', '�', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', '�', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', '�', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '�', '�');
    }

    protected function _GetHtmlLangCode()
    {
        return 'pl';
    }
}

?>