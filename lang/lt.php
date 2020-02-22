<?php
/**
Copyright 2011-2020 Nick Korbel

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

class lt extends en_gb
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

		$strings['FirstName'] = 'Vardas';
		$strings['LastName'] = 'Pavard�';
		$strings['Timezone'] = 'Laiko juosta';
		$strings['Edit'] = 'Redaguoti';
		$strings['Change'] = 'Keisti';
		$strings['Rename'] = 'Pervadinti';
		$strings['Remove'] = '�alinti';
		$strings['Delete'] = 'Trinti';
		$strings['Update'] = 'Atnaujinti';
		$strings['Cancel'] = 'At�aukti';
		$strings['Add'] = 'Prid�ti';
		$strings['Name'] = 'Pavadinimas';
		$strings['Yes'] = 'Taip';
		$strings['No'] = 'Ne';
		$strings['FirstNameRequired'] = 'B�tina �vesti vard�.';
		$strings['LastNameRequired'] = 'B�tina �vesti pavard�.';
		$strings['PwMustMatch'] = 'Pakartotas slapta�odis turi sutapti su slapta�od�iu.';
		$strings['PwComplexity'] = 'Slapta�odis turi b�ti sudarytas i� bent 6 raid�i�, skai�i� ir �enkl�.';
		$strings['ValidEmailRequired'] = 'B�tina �vesti tikr� pa�to adres�.';
		$strings['UniqueEmailRequired'] = 'Toks pa�to adresas jau u�registruotas.';
		$strings['UniqueUsernameRequired'] = 'Toks vartotojo vardas jau u�registruotas.';
		$strings['UserNameRequired'] = 'B�tina �vesti vartotojo vard�.';
		$strings['CaptchaMustMatch'] = '�veskite raides i� saugos paveiksl�lio.';
		$strings['Today'] = '�iandien';
		$strings['Week'] = 'Savait�';
		$strings['Month'] = 'M�nuo';
		$strings['BackToCalendar'] = 'Atgal � kalendori�';
		$strings['BeginDate'] = 'Prad�ia';
		$strings['EndDate'] = 'Pabaiga';
		$strings['Username'] = 'Vartotojo vardas';
		$strings['Password'] = 'Slapta�odis';
		$strings['PasswordConfirmation'] = 'Pakartokite slapta�od�';
		$strings['DefaultPage'] = 'Numatytas pradinis puslapis';
		$strings['MyCalendar'] = 'Mano kalendorius';
		$strings['ScheduleCalendar'] = 'Tvarkara��i� kalendorius';
		$strings['Registration'] = 'Registracija';
		$strings['NoAnnouncements'] = 'Prane�im� n�ra';
		$strings['Announcements'] = 'Prane�imai';
		$strings['NoUpcomingReservations'] = 'J�s neturite art�jan�i� rezervacij�';
		$strings['UpcomingReservations'] = 'Art�jan�ios rezervacijos';
		$strings['ShowHide'] = 'Rodyti/Sl�pti';
		$strings['Error'] = 'Klaida';
		$strings['ReturnToPreviousPage'] = 'Gr��ti � prie� tai buvus� puslap�.';
		$strings['UnknownError'] = 'Ne�inoma klaida';
		$strings['InsufficientPermissionsError'] = 'J�s neturite teis�s naudot� �� resurs�.';
		$strings['MissingReservationResourceError'] = 'Nepasirinktas resursas';
		$strings['MissingReservationScheduleError'] = 'Nepasirinktas tvarkara�tis';
		$strings['DoesNotRepeat'] = 'Nesikartoja';
		$strings['Daily'] = 'Kasdien';
		$strings['Weekly'] = 'Kiekvien� savait�';
		$strings['Monthly'] = 'Kiekvien� m�nes�';
		$strings['Yearly'] = 'Kiekvienus metus';
		$strings['RepeatPrompt'] = 'Kartoti';
		$strings['hours'] = 'valandos';
		$strings['days'] = 'dienos';
		$strings['weeks'] = 'savait�s';
		$strings['months'] = 'm�nesiai';
		$strings['years'] = 'metai';
		$strings['day'] = 'diena';
		$strings['week'] = 'savait�';
		$strings['month'] = 'm�nesis';
		$strings['year'] = 'metai';
		$strings['repeatDayOfMonth'] = 'm�nesio diena';
		$strings['repeatDayOfWeek'] = 'savait�s diena';
		$strings['RepeatUntilPrompt'] = 'Iki';
		$strings['RepeatEveryPrompt'] = 'Kiekvien�';
		$strings['RepeatDaysPrompt'] = 'Savait�s dien�';
		$strings['CreateReservationHeading'] = 'Kurti nauj� rezervacij�';
		$strings['EditReservationHeading'] = 'Redaguojama rezervacija %s';
		$strings['ViewReservationHeading'] = 'Per�i�rima rezervacija %s';
		$strings['ReservationErrors'] = 'Keisti rezervacij�';
		$strings['Create'] = 'Kurti';
		$strings['ThisInstance'] = 'Tik �� kart�';
		$strings['AllInstances'] = 'Visai kartais';
		$strings['FutureInstances'] = 'Ateinan�iais kartais';
		$strings['Print'] = 'Spausdinti';
		$strings['ShowHideNavigation'] = 'Rotyti/Sl�pti navigacij�';
		$strings['ReferenceNumber'] = 'Nuorodos numeris';
		$strings['Tomorrow'] = 'Rytoj';
		$strings['LaterThisWeek'] = 'V�liau �i� savait�';
		$strings['NextWeek'] = 'Ateinan�i� savait�';
		$strings['SignOut'] = 'Atsijungti';
		$strings['LayoutDescription'] = 'Savait�s prad�ia - %s, rodoma po %s dienas/�';
		$strings['AllResources'] = 'Visi resursai';
		$strings['TakeOffline'] = 'Padaryti nepasiekiamu';
		$strings['BringOnline'] = 'Padaryti pasiekiamu';
		$strings['AddImage'] = 'Prid�ti paveiksl�l�';
		$strings['NoImage'] = 'Paveiksl�lis nepriskirtas';
		$strings['Move'] = 'Perkelti';
		$strings['AppearsOn'] = '�traukta � *%s*';
		$strings['Location'] = 'Vieta';
		$strings['NoLocationLabel'] = '(vieta nenurodyta)';
		$strings['Contact'] = 'Kontaktas susisiekimui';
		$strings['NoContactLabel'] = '(kontaktin� informacija nepateikta)';
		$strings['Description'] = 'Apra�ymas';
		$strings['NoDescriptionLabel'] = '(apra�ymas nepateiktas)';
		$strings['Notes'] = 'Pastabos';
		$strings['NoNotesLabel'] = '(u�ra�� n�ra)';
		$strings['NoTitleLabel'] = '(be pavadinimo)';
		$strings['UsageConfiguration'] = 'Konfiguracija naudojimui';
		$strings['ChangeConfiguration'] = 'Keisti konfiguracij�';
		$strings['ResourceMinLength'] = 'Rezervacija turi trukti bent %s';
		$strings['ResourceMinLengthNone'] = 'Minimali rezervacijos trukm� neribojama';
		$strings['ResourceMaxLength'] = 'Rezervacija negali trukti ilgiau nei %s';
		$strings['ResourceMaxLengthNone'] = 'Maksimali rezervacijos trukm� neribojama';
		$strings['ResourceRequiresApproval'] = 'Rezervacijos turi b�ti patvirtintos';
		$strings['ResourceRequiresApprovalNone'] = 'Rezervacijai patvirtinimo nereikia';
		$strings['ResourcePermissionAutoGranted'] = 'Teis� suteikiama automati�kai';
		$strings['ResourcePermissionNotAutoGranted'] = 'Teis� automati�kai nesuteikiama';
		$strings['ResourceMinNotice'] = 'Rezervavim� atlikti likus bent %s iki jos prad�ios';
		$strings['ResourceMinNoticeNone'] = 'Rezervuoti galima iki nurodyto laiko';
		$strings['ResourceMaxNotice'] = 'Rezervacija negali baigtis %s v�liau nurodyto laiko';
		$strings['ResourceMaxNoticeNone'] = 'Rezervacija gali baigtis bet kada';
		$strings['ResourceAllowMultiDay'] = 'Rezervacija galima per �ias dienas';
		$strings['ResourceNotAllowMultiDay'] = 'Rezervacija �iomis dienomis negalima';
		$strings['ResourceCapacity'] = '�is resursas talpina %s �moni�';
		$strings['ResourceCapacityNone'] = '�io resurso viet� skai�ius neribotas';
		$strings['AddNewResource'] = 'Prid�ti nauj� resurs�';
		$strings['AddNewUser'] = 'Prid�ti nauj� vartotoj�';
		$strings['AddUser'] = 'Prid�ti vartotoj�';
		$strings['Schedule'] = 'Tvarkara�tis';
		$strings['AddResource'] = 'Prid�ti resurs�';
		$strings['Capacity'] = 'Viet� skai�ius';
		$strings['Access'] = 'Prieiga';
		$strings['Duration'] = 'Trukm�';
		$strings['Active'] = 'Aktyvus';
		$strings['Inactive'] = 'Neaktyvus';
		$strings['ResetPassword'] = 'Atstatyti slapta�od�';
		$strings['LastLogin'] = 'Paskutinis prisijungimas';
		$strings['Search'] = 'Ie�koti';
		$strings['ResourcePermissions'] = 'Resurso teis�s';
		$strings['Reservations'] = 'Rezervacijos';
		$strings['Groups'] = 'Grup�s';

		$strings['AllUsers'] = 'Visi vartotojai';
		$strings['AllGroups'] = 'Visos grup�s';
		$strings['AllSchedules'] = 'Visi tvarkara��iai';
		$strings['UsernameOrEmail'] = 'Vartotojo vardas arba pa�tas';
		$strings['Members'] = 'Nariai';
		$strings['QuickSlotCreation'] = 'Kurti ni�as kas %s minutes nuo %s iki %s';
		$strings['ApplyUpdatesTo'] = 'Taikyti atnaujinimus';
		$strings['CancelParticipation'] = 'At�aukti dalyvavim�';
		$strings['Attending'] = 'Dalyvavimas';
		$strings['QuotaConfiguration'] = 'On %s for %s users in %s are limited to %s %s per %s';
		$strings['reservations'] = 'rezervacijos';
		$strings['ChangeCalendar'] = 'Keisti kalendori�';
		$strings['AddQuota'] = 'Prid�ti kvot�';
		$strings['FindUser'] = 'Rasti vartotoj�';
		$strings['Created'] = 'Sukurta';
		$strings['LastModified'] = 'Paskutin� kart� redaguotas';
		$strings['GroupName'] = 'Grup�s pavadinimas';
		$strings['GroupMembers'] = 'Grup�s nariai';
		$strings['GroupRoles'] = 'Grup�s vaidmenys';
		$strings['GroupAdmin'] = 'Grup�s administratorius';
		$strings['Actions'] = 'Veiksmai';
		$strings['CurrentPassword'] = 'Dabartinis slapta�odis';
		$strings['NewPassword'] = 'Naujas slapta�odis';
		$strings['InvalidPassword'] = 'Neteisingai �vestas dabartinis slapta�odis';
		$strings['PasswordChangedSuccessfully'] = 'J�s� slapta�odis pakeistas s�kmingai';
		$strings['SignedInAs'] = 'Prisijung�s �iuo vardu: ';
		$strings['NotSignedIn'] = 'J�s neprisijung�s';
		$strings['ReservationTitle'] = 'Rezervacijos pavadinimas';
		$strings['ReservationDescription'] = 'Rezervacijos apra�ymas';
		$strings['ResourceList'] = 'Rezervuojami resursai';
		$strings['Accessories'] = 'Priedai';
		$strings['ParticipantList'] = 'Dalyviai';
		$strings['InvitationList'] = 'Pakviest�j� s�ra�as';
		$strings['AccessoryName'] = 'Priedo pavadinimas';
		$strings['QuantityAvailable'] = 'Lik�s kiekis';
		$strings['Resources'] = 'Resursai';
		$strings['Participants'] = 'Dalyviai';
		$strings['User'] = 'Vartotojai';
		$strings['Resource'] = 'Resursas';
		$strings['Status'] = 'B�sena';
		$strings['Approve'] = 'Patvirtinti';
		$strings['Page'] = 'Puslapis';
		$strings['Rows'] = 'Eil�s';
		$strings['Unlimited'] = 'Neribota';
		$strings['Email'] = 'Pa�tas';
		$strings['EmailAddress'] = 'Pa�to adresas';
		$strings['Phone'] = 'Telefonas';
		$strings['Organization'] = '�mon�';
		$strings['Position'] = 'Pareigos';
		$strings['Language'] = 'Kalba';
		$strings['Permissions'] = 'Teis�s';
		$strings['Reset'] = 'Atstatyti';
		$strings['FindGroup'] = 'Rasti grup�';
		$strings['Manage'] = 'Valdyti';
		$strings['None'] = 'N�ra';
		$strings['AddToOutlook'] = 'Prid�ti � kalendori�';
		$strings['Done'] = '�vykdyta';
		$strings['RememberMe'] = 'Atsiminti mane';
		$strings['FirstTimeUser?'] = 'Pirm� kart� �ia?';
		$strings['CreateAnAccount'] = 'K�rti vartotojo prisijungim�';
		$strings['ViewSchedule'] = '�i�r�ti tvarkara��ius';
		$strings['ForgotMyPassword'] = 'Pamir�au slapta�od�';
		$strings['YouWillBeEmailedANewPassword'] = 'Jums bus i�si�stas lai�kas su atsitiktinai sugeneruotu slapta�od�iu';
		$strings['Close'] = 'U�daryti';
		$strings['ExportToCSV'] = 'Eksportuoti CSV formatu';
		$strings['OK'] = 'OK';
		$strings['Working'] = 'Vykdoma...';
		$strings['Login'] = 'Prisijungti';
		$strings['AdditionalInformation'] = 'Papildoma informacija';
		$strings['AllFieldsAreRequired'] = 'visi laukeliai yra b�tini';
		$strings['Optional'] = 'neb�tina';
		$strings['YourProfileWasUpdated'] = 'J�s� profilis atnaujintas';
		$strings['YourSettingsWereUpdated'] = 'J�s� nustatymai atnaujinti';
		$strings['Register'] = 'Registruotis';
		$strings['SecurityCode'] = 'Apsauginis kodas';
		$strings['ReservationCreatedPreference'] = 'Kai sukuriu rezervacij�, arba rezervacija sukuriama mano vardu';
		$strings['ReservationUpdatedPreference'] = 'Kai atnaujinu rezervacij�, arba rezervacijos duomenys atnaujinami mano vardu';
		$strings['ReservationDeletedPreference'] = 'Kai pa�alinu rezervacij�, arba rezervacija pa�alinama mano vardu';
		$strings['ReservationApprovalPreference'] = 'Kai mano laukiantis rezervacija patvirtinama';
		$strings['PreferenceSendEmail'] = 'Si�sti man lai�k�';
		$strings['PreferenceNoEmail'] = 'Neprane�ti';
		$strings['ReservationCreated'] = 'J�s� rezervacija sukurta s�kmingai!';
		$strings['ReservationUpdated'] = 'J�s� rezervacija atnaujinta s�kmingai!';
		$strings['ReservationRemoved'] = 'J�s� rezervacija pa�alinta';
		$strings['YourReferenceNumber'] = 'J�s� nuorodos numeris %s';
		$strings['UpdatingReservation'] = 'Rezervacija atnaujinama';
		$strings['ChangeUser'] = 'Keisti vartotoj�';
		$strings['MoreResources'] = 'Daugiau resurs�';
		$strings['ReservationLength'] = 'Rezervacijos trukm�';
		$strings['ParticipantList'] = 'Dalyvi� s�ra�as';
		$strings['AddParticipants'] = 'Prid�ti dalyvi�';
		$strings['InviteOthers'] = 'Kviesti kitus';
		$strings['AddResources'] = 'Prid�ti resurs�';
		$strings['AddAccessories'] = 'Prid�ti pried�';
		$strings['Accessory'] = 'Priedai';
		$strings['QuantityRequested'] = 'Pra�omas kiekis';
		$strings['CreatingReservation'] = 'Rezervacija kuriama';
		$strings['UpdatingReservation'] = 'Rezervacija atnaujinama';
		$strings['DeleteWarning'] = '�is veiksmas yra ilgalaikis ir negr��tamas!';
		$strings['DeleteAccessoryWarning'] = 'I�trynus �� pried�, jis bus pa�alintas i� vis� rezervacij�.';
		$strings['AddAccessory'] = 'Prid�ti pried�';
		$strings['AddBlackout'] = 'Add Blackout';
		$strings['AllResourcesOn'] = 'Visi resursai';
		$strings['Reason'] = 'Prie�astis';
		$strings['BlackoutShowMe'] = 'Rodyti susikertan�ias rezervacija';
		$strings['BlackoutDeleteConflicts'] = 'Trinti susikertan�ias rezervacijas';
		$strings['Filter'] = 'Filtruoti';
		$strings['Between'] = 'Tarp';
		$strings['CreatedBy'] = 'Suk�r�';
		$strings['BlackoutCreated'] = 'Blackout Created!';
		$strings['BlackoutNotCreated'] = 'Blackout could not be created!';
		$strings['BlackoutConflicts'] = 'There are conflicting blackout times';
		$strings['ReservationConflicts'] = 'Yra susikertantys rezervacij� laikai';
		$strings['UsersInGroup'] = '�ios grup�s vartotojai';
		$strings['Browse'] = 'Nar�yti';
		$strings['DeleteGroupWarning'] = 'I�trynus �i� grup�, bus pa�alintos su resursais susietos teis�s. Vartotojai i� �ios grup�s gali netekti teis�s � resursus.';
		$strings['WhatRolesApplyToThisGroup'] = 'Kokie vaidmenys priskirti �iai grupei?';
		$strings['WhoCanManageThisGroup'] = 'Kas gali valdyti �i� grup�?';
		$strings['WhoCanManageThisSchedule'] = 'Kas gali valdyti �� tvarkara�t�?';
		$strings['AddGroup'] = 'Prid�ti grup�';
		$strings['AllQuotas'] = 'Visos kvotos';
		$strings['QuotaReminder'] = 'Atminkite: kvotos galioja pagal tvarkara��io laiko juost�.';
		$strings['AllReservations'] = 'Visos rezervacijos';
		$strings['PendingReservations'] = 'Laukian�ios rezervacijos';
		$strings['Approving'] = 'Patvirtinama';
		$strings['MoveToSchedule'] = 'Perkelti � tvarkara�t�';
		$strings['DeleteResourceWarning'] = 'I�trynus �� resurs�, bus i�trinta ir visi susieti duomenys, �skaitant';
		$strings['DeleteResourceWarningReservations'] = 'visas susietas buvusias, esamas ir b�simas rezervacijas';
		$strings['DeleteResourceWarningPermissions'] = 'visus teisi� priskyrimus';
		$strings['DeleteResourceWarningReassign'] = 'Pra�ome prie� t�siant pakeisti priskyrimus, kuri� nenorite i�trinti';
		$strings['ScheduleLayout'] = 'Laiko suskirstymas (visi laikai %s)';
		$strings['ReservableTimeSlots'] = 'Rezervuojama laiko ni��';
		$strings['BlockedTimeSlots'] = 'U�draustos laiko ni�os';
		$strings['ThisIsTheDefaultSchedule'] = 'Tai yra numatytasis tvarkara�tis';
		$strings['DefaultScheduleCannotBeDeleted'] = 'Numatytojo tvarkara��io i�trinti negalima';
		$strings['MakeDefault'] = 'Padaryti numatytuoju';
		$strings['BringDown'] = 'Perkelti �emyn';
		$strings['ChangeLayout'] = 'Keisti laiko suskirstym�';
		$strings['AddSchedule'] = 'Prid�ti tvarkara�t�';
		$strings['StartsOn'] = 'Savait�s prad�ia:';
		$strings['NumberOfDaysVisible'] = 'Kiek dien� rodoma';
		$strings['UseSameLayoutAs'] = 'Naudoti tok� pat laiko suskirstym� kaip';
		$strings['Format'] = 'Formatuoti';
		$strings['OptionalLabel'] = 'Neb�tina �ym�';
		$strings['LayoutInstructions'] = '�veskite po vien� ni�� eilut�je. �vestos ni�os turi u�pildyti vis� par�, pradedant vidurnak�iu ir juo baigiant.';
		$strings['AddUser'] = 'Prid�ti vartotoj�';
		$strings['UserPermissionInfo'] = 'Tikrasis resurso pasiekiamumas gali b�ti skirtingas, priklausomai nuo vartotojo vaidmens, jo grup�s teisi�, ar i�orini� teisi� nustatym�.';
		$strings['DeleteUserWarning'] = 'I�trynus �� vartotoj� bus pa�alinta visos jo buvusios ir b�simos rezervacijos.';
		$strings['AddAnnouncement'] = 'Prid�ti prane�im�';
		$strings['Announcement'] = 'Prane�imas';
		$strings['Priority'] = 'Prioritetas';
		$strings['Reservable'] = 'Galima rezervuoti';
		$strings['Unreservable'] = 'Rezervuoti negalima';
		$strings['Reserved'] = 'Jau rezervuotas';
		$strings['MyReservation'] = 'Mano rezervacijos';
		$strings['Pending'] = 'Laukian�ios';
		$strings['Past'] = 'Buvusios';
		$strings['Restricted'] = 'Apribotos';
		$strings['ViewAll'] = 'Per�i�r�ti visas/visus';
		$strings['MoveResourcesAndReservations'] = 'Perkelti resursus ir rezervacijas �';
		$strings['TurnOffSubscription'] = 'I�jungti kalendoriaus prenumeratas';
		$strings['TurnOnSubscription'] = 'Leisti prenumeruoti �� kalendori�';
		$strings['SubscribeToCalendar'] = 'Prenumeruoti �� kalendori�';
		$strings['SubscriptionsAreDisabled'] = 'Administratorius yra u�draud�s kalendoriaus prenumerat�';
		$strings['NoResourceAdministratorLabel'] = '(Resurso niekas neadministruoja)';
		$strings['WhoCanManageThisResource'] = 'Kas gali valdyti �� resurs�?';
		$strings['ResourceAdministrator'] = 'Resurso administratorius';
		$strings['Private'] = 'Privatus';
		$strings['Accept'] = 'Priimti';
		$strings['Decline'] = 'Atmesti';
		$strings['ShowFullWeek'] = 'Rodyti vis� savait�';
		$strings['CustomAttributes'] = 'Custom Attributes';
		$strings['AddAttribute'] = 'Prid�ti atribut�';
		$strings['EditAttribute'] = 'Atnaujinti atribut�';
		$strings['DisplayLabel'] = 'Rodoma �ym�';
		$strings['Type'] = 'Tipas';
		$strings['Required'] = 'B�tina';
		$strings['ValidationExpression'] = 'Patvirtinimo i�rai�ka / Validation Expression';
		$strings['PossibleValues'] = 'Galimos reik�m�s';
		$strings['SingleLineTextbox'] = 'Vienos eilut�s �vedimo laukelis';
		$strings['MultiLineTextbox'] = 'Keli� eilu�i� �vedimo laukelis';
		$strings['Checkbox'] = '�ym�jimo laukelis (Checkbox)';
		$strings['SelectList'] = 'Pasirinkimo s�ra�as (Select List)';
		$strings['CommaSeparated'] = 'kableta�kiu atskirta';
		$strings['Category'] = 'Kategorija';
		$strings['CategoryReservation'] = 'Rezervacija';
		$strings['CategoryGroup'] = 'Grup�';
		$strings['SortOrder'] = 'I�rikiavimo tvarka';
		$strings['Title'] = 'Pavadinimas';
		$strings['AdditionalAttributes'] = 'Papildomi atributai';
		$strings['True'] = 'Taip / True';
		$strings['False'] = 'Ne / False';
		$strings['ForgotPasswordEmailSent'] = 'Pateiktu pa�to adresu i�si�stas lai�kas su nurodymais, kaip atstatyti slapta�od�';
		$strings['ActivationEmailSent'] = 'Greitai tur�tum�te gauti aktyvavimo lai�k�.';
		$strings['AccountActivationError'] = 'Atsipra�ome, negal�jome aktyvuoti j�s� vartotojo prisijungimo.';
		$strings['Attachments'] = 'Prisegtukai';
		$strings['AttachFile'] = 'Prisegti byl�';
		$strings['Maximum'] = 'max';
		$strings['NoScheduleAdministratorLabel'] = 'Tvarkara��io niekas neadministruoja';
		$strings['ScheduleAdministrator'] = 'Tvarkara��io administratorius';
		$strings['Total'] = 'I� viso';
		$strings['QuantityReserved'] = 'Rezervuotas kiekis';
		$strings['AllAccessories'] = 'Visi priedai';
		$strings['GetReport'] = 'Gauti ataskait�';
		$strings['NoResultsFound'] = 'Nerasta joki� rezultat�';
		$strings['SaveThisReport'] = 'I�saugoti �i� ataskait�';
		$strings['ReportSaved'] = 'Ataskaita i�saugota!';
		$strings['EmailReport'] = 'I�si�sti ataskait� pa�tu';
		$strings['ReportSent'] = 'Ataskaita i�si�sta!';
		$strings['RunReport'] = 'Generuoti ataskait�';
		$strings['NoSavedReports'] = 'J�s neturite i�saugot� atasakait�.';
		$strings['CurrentWeek'] = '�i savait�';
		$strings['CurrentMonth'] = '�is m�nuo';
		$strings['AllTime'] = 'Visi laikai';
		$strings['FilterBy'] = 'Fitruoti pagal';
		$strings['Select'] = 'Pasirinkt';
		$strings['List'] = 'S�ra�as';
		$strings['TotalTime'] = 'Laiko suma';
		$strings['Count'] = 'Skai�ius/Suma';
		$strings['Usage'] = 'Panaudojimas';
		$strings['AggregateBy'] = 'R��iuoti pagal';
		$strings['Range'] = 'Intervalas';
		$strings['Choose'] = 'Pasirinkti';
		$strings['All'] = 'Visi';
		$strings['ViewAsChart'] = 'Rodyti kaip diagram�';
		$strings['ReservedResources'] = 'Rezervuoti resursai';
		$strings['ReservedAccessories'] = 'Rezervuoti priedai';
		$strings['ResourceUsageTimeBooked'] = 'Resurs� panaudojimas - bendras u�sakym� laikas';
		$strings['ResourceUsageReservationCount'] = 'Resurs� panaudojimas - rezervacij� skai�ius';
		$strings['Top20UsersTimeBooked'] = 'Top 20 vartotoj� - pagal u�sakym� laik�';
		$strings['Top20UsersReservationCount'] = 'Top 20 vartotoj� - pagal u�sakym� skai�i�';
		$strings['ConfigurationUpdated'] = 'Nustatym� byla atnaujinta';
		$strings['ConfigurationUiNotEnabled'] = 'Puslapis nepasiekiamas, nes nustatym� byloje eilut�je $conf[\'settings\'][\'pages\'][\'enable.configuration\'] nustatyta false, arba eilut�s tr�ksta.';
		$strings['ConfigurationFileNotWritable'] = 'Nustatym� byla ne�ra�oma. Patikrinkite bylos teises ir bandykite dar kart�.';
		$strings['ConfigurationUpdateHelp'] = 'Apie �iuos nustatymus skaitykite skyriuje Nustatymai, dokumente <a target=_blank href=%s>Pagalba</a>.';
		$strings['GeneralConfigSettings'] = 'nustatymai';
		$strings['UseSameLayoutForAllDays'] = 'Naudoti tok� pat� i�d�stym� visoms dienoms';
		$strings['LayoutVariesByDay'] = 'I�d�stymas skirtingas kiekvien� dien�';
		$strings['ManageReminders'] = 'Priminimai';
		$strings['ReminderUser'] = 'Vartotojo ID';
		$strings['ReminderMessage'] = '�inut�';
		$strings['ReminderAddress'] = 'Adresai';
		$strings['ReminderSendtime'] = 'Kuriuo laiku si�sti';
		$strings['ReminderRefNumber'] = 'Rezervacijos nuorodos numeris';
		$strings['ReminderSendtimeDate'] = 'Priminimo data';
		$strings['ReminderSendtimeTime'] = 'Priminimo laikas (HH:MM)';
		$strings['ReminderSendtimeAMPM'] = 'AM / PM';
		$strings['AddReminder'] = 'Prid�ti priminim�';
		$strings['DeleteReminderWarning'] = 'Trinate priminim�, gerai?';
		$strings['NoReminders'] = 'Neturite b�sim� priminim�.';
		$strings['Reminders'] = 'Priminimai';
		$strings['SendReminder'] = 'Si�sti priminim�';
		$strings['minutes'] = 'minut�s';
		$strings['hours'] = 'valandos';
		$strings['days'] = 'dienos';
		$strings['ReminderBeforeStart'] = 'prie� prad�i�';
		$strings['ReminderBeforeEnd'] = 'prie� pabaig�';
		$strings['Logo'] = 'Logo';
		$strings['CssFile'] = 'CSS byla';
		$strings['ThemeUploadSuccess'] = 'J�su pakeitimai i�saugoti. Perkraukite puslap�, kad pamatytum�te poky�ius.';
		$strings['MakeDefaultSchedule'] = 'Padaryti tvarkara�t� numatytuoju';
		$strings['DefaultScheduleSet'] = 'Tvarkara�tis numatytasis';
		$strings['FlipSchedule'] = 'Apversti tvarkara��io i�d�stym�';
		$strings['Next'] = 'Toliau';
		$strings['Success'] = '�vykdyt� s�kmingai';
		// End Strings

		// Install
		$strings['InstallApplication'] = 'Diegti Booked Scheduler (tik su MySQL)';
		$strings['IncorrectInstallPassword'] = 'Atsipra�ome, slapta�odis neteisingas.';
		$strings['SetInstallPassword'] = 'Nurodykite diegimo slapta�od� prie� prad�dami diegim�.';
		$strings['InstallPasswordInstructions'] = 'Byloje %s pakeiskite eilut� %s � slapta�od�, kuris b�t� sunkiai atsp�jamas, poto gr��kite � �� puslap�.<br/>Galima panaudoti %s';
		$strings['NoUpgradeNeeded'] = 'Atnaujinimas neb�tinas. Leid�iant diegim� bus i�trinta visi esami duomenys ir �diegta nauja Booked Scheduler kopija!';
		$strings['ProvideInstallPassword'] = 'Pateikite �diegimo slapta�od�.';
		$strings['InstallPasswordLocation'] = 'Tai galima rasti %s , %s.';
		$strings['VerifyInstallSettings'] = 'Prie� t�sdami sutikrinkite numatytas reik�me. Arba jas galima keisti byloje %s.';
		$strings['DatabaseName'] = 'Duomen� baz�s pavadinimas (Database Name)';
		$strings['DatabaseUser'] = 'DB vartoto prisijungimo vardas (Database User)';
		$strings['DatabaseHost'] = 'DB tarnybin�s stoties pavadinimas (Database Host)';
		$strings['DatabaseCredentials'] = 'B�tina pateikti MySQL prisijungimo duomenis, kurie turi teis� kurti duomen� bazes (create database). Jei ne�inote, klauskite savo duomen� bazi� administratoriaus. Daugeliu atveju jungiantis root vardu viskas veiks.';
		$strings['MySQLUser'] = 'MySQL vartotojo vardas';
		$strings['InstallOptionsWarning'] = '�ie pasirinkimai, tik�tina, neveiks nuomojamoje aplinkoje (hosted enviroment). Tokiu atveju naudokite MySQL vedlio �rankius.';
		$strings['CreateDatabase'] = 'Kurti duomen� baz�';
		$strings['CreateDatabaseUser'] = 'Kurti duomen� baz�s vartotoj�';
		$strings['PopulateExampleData'] = '�kelti pavyzdinius duomenis. Bus sukurta administratoriaus paskyra: admin/password ir vartotojo paskyra: user/password';
		$strings['DataWipeWarning'] = 'D�mesio: Bus i�trinta visi esami duomenys';
		$strings['RunInstallation'] = 'Diegti';
		$strings['UpgradeNotice'] = 'J�s atnaujinate i� versijos <b>%s</b> � versij� <b>%s</b>';
		$strings['RunUpgrade'] = 'Atnaujinti';
		$strings['Executing'] = 'Vykdoma';
		$strings['StatementFailed'] = 'Nepavyko. Smulkiau:';
		$strings['SQLStatement'] = 'SQL prane�imai:';
		$strings['ErrorCode'] = 'Klaidos kodas (Error Code):';
		$strings['ErrorText'] = 'Klaidos tekstas (Error Text):';
		$strings['InstallationSuccess'] = 'Diegimas baigtas s�kmingai!';
		$strings['RegisterAdminUser'] = 'Registruokite savo administratoriaus vartotoj�. To reikia, jei nepasirinkote �kelti pavyzdini� duomen�. �sitikinkite, kad eilut� $conf[\'settings\'][\'allow.self.registration\'] = \'true\' yra byloje %s .';
		$strings['LoginWithSampleAccounts'] = 'Jei �k�l�te pavyzdinius duomenis, galite jungtis admin/password duomenimis administratoriaus vardu, arba user/password �prasto vartotojo vardu.';
		$strings['InstalledVersion'] = 'Naudojat�s Booked Scheduler, versija %s ';
		$strings['InstallUpgradeConfig'] = 'B�tina atnaujinti nustatym� byl� (config)';
		$strings['InstallationFailure'] = 'Diegiant nutiko b�d�. Pataisykite nesklandumus ir bandykite pakartoti diegim�.';
		$strings['ConfigureApplication'] = 'Nustatyti Booked Scheduler';
		$strings['ConfigUpdateSuccess'] = 'J�s� nustatym� (config) byla dabar atnajinta!';
		$strings['ConfigUpdateFailure'] = 'Nepavyko automati�kai atnaujinti nustatym� bylos (config). Pakeiskite bylos config.php turin� �iuo tekstu:';
		// End Install

		// Errors
		$strings['LoginError'] = 'Netinkamas vartotojo vardas arba slapta�odis';
		$strings['ReservationFailed'] = 'Nepavyko padaryti j�s� rezervacijos';
		$strings['MinNoticeError'] = '�i rezervacija reikalauja i�ankstinio prane�imo. Anks�iausiai rezervuoti bus galima �iuo laiku: %s.';
		$strings['MaxNoticeError'] = 'Negalima rezervuoti taip anksti. V�liausias laikas kada galima bus rezervuoti: %s.';
		$strings['MinDurationError'] = 'Rezervacijaturi trukti bent %s.';
		$strings['MaxDurationError'] = 'Rezervacija negali tukti ilgiau nei %s.';
		$strings['ConflictingAccessoryDates'] = 'Nepakanka �i� pried�:';
		$strings['NoResourcePermission'] = 'Neturite teis�s vienam ar keliems pra�om� resurs�';
		$strings['ConflictingReservationDates'] = 'Yra susikertan�i� rezervacij� �iuomis datomis:';
		$strings['StartDateBeforeEndDateRule'] = 'Prad�ios laikas turi b�ti anks�iau u� pabaigos laik�';
		$strings['StartIsInPast'] = 'Prad�ios laikas negali b�ti praeityje';
		$strings['EmailDisabled'] = 'Administratorius i�jung�s persp�jimus pa�tu';
		$strings['ValidLayoutRequired'] = 'Pateiktos ni�os turi padengti vis� par� nuo 00h iki 24h';
		$strings['CustomAttributeErrors'] = 'Ka�kas negerai su nurodytais papildomais atributais:';
		$strings['CustomAttributeRequired'] = '%s b�tina u�pildyti';
		$strings['CustomAttributeInvalid'] = 'Reik�m� �vesta � %s yra neteisinga';
		$strings['AttachmentLoadingError'] = 'Atsipra�oma, ka�kas nutiko �keliant byl�.';
		$strings['InvalidAttachmentExtension'] = 'Galima �kelti tik �i� tip� bylas: %s';
		$strings['InvalidStartSlot'] = 'Pra�omas prad�ios laikas ir data neteisingi.';
		$strings['InvalidEndSlot'] = 'Pra�omas pabaigos laikas ir data neteisingi.';
		$strings['MaxParticipantsError'] = '%s telpa tik %s dalyvi�.';
		$strings['ReservationCriticalError'] = '�vyko klaida i�saugant j�s� rezervacij�. Jei tai kartosis, susisiekite su sistemos administratoriumi.';
		$strings['InvalidStartReminderTime'] = 'Prad�ios priminimo laikas neteisingas.';
		$strings['InvalidEndReminderTime'] = 'Pabaigos priminimo laikas neteisingas.';
		// End Errors

		// Page Titles
		$strings['CreateReservation'] = 'K�rti rezervacij�';
		$strings['EditReservation'] = 'Redaguoti rezervacij�';
		$strings['LogIn'] = 'Prisijungti';
		$strings['ManageReservations'] = 'Rezervacijos';
		$strings['AwaitingActivation'] = 'Laukia aktyvacijos';
		$strings['PendingApproval'] = 'Laukia patvirtinimo';
		$strings['ManageSchedules'] = 'Tvarkara��iai';
		$strings['ManageResources'] = 'Resursai';
		$strings['ManageAccessories'] = 'Priedai';
		$strings['ManageUsers'] = 'Vartotojai';
		$strings['ManageGroups'] = 'Grup�s';
		$strings['ManageQuotas'] = 'Kvotos';
		$strings['ManageBlackouts'] = 'Blackout Times';
		$strings['MyDashboard'] = 'Mano pradinis puslapis';
		$strings['ServerSettings'] = 'Serverio nustatymai';
		$strings['Dashboard'] = 'Pradinis puslapis';
		$strings['Help'] = 'Pagalba';
		$strings['Administration'] = 'Administravimas';
		$strings['About'] = 'Apie';
		$strings['Bookings'] = 'U�sakymai';
		$strings['Schedule'] = 'Tvarkara�tis';
		$strings['Reservations'] = 'Rezervacijos';
		$strings['Account'] = 'Vartotoj� prisijungimai';
		$strings['EditProfile'] = 'Redaguoti mano profil�';
		$strings['FindAnOpening'] = 'Rasti, kada bus laisva';
		$strings['OpenInvitations'] = 'Atviri kvietimai';
		$strings['MyCalendar'] = 'Mano kalendorius';
		$strings['ResourceCalendar'] = 'Resurs� kalendorius';
		$strings['Reservation'] = 'Nauja rezervacija';
		$strings['Install'] = 'Diegimas';
		$strings['ChangePassword'] = 'Keisti slapta�od�';
		$strings['MyAccount'] = 'Mano prisijungimo s�skaita';
		$strings['Profile'] = 'Profilis';
		$strings['ApplicationManagement'] = 'Sistemos valdymas';
		$strings['ForgotPassword'] = 'Pamir�au slapta�od�';
		$strings['NotificationPreferences'] = 'Persp�jim� nustatymai';
		$strings['ManageAnnouncements'] = 'Prane�imai';
		$strings['Responsibilities'] = 'Atsakomyb�s';
		$strings['GroupReservations'] = 'Grup�s rezervavimai';
		$strings['ResourceReservations'] = 'Resurs� rezervacijos';
		$strings['Customization'] = 'Tinkinimas';
		$strings['Attributes'] = 'Atributai';
		$strings['AccountActivation'] = 'Vartotojo s�skaitos aktyvavimas';
		$strings['ScheduleReservations'] = 'Tvarkara��io rezervacijos';
		$strings['Reports'] = 'Ataskaitos';
		$strings['GenerateReport'] = 'Kurti nauj� ataskait�';
		$strings['MySavedReports'] = 'Mano i�saugotos ataskaitos';
		$strings['CommonReports'] = '�prastos ataskaitos';
		$strings['ViewDay'] = 'Per�i�r�ti dien�';
		$strings['Group'] = 'Grup�';
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
		$strings['DaySaturdaySingle'] = '�';

		$strings['DaySundayAbbr'] = 'Sk';
		$strings['DayMondayAbbr'] = 'Pr';
		$strings['DayTuesdayAbbr'] = 'An';
		$strings['DayWednesdayAbbr'] = 'Tr';
		$strings['DayThursdayAbbr'] = 'Kt';
		$strings['DayFridayAbbr'] = 'Pn';
		$strings['DaySaturdayAbbr'] = '�t';
		// End Day representations

		// Email Subjects
		$strings['ReservationApprovedSubject'] = 'J�s� rezervacija patvirtinta';
		$strings['ReservationCreatedSubject'] = 'J�s� rezervacija sukurta';
		$strings['ReservationUpdatedSubject'] = 'J�s� rezervacija atnaujinta';
		$strings['ReservationDeletedSubject'] = 'J�s� rezervacija pa�alinta';
		$strings['ReservationCreatedAdminSubject'] = 'Persp�jimas: Rezervacija sukurta';
		$strings['ReservationUpdatedAdminSubject'] = 'Persp�jimas: Rezervacija atnaujinta';
		$strings['ReservationDeleteAdminSubject'] = 'Persp�jimas: Rezervacija pa�alinta';
		$strings['ParticipantAddedSubject'] = 'Rezervacijos dalyvio persp�jimas';
		$strings['ParticipantDeletedSubject'] = 'Rezervacija pa�alinta';
		$strings['InviteeAddedSubject'] = 'Rezervacijos pakvietimas';
		$strings['ResetPassword'] = 'Reikalauti slapta�od�io atstatymo';
		$strings['ActivateYourAccount'] = 'Pra�ome aktyvuoti savo vartotojo s�skait�';
		$strings['ReportSubject'] = 'J�s� rekalauta ataskaita (%s)';
		$strings['ReservationStartingSoonSubject'] = '%s rezervacija greitai prasid�s';
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
		$days = parent::_LoadDays();

		/***
		DAY NAMES
		All of these arrays MUST start with Sunday as the first element
		and go through the seven day week, ending on Saturday
		 ***/
		// The full day name
		$days['full'] = array('Sekmadienis', 'Pirmadienis', 'Antradienis', 'Tre�iadienis', 'Ketvirtadienis', 'Penktadienis', '�e�tadienis');
		// The three letter abbreviation
		$days['abbr'] = array('Sek', 'Pir', 'Ant', 'Tre', 'Ket', 'Pen', '�e�');
		// The two letter abbreviation
		$days['two'] = array('Sk', 'Pr', 'An', 'Tr', 'Kt', 'Pn', '�t');
		// The one letter abbreviation
		$days['letter'] = array('S', 'P', 'A', 'T', 'K', 'P', '�');

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
		$months['full'] = array('Sausis', 'Vasaris', 'Kovas', 'Balandis', 'Gegu��', 'Bir�elis', 'Liepa', 'Rugpj�tis', 'Rugs�jis', 'Spalis', 'Lapkritis', 'Gruodis');
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