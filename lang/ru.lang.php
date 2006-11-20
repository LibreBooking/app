<?php
/**
* Russian (ru) translation file.
*  
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @translator Sergey Salnikov <salnsg@gmail.com>
* @version 05-14-06
* @package Languages
*
* Copyright (C) 2003 - 2006 phpScheduleIt
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
$charset = 'windows-1251';

/***
  DAY NAMES
  All of these arrays MUST start with Sunday as the first element 
   and go through the seven day week, ending on Saturday
***/
// The full day name
$days_full = array('Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота');
// The three letter abbreviation
$days_abbr = array('Вос', 'Пон', 'Вто', 'Сре', 'Чет', 'Пят', 'Суб');
// The two letter abbreviation
$days_two  = array('Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пн', 'Сб');
// The one letter abbreviation
$days_letter = array('В', 'П', 'В', 'С', 'Ч', 'П', 'С');

/***
  MONTH NAMES
  All of these arrays MUST start with January as the first element
   and go through the twelve months of the year, ending on December
***/
// The full month name
$months_full = array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');
// The three letter month name
$months_abbr = array('Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек');

// All letters of the alphabet starting with A and ending with Z
$letters = array ('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ь' ,'Ы', 'Ъ', 'Э', 'Ю', 'Я');

/***
  DATE FORMATTING
  All of the date formatting must use the PHP strftime() syntax
  You can include any text/HTML formatting in the translation
***/
// General date formatting used for all date display unless otherwise noted
$dates['general_date'] = '%d/%m/%Y';
// General datetime formatting used for all datetime display unless otherwise noted
// The hour:minute:second will always follow this format
$dates['general_datetime'] = '%d/%m/%Y @';
// Date in the reservation notification popup and email
$dates['res_check'] = '%A %d/%m/%Y';
// Date on the scheduler that appears above the resource links
$dates['schedule_daily'] = '%A,<br/>%d/%m/%Y';
// Date on top-right of each page
$dates['header'] = '%A, %B %d, %Y';
// Jump box format on bottom of the schedule page
// This must only include %m %d %Y in the proper order,
//  other specifiers will be ignored and will corrupt the jump box 
$dates['jumpbox'] = '%d %m %Y';

/***
  STRING TRANSLATIONS
  All of these strings should be translated from the English value (right side of the equals sign) to the new language.
  - Please keep the keys (between the [] brackets) as they are.  The keys will not always be the same as the value.
  - Please keep the sprintf formatting (%s) placeholders where they are unless you are sure it needs to be moved.
  - Please keep the HTML and punctuation as-is unless you know that you want to change it.
***/
$strings['hours'] = 'часы';
$strings['minutes'] = 'минуты';
// The common abbreviation to hint that a user should enter the month as 2 digits
$strings['mm'] = 'mm';
// The common abbreviation to hint that a user should enter the day as 2 digits
$strings['dd'] = 'dd';
// The common abbreviation to hint that a user should enter the year as 4 digits
$strings['yyyy'] = 'yyyy';
$strings['am'] = 'am';
$strings['pm'] = 'pm';

$strings['Administrator'] = 'Администрирование';
$strings['Welcome Back'] = 'С возвращением, %s';
$strings['Log Out'] = 'Выйти';
$strings['My Control Panel'] = 'Моя панель управления';
$strings['Help'] = 'Помощь';
$strings['Manage Schedules'] = 'Управление расписаниями';
$strings['Manage Users'] ='Управление пользователями';
$strings['Manage Resources'] ='Управление ресурсами';
$strings['Manage User Training'] ='Управление обучением пользователей';
$strings['Manage Reservations'] ='Управление заказами';
$strings['Email Users'] ='E-mail пользователей';
$strings['Export Database Data'] = 'Экспортирование данных';
$strings['Reset Password'] = 'Переустановка пароля';
$strings['System Administration'] = 'Системное администрирование';
$strings['Successful update'] = 'Успешное обновление';
$strings['Update failed!'] = 'Обновление неудачно!';
$strings['Manage Blackout Times'] = 'Управление периодами отключения';
$strings['Forgot Password'] = 'Забыли пароль';
$strings['Manage My Email Contacts'] = 'Управление моими E-mail контактами';
$strings['Choose Date'] = 'Выбор даты';
$strings['Modify My Profile'] = 'Правка моего профиля';
$strings['Register'] = 'Регистрация';
$strings['Processing Blackout'] = 'Производится отключение';
$strings['Processing Reservation'] = 'Производится заказывание';
$strings['Online Scheduler [Read-only Mode]'] = 'Расписание он-лайн [Режим только для чтения]';
$strings['Online Scheduler'] = 'Расписание он-лайн';
$strings['phpScheduleIt Statistics'] = 'Статистика системы phpScheduleIt';
$strings['User Info'] = 'Пользовательская информация:';

$strings['Could not determine tool'] = 'Средство не определено. Пожалуйста, вернитесь в Вашу панель управления и попробуйте еще раз позже.';
$strings['This is only accessable to the administrator'] = 'Это доступно только администратору';
$strings['Back to My Control Panel'] = 'Вернуться на мою панель управления';
$strings['That schedule is not available.'] = 'Это расписание недоступно.';
$strings['You did not select any schedules to delete.'] = 'Вы не выбрали расписаний для удаления.';
$strings['You did not select any members to delete.'] = 'Вы не выбрали членов для удаления.';
$strings['You did not select any resources to delete.'] = 'Вы не выбрали ресурсов для удаления.';
$strings['Schedule title is required.'] = 'Заголовок расписания обязателен.';
$strings['Invalid start/end times'] = 'Неправильное время начала/окончания';
$strings['View days is required'] = 'Просмотр дней обязателен';
$strings['Day offset is required'] = 'Дневной интервал обязателен';
$strings['Admin email is required'] = 'Административный e-mail обязателен';
$strings['Resource name is required.'] = 'Имя ресурса обязательно.';
$strings['Valid schedule must be selected'] = 'Правильное расписание должно быть выбрано';
$strings['Minimum reservation length must be less than or equal to maximum reservation length.'] = 'Минимальная длина заказа должна быть не больше максимальное его длины.';
$strings['Your request was processed successfully.'] = 'Ваш запрос успешно обработан.';
$strings['Go back to system administration'] = 'Возврат к системному администрированию';
$strings['Or wait to be automatically redirected there.'] = 'Или подождать автоматического перемещения туда.';
$strings['There were problems processing your request.'] = 'Имеются проблемы при обработке Вашего запроса.';
$strings['Please go back and correct any errors.'] = 'Пожалуйста, вернитесь и исправьте ошибки.';
$strings['Login to view details and place reservations'] = 'Авторизуйтесь, чтобы посмотреть детали и место заказов';
$strings['Memberid is not available.'] = 'Код члена: %s не доступен.';

