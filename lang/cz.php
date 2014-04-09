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

require_once('en_us.php');

class cz extends en_us
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

        $dates['general_date'] = 'd.m.Y';
        $dates['general_datetime'] = 'd.m.Y H:i:s';
        $dates['schedule_daily'] = 'l, d.m.Y';
        $dates['reservation_email'] = 'd.m.Y H:i';
        $dates['res_popup'] = 'd.m.Y H:i';
        $dates['dashboard'] = 'l, d.m.Y H:i';
        $dates['period_time'] = 'H:i';
	$dates['general_date_js'] = 'dd.mm.yy';
	$dates['calendar_time'] = 'HH:mm';
	$dates['calendar_dates'] = 'd.M.';

        $this->Dates = $dates;

        return $this->Dates;
    }

    /**
     * @return array
     */
    protected function _LoadStrings()
    {
        $strings = array();

        $strings['FirstName'] = 'Jméno';
        $strings['LastName'] = 'Příjmení';
        $strings['Timezone'] = 'Časová zóna';
        $strings['Edit'] = 'Upravit';
        $strings['Change'] = 'Změnit';
        $strings['Rename'] = 'Přejmenovat';
        $strings['Remove'] = 'Odstranit';
        $strings['Delete'] = 'Smazat';
        $strings['Update'] = 'Uložit';
        $strings['Cancel'] = 'Zrušit';
        $strings['Add'] = 'Přidat';
        $strings['Name'] = 'Název';
        $strings['Yes'] = 'Ano';
        $strings['No'] = 'Ne';
        $strings['FirstNameRequired'] = 'Jméno je povinné.';
        $strings['LastNameRequired'] = 'Příjmení je povinné.';
        $strings['PwMustMatch'] = 'Hesla se neshodují.';
        $strings['PwComplexity'] = 'Heslo musí mít nejméně 6 znaků v kombinaci s velkým písmenem, číslem a symbolem.';
        $strings['ValidEmailRequired'] = 'Emailová adresa je povinná.';
        $strings['UniqueEmailRequired'] = 'Tato e-mailová adresa je již v systému zaregistrována.';
        $strings['UniqueUsernameRequired'] = 'Toto uživatelské jméno je již v systému zaregistrované.';
        $strings['UserNameRequired'] = 'Uživatelské jméno je povinné.';
        $strings['CaptchaMustMatch'] = 'Opište bezpečnostní kód z obrázku.';
        $strings['Today'] = 'Dnes';
        $strings['Week'] = 'Týden';
        $strings['Month'] = 'Měsíc';
        $strings['BackToCalendar'] = 'Zpět do kalendáře';
        $strings['BeginDate'] = 'Začátek';
        $strings['EndDate'] = 'Konec';
        $strings['Username'] = 'Už. jméno';
        $strings['Password'] = 'Heslo';
        $strings['PasswordConfirmation'] = 'Potvrdit heslo';
        $strings['DefaultPage'] = 'Výchozí hlavní stránka';
        $strings['MyCalendar'] = 'Můj kalendář';
        $strings['ScheduleCalendar'] = 'Plánovací kalendář';
        $strings['Registration'] = 'Registrace';
        $strings['NoAnnouncements'] = 'Není žádné omezení provozu';
        $strings['Announcements'] = 'Omezení provozu';
        $strings['NoUpcomingReservations'] = 'Nemáte žádné naplánované rezervace.';
        $strings['UpcomingReservations'] = 'Naplánované rezervace';
        $strings['ShowHide'] = 'Zobrazit/skrýt';
        $strings['Error'] = 'Chyba';
        $strings['ReturnToPreviousPage'] = 'Vrátit se zpět';
        $strings['UnknownError'] = 'Neznámá chyba';
        $strings['InsufficientPermissionsError'] = 'Nemáte oprávnení';
        $strings['MissingReservationResourceError'] = 'Nebyl vybrán prostředek';
        $strings['MissingReservationScheduleError'] = 'Nebyl zaškrtnut žádný den';
        $strings['DoesNotRepeat'] = 'Neopakovat';
        $strings['Daily'] = 'Denní';
        $strings['Weekly'] = 'Týdenní';
        $strings['Monthly'] = 'Měsíční';
        $strings['Yearly'] = 'Roční';
        $strings['RepeatPrompt'] = 'Opakování';
        $strings['hours'] = 'hodina';
        $strings['days'] = 'dny';
        $strings['weeks'] = 'týdny';
        $strings['months'] = 'měsíce';
        $strings['years'] = 'roky';
        $strings['day'] = 'den';
        $strings['week'] = 'týden';
        $strings['month'] = 'měsíc';
        $strings['year'] = 'rok';
        $strings['repeatDayOfMonth'] = 'dny měsíce';
        $strings['repeatDayOfWeek'] = 'dny týdne';
        $strings['RepeatUntilPrompt'] =	'až do';
        $strings['RepeatEveryPrompt'] = 'každý';
        $strings['RepeatDaysPrompt'] = 'Opakovat v dny';
        $strings['CreateReservationHeading'] = 'Vytváření rezervace';
        $strings['EditReservationHeading'] = 'Úpravit rezervaci: %s';
        $strings['ViewReservationHeading'] = 'Zobrazit rezervaci: %s';
        $strings['ReservationErrors'] = 'Změnit rezervaci';
        $strings['Create'] = 'Vytvořit';
        $strings['ThisInstance'] = 'Pouze tento případ';
        $strings['AllInstances'] = 'Všechny případy';
        $strings['FutureInstances'] = 'Budoucí případy';
        $strings['Print'] = 'Tisknout';
        $strings['ShowHideNavigation'] = 'zobrazit/skrýt navigaci';
        $strings['ReferenceNumber'] = 'Referenční číslo';
        $strings['Tomorrow'] = 'Zítra';
        $strings['LaterThisWeek'] = 'Později v tento týden';
        $strings['NextWeek'] = 'Následující týden';
        $strings['SignOut'] = 'Odhlásit se';
        $strings['LayoutDescription'] = 'Začátek %s, zobrazeno %s dnů';
        $strings['AllResources'] = 'Všechny prostředky';
        $strings['TakeOffline'] = 'Vzít offline';
        $strings['BringOnline'] = 'Vyvolat online';
        $strings['AddImage'] = 'Přidat obrázek';
        $strings['NoImage'] = 'Žádný obrázek';
        $strings['Move'] = 'Přesunout';
        $strings['AppearsOn'] = 'Objeví se na %s';
        $strings['Location'] = 'Umístění';
        $strings['NoLocationLabel'] = '(umístění nenastaveno)';
        $strings['Contact'] = 'Kontakt';
        $strings['NoContactLabel'] = '(kontakt nenastaven)';
        $strings['Description'] = 'Popis';
        $strings['NoDescriptionLabel'] = '(bez popisku)';
        $strings['Notes'] = 'Poznámky';
        $strings['NoNotesLabel'] = '(bez poznámek)';
        $strings['NoTitleLabel'] = '(bez názvu)';
        $strings['UsageConfiguration'] = 'Použít konfiguraci';
        $strings['ChangeConfiguration'] = 'Změnit konfiguraci';
        $strings['ResourceMinLength'] = 'Rezervace musí být delší než %s';
        $strings['ResourceMinLengthNone'] = 'Neexistuje žádná minimální doba rezervace';
        $strings['ResourceMaxLength'] = 'Rezervace musí být kratší než %s';
        $strings['ResourceMaxLengthNone'] = 'Neexistuje žádná maximální doba rezervace';
        $strings['ResourceRequiresApproval'] = 'Rezervace musí být schváleny';
        $strings['ResourceRequiresApprovalNone'] = 'Rezervace není třeba potvrzovat';
        $strings['ResourcePermissionAutoGranted'] = 'Povolení je automaticky získáno';
        $strings['ResourcePermissionNotAutoGranted'] = 'Povolení není automaticky získáno';
        $strings['ResourceMinNotice'] = 'Rezervace musí být uskutečněna nejméně %s před začátkem';
        $strings['ResourceMinNoticeNone'] = 'Rezervace lze provést až do současné doby';
        $strings['ResourceMaxNotice'] = 'Rezervace nesmí končit více než %s před současností';
        $strings['ResourceMaxNoticeNone'] = 'Rezervace může skončit kdykoliv v budoucnu';
        $strings['ResourceAllowMultiDay'] = 'Rezervace může být vytvořena na několik dnů';
        $strings['ResourceNotAllowMultiDay'] = 'Rezervace nelze provádět v rámci několika dnů';
        $strings['ResourceCapacity'] = 'Tento prostředek má omezenou kapacitu na %s osob';
        $strings['ResourceCapacityNone'] = 'Tento přírstoj má neomezenou kapacitu';
        $strings['AddNewResource'] = 'Přidat nový prostředek';
        $strings['AddNewUser'] = 'Přidat nového uživatele';
        $strings['AddUser'] = 'Přidat uživatele';
        $strings['Schedule'] = 'Rozvrhy';
        $strings['AddResource'] = 'Přidat prostředek';
        $strings['Capacity'] = 'Kapacita';
        $strings['Access'] = 'Přístup';
        $strings['Duration'] = 'Trvání';
        $strings['Active'] = 'Aktivní';
        $strings['Inactive'] = 'Vypnuto';
        $strings['ResetPassword'] = 'Přenastavit heslo';
        $strings['LastLogin'] = 'Poslední přihlášení';
        $strings['Search'] = 'Hledání';
        $strings['ResourcePermissions'] = 'Oprávnění prostředků';
        $strings['Reservations'] = 'Rezervace';
        $strings['Groups'] = 'Skupiny';
        $strings['ResetPassword'] = 'Resetovat heslo';
        $strings['AllUsers'] = 'Všichni uživatelé';
        $strings['AllGroups'] = 'Všechny skupiny';
        $strings['AllSchedules'] = 'Všechny rozvrhy'; 
        $strings['UsernameOrEmail'] = 'Uživatelské jméno nebo e-mail';
        $strings['Members'] = 'Členové';
        $strings['QuickSlotCreation'] = 'Vytvořit místo každých %s minut mezi %s a %s';
        $strings['ApplyUpdatesTo'] = 'provést update';
        $strings['CancelParticipation'] = 'Zrušení účastníků';
        $strings['Attending'] = 'Účast';
        $strings['QuotaConfiguration'] = 'pro %s pro %s uživatelům v %s omezení počtu %s %s na %s';
        $strings['reservations'] = 'rezervací';
        $strings['ChangeCalendar'] = 'Změnit kalendář';
        $strings['AddQuota'] = 'Přdat kvótu';
        $strings['FindUser'] = 'Najít uživatele';
        $strings['Created'] = 'Vytvořeno';
        $strings['LastModified'] = 'Poslední úprava';
        $strings['GroupName'] = 'Název skupiny';
        $strings['GroupMembers'] = 'Členové skupiny';
        $strings['GroupRoles'] = 'Role skupiny';
        $strings['GroupAdmin'] = 'Administrátor skupiny';
        $strings['Actions'] = 'Akce';
        $strings['CurrentPassword'] = 'Současné heslo';
        $strings['NewPassword'] = 'Nové heslo';
        $strings['InvalidPassword'] = 'Bylo chybně zadáno současné heslo.';
        $strings['PasswordChangedSuccessfully'] = 'Vaše nové heslo bylo úspěšně nastaveno';
        $strings['SignedInAs'] = 'Přihlášen jako';
        $strings['NotSignedIn'] = 'Nepřihlášený';
        $strings['ReservationTitle'] = 'Název rezervace';
        $strings['ReservationDescription'] = 'Volitelný popis';
        $strings['ResourceList'] = 'Rezervované prostředky';
        $strings['Accessories'] = 'Příslušenství';
        $strings['Add'] = 'Přidat';
        $strings['ParticipantList'] = 'Seznam účastníků';
        $strings['InvitationList'] = 'Pozvání';
        $strings['AccessoryName'] = 'Název příslušenství';
        $strings['QuantityAvailable'] = 'Dostupné množství';
        $strings['Resources'] = 'Prostředky';
        $strings['Participants'] = 'Účastníci';
        $strings['User'] = 'Uživatel';
        $strings['Resource'] = 'Prostředek';
        $strings['Status'] = 'Stav';
        $strings['Approve'] = 'Schvalování';
        $strings['Page'] = 'Strana';
        $strings['Rows'] = 'Řádek';
        $strings['Unlimited'] = 'neomezeno';
        $strings['Email'] = 'Email';
        $strings['EmailAddress'] = 'Emailová adresa';
        $strings['Phone'] = 'Telefon';
        $strings['Organization'] = 'Společnost';
        $strings['Position'] = 'Pozice';
        $strings['Language'] = 'Jazyk';
        $strings['Permissions'] = 'Oprávnění';
        $strings['Reset'] = 'Reset';
        $strings['FindGroup'] = 'Najít skupinu';
        $strings['Manage'] = 'Spravovat';
        $strings['None'] = 'Nezadáno';
        $strings['AddToOutlook'] = 'Přidat do aplikace Outlook';
        $strings['Done'] = 'Hotovo';
        $strings['RememberMe'] = 'Přihlásit se trvale';
        $strings['FirstTimeUser?'] = 'Nemáte zde založený účet?';
        $strings['CreateAnAccount'] = 'Registrovat se';
        $strings['ViewSchedule'] = 'Zobrazit rozvrh'; 
        $strings['ForgotMyPassword'] = 'Zapomenuté heslo';
        $strings['YouWillBeEmailedANewPassword'] = 'Na zadaný e-mail Vám bude zasláno nově vygenerované heslo.';
        $strings['Close'] = 'Zavřít';
        $strings['ExportToCSV'] = 'Exportovat do souboru CSV';
        $strings['OK'] = 'Odeslat';
        $strings['Working'] = 'Pracovní...';
        $strings['Login'] = 'Přihlášení';
        $strings['AdditionalInformation'] = 'Další informace';
        $strings['AllFieldsAreRequired'] = 'Všechna pole jsou povinná';
        $strings['Optional'] = 'Nepovinné';
        $strings['YourProfileWasUpdated'] = 'Váš profil by aktualizován.';
        $strings['YourSettingsWereUpdated'] = 'Vaše nastavení bylo provedeno';
        $strings['Register'] = 'Registrovat';
        $strings['SecurityCode'] = 'Bezpečnostní kód';
        $strings['ReservationCreatedPreference'] = 'Když vytvořím rezervaci, nebo když je rezervace mému účtu vytvořena.';
        $strings['ReservationUpdatedPreference'] = 'Když změním rezervaci, nebo když je rezervace mému účtu změněna.';
        $strings['ReservationDeletedPreference'] = 'Když smažu rezervaci, nebo když je rezervace mému účtu smazána.';
        $strings['ReservationApprovalPreference'] = 'Když je má rezervace potvrzena';
        $strings['PreferenceSendEmail'] = 'Oznámit e-mailem';
        $strings['PreferenceNoEmail'] = 'Neoznamovat';
        $strings['ReservationCreated'] = 'Rezervace byla vytvořena.';
        $strings['ReservationUpdated'] = 'Rezervace byla upravena.';
        $strings['ReservationRemoved'] = 'Rezervace byla odstraněna.';
        $strings['YourReferenceNumber'] = 'Referenční číslo: %s';
        $strings['UpdatingReservation'] = 'Obnovení rezervace';
        $strings['ChangeUser'] = 'Změnit uživatele';
        $strings['MoreResources'] = 'Přidat další prostředek';
        $strings['ReservationLength'] = 'Délka rezervace';
        $strings['ParticipantList'] = 'Seznam účastníků';
        $strings['AddParticipants'] = 'Přidat účastníka';
        $strings['InviteOthers'] = 'Pozvat ostatní';
        $strings['AddResources'] = 'Přidat prostředky';
        $strings['AddAccessories'] = 'Přidat příslušenství';
        $strings['Accessory'] = 'Příslušenství';
        $strings['QuantityRequested'] = 'Požadované množství';
        $strings['CreatingReservation'] = 'Vytváření rezervace';
        $strings['UpdatingReservation'] = 'Úprava rezervace';
        $strings['DeleteWarning'] = 'Tato akce je trvalá a nelze ji vrátit zpět!';
        $strings['DeleteAccessoryWarning'] = 'Při odstranění tohoto příslušenství jej odstraníte také ze všech rezervací.';
        $strings['AddAccessory'] = 'Přidat příslušenství';
        $strings['AddBlackout'] = 'Přidat období, ve kterém nebude prostředek dostupný';
        $strings['AllResourcesOn'] = 'všechny prostředky na';
        $strings['Reason'] = 'Odůvodnění';
        $strings['BlackoutShowMe'] = 'Zobrazit rezervace, které jsou v konfliktu s jinými';
        $strings['BlackoutDeleteConflicts'] = 'Odstranit rezervace, které jsou v konfliktu s jinými';
        $strings['Filter'] = 'Filtr';
        $strings['Between'] = 'Mezi';
        $strings['CreatedBy'] = 'Vytvořil';
        $strings['BlackoutCreated'] = 'Doba uzavření byla nastavena.';
        $strings['BlackoutNotCreated'] = 'Doba uzavření nebyla nastavena';
        $strings['BlackoutConflicts'] = 'Jsou zde časy zavřeného provozu v konfliktu s jinými';
        $strings['ReservationConflicts'] = 'Jsou zde rezervované čase v konfliktu s jinými';
        $strings['UsersInGroup'] = 'Uživatelé v této skupině';
        $strings['Browse'] = 'Prohledat';
        $strings['DeleteGroupWarning'] = 'Odstraněním této skupiny budou odstraněny všechny související oprávnění k prostředkům. Uživatelé v této skupině mohou přijít o přístup k prostředkům.';
        $strings['WhatRolesApplyToThisGroup'] = 'Jaká role se vztahuje k této skupině?';
        $strings['WhoCanManageThisGroup'] = 'Kdo může spravovat tuto skupinu?';
        $strings['WhoCanManageThisSchedule'] = 'Kdo může spravovat tento kalendář?';
        $strings['AddGroup'] = 'Přidat skupinu';
        $strings['AllQuotas'] = 'Všechny kvóty';
        $strings['QuotaReminder'] = 'Nezapomeňte: Kvóty se uplatňují na základě nastavení časového pásma.';
        $strings['AllReservations'] = 'Všechny rezervace';
        $strings['PendingReservations'] = 'Nevyřízené rezervace';
        $strings['Approving'] = 'Schvalování';
        $strings['MoveToSchedule'] = 'Přesunout do rozvrhu';
        $strings['DeleteResourceWarning'] = 'Odstraněním tohoto prostředku vymažete všechna související data.';
        $strings['DeleteResourceWarningReservations'] = 'všechny minulé, současné a budoucí rezervace s ním spojené';
        $strings['DeleteResourceWarningPermissions'] = 'všechna přiřazená povolení';
        $strings['DeleteResourceWarningReassign'] = 'Prosím přeřaďte cokoli, co nechcete, aby bylo vymazáno.';
        $strings['ScheduleLayout'] = 'Rozvržení (časy v %s)';
        $strings['ReservableTimeSlots'] = 'Rezervovatelné časové úseky';
        $strings['BlockedTimeSlots'] = 'Blokovaný časový úsek';
        $strings['ThisIsTheDefaultSchedule'] = 'Toto je základní rozvrh';
        $strings['DefaultScheduleCannotBeDeleted'] = 'základní rozvrh nemůže být odstraněn';
        $strings['MakeDefault'] = 'Nastavit jako základní';
        $strings['BringDown'] = 'Snížit';
        $strings['ChangeLayout'] = 'Změnit rozvržení';
        $strings['AddSchedule'] = 'Přidat rozvrh'; 
	$strings['StartsOn'] = 'Začíná od';
        $strings['NumberOfDaysVisible'] = 'Viditelné dnů';
        $strings['UseSameLayoutAs'] = 'Použít rozvržení jako';
        $strings['Format'] = 'Formát';
        $strings['OptionalLabel'] = 'Nepovinné pole';
        $strings['LayoutInstructions'] = 'Vložte každý časový úsek na jeden řádek. Časové úseky musí být naplánovány na celý den - 24hodin';
        $strings['AddUser'] = 'Ručně přidat nového uživatele';
        $strings['UserPermissionInfo'] = 'Aktuální přístup k prostředku se může lišit v závislosti na roli uživatele a skupiny oprávnění nebo externím nastavení oprávnění';
        $strings['DeleteUserWarning'] = 'Po odstranění tohoto uživatele odstraníte také jeho všechny současné, budoucí a minulé rezervace.';
        $strings['AddAnnouncement'] = 'Naplánovat přerušení provozu';
        $strings['Announcement'] = 'Text při úplném přerušení provozu';
        $strings['Priority'] = 'Priorita';
        $strings['Reservable'] = 'Volné';
        $strings['Unreservable'] = 'Zavřeno';
        $strings['Reserved'] = 'Rezervováno';
        $strings['MyReservation'] = 'Mé rezervace';
        $strings['Pending'] = 'Proces schválení';
        $strings['Past'] = 'Zmeškané';
        $strings['Restricted'] = 'Mimo provoz';
        $strings['ViewAll'] = 'Zobrazit vše';
        $strings['MoveResourcesAndReservations'] = 'Přesunout prostředky a rezervace do';
        $strings['TurnOffSubscription'] = 'Vypnout zapisování do kalendáře';
        $strings['TurnOnSubscription'] = 'Zapnout zapisování do kalendáře';
        $strings['SubscribeToCalendar'] = 'Zapisovací kalendář';
        $strings['SubscriptionsAreDisabled'] = 'Administrátor zakázal zapisování do kalendáře';
        $strings['NoResourceAdministratorLabel'] = '(Žádný správce)';
        $strings['WhoCanManageThisResource'] = 'Kdo může spravovat tento prostředek?';
        $strings['ResourceAdministrator'] = 'Správce prostředku';
        $strings['Private'] = 'Soukromé';
        $strings['Accept'] = 'Potvrdit';
        $strings['Decline'] = 'Zamítnout';
	$strings['ShowFullWeek'] = 'Zobrazit celý týden';
	$strings['CustomAttributes'] = 'Upravit atributy';
        $strings['AddAttribute'] = 'Přidat atribut';
        $strings['EditAttribute'] = 'Upravit atribut';
        $strings['DisplayLabel'] = 'Zobrazit pole';
        $strings['Type'] = 'Typ';
        $strings['Required'] = 'Povinné';
        $strings['ValidationExpression'] = 'Validation Expression';
        $strings['PossibleValues'] = 'Možnosti';
        $strings['SingleLineTextbox'] = 'jednotné textové pole';
        $strings['MultiLineTextbox'] = 'Mnohonásobné textové pole';
        $strings['Checkbox'] = 'Zaškrtávací seznam';
        $strings['SelectList'] = 'Výběr z nabídky';
        $strings['CommaSeparated'] = 'oddělujte čárkou';
        $strings['Category'] = 'Kategorie';
        $strings['CategoryReservation'] = 'Rezervace';
        $strings['CategoryGroup'] = 'Skupina';
        $strings['SortOrder'] = 'Pořadí';
        $strings['Title'] = 'Nadpis';
        $strings['AdditionalAttributes'] = 'Další atributy';
        $strings['True'] = 'Ano';
        $strings['False'] = 'Ne';
	$strings['ForgotPasswordEmailSent'] = 'Na zadaný e-mail byly odeslány instrukce pro obnovení hesla.';
	$strings['ActivationEmailSent'] = 'Brzy obdržíte aktivační e-mail.';
	$strings['AccountActivationError'] = 'Omlouváme se, Váš učet ještě není schválen.';
	$strings['Attachments'] = 'Přílohy';
	$strings['AttachFile'] = 'Příloha';
	$strings['Maximum'] = 'limit';
	$strings['NoScheduleAdministratorLabel'] = '(Žádný správce)';
	$strings['ScheduleAdministrator'] = 'Správce Rozvrhu';
	$strings['Total'] = 'Celkem';
	$strings['QuantityReserved'] = 'Rezervované množství';
	$strings['AllAccessories'] = 'Všechno příslušenství';
	$strings['GetReport'] = 'Zobrazit přehled';
	$strings['NoResultsFound'] = 'Nenalezena žádná shoda';
	$strings['SaveThisReport'] = 'Uložit přehled';
	$strings['ReportSaved'] = 'Přehled uložen!';
	$strings['EmailReport'] = 'Zaslat přehled e-mailem';
	$strings['ReportSent'] = 'Přehled odeslán na e-mail!';
	$strings['RunReport'] = 'Spustit přehled';
	$strings['NoSavedReports'] = 'Nemáte uložený žádný přehled.';
	$strings['CurrentWeek'] = 'Tento týden';
	$strings['CurrentMonth'] = 'Tento měsíc';
	$strings['AllTime'] = 'Vše';
	$strings['FilterBy'] = 'Filtrovat podle';
	$strings['Select'] = 'Typ přehledu';
	$strings['List'] = 'Seznam';
	$strings['TotalTime'] = 'Celkový čas';
	$strings['Count'] = 'Počet';
	$strings['Usage'] = 'Využití';
	$strings['AggregateBy'] = 'Rozdělení';
	$strings['Range'] = 'Období';
	$strings['Choose'] = 'Vyberte';
	$strings['All'] = 'Všechno';
	$strings['ViewAsChart'] = 'Zobrazit jako graf';
	$strings['ReservedResources'] = 'Rezervované prostředky';
	$strings['ReservedAccessories'] = 'Rezervované příslušenství';
	$strings['ResourceUsageTimeBooked'] = 'Využití prostředků - celkový čas';
	$strings['ResourceUsageReservationCount'] = 'Využití prostředků - počet rezervací';
	$strings['Top20UsersTimeBooked'] = '20 největších uživatelů - celkový čas';
	$strings['Top20UsersReservationCount'] = '20 největších uživatelů - počet rezervací';
    $strings['ConfigurationUpdated'] = 'Konfigurační soubor byl aktualizován';
    
    $strings['ConfigurationUiNotEnabled'] = 'This page cannot be accessed because $conf[\'settings\'][\'pages\'][\'enable.configuration\'] is set to false or missing.';
    $strings['ConfigurationFileNotWritable'] = 'The config file is not writable. Please check the permissions of this file and try again.';
    $strings['ConfigurationUpdateHelp'] = 'Refer to the Configuration section of the <a target=_blank href=%s>Help File</a> for documentation on these settings.';
    $strings['GeneralConfigSettings'] = 'nastavení';
    $strings['UseSameLayoutForAllDays'] = 'Use the same layout for all days';
    $strings['LayoutVariesByDay'] = 'Layout varies by day';
    $strings['ManageReminders'] = 'Reminders';
    $strings['ReminderUser'] = 'User ID';
    $strings['ReminderMessage'] = 'Message';
    $strings['ReminderAddress'] = 'Addresses';
    $strings['ReminderSendtime'] = 'Time To Send';
    $strings['ReminderRefNumber'] = 'Reservation Reference Number';
    $strings['ReminderSendtimeDate'] = 'Date of Reminder';
    $strings['ReminderSendtimeTime'] = 'Time of Reminder (HH:MM)';
    $strings['ReminderSendtimeAMPM'] = 'AM / PM';
    $strings['AddReminder'] = 'Add Reminder';
    $strings['DeleteReminderWarning'] = 'You sure about this?';
    $strings['NoReminders'] = 'You have no upcoming reminders.';
    $strings['Reminders'] = 'Reminders';
    $strings['SendReminder'] = 'Send Reminder';
    $strings['minutes'] = 'minut';
    $strings['hours'] = 'hodin';
    $strings['days'] = 'dnů';
    $strings['ReminderBeforeStart'] = 'before the start time';
    $strings['ReminderBeforeEnd'] = 'before the end time';
    $strings['Logo'] = 'Logo';
    $strings['CssFile'] = 'CSS File';
    $strings['ThemeUploadSuccess'] = 'Your changes have been saved. Refresh the page for changes to take effect.';
    $strings['MakeDefaultSchedule'] = 'Nastavit jako muj základní rozvrh';
    $strings['DefaultScheduleSet'] = 'Toto je teď váš základní rozvrh';
    $strings['FlipSchedule'] = 'Přepnout zobrazení rozvrhu';
    $strings['Next'] = 'Další';
    $strings['Success'] = 'Úspěch';
    $strings['Participant'] = 'Účastník';
    // End Strings

// Install
		$strings['InstallApplication'] = 'Install phpScheduleIt (MySQL only)';
		$strings['IncorrectInstallPassword'] = 'Sorry, that password was incorrect.';
		$strings['SetInstallPassword'] = 'You must set an install password before the installation can be run.';
		$strings['InstallPasswordInstructions'] = 'In %s please set %s to a password which is random and difficult to guess, then return to this page.<br/>You can use %s';
		$strings['NoUpgradeNeeded'] = 'There is no upgrade needed. Running the installation process will delete all existing data and install a new copy of phpScheduleIt!';
		$strings['ProvideInstallPassword'] = 'Please provide your installation password.';
		$strings['InstallPasswordLocation'] = 'This can be found at %s in %s.';
		$strings['VerifyInstallSettings'] = 'Verify the following default settings before continuing. Or you can change them in %s.';
		$strings['DatabaseName'] = 'Database Name';
		$strings['DatabaseUser'] = 'Database User';
		$strings['DatabaseHost'] = 'Database Host';
		$strings['DatabaseCredentials'] = 'You must provide credentials of a MySQL user who has privileges to create databases. If you do not know, contact your database admin. In many cases, root will work.';
		$strings['MySQLUser'] = 'MySQL User';
		$strings['InstallOptionsWarning'] = 'The following options will probably not work in a hosted environment. If you are installing in a hosted environment, use the MySQL wizard tools to complete these steps.';
		$strings['CreateDatabase'] = 'Create the database';
		$strings['CreateDatabaseUser'] = 'Create the database user';
		$strings['PopulateExampleData'] = 'Import sample data. Creates admin account: admin/password and user account: user/password';
		$strings['DataWipeWarning'] = 'Warning: This will delete any existing data';
		$strings['RunInstallation'] = 'Run Installation';
		$strings['UpgradeNotice'] = 'You are upgrading from version <b>%s</b> to version <b>%s</b>';
		$strings['RunUpgrade'] = 'Run Upgrade';
		$strings['Executing'] = 'Executing';
		$strings['StatementFailed'] = 'Failed. Details:';
		$strings['SQLStatement'] = 'SQL Statement:';
		$strings['ErrorCode'] = 'Error Code:';
		$strings['ErrorText'] = 'Error Text:';
		$strings['InstallationSuccess'] = 'Installation completed successfully!';
		$strings['RegisterAdminUser'] = 'Register your admin user. This is required if you did not import the sample data. Ensure that $conf[\'settings\'][\'allow.self.registration\'] = \'true\' in your %s file.';
		$strings['LoginWithSampleAccounts'] = 'If you imported the sample data, you can log in with admin/password for admin user or user/password for basic user.';
		$strings['InstalledVersion'] = 'You are now running version %s of phpScheduleIt';
		$strings['InstallUpgradeConfig'] = 'It is recommended to upgrade your config file';
		$strings['InstallationFailure'] = 'There were problems with the installation.  Please correct them and retry the installation.';
		$strings['ConfigureApplication'] = 'Configure phpScheduleIt';
		$strings['ConfigUpdateSuccess'] = 'Your config file is now up to date!';
		$strings['ConfigUpdateFailure'] = 'We could not automatically update your config file. Please overwrite the contents of config.php with the following:';
		// End Install

        // Errors
        $strings['LoginError'] = 'Chybně zadané uživatelské jméno nebo heslo.';
        $strings['ReservationFailed'] = 'Vaše rezervace nemůže být vytvořena.';
        $strings['MinNoticeError'] = 'Tato rezervace musí obsahovat popis. Nejstarší datum, které může být rezervováno je %s.';
        $strings['MaxNoticeError'] = 'Tato rezervace nemůže být naplánována tak daleko. Nejzazší datum, které může být rezervováno je %s.';
        $strings['MinDurationError'] = 'Tato rezervace musí být delší než %s.';
        $strings['MaxDurationError'] = 'Tato rezervace nemůže trvat déle než %s.';
        $strings['ConflictingAccessoryDates'] = 'Zatím je zde omezený počet příslušenství:';
        $strings['NoResourcePermission'] = 'Nemáte oprávnění k jednomu nebo více požadovaným prostředkům';
        $strings['ConflictingReservationDates'] = 'Zde je výpis rezervací, které jsou v konfliktu s Vámi vytvořenou:';
        $strings['StartDateBeforeEndDateRule'] = 'Začátek rezervace musí začínat dříve než její konec.';
        $strings['StartIsInPast'] = 'Začátek rezervace nemůže být vytvořen v minulosti';
        $strings['EmailDisabled'] = 'Administrátor zakázal posílání e-mailových upozornění.';
        $strings['ValidLayoutRequired'] = 'Časový úsek musí být vytvořen na celý den - 24hodin';
	$strings['CustomAttributeErrors'] = 'Chybné s dalšími hodnotami:';
        $strings['CustomAttributeRequired'] = '%s je povinné pole';
        $strings['CustomAttributeInvalid'] = 'Hodnota pro %s je chybná';
        $strings['AttachmentLoadingError'] = 'Omlouváme se, došlo k chybě při načítání požadovaného souboru.';
        $strings['InvalidAttachmentExtension'] = 'Můžete nahrát pouze soubory těchto typů: %s';
		$strings['InvalidStartSlot'] = 'The start date and time requested is not valid.';
		$strings['InvalidEndSlot'] = 'The end date and time requested is not valid.';
		$strings['MaxParticipantsError'] = '%s can only support %s participants.';
		$strings['ReservationCriticalError'] = 'There was a critical error saving your reservation. If this continues, contact your system administrator.';
		$strings['InvalidStartReminderTime'] = 'The start reminder time is not valid.';
		$strings['InvalidEndReminderTime'] = 'The end reminder time is not valid.';
		// End Errors

        // Page Titles
        $strings['CreateReservation'] = 'Vytvořit rezervaci';
        $strings['EditReservation'] = 'Upravování rezervace';
        $strings['LogIn'] = 'Přihlásit';
        $strings['ManageReservations'] = 'Rezervace';
        $strings['AwaitingActivation'] = 'Čeká na aktivaci';
        $strings['PendingApproval'] = 'Probíhá schválení';
        $strings['ManageSchedules'] = 'Rozvrhy';
        $strings['ManageResources'] = 'Prostředky';
        $strings['ManageAccessories'] = 'Příslušenství';
        $strings['ManageUsers'] = 'Uživatelé';
        $strings['ManageGroups'] = 'Skupiny';
        $strings['ManageQuotas'] = 'Kvóty';
        $strings['ManageBlackouts'] = 'Termíny přerušení provozu';
        $strings['MyDashboard'] = 'Hlavní strana';
        $strings['ServerSettings'] = 'Informace o serveru';
        $strings['Dashboard'] = 'Hlavní přehled';
        $strings['Help'] = 'Nápověda';
        $strings['Administration'] = 'Administrace';
        $strings['About'] = 'O nás';
        $strings['Bookings'] = 'Rezervace';
        $strings['Schedule'] = 'Plánování';
        $strings['Reservations'] = 'Rezervace';
        $strings['Account'] = 'Účet';
        $strings['EditProfile'] = 'Upravit vlastní profil';
        $strings['FindAnOpening'] = 'Najít otevření';
        $strings['OpenInvitations'] = 'Zobrazit pozvání';
        $strings['MyCalendar'] = 'Kalendář mých rezervací';
        $strings['ResourceCalendar'] = 'Kalendář všech prostředků';
        $strings['Reservation'] = 'Nová rezervace';
        $strings['Install'] = 'Instalace';
        $strings['ChangePassword'] = 'Změnit heslo';
        $strings['MyAccount'] = 'Můj účet';
        $strings['Profile'] = 'Nastavení profilu';
        $strings['ApplicationManagement'] = 'Správa systému';
        $strings['ForgotPassword'] = 'zapomenuté heslo';
        $strings['NotificationPreferences'] = 'Nastavení oznámení e-mailem'; 
        $strings['ManageAnnouncements'] = 'Úplné přerušení provozu'; 
        $strings['Responsibilities'] = 'Správa';
        $strings['GroupReservations'] = 'Skupinové rezervace';
        $strings['ResourceReservations'] = 'Rezervace prostředků';
        $strings['Customization'] = 'Přizpůsobení';
        $strings['Attributes'] = 'Atributy';
        $strings['AccountActivation'] = 'Aktivace účtů';
        $strings['ScheduleReservations'] = 'Rezervace kalendářů';
        $strings['Reports'] = 'Přehledy';
        $strings['GenerateReport'] = 'Vytvořit nový přehled';
        $strings['MySavedReports'] = 'Moje uložené přehledy';
        $strings['CommonReports'] = 'Společné přehledy';
        $strings['ViewDay'] = 'Zobrazit denní přehled';
        $strings['Group'] = 'Skupina';
		$strings['ManageConfiguration'] = 'Konfigurace';
		$strings['LookAndFeel'] = 'Vzhled';
       // End Page Titles


        // Day representations
        $strings['DaySundaySingle'] = 'Ne';
        $strings['DayMondaySingle'] = 'Po';
        $strings['DayTuesdaySingle'] = 'Út';
        $strings['DayWednesdaySingle'] = 'St';
        $strings['DayThursdaySingle'] = 'Čt';
        $strings['DayFridaySingle'] = 'Pá';
        $strings['DaySaturdaySingle'] = 'So';

        $strings['DaySundayAbbr'] = 'Ne';
        $strings['DayMondayAbbr'] = 'Po';
        $strings['DayTuesdayAbbr'] = 'Út';
        $strings['DayWednesdayAbbr'] = 'St';
        $strings['DayThursdayAbbr'] = 'Čt';
        $strings['DayFridayAbbr'] = 'Pá';
        $strings['DaySaturdayAbbr'] = 'So';
		// End Day representations

        // Email Subjects
        $strings['ReservationApprovedSubject'] = 'Vaše rezervace byla potvrzena';
        $strings['ReservationCreatedSubject'] = 'Rezervace byla vytvořena';
        $strings['ReservationUpdatedSubject'] = 'Rezervace byla upravena';
        $strings['ReservationDeletedSubject'] = 'Rezervace byla zrušena';
        $strings['ReservationCreatedAdminSubject'] = 'Upozornění: rezervace vytvořena';
        $strings['ReservationUpdatedAdminSubject'] = 'Upozornění: rezervace upravena';
        $strings['ReservationDeleteAdminSubject'] = 'Upozornění: rezervace zrušena';
        $strings['ParticipantAddedSubject'] = 'Upozornění: rezervace účastníků';
        $strings['ParticipantDeletedSubject'] = 'Rezervace zrušena';
        $strings['InviteeAddedSubject'] = 'Pozvánka do rezervace';
        $strings['ResetPassword'] = 'Požadavek na resetování hesla';
        $strings['ActivateYourAccount'] = 'Prosíme, aktivujte svůj účet';
        $strings['ReportSubject'] = 'Vaše požadované zprávy (%s)';
		$strings['ReservationStartingSoonSubject'] = 'Reservation for %s is starting soon';
		$strings['ReservationEndingSoonSubject'] = 'Reservation for %s is ending soon';

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
        $days['full'] = array('Neděle', 'Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota');
        // The three letter abbreviation
        $days['abbr'] = array('Ne', 'Po', 'Út', 'St', 'Čt', 'Pá', 'So');
        // The two letter abbreviation
        $days['two'] = array('Ne', 'Po', 'Út', 'St', 'Čt', 'Pá', 'So');
        // The one letter abbreviation
        $days['letter'] = array('Ne', 'Po', 'Út', 'St', 'Čt', 'Pá', 'So');

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
        $months['full'] = array('Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen', 'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec');
        // The three letter month name
        $months['abbr'] = array('Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen', 'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec');

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
        return 'cz';
    }
}

?>
