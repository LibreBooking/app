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

/* Translation for Hebrew interface. Prepared November 2012 by
   Yosef Branse, Younes and Soraya Nazarian Library, University of Haifa.
   Hebrew encoding is UTF-8.
   Corrections and comments may be sent to: jody@univ.haifa.ac.il

   N.B. The term 'resource' has been consistently translated as 'חדר' (room)
   rather than the literal 'משאב', since the application was used by the
   University of Haifa Library for room reservations only. A site which
   enables reservation of different resources may adapt the translation
   as necessary.
*/

require_once('Language.php');
require_once('en_us.php');

class he extends en_us
{
    public function __construct()
    {
        parent::__construct();

		$this->TextDirection = 'rtl';
    }

    /**
     * @return array
     */
    protected function _LoadDates()
    {
        $dates = array();

        $dates['general_date'] = 'd/m/Y';
        /* $dates['general_datetime'] = 'd/m/Y HH:MM:s'; */
         $dates['general_datetime'] = 'd/m/Y H:i:s';
        $dates['schedule_daily'] = 'l, d/m/Y';
        $dates['reservation_email'] = 'd/m/Y @ g:i A (e)';
        $dates['res_popup'] = 'd/m/Y g:i A';
        $dates['dashboard'] = 'l, d/m/Y g:i A';
        $dates['period_time'] = 'g:i A';
	$dates['general_date_js'] = 'dd/mm/yy';
	/* $dates['calendar_time'] = 'HH:MMt'; */
	$dates['calendar_time'] = 'h:mmt';
	$dates['calendar_dates'] = 'd/M';

        $this->Dates = $dates;

        return $this->Dates;
    }