$strings['Schedule Title'] = 'Заголовок расписания';
$strings['Start Time'] = 'Время начала';
$strings['End Time'] = 'Время окончания';
$strings['Time Span'] = 'Промежуток времени';
$strings['Weekday Start'] = 'Еженедельное начало';
$strings['Admin Email'] = 'E-mail администратора';

$strings['Default'] = 'По умолчанию';
$strings['Reset'] = 'Переустановка';
$strings['Edit'] = 'Правка';
$strings['Delete'] = 'Удаление';
$strings['Cancel'] = 'Отказ';
$strings['View'] = 'Просмотр';
$strings['Modify'] = 'Правка';
$strings['Save'] = 'Сохранение';
$strings['Back'] = 'Назад';
$strings['Next'] = 'След.';
$strings['Close Window'] = 'Закрыть окно';
$strings['Search'] = 'Поиск';
$strings['Clear'] = 'Очистка';

$strings['Days to Show'] = 'Дни показа';
$strings['Reservation Offset'] = 'Интервал заказа';
$strings['Hidden'] = 'Скрыто';
$strings['Show Summary'] = 'Показ свода';
$strings['Add Schedule'] = 'Добавить расписание';
$strings['Edit Schedule'] = 'Править расписание';
$strings['No'] = 'Нет';
$strings['Yes'] = 'Да';
$strings['Name'] = 'Наименование';
$strings['First Name'] = 'Имя';
$strings['Last Name'] = 'Фамилия';
$strings['Resource Name'] = 'Наименование ресурса';
$strings['Email'] = 'E-mail';
$strings['Institution'] = 'Институт';
$strings['Phone'] = 'Телефон';
$strings['Password'] = 'Пароль';
$strings['Permissions'] = 'Разрешения';
$strings['View information about'] = 'Просмотр информации о %s %s';
$strings['Send email to'] = 'Послать e-mail для %s %s';
$strings['Reset password for'] = 'Переустановить пароль для %s %s';
$strings['Edit permissions for'] = 'Править разрешения для %s %s';
$strings['Position'] = 'Местоположение';
$strings['Password (6 char min)'] = 'Пароль (%s символов минимально)';	// @since 1.1.0
$strings['Re-Enter Password'] = 'Пароль ещё раз';

$strings['Sort by descending last name'] = 'Сортировать по убыванию фамилии';
$strings['Sort by descending email address'] = 'Сортировать по убыванию адресов e-mail';
$strings['Sort by descending institution'] = 'Сортировать по убыванию институтов';
$strings['Sort by ascending last name'] = 'Сортировать по возрастанию фамилий';
$strings['Sort by ascending email address'] = 'Сортировать по возрастанию адресов e-mail';
$strings['Sort by ascending institution'] = 'Сортировать по возрастанию институтов';
$strings['Sort by descending resource name'] = 'Сортировать по убыванию названий ресурсов';
$strings['Sort by descending location'] = 'Сортировать по убыванию местоположений';
$strings['Sort by descending schedule title'] = 'Сортировать по убыванию заголовков расписаний';
$strings['Sort by ascending resource name'] = 'Сортировать по возрастанию названий ресурсов';
$strings['Sort by ascending location'] = 'Сортировать по возрастанию местоположений';
$strings['Sort by ascending schedule title'] = 'Сортироват по возрастанию заголовков расписаний';
$strings['Sort by descending date'] = 'Сортировать по убыванию дат';
$strings['Sort by descending user name'] = 'Сортировать по убыванию имен пользователей';
$strings['Sort by descending start time'] = 'Сортировать по убыванию времени начала';
$strings['Sort by descending end time'] = 'Сортировать по убыванию времени окончания';
$strings['Sort by ascending date'] = 'Сортировать по возрастанию дат';
$strings['Sort by ascending user name'] = 'Сортировать по возрастанию имен пользователей';
$strings['Sort by ascending start time'] = 'Сортировать по возрастанию времени начала';
$strings['Sort by ascending end time'] = 'Сортировать по возрастанию времени окончания';
$strings['Sort by descending created time'] = 'Сортировать по убыванию времени создания';
$strings['Sort by ascending created time'] = 'Сортироват по возрастанию времени создания';
$strings['Sort by descending last modified time'] = 'Сортироват по убыванию времени последнего изменения';
$strings['Sort by ascending last modified time'] = 'Сортироват по возрастанию времени последнего изменения';

$strings['Search Users'] = 'Поиск пользователей';
$strings['Location'] = 'Местоположение';
$strings['Schedule'] = 'Расписание';
$strings['Phone'] = 'Телефон';
$strings['Notes'] = 'Заметки';
$strings['Status'] = 'Статус';
$strings['All Schedules'] = 'Все расписания';
$strings['All Resources'] = 'Все ресурсы';
$strings['All Users'] = 'Все пользователи';

