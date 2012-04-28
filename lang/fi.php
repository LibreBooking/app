<?php
/**
Copyright

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

class fi extends en_us
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

        $strings['FirstName'] = 'Etunimi';
        $strings['LastName'] = 'Sukunimi';
        $strings['Timezone'] = 'Aikavyöhyke';
        $strings['Edit'] = 'Muokkaa';
        $strings['Change'] = 'Muuta';
        $strings['Rename'] = 'Uudelleennimeä';
        $strings['Remove'] = 'Poista';
        $strings['Delete'] = 'Poista';
        $strings['Update'] = 'Päivitä';
        $strings['Cancel'] = 'Peruuta';
        $strings['Add'] = 'Lisää';
        $strings['Name'] = 'Nimi';
        $strings['Yes'] = 'Kyllä';
        $strings['No'] = 'Ei';
        $strings['FirstNameRequired'] = 'Etunimi on pakollinen tieto';
        $strings['LastNameRequired'] = 'Sukunimi on pakollinen tieto';
        $strings['PwMustMatch'] = 'Salasana ja salasanan varmistus eivät vastaa toisiaan';
        $strings['PwComplexity'] = 'Salasanassa tulee olla vähintään 6 kirjainta tai numeroa';
        $strings['ValidEmailRequired'] = 'Sähköpostiosoite on virheellinen';
        $strings['UniqueEmailRequired'] = 'Sähköpostiosoite on jo varattu';
        $strings['UniqueUsernameRequired'] = 'Käyttäjätunnus on jo käytössä';
        $strings['UserNameRequired'] = 'Anna käyttäjätunnus';
        $strings['CaptchaMustMatch'] = 'Kirjoita kuvan kirjainyhdistelmä';
        $strings['Today'] = 'Tänään';
        $strings['Week'] = 'Viikko';
        $strings['Month'] = 'Kuukausi';
        $strings['BackToCalendar'] = 'Takaisin kalenteriin';
        $strings['BeginDate'] = 'Aloita';
        $strings['EndDate'] = 'Lopeta';
        $strings['Username'] = 'Käyttäjätunnus';
        $strings['Password'] = 'Salasana';
        $strings['PasswordConfirmation'] = 'Vahvista salasana';
        $strings['DefaultPage'] = 'Oletus Kotisivu';
        $strings['MyCalendar'] = 'Minun kalenterini';
        $strings['ScheduleCalendar'] = 'Ajasta kalenteri';
        $strings['Registration'] = 'Rekisteröidy';
        $strings['NoAnnouncements'] = 'Ei ilmoituksia';
        $strings['Announcements'] = 'Ilmoitukset';
        $strings['NoUpcomingReservations'] = 'Sinulla ei ole varauksia';
        $strings['UpcomingReservations'] = 'Tulevia varauksia';
        $strings['ShowHide'] = 'Näytä/piilota';
        $strings['Error'] = 'Virhe';
        $strings['ReturnToPreviousPage'] = 'Palaa viimeisimmäksi vieraillulle sivulle';
        $strings['UnknownError'] = 'Tuntematon virhe';
        $strings['InsufficientPermissionsError'] = 'Tämä ei ole käytössäsi';
        $strings['MissingReservationResourceError'] = 'Laite/väline valitsematta ';
        $strings['MissingReservationScheduleError'] = 'Aikataulu valitsematta';
        $strings['DoesNotRepeat'] = 'Ei voi toistaa';
        $strings['Daily'] = 'Päivittäin';
        $strings['Weekly'] = 'Joka viikko';
        $strings['Monthly'] = 'Joka kuukausi';
        $strings['Yearly'] = 'Joka vuosi';
        $strings['RepeatPrompt'] = 'Toista';
        $strings['hours'] = 'Tunnit';
        $strings['days'] = 'Päivät';
        $strings['weeks'] = 'Viikot';
        $strings['months'] = 'Kuukaudet';
        $strings['years'] = 'Vuodet';
        $strings['day'] = 'Päivä';
        $strings['week'] = 'Viikko';
        $strings['month'] = 'Kuukausi';
        $strings['year'] = 'Vuosi';
        $strings['repeatDayOfMonth'] = 'Kuukauden päivä';
        $strings['repeatDayOfWeek'] = 'Viikonpäivä';
        $strings['RepeatUntilPrompt'] = 'Asti';
        $strings['RepeatEveryPrompt'] = 'Joka';
        $strings['RepeatDaysPrompt'] = 'Kyllä';
        $strings['CreateReservationHeading'] = 'Tee uusi varaus';
        $strings['EditReservationHeading'] = 'Muokkaa varausta';
        $strings['ViewReservationHeading'] = 'Katso varausta';
        $strings['ReservationErrors'] = 'Muuta varausta';
        $strings['Create'] = 'Luo';
        $strings['ThisInstance'] = 'Vain tämä kohde';
        $strings['AllInstances'] = 'Kaikki kohteet';
        $strings['FutureInstances'] = 'Tulevat kohteet';
        $strings['Print'] = 'Tulosta';
        $strings['ShowHideNavigation'] = 'Näytä/piilota navigointi';
        $strings['ReferenceNumber'] = 'Referenssinumero';
        $strings['Tomorrow'] = 'Huominen';
        $strings['LaterThisWeek'] = 'Myöhemmin tällä viikolla';
        $strings['NextWeek'] = 'Seuraava viikko';
        $strings['SignOut'] = 'Poistu ajanvarauksesta';
        $strings['LayoutDescription'] = 'Alkaa %s, Näyttää %s päivää kerralla';
        $strings['AllResources'] = 'Kaikki tilat';
        $strings['TakeOffline'] = 'xTake Offline';
        $strings['BringOnline'] = 'xBring Online';
        $strings['AddImage'] = 'Lisää kuva';
        $strings['NoImage'] = 'Kuvaa ei ole lisätty';
        $strings['Move'] = 'Siirrä';
        $strings['AppearsOn'] = 'Löytyy %s';
        $strings['Location'] = 'Sijainti';
        $strings['NoLocationLabel'] = '(Sijaintia ei ole valittu)';
        $strings['Contact'] = 'Contact';
        $strings['NoContactLabel'] = '(Yhteystiedot puuttuu)';
        $strings['Description'] = 'Kuvaus';
        $strings['NoDescriptionLabel'] = '(Kuvaus puuttuu)';
        $strings['Notes'] = 'Muistiinpanot';
        $strings['NoNotesLabel'] = '(Ei muistiinpanoja)';
        $strings['NoTitleLabel'] = '(Ei otsikkoa)';
        $strings['UsageConfiguration'] = 'Konfigurointi';
        $strings['ChangeConfiguration'] = 'Muuta konfigurointia';
        $strings['ResourceMinLength'] = 'Varauksen tulee loppua viimeistään %s';
        $strings['ResourceMinLengthNone'] = 'Varauksen kestolla ei ole minimiä';
        $strings['ResourceMaxLength'] = 'Varauksen kesto voi olla maksimissaan %s';
        $strings['ResourceMaxLengthNone'] = 'Varauksen kestolla ei ole maksimia';
        $strings['ResourceRequiresApproval'] = 'Varaus tulee hyväksyä';
        $strings['ResourceRequiresApprovalNone'] = 'Varausta ei tarvitse hyväksyä';
        $strings['ResourcePermissionAutoGranted'] = 'Lupa hyväksytty automaattisesti';
        $strings['ResourcePermissionNotAutoGranted'] = 'Lupa vaatii vielä hyväksynnän';
        $strings['ResourceMinNotice'] = 'Varaus tehtävä viimeistään %s ennen varauksen alkua';
        $strings['ResourceMinNoticeNone'] = 'Varaus voi alkaa tästä hetkestä';
        $strings['ResourceMaxNotice'] = 'Varauksen tulee päättyä %s päästä nykyhetkestä';
        $strings['ResourceMaxNoticeNone'] = 'Varaus voi pituudeltan rajoittamaton';
        $strings['ResourceAllowMultiDay'] = 'Varaus voi olla useammalla päivällä';
        $strings['ResourceNotAllowMultiDay'] = 'Varausta ei voi tehdä useammalle päivälle';
        $strings['ResourceCapacity'] = 'Kapasiteetti on %s ihmistä';
        $strings['ResourceCapacityNone'] = 'Kapasiteetti on rajoittamaton';
        $strings['AddNewResource'] = 'Lisää uusi resurssi';
        $strings['AddNewUser'] = 'Lisää uusi käyttäjä';
        $strings['AddUser'] = 'Lisää käyttäjä';
        $strings['Schedule'] = 'Kalenteri';
        $strings['AddResource'] = 'Lisää resurssi';
        $strings['Capacity'] = 'Kapasiteetti';
        $strings['Access'] = 'Lupa';
        $strings['Duration'] = 'Kesto';
        $strings['Active'] = 'Aktiivinen';
        $strings['Inactive'] = 'Ei-aktiivinen';
        $strings['ResetPassword'] = 'Resetoi salasana';
        $strings['LastLogin'] = 'Viimeksi kirjautuneena';
        $strings['Search'] = 'Etsi';
        $strings['ResourcePermissions'] = 'Kohteen oikeudet';
        $strings['Reservations'] = 'Varaukset';
        $strings['Groups'] = 'Ryhmät';
        $strings['ResetPassword'] = 'Resetoi salasana';
        $strings['AllUsers'] = 'Kaikki käyttäjät';
        $strings['AllGroups'] = 'Kaikki ryhmät';
        $strings['AllSchedules'] = 'Kaikki aikataulut';
        $strings['UsernameOrEmail'] = 'Käyttäjätunnus tai sähköpostiosoite';
        $strings['Members'] = 'Jäsenet';
        $strings['QuickSlotCreation'] = 'Luo Slot %s minuuttia välille %s ja %s';
        $strings['ApplyUpdatesTo'] = 'Päivitä';
        $strings['CancelParticipation'] = 'Peruuta osanotto';
        $strings['Attending'] = 'Otan osaa';
        $strings['QuotaConfiguration'] = 'On %s for %s users in %s are limited to %s %s per %s';
        $strings['reservations'] = 'Varaukset';
        $strings['ChangeCalendar'] = 'Vaihda kalenteria';
        $strings['AddQuota'] = 'Lisää Quota';
        $strings['FindUser'] = 'Etsi käyttäjä';
        $strings['Created'] = 'Luotu';
        $strings['LastModified'] = 'Viimeksi päivitetty';
        $strings['GroupName'] = 'Ryhmän nimi';
        $strings['GroupMembers'] = 'Ryhmän jäsenet';
        $strings['GroupRoles'] = 'Ryhmän rooli';
        $strings['GroupAdmin'] = 'Ryhmän hallinnoija';
        $strings['Actions'] = 'Toimenpiteet';
        $strings['CurrentPassword'] = 'Nykyinen salasana';
        $strings['NewPassword'] = 'Uusi salasana';
        $strings['InvalidPassword'] = 'Nykyinen salasana on väärä';
        $strings['PasswordChangedSuccessfully'] = 'Salasanan muutettu onnistuneesti';
        $strings['SignedInAs'] = 'Olet kirjautuneena tunnuksella: ';
        $strings['NotSignedIn'] = 'Et ole kirjautuneena';
        $strings['ReservationTitle'] = 'Varauksen otsikko';
        $strings['ReservationDescription'] = 'Varauksen kuvaus';
        $strings['ResourceList'] = 'Varattavat kohteet';
        $strings['Accessories'] = 'Välineet/laitteet';
        $strings['Add'] = 'Lisää';
        $strings['ParticipantList'] = 'osanottajat';
        $strings['InvitationList'] = 'Kutsutut';
        $strings['AccessoryName'] = 'Välineen tai laitteen nimi';
        $strings['QuantityAvailable'] = 'Saatavilla oleva määrä';
        $strings['Resources'] = 'Resurssi';
        $strings['Participants'] = 'Osanottajat';
        $strings['User'] = 'Käytäjä';
        $strings['Resource'] = 'Resurssi';
        $strings['Status'] = 'Tila';
        $strings['Approve'] = 'Hyväksy';
        $strings['Page'] = 'Sivu';
        $strings['Rows'] = 'Rivit';
        $strings['Unlimited'] = 'Rajoittamaton';
        $strings['Email'] = 'Sähköposti';
        $strings['EmailAddress'] = 'Sähköpostiosoite';
        $strings['Phone'] = 'Puhelin';
        $strings['Organization'] = 'Organisaatio';
        $strings['Position'] = 'Asema';
        $strings['Language'] = 'Kieli';
        $strings['Permissions'] = 'Oikeudet';
        $strings['Reset'] = 'Resetoi';
        $strings['FindGroup'] = 'Etsi ryhmä';
        $strings['Manage'] = 'Hallitse';
        $strings['None'] = 'Ei yhtään';
        $strings['AddToOutlook'] = 'Lisää Outlook ohjelman';
        $strings['Done'] = 'Tehty';
        $strings['RememberMe'] = 'Muista minut';
        $strings['FirstTimeUser?'] = 'Ensimmäistä kertaa varaamassa?';
        $strings['CreateAnAccount'] = 'Luo käyttäjä';
        $strings['ViewSchedule'] = 'Katsoa aikataulua';
        $strings['ForgotMyPassword'] = 'Unohdin salasanan';
        $strings['YouWillBeEmailedANewPassword'] = 'Uusi salasanasi on lähetetty sähköpostiisi';
        $strings['Close'] = 'Sulje';
        $strings['ExportToCSV'] = 'Tee CSV';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'Toimii';
        $strings['Login'] = 'Login';
        $strings['AdditionalInformation'] = 'Lisätieto';
        $strings['AllFieldsAreRequired'] = 'Kaikki kentät ovat pakollisia';
        $strings['Optional'] = 'Valinnainen';
        $strings['YourProfileWasUpdated'] = 'Profiilisi on päivitetty';
        $strings['YourSettingsWereUpdated'] = 'Asetuksesi on päivitetty';
        $strings['Register'] = 'Rekisteröidy';
        $strings['SecurityCode'] = 'Turvakoodi';
        $strings['ReservationCreatedPreference'] = 'Aika, jolloin olen varannut tai se on tehty puolestani';
        $strings['ReservationUpdatedPreference'] = 'Aika, jolloin olen muuttanut varausta tai se on muutettu puolestani';
        $strings['ReservationDeletedPreference'] = 'Aika, jolloin olen poistanut varaukseni tai se on poistettu puolestani';
        $strings['ReservationApprovalPreference'] = 'Aika, jolloin varaus on hyväksytty';
        $strings['PreferenceSendEmail'] = 'Lähetä minulle sähköposti';
        $strings['PreferenceNoEmail'] = 'Älä muistuta minua';
        $strings['ReservationCreated'] = 'Varaus tehty!';
        $strings['ReservationUpdated'] = 'Varaus päivitetty!';
        $strings['ReservationRemoved'] = 'Varauksesi poistettu';
        $strings['YourReferenceNumber'] = 'Referenssinumerosi on %s ';
        $strings['UpdatingReservation'] = 'Päivittää varausta';
        $strings['ChangeUser'] = 'Vaihda käyttäjä';
        $strings['MoreResources'] = 'Lisää kohteita';
        $strings['ReservationLength'] = 'Varauksen pituus';
        $strings['ParticipantList'] = 'Osallistujaluettelo';
        $strings['AddParticipants'] = 'Lisää osallistujia';
        $strings['InviteOthers'] = 'Kutsu muita';
        $strings['AddResources'] = 'Lisää kohteita';
        $strings['AddAccessories'] = 'Lisää välineitä/laitteita';
        $strings['Accessory'] = 'Välineet/laitteet';
        $strings['QuantityRequested'] = 'Toivottu määrä';
        $strings['CreatingReservation'] = 'Luo varauksen';
        $strings['UpdatingReservation'] = 'Päivittää varauksen';
        $strings['DeleteWarning'] = 'Toimenpide on pysyvä ja sitä ei voi palauttaa!';
        $strings['DeleteAccessoryWarning'] = 'Laitteen/välineen poisto poistaa sen kaikista kohteista';
        $strings['AddAccessory'] = 'Lisää laite/väline';
        $strings['AddBlackout'] = 'xLisää Black out';
        $strings['AllResourcesOn'] ='Kaikki kohteet';
        $strings['Reason'] = 'Syy';
        $strings['BlackoutShowMe'] = 'Näytä ristiriitaiset varaukset';
        $strings['BlackoutDeleteConflicts'] = 'Poista ristiriitaiset varaukset';
        $strings['Filter'] = 'Suodata';
        $strings['Between'] = 'Välillä';
        $strings['CreatedBy'] = 'Luotu:';
        $strings['BlackoutCreated'] = 'xBlackout luotu!';
        $strings['BlackoutNotCreated'] = 'xBlackout Ei voitu luoda!';
        $strings['BlackoutConflicts'] = 'Ristiriitaisia blackout aikoja';
        $strings['ReservationConflicts'] = 'Ristiriitaisia varauksia';
        $strings['UsersInGroup'] = 'Ryhmän käyttäjät';
        $strings['Browse'] = 'Selaa';
        $strings['DeleteGroupWarning'] = 'Ryhmän poisto poistaa ryhmän jäsenten kaikki varaukset.';
        $strings['WhatRolesApplyToThisGroup'] = 'Roolit tässä ryhmässä';
        $strings['WhoCanManageThisGroup'] = 'Kuka voi hallinoida ryhmää?';
        $strings['AddGroup'] = 'Lisää ryhmä';
        $strings['AllQuotas'] = 'xKaikki Quotas';
        $strings['QuotaReminder'] = 'xMuista: Quota on sidottu aikavyöhykkeeseen';
        $strings['AllReservations'] = 'Kaikki varaukset';
        $strings['PendingReservations'] = 'Hyväksyntää odottavat varaukset';
        $strings['Approving'] = 'Hyväksyy';
        $strings['MoveToSchedule'] = 'Siirry aikatauluun';
        $strings['DeleteResourceWarning'] = 'Kohteen poistaminen tuhoaa kaikki tiedot, Mukaanlukien:';
        $strings['DeleteResourceWarningReservations'] = 'Kaikki menneet, nykyiset ja tulevat varaukset';
        $strings['DeleteResourceWarningPermissions'] = 'Kaikki oikeudet';
        $strings['DeleteResourceWarningReassign'] = 'xPlease reassign anything that you do not want to be deleted before proceeding';
        $strings['ScheduleLayout'] = 'Rakenne (Kaikki ajat %s)';
        $strings['ReservableTimeSlots'] = 'Varattavissa olevat ajat';
        $strings['BlockedTimeSlots'] = 'Ajat, jotka eivät ole varattavissa';
        $strings['ThisIsTheDefaultSchedule'] = 'Oletusaikataulu ';
        $strings['DefaultScheduleCannotBeDeleted'] = 'Oletusaikataullua ei voi poistaa';
        $strings['MakeDefault'] = 'Tee oletukseksi';
        $strings['BringDown'] = 'Tuo alas';
        $strings['ChangeLayout'] = 'Muuta rakennetta';
        $strings['AddSchedule'] = 'Lisää aikataulu';
        $strings['StartsOn'] = 'Alkaa';
        $strings['NumberOfDaysVisible'] = 'Päivien lukumäärä näkymässä';
        $strings['UseSameLayoutAs'] = 'Käytä samaa rakennetta kuin';
        $strings['Format'] = 'Format';
        $strings['OptionalLabel'] = 'xValinnainen label';
        $strings['LayoutInstructions'] = 'Anna yksi varaus rivillä.';
        $strings['AddUser'] = 'Lisää käyttäjä';
        $strings['UserPermissionInfo'] = 'Oikeudet vaihtelevat käyttäjien mukaan';
        $strings['DeleteUserWarning'] = 'Käyttäjän poistaminen poistaa kaikki käyttäjään liitetyt tiedot.';
        $strings['AddAnnouncement'] = 'Lisää tiedote';
        $strings['Announcement'] = 'Tiedote';
        $strings['Priority'] = 'Tärkeys';
        $strings['Reservable'] = 'Varattavissa';
        $strings['Unreservable'] = 'Ei varattavissa';
        $strings['Reserved'] = 'Varattu';
        $strings['MyReservation'] = 'Varaukseni';
        $strings['Pending'] = 'Odottaa hyväksyntää';
        $strings['Past'] = 'Menneet';
        $strings['Restricted'] = 'Ei oikeuksia';
        $strings['ViewAll'] = 'Katso kaikki';
        $strings['MoveResourcesAndReservations'] = 'Siirrä reurssit ja kohteet ';
        $strings['TurnOffSubscription'] = 'Sulje kalenterin tilaukset';
        $strings['TurnOnSubscription'] = 'Salli kalenterin tilaukset';
        $strings['SubscribeToCalendar'] = 'Tilaa kalenteri';
        $strings['SubscriptionsAreDisabled'] = 'Pääkäyttäjä on poistanut kalenterinti tilaukset';
        $strings['NoResourceAdministratorLabel'] = '(Ei kohteen pääkäyttäjää)';
        $strings['WhoCanManageThisResource'] = 'Kuka voi hallinoida kohdetta?';
        $strings['ResourceAdministrator'] = 'Pääkäyttäjä';
        $strings['Private'] = 'Yksityinen';
        $strings['Accept'] = 'Hyväksy';
        $strings['Decline'] = 'Estä';
        // End Strings

        // Errors
        $strings['LoginError'] = 'Käyttäjä ja salasana ei täsmää';
        $strings['ReservationFailed'] = 'Varaus ei onnistunut';
        $strings['MinNoticeError'] = 'Kohde on varattavissa aikaisintaan %s.';
        $strings['MaxNoticeError'] = 'Varaus voi olla voimassa %s asti.';
        $strings['MinDurationError'] = 'Varauksen keston tulee olla vähintään %s.';
        $strings['MaxDurationError'] = 'Varaus voi olla enintään %s.';
        $strings['ConflictingAccessoryDates'] = 'Seuraavia laitteita/välineitä ei ole riittävästi:';
        $strings['NoResourcePermission'] = 'Riittämättömät oikeudet';
        $strings['ConflictingReservationDates'] = 'Varauksessa ristiriitoja seuraavina päivinä:';
        $strings['StartDateBeforeEndDateRule'] = 'Varauksen alkupäivä pitää olla ennen loppupäivää';
        $strings['StartIsInPast'] = 'Alkupäivä ei voi olla menneisyydessä';
        $strings['EmailDisabled'] = 'Pääkäyttäjä on poistanut sähköpostitiedonannot';
        $strings['ValidLayoutRequired'] = 'xSlots must be provided for all 24 hours of the day beginning and ending at 12:00 AM.';
        // End Errors

        // Page Titles
        $strings['CreateReservation'] = 'VARAUS LUOTU';
        $strings['EditReservation'] = 'VARAUKSEN MUOKKAUS';
        $strings['LogIn'] = 'KIRJAUDU';
        $strings['ManageReservations'] = 'VARAUKSET';
        $strings['AwaitingActivation'] = 'ODOTTAA AKTIVOINTIA';
        $strings['PendingApproval'] = 'ODOTTAA HYVÄKSYNTÄÄ';
        $strings['ManageSchedules'] = 'AIKATAULUT';
        $strings['ManageResources'] = 'KOHTEET';
        $strings['ManageAccessories'] = 'LAITTEET/VÄLINEET';
        $strings['ManageUsers'] = 'KÄYTTÄJÄT';
        $strings['ManageGroups'] = 'RYHMÄT';
        $strings['ManageQuotas'] = 'xQuotas';
        $strings['ManageBlackouts'] = 'xBlackout AJAT';
        $strings['MyDashboard'] = 'TIETONI';
        $strings['ServerSettings'] = 'PALVELIMEN ASETUKSET';
        $strings['Dashboard'] = 'TIETONI';
        $strings['Help'] = 'OJHEET';
        $strings['Bookings'] = 'VARAUKSET';
        $strings['Schedule'] = 'AIKATAULUT';
        $strings['Reservations'] = 'VARAUKSET';
        $strings['Account'] = 'TILI';
        $strings['EditProfile'] = 'MUOKKAA PROFIILIA';
        $strings['FindAnOpening'] = 'xETSI An Opening';
        $strings['OpenInvitations'] = 'AVOIMET KUTSUT';
        $strings['MyCalendar'] = 'KALENTERINI';
        $strings['ResourceCalendar'] = 'KOHTEEN KALENTERI';
        $strings['Reservation'] = 'UUSI VARAUS';
        $strings['Install'] = 'ASENNUS';
        $strings['ChangePassword'] = 'VAIHDA SALASANAA';
        $strings['MyAccount'] = 'TILINI';
        $strings['Profile'] = 'PROFIILI';
        $strings['ApplicationManagement'] = 'SOVELLUSHALLINTA';
        $strings['ForgotPassword'] = 'UNOHTUNUT SALASANA';
        $strings['NotificationPreferences'] = 'ILMOITUS ASETUKSET';
        $strings['ManageAnnouncements'] = 'ILMOITUKSET';
        // End Page Titles

        // Day representations
        $strings['DaySundaySingle'] = 'Su';
        $strings['DayMondaySingle'] = 'Ma';
        $strings['DayTuesdaySingle'] = 'Ti';
        $strings['DayWednesdaySingle'] = 'Ke';
        $strings['DayThursdaySingle'] = 'To';
        $strings['DayFridaySingle'] = 'Pe';
        $strings['DaySaturdaySingle'] = 'La';

        $strings['DaySundayAbbr'] = 'Sun';
        $strings['DayMondayAbbr'] = 'Maa';
        $strings['DayTuesdayAbbr'] = 'Tii';
        $strings['DayWednesdayAbbr'] = 'Kes';
        $strings['DayThursdayAbbr'] = 'Tor';
        $strings['DayFridayAbbr'] = 'Per';
        $strings['DaySaturdayAbbr'] = 'Lau';

        // Email Subjects
        $strings['ReservationApprovedSubject'] = 'Varauksesi on hyväksytty';
        $strings['ReservationCreatedSubject'] = 'Varauksesi on luotu';
        $strings['ReservationUpdatedSubject'] = 'Varauksesi on päivitetty';
        $strings['ReservationDeletedSubject'] = 'Varauksesi on poistettu';
        $strings['ReservationCreatedAdminSubject'] = 'Ilmoitus: Varaus on tehty';
        $strings['ReservationUpdatedAdminSubject'] = 'Ilmoitus: Varausta on päivitetty';
        $strings['ReservationDeleteAdminSubject'] = 'Ilmoitus: Varaus on poistettu';
        $strings['ParticipantAddedSubject'] = 'xVarauksen ilmoitus osanottajille';
        $strings['ParticipantDeletedSubject'] = 'Varaus poistettu';
        $strings['InviteeAddedSubject'] = 'Varauskutsu';
        $strings['ResetPassword'] = 'Salasanan vaihtopyyntö';
        $strings['ForgotPasswordEmailSent'] = 'Vaihtaaksesi salasanan, toimi saamasi sähköpostin mukaisesti';
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
        $days['full'] = array('Sunnuntai', 'Maanantai', 'Tiistai', 'Keskiviikko', 'Torstai', 'Perjantai', 'Lauantai');
        // The three letter abbreviation
        $days['abbr'] = array('Sun', 'Maa', 'Tii', 'Kes', 'Tor', 'Per', 'Lau');
        // The two letter abbreviation
        $days['two'] = array('Su', 'Ma', 'Ti', 'Ke', 'To', 'Pe', 'La');
        // The one letter abbreviation
        $days['letter'] = array('S', 'M', 'T', 'K', 'T', 'P', 'L');

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
        $months['full'] = array('Tammikuu', 'Helmikuu', 'Maaliskuu', 'Huhtikuu', 'Toukokuu', 'Kesäkuu', 'Heinäkuu', 'Elokuu', 'Syyskuu', 'Lokakuu', 'Marraskuu', 'Joulukuu');
        // The three letter month name
        $months['abbr'] = array('Tam', 'Hel', 'Maa', 'Huh', 'Tou', 'Kes', 'Hei', 'Elo', 'Syy', 'Lok', 'Mar', 'Jou');

        $this->Months = $months;
    }

    protected function _LoadLetters()
    {
        $this->Letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    }

    protected function _GetHtmlLangCode()
    {
        return 'fi';
    }
}

?>