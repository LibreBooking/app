<?php
/**
* Simplified Chinese (zh_CN) translation file.
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Fancy He <fancyhe@users.sourceforge.net>
* @version 09-10-06
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
$days_full = array('周日', '周一', '周二', '周三', '周四', '周五', '周六');
// The three letter abbreviation
$days_abbr = array('周日', '周一', '周二', '周三', '周四', '周五', '周六');
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
$months_full = array('一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月');
// The three letter month name
$months_abbr = array('一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月');

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
$strings['hours'] = '小时';
$strings['minutes'] = '分钟';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = '月';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = '日';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = '年';
$strings['am'] = '上午';
$strings['pm'] = '下午';

$strings['Administrator'] = '系统管理员';
$strings['Welcome Back'] = '欢迎回来, %s';
$strings['Log Out'] = '退出登录';
$strings['My Control Panel'] = '我的控制面板';
$strings['Help'] = '说明';
$strings['Manage Schedules'] = '日程管理';
$strings['Manage Users'] ='用户管理';
$strings['Manage Resources'] ='资源管理';
$strings['Manage User Training'] ='用户培训管理';
$strings['Manage Reservations'] ='预约管理';
$strings['Email Users'] ='电子邮件用户';
$strings['Export Database Data'] = '导出数据库內容';
$strings['Reset Password'] = '重设密码';
$strings['System Administration'] = '系统管理';
$strings['Successful update'] = '更新成功';
$strings['Update failed!'] = '更新失败!';
$strings['Manage Blackout Times'] = '管制时间管理';
$strings['Forgot Password'] = '忘记密码';
$strings['Manage My Email Contacts'] = '管理我的电子邮件联系人';
$strings['Choose Date'] = '选择日期';
$strings['Modify My Profile'] = '变更个人资料';
$strings['Register'] = '注册';
$strings['Processing Blackout'] = '管制处理中';
$strings['Processing Reservation'] = '预约处理中';
$strings['Online Scheduler [Read-only Mode]'] = '在线日程管理 [只读模式]';
$strings['Online Scheduler'] = '在线日程管理';
$strings['phpScheduleIt Statistics'] = 'phpScheduleIt 统计资料';
$strings['User Info'] = '用户资料:';

$strings['Could not determine tool'] = '无法決定工具. 请回到"我的控制面板"并稍候再试.';
$strings['This is only accessable to the administrator'] = '只有系统管理员可以使用这个功能';
$strings['Back to My Control Panel'] = '回到我的控制面板';
$strings['That schedule is not available.'] = '这个日程不可用.';
$strings['You did not select any schedules to delete.'] = '您沒有选择要刪除的日程.';
$strings['You did not select any members to delete.'] = '您沒有选择要刪除的用户.';
$strings['You did not select any resources to delete.'] = '您沒有选择要刪除的资源.';
$strings['Schedule title is required.'] = '日程标题是必需的.';
$strings['Invalid start/end times'] = '非法的开始或结束时间';
$strings['View days is required'] = '查看日期是必需的';
$strings['Day offset is required'] = '日期偏移是必需的';
$strings['Admin email is required'] = '管理员电子邮件是必需的';
$strings['Resource name is required.'] = '资源名称是必需的.';
$strings['Valid schedule must be selected'] = '必須选择有效的日程';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = '最小预约長度必須比最大预约長度小.';
$strings['Your request was processed successfully.'] = '您的请求已经成功的被处理了.';
$strings['Go back to system administration'] = '回到系统管理';
$strings['Or wait to be automatically redirected there.'] = '或者等候自动返回.';
$strings['There were problems processing your request.'] = '处理您的请求時发生了问题.';
$strings['Please go back and correct any errors.'] = '请回去更正错误.';
$strings['Login to view details and place reservations'] = '登录以查看详细资料和预约';
$strings['Memberid is not available.'] = '用户名称: %s 不存在.';

$strings['Schedule Title'] = '日程标题';
$strings['Start Time'] = '开始时间';
$strings['End Time'] = '结束时间';
$strings['Time Span'] = '时间跨度';
$strings['Weekday Start'] = '星期起始日';
$strings['Admin Email'] = '管理员电子邮件';

$strings['Default'] = '默认值';
$strings['Reset'] = '重设';
$strings['Edit'] = '编辑';
$strings['Delete'] = '刪除';
$strings['Cancel'] = '取消';
$strings['View'] = '查看';
$strings['Modify'] = '修改';
$strings['Save'] = '储存';
$strings['Back'] = '上一个';
$strings['Next'] = '下一个';
$strings['Close Window'] = '关闭窗口';
$strings['Search'] = '搜索';
$strings['Clear'] = '清除';

$strings['Days to Show'] = '显示的日期';
$strings['Reservation Offset'] = '预约偏移';
$strings['Hidden'] = '隐藏';
$strings['Show Summary'] = '显示摘要';
$strings['Add Schedule'] = '增加日程';
$strings['Edit Schedule'] = '编辑日程';
$strings['No'] = '否';
$strings['Yes'] = '是';
$strings['Name'] = '用户名称';
$strings['First Name'] = '名';
$strings['Last Name'] = '姓';
$strings['Resource Name'] = '资源名称';
$strings['Email'] = '电子邮件';
$strings['Institution'] = '机构';
$strings['Phone'] = '电话';
$strings['Password'] = '密码';
$strings['Permissions'] = '权限';
$strings['View information about'] = '查看关于 %s %s 的信息';
$strings['Send email to'] = '发送电子邮件给 %s %s';
$strings['Reset password for'] = '重设 %s %s 的密码';
$strings['Edit permissions for'] = '编辑 %s %s 的权限';
$strings['Position'] = '位置';
$strings['Password (6 char min)'] = '密码 (至少 %s 个字符)';	// @since 1.1.0
$strings['Re-Enter Password'] = '再次输入密码';

$strings['Sort by descending last name'] = '根据"姓"递减排列';
$strings['Sort by descending email address'] = '根据"电子邮件"递减排列';
$strings['Sort by descending institution'] = '根据"机构"递减排列';
$strings['Sort by ascending last name'] = '根据"姓"递增排列';
$strings['Sort by ascending email address'] = '根据"电子邮件"递增排列';
$strings['Sort by ascending institution'] = '根据"机构"递增排列';
$strings['Sort by descending resource name'] = '根据"资源名称"递减排列';
$strings['Sort by descending location'] = '根据"位置"递减排列';
$strings['Sort by descending schedule title'] = '根据"日程标题"递减排列';
$strings['Sort by ascending resource name'] = '根据"资源名称"递增排列';
$strings['Sort by ascending location'] = '根据"位置"递增排列';
$strings['Sort by ascending schedule title'] = '根据"日程标题"递增排列';
$strings['Sort by descending date'] = '根据"日期"递减排列';
$strings['Sort by descending user name'] = '根据"用户名称"递减排列';
$strings['Sort by descending start time'] = '根据"开始时间"递减排列';
$strings['Sort by descending end time'] = '根据"结束时间"递减排列';
$strings['Sort by ascending date'] = '根据"日期"递增排列';
$strings['Sort by ascending user name'] = '根据"用户名称"递增排列';
$strings['Sort by ascending start time'] = '根据"开始时间"递增排列';
$strings['Sort by ascending end time'] = '根据"结束时间"递增排列';
$strings['Sort by descending created time'] = '根据"建立时间"递减排列';
$strings['Sort by ascending created time'] = '根据"建立时间"递增排列';
$strings['Sort by descending last modified time'] = '根据"最后修改时间"递减排列';
$strings['Sort by ascending last modified time'] = '根据"最后修改时间"递增排列';

$strings['Search Users'] = '搜索用户';
$strings['Location'] = '位置';
$strings['Schedule'] = '日程';
$strings['Phone'] = '电话';
$strings['Notes'] = '备注';
$strings['Status'] = '状态';
$strings['All Schedules'] = '全部日程';
$strings['All Resources'] = '全部资源';
$strings['All Users'] = '全部用户';

$strings['Edit data for'] = '编辑 %s 的资料';
$strings['Active'] = '使用中';
$strings['Inactive'] = '停用中';
$strings['Toggle this resource active/inactive'] = '切换这个资源的使用状态';
$strings['Minimum Reservation Time'] = '最小预约时间';
$strings['Maximum Reservation Time'] = '最大预约时间';
$strings['Auto-assign permission'] = '自动给予权限';
$strings['Add Resource'] = '增加资源';
$strings['Edit Resource'] = '编辑资源';
$strings['Allowed'] = '批准';
$strings['Notify user'] = '通知用户';
$strings['User Reservations'] = '用户预约';
$strings['Date'] = '日期';
$strings['User'] = '用户';
$strings['Email Users'] = '电子邮件用户';
$strings['Subject'] = '标题';
$strings['Message'] = '消息';
$strings['Please select users'] = '请选择用户';
$strings['Send Email'] = '发送邮件';
$strings['problem sending email'] = '抱歉, 发送邮件時发生了问题, 请稍候再试.';
$strings['The email sent successfully.'] = '邮件以成功发送.';
$strings['do not refresh page'] = '请 <u>不要</u> 刷新本页面. 这样将会再次发送邮件.';
$strings['Return to email management'] = '回到电子邮件管理';
$strings['Please select which tables and fields to export'] = '请选择需要导出的表格与字段:';
$strings['all fields'] = '- 全部字段 -';
$strings['HTML'] = '网页';
$strings['Plain text'] = '纯文本';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = '导出资料';
$strings['Reset Password for'] = '重设 %s 的密码';
$strings['Please edit your profile'] = '请编辑您的个人资料';
$strings['Please register'] = '请注册';
$strings['Keep me logged in'] = '记住我的登录状态 <br/> (需要 cookies)';
$strings['Edit Profile'] = '编辑个人资料';
$strings['Register'] = '注册';
$strings['Please Log In'] = '请登录';
$strings['Email address'] = '电子邮件';
$strings['Password'] = '密码';
$strings['First time user'] = '第一次使用?';
$strings['Click here to register'] = '点这里注册';
$strings['Register for phpScheduleIt'] = '注册 phpScheduleIt';
$strings['Log In'] = '登录';
$strings['View Schedule'] = '查看日程';
$strings['View a read-only version of the schedule'] = '查看只读的日程表';
$strings['I Forgot My Password'] = '忘记密码';
$strings['Retreive lost password'] = '找回密码';
$strings['Get online help'] = '获得在线帮助';
$strings['Language'] = '语言';
$strings['(Default)'] = '(默认)';

$strings['My Announcements'] = '我的公告';
$strings['My Reservations'] = '我的预约';
$strings['My Permissions'] = '我的权限';
$strings['My Quick Links'] = '我的快速链接';
$strings['Announcements as of'] = '%s 的公告';
$strings['There are no announcements.'] = '沒有公告事项.';
$strings['Resource'] = '资源';
$strings['Created'] = '建立时间';
$strings['Last Modified'] = '最后修改时间';
$strings['View this reservation'] = '查看这个预约';
$strings['Modify this reservation'] = '修改这个预约';
$strings['Delete this reservation'] = '刪除这个预约';
$strings['Bookings'] = '预约';											// @since 1.2.0
$strings['Change My Profile Information/Password'] = '变更个人资料';		// @since 1.2.0
$strings['Manage My Email Preferences'] = '电子邮件选项';				// @since 1.2.0
$strings['Mass Email Users'] = '群发电子邮件';
$strings['Search Scheduled Resource Usage'] = '搜索预约';		// @since 1.2.0
$strings['Export Database Content'] = '导出数据库內容';
$strings['View System Stats'] = '查看系统状态';
$strings['Email Administrator'] = '联系系统管理员';

$strings['Email me when'] = '通知我:';
$strings['I place a reservation'] = '建立预约';
$strings['My reservation is modified'] = '预约已被修改';
$strings['My reservation is deleted'] = '预约已被刪除';
$strings['I prefer'] = '我偏好:';
$strings['Your email preferences were successfully saved'] = '您的电子邮件选项设置已被储存!';
$strings['Return to My Control Panel'] = '回到我的控制面板';

$strings['Please select the starting and ending times'] = '请选择开始与结束时间:';
$strings['Please change the starting and ending times'] = '请变更开始与结束时间:';
$strings['Reserved time'] = '预约的时间:';
$strings['Minimum Reservation Length'] = '最小预约長度:';
$strings['Maximum Reservation Length'] = '最大预约長度:';
$strings['Reserved for'] = '预约给:';
$strings['Will be reserved for'] = '将被预约给:';
$strings['N/A'] = '无';
$strings['Update all recurring records in group'] = '是否更新组中全部的循环纪录?';
$strings['Delete?'] = '是否刪除?';
$strings['Never'] = '-- 无 --';
$strings['Days'] = '日';
$strings['Weeks'] = '周';
$strings['Months (date)'] = '月 (日期)';
$strings['Months (day)'] = '月 (天)';
$strings['First Days'] = '第一個';
$strings['Second Days'] = '第二個';
$strings['Third Days'] = '第三個';
$strings['Fourth Days'] = '第四個';
$strings['Last Days'] = '最后一個';
$strings['Repeat every'] = '重复频率:';
$strings['Repeat on'] = '重复在:';
$strings['Repeat until date'] = '重复直到:';
$strings['Choose Date'] = '选择日期';
$strings['Summary'] = '摘要';

$strings['View schedule'] = '查看日程:';
$strings['My Reservations'] = '我的预约';
$strings['My Past Reservations'] = '我之前的预约';
$strings['Other Reservations'] = '其他预约';
$strings['Other Past Reservations'] = '其他过去的预约';
$strings['Blacked Out Time'] = '管制的时间';
$strings['Set blackout times'] = '设置 %s 的管制在 %s'; 
$strings['Reserve on'] = '预约了 %s 于 %s';
$strings['Prev Week'] = '上周';
$strings['Jump 1 week back'] = '跳回一周';
$strings['Prev days'] = '之前 %d 天';
$strings['Previous days'] = '之前 %d 天';
$strings['This Week'] = '本周';
$strings['Jump to this week'] = '跳到本周';
$strings['Next days'] = '之后 %d 天';
$strings['Next Week'] = '下周';
$strings['Jump To Date'] = '跳到日期';
$strings['View Monthly Calendar'] = '查看月历';
$strings['Open up a navigational calendar'] = '打开月历窗口';

$strings['View stats for schedule'] = '查看预约的状态:';
$strings['At A Glance'] = '一览表';
$strings['Total Users'] = '全部用户数:';
$strings['Total Resources'] = '全部资源数:';
$strings['Total Reservations'] = '全部预约数:';
$strings['Max Reservation'] = '最大预约时间:';
$strings['Min Reservation'] = '最小预约时间:';
$strings['Avg Reservation'] = '平均 预约时间:';
$strings['Most Active Resource'] = '用的最多的资源:';
$strings['Most Active User'] = '用的最多的用户:';
$strings['System Stats'] = '系统状态';
$strings['phpScheduleIt version'] = 'phpScheduleIt 版本:';
$strings['Database backend'] = '后台数据库:';
$strings['Database name'] = '数据库名称:';
$strings['PHP version'] = 'PHP 版本:';
$strings['Server OS'] = '服务器系统:';
$strings['Server name'] = '服务器名称:';
$strings['phpScheduleIt root directory'] = 'phpScheduleIt 根目录:';
$strings['Using permissions'] = '使用权限:';
$strings['Using logging'] = '使用纪录:';
$strings['Log file'] = '纪录文件:';
$strings['Admin email address'] = '管理者电子邮件:';
$strings['Tech email address'] = '技术支持电子邮件:';
$strings['CC email addresses'] = '电子邮件副本:';
$strings['Reservation start time'] = '预约起始时间:';
$strings['Reservation end time'] = '预约结束时间:';
$strings['Days shown at a time'] = '同时显示日数:';
$strings['Reservations'] = '预约';
$strings['Return to top'] = '回到顶端';
$strings['for'] = '-';

$strings['Select Search Criteria'] = '选择搜索条件';
$strings['Schedules'] = '日程:';
$strings['All Schedules'] = '全部日程';
$strings['Hold CTRL to select multiple'] = '按下 CTRL 以多重选择';
$strings['Users'] = '用户:';
$strings['All Users'] = '全部用户';
$strings['Resources'] = '资源';
$strings['All Resources'] = '全部资源';
$strings['Starting Date'] = '开始日期:';
$strings['Ending Date'] = '结束日期:';
$strings['Starting Time'] = '开始时间:';
$strings['Ending Time'] = '结束时间:';
$strings['Output Type'] = '输出类型:';
$strings['Manage'] = '管理';
$strings['Total Time'] = '全部时间';
$strings['Total hours'] = '全部小时数:';
$strings['% of total resource time'] = '% 全部资源时间';
$strings['View these results as'] = '查看這些结果为:';
$strings['Edit this reservation'] = '编辑这个预约';
$strings['Search Results'] = '搜索结果';
$strings['Search Resource Usage'] = '搜索资源使用率';
$strings['Search Results found'] = '搜索结果果: 找到 %d 个预约';
$strings['Try a different search'] = '尝试不同搜索';
$strings['Search Run On'] = '搜索执行于:';
$strings['Member ID'] = '用户编号';
$strings['Previous User'] = '前一个用户';
$strings['Next User'] = '下一个用户';

$strings['No results'] = '沒有结果';
$strings['That record could not be found.'] = '找不到这个纪录.';
$strings['This blackout is not recurring.'] = '这个管制沒有循环纪录.';
$strings['This reservation is not recurring.'] = '这个预约沒有循环纪录.';
$strings['There are no records in the table.'] = '在 %s 表中沒有纪录.';
$strings['You do not have any reservations scheduled.'] = '您沒有任何预约的日程.';
$strings['You do not have permission to use any resources.'] = '您没有权限使用任何资源.';
$strings['No resources in the database.'] = '数据库中沒有资源.';
$strings['There was an error executing your query'] = '您的查詢有错误:';

$strings['That cookie seems to be invalid'] = '这个 cookie 似乎不合法';
$strings['We could not find that logon in our database.'] = '我们在数据库中找不到这个登录名称.';	// @since 1.1.0
$strings['That password did not match the one in our database.'] = '密码与我们数据库的纪录不符.';
$strings['You can try'] = '<br />您可以尝试:<br />注册一个电子邮件.<br />或者:<br />尝试另一次登录.';
$strings['A new user has been added'] = '增加了一个新用户';
$strings['You have successfully registered'] = '您已经成功注册了!';
$strings['Continue'] = '继续...';
$strings['Your profile has been successfully updated!'] = '您的个人资料已成功更新!';
$strings['Please return to My Control Panel'] = '请回到"我的控制面板"';
$strings['Valid email address is required.'] = '- 您需要一個合法的电子邮件.';
$strings['First name is required.'] = '- "名"是必需的.';
$strings['Last name is required.'] = '- "姓"是必需的.';
$strings['Phone number is required.'] = '- "电话"是必需的.';
$strings['That email is taken already.'] = '- 这个电子邮件已经被使用了.<br />请换一個电子邮件后再试.';
$strings['Min 6 character password is required.'] = '- 至少 %s 個字符的密码是必需的.';
$strings['Passwords do not match.'] = '- 密码不匹配.';

$strings['Per page'] = '每页:';
$strings['Page'] = '页码:';

$strings['Your reservation was successfully created'] = '您已经成功建立了下列预约';
$strings['Your reservation was successfully modified'] = '您已经成功修改了下列预约';
$strings['Your reservation was successfully deleted'] = '您已经成功刪除了下列预约';
$strings['Your blackout was successfully created'] = '您已经成功建立了下列管制';
$strings['Your blackout was successfully modified'] = '您已经成功修改了下列管制';
$strings['Your blackout was successfully deleted'] = '您已经成功刪除了下列管制';
$strings['for the follwing dates'] = '为以下日期:';
$strings['Start time must be less than end time'] = '开始时间必须比结束时间早.';
$strings['Current start time is'] = '目前开始时间为:';
$strings['Current end time is'] = '目前结束时间为:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = '预约长度不在资源的允许长度内.';
$strings['Your reservation is'] = '您的预约为:';
$strings['Minimum reservation length'] = '最小预约长度:';
$strings['Maximum reservation length'] = '最大预约长度:';
$strings['You do not have permission to use this resource.'] = '您没有使用这个资源的权限.';
$strings['reserved or unavailable'] = '%s 到 %s 已经被预约或者不能使用.';	// @since 1.1.0
$strings['Reservation created for'] = '预约已建立给 %s';
$strings['Reservation modified for'] = '预约已修改给 %s';
$strings['Reservation deleted for'] = '预约已刪除给 %s';
$strings['created'] = '建立时间';
$strings['modified'] = '修改时间';
$strings['deleted'] = '已刪除';
$strings['Reservation #'] = '预约编号';
$strings['Contact'] = '联系人';
$strings['Reservation created'] = '预约已建立';
$strings['Reservation modified'] = '预约已修改';
$strings['Reservation deleted'] = '预约已刪除';

$strings['Reservations by month'] = '按月的预约数';
$strings['Reservations by day of the week'] = '每周的预约数';
$strings['Reservations per month'] = '每月的预约数';
$strings['Reservations per user'] = '每个用户的预约数';
$strings['Reservations per resource'] = '每个资源的预约数';
$strings['Reservations per start time'] = '按照开始时间的预约数';
$strings['Reservations per end time'] = '按照结束时间的预约数';
$strings['[All Reservations]'] = '[全部预约]';

$strings['Permissions Updated'] = '权限已更新';
$strings['Your permissions have been updated'] = '您的 %s 权限已被更新';
$strings['You now do not have permission to use any resources.'] = '您沒有任何资源的使用权限.';
$strings['You now have permission to use the following resources'] = '您有使用下列资源的权限:';
$strings['Please contact with any questions.'] = '如果有问题, 请联系人 %s.';
$strings['Password Reset'] = '重设密码';

$strings['This will change your password to a new, randomly generated one.'] = '这个功能將会将您的密码设为一个随机的密码.';
$strings['your new password will be set'] = '在输入您的电子邮件并按下"改变密码"后, 您的密码将被重设并电子邮件给您.';
$strings['Change Password'] = '改变密码';
$strings['Sorry, we could not find that user in the database.'] = '抱歉, 我们在数据库中找不到这个用户.';
$strings['Your New Password'] = '您的新 %s 密码';
$strings['Your new passsword has been emailed to you.'] = '成功!<br />'
    			. '您的新密码已经寄出.<br />'
    			. '请到您的信箱中获得新密码, 然后使用这个新密码 <a href="index.php">登录</a>'
    			. ' 并主动到控制面板中点击变更我的个人资料/密码'
    			. ' 以变更密码.';

$strings['You are not logged in!'] = '您还没有登录!';

$strings['Setup'] = '设置';
$strings['Please log into your database'] = '请登录您的数据库';
$strings['Enter database root username'] = '输入数据库管理员名称:';
$strings['Enter database root password'] = '输入数据库管理员密码:';
$strings['Login to database'] = '登录数据库';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = '您 <b>不</b> 需要管理员帐号. 任何可以建立资料表的数据库用户都是可接受的.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = '这将会设置所有 phpScheduleIt 所需要的数据库与表.';
$strings['It also populates any required tables.'] = '同时也会在表中填入必需的资料.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = '警告: 这将会刪除所有 phpScheduleIt 的数据库!';
$strings['Not a valid database type in the config.php file.'] = 'config.php 之中没有合法的数据库名称.';
$strings['Database user password is not set in the config.php file.'] = '数据库用户名称与密码没有在 config.php 之中设置.';
$strings['Database name not set in the config.php file.'] = '数据库名称没有在 config.php 之中设置.';
$strings['Successfully connected as'] = '成功的连接为';
$strings['Create tables'] = '建立表';
$strings['There were errors during the install.'] = '安装过程中发生错误. 如果是次要的错误, phpScheduleIt 可能还是可以正常工作.<br/><br/>'
	. '请到<a href="http://sourceforge.net/forum/?group_id=95547">SourceForge</a> 的论坛发布您的问题.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = '您已经成功的完成了 phpScheduleIt 的设置. 您可以开始使用了.';
$strings['Thank you for using phpScheduleIt'] = '请确定您完全刪除 \'install\' 目录.'
	. ' 因为这个目录包含了数据库密码与其他资料, 所以这个动作非常危险.'
	. '<br /><br />'
	. '谢谢您使用 phpScheduleIt!';
$strings['There is no way to undo this action'] = '这个动作将无法恢复!';
$strings['Click to proceed'] = '点击这里继续';
$strings['Please delete this file.'] = '请刪除这个文件.';
$strings['Successful update'] = '更新成功';
$strings['Patch completed successfully'] = '修补已成功';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = '如果沒有指定值, 配置文件中的重设密码将被使用.';
$strings['Notify user that password has been changed?'] = '是否通知用户密码变更?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = '您必須有电子邮件才能使用这个系统.';
$strings['Invalid User Name/Password.'] = '错误的用户名称/密码.';
$strings['Pending User Reservations'] = '等待批准的用户预约';
$strings['Approve'] = '批准';
$strings['Approve this reservation'] = '批准这个预约';
$strings['Approve Reservations'] ='批准预约';

$strings['Announcement'] = '公告';
$strings['Number'] = '编号';
$strings['Add Announcement'] = '新增公告';
$strings['Edit Announcement'] = '编辑公告';
$strings['All Announcements'] = '所有公告';
$strings['Delete Announcements'] = '刪除公告';
$strings['Use start date/time?'] = '使用开始日期/时间?';
$strings['Use end date/time?'] = '使用结束日期/时间?';
$strings['Announcement text is required.'] = '公告內容是必需的.';
$strings['Announcement number is required.'] = '公告编号是必需的.';

$strings['Pending Approval'] = '等待批准';
$strings['My reservation is approved'] = '我的预约已被批准';
$strings['This reservation must be approved by the administrator.'] = '这个预约需要管理员的批准.';
$strings['Approval Required'] = '需要批准';
$strings['No reservations requiring approval'] = '沒有需要批准的预约';
$strings['Your reservation was successfully approved'] = '您的预约已被批准';
$strings['Reservation approved for'] = '%s 的预约批准';
$strings['approved'] = '已批准';
$strings['Reservation approved'] = '预约已被批准';

$strings['Valid username is required'] = '需要合法的用户名称';
$strings['That logon name is taken already.'] = '這的登录名已被使用.';
$strings['this will be your login'] = '(这将是您的登录名)';
$strings['Logon name'] = '登录名';
$strings['Your logon name is'] = '您的登录名为 %s';

$strings['Start'] = '开始';
$strings['End'] = '结束';
$strings['Start date must be less than or equal to end date'] = '开始时间必须比结束时间早';
$strings['That starting date has already passed'] = '这个开始时间已经过去了';
$strings['Basic'] = '基本';
$strings['Participants'] = '参与人员';
$strings['Close'] = '关闭';
$strings['Start Date'] = '开始时间';
$strings['End Date'] = '结束时间';
$strings['Minimum'] = '最小';
$strings['Maximum'] = '最大';
$strings['Allow Multiple Day Reservations'] = '允许多天的预约';
$strings['Invited Users'] = '邀请的用户';
$strings['Invite Users'] = '邀请用户';
$strings['Remove Participants'] = '删除参与人员';
$strings['Reservation Invitation'] = '预约邀请';
$strings['Manage Invites'] = '管理邀请';
$strings['No invite was selected'] = '沒有选择邀请';
$strings['reservation accepted'] = '%s 接受了您的邀请在 %s ';
$strings['reservation declined'] = '%s 拒绝了您的邀请在 %s ';
$strings['Login to manage all of your invitiations'] = '登录已管理您的邀请';
$strings['Reservation Participation Change'] = '参与邀请变更';
$strings['My Invitations'] = '我的邀请';
$strings['Accept'] = '接受';
$strings['Decline'] = '拒绝';
$strings['Accept or decline this reservation'] = '接受或拒绝邀请';
$strings['My Reservation Participation'] = '我的参与邀请';
$strings['End Participation'] = '结束参与';
$strings['Owner'] = '所有人';
$strings['Particpating Users'] = '参与的用户';
$strings['No advanced options available'] = '沒有进一步的功能';
$strings['Confirm reservation participation'] = '确认预约邀请';
$strings['Confirm'] = '确认';
$strings['Do for all reservations in the group?'] = '为这个组中的全部预约?';

$strings['My Calendar'] = '我的日历';
$strings['View My Calendar'] = '查看我的日历';
$strings['Participant'] = '参与人员';
$strings['Recurring'] = '循环';
$strings['Multiple Day'] = '多天';
$strings['[today]'] = '[今天]';
$strings['Day View'] = '日报表';
$strings['Week View'] = '周报表';
$strings['Month View'] = '月报表';
$strings['Resource Calendar'] = '资源日历';
$strings['View Resource Calendar'] = '资源日历';	// @since 1.2.0
$strings['Signup View'] = '登記报表';

$strings['Select User'] = '选择用户';
$strings['Change'] = '变更';

$strings['Update'] = '更新';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'phpScheduleIt 更新只提供给 1.0.0 之后的版本';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt 已经是最新的';
$strings['Migrating reservations'] = '合并预约';

$strings['Admin'] = '管理员';
$strings['Manage Announcements'] = '公告管理';
$strings['There are no announcements'] = '沒有公告';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = '最多参与人数';
$strings['Leave blank for unlimited'] = '留空表示不限制';
$strings['Maximum of participants'] = '这个资源的最大参与人数为 %s 人';
$strings['That reservation is at full capacity.'] = '这个预约已经满了.';
$strings['Allow registered users to join?'] = '允许注册的用户加入?';
$strings['Allow non-registered users to join?'] = '允许未注册的用户加入?';
$strings['Join'] = '参加';
$strings['My Participation Options'] = '我的参与选项';
$strings['Join Reservation'] = '参加预约';
$strings['Join All Recurring'] = '参加所有循环的预约';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = '因为已经额满, 您无法参加下列日期的预约.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = '您已经被邀请参加这个预约. 请参照给您的电子邮件的指示参加这个预约.';
$strings['Additional Tools'] = '其它工具';
$strings['Create User'] = '增加用户';
$strings['Check Availability'] = '检查是否可用';
$strings['Manage Additional Resources'] = '管理附件';
$strings['All Additional Resources'] = '所有附件';
$strings['Number Available'] = '可用的数量';
$strings['Unlimited'] = '无限制';
$strings['Add Additional Resource'] = '增加附件';
$strings['Edit Additional Resource'] = '编辑附件';
$strings['Checking'] = '检查中';
$strings['You did not select anything to delete.'] = '您沒有选择要刪除的东西.';
$strings['Added Resources'] = '增加的资源';
$strings['Additional resource is reserved'] = '附件已经预约';
$strings['All Groups'] = '全部组';
$strings['Group Name'] = '组名称';
$strings['Delete Groups'] = '刪除组';
$strings['Manage Groups'] = '组管理';
$strings['None'] = '无';
$strings['Group name is required.'] = '组名称是必需的.';
$strings['Groups'] = '组';
$strings['Current Groups'] = '目前组';
$strings['Group Administration'] = '组管理';
$strings['Reminder Subject'] = '预约提醒- %s, %s %s';
$strings['Reminder'] = '提醒';
$strings['before reservation'] = '预约之前';
$strings['My Participation'] = '我的参与';
$strings['My Past Participation'] = '我过去的参与';
$strings['Timezone'] = '时区';
$strings['Export'] = '导出';
$strings['Select reservations to export'] = '选择要导出的预约';
$strings['Export Format'] = '导出格式';
$strings['This resource cannot be reserved less than x hours in advance'] = '这个资源不能在少于 %s 小时预约';
$strings['This resource cannot be reserved more than x hours in advance'] = '这个资源不能在多于 %s 小时预约';
$strings['Minimum Booking Notice'] = '最小预约通知时间';
$strings['Maximum Booking Notice'] = '最大预约通知时间';
$strings['hours prior to the start time'] = '开始前...小时';
$strings['hours from the current time'] = '从现在起...小时';
$strings['Contains'] = '包含';
$strings['Begins with'] = '开始为';
$strings['Minimum booking notice is required.'] = '最小预约通知是必需的.';
$strings['Maximum booking notice is required.'] = '最大预约通知是必需的.';
$strings['Manage Additional Resources'] = '管理附件';
$strings['Add Additional Resource'] = '增加附件';
$strings['Edit Additional Resource'] = '编辑附件';
$strings['Accessory Name'] = '附件名称';
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
				. "您成功的注册了下列资料:\r\n"
				. "登录: %s\r\n"
				. "姓名: %s %s \r\n"
				. "电话: %s \r\n"
				. "机构: %s \r\n"
				. "称呼: %s \r\n\r\n"
				. "应从下面的地址登录系统:\r\n"
				. "%s \r\n\r\n"
				. "您可以在\"我的控制面板\"中找到编辑您个人资料的链接.\r\n\r\n"
				. "如果您有关于资源或预约的问题, 请联系 %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "管裡員,\r\n\r\n"
					. "新用户用下列的资料注册了新帐号:\r\n"
					. "电子邮件: %s \r\n"
					. "姓名: %s %s \r\n"
					. "电话: %s \r\n"
					. "机构: %s \r\n"
					. "称呼: %s \r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "您已经成功的 %s 了预约, 编号 #%s.\r\n\r\n<br/><br/>"
			. "当联系管理员时, 请使用这个预约编号.\r\n\r\n<br/><br/>"
			. "在 %s %s 到 %s %s 之间的 %s 预约,"
			. " 设备在 %s 已经被 %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "这个预约将在重复:\r\n<br/>";
$email['reservation_activity_3'] = "在这个组中, 所有的循环预约也将 %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "下面是这个预约的摘要:\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "如果有错误, 请使用 %s 联系管理员,"
			. " 或致电 %s.\r\n\r\n<br/><br/>"
			. "您可以在任何時候登录 %s (<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n) 以修改这个预约."
			. "<br/><br/>";
$email['reservation_activity_6'] = "如果需要本系统的技术支持, 请联系 <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
			. "预约编号 #%s 已经被接受了.\r\n\r\n<br/><br/>"
			. "当联系管理员时, 请使用这个预约编号.\r\n\r\n<br/><br/>"
			. "在 %s %s 到 %s %s 之间的 %s 预约,"
			. " 设备在 %s 已经被 %s.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "您的 %s 密码已经被管理员重设.\r\n\r\n"
			. "您的临时密码为:\r\n\r\n %s\r\n\r\n"
			. "请用这个临时密码(您可以使用复制和粘贴來确保正确性)登录到 %s (%s),"
			. " 并且立刻到 '变更我的个人资料与密码' 设置新的密码.\r\n\r\n"
			. "如果有任何问题, 请联系 %s.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n"
            . "您 %s 帐号的新密码为:\r\n\r\n"
            . "%s\r\n\r\n"
            . "请使用这个密码在 %s 登录"
            . "(您可以使用复制和粘贴来确保正确性), "
			. " 并且立刻到 '变更我的个人资料与密码' 设置新的密码.\r\n\r\n"
			. "如果有任何问题, 请联系人 %s.";

// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s 邀请您参加下面的预约:\r\n\r\n"
		. "资源: %s\r\n"
		. "开始日期: %s\r\n"
		. "开始时间: %s\r\n"
		. "结束日期: %s\r\n"
		. "结束时间: %s\r\n"
		. "摘要: %s\r\n"
		. "循环重复日期 (如果有设置): %s\r\n\r\n"
		. "如果要接受这个邀请, 请到 (如果有必要, 请复制并粘贴到浏览器中) %s\r\n"
		. "如果要拒绝这个邀请, 请到 (如果有必要, 请复制并粘贴到浏览器中) %s\r\n"
		. "如果想要接受部份的日期或管理您的邀请, 请登录 %s (%s)";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "您已经删除了下列的邀请:\r\n\r\n"
		. "资源: %s\r\n"
		. "开始日期: %s\r\n"
		. "开始时间: %s\r\n"
		. "结束日期: %s\r\n"
		. "结束时间: %s\r\n"
		. "摘要: %s\r\n"
		. "循环重复日期 (如果有设置): %s\r\n\r\n";

// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "您的 %s 预约, 從 %s %s 到 %s %s 已经接近了.";
?>