$strings['Edit data for'] = 'Правка данных для %s';
$strings['Active'] = 'Активирование';
$strings['Inactive'] = 'Де-активирование';
$strings['Toggle this resource active/inactive'] = 'Переключить этот ресурс активирован/де-активирован';
$strings['Minimum Reservation Time'] = 'Минимальное время заказа';
$strings['Maximum Reservation Time'] = 'Максимальное время заказа';
$strings['Auto-assign permission'] = 'Разрешать автоназначение';
$strings['Add Resource'] = 'Добавить ресурс';
$strings['Edit Resource'] = 'Править ресурс';
$strings['Allowed'] = 'Разрешено';
$strings['Notify user'] = 'Уведомить пользователя';
$strings['User Reservations'] = 'Заказы пользователя';
$strings['Date'] = 'Дата';
$strings['User'] = 'Пользователь';
$strings['Email Users'] = 'E-mail пользователей';
$strings['Subject'] = 'Тема';
$strings['Message'] = 'Сообщение';
$strings['Please select users'] = 'Пожалуйста, выберите пользователей';
$strings['Send Email'] = 'Послать E-mail';
$strings['problem sending email'] = 'Простите, возникла проблема с посылкой Вашего e-mail. Пожалуйста, попробуйте еще раз позже.';
$strings['The email sent successfully.'] = 'Письмо e-mail послано успешно.';
$strings['do not refresh page'] = 'Пожалуйста <u>не</u> обновляйте эту страницу. Это приводит к повторной отправке письма.';
$strings['Return to email management'] = 'Возврат к управлению e-mail';
$strings['Please select which tables and fields to export'] = 'Пожалуйста, выберите какие таблицы и поля будут экспортироваться:';
$strings['all fields'] = '- все поля -';
$strings['HTML'] = 'HTML';
$strings['Plain text'] = 'Обычный текст';
$strings['XML'] = 'XML';
$strings['CSV'] = 'CSV';
$strings['Export Data'] = 'Данные экспорта';
$strings['Reset Password for'] = 'Переустановить пароль для %s';
$strings['Please edit your profile'] = 'Пожалуйста, модифицируйте Ваш профиль';
$strings['Please register'] = 'Пожалуйста, зарегистрируйтесь';
$strings['Keep me logged in'] = 'Сохранить мою авторизацию <br/>(требует куки)';
$strings['Edit Profile'] = 'Правка профиля';
$strings['Register'] = 'Регистрация';
$strings['Please Log In'] = 'Пожалуйста, авторизуйтесь';
$strings['Email address'] = 'Адрес e-mail';
$strings['Password'] = 'Пароль';
$strings['First time user'] = 'Начинающий пользователь?';
$strings['Click here to register'] = 'Нажать здесь для регистрации';
$strings['Register for phpScheduleIt'] = 'Регистрация для системы phpScheduleIt';
$strings['Log In'] = 'Авторизация';
$strings['View Schedule'] = 'Смотреть расписание';
$strings['View a read-only version of the schedule'] = 'Смотреть версию данного расписания только-для-чтения';
$strings['I Forgot My Password'] = 'Я забыл мой пароль';
$strings['Retreive lost password'] = 'Восстановление утерянного пароля';
$strings['Get online help'] = 'Получить помощь он-лайн';
$strings['Language'] = 'Язык';
$strings['(Default)'] = '(По-умолчанию)';

$strings['My Announcements'] = 'Мои уведомления';
$strings['My Reservations'] = 'Мои заказы';
$strings['My Permissions'] = 'Мои разрешения';
$strings['My Quick Links'] = 'Мои быстрые ссылки';
$strings['Announcements as of'] = 'Уведомления на %s';
$strings['There are no announcements.'] = 'Нет уведомлений.';
$strings['Resource'] = 'Ресурс';
$strings['Created'] = 'Созадно';
$strings['Last Modified'] = 'Последнее исправление';
$strings['View this reservation'] = 'Смотреть этот заказ';
$strings['Modify this reservation'] = 'Править этот заказ';
$strings['Delete this reservation'] = 'Удалить этот заказ';
$strings['Bookings'] = 'Bookings';											// @since 1.2.0
$strings['Change My Profile Information/Password'] = 'Change Profile';		// @since 1.2.0
$strings['Manage My Email Preferences'] = 'Email Preferences';				// @since 1.2.0
$strings['Mass Email Users'] = 'Масса пользователей E-mail';
$strings['Search Scheduled Resource Usage'] = 'Search Reservations';		// @since 1.2.0
$strings['Export Database Content'] = 'Экспорт контента БД';
$strings['View System Stats'] = 'Смотреть статистику системы';
$strings['Email Administrator'] = 'E-mail администратора';

$strings['Email me when'] = 'E-mail мне, когда:';
$strings['I place a reservation'] = 'Я размещу заказ';
$strings['My reservation is modified'] = 'Мой заказ модифицирован';
$strings['My reservation is deleted'] = 'Мой заказ удален';
$strings['I prefer'] = 'Я предпочитаю:';
$strings['Your email preferences were successfully saved'] = 'Ваши параметры e-mail успешно сохранениы!';
$strings['Return to My Control Panel'] = 'Вернуться в моей панели управления';

$strings['Please select the starting and ending times'] = 'Пожалуйста, выберите время начала и окончания:';
$strings['Please change the starting and ending times'] = 'Пожалуйста, зимените время начала и окончания:';
$strings['Reserved time'] = 'Зарезервированное время:';
$strings['Minimum Reservation Length'] = 'Минимальное время заказа:';
$strings['Maximum Reservation Length'] = 'Максимальное время заказа:';
$strings['Reserved for'] = 'Зарезервировано для:';
$strings['Will be reserved for'] = 'Будет зарезервировано для:';
$strings['N/A'] = 'Н/О';
$strings['Update all recurring records in group'] = 'Обновить все повторяющиеся записи в группе?';
$strings['Delete?'] = 'Удалить?';
$strings['Never'] = '-- Никогда --';
$strings['Days'] = 'Дни';
$strings['Weeks'] = 'Недели';
$strings['Months (date)'] = 'Месяцы (дата)';
$strings['Months (day)'] = 'Месяцы (день)';
$strings['First Days'] = 'Первые дни';
$strings['Second Days'] = 'Вторые дни';
$strings['Third Days'] = 'Третьи дни';
$strings['Fourth Days'] = 'Четвертые дни';
$strings['Last Days'] = 'Последние дни';
$strings['Repeat every'] = 'Повторять каждые:';
$strings['Repeat on'] = 'Повторять в:';
$strings['Repeat until date'] = 'Повторять до даты:';
$strings['Choose Date'] = 'Изменить дату';
$strings['Summary'] = 'Свод';

