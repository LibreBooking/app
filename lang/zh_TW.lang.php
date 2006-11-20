<?php
/**
* Traditional Chinese (zh_TW) translation file.
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Jing-Jong Shyue <shyue@mail.shyue.idv.tw>
* @version 05-14-06
* @package Languages
*
* Copyright (C) 2003 - 2005 phpScheduleIt
* License: GPL, see LICENSE
*/
///////////////////////////////////////////////////////////
// INSTRUCTIONS
///////////////////////////////////////////////////////////
// This file contains all of the strings that are used throughout phpScheduleit.
// Please save the translated file as '2 letter language code'.lang.php.  For example, en.lang.php.
// 
// To make phpScheduleIt available in another language, simply translate each
//  of the following strings into the appropriate one for the language.  If there
//  is no direct translation, please provide the closest translation.  Please be sure
//  to make the proper additions the /config/langs.php file (instructions are in the file).
//  Also, please add a help translation for your language using en.help.php as a base.
//
// You will probably keep all sprintf (%s) tags in their current place.  These tags
//  are there as a substitution placeholder.  Please check the output after translating
//  to be sure that the sentences make sense.
//
// + Please use single quotes ' around all $strings.  If you need to use the ' character, please enter it as \'
// + Please use double quotes " around all $email.  If you need to use the " character, please enter it as \"
//
// + For all $dates please use the PHP strftime() syntax
//    http://us2.php.net/manual/en/function.strftime.php
//
// + Non-intuitive parts of this file will be explained with comments.  If you
//    have any questions, please email lqqkout13@users.sourceforge.net
//    or post questions in the Developers forum on SourceForge
//    http://sourceforge.net/forum/forum.php?forum_id=331297
///////////////////////////////////////////////////////////

////////////////////////////////
/* Do not modify this section */
////////////////////////////////
global $strings;			  //
global $email;				  //
global $dates;				  //
global $charset;			  //
global $letters;			  //
global $days_full;			  //
global $days_abbr;			  //
global $days_two;			  //
global $days_letter;		  //
global $months_full;		  //
global $months_abbr;		  //
global $days_letter;		  //
/******************************/

// Charset for this language
// 'iso-8859-1' will work for most languages
$charset = 'utf-8';

/***
  DAY NAMES
  All of these arrays MUST start with Sunday as the first element 
   and go through the seven day week, ending on Saturday
***/
// The full day name
$days_full = array('週日', '週一', '週二', '週三', '週四', '週五', '週六');
// The three letter abbreviation
$days_abbr = array('週日', '週一', '週二', '週三', '週四', '週五', '週六');
// The two letter abbreviation
$days_two  = array('日', '一', '二', '三', '四', '五', '六');
// The one letter abbreviation
$days_letter = array('S', 'M', 'T', 'W', 'T', 'F', 'S');

