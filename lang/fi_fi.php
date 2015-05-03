<?php
/**
Copyright 2011-2015 Nick Korbel

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

class fi_fi extends en_us
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

		$dates['general_date'] = 'j.n.Y';
		$dates['general_datetime'] = 'j.n.Y G.i.s';
		$dates['schedule_daily'] = 'l, j.n.Y';
		$dates['reservation_email'] = 'j.n.Y @ G.i';
		$dates['res_popup'] = 'j.n.Y G.i';
		$dates['dashboard'] = 'l, j.n.Y G.i';
		$dates['period_time'] = 'G.i';
		$dates['general_date_js'] = 'd.M.yyyy';
		$dates['calendar_time'] = 'h.mmt';
		$dates['calendar_dates'] = 'M d';

		$this->Dates = $dates;
	}

	/**
	 * @return array
	 */
	protected function _LoadStrings()
	{
		$strings = parent::_LoadStrings();

		$strings['FirstName'] = 'Etunimi';
		$strings['LastName'] = 'Sukunimi';
		$strings['Timezone'] = 'Aikavyöhyke';
		$strings['Edit'] = 'Muokkaa';
		$strings['Change'] = 'Vaihda';
		$strings['Rename'] = 'Nimeä uudelleen';
		$strings['Remove'] = 'Poista';
		$strings['Delete'] = 'Poista';
		$strings['Update'] = 'Päivitä';
		$strings['Cancel'] = 'Peruuta';
		$strings['Add'] = 'Lisää';
		$strings['Name'] = 'Nimi';
		$strings['Yes'] = 'Kyllä';
		$strings['No'] = 'Ei';
		$strings['FirstNameRequired'] = 'Etunimi vaaditaan.';
		$strings['LastNameRequired'] = 'Sukunimi vaaditaan.';
		$strings['PwMustMatch'] = 'Salasanan varmistuksen täytyy vastata salasanaan.';
		$strings['PwComplexity'] = 'Salasanan täytyy olla ainakin 6 merkkiä pitkä.';
		$strings['ValidEmailRequired'] = 'Voimassa oleva email osoite vaaditaan.';
		$strings['UniqueEmailRequired'] = 'Kyseisellä sähköpostiosoitteella on jo rekisteröidytty.';
		$strings['UniqueUsernameRequired'] = 'Käyttäjänimi on jo käytössä.';
		$strings['UserNameRequired'] = 'Käyttäjänimi vaaditaan.';
		$strings['CaptchaMustMatch'] = 'Ole hyvä ja kirjoita kuvakentässä olevat kirjaimet.';
		$strings['Today'] = 'Tänään';
		$strings['Week'] = 'Viikko';
		$strings['Month'] = 'Kuukausi';
		$strings['BackToCalendar'] = 'Takaisin kalenteriin';
		$strings['BeginDate'] = 'Alkaa';
		$strings['EndDate'] = 'Loppuu';
		$strings['Username'] = 'Käyttäjänimi';
		$strings['Password'] = 'Salasana';
		$strings['PasswordConfirmation'] = 'Varmista salasana';
		$strings['DefaultPage'] = 'Aloitussivu';
		$strings['MyCalendar'] = 'Oma kalenteri';
		$strings['ScheduleCalendar'] = 'Varauskalenteri';
		$strings['Registration'] = 'Rekisteröityminen';
		$strings['NoAnnouncements'] = 'Ei uusia ilmoituksia';
		$strings['Announcements'] = 'Ilmoitukset';
		$strings['NoUpcomingReservations'] = 'Sinulla ei ole tulossa olevia varauksia';
		$strings['UpcomingReservations'] = 'Tulossa olevat varaukset';
		$strings['ShowHide'] = 'Näytä/Piilota';
		$strings['Error'] = 'Virhe';
		$strings['ReturnToPreviousPage'] = 'Palaa edelliselle sivulle';
		$strings['UnknownError'] = 'Tuntematon virhe';
		$strings['InsufficientPermissionsError'] = 'Sinulla ei ole pääsyä tälle alueelle';
		$strings['MissingReservationResourceError'] = 'Resurssia ei valittu';
		$strings['MissingReservationScheduleError'] = 'Varausaikaa ei valittu';
		$strings['DoesNotRepeat'] = 'Ei toistuva';
		$strings['Daily'] = 'Päivittäinen';
		$strings['Weekly'] = 'Viikoittainen';
		$strings['Monthly'] = 'Kuukausittainen';
		$strings['Yearly'] = 'Vuosittainen';
		$strings['RepeatPrompt'] = 'Toistuva';
		$strings['hours'] = 'tunnit';
		$strings['days'] = 'päivät';
		$strings['weeks'] = 'viikot';
		$strings['months'] = 'kuukaudet';
		$strings['years'] = 'vuodet';
		$strings['day'] = 'päivä';
		$strings['week'] = 'viikko';
		$strings['month'] = 'kuukausi';
		$strings['year'] = 'vuosi';
		$strings['repeatDayOfMonth'] = 'kuukaudenpäivä';
		$strings['repeatDayOfWeek'] = 'viikonpäivä';
		$strings['RepeatUntilPrompt'] = 'Asti';
		$strings['RepeatEveryPrompt'] = 'Joka';
		$strings['RepeatDaysPrompt'] = '';
		$strings['CreateReservationHeading'] = 'Tee uusi varaus';
		$strings['EditReservationHeading'] = 'Muokkaa varauksia';
		$strings['ViewReservationHeading'] = 'Katso varauksia';
		$strings['ReservationErrors'] = 'Vaihda varausta';
		$strings['Create'] = 'Luo';
		$strings['ThisInstance'] = 'Vain tämä kerta';
		$strings['AllInstances'] = 'Joka kerta';
		$strings['FutureInstances'] = 'Tulossa olevat kerrat';
		$strings['Print'] = 'Tulosta';
		$strings['ShowHideNavigation'] = 'Näytä/piilota navigointi';
		$strings['ReferenceNumber'] = 'Varausnumero';
		$strings['Tomorrow'] = 'Huomenna';
		$strings['LaterThisWeek'] = 'Myöhemmin tällä viikolla';
		$strings['NextWeek'] = 'Seuraava viikko';
		$strings['SignOut'] = 'Kirjaudu ulos';
		$strings['LayoutDescription'] = 'Alkaa %s, näyttäen %s päivää kerralla';
		$strings['AllResources'] = 'Kaikki tilat';
		$strings['TakeOffline'] = 'Sulje';
		$strings['BringOnline'] = 'Aloita';
		$strings['AddImage'] = 'Lisää kuva';
		$strings['NoImage'] = 'Ei kuvaa määriteltynä';
		$strings['Move'] = 'Liiku';
		$strings['AppearsOn'] = 'Näkyy kohteessa %s';
		$strings['Location'] = 'Paikka';
		$strings['NoLocationLabel'] = '(paikkaa ei määritely)';
		$strings['Contact'] = 'Yhteystiedot';
		$strings['NoContactLabel'] = '(ei yhtystietoja)';
		$strings['Description'] = 'Kuvaus';
		$strings['NoDescriptionLabel'] = '(ei kuvausta)';
		$strings['Notes'] = 'Huomioitavaa';
		$strings['NoNotesLabel'] = '(ei huomioitavaa)';
		$strings['NoTitleLabel'] = '(ei otsikkoa)';
		$strings['UsageConfiguration'] = 'Käyttöasetukset';
		$strings['ChangeConfiguration'] = 'Vaihda asetuksia';
		$strings['ResourceMinLength'] = 'Varauksien pitää kestää vähintään %s';
		$strings['ResourceMinLengthNone'] = 'Varauksella ei ole vähittäiskestoa';
		$strings['ResourceMaxLength'] = 'Varaukset eivät voi kestää pitempään kuin %s';
		$strings['ResourceMaxLengthNone'] = 'Varauksilla ei ole maksimikestoa';
		$strings['ResourceRequiresApproval'] = 'Varaukset täytyy hyväksyä';
		$strings['ResourceRequiresApprovalNone'] = 'Varaukset eivät vaadi hyväksyntää';
		$strings['ResourcePermissionAutoGranted'] = 'Oikeudet hyväksytään automaattisesti';
		$strings['ResourcePermissionNotAutoGranted'] = 'Oikeudet myönnetään automaattisesti';
		$strings['ResourceMinNotice'] = 'Varaukset täytyy tehdä ennen %s aloitusaikaa';
		$strings['ResourceMinNoticeNone'] = 'Varauksia voidaan tehdä tähän aikaan asti';
		$strings['ResourceMaxNotice'] = 'Varaukset eivät voi loppua %s enempää tästä hetkestä katsoen';
		$strings['ResourceMaxNoticeNone'] = 'Varaukset voivat loppua milloin vain tulevaisuudessa';
		$strings['ResourceAllowMultiDay'] = 'Varauksia voi tehdä useiksi päiviksi';
		$strings['ResourceNotAllowMultiDay'] = 'Varauksia ei voi tehdä yön ajaksi';
		$strings['ResourceCapacity'] = 'Tällä resurssilla on kapasiteetti %s henkilölle';
		$strings['ResourceCapacityNone'] = 'Tällä resurssilla on rajoittamaton kapasiteetti';
		$strings['AddNewResource'] = 'Lisää uusi tila';
		$strings['AddNewUser'] = 'Lisää uusi käyttäjä';
		$strings['AddUser'] = 'Lisää käyttäjä';
		$strings['Schedule'] = 'Aikataulu';
		$strings['AddResource'] = 'Lisää tila';
		$strings['Capacity'] = 'Kapasiteetti';
		$strings['Access'] = 'Pääsy';
		$strings['Duration'] = 'Kesto';
		$strings['Active'] = 'Aktiivinen';
		$strings['Inactive'] = 'Ei-aktiivinen';
		$strings['ResetPassword'] = 'Vaihda salasana';
		$strings['LastLogin'] = 'Viimeinen kirjautuminen';
		$strings['Search'] = 'Etsi';
		$strings['ResourcePermissions'] = 'Tilan käyttöoikeidet';
		$strings['Reservations'] = 'Varaukset';
		$strings['Groups'] = 'Ryhmät';
		$strings['ResetPassword'] = 'Vaihda salasana';
		$strings['AllUsers'] = 'Kaikki käyttäjät';
		$strings['AllGroups'] = 'Kaikki ryhmät';
		$strings['AllSchedules'] = 'Kaikki waulut';
		$strings['UsernameOrEmail'] = 'Käyttäjänimi tai sähköpostiosoite';
		$strings['Members'] = 'Jäsenet';
		$strings['QuickSlotCreation'] = 'Luo kohta jokaiselle %s minuutille välillä %s - %s'; // TODO
		$strings['ApplyUpdatesTo'] = 'Lisää päivitykset';
		$strings['CancelParticipation'] = 'Peruuta osallistuminen';
		$strings['Attending'] = 'Osallistumassa';
		$strings['QuotaConfiguration'] = 'Kohteessa %s %s käyttäjälle %s on rajoitettu %s %s per %s'; // TODO
		$strings['reservations'] = 'varaukset';
		$strings['ChangeCalendar'] = 'Vaihda kalenteria';
		$strings['AddQuota'] = 'Lisää kiintiö';
		$strings['FindUser'] = 'Etsi käyttäjä';
		$strings['Created'] = 'Luotu';
		$strings['LastModified'] = 'Muokattu viimeksi';
		$strings['GroupName'] = 'Ryhmän nimi';
		$strings['GroupMembers'] = 'Ryhmän jäenet';
		$strings['GroupRoles'] = 'Ryhmän roolit';
		$strings['GroupAdmin'] = 'Ryhmän ylläpitäjä';
		$strings['Actions'] = 'Toiminnot';
		$strings['CurrentPassword'] = 'Nykyinen salasana';
		$strings['NewPassword'] = 'Uusi salasana';
		$strings['InvalidPassword'] = 'Väärä salasana';
		$strings['PasswordChangedSuccessfully'] = 'Salasanan vaihto onnistui';
		$strings['SignedInAs'] = 'Kirjautunut käyttäjänä: ';
		$strings['NotSignedIn'] = 'Et ole kirjautunut sisään';
		$strings['ReservationTitle'] = 'Varauksen otsikko';
		$strings['ReservationDescription'] = 'Varauksen kuvaus';
		$strings['ResourceList'] = 'Tilat varattaviksi';
		$strings['Accessories'] = 'Tarjoilu';
		$strings['Add'] = 'Lisää';
		$strings['ParticipantList'] = 'Osallistujat';
		$strings['InvitationList'] = 'Kutsutut';
		$strings['AccessoryName'] = 'Tarvike';
		$strings['QuantityAvailable'] = 'Käytettävissä oleva määrä';
		$strings['Resources'] = 'Tilat';
		$strings['Participants'] = 'Osallistujat';
		$strings['User'] = 'Käyttäjä';
		$strings['Resource'] = 'Tila';
		$strings['Status'] = 'Tila';
		$strings['Approve'] = 'Hyväksy';
		$strings['Page'] = 'Sivu';
		$strings['Rows'] = 'Rivit';
		$strings['Unlimited'] = 'Rajoittamaton';
		$strings['Email'] = 'Sähköposti';
		$strings['EmailAddress'] = 'Sähköpostisoite';
		$strings['Phone'] = 'Puhelin';
		$strings['Organization'] = 'Organisatio';
		$strings['Position'] = 'Rooli';
		$strings['OrganizationId'] = 'Y-tunnus';
		$strings['CreditorId'] = 'Laskutustunnus';
		$strings['StreetAddress'] = 'Katuosoite';
		$strings['ZipCode'] = 'Postinumero';
		$strings['City'] = 'Postitoimipaikka';
		$strings['Language'] = 'Kieli';
		$strings['Permissions'] = 'Oikeudet';
		$strings['Reset'] = 'Palauta';
		$strings['FindGroup'] = 'Etsi ryhmä';
		$strings['Manage'] = 'Hallitse';
		$strings['None'] = 'Ei mitään';
		$strings['AddToOutlook'] = 'Lisää Outlookiin';
		$strings['Done'] = 'Valmis';
		$strings['RememberMe'] = 'Muista minut';
		$strings['FirstTimeUser?'] = 'Uusi käyttäjä?';
		$strings['CreateAnAccount'] = 'Luo tili';
		$strings['ViewSchedule'] = 'Näytä aikataulu';
		$strings['ForgotMyPassword'] = 'Olen unohtanut salasanani';
		$strings['YouWillBeEmailedANewPassword'] = 'Sinulle lähetetään sähköpostilla uusi satunnainen salasana';
		$strings['Close'] = 'Sulje';
		$strings['ExportToCSV'] = 'Vie CSV-muotoon';
		$strings['OK'] = 'OK';
		$strings['Working'] = 'Työskennellään...';
		$strings['Login'] = 'Kirjaudu';
		$strings['AdditionalInformation'] = 'Lisätieto';
		$strings['AllFieldsAreRequired'] = 'kaikki kentät vaaditaan';
		$strings['Optional'] = 'valinnainen';
		$strings['YourProfileWasUpdated'] = 'Profiilisi on päivitetty';
		$strings['YourSettingsWereUpdated'] = 'Asetuksesi on päivitetty';
		$strings['Register'] = 'Rekisteröidy';
		$strings['SecurityCode'] = 'Turvakoodi';
		$strings['ReservationCreatedPreference'] = 'Kun teen varauksen tai varaus tehdään puolestani';
		$strings['ReservationUpdatedPreference'] = 'Kun päivitän varauksen tai varaus päivitetään puolestani';
		$strings['ReservationDeletedPreference'] = 'Kun poistan varauksen tai varaus poistetaan minun puolestani';
		$strings['ReservationApprovalPreference'] = 'Kun odottava varaukseni on hyväksytty';
		$strings['PreferenceSendEmail'] = 'Lähetä minulle sähköposti';
		$strings['PreferenceNoEmail'] = 'En tarvite muistutusta';
		$strings['ReservationCreated'] = 'Varauksesi on onnistuneesti luotu!';
		$strings['ReservationUpdated'] = 'Varauksesi on onnistuneesti päivitetty!';
		$strings['ReservationRemoved'] = 'Varauksesi on poistettu';
		$strings['YourReferenceNumber'] = 'Varauskoodisi on: %s';
		$strings['UpdatingReservation'] = 'Päivitä varaus';
		$strings['ChangeUser'] = 'Vaihda käyttäjä';
		$strings['MoreResources'] = 'Lisää varattavia tiloja';
		$strings['ReservationLength'] = 'Varauksen pituus';
		$strings['ParticipantList'] = 'Osallistujalista';
		$strings['AddParticipants'] = 'Lisää osallistujia';
		$strings['InviteOthers'] = 'Kutsu muita';
		$strings['AddResources'] = 'Lisää tiloja';
		$strings['AddAccessories'] = 'Lisää tarjottavaa';
		$strings['Accessory'] = 'Tarjottava';
		$strings['QuantityRequested'] = 'Pyydetty määrä';
		$strings['CreatingReservation'] = 'Varauksen luominen';
		$strings['UpdatingReservation'] = 'Varauksen päivittäminen';
		$strings['DeleteWarning'] = 'Tämä toiminto on pysyvä ja peruuttamaton!';
		$strings['DeleteAccessoryWarning'] = 'Tämän tarjottavan poistaminen poistaa sen kaikista varauksista.';
		$strings['AddAccessory'] = 'Lisää tarjottava';
		$strings['AddBlackout'] = 'Lisää varauksilta suljettu aika';
		$strings['AllResourcesOn'] = 'Kaikki tilat käytössä';
		$strings['Reason'] = 'Syy';
		$strings['BlackoutShowMe'] = 'Näytä ristiriitaiset varaukset';
		$strings['BlackoutDeleteConflicts'] = 'Poista ristiriidassa olevat varaukset';
		$strings['Filter'] = 'Suodata';
		$strings['Between'] = 'Välillä';
		$strings['CreatedBy'] = 'Tehnyt';
		$strings['BlackoutCreated'] = 'Suljettu aikaväli lisätty!';
		$strings['BlackoutNotCreated'] = 'Suljettua aikaväliä ei voitu luoda!';
		$strings['BlackoutConflicts'] = 'Ristiriidan aiheuttavat suljetut aikavälit';
		$strings['ReservationConflicts'] = 'Ristiriidassa olevat varaukset';
		$strings['UsersInGroup'] = 'Käyttäjät tässä ryhmässä';
		$strings['Browse'] = 'Selaa';
		$strings['DeleteGroupWarning'] = 'Tämän ryhmän poistaminen poistaa myös kaikki määritellyt resurssioikeudet.  Käyttäjät tässä ryhmässä menettävät oikeudet resursseihin.';
		$strings['WhatRolesApplyToThisGroup'] = 'Mitkä roolit koskevat tätä ryhmää?';
		$strings['WhoCanManageThisGroup'] = 'Kuka voi ylläpitää tätä ryhmää?';
		$strings['AddGroup'] = 'Lisää ryhmä';
		$strings['AllQuotas'] = 'Kaikki kiintiöt';
		$strings['QuotaReminder'] = 'Muista: rajoituksia sovelletaan varauskalenterin aikavyöhykkeen mukaisesti.';
		$strings['AllReservations'] = 'Kaikki varaukset';
		$strings['PendingReservations'] = 'Odottavat varaukset';
		$strings['Approving'] = 'Hyväksytään';
		$strings['MoveToSchedule'] = 'Siirry varauskalenteriin';
		$strings['DeleteResourceWarning'] = 'Tämän tilan poistaminen poistaa kaikki siihen liittyvät tiedot, mukaanlukien';
		$strings['DeleteResourceWarningReservations'] = 'kaikki siihen liittyvät menneet, nykyiset ja tulevat varaukset';
		$strings['DeleteResourceWarningPermissions'] = 'kaikki käyttöoikeusmääritykset';
		$strings['DeleteResourceWarningReassign'] = 'Määritä mitä et halua poistettavan ennen jatkamista';
		$strings['ScheduleLayout'] = 'Asettelu (kaikki ajat %s)';
		$strings['ReservableTimeSlots'] = 'Varattavat ajankohdat';
		$strings['BlockedTimeSlots'] = 'Estetyt ajankohdat';
		$strings['ThisIsTheDefaultSchedule'] = 'Tämä on oletusvarauskalenteri';
		$strings['DefaultScheduleCannotBeDeleted'] = 'Oletusvarauskalenteria ei voi poistaa';
		$strings['MakeDefault'] = 'Aseta oletukseksi';
		$strings['BringDown'] = 'Tyhjennä';
		$strings['ChangeLayout'] = 'Muuta ulkoasua';
		$strings['AddSchedule'] = 'Lisää kalenteri';
		$strings['StartsOn'] = 'Alkaa';
		$strings['NumberOfDaysVisible'] = 'Näkyvillä olevat päivät';
		$strings['UseSameLayoutAs'] = 'Käytä samaa ulkoasua kuin';
		$strings['Format'] = 'Tyyppi';
		$strings['OptionalLabel'] = 'Valinnainen rivi';
		$strings['LayoutInstructions'] = 'Lisää yksi kohta per rivi. Kohdat täytyy asettaa kaikille 24 tunnille alkaen ja loppuen 12:00.';
		$strings['AddUser'] = 'Lisää käyttäjä';
		$strings['UserPermissionInfo'] = 'Käyttöoikeus resurssiin voi olla erilainen riippuen käyttäjäroolista, ryhmäoikeuksista tai ylimääräisistä käyttöoikeusasetuksista';
		$strings['DeleteUserWarning'] = 'Poistamalla tämän käyttäjän poistat samalla kaikki hänen tulevat, menneet ja nykyiset varauksensa.';
		$strings['AddAnnouncement'] = 'Lisää ilmoitus';
		$strings['Announcement'] = 'Ilmoitus';
		$strings['Priority'] = 'Priotiteetti';
		$strings['Reservable'] = 'Varaamaton';
		$strings['Unreservable'] = 'Ei varattavissa';
		$strings['Reserved'] = 'Varattu';
		$strings['MyReservation'] = 'Minun varaukseni';
		$strings['Pending'] = 'Odottava';
		$strings['Past'] = 'Menneet';
		$strings['Restricted'] = 'Rajoitettu';
		$strings['ViewAll'] = 'Näytä kaikki';
		$strings['MoveResourcesAndReservations'] = 'Siirrä resurssit ja varaukset:';
		$strings['TurnOffSubscription'] = 'Lopeta kalenterin tilaus';
		$strings['TurnOnSubscription'] = 'Salli tämän kalenterin tilaaminen';
		$strings['SubscribeToCalendar'] = 'Tilaa kalenteri';
		$strings['SubscriptionsAreDisabled'] = 'Ylläpitäjä on poistanut tilaukset käytöstä';
		$strings['NoResourceAdministratorLabel'] = '(Ei resurssien ylläpitäjä)';
		$strings['WhoCanManageThisResource'] = 'Kuka ylläpitää tätä resurssia?';
		$strings['ResourceAdministrator'] = 'Resurssin ylläpitäjä';
		$strings['Private'] = 'Yksityinen';
		$strings['Accept'] = 'Hyväksy';
		$strings['Decline'] = 'Hylkää';
		// End Strings

		// Errors
		$strings['LoginError'] = 'Käyttäjänimi tai salasana on virheellinen';
		$strings['ReservationFailed'] = 'Varaustasi ei voitu toteuttaa';
		$strings['MinNoticeError'] = 'Tämä varaus on ilmoitettava etukäteen.  Aikaisin mahdollinen päivä varauksen tekemiseen on %s.';
		$strings['MaxNoticeError'] = 'Tätä varausta ei voi tehdä näin kauas tulevaisuuteen.  Viimeisin ajankohta joka voidaan varata on %s.';
		$strings['MinDurationError'] = 'Tämän varauksen tulee olla vähintään %s.';
		$strings['MaxDurationError'] = 'Tämä varaus ei voi kestää pitempään kuin %s.';
		$strings['ConflictingAccessoryDates'] = 'Seuraavia tarjoiltavia ei ole tarpeeksi: ';
		$strings['NoResourcePermission'] = 'Sinulla ei ole käyttöoikeutta yhteen tai useampaan tilaan';
		$strings['ConflictingReservationDates'] = 'Seuraavina päivinä on ristiriidan aiheuttavia toisia varauksia: ';
		$strings['StartDateBeforeEndDateRule'] = 'Aloituspäivän tulee olla ennen varauksen loppumispäivää';
		$strings['StartIsInPast'] = 'Aloituspäivä ei voi olla menneisyydessä';
		$strings['EmailDisabled'] = 'Moderaattori on estänyt automaattiset sähköposti-ilmoitukset';
		$strings['ValidLayoutRequired'] = 'Varaa kaikki 24 tuntia alkaen ja päättyen klo 00:00.';
		// End Errors

		// Page Titles
		$strings['CreateReservation'] = 'Tee varaus';
		$strings['EditReservation'] = 'Muokkaa varausta';
		$strings['LogIn'] = 'Kirjaudu';
		$strings['ManageReservations'] = 'Varaukset';
		$strings['AwaitingActivation'] = 'Odottaa aktivointia';
		$strings['PendingApproval'] = 'Odottaa hyväksymistä';
		$strings['ManageSchedules'] = 'Varauskalenterit';
		$strings['ManageResources'] = 'Varattavat tilat';
		$strings['ManageAccessories'] = 'Tarjoilut';
		$strings['ManageUsers'] = 'Käyttäjät';
		$strings['ManageGroups'] = 'Ryhmät';
		$strings['ManageQuotas'] = 'Kiintiöt';
		$strings['ManageBlackouts'] = 'Estetyt ajankohdat';
		$strings['MyDashboard'] = 'Oma työpöytä';
		$strings['ServerSettings'] = 'Palvelinasetukset';
		$strings['Dashboard'] = 'Työpöytä';
		$strings['Help'] = 'Ohje';
		$strings['Bookings'] = 'Tilatut varaukset';
		$strings['Schedule'] = 'Varauskalenteri';
		$strings['Reservations'] = 'Varaukset';
		$strings['Account'] = 'Tili';
		$strings['EditProfile'] = 'Muokkaa profiilia';
		$strings['FindAnOpening'] = 'Etsi alkukohta';
		$strings['OpenInvitations'] = 'Avaa kutsut';
		$strings['MyCalendar'] = 'Oma kalenteri';
		$strings['ResourceCalendar'] = 'Tilankäyttökalenteri';
		$strings['Reservation'] = 'Uusi varaus';
		$strings['Install'] = 'Asennus';
		$strings['ChangePassword'] = 'Vaihda salasana';
		$strings['MyAccount'] = 'Käyttäjätili';
		$strings['Profile'] = 'Profiili';
		$strings['ApplicationManagement'] = 'Ylläpito';
		$strings['ForgotPassword'] = 'Olen unohtanut salasanani';
		$strings['NotificationPreferences'] = 'Ilmoitusten asetukset';
		$strings['ManageAnnouncements'] = 'Ilmoitukset';
		// End Page Titles

		// Day representations
		$strings['DaySundaySingle'] = 'S';
		$strings['DayMondaySingle'] = 'M';
		$strings['DayTuesdaySingle'] = 'T';
		$strings['DayWednesdaySingle'] = 'K';
		$strings['DayThursdaySingle'] = 'T';
		$strings['DayFridaySingle'] = 'P';
		$strings['DaySaturdaySingle'] = 'L';

		$strings['DaySundayAbbr'] = 'Su';
		$strings['DayMondayAbbr'] = 'Ma';
		$strings['DayTuesdayAbbr'] = 'Ti';
		$strings['DayWednesdayAbbr'] = 'Ke';
		$strings['DayThursdayAbbr'] = 'To';
		$strings['DayFridayAbbr'] = 'Pe';
		$strings['DaySaturdayAbbr'] = 'La';

		// Email Subjects
		$strings['ReservationApprovedSubject'] = 'Varauksesi on hyväksytty';
		$strings['ReservationCreatedSubject'] = 'Varauksesi on tehty';
		$strings['ReservationUpdatedSubject'] = 'Varauksesi on päivitetty';
		$strings['ReservationDeletedSubject'] = 'Varauksesi on poistettu';
		$strings['ReservationCreatedAdminSubject'] = 'Ilmoitus: Varaus on tehty';
		$strings['ReservationUpdatedAdminSubject'] = 'Ilmoitus: Varaus on päivitetty';
		$strings['ReservationDeleteAdminSubject'] = 'Ilmoitus: Varaus on poistettu';
		$strings['ParticipantAddedSubject'] = 'Ilmoitus varaukseen osallistumisesta';
		$strings['ParticipantDeletedSubject'] = 'Varaus poistettu';
		$strings['InviteeAddedSubject'] = 'Varauskutsu';
		$strings['ResetPassword'] = 'Salasanan palautuspyyntö';
		$strings['ForgotPasswordEmailSent'] = 'Ohjeet salasanan palauttamiseksi lähetettiin antamaasi sähköpostiosoitteeseen';
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
		$days['full'] = array('Sunnuntai', 'Maanantai', 'Tiistai', 'Keskiviikko', 'Torstai', 'Perjantai', 'Lauantai');
		// The three letter abbreviation
		$days['abbr'] = array('Sun', 'Maa', 'Tii', 'Kes', 'Tor', 'Per', 'Lau');
		// The two letter abbreviation
		$days['two'] = array('Su', 'Ma', 'Ti', 'Ke', 'To', 'Pe', 'La');
		// The one letter abbreviation
		$days['letter'] = array('S', 'M', 'T', 'K', 'T', 'P', 'L');

		$this->Days = $days;
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
		$months['full'] = array('Tammikuu', 'Helmikuu', 'Maaliskuu', 'Huhtikuu', 'Toukokuu', 'Kesäkuu', 'Heinäkuu', 'Elokuu', 'Syyskuu', 'Lokakuu', 'Marraskuu', 'Joulukuu');
		// The three letter month name
		$months['abbr'] = array('Tam', 'Hel', 'Maa', 'Huh', 'Tou', 'Kes', 'Hei', 'Elo', 'Syy', 'Lok', 'Mar', 'Jou');

		$this->Months = $months;
	}

	/**
	 * @return array
	 */
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