$strings['View schedule'] = 'Смотреть расписание:';
$strings['My Reservations'] = 'Мои заказы';
$strings['My Past Reservations'] = 'Мои последние заказы';
$strings['Other Reservations'] = 'Другие заказы';
$strings['Other Past Reservations'] = 'Доугие последние заказы';
$strings['Blacked Out Time'] = 'Времена отключения';
$strings['Set blackout times'] = 'Установить времена отключения для %s в %s'; 
$strings['Reserve on'] = 'Зарезервировать %s в %s';
$strings['Prev Week'] = '&laquo; Пред. неделя';
$strings['Jump 1 week back'] = 'Вернуться на 1 неделю назад';
$strings['Prev days'] = '&#8249; Пред. %d дней';
$strings['Previous days'] = '&#8249; Пред. %d дней';
$strings['This Week'] = 'Эта неделя';
$strings['Jump to this week'] = 'Перепрыгнуть на эту неделю';
$strings['Next days'] = 'След. %d дней &#8250;';
$strings['Next Week'] = 'След. неделя &raquo;';
$strings['Jump To Date'] = 'Прыгнуть на дату';
$strings['View Monthly Calendar'] = 'Смотреть ежемесячный календарь';
$strings['Open up a navigational calendar'] = 'Открыть навигационный календарь';

$strings['View stats for schedule'] = 'Смотреть статистику для расписания:';
$strings['At A Glance'] = 'С первого взгляда';
$strings['Total Users'] = 'Всего пользователей:';
$strings['Total Resources'] = 'Всего ресурсов:';
$strings['Total Reservations'] = 'Всего заказов:';
$strings['Max Reservation'] = 'Максимальный заказ:';
$strings['Min Reservation'] = 'Минимальный заказ:';
$strings['Avg Reservation'] = 'Средний заказ:';
$strings['Most Active Resource'] = 'Самый активный ресурс:';
$strings['Most Active User'] = 'Самый активный пользователь:';
$strings['System Stats'] = 'Системная статистика';
$strings['phpScheduleIt version'] = 'Версия системы phpScheduleIt:';
$strings['Database backend'] = 'Внутренняя база данных:';
$strings['Database name'] = 'Имя БД:';
$strings['PHP version'] = 'Версия PHP:';
$strings['Server OS'] = 'ОС сервера:';
$strings['Server name'] = 'Имя сервера:';
$strings['phpScheduleIt root directory'] = 'Корневая директория системы phpScheduleIt:';
$strings['Using permissions'] = 'Разрешения пользователей:';
$strings['Using logging'] = 'Пользовательские авторизации:';
$strings['Log file'] = 'Log-файл:';
$strings['Admin email address'] = 'Адрес e-mail администратора:';
$strings['Tech email address'] = 'Технический e-mail:';
$strings['CC email addresses'] = 'CC e-mail:';
$strings['Reservation start time'] = 'Время начала заказов:';
$strings['Reservation end time'] = 'Время окончания заказов:';
$strings['Days shown at a time'] = 'Дней, показываемых во времени:';
$strings['Reservations'] = 'Заказы';
$strings['Return to top'] = 'Вернуться наверх';
$strings['for'] = 'для';

$strings['Select Search Criteria'] = 'Выбор критерия поиска';
$strings['Schedules'] = 'Расписания:';
$strings['All Schedules'] = 'Все расписания';
$strings['Hold CTRL to select multiple'] = 'Держать CTRL для мультивыбора';
$strings['Users'] = 'Пользователи:';
$strings['All Users'] = 'Все пользователи';
$strings['Resources'] = 'Ресурсы';
$strings['All Resources'] = 'Все ресурсы';
$strings['Starting Date'] = 'Дата начала:';
$strings['Ending Date'] = 'Дата окончания:';
$strings['Starting Time'] = 'Время начала:';
$strings['Ending Time'] = 'Время окончания:';
$strings['Output Type'] = 'Тип выхода:';
$strings['Manage'] = 'Управление';
$strings['Total Time'] = 'Время всего';
$strings['Total hours'] = 'Часы всего:';
$strings['% of total resource time'] = '% от общего времени ресурса';
$strings['View these results as'] = 'Смотреть эти результаты как:';
$strings['Edit this reservation'] = 'Правка данного заказа';
$strings['Search Results'] = 'Поиск результатов';
$strings['Search Resource Usage'] = 'Поиск использования ресурсов';
$strings['Search Results found'] = 'Результаты поиска: %d заказов найден';
$strings['Try a different search'] = 'Попробуйте поискать ещё';
$strings['Search Run On'] = 'Поиск запущен для:';
$strings['Member ID'] = 'Код члена';
$strings['Previous User'] = '&laquo; Пред. пользователь';
$strings['Next User'] = 'След. пользователь &raquo;';

$strings['No results'] = 'Нет результатов';
$strings['That record could not be found.'] = 'Такая запись не найдена.';
$strings['This blackout is not recurring.'] = 'Такое отключение не повторяется.';
$strings['This reservation is not recurring.'] = 'Такой заказ не повторяется.';
$strings['There are no records in the table.'] = 'Нет записей в %s таблице.';
$strings['You do not have any reservations scheduled.'] = 'У Вас не расписано никаких заказов.';
$strings['You do not have permission to use any resources.'] = 'У Вас нет прав на использовани ресурсов.';
$strings['No resources in the database.'] = 'Нет ресурсов в БД.';
$strings['There was an error executing your query'] = 'Ошибка при запуске Вашего запроса:';