/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '�?月', '�??月', '�??一月', '�??二月');
// The three letter month name
$months_abbr = array('一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '�?月', '�??月', '�??一月', '�??二月');

// All letters of the alphabet starting with A and ending with Z
$letters = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

/***
  DATE FORMATTING
  All of the date formatting must use the PHP strftime() syntax
  You can include any text/HTML formatting in the translation
***/
// General date formatting used for all date display unless otherwise noted
$dates['general_date'] = '%m/%d/%Y';
// General datetime formatting used for all datetime display unless otherwise noted
// The hour:minute:second will always follow this format
$dates['general_datetime'] = '%m/%d/%Y @';
// Date in the reservation notification popup and email
$dates['res_check'] = '%A %m/%d/%Y';
// Date on the scheduler that appears above the resource links
$dates['schedule_daily'] = '%A,<br/>%m/%d/%Y';
// Date on top-right of each page
$dates['header'] = '%A, %B %d, %Y';
// Jump box format on bottom of the schedule page
// This must only include %m %d %Y in the proper order,
//  other specifiers will be ignored and will corrupt the jump box 
$dates['jumpbox'] = '%m %d %Y';

/***
  STRING TRANSLATIONS
  All of these strings should be translated from the English value (right side of the equals sign) to the new language.
  - Please keep the keys (between the [] brackets) as they are.  The keys will not always be the same as the value.
  - Please keep the sprintf formatting (%s) placeholders where they are unless you are sure it needs to be moved.
  - Please keep the HTML and punctuation as-is unless you know that you want to change it.
***/
$strings['hours'] = '�?時';
$strings['minutes'] = '分�?�';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = '月';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = '日';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = '年';
$strings['am'] = 'am';
$strings['pm'] = 'pm';

$strings['Administrator'] = '系統管�?�員';
$strings['Welcome Back'] = '歡迎回來, %s';
$strings['Log Out'] = '登出';
$strings['My Control Panel'] = '我的控制�?�';
$strings['Help'] = '說明';
$strings['Manage Schedules'] = '日程管�?�';
$strings['Manage Users'] ='使用者管�?�';
$strings['Manage Resources'] ='資�?管�?�';
$strings['Manage User Training'] ='使用者訓練管�?�';
$strings['Manage Reservations'] ='�?約管�?�';
$strings['Email Users'] ='電郵使用者';
$strings['Export Database Data'] = '匯出資料庫內容';
$strings['Reset Password'] = '�?設密碼';
$strings['System Administration'] = '系統管�?�';
$strings['Successful update'] = '更新�?功';
$strings['Update failed!'] = '更新失敗!';
$strings['Manage Blackout Times'] = '管�?�管制時間';
$strings['Forgot Password'] = '忘記密碼';
$strings['Manage My Email Contacts'] = '管�?�我的電郵連絡';
$strings['Choose Date'] = '�?�擇日期';
$strings['Modify My Profile'] = '變更個人資料';
$strings['Register'] = '註冊';
$strings['Processing Blackout'] = '管制處�?�中';
$strings['Processing Reservation'] = '�?約處�?�中';
$strings['Online Scheduler [Read-only Mode]'] = '線上日程管�?� [唯讀模�?]';
$strings['Online Scheduler'] = '線上日程管�?�';
$strings['phpScheduleIt Statistics'] = 'phpScheduleIt 統計資料';
$strings['User Info'] = '使用者資料:';

$strings['Could not determine tool'] = '無法決定工具. 請回到"我的控制�?�"並�?候�?試.';
$strings['This is only accessable to the administrator'] = '�?�有系統管�?�員�?�以使用這個功能';
$strings['Back to My Control Panel'] = '回到我的控制�?�';
$strings['That schedule is not available.'] = '�?�?許這個日程.';
$strings['You did not select any schedules to delete.'] = '您沒有�?�擇�?刪除的日程.';
$strings['You did not select any members to delete.'] = '您沒有�?�擇�?刪除的會員.';
$strings['You did not select any resources to delete.'] = '您沒有�?�擇�?刪除的資�?.';
$strings['Schedule title is required.'] = '日程標題是必需的.';
$strings['Invalid start/end times'] = '�?�?�法的開始或�?�?�時間';
$strings['View days is required'] = '檢視日期是必需的';
$strings['Day offset is required'] = '日期�?移是必需的';
$strings['Admin email is required'] = '管�?�電�?郵件是必需的';
$strings['Resource name is required.'] = '資�?�??稱是必需的.';
$strings['Valid schedule must be selected'] = '必須�?�擇有效的日程';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = '最�?�?約長度必須比最大�?約長度�?.';
$strings['Your request was processed successfully.'] = '您的�?求已經�?功的被處�?�了.';
$strings['Go back to system administration'] = '回到系統管�?�';
$strings['Or wait to be automatically redirected there.'] = '或�?候自動�?轉�?�到那裡.';
$strings['There were problems processing your request.'] = '處�?�您的�?求時發生了�?題.';
$strings['Please go back and correct any errors.'] = '請回去更正錯誤.';
$strings['Login to view details and place reservations'] = '登入以檢視詳細資料和�?約';
$strings['Memberid is not available.'] = '使用者�??稱: %s �?存在.';

$strings['Schedule Title'] = '日程標題';
$strings['Start Time'] = '開始時間';
$strings['End Time'] = '�?�?�時間';
$strings['Time Span'] = '時間跨度';
$strings['Weekday Start'] = '�?週起始日';
$strings['Admin Email'] = '管�?�者電郵';

$strings['Default'] = '�?設值';
$strings['Reset'] = '�?設';
$strings['Edit'] = '編輯';
$strings['Delete'] = '刪除';
$strings['Cancel'] = '�?�消';
$strings['View'] = '檢視';
$strings['Modify'] = '修改';
$strings['Save'] = '儲存';
$strings['Back'] = '上一個';
$strings['Next'] = '下一個';
$strings['Close Window'] = '關閉視窗';
$strings['Search'] = '�?�尋';
$strings['Clear'] = '清除';

$strings['Days to Show'] = '�?顯示的日期';
$strings['Reservation Offset'] = '�?約�?移';
$strings['Hidden'] = '隱�?';
$strings['Show Summary'] = '顯示摘�?';
$strings['Add Schedule'] = '增加日程';
$strings['Edit Schedule'] = '編輯日程';
$strings['No'] = '�?�';
$strings['Yes'] = '是';
$strings['Name'] = '使用者�??稱';
$strings['First Name'] = '�??';
$strings['Last Name'] = '姓';
$strings['Resource Name'] = '資�?�??稱';
$strings['Email'] = '電�?郵件';
$strings['Institution'] = '機構';
$strings['Phone'] = '電話';
$strings['Password'] = '密碼';
$strings['Permissions'] = '權�?';
$strings['View information about'] = '檢視關於 %s %s 的資訊';
$strings['Send email to'] = '�?電�?郵件給 %s %s';
$strings['Reset password for'] = '�?設 %s %s 的密碼';
$strings['Edit permissions for'] = '編輯 %s %s 的權�?';
$strings['Position'] = '�?�稱';
$strings['Password (6 char min)'] = '密碼 (至少 %s 個字元)';	// @since 1.1.0
$strings['Re-Enter Password'] = '�?次輸入密碼';

$strings['Sort by descending last name'] = '根據"姓"�?�減排�?';
$strings['Sort by descending email address'] = '根據"電�?郵件"�?�減排�?';
$strings['Sort by descending institution'] = '根據"機構"�?�減排�?';
$strings['Sort by ascending last name'] = '根據"姓"�?�增排�?';
$strings['Sort by ascending email address'] = '根據"電�?郵件"�?�增排�?';
$strings['Sort by ascending institution'] = '根據"機構"�?�增排�?';
$strings['Sort by descending resource name'] = '根據"資�?�??稱"�?�減排�?';
$strings['Sort by descending location'] = '根據"�?置"�?�減排�?';
$strings['Sort by descending schedule title'] = '根據"日程標題"�?�減排�?';
$strings['Sort by ascending resource name'] = '根據"資�?�??稱"�?�增排�?';
$strings['Sort by ascending location'] = '根據"�?置"�?�增排�?';
$strings['Sort by ascending schedule title'] = '根據"日程標題"�?�增排�?';
$strings['Sort by descending date'] = '根據"日期"�?�減排�?';
$strings['Sort by descending user name'] = '根據"使用者�??稱"�?�減排�?';
$strings['Sort by descending start time'] = '根據"開始時間"�?�減排�?';
$strings['Sort by descending end time'] = '根據"�?�?�時間"�?�減排�?';
$strings['Sort by ascending date'] = '根據"日期"�?�增排�?';
$strings['Sort by ascending user name'] = '根據"使用者�??稱"�?�增排�?';
$strings['Sort by ascending start time'] = '根據"開始時間"�?�增排�?';
$strings['Sort by ascending end time'] = '根據"�?�?�時間"�?�增排�?';
$strings['Sort by descending created time'] = '根據"建立時間"�?�減排�?';
$strings['Sort by ascending created time'] = '根據"建立時間"�?�增排�?';
$strings['Sort by descending last modified time'] = '根據"最後修改時間"�?�減排�?';
$strings['Sort by ascending last modified time'] = '根據"最後修改時間"�?�增排�?';

$strings['Search Users'] = '�?�尋使用者';
$strings['Location'] = '�?置';
$strings['Schedule'] = '日程';
$strings['Phone'] = '電話';
$strings['Notes'] = '備考';
$strings['Status'] = '狀態';
$strings['All Schedules'] = '全部日程';
$strings['All Resources'] = '全部資�?';
$strings['All Users'] = '全部使用者';

$strings['Edit data for'] = '編輯 %s 的資料';
$strings['Active'] = '使用中';
$strings['Inactive'] = '�?�用中';
$strings['Toggle this resource active/inactive'] = '切�?�這個資�?的使用狀態';
$strings['Minimum Reservation Time'] = '最�?�?約時間';
$strings['Maximum Reservation Time'] = '最大�?約時間';
$strings['Auto-assign permission'] = '自動給予權�?';
$strings['Add Resource'] = '增加資�?';
$strings['Edit Resource'] = '編輯資�?';
$strings['Allowed'] = '�?許';
$strings['Notify user'] = '通知使用著';
$strings['User Reservations'] = '使用者�?約';
$strings['Date'] = '日期';
$strings['User'] = '使用者';
$strings['Email Users'] = '電郵使用著';
$strings['Subject'] = '標題';
$strings['Message'] = '訊�?�';
$strings['Please select users'] = '請�?�擇使用者';
$strings['Send Email'] = '寄�?郵件';
$strings['problem sending email'] = '抱歉, 寄�?郵件時發生了�?題, 請�?候�?試.';
$strings['The email sent successfully.'] = '郵件以�?功�?出.';
$strings['do not refresh page'] = '請 <u>�?�?</u> �?新載入本�?. 這麼�?�將會�?一次的�?出郵件.';
$strings['Return to email management'] = '回到電郵管�?�';
$strings['Please select which tables and fields to export'] = '請�?�擇�?匯出的表格與欄�?:';
$strings['all fields'] = '- 全部欄�? -';
$strings['HTML'] = '網�?';
$strings['Plain text'] = '純文字';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = '匯出資料';
$strings['Reset Password for'] = '�?設 %s 的密碼';
$strings['Please edit your profile'] = '請編輯您的個人資料';
$strings['Please register'] = '請註冊';
$strings['Keep me logged in'] = '�?�?我的登入狀態 <br/>(需�? cookies)';
$strings['Edit Profile'] = '編輯個人資料';
$strings['Register'] = '註冊';
$strings['Please Log In'] = '請登入';
$strings['Email address'] = '電�?郵件�?�?�';
$strings['Password'] = '密碼';
$strings['First time user'] = '第一次使用?';
$strings['Click here to register'] = '按這裡註冊';
$strings['Register for phpScheduleIt'] = '註冊 phpScheduleIt';
$strings['Log In'] = '登入';
$strings['View Schedule'] = '檢視日程';
$strings['View a read-only version of the schedule'] = '檢視唯讀得日程表';
$strings['I Forgot My Password'] = '我忘記我的密碼了';
$strings['Retreive lost password'] = '找回密碼';
$strings['Get online help'] = '�?�得線上說明';
$strings['Language'] = '語言';
$strings['(Default)'] = '(�?設)';

$strings['My Announcements'] = '我的公告';
$strings['My Reservations'] = '我的�?約';
$strings['My Permissions'] = '我的權�?';
$strings['My Quick Links'] = '我的快速連�?';
$strings['Announcements as of'] = '%s 的公告';
$strings['There are no announcements.'] = '沒有公告事項.';
$strings['Resource'] = '資�?';
$strings['Created'] = '建立時間';
$strings['Last Modified'] = '最後修改時間';
$strings['View this reservation'] = '檢視這個�?約';
$strings['Modify this reservation'] = '修改這個�?約';
$strings['Delete this reservation'] = '刪除這個�?約';
$strings['Bookings'] = '�?約';											// @since 1.2.0
$strings['Change My Profile Information/Password'] = '變更個人資料';		// @since 1.2.0
$strings['Manage My Email Preferences'] = '電�?郵件�??好';				// @since 1.2.0
$strings['Mass Email Users'] = '大�?電郵使用者';
$strings['Search Scheduled Resource Usage'] = '�?�尋�?約';		// @since 1.2.0
$strings['Export Database Content'] = '匯出資料庫內容';
$strings['View System Stats'] = '檢視系統狀�?';
$strings['Email Administrator'] = '電郵管�?�員';

$strings['Email me when'] = '通知我:';
$strings['I place a reservation'] = '建立�?約';
$strings['My reservation is modified'] = '�?約已被修改';
$strings['My reservation is deleted'] = '�?約已被刪除';
$strings['I prefer'] = '我�??好:';
$strings['Your email preferences were successfully saved'] = '您的電郵�??好設定已被儲存!';
$strings['Return to My Control Panel'] = '回到我的控制�?�';

$strings['Please select the starting and ending times'] = '請�?�擇開始與�?�?�時間:';
$strings['Please change the starting and ending times'] = '請變更開始與�?�?�時間:';
$strings['Reserved time'] = '�?約的時間:';
$strings['Minimum Reservation Length'] = '最�?�?約長度:';
$strings['Maximum Reservation Length'] = '最大�?約長度:';
$strings['Reserved for'] = '�?約給:';
$strings['Will be reserved for'] = '將被�?約給:';
$strings['N/A'] = '無';
$strings['Update all recurring records in group'] = '是�?�更新群組中全部的循環記錄?';
$strings['Delete?'] = '是�?�刪除?';
$strings['Never'] = '-- 無 --';
$strings['Days'] = '日';
$strings['Weeks'] = '週';
$strings['Months (date)'] = '月 (日期)';
$strings['Months (day)'] = '月 (�?天)';
$strings['First Days'] = '第一個';
$strings['Second Days'] = '第二個';
$strings['Third Days'] = '第三個';
$strings['Fourth Days'] = '第四個';
$strings['Last Days'] = '最後一個';
$strings['Repeat every'] = '�?複頻率:';
$strings['Repeat on'] = '�?複在:';
$strings['Repeat until date'] = '�?複直到:';
$strings['Choose Date'] = '�?�擇日期';
$strings['Summary'] = '摘�?';

$strings['View schedule'] = '檢視日程:';
$strings['My Reservations'] = '我的�?約';
$strings['My Past Reservations'] = '我之�?的�?約';
$strings['Other Reservations'] = '其他�?約';
$strings['Other Past Reservations'] = '其他�?�去的�?約';
$strings['Blacked Out Time'] = '管制的時間';
$strings['Set blackout times'] = '設定 %s 的管制於 %s'; 
$strings['Reserve on'] = '�?約了 %s 於 %s';
$strings['Prev Week'] = '&laquo; 上週';
$strings['Jump 1 week back'] = '跳到一週�?';
$strings['Prev days'] = '&#8249; 之�? %d 天';
$strings['Previous days'] = '&#8249; 之�? %d 天';
$strings['This Week'] = '本週';
$strings['Jump to this week'] = '跳到本週';
$strings['Next days'] = '之後 %d 天 &#8250;';
$strings['Next Week'] = '下週 &raquo;';
$strings['Jump To Date'] = '跳到日期';
$strings['View Monthly Calendar'] = '檢視月曆';
$strings['Open up a navigational calendar'] = '開啟一個�?�以�?覽的月曆';

$strings['View stats for schedule'] = '檢視�?約的狀態:';
$strings['At A Glance'] = '一覽表';
$strings['Total Users'] = '全部使用者數:';
$strings['Total Resources'] = '全部資�?數:';
$strings['Total Reservations'] = '全部�?約數:';
$strings['Max Reservation'] = '最大�?約時間:';
$strings['Min Reservation'] = '最�?�?約時間:';
$strings['Avg Reservation'] = '平�?��?約時間:';
$strings['Most Active Resource'] = '用�?最高的資�?:';
$strings['Most Active User'] = '用�?最多的使用者:';
$strings['System Stats'] = '系統狀態';
$strings['phpScheduleIt version'] = 'phpScheduleIt 版本:';
$strings['Database backend'] = '後端資料庫:';
$strings['Database name'] = '資料庫�??稱:';
$strings['PHP version'] = 'PHP 版本:';
$strings['Server OS'] = '伺�?器作業系統:';
$strings['Server name'] = '伺�?器�??稱:';
$strings['phpScheduleIt root directory'] = 'phpScheduleIt 根目錄:';
$strings['Using permissions'] = '使用權�?:';
$strings['Using logging'] = '使用記錄:';
$strings['Log file'] = '記錄檔:';
$strings['Admin email address'] = '管�?�者電�?郵件:';
$strings['Tech email address'] = '工程支�?�電�?郵件:';
$strings['CC email addresses'] = '電�?郵件副本:';
$strings['Reservation start time'] = '�?約起始時間:';
$strings['Reservation end time'] = '�?約�?�?�時間:';
$strings['Days shown at a time'] = '�?�時顯示日數:';
$strings['Reservations'] = '�?約';
$strings['Return to top'] = '回到頂端';
$strings['for'] = '-';

$strings['Select Search Criteria'] = '�?�擇�?�尋�?件';
$strings['Schedules'] = '日程:';
$strings['All Schedules'] = '全部日程';
$strings['Hold CTRL to select multiple'] = '按下 CTRL 以多�?�?�擇';
$strings['Users'] = '使用者:';
$strings['All Users'] = '全部使用者';
$strings['Resources'] = '資�?';
$strings['All Resources'] = '全部資�?';
$strings['Starting Date'] = '開始日期:';
$strings['Ending Date'] = '�?�?�日期:';
$strings['Starting Time'] = '開始時間:';
$strings['Ending Time'] = '�?�?�時間:';
$strings['Output Type'] = '輸出類型:';
$strings['Manage'] = '管�?�';
$strings['Total Time'] = '全部時間';
$strings['Total hours'] = '全部時數:';
$strings['% of total resource time'] = '% 全部資�?時間';
$strings['View these results as'] = '檢視這些�?果為:';
$strings['Edit this reservation'] = '編輯這個�?約';
$strings['Search Results'] = '�?�尋�?果';
$strings['Search Resource Usage'] = '�?�尋資�?使用�?';
$strings['Search Results found'] = '�?�尋�?果: 找到 %d 個�?約';
$strings['Try a different search'] = '嘗試�?�?��?�尋�?件';
$strings['Search Run On'] = '�?�尋執行於:';
$strings['Member ID'] = '會員編號';
$strings['Previous User'] = '&laquo; �?一個使用者';
$strings['Next User'] = '下一個使用者 &raquo;';

$strings['No results'] = '沒有�?果';
$strings['That record could not be found.'] = '找�?到這個記錄.';
$strings['This blackout is not recurring.'] = '這個管制沒有循環記錄.';
$strings['This reservation is not recurring.'] = '這個�?約沒有循環記錄.';
$strings['There are no records in the table.'] = '在 %s 表中沒有記錄.';
$strings['You do not have any reservations scheduled.'] = '您沒有任何�?約的日程.';
$strings['You do not have permission to use any resources.'] = '您沒有權�?使用任何資�?.';
$strings['No resources in the database.'] = '資料庫中沒有資�?.';
$strings['There was an error executing your query'] = '您的查詢有錯誤:';

$strings['That cookie seems to be invalid'] = '這個 cookie 似乎�?�?�法';
$strings['We could not find that logon in our database.'] = '我們在資料庫中找�?到這個登入�??稱.';	// @since 1.1.0
$strings['That password did not match the one in our database.'] = '密碼與我們資料庫的記錄�?符.';
$strings['You can try'] = '<br />您�?�以嘗試:<br />註冊一個電�?郵件.<br />或者:<br />嘗試�?一次登入.';
$strings['A new user has been added'] = '增加了一個新使用者';
$strings['You have successfully registered'] = '您已經�?功註冊了!';
$strings['Continue'] = '繼續...';
$strings['Your profile has been successfully updated!'] = '您個個人資料已�?功更新!';
$strings['Please return to My Control Panel'] = '請回到"我的控制�?�"';
$strings['Valid email address is required.'] = '- 您需�?一個�?�法的電�?郵件.';
$strings['First name is required.'] = '- "�??"是必�?的.';
$strings['Last name is required.'] = '- "姓"是必�?的.';
$strings['Phone number is required.'] = '- "電話"是必�?的.';
$strings['That email is taken already.'] = '- 這個電�?郵件已經被使用了.<br />請�?�一個電�?郵件後�?試.';
$strings['Min 6 character password is required.'] = '- 至少 %s 個字元的密碼是必需的.';
$strings['Passwords do not match.'] = '- 密碼�?符.';

$strings['Per page'] = '�?�?:';
$strings['Page'] = '�?碼:';

$strings['Your reservation was successfully created'] = '您已經�?功建立了下列�?約';
$strings['Your reservation was successfully modified'] = '您已經�?功修改了下列�?約';
$strings['Your reservation was successfully deleted'] = '您已經�?功刪除了下列�?約';
$strings['Your blackout was successfully created'] = '您已經�?功建立了下列管制';
$strings['Your blackout was successfully modified'] = '您已經�?功修改了下列管制';
$strings['Your blackout was successfully deleted'] = '您已經�?功刪除了下列管制';
$strings['for the follwing dates'] = ':';
$strings['Start time must be less than end time'] = '開始時間必須比�?�?�時間早.';
$strings['Current start time is'] = '目�?開始時間為:';
$strings['Current end time is'] = '目�?�?�?�時間為:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = '�?約長度�?在資�?的�?制長度內.';
$strings['Your reservation is'] = '您的�?約為:';
$strings['Minimum reservation length'] = '最�?�?約長度:';
$strings['Maximum reservation length'] = '最大�?約長度:';
$strings['You do not have permission to use this resource.'] = '您沒有使用這個資�?的許�?�.';
$strings['reserved or unavailable'] = '%s 到 %s 已經被�?約或�?�?�使用.';	// @since 1.1.0
$strings['Reservation created for'] = '�?約已建立給 %s';
$strings['Reservation modified for'] = '�?約已修改給 %s';
$strings['Reservation deleted for'] = '�?約已刪除給 %s';
$strings['created'] = '建立時間';
$strings['modified'] = '修改時間';
$strings['deleted'] = '已刪除';
$strings['Reservation #'] = '�?約編號';
$strings['Contact'] = '連絡';
$strings['Reservation created'] = '�?約已建立';
$strings['Reservation modified'] = '�?約已修改';
$strings['Reservation deleted'] = '�?約已刪除';

$strings['Reservations by month'] = '�?月的�?約數';
$strings['Reservations by day of the week'] = '�?週日�?的�?約數';
$strings['Reservations per month'] = '�?個月的�?約數';
$strings['Reservations per user'] = '�?照使用者的�?約數';
$strings['Reservations per resource'] = '�?照儀器的�?約數';
$strings['Reservations per start time'] = '�?照開始時間的�?約數';
$strings['Reservations per end time'] = '�?照�?�?�時間的�?約數';
$strings['[All Reservations]'] = '[全部�?約]';

$strings['Permissions Updated'] = '權�?已更新';
$strings['Your permissions have been updated'] = '您的 %s 權�?已被更新';
$strings['You now do not have permission to use any resources.'] = '您沒有任何資�?的使用權�?.';
$strings['You now have permission to use the following resources'] = '您有使用下列資�?的權�?:';
$strings['Please contact with any questions.'] = '如果有�?題, 請連絡 %s.';
$strings['Password Reset'] = '�?設密碼';

$strings['This will change your password to a new, randomly generated one.'] = '這個功能將會變更您的密碼為一個隨機的密碼.';
$strings['your new password will be set'] = '在輸入您的電�?郵件並按下"變更密碼"後, 您的密碼將被�?設並電郵給您.';
$strings['Change Password'] = '變更密碼';
$strings['Sorry, we could not find that user in the database.'] = '抱歉, 我們在資料庫中找�?到這個使用者.';
$strings['Your New Password'] = '您的新 %s 密碼';
$strings['Your new passsword has been emailed to you.'] = '�?功!<br />'
    			. '您的新密碼已經寄出.<br />'
    			. '請到您的信箱中�?�得新密碼, 然後使用這個新密碼 <a href="index.php">登入</a>'
    			. ' 並主動到 &quot;我的控制�?�&quot; 中按下 &quot;變更我的個人資料/密碼&quot;'
    			. ' 以變更密碼.';

$strings['You are not logged in!'] = '您尚未登入!';

$strings['Setup'] = '設定';
$strings['Please log into your database'] = '請登入您的資料庫';
$strings['Enter database root username'] = '輸入資料庫管�?�員�??稱:';
$strings['Enter database root password'] = '輸入資料庫管�?�員密碼:';
$strings['Login to database'] = '登入資料庫';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = '您 <b>�?</b> 需�?管�?�員帳號. 任何�?�以建立資料表的資料庫使用者都是�?�接�?�的.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = '這將會設定所有 phpScheduleIt 所需�?的資料庫與資料表.';
$strings['It also populates any required tables.'] = '�?�時也會在資料表中填入必需的資料.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = '警告: 這將會刪除所有 phpScheduleIt 的資料庫!';
$strings['Not a valid database type in the config.php file.'] = 'config.php 之中沒有�?�法的資料庫�??稱.';
$strings['Database user password is not set in the config.php file.'] = '資料庫使用者�??稱與密碼未設定於 config.php 之中.';
$strings['Database name not set in the config.php file.'] = '資料庫�??稱未設定於 config.php 之中.';
$strings['Successfully connected as'] = '�?功的連�?為';
$strings['Create tables'] = '建立資料表 &gt;';
$strings['There were errors during the install.'] = '安�?�?�程中發生錯誤. 如果是次�?的錯誤, phpScheduleIt �?�能還是�?�以正常�?�作.<br/><br/>'
	. '請到<a href="http://sourceforge.net/forum/?group_id=95547">SourceForge</a> 的討論�?�張貼您的�?題.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = '您已經�?功的完�?了 phpScheduleIt 的設定. 您�?�以開始使用了.';
$strings['Thank you for using phpScheduleIt'] = '請確定您完全刪除 \'install\' 目錄.'
	. ' 因為這個目錄包�?�了資料庫密碼與其他�?�?資料, 所以這個動作�?�常�?�?.'
	. ' 如果您沒有刪除, 您等於開了大門讓其他人侵入您的資料庫!'
	. '<br /><br />'
	. '�?�?您使用 phpScheduleIt!';
$strings['There is no way to undo this action'] = '這個動作將無法復原!';
$strings['Click to proceed'] = '按下這裡繼續';
$strings['Please delete this file.'] = '請刪除這個檔案.';
$strings['Successful update'] = '更新�?功';
$strings['Patch completed successfully'] = '修補已�?功';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = '如果沒有指定數值, 設定檔中的�?設密碼將被使用.';
$strings['Notify user that password has been changed?'] = '是�?�通知使用者密碼變更?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = '您必須有電�?郵件�?能使用這個系統.';
$strings['Invalid User Name/Password.'] = '錯誤的使用者�??稱/密碼.';
$strings['Pending User Reservations'] = '等待�?��?的使用者�?約';
$strings['Approve'] = '�?��?';
$strings['Approve this reservation'] = '�?��?這個�?約';
$strings['Approve Reservations'] ='�?��?�?約';

$strings['Announcement'] = '公告';
$strings['Number'] = '編號';
$strings['Add Announcement'] = '新增公告';
$strings['Edit Announcement'] = '編輯公告';
$strings['All Announcements'] = '所有公告';
$strings['Delete Announcements'] = '刪除公告';
$strings['Use start date/time?'] = '使用開始日期/時間';
$strings['Use end date/time?'] = '使用�?�?�日期/時間';
$strings['Announcement text is required.'] = '公告內容是必需的.';
$strings['Announcement number is required.'] = '公告編號是必需的.';

$strings['Pending Approval'] = '等待�?��?';
$strings['My reservation is approved'] = '我的�?約已被�?��?';
$strings['This reservation must be approved by the administrator.'] = '這個�?約需�?管�?�員的�?��?.';
$strings['Approval Required'] = '需�?�?��?';
$strings['No reservations requiring approval'] = '沒有需�?�?��?的�?約';
$strings['Your reservation was successfully approved'] = '您的�?約已被�?��?';
$strings['Reservation approved for'] = '%s 的�?約�?��?';
$strings['approved'] = '已�?��?';
$strings['Reservation approved'] = '�?約已被�?��?';

$strings['Valid username is required'] = '需�?�?�法的使用者�??稱';
$strings['That logon name is taken already.'] = '這的登入�??稱已被使用.';
$strings['this will be your login'] = '(這將�?為您的登入�??稱)';
$strings['Logon name'] = '登入�??稱';
$strings['Your logon name is'] = '您的登入�??稱為 %s';

$strings['Start'] = '開始';
$strings['End'] = '�?�?�';
$strings['Start date must be less than or equal to end date'] = '開始時間必須比�?�?�時間早';
$strings['That starting date has already passed'] = '這個開始時間已經�?�去了';
$strings['Basic'] = '基本';
$strings['Participants'] = '�?�與人員';
$strings['Close'] = '關閉';
$strings['Start Date'] = '開始時間';
$strings['End Date'] = '�?�?�時間';
$strings['Minimum'] = '最�?';
$strings['Maximum'] = '最大';
$strings['Allow Multiple Day Reservations'] = '�?許多天的�?約';
$strings['Invited Users'] = '邀請的使用者';
$strings['Invite Users'] = '邀請使用者';
$strings['Remove Participants'] = '移除�?�與人員';
$strings['Reservation Invitation'] = '�?約邀請';
$strings['Manage Invites'] = '管�?�邀請';
$strings['No invite was selected'] = '沒有�?�擇邀請';
$strings['reservation accepted'] = '%s 接�?�了您的邀請在 %s ';
$strings['reservation declined'] = '%s 拒絕了您的邀請在 %s ';
$strings['Login to manage all of your invitiations'] = '登入已管�?�您的邀請';
$strings['Reservation Participation Change'] = '�?�與邀請變更';
$strings['My Invitations'] = '我的邀請';
$strings['Accept'] = '接�?�';
$strings['Decline'] = '拒絕';
$strings['Accept or decline this reservation'] = '接�?�或拒絕邀請';
$strings['My Reservation Participation'] = '我的�?�與邀請';
$strings['End Participation'] = '�?�?��?�與';
$strings['Owner'] = '�?有人';
$strings['Particpating Users'] = '�?�與的使用者';
$strings['No advanced options available'] = '沒有進階的功能';
$strings['Confirm reservation participation'] = '確�?�?約邀請';
$strings['Confirm'] = '確�?';
$strings['Do for all reservations in the group?'] = '是�?��?這個群組中的全部�?約?';

$strings['My Calendar'] = '我的日曆';
$strings['View My Calendar'] = '檢視我的日曆';
$strings['Participant'] = '�?�與人員';
$strings['Recurring'] = '循環';
$strings['Multiple Day'] = '多天';
$strings['[today]'] = '[今天]';
$strings['Day View'] = '日報表';
$strings['Week View'] = '週報表';
$strings['Month View'] = '月報表';
$strings['Resource Calendar'] = '資�?日曆';
$strings['View Resource Calendar'] = '日程日曆';	// @since 1.2.0
$strings['Signup View'] = '登記報表';

$strings['Select User'] = '�?�擇使用者';
$strings['Change'] = '變更';

$strings['Update'] = '更新';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'phpScheduleIt 更新�?��??供給 1.0.0 之後的版本';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt 已經是最新的';
$strings['Migrating reservations'] = '�?�併�?約';

$strings['Admin'] = '管�?�';
$strings['Manage Announcements'] = '管�?�公告';
$strings['There are no announcements'] = '沒有公告';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = '最多�?��?�與人數';
$strings['Leave blank for unlimited'] = '留空表示�?設�?';
$strings['Maximum of participants'] = '這個資�?的最大�?��?�與人數為 %s 人';
$strings['That reservation is at full capacity.'] = '這個�?約已經�?滿了.';
$strings['Allow registered users to join?'] = '是�?��?許註冊的使用者�?�加?';
$strings['Allow non-registered users to join?'] = '是�?��?許未註冊的使用者�?�加?';
$strings['Join'] = '�?�加';
$strings['My Participation Options'] = '我的�?�與�?�項';
$strings['Join Reservation'] = '�?�加�?約';
$strings['Join All Recurring'] = '�?�加所有循環的�?約';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = '因為已經�?滿, 您無法�?�加下列日期的�?約.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = '您已經被邀請�?�加這個�?約. 請跟隨給您的電�?郵件的指示�?�加這個�?約.';
$strings['Additional Tools'] = '�?外的工具';
$strings['Create User'] = '建立使用者';
$strings['Check Availability'] = '檢查是�?��?�用';
$strings['Manage Additional Resources'] = '管�?��?外的資�?';
$strings['All Additional Resources'] = '所有�?外的資�?';
$strings['Number Available'] = '�?�用的數�?';
$strings['Unlimited'] = '無�?制';
$strings['Add Additional Resource'] = '增加�?外的資�?';
$strings['Edit Additional Resource'] = '編輯�?外的資�?';
$strings['Checking'] = '檢查中';
$strings['You did not select anything to delete.'] = '您沒有�?�擇�?刪除的�?�西.';
$strings['Added Resources'] = '增加的資�?';
$strings['Additional resource is reserved'] = '�?外的資�? %s �?次�?�有 %s 個�?�用';
$strings['All Groups'] = '全部群組';
$strings['Group Name'] = '群組�??稱';
$strings['Delete Groups'] = '刪除群組';
$strings['Manage Groups'] = '管�?�群組';
$strings['None'] = '無';
$strings['Group name is required.'] = '群組�??稱是必需的.';
$strings['Groups'] = '群組';
$strings['Current Groups'] = '目�?群組';
$strings['Group Administration'] = '群組管�?�';
$strings['Reminder Subject'] = '�?約�??醒- %s, %s %s';
$strings['Reminder'] = '�??醒';
$strings['before reservation'] = '�?約�?';
$strings['My Participation'] = '我的�?�與';
$strings['My Past Participation'] = '我�?�去的�?�與';
$strings['Timezone'] = '時�?�';
$strings['Export'] = '匯出';
$strings['Select reservations to export'] = '�?�擇�?匯出的�?約';
$strings['Export Format'] = '匯出格�?';
$strings['This resource cannot be reserved less than x hours in advance'] = '這個資�?�?能在少於 %s �?時�?�?約';
$strings['This resource cannot be reserved more than x hours in advance'] = '這個資�?�?能在多於 %s �?時�?�?約';
$strings['Minimum Booking Notice'] = '最�?�?約通知';
$strings['Maximum Booking Notice'] = '最大�?約通知';
$strings['hours prior to the start time'] = '開始�?...�?時';
$strings['hours from the current time'] = '從�?�在起...�?時';
$strings['Contains'] = '包�?�';
$strings['Begins with'] = '開始為';
$strings['Minimum booking notice is required.'] = '最�?�?約通知是必需的.';
$strings['Maximum booking notice is required.'] = '最大�?約通知是必需的.';
$strings['Manage Additional Resources'] = '管�?�附件';
$strings['Add Additional Resource'] = '增加附件';
$strings['Edit Additional Resource'] = '編輯附件';
$strings['Accessory Name'] = '附件�??稱';
$strings['Accessories'] = '附件';
$strings['All Accessories'] = '全部附件';
$strings['Added Accessories'] = '增加的附件';
// end since 1.2.0

/***
  EMAIL MESSAGES
  Please translate these email messages into your language.  You should keep the sprintf (%s) placeholders
   in their current position unless you know you need to move them.
  All email messages should be surrounded by double quotes "
  Each email message will be described below.
***/
// @since 1.1.0
// Email message that a user gets after they register
$email['register'] = "%s, %s \r\n"
				. "您�?功的註冊了下列資料:\r\n"
				. "登入: %s\r\n"
				. "姓�??: %s %s \r\n"
				. "電話: %s \r\n"
				. "機構: %s \r\n"
				. "�?�稱: %s \r\n\r\n"
				. "慶從下�?�的�?�?�登入系統:\r\n"
				. "%s \r\n\r\n"
				. "您�?�以在\"我的控制�?�\"中找到編輯您個人資料的連�?.\r\n\r\n"
				. "如果您有關於資�?或�?約的�?題, 請連絡 %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "管裡員,\r\n\r\n"
					. "新使用者用下列的資料註冊了新帳號:\r\n"
					. "電�?郵件: %s \r\n"
					. "姓�??: %s %s \r\n"
					. "電話: %s \r\n"
					. "機構: %s \r\n"
					. "�?�稱: %s \r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "您已經�?功的 %s 了�?約, 編號 #%s.\r\n\r\n<br/><br/>"
			. "當連絡管裡員時, 請使用這個�?約編號.\r\n\r\n<br/><br/>"
			. "在 %s %s 到 %s %s 之間的 %s �?約,"
			. " �?置在 %s 已經被 %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "這個�?約將在�?複:\r\n<br/>";
$email['reservation_activity_3'] = "在這個群組中, 所有的循環�?約也將 %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "下�?�是這個�?約的摘�?:\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "如果有錯誤, 請使用 %s 連絡管�?�員,"
			. " 或致電 %s.\r\n\r\n<br/><br/>"
			. "您�?�以在任何時候登入 %s (<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n) 以修改這個�?約."
			. "<br/><br/>";
$email['reservation_activity_6'] = "如果需�?本系統的技術支�?�, 請連絡 <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
			. "�?約編號 #%s 已經被接�?�了.\r\n\r\n<br/><br/>"
			. "當連絡管裡員時, 請使用這個�?約編號.\r\n\r\n<br/><br/>"
			. "在 %s %s 到 %s %s 之間的 %s �?約,"
			. " �?置在 %s 已經被 %s.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "您的 %s 密碼已經被管�?�員�?設.\r\n\r\n"
			. "您的臨時密碼為:\r\n\r\n %s\r\n\r\n"
			. "請用這個臨時密碼(您�?�以使用複製與貼上來確�?正確性)登入到 %s (%s),"
			. " 並且立刻到 '變更我的個人資料與密碼' 設定新的密碼.\r\n\r\n"
			. "如果有任何�?題, 請連絡 %s.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n"
            . "您 %s 帳號的新密碼為:\r\n\r\n"
            . "%s\r\n\r\n"
            . "請使用這個密碼在 %s 登入"
            . "(您�?�以使用複製與貼上來確�?正確性), "
			. " 並且立刻到 '變更我的個人資料與密碼' 設定新的密碼.\r\n\r\n"
			. "如果有任何�?題, 請連絡 %s.";

// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s 邀請您�?�加下�?�的�?約:\r\n\r\n"
		. "資�?: %s\r\n"
		. "開始日期: %s\r\n"
		. "開始時間: %s\r\n"
		. "�?�?�日期: %s\r\n"
		. "�?�?�時間: %s\r\n"
		. "摘�?: %s\r\n"
		. "循環�?複日期 (如果有設定): %s\r\n\r\n"
		. "如果�?接�?�這個邀請, 請到 (如果有必�?, 請複製並貼到�?覽器中) %s\r\n"
		. "如果�?拒絕這個邀請, 請到 (如果有必�?, 請複製並貼到�?覽器中) %s\r\n"
		. "如果�?��?接�?�部份的日期或管�?�您的邀請, 請登入 %s (%s)";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "您已經移除了下�?�的邀請:\r\n\r\n"
		. "資�?: %s\r\n"
		. "開始日期: %s\r\n"
		. "開始時間: %s\r\n"
		. "�?�?�日期: %s\r\n"
		. "�?�?�時間: %s\r\n"
		. "摘�?: %s\r\n"
		. "循環�?複日期 (如果有設定): %s\r\n\r\n";

// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "您的 %s �?約, 從 %s %s 到 %s %s 已經接近了.";
?>