    /**
     * @return array
     */
    protected function _LoadStrings()
    {
        $strings = array();

        $strings['FirstName'] = 'שם פרטי';
        $strings['LastName'] = 'שמ משפחה';
        $strings['Timezone'] = 'אזור זמן';
        $strings['Edit'] = 'עריכה';
        $strings['Change'] = 'לשנות';
        $strings['Rename'] = 'שם אחר';
        $strings['Remove'] = 'להסיר';
        $strings['Delete'] = 'למחוק את ההזמנה';
        $strings['Update'] = 'לעדכן את ההזמנה';
        $strings['Cancel'] = 'לבטל שינויים';
        $strings['Add'] = 'להוסיף';
        $strings['Name'] = 'שם';
        $strings['Yes'] = 'כן';
        $strings['No'] = 'לא';
        $strings['FirstNameRequired'] = 'שם פרטי חיוני.';
        $strings['LastNameRequired'] = 'שם משפחה חיוני.';
        $strings['PwMustMatch'] = 'אימות סיסמה חייבת להיות זהה לסיסמה.';
        $strings['PwComplexity'] = 'סיסמה חייבת להיות לפחות 6 תווים, עם צירוף של אותיות, ספרות וסימנים מיוחדים.';
        $strings['ValidEmailRequired'] = 'כתובת דואר אלקטרוני תקינה - חובה.';
        $strings['UniqueEmailRequired'] = 'כתובת דואר אלקטרוני זו כבר רשומה.';
        $strings['UniqueUsernameRequired'] = 'שם משתמש זה כבר שרום.';
        $strings['UserNameRequired'] = 'שם משתמש - חובה.';
        $strings['CaptchaMustMatch'] = 'נא להקיש תווים מתמונת הבטחון בדיוק כפי שהם מוצגים.';
        $strings['Today'] = 'היום';
        $strings['Week'] = 'שבוע';
        $strings['Month'] = 'יחודש';
        $strings['BackToCalendar'] = 'חזרה ללוח';
        $strings['BeginDate'] = 'תאריך התחלה';
        $strings['EndDate'] = 'תאריך סופי';
        $strings['Username'] = 'שם משתמש';
        $strings['Password'] = 'סיסמה';
        $strings['PasswordConfirmation'] = 'אימות סיסמה';
        $strings['DefaultPage'] = 'דף בית - ברירת מחדל';
        $strings['MyCalendar'] = 'לוח שלי';
        $strings['ScheduleCalendar'] = 'לוח שבועי';
        $strings['Registration'] = 'הרשמה';
        $strings['NoAnnouncements'] = 'אין הודעות';
        $strings['Announcements'] = 'הודעות';
        $strings['NoUpcomingReservations'] = 'אין לך הזמנות עתידיות';
        $strings['UpcomingReservations'] = 'הזמנות עתידיות';
        $strings['ShowHide'] = 'להציג/להסתיר';
        $strings['Error'] = 'שגיאה';
        $strings['ReturnToPreviousPage'] = 'חזרה לדף הקודם';
        $strings['UnknownError'] = 'שגיאה לא ידועה';
        $strings['InsufficientPermissionsError'] = 'אין לך הרשאות לגשת לחדר זה';
        $strings['MissingReservationResourceError'] = 'לא נבחר שום חדר';
        $strings['MissingReservationScheduleError'] = 'לא נבחר שום לוח';
        $strings['DoesNotRepeat'] = 'אין הישנות';
        $strings['Daily'] = 'יומי';
        $strings['Weekly'] = 'שבועי';
        $strings['Monthly'] = 'חדשי';
        $strings['Yearly'] = 'שנתי';
        $strings['RepeatPrompt'] = 'הישנות';
        $strings['hours'] = 'שעות';
        $strings['days'] = 'ימים';
        $strings['weeks'] = 'שבועות';
        $strings['months'] = 'חודשים';
        $strings['years'] = 'שנים';
        $strings['day'] = 'יום';
        $strings['week'] = 'שבוע';
        $strings['month'] = 'חודש';
        $strings['year'] = 'שנה';
        $strings['repeatDayOfMonth'] = 'יום בחודש';
        $strings['repeatDayOfWeek'] = 'יום בשבוע';
        $strings['RepeatUntilPrompt'] = 'עד';
        $strings['RepeatEveryPrompt'] = 'כל';
        $strings['RepeatDaysPrompt'] = 'על';
        $strings['CreateReservationHeading'] = 'הזמנה חדשה';
        $strings['EditReservationHeading'] = 'עריכת הזמנה %s';
        $strings['ViewReservationHeading'] = 'צפייה בהזמנה %s';
        $strings['ReservationErrors'] = 'לשנות הזמנה';
        $strings['Create'] = 'ליצור';
        $strings['ThisInstance'] = 'מקרה זה בלבד';
        $strings['AllInstances'] = 'כל מקרים';
        $strings['FutureInstances'] = 'מקרים עתידיים';
        $strings['Print'] = 'הדפס';
        $strings['ShowHideNavigation'] = 'להציג/להסתיר ניווט';
        $strings['ReferenceNumber'] = 'מספר אסמכתא';
        $strings['Tomorrow'] = 'מחר';
        $strings['LaterThisWeek'] = 'יותר מאוחר בשבוע זה';
        $strings['NextWeek'] = 'שבוע הבא';
        $strings['SignOut'] = 'להתנתק';
        $strings['LayoutDescription'] = 'מתחיל ב- %s, מראה %s ימים ביחד';
        $strings['AllResources'] = 'כל החדרים';
        $strings['TakeOffline'] = 'Take Offline';
        $strings['BringOnline'] = 'Bring Online';
        $strings['AddImage'] = 'להוסיף תמונה';
        $strings['NoImage'] = 'אין תמונה';
        $strings['Move'] = 'להזיז';
        $strings['AppearsOn'] = 'מופיע ב- %s';
        $strings['Location'] = 'מקום';
        $strings['NoLocationLabel'] = '(חקום לא נקבע)';
        $strings['Contact'] = 'איש קשר';
        $strings['NoContactLabel'] = '(אין איש קשר)';
        $strings['Description'] = 'תאור';
        $strings['NoDescriptionLabel'] = '(אין תאור)';
        $strings['Notes'] = 'הערות';
        $strings['NoNotesLabel'] = '(אין הערות)';
        $strings['NoTitleLabel'] = '(אין כותר)';
        $strings['UsageConfiguration'] = 'קונפיגורציית שימוש';
        $strings['ChangeConfiguration'] = 'לשנות קונפיגורציה';
        $strings['ResourceMinLength'] = 'הזמנה חייבת להיות לפחות %s';
        $strings['ResourceMinLengthNone'] = 'אין אורך מינימאלי להזמנות';
        $strings['ResourceMaxLength'] = 'הזמנה לא יכולה להיות יותר מ- %s';
        $strings['ResourceMaxLengthNone'] = 'אין אורך מקסימאלי להזמנות';
        $strings['ResourceRequiresApproval'] = 'הזמנות כפופות לאישור';
        $strings['ResourceRequiresApprovalNone'] = 'הזמנות לא כפופות לאישור';
        $strings['ResourcePermissionAutoGranted'] = 'אישור ניתן באופן אוטומטי';
        $strings['ResourcePermissionNotAutoGranted'] = 'אישור לא ניתן באופן אוטומטי';
        $strings['ResourceMinNotice'] = 'יש להזמין לפחות %s לפני הזמן המבוקש';
        $strings['ResourceMinNoticeNone'] = 'אפשר להזמין עד לזמן הנוכחי';
        $strings['ResourceMaxNotice'] = 'הזמנות חייבות להסתיים תוך %s מהזמן הנוכחי';
        $strings['ResourceMaxNoticeNone'] = 'הזמנות יכולות להסתיים בכל זמן שהו בעתיד';
        $strings['ResourceAllowMultiDay'] = 'הזמנות יכולות לגלוש על-פני מספר ימים';
        $strings['ResourceNotAllowMultiDay'] = 'הזמנות לא יכולות לגלוש על-פני מספר ימים';
        $strings['ResourceCapacity'] = 'לחדר זה יש מקום למקסימום %s אנשים';
        $strings['ResourceCapacityNone'] = 'לחדר זה אין הגבלה במספר אנשים';
        $strings['AddNewResource'] = 'להוסיף חדר חדש';
        $strings['AddNewUser'] = 'להוסיף משתמש חדש';
        $strings['AddUser'] = 'להוסיף משתמש';
        $strings['Schedule'] = 'לוח שבועי';
        $strings['AddResource'] = 'להוסיף חדר';
        $strings['Capacity'] = 'קיבולת';
        $strings['Access'] = 'גישה';
        $strings['Duration'] = 'משך';
        $strings['Active'] = 'פעיל';
        $strings['Inactive'] = 'לא פעיל';
        $strings['ResetPassword'] = 'איפוס סיסמה';
        $strings['LastLogin'] = 'התחברות אחרונה';
        $strings['Search'] = 'חיפוש';
        $strings['ResourcePermissions'] = 'הרשאות לחדר';
        $strings['Reservations'] = 'הזמנות';
        $strings['Groups'] = 'קבוצות';
        $strings['ResetPassword'] = 'איפוס סיסמה';
        $strings['AllUsers'] = 'כל משתמשים';
        $strings['AllGroups'] = 'כל קבוצות';
        $strings['AllSchedules'] = 'כל הלוחות';
        $strings['UsernameOrEmail'] = 'שם משתמש או דואר אלקטרוני';
        $strings['Members'] = 'חברים';
        $strings['QuickSlotCreation'] = 'ליצור יחידות זמן כל %s דקות בין %s ו- %s';
        $strings['ApplyUpdatesTo'] = 'ליישם עדכונים ל-';
        $strings['CancelParticipation'] = 'בטל השתתפות';
        $strings['Attending'] = 'משתתף';
        $strings['QuotaConfiguration'] = 'ב-%s ל-%s משתמשים ב-%s הם מוגבלים
ל-%s %s ל%s';
        $strings['reservations'] = 'הזמנות';
        $strings['ChangeCalendar'] = 'לשנות לוח שבועי';
        $strings['AddQuota'] = 'להוסיף מכסה';
        $strings['FindUser'] = 'לאתר משתמש';
        $strings['Created'] = 'נוצר';
        $strings['LastModified'] = 'עדכון אחרון ';
        $strings['GroupName'] = 'שם קבוצה';
        $strings['GroupMembers'] = 'חברי קבוצה';
        $strings['GroupRoles'] = 'תפקידי קבוצה';
        $strings['GroupAdmin'] = 'מנהל קבוצה';
        $strings['Actions'] = 'פעולות';
        $strings['CurrentPassword'] = 'סיסמה נוכחית';
        $strings['NewPassword'] = 'סיסמה חדשה';
        $strings['InvalidPassword'] = 'סיסמה נוכחית לא נכונה';
        $strings['PasswordChangedSuccessfully'] = 'סיסמה שלך שונתה בהצלחה';
        $strings['SignedInAs'] = 'מחובר כ: ';
        $strings['NotSignedIn'] = 'טרם מזוהה';
        $strings['ReservationTitle'] = 'כותר להזמנה';
        $strings['ReservationDescription'] = 'תאור הזמנה';
        $strings['ResourceList'] = 'חדרים זמינים';
        $strings['Accessories'] = 'אביזרים';
        $strings['Add'] = 'להוסיף';
        $strings['ParticipantList'] = 'משתתפים';
        $strings['InvitationList'] = 'מוזמנים';
        $strings['AccessoryName'] = 'שם אביזר';
        $strings['QuantityAvailable'] = 'כמות זמינה';
        $strings['Resources'] = 'חדרים';
        $strings['Participants'] = 'משתתפים';
        $strings['User'] = 'משתמש';
        $strings['Resource'] = 'חדר';
        $strings['Status'] = 'סטטוס';
        $strings['Approve'] = 'לאשר';
        $strings['Page'] = 'דף';
        $strings['Rows'] = 'שורות';
        $strings['Unlimited'] = 'ללא הגבלה';
        $strings['Email'] = 'דואר אלקטרוני';
        $strings['EmailAddress'] = 'כתובת דואר אלקטרוני';
        $strings['Phone'] = 'טלפון';
        $strings['Organization'] = 'ארגון';
        $strings['Position'] = 'תפקיד';
        $strings['Language'] = 'שפה';
        $strings['Permissions'] = 'הרשאות';
        $strings['Reset'] = 'איפוס';
        $strings['FindGroup'] = 'לאתר קבוצנ';
        $strings['Manage'] = 'ניהול';
        $strings['None'] = 'כלום';
        $strings['AddToOutlook'] = 'להוסיף ללוח-זמן';
        $strings['Done'] = 'בוצע';
        $strings['RememberMe'] = 'לזכור אותי';
        $strings['FirstTimeUser?'] = '?משתמש חדש';
        $strings['CreateAnAccount'] = 'ליצור חשבון';
        $strings['ViewSchedule'] = 'צפייה בלוח';
        $strings['ForgotMyPassword'] = 'שכחתי את הסיסמה שלי';
        $strings['YouWillBeEmailedANewPassword'] = 'תישלח אליך בדואר אלקטרוני
סיסמה חדשה, מחוללת באופן אוטומטי';
        $strings['Close'] = 'לסגור';
        $strings['ExportToCSV'] = 'ייצוא ל-CSV';
        $strings['OK'] = 'OK';
        $strings['Working'] = 'עובד...';
        $strings['Login'] = 'התחברות';
        $strings['AdditionalInformation'] = 'מידע נוסף';
        $strings['AllFieldsAreRequired'] = 'כל השדות חובות';
        $strings['Optional'] = 'לא חובה';
        $strings['YourProfileWasUpdated'] = 'הפרופיל שלך עודכן';
        $strings['YourSettingsWereUpdated'] = 'עודכנו כוונונים שלך';
        $strings['Register'] = 'הרשמה';
        $strings['SecurityCode'] = 'קוד בטחון';
        $strings['ReservationCreatedPreference'] = 'כאשר אני עושה הזמנה או שהזמנה נעשתה בשבילי';
        $strings['ReservationUpdatedPreference'] = 'כאשר אני מעדכן הזמנה או שהזמנה עודכנה בשבילי';
        $strings['ReservationDeletedPreference'] = 'כאשר אני מבטל הזמנה או שהזמנה בוטלה בשבילי';
        $strings['ReservationApprovalPreference'] = 'כאשר תאושר הזמנה שביקשתי';
        $strings['PreferenceSendEmail'] = 'שלח לי מייל';
        $strings['PreferenceNoEmail'] = 'אל תודיע לי';
        $strings['ReservationCreated'] = '!ההזמנה שלך נוצרה בהצלחה';
        $strings['ReservationUpdated'] = '!ההזמנה שלך עודכנה בהצלחה';
        $strings['ReservationRemoved'] = '!ההזמנה שלך בוטלה';
        $strings['YourReferenceNumber'] = ' %s מספר אשמכתא שלך הוא:';
        $strings['UpdatingReservation'] = 'מעדכן הזמנה';
        $strings['ChangeUser'] = 'שלשנות משתמש';
        $strings['MoreResources'] = 'חדרים נוספים';
        $strings['ReservationLength'] = 'אורך הזמנה';
        $strings['ParticipantList'] = 'רשימת משתתפים';
        $strings['AddParticipants'] = 'להוסיף משתתפים';
        $strings['InviteOthers'] = 'להזמין אחרים';
        $strings['AddResources'] = 'להוסיף חדרים';
        $strings['AddAccessories'] = 'להוסיף אביזרים';
        $strings['Accessory'] = 'אביזר';
        $strings['QuantityRequested'] = 'כמות מבוקשת';
        $strings['CreatingReservation'] = 'יוצר הזמנה';
        $strings['UpdatingReservation'] = 'מעדכן הזמנה';
        $strings['DeleteWarning'] = 'פעולה זו היא קבועה ובלתי-הפיך!';
        $strings['DeleteAccessoryWarning'] = 'מחיקת אביזר זה תסיר אותו מכל הזמנות.';
        $strings['AddAccessory'] = 'להוסיף אביזר';
        $strings['AddBlackout'] = 'להוסיף חסימה';
        $strings['AllResourcesOn'] = 'כל חדרים ב-';
        $strings['Reason'] = 'סיבה';
        $strings['BlackoutShowMe'] = 'הצג הזמנות קיימות';
        $strings['BlackoutDeleteConflicts'] = 'מחק הזמנות קיימות';
        $strings['Filter'] = 'סינון';
        $strings['Between'] = 'בין';
        $strings['CreatedBy'] = 'נוצר על-ידי:';
        $strings['BlackoutCreated'] = 'נוצרה חסימה!';
        $strings['BlackoutNotCreated'] = 'לא ניתן ליצור חסימה!';
        $strings['BlackoutConflicts'] = 'יש זמני חסימה סותרים';
        $strings['ReservationConflicts'] = 'יש הזמנות סותרות';
        $strings['UsersInGroup'] = 'משתמשים בקבוצה זו';
        $strings['Browse'] = 'דפדף';
        $strings['DeleteGroupWarning'] = 'מחיקת קבוצה זו תסיר כל הרשאות לחדרים המשוייכות לקבוצה. משתמשים בקבוצה עלולים לאבד גישה לחדרים.';
        $strings['WhatRolesApplyToThisGroup'] = 'איזה תפקידים יש לקובצה זו?';
        $strings['WhoCanManageThisGroup'] = 'מי יכול לנהל קבוצה זו?';
        $strings['WhoCanManageThisSchedule'] = 'מי יכול לנהל לוח זה?';
        $strings['AddGroup'] = 'להוסיף קבוצה';
        $strings['AllQuotas'] = 'כל מכסים';
        $strings['QuotaReminder'] = 'לזכור: אכיפת מכסים היא לפי אזור הזמן של לוח-הזמן.';
        $strings['AllReservations'] = 'כל הזמנות';
        $strings['PendingReservations'] = 'הזמנות בהמתנה';
        $strings['Approving'] = 'מאשר';
        $strings['MoveToSchedule'] = 'לעבור ללוח';
        $strings['DeleteResourceWarning'] = 'מחיקת חדר זה תמחוק כל מידע השייך לו, כולל';
        $strings['DeleteResourceWarningReservations'] = 'כל הזמנות בעבר ובעתיד הקשורות לחדר';
        $strings['DeleteResourceWarningPermissions'] = 'כל הרשאות';
        $strings['DeleteResourceWarningReassign'] = 'נא להעביר כל דבר שברצונך לשמור  לפני המשך פעולה זו';
        $strings['ScheduleLayout'] = 'Layout (all times %s)';
        $strings['ReservableTimeSlots'] = 'שעות זמינות';
        $strings['BlockedTimeSlots'] = 'זמנים חסומים';
        $strings['ThisIsTheDefaultSchedule'] = 'לוח זה הוא ברירת המחדל';
        $strings['DefaultScheduleCannotBeDeleted'] = 'לוח ברירת מחדל - לא ניתן למחוק';
        $strings['MakeDefault'] = 'לקבוע כברירת מחדל';
        $strings['BringDown'] = 'להוריד';
        $strings['ChangeLayout'] = 'לשנות מערכך';
        $strings['AddSchedule'] = 'להוסיף לוח';
        $strings['StartsOn'] = 'מתחיל ב-';
        $strings['NumberOfDaysVisible'] = 'מספר ימים נראים';
        $strings['UseSameLayoutAs'] = 'להשתמש באולו מערך כמו';
        $strings['Format'] = 'פורמט';
        $strings['OptionalLabel'] = 'תגית אופציונאלית';
        $strings['LayoutInstructions'] = 'יש לרשום פרק זמן אחד בכל שורה ולרשום זמנים לכל 24 שעות היממה, החל מחצות הלילה.';
        $strings['AddUser'] = 'להוסיף משתמש';
        $strings['UserPermissionInfo'] = 'גישה בפועל לחדר יכולה להיות תלויה בתפקיד משתמש, הרשאות קבוצה וא הרשאות חיצוניות';
        $strings['DeleteUserWarning'] = 'מחיקת משתחש זה תסיר כל הזמנות שלו - שוטפות, עתידיות, וארכיוניות.';
        $strings['AddAnnouncement'] = 'להוסיף הודעה';
        $strings['Announcement'] = 'הודעה';
        $strings['Priority'] = 'עדיפות';
        $strings['Reservable'] = 'זמין';
        $strings['Unreservable'] = 'הספריה סגורה';
        $strings['Reserved'] = 'תפוס';
        $strings['MyReservation'] = 'הזמנות שלי';
        $strings['Pending'] = 'בהמתנה';
        $strings['Past'] = 'זמן בעבר';
        $strings['Restricted'] = 'מוגבל';
        $strings['ViewAll'] = 'צפייה בכל';
        $strings['MoveResourcesAndReservations'] = 'להעביר חדרים והזמנות ל';
        $strings['TurnOffSubscription'] = 'בטל מינויים ללוחות זמנים';
        $strings['TurnOnSubscription'] = 'לאפשר מינויים ללוח זמן זה';
        $strings['SubscribeToCalendar'] = 'לרשום מינוי ללוח זה';
        $strings['SubscriptionsAreDisabled'] = 'מנהל המערכת נטרל מינויים ללוחות-זמנים';
        $strings['NoResourceAdministratorLabel'] = '(אין מנהל לחדר זה)';
        $strings['WhoCanManageThisResource'] = 'מי יכול לנהל חדר זה?';
        $strings['ResourceAdministrator'] = 'מנהל חדרים';
        $strings['Private'] = 'פרטי';
        $strings['Accept'] = 'לקבל';
        $strings['Decline'] = 'לוותר';
        $strings['ShowFullWeek'] = 'להציג שבוע שלם';
        $strings['CustomAttributes'] = 'מאפיינים מקומיים';
        $strings['AddAttribute'] = 'להוסיף מאפיין';
        $strings['EditAttribute'] = 'לעדכן מאפיין';
        $strings['DisplayLabel'] = 'להציג כיתוב';
        $strings['Type'] = 'סוג';
        $strings['Required'] = 'חובה';
        $strings['ValidationExpression'] = 'ביטוי אימות';
        $strings['PossibleValues'] = 'ערכים אפשריים';
        $strings['SingleLineTextbox'] = 'תיבת טקסט בעלת שורה אחת';
        $strings['MultiLineTextbox'] = 'תיבת טקסט בעלת מספר שורות';
        $strings['Checkbox'] = 'Checkbox';
        $strings['SelectList'] = 'רשימת אופציות';
        $strings['CommaSeparated'] = 'פסיק כסימן הפרדה';
        $strings['Category'] = 'סיווג';
        $strings['CategoryReservation'] = 'הזמנה';
        $strings['CategoryGroup'] = 'קבוצה';
        $strings['SortOrder'] = 'סדר מיון';
        $strings['Title'] = 'כותר';
        $strings['AdditionalAttributes'] = 'מאפיינים נוספים';
        $strings['True'] = 'נכון';
        $strings['False'] = 'לא נכון';
	$strings['ForgotPasswordEmailSent'] = 'נשלחה הודעה לכתובת מייל הרשומה, עם הוראות לאיפוס סיסמה שלך';
	$strings['ActivationEmailSent'] = ' בקרוב תקבל הודעה מייל להפעלה.';
	$strings['AccountActivationError'] = 'מצטער, לא יכלנו להפעיל את החשבון
שלך.';
	$strings['Attachments'] = 'צרופות';
	$strings['AttachFile'] = 'לצרף קובץ';
	$strings['Maximum'] = 'מקסימום';
	$strings['NoScheduleAdministratorLabel'] = 'אין מנהל ללוח';
	$strings['ScheduleAdministrator'] = 'מנהל הלוח';
	$strings['Total'] = 'סה"כ';
	$strings['QuantityReserved'] = 'כמות מוזמנת';
	$strings['AllAccessories'] = 'כל אביזרים';
	$strings['GetReport'] = 'הפק דוח';
	$strings['NoResultsFound'] = 'לא נמצאו תוצות מתאימות';
	$strings['SaveThisReport'] = 'לשמור דוח זה';
	$strings['ReportSaved'] = '!דוח שמור';
	$strings['EmailReport'] = 'לשלוח דוח במייל';
	$strings['ReportSent'] = '!דוח נשלח';
	$strings['RunReport'] = 'הפק דוח';
	$strings['NoSavedReports'] = 'אין לך דוחות שמורים.';
	$strings['CurrentWeek'] = 'שבוע נוכחי';
	$strings['CurrentMonth'] = 'חודש נוכחי';
	$strings['AllTime'] = 'כל זמנים';
	$strings['FilterBy'] = 'לסנן לפי';
	$strings['Select'] = 'בחר';
	$strings['List'] = 'רשימה';
	$strings['TotalTime'] = 'זמן מצטבר';
	$strings['Count'] = 'ספירה';
	$strings['Usage'] = 'Usage';
	$strings['AggregateBy'] = 'להסתכם לפי';
	$strings['Range'] = 'טווח';
	$strings['Choose'] = 'בחר';
	$strings['All'] = 'הכל';
	$strings['ViewAsChart'] = 'להציג כתרשים';
	$strings['ReservedResources'] = 'חדרים מוזמנים';
	$strings['ReservedAccessories'] = 'אביזרים מוזמנים';
	$strings['ResourceUsageTimeBooked'] = 'שימוש בחדר - לפי זמן מוזמן';
	$strings['ResourceUsageReservationCount'] = 'שימוש בחדר - לפי מספר הזמנות';
	$strings['Top20UsersTimeBooked'] = '20 משתמשים הכי פעילים - לפי זמן מוזמן';
	$strings['Top20UsersReservationCount'] = '20 משתמשים הכי פעילים - לפי מספר הזמנות';
        // End Strings

        // Errors
        $strings['LoginError'] = 'לא הצלחנו לוודא שם או סיסמה שלך';
        $strings['ReservationFailed'] = 'לא ניתן לבצע את ההזמנה שלך';
        $strings['MinNoticeError'] = 'הזמנה זו דורשת התראה מראש. המועד הכי קרוב שניתן להזמין הוא %s.';
        $strings['MaxNoticeError'] = 'לא ניתן להזמין בעתיד יותר מאוחר מ- %s.';
        $strings['MinDurationError'] = 'משך ההזמנה חייב להיות לפחות %s.';
        $strings['MaxDurationError'] = 'משך ההזמנה חייב להיות פחות מ- %s.';
        $strings['ConflictingAccessoryDates'] = 'אין מספיק מהאביזרים הבאים:';
        $strings['NoResourcePermission'] = 'אין לך הרשאות לגשת לאחד או יותר מהמשאבים המבוקשים';
        $strings['ConflictingReservationDates'] = 'כבר קיימת הזמנה לחדר זה באותו מועד:';
        $strings['StartDateBeforeEndDateRule'] = 'תאריך/שעת התחלה חייב להיות לפני תאריך/שעת סיום';
        $strings['StartIsInPast'] = 'תאריך/שעת התחלה לא יכול להיות בעבר';
        $strings['EmailDisabled'] = 'מנהל המערכת ביטל הודעות באמצעות דואר
אלקטרוני';
        $strings['ValidLayoutRequired'] = 'יש לשבץ כל 24 שעות היממא, החל ומסיים בחצות הלילה.';
        $strings['CustomAttributeErrors'] = 'יש בעיות עם המאפיינים הנוספים שהגדרת:';
        $strings['CustomAttributeRequired'] = '%s הוא שדה חובה';
        $strings['CustomAttributeInvalid'] = 'הערך שניתן עבור %s אינו תקין';
        $strings['AttachmentLoadingError'] = 'מצטער - הייתה תקלה בהאעלת הקובץ
המבוקש.';
        $strings['InvalidAttachmentExtension'] = 'ניתן להעלות קבצים מסוג: %s בלבד';
        // End Errors

        // Page Titles
        $strings['CreateReservation'] = 'ליצור הזמנה';
        $strings['EditReservation'] = 'לערוך הזמנה';
        $strings['LogIn'] = 'התחברות';
        $strings['ManageReservations'] = 'הזמנות';
        $strings['AwaitingActivation'] = 'ממתין להפעלה';
        $strings['PendingApproval'] = 'ממתינה לאישור';
        $strings['ManageSchedules'] = 'לוחות';
        $strings['ManageResources'] = 'חדרים';
        $strings['ManageAccessories'] = 'אביזרים';
        $strings['ManageUsers'] = 'משתמשים';
        $strings['ManageGroups'] = 'קבוצות';
        $strings['ManageQuotas'] = 'מכסים';
        $strings['ManageBlackouts'] = 'זמנים חסומים';
        $strings['MyDashboard'] = 'My Dashboard';
        $strings['ServerSettings'] = 'כוונון שרת';
        $strings['Dashboard'] = 'Dashboard';
        $strings['Help'] = 'עזרה';
        $strings['Administration'] = 'ניהול';
        $strings['About'] = 'על';
        $strings['Bookings'] = 'הזמנות';
        $strings['Schedule'] = 'לוח שבועי';
        $strings['Reservations'] = 'הזמנות';
        $strings['Account'] = 'חשבון';
        $strings['EditProfile'] = 'לערוך פריפיל שלי';
        $strings['FindAnOpening'] = 'לחפש זמן פנוי';
        $strings['OpenInvitations'] = 'הזמנות פתוחות';
        $strings['MyCalendar'] = 'הלוח שלי';
        $strings['ResourceCalendar'] = 'לוח חדרים';
        $strings['Reservation'] = 'הזמנה חדשה';
        $strings['Install'] = 'התקנה';
        $strings['ChangePassword'] = 'להחליף סיסמה';
        $strings['MyAccount'] = 'החשבון שלי';
        $strings['Profile'] = 'פרופיל';
        $strings['ApplicationManagement'] = 'ניהול יישום';
        $strings['ForgotPassword'] = 'שכחתי סיסמה';
        $strings['NotificationPreferences'] = 'עדיפויות יידוע';
        $strings['ManageAnnouncements'] = 'הודעות';
        $strings['Responsibilities'] = 'אחריויות';
        $strings['GroupReservations'] = 'הזמנות קבוצה';
        $strings['ResourceReservations'] = 'הזמנות חדר';
        $strings['Customization'] = 'התאמה מקומית';
        $strings['Attributes'] = 'מאפיינים';
	$strings['AccountActivation'] = 'הפעלת חשבון';
	$strings['ScheduleReservations'] = 'Schedule Reservations';
	$strings['Reports'] = 'דוחות';
	$strings['GenerateReport'] = 'ליצור דוח חדש';
	$strings['MySavedReports'] = 'דוחות שמורים שלי';
	$strings['CommonReports'] = 'דוחות שכיחים';
	$strings['ViewDay'] = 'הצג יום';
	$strings['Group'] = 'קבוצה';
        // End Page Titles

        // Day representations
        $strings['DaySundaySingle'] = 'יום א';
        $strings['DayMondaySingle'] = 'יום ב';
        $strings['DayTuesdaySingle'] = 'יום ג';
        $strings['DayWednesdaySingle'] = 'יום ד';
        $strings['DayThursdaySingle'] = 'יום ה';
        $strings['DayFridaySingle'] = 'יום ו';
        $strings['DaySaturdaySingle'] = 'שבת';

        $strings['DaySundayAbbr'] = 'יום א';
        $strings['DayMondayAbbr'] = 'יום ב';
        $strings['DayTuesdayAbbr'] = 'יום ג';
        $strings['DayWednesdayAbbr'] = 'יום ד';
        $strings['DayThursdayAbbr'] = 'יום ה';
        $strings['DayFridayAbbr'] = 'יום ו';
        $strings['DaySaturdayAbbr'] = 'שבת';
		// End Day representations

        // Email Subjects
        $strings['ReservationApprovedSubject'] = 'ההזמנה שלך אושרה';
        $strings['ReservationCreatedSubject'] = 'ההזמנה שלך נוצרה';
        $strings['ReservationUpdatedSubject'] = 'ההזמנה שלך עודכנרה';
        $strings['ReservationDeletedSubject'] = 'ההזמנה שלך בוטלה';
        $strings['ReservationCreatedAdminSubject'] = 'הודעה: נוצרה הזמנה';
        $strings['ReservationUpdatedAdminSubject'] = 'הודעה: עודכנה הזמנה';
        $strings['ReservationDeleteAdminSubject'] = 'הודעה: בוטלה הזמנה';
        $strings['ParticipantAddedSubject'] = 'הודעה על הוספת משתמש';
        $strings['ParticipantDeletedSubject'] = 'הזמנה הוסרה';
        $strings['InviteeAddedSubject'] = 'הזמנה';
        $strings['ResetPassword'] = 'בקשה לאיפוס סיסמה';
        $strings['ActivateYourAccount'] = 'נא להפעיל את חשבונך';
        $strings['ReportSubject'] = ' הדוח שביקשת (%s)';
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
        $days['full'] = array('יום א', 'יום ב', 'יום ג', 'יום ד', 'יום ה', 'יום ו', 'שבת');
        // The three letter abbreviation
        $days['abbr'] = array('א', 'ב', 'ג', 'ד', 'ה', 'ו', 'ש');
        // The two letter abbreviation
        $days['two'] = array('א', 'ב', 'ג', 'ד', 'ה', 'ו', 'ש');
        // The one letter abbreviation
        $days['letter'] = array('א', 'ב', 'ג', 'ד', 'ה', 'ו', 'ש');

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
        $months['full'] = array('ינואר', 'פברואר', 'מרץ', 'אפריל', 'מאי', 'יוני', 'יולי', 'אוגוסט', 'ספטמבר', 'אוקטובר', 'נובמבר', 'דצמבר');
        // The three letter month name
        $months['abbr'] = array('ינ.', 'פב.', 'מרץ', 'אפר.', 'מאי', 'יוני', 'יולי', 'אוג.', 'ספט.', 'אוקט.', 'נוב.', 'דצ.');

        $this->Months = $months;

        return $this->Months;
    }

    /**
     * @return array
     */
    protected function _LoadLetters()
    {
        $this->Letters = array('א', 'ב', 'ג', 'ד', 'ה', 'ו', 'ז', 'ח', 'ט', 'י', 'כ', 'ל', 'מ', 'נ', 'ס', 'ע', 'פ', 'ק', 'ר', 'ש', 'ת');

        return $this->Letters;
    }

    protected function _GetHtmlLangCode()
    {
        return 'he';
    }
}

?>