$strings['That cookie seems to be invalid'] = 'Эти куки выглядят неправильными';
$strings['We could not find that logon in our database.'] = 'Мы не нашли такого логина в БД.';	// @since 1.1.0
$strings['That password did not match the one in our database.'] = 'Этот пароль не соответствует ни одному пользователю в нашей БД.';
$strings['You can try'] = '<br />Вы можете попробовать:<br />Зарегистрировать адрес e-mail.<br />или:<br />Попробовать авторизоваться ещё раз.';
$strings['A new user has been added'] = 'Новый пользователь добавлен';
$strings['You have successfully registered'] = 'Вы успешно зарегистрировались!';
$strings['Continue'] = 'Продолжение...';
$strings['Your profile has been successfully updated!'] = 'Ваш профиль успешно обновлен!';
$strings['Please return to My Control Panel'] = 'Пожалуйста вернитесь к Вашей панели управления';
$strings['Valid email address is required.'] = '- Правльный адрес e-mail обязателен.';
$strings['First name is required.'] = '- Имя обязательно.';
$strings['Last name is required.'] = '- Фамилия обязательна.';
$strings['Phone number is required.'] = '- Номер телефона обязателен.';
$strings['That email is taken already.'] = '- Такой e-mail уже используется.<br />Пожалуйста, попробуйте еще раз с другим адресом e-mail.';
$strings['Min 6 character password is required.'] = '- Минимум %s символов в пароле обязательно.';
$strings['Passwords do not match.'] = '- Пароли не соответствуют.';

$strings['Per page'] = 'На страницу:';
$strings['Page'] = 'Страница:';

$strings['Your reservation was successfully created'] = 'Ваш заказ успешно создан';
$strings['Your reservation was successfully modified'] = 'Ваш заказ успешно модифицирован';
$strings['Your reservation was successfully deleted'] = 'Ваш заказ успешно удален';
$strings['Your blackout was successfully created'] = 'Ваше отключение успешно создано';
$strings['Your blackout was successfully modified'] = 'Ваше отключение успешно модифицировано';
$strings['Your blackout was successfully deleted'] = 'Ваше отключение успешно удалено';
$strings['for the follwing dates'] = 'для следующих дат:';
$strings['Start time must be less than end time'] = 'Время начала должно быть меньше времени окончания.';
$strings['Current start time is'] = 'Текущее время начала:';
$strings['Current end time is'] = 'Текущее время окончания:';
$strings['Reservation length does not fall within this resource\'s allowed length.'] = 'Длина заказа не попадает в пределы допстимой длины для этого ресурса.';
$strings['Your reservation is'] = 'Ваш заказ:';
$strings['Minimum reservation length'] = 'Минимальная длина заказа:';
$strings['Maximum reservation length'] = 'Максимальная длина заказа:';
$strings['You do not have permission to use this resource.'] = 'У Вас нет прав на использование этого ресурса.';
$strings['reserved or unavailable'] = '%s от %s зарезервировано или недоступно.';	// @since 1.1.0
$strings['Reservation created for'] = 'Заказ создан для %s';
$strings['Reservation modified for'] = 'Заказ модифицирован для %s';
$strings['Reservation deleted for'] = 'Заказ удален для %s';
$strings['created'] = 'создано';
$strings['modified'] = 'модифицировано';
$strings['deleted'] = 'Удалено';
$strings['Reservation #'] = 'Заказ №';
$strings['Contact'] = 'Контакт';
$strings['Reservation created'] = 'Заказ создан';
$strings['Reservation modified'] = 'Заказ модифицирован';
$strings['Reservation deleted'] = 'Заказ удален';

$strings['Reservations by month'] = 'Заказы помесячно';
$strings['Reservations by day of the week'] = 'Заказы по дням недели';
$strings['Reservations per month'] = 'Заказы за месяц';
$strings['Reservations per user'] = 'Заказы на пользователя';
$strings['Reservations per resource'] = 'Заказы по ресурсам';
$strings['Reservations per start time'] = 'Заказы по времени начала';
$strings['Reservations per end time'] = 'Заказы по времени окончания';
$strings['[All Reservations]'] = '[Все заказы]';

$strings['Permissions Updated'] = 'Разрешения обновлены';
$strings['Your permissions have been updated'] = 'Ваши %s права обновлены';
$strings['You now do not have permission to use any resources.'] = 'У Вас нет сейчас прав использовать какие-либо ресурсы.';
$strings['You now have permission to use the following resources'] = 'У Вас есть сейчас права использовать следующие ресурсы:';
$strings['Please contact with any questions.'] = 'Пожалуйста, свяжитесь %s при возникновении любых вопросов.';
$strings['Password Reset'] = 'Переустановка пароля';

$strings['This will change your password to a new, randomly generated one.'] = 'Это изменит Ваш пароль на новый, случайно сгенерированный.';
$strings['your new password will be set'] = 'После ввода Вашего адреса e-mail и нажатия "Изменить пароль", Ваш новый пароль будет установлен в системе и будет послан e-maile для Вас.';
$strings['Change Password'] = 'Изменить пароль';
$strings['Sorry, we could not find that user in the database.'] = 'Простите, мы не нашли такого пользователя в нашей БД.';
$strings['Your New Password'] = 'Ваш новый %s пароль';
$strings['Your new passsword has been emailed to you.'] = 'Успех!<br />'
    			. 'Ваш новый пароль отправлен Вам по e-mail.<br />'
    			. 'Пожалуйста, откройте письмо с новым паролем, затем <a href="index.php">Авторизуйтесь</a>'
    			. ' с новым паролем и быстро измените его нажав на ссылку &quot;Изменить мою профильную информацию/Пароль&quot;'
    			. ' в Вашей панели управления.';

$strings['You are not logged in!'] = 'Вы не авторизовались!';

