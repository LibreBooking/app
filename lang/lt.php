<?php
/**
Copyright 2011-2013 Nick Korbel

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

class en_us extends Language
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
		$dates = array();

		$dates['general_date'] = 'Y.m.d';
		$dates['general_datetime'] = 'Y.m.d H:i:s';
		$dates['schedule_daily'] = 'Y.m.d, l';
		$dates['reservation_email'] = 'Y.m.d @ H:i (e)';
		$dates['res_popup'] = 'Y.m.d H:i';
		$dates['dashboard'] = 'Y.m.d H:i, l';
		$dates['period_time'] = 'H:i';
		$dates['general_date_js'] = 'yy.mm.dd';
		$dates['calendar_time'] = 'h:mmt';
		$dates['calendar_dates'] = 'F d';

		$this->Dates = $dates;

		return $this->Dates;
	}

	/**
	 * @return array
	 */
	protected function _LoadStrings()
	{
		$strings = array();

		$strings['FirstName'] = 'Vardas';
		$strings['LastName'] = 'Pavardë';
		$strings['Timezone'] = 'Laiko juosta';
		$strings['Edit'] = 'Redaguoti';
		$strings['Change'] = 'Keisti';
		$strings['Rename'] = 'Pervadinti';
		$strings['Remove'] = 'Ðalinti';
		$strings['Delete'] = 'Trinti';
		$strings['Update'] = 'Atnaujinti';
		$strings['Cancel'] = 'Atðaukti';
		$strings['Add'] = 'Pridëti';
		$strings['Name'] = 'Pavadinimas';
		$strings['Yes'] = 'Taip';
		$strings['No'] = 'Ne';
		$strings['FirstNameRequired'] = 'Bûtina ávesti vardà.';
		$strings['LastNameRequired'] = 'Bûtina ávesti pavardæ.';
		$strings['PwMustMatch'] = 'Pakartotas slaptaþodis turi sutapti su slaptaþodþiu.';
		$strings['PwComplexity'] = 'Slaptaþodis turi bûti sudarytas ið bent 6 raidþiø, skaièiø ir þenklø.';
		$strings['ValidEmailRequired'] = 'Bûtina ávesti tikrà paðto adresà.';
		$strings['UniqueEmailRequired'] = 'Toks paðto adresas jau uþregistruotas.';
		$strings['UniqueUsernameRequired'] = 'Toks vartotojo vardas jau uþregistruotas.';
		$strings['UserNameRequired'] = 'Bûtina ávesti vartotojo vardà.';
		$strings['CaptchaMustMatch'] = 'Áveskite raides ið saugos paveikslëlio.';
		$strings['Today'] = 'Ðiandien';
		$strings['Week'] = 'Savaitë';
		$strings['Month'] = 'Mënuo';
		$strings['BackToCalendar'] = 'Atgal á kalendoriø';
		$strings['BeginDate'] = 'Pradþia';
		$strings['EndDate'] = 'Pabaiga';
		$strings['Username'] = 'Vartotojo vardas';
		$strings['Password'] = 'Slaptaþodis';
		$strings['PasswordConfirmation'] = 'Pakartokite slaptaþodá';
		$strings['DefaultPage'] = 'Numatytas pradinis puslapis';
		$strings['MyCalendar'] = 'Mano kalendorius';
		$strings['ScheduleCalendar'] = 'Tvarkaraðèiø kalendorius';
		$strings['Registration'] = 'Registracija';
		$strings['NoAnnouncements'] = 'Praneðimø nëra';
		$strings['Announcements'] = 'Praneðimai';
		$strings['NoUpcomingReservations'] = 'Jûs neturite artëjanèiø rezervacijø';
		$strings['UpcomingReservations'] = 'Artëjanèios rezervacijos';
		$strings['ShowHide'] = 'Rodyti/Slëpti';
		$strings['Error'] = 'Klaida';
		$strings['ReturnToPreviousPage'] = 'Gráþti á prieð tai buvusá puslapá.';
		$strings['UnknownError'] = 'Neþinoma klaida';
		$strings['InsufficientPermissionsError'] = 'Jûs neturite teisës naudotá ðá resursà.';
		$strings['MissingReservationResourceError'] = 'Nepasirinktas resursas';
		$strings['MissingReservationScheduleError'] = 'Nepasirinktas tvarkaraðtis';
		$strings['DoesNotRepeat'] = 'Nesikartoja';
		$strings['Daily'] = 'Kasdien';
		$strings['Weekly'] = 'Kiekvienà savaitæ';
		$strings['Monthly'] = 'Kiekvienà mënesá';
		$strings['Yearly'] = 'Kiekvienus metus';
		$strings['RepeatPrompt'] = 'Kartoti';
		$strings['hours'] = 'valandos';
		$strings['days'] = 'dienos';
		$strings['weeks'] = 'savaitës';
		$strings['months'] = 'mënesiai';
		$strings['years'] = 'metai';
		$strings['day'] = 'diena';
		$strings['week'] = 'savaitë';
		$strings['month'] = 'mënesis';
		$strings['year'] = 'metai';
		$strings['repeatDayOfMonth'] = 'mënesio diena';
		$strings['repeatDayOfWeek'] = 'savaitës diena';
		$strings['RepeatUntilPrompt'] = 'Iki';
		$strings['RepeatEveryPrompt'] = 'Kiekvienà';
		$strings['RepeatDaysPrompt'] = 'Savaitës dienà';
		$strings['CreateReservationHeading'] = 'Kurti naujà rezervacijà';
		$strings['EditReservationHeading'] = 'Redaguojama rezervacija %s';
		$strings['ViewReservationHeading'] = 'Perþiûrima rezervacija %s';
		$strings['ReservationErrors'] = 'Keisti rezervacijà';
		$strings['Create'] = 'Kurti';
		$strings['ThisInstance'] = 'Tik ðá kartà';
		$strings['AllInstances'] = 'Visai kartais';
		$strings['FutureInstances'] = 'Ateinanèiais kartais';
		$strings['Print'] = 'Spausdinti';
		$strings['ShowHideNavigation'] = 'Rotyti/Slëpti navigacijà';
		$strings['ReferenceNumber'] = 'Nuorodos numeris';
		$strings['Tomorrow'] = 'Rytoj';
		$strings['LaterThisWeek'] = 'Vëliau ðià savaitæ';
		$strings['NextWeek'] = 'Ateinanèià savaitæ';
		$strings['SignOut'] = 'Atsijungti';
		$strings['LayoutDescription'] = 'Savaitës pradþia - %s, rodoma po %s dienas/ø';
		$strings['AllResources'] = 'Visi resursai';
		$strings['TakeOffline'] = 'Padaryti nepasiekiamu';
		$strings['BringOnline'] = 'Padaryti pasiekiamu';
		$strings['AddImage'] = 'Pridëti paveikslëlá';
		$strings['NoImage'] = 'Paveikslëlis nepriskirtas';
		$strings['Move'] = 'Perkelti';
		$strings['AppearsOn'] = 'Átraukta á *%s*';
		$strings['Location'] = 'Vieta';
		$strings['NoLocationLabel'] = '(vieta nenurodyta)';
		$strings['Contact'] = 'Kontaktas susisiekimui';
		$strings['NoContactLabel'] = '(kontaktinë informacija nepateikta)';
		$strings['Description'] = 'Apraðymas';
		$strings['NoDescriptionLabel'] = '(apraðymas nepateiktas)';
		$strings['Notes'] = 'Pastabos';
		$strings['NoNotesLabel'] = '(uþraðø nëra)';
		$strings['NoTitleLabel'] = '(be pavadinimo)';
		$strings['UsageConfiguration'] = 'Konfiguracija naudojimui';
		$strings['ChangeConfiguration'] = 'Keisti konfiguracijà';
		$strings['ResourceMinLength'] = 'Rezervacija turi trukti bent %s';
		$strings['ResourceMinLengthNone'] = 'Minimali rezervacijos trukmë neribojama';
		$strings['ResourceMaxLength'] = 'Rezervacija negali trukti ilgiau nei %s';
		$strings['ResourceMaxLengthNone'] = 'Maksimali rezervacijos trukmë neribojama';
		$strings['ResourceRequiresApproval'] = 'Rezervacijos turi bûti patvirtintos';
		$strings['ResourceRequiresApprovalNone'] = 'Rezervacijai patvirtinimo nereikia';
		$strings['ResourcePermissionAutoGranted'] = 'Teisë suteikiama automatiðkai';
		$strings['ResourcePermissionNotAutoGranted'] = 'Teisë automatiðkai nesuteikiama';
		$strings['ResourceMinNotice'] = 'Rezervavimà atlikti likus bent %s iki jos pradþios';
		$strings['ResourceMinNoticeNone'] = 'Rezervuoti galima iki nurodyto laiko';
		$strings['ResourceMaxNotice'] = 'Rezervacija negali baigtis %s vëliau nurodyto laiko';
		$strings['ResourceMaxNoticeNone'] = 'Rezervacija gali baigtis bet kada';
		$strings['ResourceAllowMultiDay'] = 'Rezervacija galima per ðias dienas';
		$strings['ResourceNotAllowMultiDay'] = 'Rezervacija ðiomis dienomis negalima';
		$strings['ResourceCapacity'] = 'Ðis resursas talpina %s þmoniø';
		$strings['ResourceCapacityNone'] = 'Ðio resurso vietø skaièius neribotas';
		$strings['AddNewResource'] = 'Pridëti naujà resursà';
		$strings['AddNewUser'] = 'Pridëti naujà vartotojà';
		$strings['AddUser'] = 'Pridëti vartotojà';
		$strings['Schedule'] = 'Tvarkaraðtis';
		$strings['AddResource'] = 'Pridëti resursà';
		$strings['Capacity'] = 'Vietø skaièius';
		$strings['Access'] = 'Prieiga';
		$strings['Duration'] = 'Trukmë';
		$strings['Active'] = 'Aktyvus';
		$strings['Inactive'] = 'Neaktyvus';
		$strings['ResetPassword'] = 'Atstatyti slaptaþodá';
		$strings['LastLogin'] = 'Paskutinis prisijungimas';
		$strings['Search'] = 'Ieðkoti';
		$strings['ResourcePermissions'] = 'Resurso teisës';
		$strings['Reservations'] = 'Rezervacijos';
		$strings['Groups'] = 'Grupës';

		$strings['AllUsers'] = 'Visi vartotojai';
		$strings['AllGroups'] = 'Visos grupës';
		$strings['AllSchedules'] = 'Visi tvarkaraðèiai';
		$strings['UsernameOrEmail'] = 'Vartotojo vardas arba paðtas';
		$strings['Members'] = 'Nariai';
		$strings['QuickSlotCreation'] = 'Kurti niðas kas %s minutes nuo %s iki %s';
		$strings['ApplyUpdatesTo'] = 'Taikyti atnaujinimus';
		$strings['CancelParticipation'] = 'Atðaukti dalyvavimà';
		$strings['Attending'] = 'Dalyvavimas';
		$strings['QuotaConfiguration'] = 'On %s for %s users in %s are limited to %s %s per %s';
		$strings['reservations'] = 'rezervacijos';
		$strings['ChangeCalendar'] = 'Keisti kalendoriø';
		$strings['AddQuota'] = 'Pridëti kvotà';
		$strings['FindUser'] = 'Rasti vartotojà';
		$strings['Created'] = 'Sukurta';
		$strings['LastModified'] = 'Paskutiná kartà redaguotas';
		$strings['GroupName'] = 'Grupës pavadinimas';
		$strings['GroupMembers'] = 'Grupës nariai';
		$strings['GroupRoles'] = 'Grupës vaidmenys';
		$strings['GroupAdmin'] = 'Grupës administratorius';
		$strings['Actions'] = 'Veiksmai';
		$strings['CurrentPassword'] = 'Dabartinis slaptaþodis';
		$strings['NewPassword'] = 'Naujas slaptaþodis';
		$strings['InvalidPassword'] = 'Neteisingai ávestas dabartinis slaptaþodis';
		$strings['PasswordChangedSuccessfully'] = 'Jûsø slaptaþodis pakeistas sëkmingai';
		$strings['SignedInAs'] = 'Prisijungæs ðiuo vardu: ';
		$strings['NotSignedIn'] = 'Jûs neprisijungæs';
		$strings['ReservationTitle'] = 'Rezervacijos pavadinimas';
		$strings['ReservationDescription'] = 'Rezervacijos apraðymas';
		$strings['ResourceList'] = 'Rezervuojami resursai';
		$strings['Accessories'] = 'Priedai';
		$strings['ParticipantList'] = 'Dalyviai';
		$strings['InvitationList'] = 'Pakviestøjø sàraðas';
		$strings['AccessoryName'] = 'Priedo pavadinimas';
		$strings['QuantityAvailable'] = 'Likæs kiekis';
		$strings['Resources'] = 'Resursai';
		$strings['Participants'] = 'Dalyviai';
		$strings['User'] = 'Vartotojai';
		$strings['Resource'] = 'Resursas';
		$strings['Status'] = 'Bûsena';
		$strings['Approve'] = 'Patvirtinti';
		$strings['Page'] = 'Puslapis';
		$strings['Rows'] = 'Eilës';
		$strings['Unlimited'] = 'Neribota';
		$strings['Email'] = 'Paðtas';
		$strings['EmailAddress'] = 'Paðto adresas';
		$strings['Phone'] = 'Telefonas';
		$strings['Organization'] = 'Ámonë';
		$strings['Position'] = 'Pareigos';
		$strings['Language'] = 'Kalba';
		$strings['Permissions'] = 'Teisës';
		$strings['Reset'] = 'Atstatyti';
		$strings['FindGroup'] = 'Rasti grupæ';
		$strings['Manage'] = 'Valdyti';
		$strings['None'] = 'Nëra';
		$strings['AddToOutlook'] = 'Pridëti á kalendoriø';
		$strings['Done'] = 'Ávykdyta';
		$strings['RememberMe'] = 'Atsiminti mane';
		$strings['FirstTimeUser?'] = 'Pirmà kartà èia?';
		$strings['CreateAnAccount'] = 'Kûrti vartotojo prisijungimà';
		$strings['ViewSchedule'] = 'Þiûrëti tvarkaraðèius';
		$strings['ForgotMyPassword'] = 'Pamirðau slaptaþodá';
		$strings['YouWillBeEmailedANewPassword'] = 'Jums bus iðsiøstas laiðkas su atsitiktinai sugeneruotu slaptaþodþiu';
		$strings['Close'] = 'Uþdaryti';
		$strings['ExportToCSV'] = 'Eksportuoti CSV formatu';
		$strings['OK'] = 'OK';
		$strings['Working'] = 'Vykdoma';
		$strings['Login'] = 'Prisijungti';
		$strings['AdditionalInformation'] = 'Papildoma informacija';
		$strings['AllFieldsAreRequired'] = 'visi laukeliai yra bûtini';
		$strings['Optional'] = 'nebûtina';
		$strings['YourProfileWasUpdated'] = 'Jûsø profilis atnaujintas';
		$strings['YourSettingsWereUpdated'] = 'Jûsø nustatymai atnaujinti';
		$strings['Register'] = 'Registruotis';
		$strings['SecurityCode'] = 'Apsauginis kodas';
		$strings['ReservationCreatedPreference'] = 'Kai sukuriu rezervacijà, arba rezervacija sukuriama mano vardu';
		$strings['ReservationUpdatedPreference'] = 'Kai atnaujinu rezervacijà, arba rezervacijos duomenys atnaujinami mano vardu';
		$strings['ReservationDeletedPreference'] = 'Kai paðalinu rezervacijà, arba rezervacija paðalinama mano vardu';
		$strings['ReservationApprovalPreference'] = 'Kai mano laukiantis rezervacija patvirtinama';
		$strings['PreferenceSendEmail'] = 'Siøsti man laiðkà';
		$strings['PreferenceNoEmail'] = 'Nepraneðti';
		$strings['ReservationCreated'] = 'Jûsø rezervacija sukurta sëkmingai!';
		$strings['ReservationUpdated'] = 'Jûsø rezervacija atnaujinta sëkmingai!';
		$strings['ReservationRemoved'] = 'Jûsø rezervacija paðalinta';
		$strings['YourReferenceNumber'] = 'Jûsø nuorodos numeris %s';
		$strings['UpdatingReservation'] = 'Rezervacija atnaujinama';
		$strings['ChangeUser'] = 'Keisti vartotojà';
		$strings['MoreResources'] = 'Daugiau resursø';
		$strings['ReservationLength'] = 'Rezervacijos trukmë';
		$strings['ParticipantList'] = 'Dalyviø sàraðas';
		$strings['AddParticipants'] = 'Pridëti dalyviø';
		$strings['InviteOthers'] = 'Kviesti kitus';
		$strings['AddResources'] = 'Pridëti resursø';
		$strings['AddAccessories'] = 'Pridëti priedø';
		$strings['Accessory'] = 'Priedai';
		$strings['QuantityRequested'] = 'Praðomas kiekis';
		$strings['CreatingReservation'] = 'Rezervacija kuriama';
		$strings['UpdatingReservation'] = 'Rezervacija atnaujinama';
		$strings['DeleteWarning'] = 'Ðis veiksmas yra ilgalaikis ir negráþtamas!';
		$strings['DeleteAccessoryWarning'] = 'Iðtrynus ðá priedà, jis bus paðalintas ið visø rezervacijø.';
		$strings['AddAccessory'] = 'Pridëti priedà';
		$strings['AddBlackout'] = 'Add Blackout';
		$strings['AllResourcesOn'] = 'Visi resursai';
		$strings['Reason'] = 'Prieþastis';
		$strings['BlackoutShowMe'] = 'Rodyti susikertanèias rezervacija';
		$strings['BlackoutDeleteConflicts'] = 'Trinti susikertanèias rezervacijas';
		$strings['Filter'] = 'Filtruoti';
		$strings['Between'] = 'Tarp';
		$strings['CreatedBy'] = 'Sukûrë';
		$strings['BlackoutCreated'] = 'Blackout Created!';
		$strings['BlackoutNotCreated'] = 'Blackout could not be created!';
		$strings['BlackoutConflicts'] = 'There are conflicting blackout times';
		$strings['ReservationConflicts'] = 'Yra susikertantys rezervacijø laikai';
		$strings['UsersInGroup'] = 'Ðios grupës vartotojai';
		$strings['Browse'] = 'Narðyti';
		$strings['DeleteGroupWarning'] = 'Iðtrynus ðià grupæ, bus paðalintos su resursais susietos teisës. Vartotojai ið ðios grupës gali netekti teisës á resursus.';
		$strings['WhatRolesApplyToThisGroup'] = 'Kokie vaidmenys priskirti ðiai grupei?';
		$strings['WhoCanManageThisGroup'] = 'Kas gali valdyti ðià grupæ?';
		$strings['WhoCanManageThisSchedule'] = 'Kas gali valdyti ðá tvarkaraðtá?';
		$strings['AddGroup'] = 'Pridëti grupæ';
		$strings['AllQuotas'] = 'Visos kvotos';
		$strings['QuotaReminder'] = 'Atminkite: kvotos galioja pagal tvarkaraðèio laiko juostà.';
		$strings['AllReservations'] = 'Visos rezervacijos';
		$strings['PendingReservations'] = 'Laukianèios rezervacijos';
		$strings['Approving'] = 'Patvirtinama';
		$strings['MoveToSchedule'] = 'Perkelti á tvarkaraðtá';
		$strings['DeleteResourceWarning'] = 'Iðtrynus ðá resursà, bus iðtrinta ir visi susieti duomenys, áskaitant';
		$strings['DeleteResourceWarningReservations'] = 'visas susietas buvusias, esamas ir bûsimas rezervacijas';
		$strings['DeleteResourceWarningPermissions'] = 'visus teisiø priskyrimus';
		$strings['DeleteResourceWarningReassign'] = 'Praðome prieð tæsiant pakeisti priskyrimus, kuriø nenorite iðtrinti';
		$strings['ScheduleLayout'] = 'Laiko suskirstymas (visi laikai %s)';
		$strings['ReservableTimeSlots'] = 'Rezervuojama laiko niðà';
		$strings['BlockedTimeSlots'] = 'Uþdraustos laiko niðos';
		$strings['ThisIsTheDefaultSchedule'] = 'Tai yra numatytasis tvarkaraðtis';
		$strings['DefaultScheduleCannotBeDeleted'] = 'Numatytojo tvarkaraðèio iðtrinti negalima';
		$strings['MakeDefault'] = 'Padaryti numatytuoju';
		$strings['BringDown'] = 'Perkelti þemyn';
		$strings['ChangeLayout'] = 'Keisti laiko suskirstymà';
		$strings['AddSchedule'] = 'Pridëti tvarkaraðtá';
		$strings['StartsOn'] = 'Savaitës pradþia:';
		$strings['NumberOfDaysVisible'] = 'Kiek dienø rodoma';
		$strings['UseSameLayoutAs'] = 'Naudoti toká pat laiko suskirstymà kaip';
		$strings['Format'] = 'Formatuoti';
		$strings['OptionalLabel'] = 'Nebûtina þymë';
		$strings['LayoutInstructions'] = 'Áveskite po vienà niðà eilutëje. Ávestos niðos turi uþpildyti visà parà, pradedant vidurnakèiu ir juo baigiant.';
		$strings['AddUser'] = 'Pridëti vartotojà';
		$strings['UserPermissionInfo'] = 'Tikrasis resurso pasiekiamumas gali bûti skirtingas, priklausomai nuo vartotojo vaidmens, jo grupës teisiø, ar iðoriniø teisiø nustatymø.';
		$strings['DeleteUserWarning'] = 'Iðtrynus ðá vartotojà bus paðalinta visos jo buvusios ir bûsimos rezervacijos.';
		$strings['AddAnnouncement'] = 'Pridëti praneðimà';
		$strings['Announcement'] = 'Praneðimas';
		$strings['Priority'] = 'Prioritetas';
		$strings['Reservable'] = 'Galima rezervuoti';
		$strings['Unreservable'] = 'Rezervuoti negalima';
		$strings['Reserved'] = 'Jau rezervuotas';
		$strings['MyReservation'] = 'Mano rezervacijos';
		$strings['Pending'] = 'Laukianèios';
		$strings['Past'] = 'Buvusios';
		$strings['Restricted'] = 'Apribotos';
		$strings['ViewAll'] = 'Perþiûrëti visas/visus';
		$strings['MoveResourcesAndReservations'] = 'Perkelti resursus ir rezervacijas á';
		$strings['TurnOffSubscription'] = 'Iðjungti kalendoriaus prenumeratas';
		$strings['TurnOnSubscription'] = 'Leisti prenumeruoti ðá kalendoriø';
		$strings['SubscribeToCalendar'] = 'Prenumeruoti ðá kalendoriø';
		$strings['SubscriptionsAreDisabled'] = 'Administratorius yra uþdraudës kalendoriaus prenumeratà';
		$strings['NoResourceAdministratorLabel'] = '(Resurso niekas neadministruoja)';
		$strings['WhoCanManageThisResource'] = 'Kas gali valdyti ðá resursà?';
		$strings['ResourceAdministrator'] = 'Resurso administratorius';
		$strings['Private'] = 'Privatus';
		$strings['Accept'] = 'Priimti';
		$strings['Decline'] = 'Atmesti';
		$strings['ShowFullWeek'] = 'Rodyti visà savaitæ';
		$strings['CustomAttributes'] = 'Custom Attributes';
		$strings['AddAttribute'] = 'Pridëti atributà';
		$strings['EditAttribute'] = 'Atnaujinti atributà';
		$strings['DisplayLabel'] = 'Rodoma þymë';
		$strings['Type'] = 'Tipas';
		$strings['Required'] = 'Bûtina';
		$strings['ValidationExpression'] = 'Patvirtinimo iðraiðka / Validation Expression';
		$strings['PossibleValues'] = 'Galimos reikðmës';
		$strings['SingleLineTextbox'] = 'Vienos eilutës ávedimo laukelis';
		$strings['MultiLineTextbox'] = 'Keliø eiluèiø ávedimo laukelis';
		$strings['Checkbox'] = 'Þymëjimo laukelis (Checkbox)';
		$strings['SelectList'] = 'Pasirinkimo sàraðas (Select List)';
		$strings['CommaSeparated'] = 'kabletaðkiu atskirta';
		$strings['Category'] = 'Kategorija';
		$strings['CategoryReservation'] = 'Rezervacija';
		$strings['CategoryGroup'] = 'Grupë';
		$strings['SortOrder'] = 'Iðrikiavimo tvarka';
		$strings['Title'] = 'Pavadinimas';
		$strings['AdditionalAttributes'] = 'Papildomi atributai';
		$strings['True'] = 'Taip / True';
		$strings['False'] = 'Ne / False';
		$strings['ForgotPasswordEmailSent'] = 'Pateiktu paðto adresu iðsiøstas laiðkas su nurodymais, kaip atstatyti slaptaþodá';
		$strings['ActivationEmailSent'] = 'Greitai turëtumëte gauti aktyvavimo laiðkà.';
		$strings['AccountActivationError'] = 'Atsipraðome, negalëjome aktyvuoti jûsø vartotojo prisijungimo.';
		$strings['Attachments'] = 'Prisegtukai';
		$strings['AttachFile'] = 'Prisegti bylà';
		$strings['Maximum'] = 'max';
		$strings['NoScheduleAdministratorLabel'] = 'Tvarkaraðèio niekas neadministruoja';
		$strings['ScheduleAdministrator'] = 'Tvarkaraðèio administratorius';
		$strings['Total'] = 'Ið viso';
		$strings['QuantityReserved'] = 'Rezervuotas kiekis';
		$strings['AllAccessories'] = 'Visi priedai';
		$strings['GetReport'] = 'Gauti ataskaità';
		$strings['NoResultsFound'] = 'Nerasta jokiø rezultatø';
		$strings['SaveThisReport'] = 'Iðsaugoti ðià ataskaità';
		$strings['ReportSaved'] = 'Ataskaita iðsaugota!';
		$strings['EmailReport'] = 'Iðsiøsti ataskaità paðtu';
		$strings['ReportSent'] = 'Ataskaita iðsiøsta!';
		$strings['RunReport'] = 'Generuoti ataskaità';
		$strings['NoSavedReports'] = 'Jûs neturite iðsaugotø atasakaitø.';
		$strings['CurrentWeek'] = 'Ði savaitë';
		$strings['CurrentMonth'] = 'Ðis mënuo';
		$strings['AllTime'] = 'Visi laikai';
		$strings['FilterBy'] = 'Fitruoti pagal';
		$strings['Select'] = 'Pasirinkt';
		$strings['List'] = 'Sàraðas';
		$strings['TotalTime'] = 'Laiko suma';
		$strings['Count'] = 'Skaièius/Suma';
		$strings['Usage'] = 'Panaudojimas';
		$strings['AggregateBy'] = 'Rûðiuoti pagal';
		$strings['Range'] = 'Intervalas';
		$strings['Choose'] = 'Pasirinkti';
		$strings['All'] = 'Visi';
		$strings['ViewAsChart'] = 'Rodyti kaip diagramà';
		$strings['ReservedResources'] = 'Rezervuoti resursai';
		$strings['ReservedAccessories'] = 'Rezervuoti priedai';
		$strings['ResourceUsageTimeBooked'] = 'Resursø panaudojimas - bendras uþsakymø laikas';
		$strings['ResourceUsageReservationCount'] = 'Resursø panaudojimas - rezervacijø skaièius';
		$strings['Top20UsersTimeBooked'] = 'Top 20 vartotojø - pagal uþsakymø laikà';
		$strings['Top20UsersReservationCount'] = 'Top 20 vartotojø - pagal uþsakymø skaièiø';
		$strings['ConfigurationUpdated'] = 'Nustatymø byla atnaujinta';
		$strings['ConfigurationUiNotEnabled'] = 'Puslapis nepasiekiamas, nes nustatymø byloje eilutëje $conf[\'settings\'][\'pages\'][\'enable.configuration\'] nustatyta false, arba eilutës trûksta.';
		$strings['ConfigurationFileNotWritable'] = 'Nustatymø byla neáraðoma. Patikrinkite bylos teises ir bandykite dar kartà.';
		$strings['ConfigurationUpdateHelp'] = 'Apie ðiuos nustatymus skaitykite skyriuje Nustatymai, dokumente <a target=_blank href=%s>Pagalba</a>.';
		$strings['GeneralConfigSettings'] = 'nustatymai';
		$strings['UseSameLayoutForAllDays'] = 'Naudoti toká patá iðdëstymà visoms dienoms';
		$strings['LayoutVariesByDay'] = 'Iðdëstymas skirtingas kiekvienà dienà';
		$strings['ManageReminders'] = 'Priminimai';
		$strings['ReminderUser'] = 'Vartotojo ID';
		$strings['ReminderMessage'] = 'Þinutë';
		$strings['ReminderAddress'] = 'Adresai';
		$strings['ReminderSendtime'] = 'Kuriuo laiku siøsti';
		$strings['ReminderRefNumber'] = 'Rezervacijos nuorodos numeris';
		$strings['ReminderSendtimeDate'] = 'Priminimo data';
		$strings['ReminderSendtimeTime'] = 'Priminimo laikas (HH:MM)';
		$strings['ReminderSendtimeAMPM'] = 'AM / PM';
		$strings['AddReminder'] = 'Pridëti priminimà';
		$strings['DeleteReminderWarning'] = 'Trinate priminimà, gerai?';
		$strings['NoReminders'] = 'Neturite bûsimø priminimø.';
		$strings['Reminders'] = 'Priminimai';
		$strings['SendReminder'] = 'Siøsti priminimà';
		$strings['minutes'] = 'minutës';
		$strings['hours'] = 'valandos';
		$strings['days'] = 'dienos';
		$strings['ReminderBeforeStart'] = 'prieð pradþià';
		$strings['ReminderBeforeEnd'] = 'prieð pabaigà';
		$strings['Logo'] = 'Logo';
		$strings['CssFile'] = 'CSS byla';
		$strings['ThemeUploadSuccess'] = 'Jûsu pakeitimai iðsaugoti. Perkraukite puslapá, kad pamatytumëte pokyèius.';
		$strings['MakeDefaultSchedule'] = 'Padaryti tvarkaraðtá numatytuoju';
		$strings['DefaultScheduleSet'] = 'Tvarkaraðtis numatytasis';
		$strings['FlipSchedule'] = 'Apversti tvarkaraðèio iðdëstymà';
		$strings['Next'] = 'Toliau';
		$strings['Success'] = 'Ávykdytà sëkmingai';
		// End Strings

		// Install
		$strings['InstallApplication'] = 'Diegti phpScheduleIt (tik su MySQL)';
		$strings['IncorrectInstallPassword'] = 'Atsipraðome, slaptaþodis neteisingas.';
		$strings['SetInstallPassword'] = 'Nurodykite diegimo slaptaþodá prieð pradëdami diegimà.';
		$strings['InstallPasswordInstructions'] = 'Byloje %s pakeiskite eilutæ %s á slaptaþodá, kuris bûtø sunkiai atspëjamas, poto gráþkite á ðá puslapá.<br/>Galima panaudoti %s';
		$strings['NoUpgradeNeeded'] = 'Atnaujinimas nebûtinas. Leidþiant diegimà bus iðtrinta visi esami duomenys ir ádiegta nauja phpScheduleIt kopija!';
		$strings['ProvideInstallPassword'] = 'Pateikite ádiegimo slaptaþodá.';
		$strings['InstallPasswordLocation'] = 'Tai galima rasti %s , %s.';
		$strings['VerifyInstallSettings'] = 'Prieð tæsdami sutikrinkite numatytas reikðme. Arba jas galima keisti byloje %s.';
		$strings['DatabaseName'] = 'Duomenø bazës pavadinimas (Database Name)';
		$strings['DatabaseUser'] = 'DB vartoto prisijungimo vardas (Database User)';
		$strings['DatabaseHost'] = 'DB tarnybinës stoties pavadinimas (Database Host)';
		$strings['DatabaseCredentials'] = 'Bûtina pateikti MySQL prisijungimo duomenis, kurie turi teisæ kurti duomenø bazes (create database). Jei neþinote, klauskite savo duomenø baziø administratoriaus. Daugeliu atveju jungiantis root vardu viskas veiks.';
		$strings['MySQLUser'] = 'MySQL vartotojo vardas';
		$strings['InstallOptionsWarning'] = 'Ðie pasirinkimai, tikëtina, neveiks nuomojamoje aplinkoje (hosted enviroment). Tokiu atveju naudokite MySQL vedlio árankius.';
		$strings['CreateDatabase'] = 'Kurti duomenø bazæ';
		$strings['CreateDatabaseUser'] = 'Kurti duomenø bazës vartotojà';
		$strings['PopulateExampleData'] = 'Ákelti pavyzdinius duomenis. Bus sukurta administratoriaus paskyra: admin/password ir vartotojo paskyra: user/password';
		$strings['DataWipeWarning'] = 'Dëmesio: Bus iðtrinta visi esami duomenys';
		$strings['RunInstallation'] = 'Diegti';
		$strings['UpgradeNotice'] = 'Jûs atnaujinate ið versijos <b>%s</b> á versijà <b>%s</b>';
		$strings['RunUpgrade'] = 'Atnaujinti';
		$strings['Executing'] = 'Vykdoma';
		$strings['StatementFailed'] = 'Nepavyko. Smulkiau:';
		$strings['SQLStatement'] = 'SQL praneðimai:';
		$strings['ErrorCode'] = 'Klaidos kodas (Error Code):';
		$strings['ErrorText'] = 'Klaidos tekstas (Error Text):';
		$strings['InstallationSuccess'] = 'Diegimas baigtas sëkmingai!';
		$strings['RegisterAdminUser'] = 'Registruokite savo administratoriaus vartotojà. To reikia, jei nepasirinkote ákelti pavyzdiniø duomenø. Ásitikinkite, kad eilutë $conf[\'settings\'][\'allow.self.registration\'] = \'true\' yra byloje %s .';
		$strings['LoginWithSampleAccounts'] = 'Jei ákëlëte pavyzdinius duomenis, galite jungtis admin/password duomenimis administratoriaus vardu, arba user/password áprasto vartotojo vardu.';
		$strings['InstalledVersion'] = 'Naudojatës phpScheduleIt, versija %s ';
		$strings['InstallUpgradeConfig'] = 'Bûtina atnaujinti nustatymø bylà (config)';
		$strings['InstallationFailure'] = 'Diegiant nutiko bëdø. Pataisykite nesklandumus ir bandykite pakartoti diegimà.';
		$strings['ConfigureApplication'] = 'Nustatyti phpScheduleIt';
		$strings['ConfigUpdateSuccess'] = 'Jûsø nustatymø (config) byla dabar atnajinta!';
		$strings['ConfigUpdateFailure'] = 'Nepavyko automatiðkai atnaujinti nustatymø bylos (config). Pakeiskite bylos config.php turiná ðiuo tekstu:';
		// End Install

		// Errors
		$strings['LoginError'] = 'Netinkamas vartotojo vardas arba slaptaþodis';
		$strings['ReservationFailed'] = 'Nepavyko padaryti jûsø rezervacijos';
		$strings['MinNoticeError'] = 'Ði rezervacija reikalauja iðankstinio praneðimo. Anksèiausiai rezervuoti bus galima ðiuo laiku: %s.';
		$strings['MaxNoticeError'] = 'Negalima rezervuoti taip anksti. Vëliausias laikas kada galima bus rezervuoti: %s.';
		$strings['MinDurationError'] = 'Rezervacijaturi trukti bent %s.';
		$strings['MaxDurationError'] = 'Rezervacija negali tukti ilgiau nei %s.';
		$strings['ConflictingAccessoryDates'] = 'Nepakanka ðiø priedø:';
		$strings['NoResourcePermission'] = 'Neturite teisës vienam ar keliems praðomø resursø';
		$strings['ConflictingReservationDates'] = 'Yra susikertanèiø rezervacijø ðiuomis datomis:';
		$strings['StartDateBeforeEndDateRule'] = 'Pradþios laikas turi bûti anksèiau uþ pabaigos laikà';
		$strings['StartIsInPast'] = 'Pradþios laikas negali bûti praeityje';
		$strings['EmailDisabled'] = 'Administratorius iðjungæs perspëjimus paðtu';
		$strings['ValidLayoutRequired'] = 'Pateiktos niðos turi padengti visà parà nuo 00h iki 24h';
		$strings['CustomAttributeErrors'] = 'Kaþkas negerai su nurodytais papildomais atributais:';
		$strings['CustomAttributeRequired'] = '%s bûtina uþpildyti';
		$strings['CustomAttributeInvalid'] = 'Reikðmá ávesta á %s yra neteisinga';
		$strings['AttachmentLoadingError'] = 'Atsipraðoma, kaþkas nutiko ákeliant bylà.';
		$strings['InvalidAttachmentExtension'] = 'Galima ákelti tik ðiø tipø bylas: %s';
		$strings['InvalidStartSlot'] = 'Praðomas pradþios laikas ir data neteisingi.';
		$strings['InvalidEndSlot'] = 'Praðomas pabaigos laikas ir data neteisingi.';
		$strings['MaxParticipantsError'] = '%s telpa tik %s dalyviø.';
		$strings['ReservationCriticalError'] = 'Ávyko klaida iðsaugant jûsø rezervacijà. Jei tai kartosis, susisiekite su sistemos administratoriumi.';
		$strings['InvalidStartReminderTime'] = 'Pradþios priminimo laikas neteisingas.';
		$strings['InvalidEndReminderTime'] = 'Pabaigos priminimo laikas neteisingas.';
		// End Errors

		// Page Titles
		$strings['CreateReservation'] = 'Kûrti rezervacijà';
		$strings['EditReservation'] = 'Redaguoti rezervacijà';
		$strings['LogIn'] = 'Prisijungti';
		$strings['ManageReservations'] = 'Rezervacijos';
		$strings['AwaitingActivation'] = 'Laukia aktyvacijos';
		$strings['PendingApproval'] = 'Laukia patvirtinimo';
		$strings['ManageSchedules'] = 'Tvarkaraðèiai';
		$strings['ManageResources'] = 'Resursai';
		$strings['ManageAccessories'] = 'Priedai';
		$strings['ManageUsers'] = 'Vartotojai';
		$strings['ManageGroups'] = 'Grupës';
		$strings['ManageQuotas'] = 'Kvotos';
		$strings['ManageBlackouts'] = 'Blackout Times';
		$strings['MyDashboard'] = 'Mano pradinis puslapis';
		$strings['ServerSettings'] = 'Serverio nustatymai';
		$strings['Dashboard'] = 'Pradinis puslapis';
		$strings['Help'] = 'Pagalba';
		$strings['Administration'] = 'Administravimas';
		$strings['About'] = 'Apie';
		$strings['Bookings'] = 'Uþsakymai';
		$strings['Schedule'] = 'Tvarkaraðtis';
		$strings['Reservations'] = 'Rezervacijos';
		$strings['Account'] = 'Vartotojø prisijungimai';
		$strings['EditProfile'] = 'Redaguoti mano profilá';
		$strings['FindAnOpening'] = 'Rasti, kada bus laisva';
		$strings['OpenInvitations'] = 'Atviri kvietimai';
		$strings['MyCalendar'] = 'Mano kalendorius';
		$strings['ResourceCalendar'] = 'Resursø kalendorius';
		$strings['Reservation'] = 'Nauja rezervacija';
		$strings['Install'] = 'Diegimas';
		$strings['ChangePassword'] = 'Keisti slaptaþodá';
		$strings['MyAccount'] = 'Mano prisijungimo sàskaita';
		$strings['Profile'] = 'Profilis';
		$strings['ApplicationManagement'] = 'Sistemos valdymas';
		$strings['ForgotPassword'] = 'Pamirðau slaptaþodá';
		$strings['NotificationPreferences'] = 'Perspëjimø nustatymai';
		$strings['ManageAnnouncements'] = 'Praneðimai';
		$strings['Responsibilities'] = 'Atsakomybës';
		$strings['GroupReservations'] = 'Grupës rezervavimai';
		$strings['ResourceReservations'] = 'Resursø rezervacijos';
		$strings['Customization'] = 'Tinkinimas';
		$strings['Attributes'] = 'Atributai';
		$strings['AccountActivation'] = 'Vartotojo sàskaitos aktyvavimas';
		$strings['ScheduleReservations'] = 'Tvarkaraðèio rezervacijos';
		$strings['Reports'] = 'Ataskaitos';
		$strings['GenerateReport'] = 'Kurti naujà ataskaità';
		$strings['MySavedReports'] = 'Mano iðsaugotos ataskaitos';
		$strings['CommonReports'] = 'Áprastos ataskaitos';
		$strings['ViewDay'] = 'Perþiûrëti dienà';
		$strings['Group'] = 'Grupë';
		$strings['ManageConfiguration'] = 'Programos nustatymai';
		$strings['LookAndFeel'] = 'Look and Feel';
		// End Page Titles

		// Day representations
		$strings['DaySundaySingle'] = 'S';
		$strings['DayMondaySingle'] = 'P';
		$strings['DayTuesdaySingle'] = 'A';
		$strings['DayWednesdaySingle'] = 'T';
		$strings['DayThursdaySingle'] = 'K';
		$strings['DayFridaySingle'] = 'P';
		$strings['DaySaturdaySingle'] = 'Ð';

		$strings['DaySundayAbbr'] = 'Sk';
		$strings['DayMondayAbbr'] = 'Pr';
		$strings['DayTuesdayAbbr'] = 'An';
		$strings['DayWednesdayAbbr'] = 'Tr';
		$strings['DayThursdayAbbr'] = 'Kt';
		$strings['DayFridayAbbr'] = 'Pn';
		$strings['DaySaturdayAbbr'] = 'Ðt';
		// End Day representations

		// Email Subjects
		$strings['ReservationApprovedSubject'] = 'Jûsø rezervacija patvirtinta';
		$strings['ReservationCreatedSubject'] = 'Jûsø rezervacija sukurta';
		$strings['ReservationUpdatedSubject'] = 'Jûsø rezervacija atnaujinta';
		$strings['ReservationDeletedSubject'] = 'Jûsø rezervacija paðalinta';
		$strings['ReservationCreatedAdminSubject'] = 'Perspëjimas: Rezervacija sukurta';
		$strings['ReservationUpdatedAdminSubject'] = 'Perspëjimas: Rezervacija atnaujinta';
		$strings['ReservationDeleteAdminSubject'] = 'Perspëjimas: Rezervacija paðalinta';
		$strings['ParticipantAddedSubject'] = 'Rezervacijos dalyvio perspëjimas';
		$strings['ParticipantDeletedSubject'] = 'Rezervacija paðalinta';
		$strings['InviteeAddedSubject'] = 'Rezervacijos pakvietimas';
		$strings['ResetPassword'] = 'Reikalauti slaptaþodþio atstatymo';
		$strings['ActivateYourAccount'] = 'Praðome aktyvuoti savo vartotojo sàskaità';
		$strings['ReportSubject'] = 'Jûsø rekalauta ataskaita (%s)';
		$strings['ReservationStartingSoonSubject'] = '%s rezervacija greitai prasidës';
		$strings['ReservationEndingSoonSubject'] = '%s rezercaija greitai baigsis';
		// End Email Subjects

		$this->Strings = $strings;

		return $this->Strings;
	}

	/**
	 * @return array
	 */
	protected function _LoadDays()
	{
		$days = array();

		/***
		DAY NAMES
		All of these arrays MUST start with Sunday as the first element
		and go through the seven day week, ending on Saturday
		 ***/
		// The full day name
		$days['full'] = array('Sekmadienis', 'Pirmadienis', 'Antradienis', 'Treèiadienis', 'Ketvirtadienis', 'Penktadienis', 'Ðeðtadienis');
		// The three letter abbreviation
		$days['abbr'] = array('Sek', 'Pir', 'Ant', 'Tre', 'Ket', 'Pen', 'Ðeð');
		// The two letter abbreviation
		$days['two'] = array('Sk', 'Pr', 'An', 'Tr', 'Kt', 'Pn', 'Ðt');
		// The one letter abbreviation
		$days['letter'] = array('S', 'P', 'A', 'T', 'K', 'P', 'Ð');

		$this->Days = $days;

		return $this->Days;
	}

	/**
	 * @return array
	 */
	protected function _LoadMonths()
	{
		$months = array();

		/***
		MONTH NAMES
		All of these arrays MUST start with January as the first element
		and go through the twelve months of the year, ending on December
		 ***/
		// The full month name
		$months['full'] = array('Sausis', 'Vasaris', 'Kovas', 'Balandis', 'Geguþë', 'Birþelis', 'Liepa', 'Rugpjûtis', 'Rugsëjis', 'Spalis', 'Lapkritis', 'Gruodis');
		// The three letter month name
		$months['abbr'] = array('Sau', 'Vas', 'Kov', 'Bal', 'Geg', 'Bir', 'Lie', 'Rgp', 'Rgs', 'Spa', 'Lap', 'Grd');

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
		return 'lt';
	}
}

?>