$strings['Setup'] = 'Установка';
$strings['Please log into your database'] = 'Пожалуйста, подсоединитесь к Вашей БД';
$strings['Enter database root username'] = 'Введите имя корневого пользователя БД:';
$strings['Enter database root password'] = 'Введите корневой пароль БД:';
$strings['Login to database'] = 'Соединение с БД';
$strings['Root user is not required. Any database user who has permission to create tables is acceptable.'] = 'Корневой пользователь <b>не</b> обязателен. Приемлен любой пользователь, который имеет право на создание таблиц.';
$strings['This will set up all the necessary databases and tables for phpScheduleIt.'] = 'Это установит все необходимые БД и таблицы для системы phpScheduleIt.';
$strings['It also populates any required tables.'] = 'Это также заполнит необходимые таблицы.';
$strings['Warning: THIS WILL ERASE ALL DATA IN PREVIOUS phpScheduleIt DATABASES!'] = 'Предупреждение: ЭТО СОТРЁТ ВСЕ ДАННЫЕ ПРЕДЫДУЩЕЙ ВЕРСИИ СИСТЕМЫ phpScheduleIt!';
$strings['Not a valid database type in the config.php file.'] = 'Нет правильного типа БД в файле config.php.';
$strings['Database user password is not set in the config.php file.'] = 'Пароль пользователя БД не установлен в файле config.php.';
$strings['Database name not set in the config.php file.'] = 'Имя БД не установлено в файле config.php.';
$strings['Successfully connected as'] = 'Успешное соединение';
$strings['Create tables'] = 'Создание таблиц &gt;';
$strings['There were errors during the install.'] = 'Произошли ошибки при инсталляции. Возмолжно система phpScheduleIt всё же будет работать, если ошибки некритичны.<br/><br/>'
	. 'Пожалуйста, отправьте Ваши вопросы на форумы <a href="http://sourceforge.net/forum/?group_id=95547">SourceForge</a>.';
$strings['You have successfully finished setting up phpScheduleIt and are ready to begin using it.'] = 'You have successfully finished setting up phpScheduleIt and are ready to begin using it.';
$strings['Thank you for using phpScheduleIt'] = 'Пожалуйста убедитесь, что Вы ПОЛНОСТЬЮ УДАЛИЛИ \'install\' ДИРЕКТОРИЮ.'
	. ' Это критично, так как она содержит пароли БД и другую чувствительную информацию.'
	. ' Отказ от данного действия оставляет широко открытую дверь любому для поломки Вашей БД!'
	. '<br /><br />'
	. 'Спасибо за использование системы phpScheduleIt!';
$strings['There is no way to undo this action'] = 'Нет способа отменить это действие!';
$strings['Click to proceed'] = 'Нажать для продолжения';
$strings['Please delete this file.'] = 'Пожалуйста, удалите этот файл.';
$strings['Successful update'] = 'Обновление полностью успешно';
$strings['Patch completed successfully'] = 'Патч завершен успешно';

// @since 1.0.0 RC1
$strings['If no value is specified, the default password set in the config file will be used.'] = 'Если не будет введено значение, то будет использоваться пароль по умолчанию из конфигурационного файла.';
$strings['Notify user that password has been changed?'] = 'Уведомить пользователя, что пароль был изменен?';

// @since 1.1.0
$strings['This system requires that you have an email address.'] = 'Эта система требует, чтобы Вы имели адрес e-mail.';
$strings['Invalid User Name/Password.'] = 'Неправильное имя пользователя/пароль.';
$strings['Pending User Reservations'] = 'Ожидающие заказы пользователя';
$strings['Approve'] = 'Одобрить';
$strings['Approve this reservation'] = 'Одобрить этот заказ';
$strings['Approve Reservations'] ='Одобрить заказы';

$strings['Announcement'] = 'Извещение';
$strings['Number'] = 'Номер';
$strings['Add Announcement'] = 'Добавление извещения';
$strings['Edit Announcement'] = 'Правка извещения';
$strings['All Announcements'] = 'Всен извещения';
$strings['Delete Announcements'] = 'Удаление извещений';
$strings['Use start date/time?'] = 'Использовать дату/время начала?';
$strings['Use end date/time?'] = 'Использовать дату/время окончания?';
$strings['Announcement text is required.'] = 'Текст извещения обязателен.';
$strings['Announcement number is required.'] = 'Номер извещения обязателен.';

$strings['Pending Approval'] = 'Ожидание одобрения';
$strings['My reservation is approved'] = 'Мой заказ одобрен';
$strings['This reservation must be approved by the administrator.'] = 'Этот заказ должен быть одобрен администратором.';
$strings['Approval Required'] = 'Одобрение обязательно';
$strings['No reservations requiring approval'] = 'Нет заказов с обязательным одобрением';
$strings['Your reservation was successfully approved'] = 'Ваш заказ успешно одобрен';
$strings['Reservation approved for'] = 'Заказ одобрен для %s';
$strings['approved'] = 'одобрено';
$strings['Reservation approved'] = 'Заказ одобрен';

$strings['Valid username is required'] = 'Правильное имя пользователя обязательно';
$strings['That logon name is taken already.'] = 'Этот логин уже используется.';
$strings['this will be your login'] = '(это будет Ваш логин)';
$strings['Logon name'] = 'Ввод имени';
$strings['Your logon name is'] = 'Ваше введенное имя %s';

$strings['Start'] = 'Начало';
$strings['End'] = 'Конец';
$strings['Start date must be less than or equal to end date'] = 'Дата начала должна быть не больше даты конца';
$strings['That starting date has already passed'] = 'Такое время начала уже прошло';
$strings['Basic'] = 'Основной';
$strings['Participants'] = 'Участники';
$strings['Close'] = 'Закрыть';
$strings['Start Date'] = 'Дата начала';
$strings['End Date'] = 'Дата окончания';
$strings['Minimum'] = 'Минимум';
$strings['Maximum'] = 'Максимум';
$strings['Allow Multiple Day Reservations'] = 'Разрешить мультидневные заказы';
$strings['Invited Users'] = 'Приглашенные пользователи';
$strings['Invite Users'] = 'Приглашать пользователей';
$strings['Remove Participants'] = 'Убрать участников';
$strings['Reservation Invitation'] = 'Приглашение заказа';
$strings['Manage Invites'] = 'Управление приглашениями';
$strings['No invite was selected'] = 'Приглашение не выбрано';
$strings['reservation accepted'] = '%s принял Ваше приглашение на %s';
$strings['reservation declined'] = '%s отклонил Ваше приглашение на %s';
$strings['Login to manage all of your invitiations'] = 'Авторизуйтесь для управления всеми Вашими приглашениями';
$strings['Reservation Participation Change'] = 'Изменение участников заказа';
$strings['My Invitations'] = 'Мои приглашения';
$strings['Accept'] = 'Подтвердить';
$strings['Decline'] = 'Отклонить';
$strings['Accept or decline this reservation'] = 'Подтвердить или отклонить этот заказ';
$strings['My Reservation Participation'] = 'Мои участние в заказе';
$strings['End Participation'] = 'Окончание участия';
$strings['Owner'] = 'Владелец';
$strings['Particpating Users'] = 'Участвиющие пользователи';
$strings['No advanced options available'] = 'Дополнительные опции недоступны';
$strings['Confirm reservation participation'] = 'Подтвердить участие заказа';
$strings['Confirm'] = 'Подтвердить';
$strings['Do for all reservations in the group?'] = 'Сделать для всех заказов в этой группе?';

$strings['My Calendar'] = 'Мой календарь';
$strings['View My Calendar'] = 'Смотреть мой календарь';
$strings['Participant'] = 'Участник';
$strings['Recurring'] = 'Повторяющийся';
$strings['Multiple Day'] = 'Многодневный';
$strings['[today]'] = '[сегодня]';
$strings['Day View'] = 'Просмотр дня';
$strings['Week View'] = 'Просмотр недели';
$strings['Month View'] = 'Просмотр месяца';
$strings['Resource Calendar'] = 'Ресурсный календарь';
$strings['View Resource Calendar'] = 'Schedule Calendar';	// @since 1.2.0
$strings['Signup View'] = 'Поставить просмотр';

$strings['Select User'] = 'Выбор пользователя';
$strings['Change'] = 'Изменение';

$strings['Update'] = 'Обновление';
$strings['phpScheduleIt Update is only available for versions 1.0.0 or later'] = 'Обновление системы phpScheduleIt возможно только для версии 1.0.0 или более поздней';
$strings['phpScheduleIt is already up to date'] = 'phpScheduleIt is already up to date';
$strings['Migrating reservations'] = 'Миграция заказов';

$strings['Admin'] = 'Администрирование';
$strings['Manage Announcements'] = 'Управление извещениями';
$strings['There are no announcements'] = 'Нет извещений';
// end since 1.1.0

// @since 1.2.0
$strings['Maximum Participant Capacity'] = 'Maximum Participant Capacity';
$strings['Leave blank for unlimited'] = 'Leave blank for unlimited';
$strings['Maximum of participants'] = 'This resource has a maximum capacity of %s participants';
$strings['That reservation is at full capacity.'] = 'That reservation is at full capacity.';
$strings['Allow registered users to join?'] = 'Allow registered users to join?';
$strings['Allow non-registered users to join?'] = 'Allow non-registered users to join?';
$strings['Join'] = 'Join';
$strings['My Participation Options'] = 'My Participation Options';
$strings['Join Reservation'] = 'Join Reservation';
$strings['Join All Recurring'] = 'Join All Recurring';
$strings['You are not participating on the following reservation dates because they are at full capacity.'] = 'You are not participating on the following reservation dates because they are at full capacity.';
$strings['You are already invited to this reservation. Please follow participation instructions previously sent to your email.'] = 'You are already invited to this reservation. Please follow participation instructions previously sent to your email.';
$strings['Additional Tools'] = 'Additional Tools';
$strings['Create User'] = 'Create User';
$strings['Check Availability'] = 'Check Availability';
$strings['Manage Additional Resources'] = 'Manage Additional Resources';
$strings['All Additional Resources'] = 'All Additional Resources';
$strings['Number Available'] = 'Number Available';
$strings['Unlimited'] = 'Unlimited';
$strings['Add Additional Resource'] = 'Add Additional Resource';
$strings['Edit Additional Resource'] = 'Edit Additional Resource';
$strings['Checking'] = 'Checking';
$strings['You did not select anything to delete.'] = 'You did not select anything to delete.';
$strings['Added Resources'] = 'Added Resources';
$strings['Additional resource is reserved'] = 'The additional resource %s only has %s available at a time';
$strings['All Groups'] = 'All Groups';
$strings['Group Name'] = 'Group Name';
$strings['Delete Groups'] = 'Delete Groups';
$strings['Manage Groups'] = 'Manage Groups';
$strings['None'] = 'None';
$strings['Group name is required.'] = 'Group name is required.';
$strings['Groups'] = 'Groups';
$strings['Current Groups'] = 'Current Groups';
$strings['Group Administration'] = 'Group Administration';
$strings['Reminder Subject'] = 'Reservation reminder- %s, %s %s';
$strings['Reminder'] = 'Reminder';
$strings['before reservation'] = 'before reservation';
$strings['My Participation'] = 'My Participation';
$strings['My Past Participation'] = 'My Past Participation';
$strings['Timezone'] = 'Timezone';
$strings['Export'] = 'Export';
$strings['Select reservations to export'] = 'Select reservations to export';
$strings['Export Format'] = 'Export Format';
$strings['This resource cannot be reserved less than x hours in advance'] = 'This resource cannot be reserved less than %s hours in advance';
$strings['This resource cannot be reserved more than x hours in advance'] = 'This resource cannot be reserved more than %s hours in advance';
$strings['Minimum Booking Notice'] = 'Minimum Booking Notice';
$strings['Maximum Booking Notice'] = 'Maximum Booking Notice';
$strings['hours prior to the start time'] = 'hours prior to the start time';
$strings['hours from the current time'] = 'hours from the current time';
$strings['Contains'] = 'Contains';
$strings['Begins with'] = 'Begins with';
$strings['Minimum booking notice is required.'] = 'Minimum booking notice is required.';
$strings['Maximum booking notice is required.'] = 'Maximum booking notice is required.';
$strings['Accessory Name'] = 'Accessory Name';
$strings['Accessories'] = 'Accessories';
$strings['All Accessories'] = 'All Accessories';
$strings['Added Accessories'] = 'Added Accessories';
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
				. "Вы успешно зарегистрировались со следующей информацией:\r\n"
				. "Вход: %s\r\n"
				. "Имя: %s %s \r\n"
				. "Телефон: %s \r\n"
				. "Институт: %s \r\n"
				. "Местоположение: %s \r\n\r\n"
				. "Пожалуйста, авторизуйтесь для расписания в:\r\n"
				. "%s \r\n\r\n"
				. "Вы можете найти ссылки на расписания он-лайн и править Ваш профиль в Вашей панели управления.\r\n\r\n"
				. "Пожалуйста, направляйте любые вопросы по ресурсам или заказам на %s";

// Email message the admin gets after a new user registers
$email['register_admin'] = "Администратор,\r\n\r\n"
					. "Зарегистрироваля новый пользователь со следующей информацией:\r\n"
					. "E-mail: %s \r\n"
					. "Имя: %s %s \r\n"
					. "Телефон: %s \r\n"
					. "Институт: %s \r\n"
					. "Местоположение: %s \r\n\r\n";

// First part of the email that a user gets after they create/modify/delete a reservation
// 'reservation_activity_1' through 'reservation_activity_6' are all part of one email message
//  that needs to be assembled depending on different options.  Please translate all of them.
// @since 1.1.0
$email['reservation_activity_1'] = "%s,\r\n<br />"
			. "Вы имеете успешный %s заказ #%s.\r\n\r\n<br/><br/>"
			. "Пожалуйста, используйте этот номер заказа, при контакте с администратором по любым вопросам.\r\n\r\n<br/><br/>"
			. "Заказ между %s %s и %s %s для %s"
			. " расположенный на %s будет %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_2'] = "Этот заказ будет повторен в следующие даты:\r\n<br/>";
$email['reservation_activity_3'] = "Все повторяющиеся заказы в этой группе также %s.\r\n\r\n<br/><br/>";
$email['reservation_activity_4'] = "Следующее резюме обеспечено для этих заказов:\r\n<br/>%s\r\n\r\n<br/><br/>";
$email['reservation_activity_5'] = "Если это ошибка, пожалуйста свяжитесь с администратором: %s"
			. " или по телефону %s.\r\n\r\n<br/><br/>"
			. "Вы можете просмотреть или модифицировать Вашу информацию по заказу в любое время"
			. " авторизуясь в %s для:\r\n<br/>"
			. "<a href=\"%s\" target=\"_blank\">%s</a>.\r\n\r\n<br/><br/>";
$email['reservation_activity_6'] = "Пожалуйста, направляйте все технические вопросы к <a href=\"mailto:%s\">%s</a>.\r\n\r\n<br/><br/>";
// @since 1.1.0
$email['reservation_activity_7'] = "%s,\r\n<br />"
			. "Заказ #%s одобрен.\r\n\r\n<br/><br/>"
			. "Пожалуйста, используйте этот код заказа при контакте с администратором по любым вопросам.\r\n\r\n<br/><br/>"
			. "Заказ между %s %s и %s %s для %s"
			. " размещен на %s для %s.\r\n\r\n<br/><br/>";

// Email that the user gets when the administrator changes their password
$email['password_reset'] = "Ваш %s пароль пререустановлен администратором.\r\n\r\n"
			. "Ваш временный пароль:\r\n\r\n %s\r\n\r\n"
			. "Пожалуйста, используйте этот временный пароль (скопируйте и вставьте, чтобы быть уверенным в корректности) для входа в %s на %s"
			. " и сразу же измените его, используя ссылку 'Изменить мою профильную информацию/Пароль' на панели Мои быстрые ссылки.\r\n\r\n"
			. "Пожалуйста, свяжитесь с %s с любыми вопросами.";

// Email that the user gets when they change their lost password using the 'Password Reset' form
$email['new_password'] = "%s,\r\n"
            . "Ваш новый пароль для Вашего %s счета:\r\n\r\n"
            . "%s\r\n\r\n"
            . "Пожалуйста, авторизуйтесь в %s "
            . "с этим новым паролем "
            . "(скопируйте и вставьте, чтобы быть уверенным в корректности) "
            . "и быстро измените его нажав на ссылку "
            . "Изменить мою профильную информацию/Пароль "
            . "на Вашей панели управления.\r\n\r\n"
            . "Пожалуйста, направляйте любые вопросы к %s.";

// @since 1.1.0
// Email that is sent to invite users to a reservation
$email['reservation_invite'] = "%s приглашает Вас участвовать в следующем заказе:\r\n\r\n"
		. "Ресурс: %s\r\n"
		. "Дата начала: %s\r\n"
		. "Время начала: %s\r\n"
		. "Дата окончания: %s\r\n"
		. "Время окончания: %s\r\n"
		. "Резюме: %s\r\n"
		. "Даты повтора (если представлены): %s\r\n\r\n"
		. "Чтобы принять это приглашени нажмите на эту ссылку (скопируйте и вставьте, если она не выделена) %s\r\n"
		. "Чтобы отклонить это приглашение нажмите на эту ссылку (скопируйте и вставьте, если она не выделена) %s\r\n"
		. "Для принятия выбранных дат или управления Ващими приглашениями в последующем, пожалуйста, авторизуйтесь в %s как %s";

// @since 1.1.0
// Email that is sent when a user is removed from a reservation
$email['reservation_removal'] = "Вы убраны из следующего заказа:\r\n\r\n"
		. "Ресурс: %s\r\n"
		. "Дата начала: %s\r\n"
		. "Время начала: %s\r\n"
		. "Дата окончания: %s\r\n"
		. "Время окончания: %s\r\n"
		. "Резюме: %s\r\n"
		. "Даты повтора (если представлены): %s\r\n\r\n";	

// @since 1.2.0
// Email body that is sent for reminders
$email['Reminder Body'] = "Your reservation for %s from %s %s to %s %s is approaching.";
?>